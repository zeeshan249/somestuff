<?php

namespace App;

use App\Mail\StaffDetailsMailable;
use DB;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class StaffModel extends Model
{
    protected $primaryKey = "lms_staff_id";
    protected $table = "lms_staff";
    public $timestamps = false;
    // Enable Disable Staff
    public static function enableDisableStaff(
        $centerId,
        $staffId,
        $isStaffActive,
        $loggedUserId,
        $staffUserId
    ) {

        //trans

        $exception = DB::transaction(function () use (
            $centerId,
            $staffId,
            $isStaffActive,
            $loggedUserId,
            $staffUserId
        ) {

            DB::table('lms_staff')
                ->where('lms_staff_id', $staffId)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_staff_is_active' => $isStaffActive,
                    'lms_staff_updated_at' => now(),
                    'lms_staff_updated_by' => $loggedUserId,

                ]);
            DB::table('lms_user')
                ->where('lms_user_id', $staffUserId)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_user_is_active' => $isStaffActive,
                    'lms_user_updated_at' => now(),
                    'lms_user_updated_by' => $loggedUserId,

                ]);
        });

        if (is_null($exception)) {

            $result_data['responseData'] = "1";
        } else {

            $result_data['responseData'] = "2";
        }
        //End
        return $result_data;
    }

    // Add Edit Staff
    public static function saveEditStaffBasicInfo(
        $centerId,
        $staffId,
        $loggedUserId,
        $staffUserId,
        $staffRoleId,
        $staffDesignationId,
        $staffDepartmentId,
        $staffFirstName,
        $staffLastName,
        $staffFathersName,
        $staffMothersName,
        $staffGender,
        $staffMaritalStatus,
        $staffDOB,
        $staffDOJ,
        $staffContactNumber,
        $staffEmergencyContactNumber,
        $staffEmail,
        $staffProfileImageName,
        $staffCurrentAddress,
        $staffPermanentAddress,
        $staffQualification,
        $staffWorkExp,
        $staffAbout,
        $isStaffBasicEdit,
        $staffProfileImageNameForEdit
    ) {

        if ($isStaffBasicEdit == 1) {
            // Edit the Staff
            //trans
            DB::beginTransaction();
            try {

                $checkMobileNumberQuery = DB::table('lms_user')
                    ->where('lms_user_mobile', $staffContactNumber)
                    ->where('lms_user_id', '!=', $staffUserId)
                    ->get();
                if ($checkMobileNumberQuery->count() == 0) {
                    // Mobile no do not exist
                    $checkEmailQuery = DB::table('lms_staff')
                        ->where('lms_staff_email', $staffEmail)
                        ->where('lms_user_id', '!=', $staffUserId)
                        ->get();
                    if ($checkEmailQuery->count() == 0) {

                        DB::table('lms_staff')
                            ->where('lms_user_id', $staffUserId)
                            ->where('lms_center_id', $centerId)
                            ->update([
                                'lms_staff_first_name' => $staffFirstName,
                                'lms_staff_last_name' => $staffLastName,
                                'lms_staff_full_name' => $staffFirstName . ' ' . $staffLastName,
                                'lms_staff_email' => $staffEmail,
                                'lms_staff_mobile_number' => $staffContactNumber,
                                'lms_staff_profile_image' => $staffProfileImageNameForEdit,
                                'lms_staff_updated_at' => now(),
                                'lms_staff_updated_by' => $loggedUserId,

                            ]);
                        
                     
                        DB::table('lms_staff')
                            ->where('lms_staff_id', $staffId)
                            ->where('lms_center_id', $centerId)
                            ->update([
                                'lms_department_id' => $staffDepartmentId == "null" ? null : $staffDepartmentId,
                                'lms_designation_id' => $staffDesignationId == "null" ? null : $staffDesignationId,
                                'lms_staff_qualification' => $staffQualification == "null" ? null : $staffQualification,
                                'lms_staff_work_experience' => $staffWorkExp == "null" ? null : $staffWorkExp,
                                'lms_staff_father_name' => $staffFathersName == "null" ? null : $staffFathersName,
                                'lms_staff_mother_name' => $staffMothersName == "null" ? null : $staffMothersName,
                                'lms_staff_emergency_contact' => $staffEmergencyContactNumber == "null" ? null : $staffEmergencyContactNumber,
                                'lms_staff_date_of_birth' => $staffDOB,
                                'lms_staff_marital_status' => $staffMaritalStatus == "null" ? null : $staffMaritalStatus,
                                'lms_staff_date_of_joining' => $staffDOJ,
                                'lms_staff_local_address' => $staffCurrentAddress == "null" ? null : $staffCurrentAddress,
                                'lms_staff_permanent_address' => $staffPermanentAddress == "null" ? null : $staffPermanentAddress,
                                'lms_staff_about' => $staffAbout == "null" ? null : $staffAbout,
                                'lms_staff_gender' => $staffGender,
                                'lms_staff_updated_at' => now(),
                                'lms_staff_updated_by' => $loggedUserId,

                            ]);

                            DB::table('lms_user')
                            ->where('lms_user_id',$staffUserId)
                            ->update([
                                'lms_user_mobile' => $staffContactNumber,
                              ]); 

                      //  DB::table('model_has_roles')
                      //      ->where('model_id', $staffUserId)
                       //     ->update([
                       //         'role_id' => $staffRoleId,
                       //     ]);
                    } else {
                        // Email exists
                        if ($staffProfileImageName != '') {
                            if (file_exists(storage_path('app/public/user_profile_images/' . $staffProfileImageName))) {
                                unlink(storage_path('app/public/user_profile_images/' . $staffProfileImageName));
                            }
                        }
                        $result_data['responseData'] = 2;
                        return $result_data;
                    }
                }
                 else 
                {
                    //Mobile no exist
                    if ($staffProfileImageName != '') {
                        if (file_exists(storage_path('app/public/user_profile_images/' . $staffProfileImageName))) {
                            unlink(storage_path('app/public/user_profile_images/' . $staffProfileImageName));
                        }
                    }
                    $result_data['responseData'] = 3;
                    return $result_data;
                }

                DB::commit();
                // Edit Success
                $result_data['responseData'] = 6;
                $result_data['staffEditImageName'] = $staffProfileImageName;
                return $result_data;
            
            } catch (Exception $ex) {

                DB::rollback();
                if ($staffProfileImageName != '') {
                    if (file_exists(storage_path('app/public/user_profile_images/' . $staffProfileImageName))) {
                        unlink(storage_path('app/public/user_profile_images/' . $staffProfileImageName));
                    }
                }
                $result_data['responseData'] = $ex->getMessage();
                return $result_data;
            }
            //End

        } else {
            //Save the staff
            //trans
            DB::beginTransaction();
            try {

                $checkMobileNumberQuery = DB::table('lms_user')->where('lms_user_mobile', $staffContactNumber)->get();
                if ($checkMobileNumberQuery->count() == 0) {
                    // Mobile no do not exist
                    $checkEmailQuery = DB::table('lms_staff')->where('lms_staff_email', $staffEmail)->get();
                    if ($checkEmailQuery->count() == 0) {

                        // Email do not exists
                        $staffPassword = random_int(100000, 999999);
                        $getCenterCodeQuery = DB::table('lms_center_details')
                            ->select(['lms_center_code'])
                            ->where('lms_center_id', $centerId)
                            ->get();

                        $getStaffCodePrefixQuery = DB::table('lms_prefix_setting')
                            ->select(['lms_prefix'])
                            ->where('lms_center_id', $centerId)
                            ->where('lms_prefix_module_name', "Staff Code")
                            ->get();
                        $staffCodePrefix = $getStaffCodePrefixQuery[0]->lms_prefix . $getCenterCodeQuery[0]->lms_center_code . date('y');
                        $staffCode = IdGenerator::generate([
                            'table' => 'lms_staff', 'length' => 14, 'prefix' => $staffCodePrefix,
                            'reset_on_prefix_change' => true, 'field' => 'lms_staff_code',
                        ]);
                        //Check Email or SMS will be sent
                        $checkEmailSMSSentQuery = DB::table('lms_notification_setting')
                            ->select(['lms_notification_setting_is_mail', 'lms_notification_setting_is_sms', 'lms_notification_setting_is_notification', 'lms_notification_setting_template'])
                            ->where('lms_center_id', $centerId)
                            ->where('lms_notification_setting_id', 1)
                            ->get();

                        $staffCreateUserQuery = DB::table('lms_user')->insertGetId(
                            [
                                'lms_center_id' => $centerId,
                                'password' => bcrypt($staffPassword),
                                'lms_user_mobile' => $staffContactNumber,
                                'lms_user_created_by' => $loggedUserId,
                                'role_id'=> $staffRoleId,
                                'password_normal'=>$staffPassword

                            ]
                        );

                        $staffCreateQuery = DB::table('lms_staff')->insertGetId(
                            [
                                'lms_staff_profile_image' => $staffProfileImageName,
                                'lms_staff_first_name' => $staffFirstName,
                                'lms_staff_last_name' => $staffLastName,
                                'lms_staff_full_name' => $staffFirstName . ' ' . $staffLastName,
                                'lms_staff_email' => $staffEmail,
                                'lms_staff_mobile_number' => $staffContactNumber,
                                'lms_center_id' => $centerId,
                                'lms_department_id' => $staffDepartmentId,
                                'lms_designation_id' => $staffDesignationId,
                                'lms_user_id' => $staffCreateUserQuery,
                                'lms_staff_code' => $staffCode,
                                'lms_staff_qualification' => $staffQualification,
                                'lms_staff_work_experience' => $staffWorkExp,
                                'lms_staff_father_name' => $staffFathersName,
                                'lms_staff_mother_name' => $staffMothersName,
                                'lms_staff_emergency_contact' => $staffEmergencyContactNumber,
                                'lms_staff_date_of_birth' => $staffDOB,
                                'lms_staff_marital_status' => $staffMaritalStatus,
                                'lms_staff_date_of_joining' => $staffDOJ,
                                'lms_staff_local_address' => $staffCurrentAddress,
                                'lms_staff_permanent_address' => $staffPermanentAddress,
                                'lms_staff_about' => $staffAbout,
                                'lms_staff_gender' => $staffGender,
                                'lms_staff_created_by' => $loggedUserId,
                                'role_id'=> $staffRoleId,
                            ]
                        );

                        DB::table('model_has_roles')->insertGetId(
                           [
                               'role_id' => $staffRoleId,
                               'model_id' => $staffCreateUserQuery,

                           ]
                       );
                    } else {
                        // Email exists
                        if ($staffProfileImageName != '') {
                            if (file_exists(storage_path('app/public/user_profile_images/' . $staffProfileImageName))) {
                                unlink(storage_path('app/public/user_profile_images/' . $staffProfileImageName));
                            }
                        }
                        $result_data['responseData'] = 2;
                        return $result_data;
                    }
                } else {

                    //Mobile no exist
                    if ($staffProfileImageName != '') {
                        if (file_exists(storage_path('app/public/user_profile_images/' . $staffProfileImageName))) {
                            unlink(storage_path('app/public/user_profile_images/' . $staffProfileImageName));
                        }
                    }
                    $result_data['responseData'] = 3;
                    return $result_data;
                }
                DB::commit();

                // if ($checkEmailSMSSentQuery[0]->lms_notification_setting_is_mail == "1") {
                //     //send Mail
                //     StaffModel::sendMail($centerId, $staffPassword, $staffContactNumber, $staffEmail);
                // }
                // if ($checkEmailSMSSentQuery[0]->lms_notification_setting_is_sms == "1") {
                //     //send SMS
                //     StaffModel::sendSMS($centerId, $staffPassword, $staffContactNumber, $checkEmailSMSSentQuery[0]->lms_notification_setting_template, $staffFirstName);
                // }

                // if ($checkEmailSMSSentQuery[0]->lms_notification_setting_is_sms == "1" && $checkEmailSMSSentQuery[0]->lms_notification_setting_is_mail == "1") {
                //     //send SMS & Email Both
                //     StaffModel::sendMail($centerId, $staffPassword, $staffContactNumber, $staffEmail);
                //     StaffModel::sendSMS($centerId, $staffPassword, $staffContactNumber, $checkEmailSMSSentQuery[0]->lms_notification_setting_template, $staffFirstName);
                // }
                // If saved success

                $result_data['responseData'] = 4;
                $result_data['staffUserId'] = $staffCreateUserQuery;
                $result_data['staffId'] = $staffCreateQuery;
                $result_data['staffCode'] = $staffCode;
                $result_data['staffEditImageName'] = $staffProfileImageName;
                return $result_data;
            } catch (Exception $ex) {

                DB::rollback();
                if ($staffProfileImageName != '') {
                    if (file_exists(storage_path('app/public/user_profile_images/' . $staffProfileImageName))) {
                        unlink(storage_path('app/public/user_profile_images/' . $staffProfileImageName));
                    }
                }
                $result_data['responseData'] = $ex->getMessage();
                return $result_data;
            }

            //End

        }
    }

    public static function sendMail($centerId, $staffPassword, $staffContactNumber, $staffEmail)
    {
        $getEmailSettingQuery = DB::table('lms_email_setting')->where('lms_center_id', $centerId)
            ->where('lms_email_setting_is_active', 1)
            ->get();

        $config = array(
            'driver' => $getEmailSettingQuery[0]->lms_email_setting_driver_name,
            'host' => $getEmailSettingQuery[0]->lms_email_setting_host,
            'port' => $getEmailSettingQuery[0]->lms_email_setting_port,
            'username' => $getEmailSettingQuery[0]->lms_email_setting_user_name,
            'password' => $getEmailSettingQuery[0]->lms_email_setting_password,
            'encryption' => $getEmailSettingQuery[0]->lms_email_setting_encryption,
            'from' => array('address' => $getEmailSettingQuery[0]->lms_email_setting_from_address, 'name' => $getEmailSettingQuery[0]->lms_email_setting_from_name),
            'transport' => $getEmailSettingQuery[0]->lms_email_setting_transport,
            'pretend' => false,

        );
        Config::set('mail', $config);
        $staffDetails = [
            'loginId' => $staffContactNumber,
            'password' => $staffPassword,
        ];
        Mail::to($staffEmail)->send(new StaffDetailsMailable($staffDetails));
    }
    public static function sendSMS($centerId, $staffPassword, $staffContactNumber, $smsTemplate, $staffFirstName)
    {
        try {
            $getSMSSettingQuery = DB::table('lms_sms_setting')->where('lms_center_id', $centerId)
                ->where('lms_sms_setting_is_active', 1)
                ->get();
            $actualSMSTemplate = rawurlencode(str_replace(
                array('{{username}}', '{{loginid}}', '{{password}}'),
                array($staffFirstName, $staffContactNumber, $staffPassword),
                $smsTemplate
            ));
            $smsApiKey = $getSMSSettingQuery[0]->lms_sms_api_key;
            $smsSenderId = $getSMSSettingQuery[0]->lms_sms_setting_sender_id;

            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=$smsApiKey&senderid=$smsSenderId&channel=2&DCS=0&flashsms=0&number=$staffContactNumber&text=$actualSMSTemplate&route=1");
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
    }
    // Edit Pay roll
    public static function editStaffPayrollInfo(
        $centerId,
        $staffId,
        $loggedUserId,
        $staffEpfNo,
        $staffBasicSalary,
        $staffContractType,
        $staffWorkShift,
        $staffLocation
    ) {
        $updateQuery = DB::table('lms_staff')
            ->where('lms_staff_id', $staffId)
            ->where('lms_center_id', $centerId)
            ->update([
                'lms_staff_basic_salary' => $staffBasicSalary == "null" ? null : $staffBasicSalary,
                'lms_staff_epf_number' => $staffEpfNo == "null" ? null : $staffEpfNo,
                'lms_staff_contract_type' => $staffContractType == "null" ? null : $staffContractType,
                'lms_staff_shift' => $staffWorkShift == "null" ? null : $staffWorkShift,
                'lms_staff_location' => $staffLocation == "null" ? null : $staffLocation,
                'lms_staff_updated_at' => now(),
                'lms_staff_updated_by' => $loggedUserId,

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = 1;
        } else {
            $result_data['responseData'] = 2;
        }
        return $result_data;
    }

    // Edit bank details
    public static function editStaffBankDetailsInfo(
        $centerId,
        $staffId,
        $loggedUserId,
        $staffAccountTitle,
        $staffBankAccountNumber,
        $staffBank,
        $staffIfscCode,
        $staffBankBranch
    ) {
        $updateQuery = DB::table('lms_staff')
            ->where('lms_staff_id', $staffId)
            ->where('lms_center_id', $centerId)
            ->update([
                'lms_staff_account_title' => $staffAccountTitle == "null" ? null : $staffAccountTitle,
                'lms_staff_bank_account_number' => $staffBankAccountNumber == "null" ? null : $staffBankAccountNumber,
                'lms_staff_bank_name' => $staffBank == "null" ? null : $staffBank,
                'lms_staff_bank_ifsc_code' => $staffIfscCode == "null" ? null : $staffIfscCode,
                'lms_staff_bank_branch' => $staffBankBranch == "null" ? null : $staffBankBranch,
                'lms_staff_updated_at' => now(),
                'lms_staff_updated_by' => $loggedUserId,

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = 1;
        } else {
            $result_data['responseData'] = 2;
        }
        return $result_data;
    }

    // Edit Social details
    public static function editStaffSocialLinkInfo(
        $centerId,
        $staffId,
        $loggedUserId,
        $staffWhatsApp,
        $staffFacebook,
        $staffTwitter,
        $staffLinkedin,
        $staffInstagram
    ) {
        $updateQuery = DB::table('lms_staff')
            ->where('lms_staff_id', $staffId)
            ->where('lms_center_id', $centerId)
            ->update([
                'lms_staff_whatsapp' => $staffWhatsApp == "null" ? null : $staffWhatsApp,
                'lms_staff_facebook' => $staffFacebook == "null" ? null : $staffFacebook,
                'lms_staff_twitter' => $staffTwitter == "null" ? null : $staffTwitter,
                'lms_staff_linkedin' => $staffLinkedin == "null" ? null : $staffLinkedin,
                'lms_staff_instagram' => $staffInstagram == "null" ? null : $staffInstagram,
                'lms_staff_updated_at' => now(),
                'lms_staff_updated_by' => $loggedUserId,

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = 1;
        } else {
            $result_data['responseData'] = 2;
        }
        return $result_data;
    }

    // Edit Upload Document
    public static function editStaffUploadDocumentInfo(
        $centerId,
        $staffId,
        $loggedUserId,
        $staffJoiningLetterName,
        $staffResumeName,
        $staffResignationLetterName,
        $staffAadharCardName,
        $staffPanCardName,
        $staffVoterCardName
    ) {
        $updateQuery = DB::table('lms_staff')
            ->where('lms_staff_id', $staffId)
            ->where('lms_center_id', $centerId)
            ->update([
                'lms_staff_resume_path' => $staffResumeName,
                'lms_staff_joining_letter_path' => $staffJoiningLetterName,
                'lms_staff_resignation_letter_path' => $staffResignationLetterName,
                'lms_staff_aadhar_path' => $staffAadharCardName,
                'lms_staff_pan_path' => $staffPanCardName,
                'lms_staff_voter_card_path' => $staffVoterCardName,
                'lms_staff_updated_at' => now(),
                'lms_staff_updated_by' => $loggedUserId,

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = 7;
            $result_data['staffJoiningLetterName'] = $staffJoiningLetterName;
            $result_data['staffResumeName'] = $staffResumeName;
            $result_data['staffResignationLetterName'] = $staffResignationLetterName;
            $result_data['staffAadharCardName'] = $staffAadharCardName;
            $result_data['staffPanCardName'] = $staffPanCardName;
            $result_data['staffVoterCardName'] = $staffVoterCardName;
        } else {
            $result_data['responseData'] = 8;
            if ($staffJoiningLetterName != '') {
                if (file_exists(storage_path('app/public/staff_documents/' . $staffJoiningLetterName))) {
                    unlink(storage_path('app/public/staff_documents/' . $staffJoiningLetterName));
                }
            }
            if ($staffResumeName != '') {
                if (file_exists(storage_path('app/public/staff_documents/' . $staffResumeName))) {
                    unlink(storage_path('app/public/staff_documents/' . $staffResumeName));
                }
            }
            if ($staffResignationLetterName != '') {
                if (file_exists(storage_path('app/public/staff_documents/' . $staffResignationLetterName))) {
                    unlink(storage_path('app/public/staff_documents/' . $staffResignationLetterName));
                }
            }
            if ($staffAadharCardName != '') {
                if (file_exists(storage_path('app/public/staff_documents/' . $staffAadharCardName))) {
                    unlink(storage_path('app/public/staff_documents/' . $staffAadharCardName));
                }
            }
            if ($staffPanCardName != '') {
                if (file_exists(storage_path('app/public/staff_documents/' . $staffPanCardName))) {
                    unlink(storage_path('app/public/staff_documents/' . $staffPanCardName));
                }
            }
            if ($staffVoterCardName != '') {
                if (file_exists(storage_path('app/public/staff_documents/' . $staffVoterCardName))) {
                    unlink(storage_path('app/public/staff_documents/' . $staffVoterCardName));
                }
            }
        }
        return $result_data;
    }
}
