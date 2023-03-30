<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;

class FeeGenerateController extends Controller
{
    public function sendWhatsappMessage($mobile, $message)
    {
        try {

            $smstext = rawurlencode($message);
            $ch = curl_init("https://app.botsender.in/api/send.php?number=$mobile&type=template&message=$smstext&instance_id=639531DEC7E6C&access_token=52d8bd012964c198169ccc67dcb754df");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
            $result = curl_exec($ch);
            if (curl_error($ch)) {
                $result = curl_errno($ch);
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);
    }

    public function sendWhatsappMessageRegister($mobile, $message){
        try {

            $smstext = rawurlencode($message);
            $ch = curl_init("https://app.botsender.in/api/send.php?number=$mobile&type=template&message=$smstext&instance_id=639531DEC7E6C&access_token=52d8bd012964c198169ccc67dcb754df");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
            $result = curl_exec($ch);
            if (curl_error($ch)) {
                $result = curl_errno($ch);
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);
    }

    public function getAllStudentFeeDetails(Request $request)
    {

        $perPage = $request->perPage ? $request->perPage : 100;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_student')

            ->leftjoin('lms_fees_generate', 'lms_fees_generate.lms_student_id', '=', 'lms_student.lms_student_id')

            ->join('lms_student_course_mapping', 'lms_student.lms_student_id', '=', 'lms_student_course_mapping.lms_student_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_student_course_mapping.lms_course_id')
            ->join('lms_child_course', 'lms_student_course_mapping.lms_child_course_id', '=', 'lms_child_course.lms_child_course_id')

            ->select(


                'lms_student_course_mapping.lms_registration_code',
                'lms_student.lms_student_code',
                'lms_student.lms_student_id',
                'lms_student.lms_center_id',
                'lms_student.lms_student_first_name',
                'lms_student.lms_student_last_name',
                'lms_student.lms_student_full_name',
                'lms_student.lms_student_mobile_number',
                'lms_student_course_mapping.lms_registration_id',
                'lms_student.lms_student_profile_image',
                'lms_course.lms_course_name',
                'lms_child_course.lms_child_course_name',
                'lms_child_course.lms_child_course_fees',
                'lms_child_course.lms_child_course_id',
                'lms_child_course.lms_child_course_code',
                'lms_child_course.lms_child_course_duration',
                'lms_course.lms_course_id',
                'lms_fees_generate.lms_discount_id',
                'lms_fees_generate.lms_total_fee_discount as amount',
                'lms_fees_generate.lms_actual_fee',
                'lms_fees_generate.lms_actual_fee_start_date',
                //  'lms_fees_generate.lms_actual_fee_end_date',
                //  'lms_fees_generate.lms_total_fee_discount',
                //discount


                DB::raw("
             (case when lms_student.lms_student_is_active  = '0' then 'Inactive'
              ELSE 'Active' end) as 'lms_student_is_active'"),
            )

            ->where('lms_student.lms_student_is_active', 1)
            ->where('lms_student_course_mapping.is_fee_generated', 0)
            ->where(function ($q) use ($filterBy) {
                $q->where('lms_student_course_mapping.lms_registration_code', 'like', "%$filterBy%")
                    ->orWhere('lms_student.lms_student_code', 'like', "%$filterBy%")
                    ->orWhere('lms_student.lms_student_mobile_number', 'like', "%$filterBy%");
            })
            ->orderBy('lms_student.lms_student_created_at', 'DESC')

            ->paginate($perPage);
        return $result;
    }

    public function saveFees(Request $request)
    {


        $studentId = $request->studentId;
        $registrationCode = $request->courseRegistrationCode;
        $discount_id = $request->discountId;
        $lms_child_course_id = $request->courseId;
        $lms_course_id = $request->streamId;
        $lms_child_course_fees = $request->courseFees;
        $lms_child_course_fee_duration = $request->feeDuration;
        $lms_total_fee_discount = $request->totalFeeDiscount;
        $lms_actual_fee = $request->actualFee;
        $lms_actual_fee_start_date = $request->startDate;
        $startdateactual = date('Y-m-d', strtotime($lms_actual_fee_start_date));
        $totalmonths = $lms_child_course_fee_duration;
        $monthlyFee=$request->monthlyFee;
        $totalmonths .= "months";
        $enddateactual = date('Y-m-d', strtotime($totalmonths, strtotime($startdateactual)));
        DB::beginTransaction();

        try {
            $checkregistration = DB::table('lms_fees_generate')->where('lms_fees_generate.lms_registration_code', $registrationCode)->count();
            if ($checkregistration > 0) {
                $result_data['responseData'] = 2;
                return $result_data;
            }

            $feesGenerate = DB::table('lms_fees_generate')->insertGetId(
                [

                    'lms_student_id' => $studentId,
                    'lms_registration_code' => $registrationCode,
                    'lms_discount_id' => $discount_id,
                    'lms_child_course_id' => $lms_child_course_id,
                    'lms_course_id' => $lms_course_id,
                    'lms_child_course_fees' => $lms_child_course_fees,
                    'lms_child_course_fee_duration' => $lms_child_course_fee_duration,
                    'lms_total_fee_discount' => $lms_total_fee_discount,
                    'lms_actual_fee' =>  $lms_actual_fee,
                    'lms_actual_fee_start_date' => $startdateactual,
                    'lms_actual_fee_end_date' => $enddateactual,

                ]
            );
         //   $finalAmount = round($lms_child_course_fees - $lms_total_fee_discount) / $lms_child_course_fee_duration;
            // $begin = new DateTime('2010-05-01');
            // $end = new DateTime('2010-12-01');

            // $interval = DateInterval::createFromDateString('1 month');
            // $period = new DatePeriod($begin, $interval, $end);

            // foreach ($period as $dt) {
            //     echo $dt->format("l Y-m-d H:i:s\n");
            // }
            $getCenterCodeQuery = DB::table('lms_center_details')
            ->select(['lms_center_code'])
            ->where('lms_center_id', 1)
            ->get();

            $getEnquiryCodePrefixQuery = DB::table('lms_prefix_setting')
                ->select(['lms_prefix'])
                ->where('lms_center_id', 1)
                ->where('lms_prefix_module_name', "Receipt Code")
                ->get();
            $enquiryCodePrefix = $getEnquiryCodePrefixQuery[0]->lms_prefix . $getCenterCodeQuery[0]->lms_center_code . date('y');
        
            $months = $lms_child_course_fee_duration;
            $months .= "months";
            $startdate = date('Y-m-d', strtotime($lms_actual_fee_start_date));
            $endDate = date('Y-m-d', strtotime($months, strtotime($lms_actual_fee_start_date)));
            $begin = new DateTime($startdate);
            $end = new DateTime($endDate);

            $interval = DateInterval::createFromDateString('1 month');
            $period = new DatePeriod($begin, $interval, $end);

            foreach ($period as $dt) {
                $receiptCode = IdGenerator::generate([
                    'table' => 'lms_monthly_fee_generate', 'length' => 20, 'prefix' => $enquiryCodePrefix,
                    'reset_on_prefix_change' => true, 'field' => 'lms_receipt_no',
                ]);
                
             
                $feesGenerateMain = DB::table('lms_monthly_fee_generate')->insertGetId(
                    [

                        'lms_student_id' => $studentId,
                        'lms_fees_id' => $feesGenerate,
                        'lms_student_reg_id' => $registrationCode,
                        'lms_final_monthly_amount' => round($monthlyFee),
                        'lms_fees_date' => $dt,
                        'due_date' => date('Y-m-05',strtotime($dt->format('Y-m-d'))),
                        'lms_fee_description' => 'Tuition Fee',
                        'lms_actual_fee' => round($lms_actual_fee),
                        'lms_receipt_no' =>$receiptCode

                    ]
                );
            }

            //update is_fee_generated
            DB::table('lms_student_course_mapping')
                ->where('lms_student_course_mapping.lms_registration_code', $registrationCode)
                ->update(['lms_student_course_mapping.is_fee_generated' => 1]);


            DB::commit();
            $result_data['responseData'] = 4;
            return $result_data;
        } catch (Exception $ex) {

            DB::rollback();

            $result_data['responseData'] = 5;
            return $result_data;
        }
    }
    public function discountFetch(Request $request)
    {
        $id = $request->discountId;
        $result = DB::table('lms_discount')->select('*')
            ->where('lms_discount.status', 1)
            ->where(function ($q) use ($id) {
                if ($id != null) {

                    $q->where('lms_discount.lms_discount_id', $id);
                }
            })
            ->get();
        return $result;
    }


    public function getAllStudentFeeDetailsGenerated(Request $request)
    {

        $perPage = $request->perPage ? $request->perPage : 100;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_student')

            ->join('lms_fees_generate', 'lms_fees_generate.lms_student_id', '=', 'lms_student.lms_student_id')
            ->join('lms_student_course_mapping', 'lms_student.lms_student_id', '=', 'lms_student_course_mapping.lms_student_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_student_course_mapping.lms_course_id')
            ->join('lms_child_course', 'lms_student_course_mapping.lms_child_course_id', '=', 'lms_child_course.lms_child_course_id')

            ->select(

                'lms_student.lms_user_id',
                'lms_student_course_mapping.lms_registration_code',
                'lms_student.lms_student_code',
                'lms_student.lms_student_id',
                'lms_student.lms_center_id',
                'lms_student.lms_student_first_name',
                'lms_student.lms_student_last_name',
                'lms_student.lms_student_full_name',
                'lms_student.lms_student_mobile_number',
                'lms_student.lms_student_whatsapp_number',
                'lms_student_course_mapping.lms_registration_id',
                'lms_student.lms_student_profile_image',
                'lms_course.lms_course_name',
                'lms_child_course.lms_child_course_name',
                'lms_child_course.lms_child_course_id',
                'lms_child_course.lms_child_course_code',
                'lms_child_course.lms_child_course_duration',
                'lms_course.lms_course_id',
                'lms_fees_generate.lms_discount_id',
                'lms_fees_generate.lms_total_fee_discount as amount',
                'lms_fees_generate.lms_actual_fee',
                'lms_fees_generate.lms_actual_fee_start_date',
                'lms_fees_generate.lms_actual_fee_end_date',
                'lms_fees_generate.lms_child_course_fees',



                DB::raw("
             (case when lms_student.lms_student_is_active  = '0' then 'Inactive'
              ELSE 'Active' end) as 'lms_student_is_active'"),
            )
            ->where(function ($q) use ($filterBy) {
                $q->where('lms_student_course_mapping.lms_registration_code', 'like', "%$filterBy%")
                    ->orWhere('lms_student.lms_student_code', 'like', "%$filterBy%")
                    ->orWhere('lms_student.lms_student_mobile_number', 'like', "%$filterBy%");
            })
            ->where('lms_student.lms_student_is_active', 1)
            ->where('lms_student_course_mapping.is_fee_generated', 1)
            ->orderBy('lms_student.lms_student_created_at', 'DESC')

            ->paginate($perPage);
        return $result;
    }

    public function getMonthlyFeeForStudent(Request $request)
    {
        $perPage = $request->perPage ? $request->perPage : 100;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $studentId = $request->studentId;

        $result = DB::table('lms_monthly_fee_generate')
            ->select(
                'lms_student.lms_user_id',
                'lms_student.lms_student_id',
                'lms_monthly_fee_generate.fee_id',
                'lms_monthly_fee_generate.lms_student_reg_id',
                'lms_monthly_fee_generate.lms_final_monthly_amount',
                'lms_discount.description',
                'lms_monthly_fee_generate.is_paid',
                'lms_monthly_fee_generate.lms_fee_description',
                'lms_fees_generate.lms_total_fee_discount',
                'lms_fees_generate.lms_actual_fee',
                DB::raw("date_format(lms_monthly_fee_generate.lms_fees_date,'%b-%y') as lms_fees_date")
            )
            ->join('lms_fees_generate', 'lms_fees_generate.lms_student_id', '=', 'lms_monthly_fee_generate.lms_student_id')
            ->join('lms_discount', 'lms_discount.lms_discount_id', '=', 'lms_fees_generate.lms_discount_id')
            ->join('lms_student', 'lms_student.lms_student_id', '=', 'lms_monthly_fee_generate.lms_student_id')
            ->where('lms_monthly_fee_generate.lms_student_id', $studentId)
            ->where(function ($q) use ($filterBy) {
                $q->where('lms_monthly_fee_generate.lms_student_reg_id', 'like', "%$filterBy%")
                    ->orWhere('lms_monthly_fee_generate.lms_final_monthly_amount', 'like', "%$filterBy%")
                    ->orWhere('lms_monthly_fee_generate.lms_fees_date', 'like', "%$filterBy%");
            })
            ->paginate($perPage);

        return $result;
    }

    public function voucherdetailssave(Request $request)
    {
        $voucherDescription = $request->voucherDescription;
        $voucherAmount = $request->voucherAmount;

        try {
            $checkregistration = DB::table('lms_voucher_details')->where('lms_voucher_details.voucher_description', $voucherDescription)->count();
            if ($checkregistration > 0) {
                $result_data['responseData'] = 2;
                return $result_data;
            }

            $voucherSave = DB::table('lms_voucher_details')->insertGetId(
                [
                    'voucher_description' => $voucherDescription,
                    'voucher_amount' => $voucherAmount
                ]

            );

            $result_data['responseData'] = 4;
            return $result_data;
        } catch (Exception $ex) {
            $result_data['responseData'] = 7;
            return $result_data;
        }
    }

    public function voucherGenerateStudent(Request $request)

    {

        DB::beginTransaction();
        try {
            $student_id = $request->studentId;
            $voucher_id = $request->voucherId;
            $voucher_amount = $request->voucherAmount;
            $no_of_vouchers = $request->totalVouchers;
            $userId = $request->userId;
            $registrationCode = $request->studentRegistrationCode;
            $validityDays = $request->validityDays;

            $valid_from = date('Y-m-d');
            // registration_id
            $getCenterCodeQuery = DB::table('lms_center_details')
                ->select(['lms_center_code'])
                ->where('lms_center_id', 1)
                ->get();

            $getEnquiryCodePrefixQuery = DB::table('lms_prefix_setting')
                ->select(['lms_prefix'])
                ->where('lms_center_id', 1)
                ->where('lms_prefix_module_name', "Voucher Code")
                ->get();
            $enquiryCodePrefix = $getEnquiryCodePrefixQuery[0]->lms_prefix . $getCenterCodeQuery[0]->lms_center_code . date('y');
            $startdateactual = date('Y-m-d',  strtotime($valid_from));
            $totalmonths = $validityDays;
            $totalmonths .= "days";
            $enddateactual = date('Y-m-d', strtotime($totalmonths, strtotime($startdateactual)));
            for ($i = 1; $i <= $no_of_vouchers; $i++) {

                $discountCode = IdGenerator::generate([
                    'table' => 'lms_issued_voucher', 'length' => 20, 'prefix' => $enquiryCodePrefix,
                    'reset_on_prefix_change' => true, 'field' => 'issue_voucher_number',
                ]);
                $voucherSave = DB::table('lms_issued_voucher')->insertGetId(
                    [
                        'issue_voucher_number' => $discountCode,
                        'student_id' => $student_id,
                        'registration_id' => $registrationCode,
                        'voucher_id' => $voucher_id,
                        'voucher_amount' => $voucher_amount,
                        'valid_from' => $startdateactual,
                        'valid_to' => $enddateactual,
                        'user_id' => $userId
                    ]

                );
            }
            DB::commit();
            $result_data['responseData'] = 4;
            return $result_data;
        } catch (Exception $ex) {
            DB::rollback();
            $result_data['responseData'] = 7;
            return $result_data;
        }
    }

    public function getVoucherStudent(Request $request){
   
        try{
            $studentId=$request->studentId;
            $voucherStatus=$request->voucherStatus;
            $result = DB::table('lms_issued_voucher')->select('lms_issued_voucher.issue_voucher_id',
            DB::raw("(SELECT concat(lms_issued_voucher.issue_voucher_number,', Amount:-',lms_issued_voucher.voucher_amount)) as issue_voucher_number"),   
            )
            ->join('lms_voucher_details','lms_voucher_details.voucher_id','lms_issued_voucher.voucher_id')
            ->where(function ($q) use ($studentId,$voucherStatus) {
                if($studentId != null){
                $q->where('student_id',$studentId);    
                
                }
                if($voucherStatus!=null)
                {
                 $q->where('lms_issued_voucher.voucher_issue_status',1);
                }
                  
            })
        
            ->where('voucher_status',1)   
            ->get();
            return response()->json(['data'=>$result]);
        }
        catch(Exception $ex){
            $result_data['responseData'] = 7;
            return $result_data;  
        }
    }

    public function changeVoucherStatus(Request $request)
    {
        try {
            $result = DB::table('lms_voucher_details')->select('lms_voucher_details.voucher_amount')
                ->where('voucher_id', $request->voucherId)
                ->get();
            return $result;
        } catch (Exception $ex) {
            $result_data['responseData'] = 7;
            return $result_data;
        }
    }

    public function getVoucherDetailsWithoutPagination(Request $request)
    {
        $voucherId = $request->voucherId;
        $result = DB::table('lms_voucher_details')->select('*')

            ->where('lms_voucher_details.voucher_status', 1)
            ->where(function ($q) use ($voucherId) {
                if ($voucherId != null) {
                    $q->where('voucher_id', $voucherId);
                }
            })
            ->get();
        return response()->json(['data' => $result]);
    }

    public function getVoucherStudentWise(Request $request)
    {
        $perPage = $request->perPage ? $request->perPage : 15;
        $studentId = $request->studentId;
        $filterBy = $request->filterBy;
        $result = DB::table('lms_issued_voucher')
            ->select(
                'lms_issued_voucher.issue_voucher_id',
                'lms_issued_voucher.issue_voucher_number',
                'lms_student.lms_student_full_name',
                'lms_issued_voucher.registration_id',
                'lms_issued_voucher.voucher_amount',
                'lms_voucher_details.voucher_description',
                DB::raw("date_format(lms_issued_voucher.valid_from,'%d-%m-%y') as valid_from"),
                DB::raw("date_format(lms_issued_voucher.valid_to,'%d-%m-%y') as valid_to"),


                DB::raw("
        (case when lms_issued_voucher.voucher_issue_status  = '3' then 'Expired'
        when       lms_issued_voucher.voucher_issue_status  = '1' then 'Issued'
        when       lms_issued_voucher.voucher_issue_status  = '2' then 'Redeemed'
        ELSE 'Default' end) as 'voucher_issue_status'"),
            )
            ->join('lms_student', 'lms_student.lms_student_id', 'lms_issued_voucher.student_id')
            ->join('lms_voucher_details', 'lms_voucher_details.voucher_id', 'lms_issued_voucher.voucher_id')
            ->where('lms_issued_voucher.student_id', $studentId)
            ->where(function ($q) use ($filterBy) {
                $q->where('lms_issued_voucher.issue_voucher_number', 'like', "%$filterBy%");
            })
            ->orderBy('lms_issued_voucher.issue_voucher_number', 'desc')
            ->paginate($perPage);

        return $result;
    }

    public function getVoucherWithStudent(Request $request)
    {
        $perPage = $request->perPage ? $request->perPage : 15;
        $studentId = $request->studentId;
        $voucherId = $request->voucherId;
        $filterBy = $request->filterBy;
        $result = DB::table('lms_issued_voucher')
            ->select(
                'lms_issued_voucher.issue_voucher_id',
                'lms_issued_voucher.issue_voucher_number',
                'lms_student.lms_student_full_name',
                'lms_issued_voucher.registration_id',
                'lms_issued_voucher.voucher_amount',
                'lms_voucher_details.voucher_description',

            )
            ->join('lms_student', 'lms_student.lms_student_id', 'lms_issued_voucher.student_id')
            ->join('lms_voucher_details', 'lms_voucher_details.voucher_id', 'lms_issued_voucher.voucher_id')
            ->where('lms_issued_voucher.student_id', $studentId)
            ->where('lms_issued_voucher.issue_voucher_id', $voucherId)
            ->where('lms_issued_voucher.voucher_issue_status', 1)
            ->where(function ($q) use ($filterBy) {
                $q->where('lms_issued_voucher.issue_voucher_number', 'like', "%$filterBy%");
            })
            ->orderBy('lms_issued_voucher.issue_voucher_number', 'desc')
            ->get();

        return $result;
    }

    public function feePaidForMonth(Request $request)
    {
        $studentId = $request->studentId;
        $lms_student_full_name = $request->lms_student_full_name;
        $courseregistratoncode = $request->courseRegistrationCode;
        $studentCode = $request->studentCode;
        $feesPaidforTheMonth = $request->feesPaidForTheMonth;
        $feespayable = $request->feesPayable;
        $paymentMode = $request->paymentMode;
        $referenceNo = $request->referenceNo;
        $voucherId = $request->voucherId;
        $voucherAmount = $request->voucherAmount;
        $feeId = $request->feeId;
        $receiptNo = $request->ManualReceiptNo;



        try {
            DB::beginTransaction();
            $generateFees = DB::table('lms_fees_paid')->insertGetId(
                [
                    'student_id' => $studentId,
                    'registration_id' => $courseregistratoncode,
                    'monthly_fee_id' => $feeId,
                    'fees_paid_for_the_month' => $feesPaidforTheMonth,
                    'fees_paid' => $feespayable,
                    'payment_mode' => $paymentMode,
                    'reference_no' => $referenceNo,

                ]

            );
            //monthly generated fee updated
            DB::table('lms_monthly_fee_generate')
                ->where('lms_monthly_fee_generate.fee_id', $feeId)
                ->update([
                    'lms_cash_receipt' => $feespayable,
                    'lms_voucher_adjusted' => $voucherAmount,
                    'lms_voucher_id' => $voucherId,
                    'is_paid' => 1,
                    'updated_at' => now(),
                    'paid_date' => date('Y-m-d'),
                    'lms_manual_receipt_no' => $receiptNo
                ]);

            //update voucher  status
            DB::table('lms_issued_voucher')->where('lms_issued_voucher.issue_voucher_id', $request->voucherId)
                ->update([
                    'voucher_issue_status' => 2
                ]);

            DB::commit();
            $result_data['responseData'] = 4;
            return $result_data;
        } catch (Exception $ex) {

            $result_data['responseData'] = 7;
            return $result_data;
            DB::rollback();
        }


        return $result;
    }


    //generate monthly fee report

    public function generateMonthlyFeeReport(Request $request)
    {

        $perPage = $request->perPage ? $request->perPage : 100;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $startdate = $request->startDate;
        $enddate = $request->endDate;
        $isPaid = $request->isPaid;
        $result = DB::table('lms_monthly_fee_generate')
            ->select(
                'lms_monthly_fee_generate.fee_id',
                'lms_monthly_fee_generate.lms_student_id',
                'lms_student.lms_student_mobile_number',
                'lms_monthly_fee_generate.lms_student_reg_id',
                'lms_monthly_fee_generate.lms_fee_description',
                'lms_monthly_fee_generate.lms_final_monthly_amount as total_amount',
                DB::raw(
                    "IF(lms_monthly_fee_generate.is_paid=0,lms_monthly_fee_generate.lms_final_monthly_amount,null) as 'due_amount'"
                ),
                'lms_monthly_fee_generate.lms_cash_receipt',
                'lms_monthly_fee_generate.lms_voucher_adjusted',
                'lms_fees_generate.lms_child_course_fee_duration',
                'lms_child_course.lms_child_course_name',
                'lms_monthly_fee_generate.is_paid',
                'lms_monthly_fee_generate.paid_date',
                'lms_monthly_fee_generate.lms_manual_receipt_no',
                'lms_monthly_fee_generate.lms_receipt_no',
                DB::raw("date_format(lms_monthly_fee_generate.lms_fees_date,'%b-%y') as month"),
                DB::raw("date_format(lms_monthly_fee_generate.due_date,'%d-%m-%y') as due_date"),
                DB::raw("date_format(lms_monthly_fee_generate.paid_date,'%d-%m-%y') as paid_date"),
                'lms_monthly_fee_generate.lms_fees_date',

                DB::raw("
             (case when lms_monthly_fee_generate.is_paid  = '1' then 'Paid'
          
             ELSE 'Not Paid' end) as 'status'"),
                DB::raw("UPPER(lms_student.lms_student_full_name) as lms_student_full_name")
            )

            ->join('lms_fees_generate', 'lms_fees_generate.lms_fees_id', '=', 'lms_monthly_fee_generate.lms_fees_id')
            //  ->join('lms_fees_paid', 'lms_fees_paid.monthly_fee_id', '=', 'lms_monthly_fee_generate.fee_id')    
            ->join('lms_child_course', 'lms_child_course.lms_child_course_id', '=', 'lms_fees_generate.lms_child_course_id')
            ->join('lms_student', 'lms_student.lms_student_id', '=', 'lms_monthly_fee_generate.lms_student_id')
            ->where(function ($q) use ($filterBy) {
                $q->where('lms_student.lms_student_full_name', 'like', "%$filterBy%")
                    ->orWhere('lms_monthly_fee_generate.lms_student_reg_id', 'like', "%$filterBy%")
                    ->orWhere('lms_child_course.lms_child_course_name', 'like', "%$filterBy%")
                    ->orWhere('lms_monthly_fee_generate.lms_fees_date', 'like', "%$filterBy%");
            })


            ->where(function ($q) use ($startdate, $enddate) {
                if ($startdate != null) {
                    $q
                        ->where('lms_monthly_fee_generate.lms_fees_date', '>=', $startdate);
                }
                if ($enddate != null) {
                    $q
                        ->where('lms_monthly_fee_generate.lms_fees_date', '<=', $enddate);
                }
            })
            ->where(function ($q) use ($isPaid) {
                if ($isPaid != null && $isPaid == 0) {
                    $q
                        ->where('lms_monthly_fee_generate.is_paid', 0);
                }
                if ($isPaid != null && $isPaid == 1) {
                    $q
                        ->where('lms_monthly_fee_generate.is_paid', 1);
                }
                if ($isPaid != null && $isPaid == 2) {
                    $q
                        ->where('lms_monthly_fee_generate.is_paid', 0)
                        ->orWhere('lms_monthly_fee_generate.is_paid', 1);
                }
            })

            ->where('lms_fees_generate.lms_current_fee_status', 1)
            ->where('lms_student.lms_student_is_active', 1)
            ->paginate($perPage);

        return $result;
    }


  
}
