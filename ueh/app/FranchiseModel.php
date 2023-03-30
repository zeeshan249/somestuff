<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class FranchiseModel extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected  $primaryKey = "franchise_id";
    protected  $table = "ueh_franchise";
    public  $timestamps = false;

    public static function  approveRejectAppliedFranchise(
        $clickedFranchiseId,
        $approveRejectStatus,
        $approveRejectBy,
        $clickedFranchiseMobileNumber,
        $clickedFranchiseDOB,
        $clickedFranchiseName,
        $approveRejectRemarks
    ) {

        if ($approveRejectStatus == "1") {
            $check_mobile_number_query = DB::table('ueh_user')->where('user_mobile_number',  $clickedFranchiseMobileNumber)->get();
            if ($check_mobile_number_query->count() == 0) {
                $franchise_code="";
                //trans

                $exception = DB::transaction(function () use (
                    $clickedFranchiseId,
                    $approveRejectStatus,
                    $approveRejectBy,
                    $clickedFranchiseMobileNumber,
                    $clickedFranchiseDOB,
                    $clickedFranchiseName,
                    $approveRejectRemarks
                ) {

                    $save_query =  DB::table('ueh_user')->insertGetId(
                        [
                            'role_id' => 1,
                            'user_name' => $clickedFranchiseName,
                            'user_dob' => $clickedFranchiseDOB,
                            'user_mobile_number' => $clickedFranchiseMobileNumber,
                            'password' => bcrypt('123456'),
                            'user_profile_image' => 'default.png',

                        ]
                    );

                    //
                    $get_query =  DB::table('ueh_franchise')
                        ->join('ueh_state', 'ueh_state.state_id', '=', 'ueh_franchise.state_id')
                        ->select(['ueh_state.state_code'])
                        ->where('ueh_franchise.franchise_id', $clickedFranchiseId)
                        ->get();

                    $franchise_code_prefix = "UEH/" . $get_query[0]->state_code . "/" . date('y') . "/FR";

                    $franchise_code = IdGenerator::generate([
                        'table' => 'ueh_franchise', 'length' => 16, 'prefix' => $franchise_code_prefix,
                        'reset_on_prefix_change' => true, 'field' => 'franchise_code'
                    ]);


                    DB::table('ueh_franchise')
                        ->where('franchise_id', $clickedFranchiseId)
                        ->update([
                            'user_id' => $save_query,
                            'franchise_status' => $approveRejectStatus,
                            'franchise_code' => $franchise_code,
                            'franchise_approved_rejected_remarks' => $approveRejectRemarks,
                            'franchise_approved_rejected_date' => now(),
                            'franchise_approved_rejected_by' => $approveRejectBy,
                            'franchise_valid_till'=> DB::raw("date_add(now(), INTERVAL 2 YEAR)")

                        ]);
                });

                if (is_null($exception)) {

                        $save_data['Result'] = "1";
                        try
                        {

                            $smstext = rawurlencode("Hi ".$clickedFranchiseName.", Your request for Franchise has been approved with Franchise Code: ".$franchise_code." . Login with Id:" .$clickedFranchiseMobileNumber ." & Password: 123456"  );

                            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=V6dw6TBazEGoT3a3exO8UA&senderid=ODILAS&channel=2&DCS=0&flashsms=0&number=$clickedFranchiseMobileNumber,8597500501&text=$smstext&route=1");
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
                            $result = curl_exec($ch);
                            if (curl_error($ch))
                            {
                                $result = curl_errno($ch);
                            }
                        } catch (Exception $ex)
                        {
                            $result = $ex->getMessage();
                        }

                } else {

                        $save_data['Result'] = "3";


                }
                //End

            } else {
                $save_data['Result'] = "5";
            }
        } else {
            $update_query=DB::table('ueh_franchise')
                ->where('franchise_id', $clickedFranchiseId)
                ->update([
                    'franchise_status' => $approveRejectStatus,
                    'franchise_approved_rejected_remarks' => $approveRejectRemarks,
                    'franchise_approved_rejected_date' => now(),
                    'franchise_approved_rejected_by' => $approveRejectBy

                ]);
                if($update_query>0)
                {
                    $save_data['Result'] = "2";

                        try
                        {

                            $smstext = rawurlencode("Hi ".$clickedFranchiseName.", Your request for Franchise has been rejected due to: ".$approveRejectRemarks.""  );

                            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=V6dw6TBazEGoT3a3exO8UA&senderid=ODILAS&channel=2&DCS=0&flashsms=0&number=$clickedFranchiseMobileNumber,8597500501&text=$smstext&route=1");
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
                            $result = curl_exec($ch);
                            if (curl_error($ch))
                            {
                                $result = curl_errno($ch);
                            }
                        } catch (Exception $ex)
                        {
                            $result = $ex->getMessage();
                        }
                }
                else
                {
                    $save_data['Result'] = "4";
                }

        }
        return $save_data;
    }

    public static function getAllECMemberListNotAssignedtoFranchise($franchiseId)
    {
    return  $query=DB::select("select ueh_ec_member.ec_member_id,
    ueh_ec_member.ec_member_applicant_name

        from ueh_ec_member left join ueh_franchise on ueh_ec_member.ec_member_id!=ueh_franchise.franchise_ec_member_code
         and
        ueh_franchise.franchise_id=$franchiseId where ueh_ec_member.ec_member_status=1");

    }

    public static function assignECMemberToFranchise($franchiseId,
    $ecMemberId)
    {
        $update_query=DB::table('ueh_franchise')
        ->where('franchise_id', $franchiseId)
        ->update([
            'franchise_ec_member_code' => $ecMemberId
        ]);
        if($update_query>0)
        {
            $save_data['Result'] = "1";
        }
        else
        {
            $save_data['Result'] = "2";
        }
        return $save_data;

    }


}
