<?php

namespace App;

use App\Mail\StaffDetailsMailable;
use DB;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class EnquiryModel extends Model
{
    protected $primaryKey = "lms_staff_id";
    protected $table = "lms_staff";
    public $timestamps = false;
    // Enable Disable Enquiry
    public static function enableDisableEnquiry(
        $centerId,
        $lms_enquiry_id,
        $lms_enquiry_status,
        $loggedUserId
    ) {

        //trans

        $exception = DB::transaction(function () use (
            $centerId,
            $lms_enquiry_id,
            $lms_enquiry_status,
            $loggedUserId
        ) {

            DB::table('lms_enquiry')
                ->where('lms_enquiry_id', $lms_enquiry_id)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_enquiry_status' => $lms_enquiry_status,
                    'lms_enquiry_updated_at' => now(),
                    'lms_enquiry_updated_by' => $loggedUserId,

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



    public static function updateStudentDetails(
        $lms_user_id,
        $centerId,
        $lms_enquiry_id,
        $loggedUserId,
        $lms_student_first_name,
        $lms_student_last_name,
        $lms_student_mobile_number,
        $lms_enquiry_local_address,
        $lms_enquiry_date_of_birth,
        $lms_enquiry_father_name,
        $lms_enquiry_mother_name,
        $lms_enquiry_gender,
        $lms_enquiry_marital_status,
        $lms_enquiry_whatsapp_contact,
        $lms_enquiry_qualification,
        $lms_enquiry_email,
        $lms_enquiry_permanent_address,
        $lms_user_can_change_profile_image
    ) {
    

        if ($lms_user_can_change_profile_image == "true") {
            $lms_user_can_change_profile_image = 1;
        } else {

            $lms_user_can_change_profile_image = 0;
        }

        //trans

        $exception = DB::transaction(function () use (
            $lms_user_id,
            $centerId,
            $lms_enquiry_id,
            $loggedUserId,
            $lms_student_first_name,
            $lms_student_last_name,
            $lms_student_mobile_number,
            $lms_enquiry_local_address,
            $lms_enquiry_date_of_birth,
            $lms_enquiry_father_name,
            $lms_enquiry_mother_name,
            $lms_enquiry_gender,
            $lms_enquiry_marital_status,
            $lms_enquiry_whatsapp_contact,
            $lms_enquiry_qualification,
            $lms_enquiry_email,
            $lms_enquiry_permanent_address,
            $lms_user_can_change_profile_image
        ) {

            DB::table('lms_student')
                ->where('lms_enquiry_id', $lms_enquiry_id)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_student_first_name' => $lms_student_first_name,
                    'lms_student_last_name' => $lms_student_last_name,
                    'lms_student_full_name' => $lms_student_first_name  . ' ' . $lms_student_last_name,
                    'lms_student_mobile_number' => $lms_student_mobile_number,
                    'lms_student_whatsapp_number' => $lms_enquiry_whatsapp_contact,
                    'lms_student_email' => $lms_enquiry_email,
                    'lms_student_updated_by' => $loggedUserId,
                    'lms_student_updated_at' => now(),
                ]);

            DB::table('lms_user')
                ->where('lms_user_id', $lms_user_id)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_user_can_change_profile_image' => $lms_user_can_change_profile_image,
                    'lms_user_mobile' => $lms_student_mobile_number,
                    'lms_user_created_by' => $loggedUserId,
                    'lms_user_updated_at' => now(),

                ]);

            DB::table('lms_enquiry')
                ->where('lms_enquiry_id', $lms_enquiry_id)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_enquiry_first_name' => $lms_student_first_name,
                    'lms_enquiry_last_name' => $lms_student_last_name,
                    'lms_enquiry_full_name' => $lms_student_first_name  . ' ' . $lms_student_last_name,
                    'lms_enquiry_mobile' => $lms_student_mobile_number,
                    'lms_enquiry_email' => $lms_enquiry_email,

                    'lms_enquiry_qualification' => $lms_enquiry_qualification,
                    'lms_enquiry_father_name' => $lms_enquiry_father_name,
                    'lms_enquiry_mother_name' => $lms_enquiry_mother_name,
                    'lms_enquiry_gender' => $lms_enquiry_gender,
                    'lms_enquiry_mobile' => $lms_student_mobile_number,
                    'lms_enquiry_marital_status' => $lms_enquiry_marital_status,
                    'lms_enquiry_date_of_birth' => $lms_enquiry_date_of_birth,
                    'lms_enquiry_whatsapp_contact' => $lms_enquiry_whatsapp_contact,
                    'lms_enquiry_local_address' => $lms_enquiry_local_address,
                    'lms_enquiry_permanent_address' => $lms_enquiry_permanent_address,


                    'lms_enquiry_updated_by' => $loggedUserId,
                    'lms_enquiry_updated_at' => now()
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

    // Add Edit Enquiry
   public static function saveEditEnquiryBasicInfo(
        $centerId,
        $enquiryId,
        $loggedUserId,
        $enquiryUserId,
        $enquirySourceId,
        $enquiryCourseId,
        $enquirySchoolId,
        $enquiryFirstName,
        $enquiryLastName,
        $enquiryFathersName,
        $enquiryMothersName,
        $enquiryGender,
        $enquiryMaritalStatus,
        $enquiryDOB,
        $enquiryDOJ,
        $enquiryContactNumber,
        $whatsAppNumber,
        $enquiryEmail,
        $enquiryCurrentAddress,
        $enquiryPermanentAddress,
        $enquiryQualification,
        $enquiryWorkExp,
        $enquiryAbout,
        $isEnquiryBasicEdit,
        $lms_child_course_id,
        $lms_enquiry_class,
        $lms_enquiry_section,
        $lms_enquiry_roll_no
    ) {

        if ($isEnquiryBasicEdit == 1) {
            // Edit the Enquiry

            //trans
            DB::beginTransaction();
            try {

                $checkMobileNumberQuery = DB::table('lms_enquiry')
                    ->where('lms_enquiry_mobile', $enquiryContactNumber)
                    ->where('lms_enquiry_id', '!=', $enquiryId)
                    ->get();
                if ($checkMobileNumberQuery->count() == 0) {
                    // Mobile no do not exist
                    $checkEmailQuery = DB::table('lms_enquiry')
                        ->where('lms_enquiry_email', $enquiryEmail)
                        ->where('lms_enquiry_id', '!=', $enquiryId)
                        ->get();
                    if ($checkEmailQuery->count() == 0) {

                        DB::table('lms_enquiry')
                            ->where('lms_enquiry_id', $enquiryId)
                            ->where('lms_center_id', $centerId)
                            ->update([
                                'lms_enquiry_first_name' => $enquiryFirstName,
                                'lms_enquiry_last_name' => $enquiryLastName,
                                'lms_enquiry_full_name' => $enquiryFirstName . ' ' . $enquiryLastName,
                                'lms_enquiry_email' => $enquiryEmail,
                                'lms_enquiry_mobile' => $enquiryContactNumber,

                                'lms_enquiry_updated_at' => now(),
                                'lms_enquiry_updated_by' => $loggedUserId,

                            ]);

                        DB::table('lms_enquiry')
                            ->where('lms_enquiry_id', $enquiryId)
                            ->where('lms_center_id', $centerId)
                            ->update([
                                'lms_information_source_id' => $enquirySourceId == "null" ? null : $enquirySourceId,
                                'lms_school_id' => $enquirySchoolId == "null" ? null : $enquirySchoolId,
                                'lms_course_id' => $enquiryCourseId == "null" ? null : $enquiryCourseId,
                                'lms_child_course_id' => $lms_child_course_id == "null" ? null : $lms_child_course_id,

                                'lms_enquiry_qualification' => $enquiryQualification == "null" ? null : $enquiryQualification,
                                'lms_enquiry_work_experience' => $enquiryWorkExp == "null" ? null : $enquiryWorkExp,
                                'lms_enquiry_father_name' => $enquiryFathersName == "null" ? null : $enquiryFathersName,
                                'lms_enquiry_mother_name' => $enquiryMothersName == "null" ? null : $enquiryMothersName,
                                'lms_enquiry_whatsapp_contact' => $whatsAppNumber == "null" ? null : $whatsAppNumber,
                                'lms_enquiry_date_of_birth' => $enquiryDOB,
                                'lms_enquiry_marital_status' => $enquiryMaritalStatus == "null" ? null : $enquiryMaritalStatus,
                                'lms_enquiry_date' => $enquiryDOJ,
                                'lms_enquiry_date_of_joining' => $enquiryDOJ,
                                'lms_enquiry_local_address' => $enquiryCurrentAddress == "null" ? null : $enquiryCurrentAddress,
                                'lms_enquiry_permanent_address' => $enquiryPermanentAddress == "null" ? null : $enquiryPermanentAddress,
                                'lms_enquiry_about' => $enquiryAbout == "null" ? null : $enquiryAbout,
                                'lms_enquiry_gender' => $enquiryGender,
                                'lms_enquiry_updated_at' => now(),
                                'lms_enquiry_updated_by' => $loggedUserId,
                                'lms_enquiry_class'=> $lms_enquiry_class,
                                'lms_enquiry_section' => $lms_enquiry_section,
                                'lms_roll_no' => $lms_enquiry_roll_no

                            ]);
                    } else {
                        // Email exists

                        $result_data['responseData'] = 2;
                        return $result_data;
                    }
                } else {
                    //Mobile no exist

                    $result_data['responseData'] = 3;
                    return $result_data;
                }

                DB::commit();
                // Edit Success
                $result_data['responseData'] = 6;

                return $result_data;
            } catch (Exception $ex) {

                DB::rollback();

                $result_data['responseData'] = 7;
                return $result_data;
            }
            //End

        } else {
            //Save the enquiry
            //trans


            DB::beginTransaction();
            try {
                $checkMobileNumberQuery = DB::table('lms_enquiry')->where('lms_enquiry_mobile', $enquiryContactNumber)->get();
                if ($checkMobileNumberQuery->count() == 0) {
                    // Mobile no do not exist
                    $checkEmailQuery = DB::table('lms_enquiry')->where('lms_enquiry_email', $enquiryEmail)->get();
                    if ($checkEmailQuery->count() == 0) {

                        // Email do not exists
                        $enquiryPassword = random_int(100000, 999999);

                        $getCenterCodeQuery = DB::table('lms_center_details')
                            ->select(['lms_center_code'])
                            ->where('lms_center_id', $centerId)
                            ->get();

                        $getEnquiryCodePrefixQuery = DB::table('lms_prefix_setting')
                            ->select(['lms_prefix'])
                            ->where('lms_center_id', $centerId)
                            ->where('lms_prefix_module_name', "Enquiry Code")
                            ->get();
                        $enquiryCodePrefix = $getEnquiryCodePrefixQuery[0]->lms_prefix . $getCenterCodeQuery[0]->lms_center_code . date('y');
                        $enquiryCode = IdGenerator::generate([
                            'table' => 'lms_enquiry', 'length' => 14, 'prefix' => $enquiryCodePrefix,
                            'reset_on_prefix_change' => true, 'field' => 'lms_enquiry_code',
                        ]);
                        //Check Email or SMS will be sent
                        $checkEmailSMSSentQuery = DB::table('lms_notification_setting')
                            ->select(['lms_notification_setting_is_mail', 'lms_notification_setting_is_sms', 'lms_notification_setting_is_notification', 'lms_notification_setting_template'])
                            ->where('lms_center_id', $centerId)
                            ->where('lms_notification_setting_id', 2)
                            ->get();

                      

                        $enquiryCreateQuery = DB::table('lms_enquiry')->insertGetId(
                            [

                                'lms_enquiry_first_name' => $enquiryFirstName,
                                'lms_enquiry_last_name' => $enquiryLastName,
                                'lms_enquiry_full_name' => $enquiryFirstName . ' ' . $enquiryLastName,
                                'lms_enquiry_email' => $enquiryEmail,
                                'lms_enquiry_mobile' => $enquiryContactNumber,
                                'lms_center_id' => $centerId,
                                'lms_enquiry_school_name' => $enquirySchoolId,
                                'lms_course_id' => $enquiryCourseId,
                                'lms_child_course_id' =>  $lms_child_course_id,
                                'lms_enquiry_code' => $enquiryCode,
                                'lms_information_source_id' => $enquirySourceId,
                                'lms_enquiry_qualification' => $enquiryQualification,
                                'lms_enquiry_work_experience' => $enquiryWorkExp,
                                'lms_enquiry_father_name' => $enquiryFathersName,
                                'lms_enquiry_mother_name' => $enquiryMothersName,
                                'lms_enquiry_whatsapp_contact' => $whatsAppNumber,
                                'lms_enquiry_date_of_birth' => $enquiryDOB,
                                'lms_enquiry_marital_status' => $enquiryMaritalStatus,
                                'lms_enquiry_date' => $enquiryDOJ,
                                'lms_enquiry_date_of_joining' => $enquiryDOJ,
                                'lms_enquiry_local_address' => $enquiryCurrentAddress,
                                'lms_enquiry_permanent_address' => $enquiryPermanentAddress,
                                'lms_enquiry_about' => $enquiryAbout,
                                'lms_enquiry_gender' => $enquiryGender,
                                'lms_enquiry_created_by' => $loggedUserId,
                                'lms_enquiry_handled_by' => $loggedUserId,
                                'lms_enquiry_class'=> $lms_enquiry_class,
                                'lms_enquiry_section' => $lms_enquiry_section,
                                'lms_roll_no' => $lms_enquiry_roll_no
                            ]
                        );
                    } else {
                        // Email exists

                        $result_data['responseData'] = 2;
                        return $result_data;
                    }
                } else {

                    //Mobile no exist

                    $result_data['responseData'] = 3;
                    return $result_data;
                }
                DB::commit();

                // if ($checkEmailSMSSentQuery[0]->lms_notification_setting_is_mail == "1") {
                //     //send Mail
                //     EnquiryModel::sendMail($centerId, $enquiryCode, $enquiryContactNumber, $enquiryEmail);
                // }
                // if ($checkEmailSMSSentQuery[0]->lms_notification_setting_is_sms == "1") {
                //     //send SMS
                //     EnquiryModel::sendSMS($centerId, $enquiryPassword, $enquiryContactNumber, $checkEmailSMSSentQuery[0]->lms_notification_setting_template, $enquiryFirstName);
                // }

                // if ($checkEmailSMSSentQuery[0]->lms_notification_setting_is_sms == "1" && $checkEmailSMSSentQuery[0]->lms_notification_setting_is_mail == "1") {
                //     //send SMS & Email Both
                //     EnquiryModel::sendMail($centerId, $enquiryCode, $enquiryContactNumber, $enquiryEmail);
                //     EnquiryModel::sendSMS($centerId, $enquiryContactNumber, $checkEmailSMSSentQuery[0]->lms_notification_setting_template, $enquiryFirstName);
                // }
                // If saved success

                $result_data['responseData'] = 4;
                $result_data['enquiryId'] = $enquiryCreateQuery;
                $result_data['enquiryCode'] = $enquiryCode;
                return $result_data;
               
            } 
            
            catch (Exception $ex) {

                DB::rollback();

                $result_data['responseData'] = 5;
                return $result_data;
            }
        }
    }



    //End of Add Enquiry

    public static function sendMail($centerId, $enquiryCode, $enquiryContactNumber, $enquiryEmail)
    {
        $getEmailSettingQuery = DB::table('lms_email_setting')->where('lms_center_id', $centerId)
            ->where('lms_email_setting_is_active', 2)
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
            'enquiryCode' => $enquiryCode,
            'course' => $enquiryContactNumber,
        ];
        Mail::to($enquiryEmail)->send(new StaffDetailsMailable($staffDetails));
    }

    public static function sendSMS($centerId, $enquiryContactNumber, $smsTemplate, $enquiryFirstName)
    {
        try {
            $getSMSSettingQuery = DB::table('lms_sms_setting')->where('lms_center_id', $centerId)
                ->where('lms_sms_setting_is_active', 1)
                ->get();
            $actualSMSTemplate = rawurlencode(str_replace(
                array('{{username}}', '{{enquiryCode}}', '{{course}}'),
                array($enquiryFirstName, $enquiryContactNumber),
                $smsTemplate
            ));
          
            $smsApiKey = $getSMSSettingQuery[0]->lms_sms_api_key;
            $smsSenderId = $getSMSSettingQuery[0]->lms_sms_setting_sender_id;

            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=$smsApiKey&senderid=$smsSenderId&channel=2&DCS=0&flashsms=0&number=$enquiryContactNumber&text=$actualSMSTemplate&route=1");
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

  // Save Enquiry
  public static function registerUser($centerId ,$courseId, $firstName, $lastName, $mobileNumber, $password, $loggedUserId,
   $enquiryEmail, $lms_enquiry_id, $childCourseId,$selectedImage,$enquiryCurrentAddress,$enquiryPermanentAddress
   ,$enquiryFathersName,$enquiryMothersName,$enquiryGender,$enquiryMaritalStatus,$enquiryDOB,$enquiryDOJ,$whatsAppNumber, $enquiryQualification,
   $enquiryWorkExp)
  {
      try {

          DB::beginTransaction();

          $checkMobileNumberQuery = DB::table('lms_student')->where('lms_student_mobile_number', $mobileNumber)->get();
          if ($checkMobileNumberQuery->count() == 0) {
              // Mobile no do not exist
              $checkEmailQuery = DB::table('lms_student')->where('lms_student_email', $enquiryEmail)->get();
              if ($checkEmailQuery->count() == 0) {
                $rand=random_int(111111, 999999);
                  $userId = DB::table('lms_user')->insertGetId(
                      [
                          'role_id' => 1,
                          'password' => bcrypt($rand),
                          'password_normal' =>  $rand,
                          'lms_user_mobile' => $mobileNumber,
                          'lms_center_id' => $centerId,
                          'lms_user_created_by' => $loggedUserId,
                      ]
                  );
                  $getCenterCodeQuery = DB::table('lms_center_details')
                      ->select(['lms_center_code'])
                      ->where('lms_center_id', $centerId)
                      ->get();

                  $getStudentCodePrefixQuery = DB::table('lms_prefix_setting')
                      ->select(['lms_prefix'])
                      ->where('lms_center_id', $centerId)
                      ->where('lms_prefix_module_name', "Student Code")
                      ->get();
                  $studentCodePrefix = $getStudentCodePrefixQuery[0]->lms_prefix . $getCenterCodeQuery[0]->lms_center_code . date('y');
                  $studentCode = IdGenerator::generate([
                      'table' => 'lms_student', 'length' => 14, 'prefix' => $studentCodePrefix,
                      'reset_on_prefix_change' => true, 'field' => 'lms_student_code',
                  ]);

                  
                  $studentId = DB::table('lms_student')->insertGetId(
                      [
                          'lms_center_id' => $centerId,
                          'lms_enquiry_id' => $lms_enquiry_id,
                          'lms_user_id' => $userId,
                          'lms_student_email' => $enquiryEmail,
                          'role_id' => 1,
                          'lms_student_code' => $studentCode,
                          'lms_student_first_name' => ucfirst($firstName),
                          'lms_student_last_name' => ucfirst($lastName),
                          'lms_student_full_name' => ucfirst($firstName) . ' ' . ucfirst($lastName),
                          'lms_student_mobile_number' => $mobileNumber,
                          'lms_student_whatsapp_number'=>$whatsAppNumber,
                          'lms_student_created_by' => $loggedUserId,
                          'lms_student_profile_image'=>  $selectedImage

                      ]
                  );

                  $getRegistrationCodePrefixQuery = DB::table('lms_prefix_setting')
                      ->select(['lms_prefix'])
                      ->where('lms_center_id', $centerId)
                      ->where('lms_prefix_module_name', "Registration Code")
                      ->get();
                  $registrationCodePrefix = $getRegistrationCodePrefixQuery[0]->lms_prefix . $getCenterCodeQuery[0]->lms_center_code . date('y');
                  $registrationCode = IdGenerator::generate([
                      'table' => 'lms_student_course_mapping', 'length' => 14, 'prefix' => $registrationCodePrefix,
                      'reset_on_prefix_change' => true, 'field' => 'lms_registration_code',
                  ]);

                  DB::table('lms_student_course_mapping')->insertGetId(
                      [

                          'lms_center_id' => $centerId,
                          'lms_course_id' => $courseId,
                          'lms_child_course_id' => $childCourseId,
                          'lms_user_id' => $userId,
                          'lms_student_id' => $studentId,
                          'lms_registration_code' => $registrationCode,
                          'lms_student_course_mapping_created_by' => $loggedUserId,
                          'lms_student_registration_type' => '2'

                      ]
                  );

                  DB::table('lms_enquiry')
                      ->where('lms_enquiry_id', $lms_enquiry_id)
                      ->update([
                          'lms_enquiry_status' => '3',
                          'lms_enquiry_updated_at' => now(),
                          'lms_enquiry_updated_by' => $loggedUserId,

                      ]);
               DB::table('lms_enquiry')
                ->where('lms_enquiry_id', $lms_enquiry_id)
              ->update([
                     'lms_enquiry_first_name'=>$firstName,
                     'lms_enquiry_last_name'=>$lastName,
                     'lms_enquiry_mobile'=>$mobileNumber,
                     'lms_enquiry_email'=>$enquiryEmail,
                     'lms_enquiry_local_address'=>$enquiryCurrentAddress,
                     'lms_enquiry_permanent_address'=>$enquiryPermanentAddress,
                     'lms_enquiry_father_name'=>$enquiryFathersName,
                     'lms_enquiry_mother_name'=>$enquiryMothersName,
                     'lms_enquiry_gender'=>$enquiryGender,
                     'lms_enquiry_marital_status'=>$enquiryMaritalStatus,
                     'lms_enquiry_date_of_birth' => $enquiryDOB,
                     'lms_enquiry_date' => $enquiryDOJ,
                     'lms_enquiry_whatsapp_contact' => $whatsAppNumber,
                     'lms_enquiry_qualification' => $enquiryQualification == "null" ? null : $enquiryQualification,
                     'lms_enquiry_work_experience' => $enquiryWorkExp,
                      ]);
              } else {
                  // Email exists
                  $result_data['responseData'] = 3;
                
                  return $result_data;
              }
          } else {
              //Mobile no exist

              $result_data['responseData'] = 4;
              

              return $result_data;
          }

          DB::commit();
       
//course name and duration Fetch
  $child=DB::table('lms_child_course')
  ->select('lms_child_course.lms_child_course_name','lms_child_course.lms_child_course_duration')
  ->where('lms_child_course.lms_child_course_id',$childCourseId)->first();


          $result_data['responseData'] = 1;
          $result_data['studentCode'] = $studentCode;
          $result_data['registrationCode'] = $registrationCode;
          $result_data['appUrl'] = 'https://play.google.com/store/apps/details?id=com.forbit.futureorbit';
          $result_data['phoneNo'] = $mobileNumber;
          $result_data['password'] = $rand;
          $result_data['courseName'] =$child->lms_child_course_name;
          $result_data['courseDuration'] =$child->lms_child_course_duration;
          $result_data['whatsapp'] = $whatsAppNumber;
          return $result_data;
      } catch (Exception $ex) {

          DB::rollback();
       //   $result_data['responseData'] = $ex -> getMessage();
           $result_data['responseData'] = '2';
          return $result_data;
      }
  }
}
