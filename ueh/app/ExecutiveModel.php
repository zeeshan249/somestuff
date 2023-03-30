<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class ExecutiveModel extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected  $primaryKey = "ec_member_id";
    protected  $table = "ueh_ec_member";
    public  $timestamps = false;

    public static function  approveRejectAppliedExecutive(
        $clickedFranchiseId,
        $approveRejectStatus,$approveRejectBy,$clickedFranchiseMobileNumber,
        $clickedFranchiseDOB,
    $clickedFranchiseName,$approveRejectRemarks
    ) {

        if ($approveRejectStatus == "1") {
            $check_mobile_number_query = DB::table('ueh_user')->where('user_mobile_number',  $clickedFranchiseMobileNumber)->get();
            if ($check_mobile_number_query->count() == 0) {
                $Executive_code="";
                //trans

                $exception = DB::transaction(function () use (
                    $clickedFranchiseId,
                    $approveRejectStatus,$approveRejectBy,$clickedFranchiseMobileNumber,
                    $clickedFranchiseDOB,
                    $clickedFranchiseName,$approveRejectRemarks
                ) {

                    $save_query =  DB::table('ueh_user')->insertGetId(
                        [
                            'role_id' => 2,
                            'user_name' => $clickedFranchiseName,
                            'user_dob' => $clickedFranchiseDOB,
                            'user_mobile_number' => $clickedFranchiseMobileNumber,
                            'password' => bcrypt('123456'),
                            'user_profile_image' => 'default.png',

                        ]
                    );

                    //
                    $get_query =  DB::table('ueh_ec_member')
                        ->join('ueh_state', 'ueh_state.state_id', '=', 'ueh_ec_member.state_id')
                        ->select(['ueh_state.state_code'])
                        ->where('ueh_ec_member.ec_member_id', $clickedFranchiseId)
                        ->get();

                    $Executive_code_prefix = "UEH/" . $get_query[0]->state_code . "/" . date('y') . "/";

                    $Executive_code = IdGenerator::generate([
                        'table' => 'ueh_ec_member', 'length' => 15, 'prefix' => $Executive_code_prefix,
                        'reset_on_prefix_change' => true, 'field' => 'ec_member_code'
                    ]);


                    DB::table('ueh_ec_member')
                        ->where('ec_member_id', $clickedFranchiseId)
                        ->update([
                            'user_id' => $save_query,
                            'ec_member_status' => $approveRejectStatus,
                            'ec_member_code' => $Executive_code,
                            'ec_member_approved_rejected_remarks' => $approveRejectRemarks,
                            'ec_member_approved_rejected_date' => now(),
                            'ec_member_approved_rejected_by' => $approveRejectBy


                        ]);
                });

                if (is_null($exception)) {

                        $save_data['Result'] = "1";
                        try
                        {

                            $smstext = rawurlencode("Hi ".$clickedFranchiseName.", Your request for Executive Member has been approved with Executive Code: ".$Executive_code." . Login with Id:" .$clickedFranchiseMobileNumber ." & Password: 123456"  );

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
            $update_query=DB::table('ueh_ec_member')
                ->where('ec_member_id', $clickedFranchiseId)
                ->update([
                    'ec_member_status' => $approveRejectStatus,
                    'ec_member_approved_rejected_remarks' => $approveRejectRemarks,
                    'ec_member_approved_rejected_date' => now(),
                    'ec_member_approved_rejected_by' => $approveRejectBy

                ]);
                if($update_query>0)
                {
                    $save_data['Result'] = "2";
                    try
                        {

                            $smstext = rawurlencode("Hi ".$clickedFranchiseName.", Your request for Executive Member has been rejected due to: ".$approveRejectRemarks.""  );

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
}
