<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class AppModel extends Model
{
    // To get about us page
    public function get_about_us()
    {
        $get_about_us_query =  DB::table('ueh_about_us')
            ->where('about_us_status', '=', 1)
            ->select()
            ->get();
        $get_about_us_query_result = $get_about_us_query->toArray();
        return $get_about_us_query_result;
    }


    // To get all course
    public function get_course()
    {
        $get_about_us_query =  DB::table('ueh_course')
            ->where('course_status', '=', 1)
            ->select()
            ->get();
        $get_course_query_result = $get_about_us_query->toArray();
        return $get_course_query_result;
    }

    // To get the gallery
    public function get_gallery($page_number, $item_to_load)
    {
        $page_number = $page_number;
        $item_to_load = $item_to_load;
        if ($page_number == 1) {
            $page_number = 0;
        } else {
            $page_number = $item_to_load * $page_number;
            $page_number = $page_number - $item_to_load;
        }

        $all_gallery_query =   DB::table('ueh_gallery')

            ->where('gallery_status', '=', 1)
            ->select()
            ->limit($item_to_load)
            ->offset($page_number)

            ->orderBy('gallery_id', 'desc')

            ->get();


        $data_response = array();
        if (count($all_gallery_query) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $all_gallery_query->toArray()));
            echo json_encode($data_response);
        }
    }


    // To get all state
    public function get_state()
    {
        $get_state_query =  DB::table('ueh_state')
            ->where('state_status', '=', 1)
            ->select()
            ->get();
        $get_state_query_result = $get_state_query->toArray();
        return $get_state_query_result;
    }

    // To get franchise type
    public function get_franchise_type()
    {
        $get_franchise_query =  DB::table('ueh_franchise_type')
            ->where('franchise_type_status', '=', 1)
            ->select()
            ->get();
        $get_franchise_query_result = $get_franchise_query->toArray();
        return $get_franchise_query_result;
    }


    //To insert  franchise details
    public function save_franchise_details(
        $business_nature,
        $applicant_name,
        $dob,
        $mobile_number,
        $qualification,
        $state,
        $address,
        $pin,
        $pan_image_name,
        $aadhar_image_name,
        $franchise_number,
        $franchise_type_id,
        $franchise_information_source,$referred_by_name
    ) {
        $save_franchise_query =  DB::table('ueh_franchise')->insertGetId(
            [
                'franchise_nature_of_business' => $business_nature,
                'franchise_applicant_name' => $applicant_name,
                'franchise_dob' => $dob,
                'franchise_mobile' => $mobile_number,
                'franchise_educational_qualification' => $qualification,
                'state_id' => $state,
                'franchise_address' => $address,
                'franchise_pin' => $pin,
                'franchise_document_pan' => $pan_image_name,
                'franchise_document_aadhar' => $aadhar_image_name,
                'franchise_application_number' => $franchise_number,
                'franchise_type_id' => $franchise_type_id,
                'franchise_information_source' => $franchise_information_source,
				'referred_by_name'=>$referred_by_name
            ]
        );
        if ($save_franchise_query > 0) {
            $save_data['Result'] = "success";
        } else {
            $save_data['Result'] = "fail";
            if (file_exists(storage_path('app/public/franchise_document_images/' . $pan_image_name))) {
                unlink(storage_path('app/public/franchise_document_images/' . $pan_image_name));
            }
            if (file_exists(storage_path('app/public/franchise_document_images/' . $aadhar_image_name))) {
                unlink(storage_path('app/public/franchise_document_images/' . $aadhar_image_name));
            }
        }
        return  $save_data;
    }



    // To get franchise type
    public function get_franchise_apply_details($mobile_number)
    {
        $get_franchise_details_query =  DB::table('ueh_franchise')
            ->join('ueh_franchise_type', 'ueh_franchise_type.franchise_type_id', '=', 'ueh_franchise.franchise_type_id')
            ->select([
                'ueh_franchise.franchise_application_number',
                DB::raw("DATE_FORMAT(ueh_franchise.franchise_applied_date, '%d-%m-%Y') as franchise_applied_date"),
                'ueh_franchise.franchise_status',
                'ueh_franchise.franchise_approved_rejected_remarks',
                DB::raw("DATE_FORMAT(ueh_franchise.franchise_approved_rejected_date, '%d-%m-%Y') as franchise_approved_rejected_date"),
                'ueh_franchise_type.franchise_type_name'
            ])
            ->where('ueh_franchise.franchise_mobile', $mobile_number)
            ->get();
        $get_franchise_details_query_result = $get_franchise_details_query->toArray();
        return $get_franchise_details_query_result;
    }

    public function check_user_active_status($mobile_number)
    {
        $check_user_active_status_query =  DB::table('ueh_user')

            ->where('ueh_user.user_mobile_number', '=', $mobile_number)
            ->select([
                'ueh_user.role_id', 'ueh_user.user_id', 'ueh_user.user_status'


            ])
            ->get();
        $check_user_active_status_query_result = $check_user_active_status_query->toArray();
        return $check_user_active_status_query_result;
    }

    public function get_user_details($user_id)
    {
        $check_user_active_status_query =  DB::table('ueh_user')

            ->where('ueh_user.user_id', '=', $user_id)
            ->select([
                'ueh_user.role_id',
                'ueh_user.user_profile_image',
                'ueh_user.user_email_id',
                'ueh_user.user_name',
                DB::raw("DATE_FORMAT(ueh_user.user_dob, '%d-%m-%Y') as user_dob"),
                'ueh_user.user_mobile_number',
                'ueh_user.user_id',
            ])
            ->get();
			
			if($check_user_active_status_query[0]->role_id=="1")
			{
				$check_login_query =  DB::table('ueh_user')
				  ->leftJoin('ueh_franchise', 'ueh_franchise.user_id', '=', 'ueh_user.user_id')
				   ->where('ueh_user.user_id', '=', $user_id)
                ->select([ 'ueh_user.role_id',
                'ueh_user.user_profile_image',
                'ueh_user.user_email_id',
                'ueh_user.user_name',
                DB::raw("DATE_FORMAT(ueh_user.user_dob, '%d-%m-%Y') as user_dob"),
                'ueh_user.user_mobile_number',
                'ueh_user.user_id','ueh_franchise.franchise_organisation_name',
				'ueh_franchise.franchise_address',
				'ueh_franchise.franchise_code',
				   DB::raw("DATE_FORMAT(ueh_franchise.franchise_valid_till, '%d-%m-%Y') as franchise_valid_till"),
		  DB::raw("DATE_FORMAT(ueh_franchise.franchise_approved_rejected_date, '%d-%m-%Y') as franchise_approved_rejected_date")])
				
                ->get();
            $check_login_query_result = $check_login_query->toArray();
         
            return $check_login_query_result;
			}
			else
			{
				 $check_user_active_status_query_result = $check_user_active_status_query->toArray();
        return $check_user_active_status_query_result;
			}
			
			
       
    }

    // To check the customer login
    public function check_login($mobile_number, $password, $device_token)
    {

        $get_bcrypt_password_query =  DB::table('ueh_user')
            ->where('ueh_user.user_mobile_number', '=', $mobile_number)
            ->select(['password'])
            ->first();
        $bcrypt_password = $get_bcrypt_password_query->password;
        if (password_verify($password, $bcrypt_password)) {
			
			
			
				$check_login_query =  DB::table('ueh_user')
                ->where('ueh_user.user_mobile_number', '=', $mobile_number)
                ->select(['user_id',  'role_id', 'user_profile_image'])
                ->get();
            $check_login_query_result = $check_login_query->toArray();
            $this->update_device_token($check_login_query_result[0]->user_id, $device_token);
            return $check_login_query_result;
			

            
        } else {
            return [];
        }
    }
    public function update_device_token($user_id, $device_token)
    {
        DB::table('ueh_user')
            ->where('user_id', $user_id)
            ->update(['user_device_token' => $device_token]);

        $update_data['Result'] = "success";

        return  $update_data;
    }

    //To remove profile image
    public function remove_profile_image($user_id, $fileName)
    {



        DB::table('ueh_user')
            ->where('user_id', $user_id)
            ->update(['user_profile_image' => 'default.jpg']);
        $update_data['Result'] = "success";
        if (file_exists(storage_path('app/public/user_profile_images/' . $fileName))) {
            unlink(storage_path('app/public/user_profile_images/' . $fileName));
        }

        return  $update_data;
    }



    //To update profile image
    public function update_profile_image($user_id, $fileName)
    {
        DB::table('ueh_user')
            ->where('user_id', $user_id)
            ->update(['user_profile_image' => $fileName]);
        $update_data['Result'] = "success";
        return  $update_data;
    }

    public function change_password($old_password, $new_password, $user_id)
    {
        $get_bcrypt_password_query =  DB::table('ueh_user')
            ->where('ueh_user.user_id', '=', $user_id)
            ->select(['password'])
            ->first();
        $bcrypt_password = $get_bcrypt_password_query->password;
        if (password_verify($old_password, $bcrypt_password)) {

            DB::table('ueh_user')
                ->where('user_id', $user_id)
                ->update(['password' => bcrypt($new_password)]);

            $update_data['Result'] = "success";
        } else {
            $update_data['Result'] = "wrong";
        }

        return  $update_data;
    }

    public function fetch_whats_new()
    {

        $daily_quiz_analysis_top_10_user_query =   DB::select("select * from mock_version_history
     where is_version_active=1");
        return  $daily_quiz_analysis_top_10_user_query;
    }



     public function get_last_10_franchise()
    {
        $check_user_active_status_query =  DB::table('ueh_franchise')
            ->join('ueh_user', 'ueh_user.user_id', '=', 'ueh_franchise.user_id')
            ->join('ueh_franchise_type', 'ueh_franchise_type.franchise_type_id', '=', 'ueh_franchise.franchise_type_id')
            ->where('franchise_status', '=', 1)
            ->select([
                'ueh_franchise.franchise_applicant_name',
                'ueh_franchise.franchise_organisation_name',
                'ueh_user.user_profile_image',
                'ueh_franchise.franchise_code',
                'ueh_franchise_type.franchise_type_name',
                DB::raw("DATE_FORMAT(ueh_franchise.franchise_approved_rejected_date,'%d-%m-%Y') as franchise_approved_rejected_date ")
            ])
            ->orderBy('ueh_franchise.franchise_id', 'desc')
            ->limit(10)
            ->get();
        $check_user_active_status_query_result = $check_user_active_status_query->toArray();
        return $check_user_active_status_query_result;
    }



    public function save_ec_member_details(
        $applicant_name,
        $dob,
        $mobile_number,
        $qualification,
        $state,
        $address,
        $pin,
        $pan_image_name,
        $aadhar_image_name,
        $ec_application_number,
        $ec_member_information_source,$referred_by_name
    ) {
        $save_franchise_query =  DB::table('ueh_ec_member')->insertGetId(
            [

                'ec_member_applicant_name' => $applicant_name,
                'ec_member_dob' => $dob,
                'ec_member_mobile' => $mobile_number,
                'ec_member_educational_qualification' => $qualification,
                'state_id' => $state,
                'ec_member_address' => $address,
                'ec_member_pin' => $pin,
                'ec_member_document_pan' => $pan_image_name,
                'ec_member_document_aadhar' => $aadhar_image_name,
                'ec_member_application_number' => $ec_application_number,
                'ec_member_information_source' => $ec_member_information_source,
				'referred_by_name'=>$referred_by_name
            ]
        );
        if ($save_franchise_query > 0) {
            $save_data['Result'] = "success";
        } else {
            $save_data['Result'] = "fail";
            if (file_exists(storage_path('app/public/ec_member_document_images/' . $pan_image_name))) {
                unlink(storage_path('app/public/ec_member_document_images/' . $pan_image_name));
            }
            if (file_exists(storage_path('app/public/ec_member_document_images/' . $aadhar_image_name))) {
                unlink(storage_path('app/public/ec_member_document_images/' . $aadhar_image_name));
            }
        }
        return  $save_data;
    }

    public function get_ec_member_apply_details($mobile_number)
    {
        $get_franchise_details_query =  DB::table('ueh_ec_member')

            ->select([
                'ueh_ec_member.ec_member_application_number',
                DB::raw("DATE_FORMAT(ueh_ec_member.ec_member_applied_date, '%d-%m-%Y') as ec_member_applied_date"),
                'ueh_ec_member.ec_member_status',
                'ueh_ec_member.ec_member_approved_rejected_remarks',
                DB::raw("DATE_FORMAT(ueh_ec_member.ec_member_approved_rejected_date, '%d-%m-%Y') as ec_member_approved_rejected_date"),
                'ueh_ec_member.ec_member_applicant_name'
            ])
            ->where('ueh_ec_member.ec_member_mobile', $mobile_number)
            ->get();
        $get_franchise_details_query_result = $get_franchise_details_query->toArray();
        return $get_franchise_details_query_result;
    }



    public function save_student_details(
        $student_name,
        $student_course,
        $dob,
        $mobile_number,
        $qualification,
        $state,
        $address,
        $pin,
        $student_profile_image_name,
        $student_information_source,
        $user_id,
        $role_id
    ) {

        $exception = DB::transaction(function () use (
            $student_name,
            $student_course,
            $dob,
            $mobile_number,
            $qualification,
            $state,
            $address,
            $pin,
            $student_profile_image_name,
            $student_information_source,
            $user_id,
            $role_id
        ) {

            $get_query =  DB::table('ueh_franchise')
                ->join('ueh_state', 'ueh_state.state_id', '=', 'ueh_franchise.state_id')
                ->select(['ueh_state.state_code', 'ueh_franchise.franchise_id'])
                ->where('ueh_franchise.user_id', $user_id)
                ->get();

            $student_code_prefix = "UEH/" . $get_query[0]->state_code . "/" . date('y') . "/S";
            $student_registration_code_prefix = "UEH/" . $get_query[0]->state_code . "/" . date('y') . "/R";
            $student_code = IdGenerator::generate([
                'table' => 'ueh_student', 'length' => 16, 'prefix' => $student_code_prefix, 'reset_on_prefix_change' => true, 'field' => 'student_code'
            ]);
            $student_registration_code = IdGenerator::generate([
                'table' => 'ueh_student', 'length' => 16, 'prefix' => $student_registration_code_prefix, 'reset_on_prefix_change' => true, 'field' => 'student_registration_code'
            ]);



            $query =   DB::table('ueh_student')->insertGetId(
                [

                    'student_name' => $student_name,
                    'course_id' => $student_course,
                    'student_dob' => $dob,
                    'student_mobile' => $mobile_number,
                    'student_educational_qualification' => $qualification,
                    'state_id' => $state,
                    'student_address' => $address,
                    'student_pin' => $pin,
                    'franchise_id' => $get_query[0]->franchise_id,
                    'student_information_source' => $student_information_source,
                    'student_code' => $student_code,
                    'student_registration_code' => $student_registration_code

                ]
            );


            $insert_query = DB::table('ueh_user')->insertGetId(
                [

                    'role_id' => 3,
                    'user_name' => $student_name,
                    'user_mobile_number' => $mobile_number,
                    'password' => bcrypt('1234'),
                    'user_profile_image' => $student_profile_image_name,
                    'user_dob' => $dob


                ]
            );
            DB::table('ueh_student')
                ->where('student_id',  $query)
                ->update(['user_id' => $insert_query]);
        });

        if (is_null($exception)) {
            $post_data['Result'] = "success";
        } else {
            $post_data['Result'] = "fail";
            if (file_exists(storage_path('app/public/user_profile_images/' . $student_profile_image_name))) {
                unlink(storage_path('app/public/user_profile_images/' . $student_profile_image_name));
            }
        }

        return  $post_data;
    }


    public function get_student_details_franchise_wise($user_id, $page_number, $item_to_load)
    {
        $page_number = $page_number;
        $item_to_load = $item_to_load;
        if ($page_number == 1) {
            $page_number = 0;
        } else {
            $page_number = $item_to_load * $page_number;
            $page_number = $page_number - $item_to_load;
        }
        $get_query =  DB::table('ueh_franchise')
            ->select(['ueh_franchise.franchise_id'])
            ->where('ueh_franchise.user_id', $user_id)
            ->get();
			
			

			if(count($get_query)>0)
			{
				 $all_gallery_query =   DB::table('ueh_student')
            ->join('ueh_user', 'ueh_user.user_id', '=', 'ueh_student.user_id')
            ->join('ueh_course', 'ueh_course.course_id', '=', 'ueh_student.course_id')
            ->where('ueh_student.franchise_id', '=',  $get_query[0]->franchise_id)
            ->where('ueh_student.student_status', '!=', 0)
            ->select([
                'ueh_student.student_name', 'ueh_student.student_mobile',
                'ueh_course.course_name', 'ueh_student.student_id', 'ueh_student.user_id',
                'ueh_user.user_profile_image', 'ueh_student.student_status', 'ueh_course.course_id'
            ])
            ->limit($item_to_load)
            ->offset($page_number)

            ->orderBy('ueh_student.student_id', 'desc')

            ->get();


        $data_response = array();
        if (count($all_gallery_query) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $all_gallery_query->toArray()));
            echo json_encode($data_response);
        }
			}
			else
			{
				  array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
			}
       
    }


    public function generate_student_certificate(
        $course_id,
        $student_id,
        $certificate_application_number,
        $user_id
    ) {
        $exception = DB::transaction(function () use (
            $course_id,
            $student_id,
            $certificate_application_number,
            $user_id
        ) {

            $get_query =  DB::table('ueh_franchise')
                ->select(['ueh_franchise.franchise_id'])
                ->where('ueh_franchise.user_id', $user_id)
                ->get();




            $query =   DB::table('ueh_certificate')->insertGetId(
                [

                    'course_id' => $course_id,
                    'student_id' => $student_id,
                    'franchise_id' =>  $get_query[0]->franchise_id,
                    'certificate_application_number' => $certificate_application_number

                ]
            );

            DB::table('ueh_student')
                ->where('student_id',  $student_id)
                ->update(['student_status' => 2]);
        });

        if (is_null($exception)) {
            $post_data['Result'] = "success";
        } else {
            $post_data['Result'] = "fail";
        }

        return  $post_data;
    }



    public function get_ec_member_list($page_number, $item_to_load)
    {
        $page_number = $page_number;
        $item_to_load = $item_to_load;
        if ($page_number == 1) {
            $page_number = 0;
        } else {
            $page_number = $item_to_load * $page_number;
            $page_number = $page_number - $item_to_load;
        }

        $all_gallery_query =   DB::table('ueh_ec_member')
            ->leftJoin('ueh_user', 'ueh_ec_member.user_id', '=', 'ueh_user.user_id')
            ->join('ueh_state', 'ueh_ec_member.state_id', '=', 'ueh_state.state_id')
            ->join(
                'ueh_franchise',
                'ueh_franchise.franchise_ec_member_code',
                '=',
                'ueh_ec_member.ec_member_id'
            )


            ->select([
                'ueh_ec_member.ec_member_applicant_name',
                'ueh_ec_member.ec_member_mobile',
                'ueh_ec_member.ec_member_status',
                'ueh_state.state_name',
                'ueh_ec_member.ec_member_id',
                DB::raw("DATE_FORMAT(ueh_ec_member.ec_member_approved_rejected_date, '%d-%m-%Y') as ec_member_approved_rejected_date"),
                'ueh_user.user_profile_image', DB::raw("(select count(ueh_franchise.franchise_ec_member_code) from ueh_ec_member where
            ueh_franchise.franchise_ec_member_code=ueh_ec_member.ec_member_id )
             as total_franchise_count")

            ])
            ->limit($item_to_load)
            ->offset($page_number)
            ->groupBy('ueh_franchise.franchise_ec_member_code')

            ->orderBy('ueh_ec_member.ec_member_id', 'desc')

            ->get();


        $data_response = array();
        if (count($all_gallery_query) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $all_gallery_query->toArray()));
            echo json_encode($data_response);
        }
    }




    public function get_franchise_list($ec_member_id,$page_number, $item_to_load,$is_ec_member,$user_id)
    {

        $page_number = $page_number;
        $item_to_load = $item_to_load;
        if ($page_number == 1) {
            $page_number = 0;
        } else {
            $page_number = $item_to_load * $page_number;
            $page_number = $page_number - $item_to_load;
        }
        $all_gallery_query = "";
        if($is_ec_member=="1" && $ec_member_id=="0")
        {
            $get_query =  DB::table('ueh_ec_member')
            ->select(['ueh_ec_member.ec_member_id'])
            ->where('ueh_ec_member.user_id', $user_id)
            ->get();
            $ec_member_id=$get_query[0]->ec_member_id;

        }
        if ($ec_member_id == "0") {
            $all_gallery_query =   DB::table('ueh_franchise')
                ->leftJoin('ueh_user', 'ueh_franchise.user_id', '=', 'ueh_user.user_id')
                ->join('ueh_state', 'ueh_franchise.state_id', '=', 'ueh_state.state_id')



                ->select([
                    'ueh_franchise.franchise_organisation_name',
                    'ueh_franchise.franchise_mobile',
                    'ueh_franchise.franchise_status',
                    'ueh_state.state_name',
                    'ueh_franchise.franchise_id',
                    'ueh_franchise.user_id',
                    DB::raw("DATE_FORMAT(ueh_franchise.franchise_approved_rejected_date, '%d-%m-%Y')
as franchise_approved_rejected_date"),
                    'ueh_user.user_profile_image'


                ])

                ->limit($item_to_load)
                ->offset($page_number)


                ->orderBy('ueh_franchise.franchise_id', 'desc')

                ->get();
        } else {
            $all_gallery_query =   DB::table('ueh_franchise')
                ->leftJoin('ueh_user', 'ueh_franchise.user_id', '=', 'ueh_user.user_id')
                ->join('ueh_state', 'ueh_franchise.state_id', '=', 'ueh_state.state_id')



                ->select([
                    'ueh_franchise.franchise_organisation_name',
                    'ueh_franchise.franchise_mobile',
                    'ueh_franchise.franchise_status',
                    'ueh_state.state_name',
                    'ueh_franchise.franchise_id',
                    'ueh_franchise.user_id',
                    DB::raw("DATE_FORMAT(ueh_franchise.franchise_approved_rejected_date, '%d-%m-%Y')
            as franchise_approved_rejected_date"),
                    'ueh_user.user_profile_image'


                ])
                ->where('ueh_franchise.franchise_ec_member_code', $ec_member_id)
                ->limit($item_to_load)
                ->offset($page_number)


                ->orderBy('ueh_franchise.franchise_id', 'desc')

                ->get();
        }

        $data_response = array();
        if (count($all_gallery_query) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $all_gallery_query->toArray()));
            echo json_encode($data_response);
        }
    }
	
	
	public function save_share_details($shared_by_name,
     $shared_by_mobile, $shared_to_name,$shared_to_mobile)
     {
        $save_franchise_query =  DB::table('link_sharing_details')->insertGetId(
            [
                'link_shared_by_mobile' => $shared_by_mobile,
                'link_shared_by_name' => $shared_by_name,
                'link_shared_to_mobile' => $shared_to_mobile,
                'link_shared_to_name' => $shared_to_name
             
            ]
        );
        if ($save_franchise_query > 0) {
            $save_data['Result'] = "success";
        } else {
            $save_data['Result'] = "fail";
          
        }
        return  $save_data;
    }
	
	
	//To insert  franchise details
    public function save_feedback(
        $role_id,
        $feedback_title,
        $feedback_description,
        $user_id
    ) {
        $save_franchise_query =  DB::table('ueh_feedback')->insertGetId(
            [
                'role_id' => $role_id,
                'user_id' => $user_id,
                'feedback_title' => $feedback_title,
                'feedback_description' => $feedback_description
            ]
        );
        if ($save_franchise_query > 0) {
            $save_data['Result'] = "success";
        } else {
            $save_data['Result'] = "fail";
           
        }
        return  $save_data;
    }

	
	
}
