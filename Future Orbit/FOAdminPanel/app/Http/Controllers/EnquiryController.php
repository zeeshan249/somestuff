<?php

namespace App\Http\Controllers;

use App\EnquiryModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    public function __construct()
    {
    }
    public function sendWhatsappMessageRegister(){
     
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
    public function getAllEnquiry(Request $request)
    {

        $perPage = $request->perPage ? $request->perPage : 15;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_enquiry')
            ->join('lms_information_source', 'lms_information_source.lms_information_source_id', '=', 'lms_enquiry.lms_information_source_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_enquiry.lms_course_id')
            ->join('lms_child_course', 'lms_enquiry.lms_child_course_id', '=', 'lms_child_course.lms_child_course_id')
            ->join('lms_school_list', 'lms_school_list.lms_school_id', '=', 'lms_enquiry.lms_school_id')

            ->where('lms_enquiry.lms_center_id', '=', $centerId)
            ->where('lms_enquiry.lms_enquiry_status', '=', 1)

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_enquiry.lms_enquiry_full_name', 'like', "%$filterBy%")
                    ->orWhere('lms_enquiry.lms_enquiry_code', 'like', "%$filterBy%")
                    ->orWhere('lms_information_source.lms_information_source_name', $filterBy);
            })

            ->select(
                'lms_enquiry.lms_enquiry_id',
                'lms_enquiry.lms_center_id',
                'lms_enquiry.lms_enquiry_handled_by',
                'lms_enquiry.lms_enquiry_code',
                'lms_enquiry.lms_enquiry_first_name',
                'lms_enquiry.lms_enquiry_last_name',
                'lms_enquiry.lms_enquiry_full_name',
                'lms_enquiry.lms_enquiry_father_name',
                'lms_enquiry.lms_enquiry_mother_name',
                'lms_enquiry.lms_enquiry_gender',
                'lms_enquiry.lms_enquiry_marital_status',
                'lms_enquiry.lms_enquiry_date_of_birth',
                'lms_enquiry.lms_enquiry_date_of_joining',

                'lms_enquiry.lms_enquiry_mobile',
                'lms_enquiry.lms_enquiry_whatsapp_contact',
                'lms_enquiry.lms_enquiry_email',
                'lms_enquiry.lms_enquiry_local_address',
                'lms_enquiry.lms_enquiry_permanent_address',
                'lms_enquiry.lms_enquiry_work_experience',
                'lms_enquiry.lms_enquiry_about',

                'lms_enquiry.lms_enquiry_qualification',
                'lms_enquiry.lms_enquiry_school_name',
                'lms_enquiry.lms_enquiry_remarks',
                'lms_enquiry.lms_information_source_id',
                DB::raw("date_format(lms_enquiry.lms_enquiry_created_at,'%d-%m-%y') as lms_enquiry_created_at"),

                'lms_course.lms_course_name',
                'lms_course.lms_course_id',
                'lms_child_course.lms_child_course_id',
                'lms_child_course.lms_child_course_name',

                'lms_school_list.lms_school_id',
                'lms_enquiry.lms_enquiry_class',
                'lms_enquiry.lms_enquiry_section',
                'lms_enquiry.lms_roll_no',

                DB::raw("
                        (case when lms_enquiry.lms_enquiry_status  = '4' then 'Closed'
                        when       lms_enquiry.lms_enquiry_status  = '3' then 'Mobile-R'
                        when       lms_enquiry.lms_enquiry_status  = '2' then 'Internal-R'
                        when       lms_enquiry.lms_enquiry_status  = '0' then 'Inactive'
                        ELSE 'Active' end) as 'lms_enquiry_status'"),

                DB::raw('lms_information_source.lms_information_source_name as source_name')
            )
            ->orderBy('lms_enquiry.lms_enquiry_code','desc')
            ->paginate($perPage);
        return $result;
    }

    // Enable Disable Enquiry
    public function enableDisableEnquiry(Request $request)
    {
        $centerId = $request->centerId;
        $lms_enquiry_id = $request->lms_enquiry_id;
        $lms_enquiry_status = $request->lms_enquiry_status;
        $loggedUserId = $request->loggedUserId;
        $result = EnquiryModel::enableDisableEnquiry(
            $centerId,
            $lms_enquiry_id,
            $lms_enquiry_status,
            $loggedUserId,
        );
        return response()->json($result);
    }

    public function updateStudentDetails(Request $request)
    {
        $lms_user_id = $request->lms_user_id;
        $centerId = $request->centerId;
        $lms_enquiry_id = $request->lms_enquiry_id;
        $loggedUserId = $request->loggedUserId;
        $lms_student_first_name = $request->lms_student_first_name;
        $lms_student_last_name = $request->lms_student_last_name;
        $lms_student_mobile_number = $request->lms_student_mobile_number;
        $lms_enquiry_local_address = $request->lms_enquiry_local_address;
        $lms_enquiry_date_of_birth = $request->lms_enquiry_date_of_birth;
        $lms_enquiry_father_name = $request->lms_enquiry_father_name;
        $lms_enquiry_mother_name = $request->lms_enquiry_mother_name;
        $lms_enquiry_gender = $request->lms_enquiry_gender;
        $lms_enquiry_marital_status = $request->lms_enquiry_marital_status;
        $lms_enquiry_whatsapp_contact = $request->lms_enquiry_whatsapp_contact;
        $lms_enquiry_qualification = $request->lms_enquiry_qualification;
        $lms_enquiry_email = $request->lms_enquiry_email;
        $lms_enquiry_permanent_address = $request->lms_enquiry_permanent_address;
        $lms_user_can_change_profile_image = $request->lms_user_can_change_profile_image;

        // if ($request->has('oldBookCoverImage')) {
        //     if (file_exists(storage_path('app/public/book_cover_images/' . $oldBookCoverImage))) {
        //         unlink(storage_path('app/public/book_cover_images/' . $oldBookCoverImage));
        //     }
        // }

        $result = EnquiryModel::updateStudentDetails(
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

        );
        return response()->json($result);
    }

    // Add/Edit Enquiry Basic Info
    public function saveEditEnquiryBasicInfo(Request $request)
    {
       
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            // Later on check nullable with numeric condition(presently removed from code)
            'centerId' => 'bail | required |numeric ',
            'enquiryId' => 'bail|sometimes|nullable ',
            'loggedUserId' => 'bail | required |numeric ',
            'enquiryUserId' => 'bail|sometimes|nullable ',
            'enquirySourceId' => 'bail | required |numeric ',
            'enquiryCourseId' => 'bail | sometimes|nullable ',
            'enquirySchoolId' => 'bail | sometimes|nullable ',
            'enquiryFirstName' => 'bail | required |alpha',
            'enquiryLastName' => 'bail | required |alpha',
            'enquiryFathersName' => 'bail | sometimes|nullable |regex:/^[\pL\s\-]+$/u',
            'enquiryMothersName' => 'bail | sometimes|nullable |regex:/^[\pL\s\-]+$/u',
            'enquiryGender' => 'bail | required |alpha ',
            'enquiryMaritalStatus' => 'bail | sometimes|nullable |alpha',
            'enquiryDOB' => 'bail | required |date ',
            'enquiryDOJ' => 'bail | sometimes |nullable|date ',
            'enquiryContactNumber' => 'bail | required |numeric|digits:10 ',
            'enquiryWhatsAppNumber' => 'bail | sometimes|nullable|digits:10 ',
            'enquiryEmail' => 'bail | required |email ',
            'enquiryProfileImage' => 'bail|sometimes|nullable|mimes:jpeg,jpg,png|max:1024 ',

        ]);
        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {
            $centerId = $request->centerId;
            $enquiryId = $request->enquiryId;
            $loggedUserId = $request->loggedUserId;
            $enquiryUserId = $request->enquiryUserId;
            $enquirySourceId = $request->enquirySourceId;
            $enquiryCourseId = $request->enquiryCourseId;
            $lms_child_course_id = $request->lms_child_course_id;

            $enquirySchoolId = $request->enquirySchoolId;
            $enquiryFirstName = $request->enquiryFirstName;
            $enquiryLastName = $request->enquiryLastName;
            $enquiryFathersName = $request->enquiryFathersName;
            $enquiryMothersName = $request->enquiryMothersName;
            $enquiryGender = $request->enquiryGender;
            $enquiryMaritalStatus = $request->enquiryMaritalStatus;
            $enquiryDOB = $request->enquiryDOB;
            $enquiryDOJ = $request->enquiryDOJ;
            $enquiryContactNumber = $request->enquiryContactNumber;
            $whatsAppNumber = $request->enquiryWhatsAppNumber;
            $enquiryEmail = $request->enquiryEmail;
            $enquiryCurrentAddress = $request->enquiryCurrentAddress;
            $enquiryPermanentAddress = $request->enquiryPermanentAddress;
            $enquiryQualification = $request->enquiryQualification;
            $enquiryWorkExp = $request->enquiryWorkExp;
            $enquiryAbout = $request->enquiryAbout;
            $isEnquiryBasicEdit = $request->isEnquiryBasicEdit;
            $lms_enquiry_class=$request->lms_enquiry_class;
            $lms_enquiry_section=$request->lms_enquiry_section;
            $lms_enquiry_roll_no=$request->lms_roll_no;

            $result = EnquiryModel::saveEditEnquiryBasicInfo(
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


            );
            return response()->json($result);
        }
    }


    // To register user
    public function registerUser(Request $request)
    {
      
        $courseId = $request->courseId;
        $centerId = $request->centerId;
        $firstName = $request->enquiryFirstName;
        $lastName = $request->enquiryLastName;
        $mobileNumber = $request->enquiryContactNumber;
        $password = $request->password;
        $loggedUserId = $request->enquiryUserId;
        $enquiryEmail = $request->enquiryEmail;
        $lms_enquiry_id = $request->enquiryId;
        $childCourseId = $request->lms_child_course_id;
	    $loggedUserId=$request->loggedUserId;
        $enquiryCurrentAddress = $request->enquiryCurrentAddress;
        $enquiryPermanentAddress = $request->enquiryPermanentAddress;
        $enquiryFathersName = $request->enquiryFathersName;
        $enquiryMothersName = $request->enquiryMothersName;
        $enquiryGender = $request->enquiryGender;
        $enquiryMaritalStatus = $request->enquiryMaritalStatus;
        $enquiryDOB = $request->enquiryDOB;
        $enquiryDOJ = $request->enquiryDOJ;
        $enquiryContactNumber = $request->enquiryContactNumber;
        $whatsAppNumber = $request->enquiryWhatsAppNumber;
        $enquiryQualification = $request->enquiryQualification;
        $enquiryWorkExp = $request->enquiryWorkExp;
     
         if ($request->hasFile('selectedProfilePicture')) {
            $file= $request->file('selectedProfilePicture');
            $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = 'public/user_profile_images';
            $request->file('selectedProfilePicture')->storeAs($destinationPath, $filename);
            $selectedImage= $filename;
        }
        else{
            $selectedImage= '';  
        }
   
       
        $result = EnquiryModel::registerUser(
            $centerId,
            $courseId,
            $firstName,
            $lastName,
            $mobileNumber,
            $password,
            $loggedUserId,
            $enquiryEmail,
            $lms_enquiry_id,
            $childCourseId,
		    $selectedImage,
            $enquiryCurrentAddress,
            $enquiryPermanentAddress,
            $enquiryFathersName,
            $enquiryMothersName,
            $enquiryGender,
            $enquiryMaritalStatus,
            $enquiryDOB,
            $enquiryDOJ,
            $whatsAppNumber,
            $enquiryQualification,
            $enquiryWorkExp,

        );
  
         return response()->json($result);
    }



    //Get All Registered Students - App
    public function getAllRegisteredStudents(Request $request)
    {

        $perPage = $request->perPage ? $request->perPage : 100;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_student')
            ->join('lms_user', 'lms_user.lms_user_id', '=', 'lms_student.lms_user_id')
            ->join('lms_enquiry', 'lms_enquiry.lms_enquiry_id', '=', 'lms_student.lms_enquiry_id')
            ->join('lms_student_course_mapping', 'lms_student.lms_student_id', '=', 'lms_student_course_mapping.lms_student_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_student_course_mapping.lms_course_id')
            ->join('lms_child_course', 'lms_student_course_mapping.lms_child_course_id', '=', 'lms_child_course.lms_child_course_id')
            ->leftjoin('lms_batch_details', 'lms_batch_details.lms_batch_id', '=', 'lms_student_course_mapping.lms_batch_id')

            ->where('lms_student.lms_center_id', '=', $centerId)
            ->where('lms_student_course_mapping.lms_student_registration_type',  '=', 3)

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_student.lms_student_full_name', 'like', "%$filterBy%")
                    ->orWhere('lms_batch_details.lms_batch_code', 'like', "%$filterBy%");
            })

            ->select(
                'lms_user.password_normal',
                'lms_user_can_change_profile_image',
                'lms_user.lms_user_id',
                DB::raw("date_format(lms_student_course_mapping.lms_batch_mapping_date,'%d-%m-%y') as lms_batch_mapping_date"),
                'lms_student_course_mapping.lms_registration_code',
                'lms_batch_details.lms_batch_id',
                'lms_student.lms_student_code',
                'lms_student.lms_student_id',
                'lms_student.lms_center_id',
                'lms_student.lms_student_first_name',
                'lms_student.lms_student_last_name',
                'lms_student.lms_student_full_name',
                'lms_student.lms_student_mobile_number',
                'lms_student_course_mapping.lms_registration_id',
                'lms_batch_details.lms_batch_name',
                'lms_batch_details.lms_batch_code',
                'lms_student.lms_student_profile_image',

                'lms_student_course_mapping.lms_registration_code',
                DB::raw("date_format(lms_student_course_mapping.lms_student_course_mapping_created_at,'%d-%m-%y %H:%i') as lms_student_course_mapping_created_at"),

                'lms_course.lms_course_name',
                'lms_child_course.lms_child_course_name',
                'lms_course.lms_course_id',

                //Enquiry Start
                'lms_enquiry.lms_enquiry_id',
                'lms_enquiry.lms_enquiry_code',
                'lms_enquiry.lms_enquiry_first_name',
                'lms_enquiry.lms_enquiry_last_name',
                'lms_enquiry.lms_enquiry_full_name',
                'lms_enquiry.lms_enquiry_father_name',
                'lms_enquiry.lms_enquiry_mother_name',
                'lms_enquiry.lms_enquiry_gender',
                'lms_enquiry.lms_enquiry_marital_status',
                'lms_enquiry.lms_enquiry_date_of_birth',
                'lms_enquiry.lms_enquiry_date_of_joining',

                'lms_enquiry.lms_enquiry_mobile',
                'lms_enquiry.lms_enquiry_whatsapp_contact',
                'lms_enquiry.lms_enquiry_email',
                'lms_enquiry.lms_enquiry_local_address',
                'lms_enquiry.lms_enquiry_permanent_address',
                'lms_enquiry.lms_enquiry_work_experience',
                'lms_enquiry.lms_enquiry_about',

                'lms_enquiry.lms_enquiry_qualification',
                'lms_enquiry.lms_enquiry_school_name',
                'lms_enquiry.lms_enquiry_remarks',
                'lms_enquiry.lms_information_source_id',
                //Enquiry End
                DB::raw("
                        (case when lms_student.lms_student_is_active  = '0' then 'Inactive'
                        when       lms_student.lms_student_is_active  = '1' then 'Active'
                        ELSE 'Default' end) as 'lms_student_is_active'"),




                DB::raw("
                        (case when lms_student_course_mapping.lms_student_registration_type  = '4' then 'Closed'
                        when       lms_student_course_mapping.lms_student_registration_type  = '1' then 'Online'
                        when       lms_student_course_mapping.lms_student_registration_type  = '2' then 'Internal'
                        when       lms_student_course_mapping.lms_student_registration_type  = '0' then 'Inactive'
                        ELSE 'APP' end) as 'lms_student_registration_type'")
            )
            ->orderBy('lms_student_course_mapping.lms_student_course_mapping_created_at', 'desc')





            ->paginate($perPage);
        return $result;
    }

    //Get All Registered Students- Batch
    public function getAllRegisteredStudentsBatch(Request $request)
    {

        $perPage = $request->per_page ? $request->perPage : 100;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_student')
            ->join('lms_user', 'lms_user.lms_user_id', '=', 'lms_student.lms_user_id')
            ->join('lms_enquiry', 'lms_enquiry.lms_enquiry_id', '=', 'lms_student.lms_enquiry_id')
            ->join('lms_student_course_mapping', 'lms_student.lms_student_id', '=', 'lms_student_course_mapping.lms_student_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_student_course_mapping.lms_course_id')
            ->join('lms_child_course', 'lms_student_course_mapping.lms_child_course_id', '=', 'lms_child_course.lms_child_course_id')
            ->leftjoin('lms_batch_details', 'lms_batch_details.lms_batch_id', '=', 'lms_student_course_mapping.lms_batch_id')

            ->where('lms_student.lms_center_id', '=', $centerId)
            ->where('lms_student_course_mapping.lms_batch_id',  '!=', null)

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_student.lms_student_full_name', 'like', "%$filterBy%")
                    ->orWhere('lms_batch_details.lms_batch_code', 'like', "%$filterBy%");
            })

            ->select(
                'lms_user.password_normal',
                'lms_user.lms_user_can_change_profile_image',
                'lms_user.lms_user_id',
                DB::raw("date_format(lms_student_course_mapping.lms_batch_mapping_date,'%d-%m-%y') as lms_batch_mapping_date"),
                'lms_student_course_mapping.lms_registration_code',
                'lms_batch_details.lms_batch_id',
                'lms_student.lms_student_code',

                'lms_student.lms_student_id',
                'lms_student.lms_center_id',
                'lms_student.lms_student_first_name',
                'lms_student.lms_student_last_name',
                'lms_student.lms_student_full_name',
                'lms_student.lms_student_mobile_number',

                'lms_batch_details.lms_batch_name',
                'lms_batch_details.lms_batch_code',
                'lms_student.lms_student_profile_image',



                'lms_student_course_mapping.lms_registration_code',
                DB::raw("date_format(lms_student_course_mapping.lms_student_course_mapping_created_at,'%d-%m-%y') as lms_student_course_mapping_created_at"),

                'lms_course.lms_course_name',
                'lms_child_course.lms_child_course_name',
                'lms_course.lms_course_id',

                //Enquiry Start
                'lms_enquiry.lms_enquiry_id',
                'lms_enquiry.lms_enquiry_code',
                'lms_enquiry.lms_enquiry_first_name',
                'lms_enquiry.lms_enquiry_last_name',
                'lms_enquiry.lms_enquiry_full_name',
                'lms_enquiry.lms_enquiry_father_name',
                'lms_enquiry.lms_enquiry_mother_name',
                'lms_enquiry.lms_enquiry_gender',
                'lms_enquiry.lms_enquiry_marital_status',
                'lms_enquiry.lms_enquiry_date_of_birth',
                'lms_enquiry.lms_enquiry_date_of_joining',

                'lms_enquiry.lms_enquiry_mobile',
                'lms_enquiry.lms_enquiry_whatsapp_contact',
                'lms_enquiry.lms_enquiry_email',
                'lms_enquiry.lms_enquiry_local_address',
                'lms_enquiry.lms_enquiry_permanent_address',
                'lms_enquiry.lms_enquiry_work_experience',
                'lms_enquiry.lms_enquiry_about',

                'lms_enquiry.lms_enquiry_qualification',
                'lms_enquiry.lms_enquiry_school_name',
                'lms_enquiry.lms_enquiry_remarks',
                'lms_enquiry.lms_information_source_id',
                //Enquiry End
                DB::raw("
                        (case when lms_student.lms_student_is_active  = '0' then 'Inactive'
                        when       lms_student.lms_student_is_active  = '1' then 'Active'
                        ELSE 'Default' end) as 'lms_student_is_active'"),




                DB::raw("
                        (case when lms_student_course_mapping.lms_student_registration_type  = '4' then 'Closed'
                        when       lms_student_course_mapping.lms_student_registration_type  = '1' then 'Online'
                        when       lms_student_course_mapping.lms_student_registration_type  = '2' then 'Internal'
                        when       lms_student_course_mapping.lms_student_registration_type  = '0' then 'Inactive'
                        ELSE 'APP' end) as 'lms_student_registration_type'")
            )
            ->orderBy('lms_student_course_mapping.lms_student_course_mapping_created_at', 'desc')





            ->paginate($perPage);
        return $result;
    }

    //Get All Registered Students- Batch
    public function getAllRegisteredStudentsAll(Request $request)
    {

        $perPage = $request->perPage ? $request->perPage : 100;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_student')
            ->join('lms_user', 'lms_user.lms_user_id', '=', 'lms_student.lms_user_id')
            ->join('lms_enquiry', 'lms_enquiry.lms_enquiry_id', '=', 'lms_student.lms_enquiry_id')
            ->join('lms_student_course_mapping', 'lms_student.lms_student_id', '=', 'lms_student_course_mapping.lms_student_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_student_course_mapping.lms_course_id')
            ->join('lms_child_course', 'lms_student_course_mapping.lms_child_course_id', '=', 'lms_child_course.lms_child_course_id')
            ->leftjoin('lms_batch_details', 'lms_batch_details.lms_batch_id', '=', 'lms_student_course_mapping.lms_batch_id')

            ->where('lms_student.lms_center_id', '=', $centerId)

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_student.lms_student_full_name', 'like', "%$filterBy%")
                    ->orWhere('lms_batch_details.lms_batch_code', 'like', "%$filterBy%");
            })

            ->select(
                'lms_user.password_normal',
                'lms_user.lms_user_can_change_profile_image',
                'lms_user.lms_user_id',
                DB::raw("date_format(lms_student_course_mapping.lms_batch_mapping_date,'%d-%m-%y') as lms_batch_mapping_date"),
                'lms_student_course_mapping.lms_registration_code',
                'lms_batch_details.lms_batch_id',
                'lms_student.lms_student_code',
                'lms_student.lms_student_id',
                'lms_student.lms_center_id',
                'lms_student.lms_student_first_name',
                'lms_student.lms_student_last_name',
                'lms_student.lms_student_full_name',
                'lms_student.lms_student_mobile_number',
                'lms_student_course_mapping.lms_registration_id',
                'lms_batch_details.lms_batch_name',
                'lms_batch_details.lms_batch_code',
                'lms_student.lms_student_profile_image',

                'lms_student_course_mapping.lms_registration_code',
                DB::raw("date_format(lms_student_course_mapping.lms_student_course_mapping_created_at,'%d-%m-%y') as lms_student_course_mapping_created_at"),

                'lms_course.lms_course_name',
                'lms_child_course.lms_child_course_name',
                'lms_course.lms_course_id',

                //Enquiry Start
                'lms_enquiry.lms_enquiry_id',
                'lms_enquiry.lms_enquiry_code',
                'lms_enquiry.lms_enquiry_first_name',
                'lms_enquiry.lms_enquiry_last_name',
                'lms_enquiry.lms_enquiry_full_name',
                'lms_enquiry.lms_enquiry_father_name',
                'lms_enquiry.lms_enquiry_mother_name',
                'lms_enquiry.lms_enquiry_gender',
                'lms_enquiry.lms_enquiry_marital_status',
                'lms_enquiry.lms_enquiry_date_of_birth',
                'lms_enquiry.lms_enquiry_date_of_joining',

                'lms_enquiry.lms_enquiry_mobile',
                'lms_enquiry.lms_enquiry_whatsapp_contact',
                'lms_enquiry.lms_enquiry_email',
                'lms_enquiry.lms_enquiry_local_address',
                'lms_enquiry.lms_enquiry_permanent_address',
                'lms_enquiry.lms_enquiry_work_experience',
                'lms_enquiry.lms_enquiry_about',

                'lms_enquiry.lms_enquiry_qualification',
                'lms_enquiry.lms_enquiry_school_name',
                'lms_enquiry.lms_enquiry_remarks',
                'lms_enquiry.lms_information_source_id',
                //Enquiry End
                DB::raw("
                          (case when lms_student.lms_student_is_active  = '0' then 'Inactive'
                          when       lms_student.lms_student_is_active  = '1' then 'Active'
                          ELSE 'Default' end) as 'lms_student_is_active'"),




                DB::raw("
                          (case when lms_student_course_mapping.lms_student_registration_type  = '4' then 'Closed'
                          when       lms_student_course_mapping.lms_student_registration_type  = '1' then 'Online'
                          when       lms_student_course_mapping.lms_student_registration_type  = '2' then 'Internal'
                          when       lms_student_course_mapping.lms_student_registration_type  = '0' then 'Inactive'
                          ELSE 'APP' end) as 'lms_student_registration_type'")
            )
            ->orderBy('lms_student_course_mapping.lms_student_course_mapping_created_at', 'desc')





            ->paginate($perPage);
        return $result;
    }

    //Get All Registered Students- Internal
    public function getAllRegisteredStudentsInternal(Request $request)
    {

        $perPage = $request->per_page ? $request->perPage : 100;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_student')
            ->join('lms_user', 'lms_user.lms_user_id', '=', 'lms_student.lms_user_id')
            ->join('lms_enquiry', 'lms_enquiry.lms_enquiry_id', '=', 'lms_student.lms_enquiry_id')
            ->join('lms_student_course_mapping', 'lms_student.lms_student_id', '=', 'lms_student_course_mapping.lms_student_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_student_course_mapping.lms_course_id')
            ->join('lms_child_course', 'lms_student_course_mapping.lms_child_course_id', '=', 'lms_child_course.lms_child_course_id')
            ->leftjoin('lms_batch_details', 'lms_batch_details.lms_batch_id', '=', 'lms_student_course_mapping.lms_batch_id')

            ->where('lms_student.lms_center_id', '=', $centerId)
            ->where('lms_student_course_mapping.lms_student_registration_type',  '=', 2)

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_student.lms_student_full_name', 'like', "%$filterBy%")
                    ->orWhere('lms_batch_details.lms_batch_code', 'like', "%$filterBy%");
            })

            ->select(
                'lms_user.password_normal',
                'lms_user.lms_user_can_change_profile_image',
                'lms_user.lms_user_id',
                DB::raw("date_format(lms_student_course_mapping.lms_batch_mapping_date,'%d-%m-%y') as lms_batch_mapping_date"),
                'lms_student_course_mapping.lms_registration_code',
                'lms_batch_details.lms_batch_id',
                'lms_student.lms_student_code',
                'lms_student.lms_student_id',
                'lms_student.lms_center_id',
                'lms_student.lms_student_first_name',
                'lms_student.lms_student_last_name',
                'lms_student.lms_student_full_name',
                'lms_student.lms_student_mobile_number',
                'lms_student.lms_student_profile_image',

                'lms_batch_details.lms_batch_name',
                'lms_batch_details.lms_batch_code',

                'lms_student_course_mapping.lms_registration_code',
                DB::raw("date_format(lms_student_course_mapping.lms_student_course_mapping_created_at,'%d-%m-%y') as lms_student_course_mapping_created_at"),

                'lms_course.lms_course_name',
                'lms_child_course.lms_child_course_name',
                'lms_course.lms_course_id',

                //Enquiry Start
                'lms_enquiry.lms_enquiry_id',
                'lms_enquiry.lms_enquiry_code',
                'lms_enquiry.lms_enquiry_first_name',
                'lms_enquiry.lms_enquiry_last_name',
                'lms_enquiry.lms_enquiry_full_name',
                'lms_enquiry.lms_enquiry_father_name',
                'lms_enquiry.lms_enquiry_mother_name',
                'lms_enquiry.lms_enquiry_gender',
                'lms_enquiry.lms_enquiry_marital_status',
                'lms_enquiry.lms_enquiry_date_of_birth',
                'lms_enquiry.lms_enquiry_date_of_joining',

                'lms_enquiry.lms_enquiry_mobile',
                'lms_enquiry.lms_enquiry_whatsapp_contact',
                'lms_enquiry.lms_enquiry_email',
                'lms_enquiry.lms_enquiry_local_address',
                'lms_enquiry.lms_enquiry_permanent_address',
                'lms_enquiry.lms_enquiry_work_experience',
                'lms_enquiry.lms_enquiry_about',

                'lms_enquiry.lms_enquiry_qualification',
                'lms_enquiry.lms_enquiry_school_name',
                'lms_enquiry.lms_enquiry_remarks',
                'lms_enquiry.lms_information_source_id',
                //Enquiry End
                DB::raw("
                        (case when lms_student.lms_student_is_active  = '0' then 'Inactive'
                        when       lms_student.lms_student_is_active  = '1' then 'Active'
                        ELSE 'Default' end) as 'lms_student_is_active'"),




                DB::raw("
                        (case when lms_student_course_mapping.lms_student_registration_type  = '4' then 'Closed'
                        when       lms_student_course_mapping.lms_student_registration_type  = '1' then 'Online'
                        when       lms_student_course_mapping.lms_student_registration_type  = '2' then 'Internal'
                        when       lms_student_course_mapping.lms_student_registration_type  = '0' then 'Inactive'
                        ELSE 'APP' end) as 'lms_student_registration_type'")
            )
            ->orderBy('lms_student_course_mapping.lms_student_course_mapping_created_at', 'desc')





            ->paginate($perPage);
        return $result;
    }

    public function enquiryReport(Request $request){
        $perPage = $request->perPage ? $request->perPage : 15;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $startdate=$request->startDate;
        $enddate=$request->endDate;
        $status=$request->status;
        $result = DB::table('lms_enquiry')
            ->join('lms_information_source', 'lms_information_source.lms_information_source_id', '=', 'lms_enquiry.lms_information_source_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_enquiry.lms_course_id')
            ->join('lms_child_course', 'lms_enquiry.lms_child_course_id', '=', 'lms_child_course.lms_child_course_id')
            ->join('lms_school_list', 'lms_school_list.lms_school_id', '=', 'lms_enquiry.lms_school_id')

            ->where('lms_enquiry.lms_center_id', '=', $centerId)
         //   ->where('lms_enquiry.lms_enquiry_status', '=', 1)

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_enquiry.lms_enquiry_full_name', 'like', "%$filterBy%")
                    ->orWhere('lms_enquiry.lms_enquiry_code', 'like', "%$filterBy%")
                    ->orWhere('lms_information_source.lms_information_source_name', $filterBy);
            })
            ->where(function ($q) use ($status) {
                if($status != null){
                $q->where('lms_enquiry.lms_enquiry_status',$status);
                }
            })
            ->where(function ($q) use ($startdate, $enddate) {
                if ($startdate != null) {
                    $q
                        ->where('lms_enquiry.lms_enquiry_created_at', '>=', $startdate);
                }
                if ($enddate != null) {
                    $q
                        ->where('lms_enquiry.lms_enquiry_created_at', '<=', $enddate);
                }
            })
            ->select(
                'lms_enquiry.lms_enquiry_id',
                'lms_enquiry.lms_center_id',
                'lms_enquiry.lms_enquiry_handled_by',
                'lms_enquiry.lms_enquiry_code',
                'lms_enquiry.lms_enquiry_first_name',
                'lms_enquiry.lms_enquiry_last_name',
                'lms_enquiry.lms_enquiry_full_name',
                'lms_enquiry.lms_enquiry_father_name',
                'lms_enquiry.lms_enquiry_mother_name',
                'lms_enquiry.lms_enquiry_gender',
                'lms_enquiry.lms_enquiry_marital_status',
                'lms_enquiry.lms_enquiry_date_of_birth',
                'lms_enquiry.lms_enquiry_date_of_joining',

                'lms_enquiry.lms_enquiry_mobile',
                'lms_enquiry.lms_enquiry_whatsapp_contact',
                'lms_enquiry.lms_enquiry_email',
                'lms_enquiry.lms_enquiry_local_address',
                'lms_enquiry.lms_enquiry_permanent_address',
                'lms_enquiry.lms_enquiry_work_experience',
                'lms_enquiry.lms_enquiry_about',

                'lms_enquiry.lms_enquiry_qualification',
                'lms_enquiry.lms_enquiry_school_name',
                'lms_enquiry.lms_enquiry_remarks',
                'lms_enquiry.lms_information_source_id',
                DB::raw("date_format(lms_enquiry.lms_enquiry_created_at,'%d-%m-%y') as lms_enquiry_created_at"),

                'lms_course.lms_course_name',
                'lms_course.lms_course_id',
                'lms_child_course.lms_child_course_id',
                'lms_child_course.lms_child_course_name',

                'lms_school_list.lms_school_id',
                'lms_enquiry.lms_enquiry_class',
                'lms_enquiry.lms_enquiry_section',
                'lms_enquiry.lms_roll_no',

                DB::raw("
                        (case when lms_enquiry.lms_enquiry_status  = '4' then 'Closed'
                        when       lms_enquiry.lms_enquiry_status  = '3' then 'Mobile-R'
                        when       lms_enquiry.lms_enquiry_status  = '2' then 'Internal-R'
                        when       lms_enquiry.lms_enquiry_status  = '0' then 'Inactive'
                        ELSE 'Active' end) as 'lms_enquiry_status'"),

                DB::raw('lms_information_source.lms_information_source_name as source_name')
            )
            ->orderBy('lms_enquiry.lms_enquiry_code','desc')
            ->paginate($perPage);
        return $result;
    }

    public function registeredStudentsReport(Request $request){
        $perPage = $request->perPage ? $request->perPage : 100;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $startdate=$request->startDate;
        $enddate=$request->endDate;
        $status=$request->status;
        $result = DB::table('lms_student')
            ->join('lms_user', 'lms_user.lms_user_id', '=', 'lms_student.lms_user_id')
            ->join('lms_enquiry', 'lms_enquiry.lms_enquiry_id', '=', 'lms_student.lms_enquiry_id')
            ->join('lms_student_course_mapping', 'lms_student.lms_student_id', '=', 'lms_student_course_mapping.lms_student_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_student_course_mapping.lms_course_id')
            ->join('lms_child_course', 'lms_student_course_mapping.lms_child_course_id', '=', 'lms_child_course.lms_child_course_id')
            ->leftjoin('lms_batch_details', 'lms_batch_details.lms_batch_id', '=', 'lms_student_course_mapping.lms_batch_id')

            ->where('lms_student.lms_center_id', '=', $centerId)

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_student.lms_student_full_name', 'like', "%$filterBy%")
                    ->orWhere('lms_batch_details.lms_batch_code', 'like', "%$filterBy%");
            })
            ->where(function ($q) use ($status) {
                if($status != null){
                $q->where('lms_student.lms_student_is_active',$status);
                }
            })
            ->where(function ($q) use ($startdate, $enddate) {
                if ($startdate != null) {
                    $q
                        ->where('lms_student.lms_student_created_at', '>=', $startdate);
                }
                if ($enddate != null) {
                    $q
                        ->where('lms_student.lms_student_created_at', '<=', $enddate);
                }
            })
            ->select(
                'lms_user.lms_user_can_change_profile_image',
                'lms_user.lms_user_id',
                DB::raw("date_format(lms_student_course_mapping.lms_batch_mapping_date,'%d-%m-%y') as lms_batch_mapping_date"),
                'lms_student_course_mapping.lms_registration_code',
                'lms_batch_details.lms_batch_id',
                'lms_student.lms_student_code',
                'lms_student.lms_student_id',
                'lms_student.lms_center_id',
                'lms_student.lms_student_first_name',
                'lms_student.lms_student_last_name',
                'lms_student.lms_student_full_name',
                'lms_student.lms_student_mobile_number',
                'lms_student_course_mapping.lms_registration_id',
                'lms_batch_details.lms_batch_name',
                'lms_batch_details.lms_batch_code',
                'lms_student.lms_student_profile_image',

                'lms_student_course_mapping.lms_registration_code',
                DB::raw("date_format(lms_student.lms_student_created_at,'%d-%m-%y') as lms_student_created_at"),
                DB::raw("date_format(lms_student_course_mapping.lms_student_course_mapping_created_at,'%d-%m-%y') as lms_student_course_mapping_created_at"),

                'lms_course.lms_course_name',
                'lms_child_course.lms_child_course_name',
                'lms_course.lms_course_id',

                //Enquiry Start
                'lms_enquiry.lms_enquiry_id',
                'lms_enquiry.lms_enquiry_code',
                'lms_enquiry.lms_enquiry_first_name',
                'lms_enquiry.lms_enquiry_last_name',
                'lms_enquiry.lms_enquiry_full_name',
                'lms_enquiry.lms_enquiry_father_name',
                'lms_enquiry.lms_enquiry_mother_name',
                'lms_enquiry.lms_enquiry_gender',
                'lms_enquiry.lms_enquiry_marital_status',
                'lms_enquiry.lms_enquiry_date_of_birth',
                'lms_enquiry.lms_enquiry_date_of_joining',

                'lms_enquiry.lms_enquiry_mobile',
                'lms_enquiry.lms_enquiry_whatsapp_contact',
                'lms_enquiry.lms_enquiry_email',
                'lms_enquiry.lms_enquiry_local_address',
                'lms_enquiry.lms_enquiry_permanent_address',
                'lms_enquiry.lms_enquiry_work_experience',
                'lms_enquiry.lms_enquiry_about',

                'lms_enquiry.lms_enquiry_qualification',
                'lms_enquiry.lms_enquiry_school_name',
                'lms_enquiry.lms_enquiry_remarks',
                'lms_enquiry.lms_information_source_id',
                //Enquiry End
                DB::raw("
                          (case when lms_student.lms_student_is_active  = '0' then 'Inactive'
                          when       lms_student.lms_student_is_active  = '1' then 'Active'
                          ELSE 'Default' end) as 'lms_student_is_active'"),




                DB::raw("
                          (case when lms_student_course_mapping.lms_student_registration_type  = '4' then 'Closed'
                          when       lms_student_course_mapping.lms_student_registration_type  = '1' then 'Online'
                          when       lms_student_course_mapping.lms_student_registration_type  = '2' then 'Internal'
                          when       lms_student_course_mapping.lms_student_registration_type  = '0' then 'Inactive'
                          ELSE 'APP' end) as 'lms_student_registration_type'")
            )
            ->orderBy('lms_student_course_mapping.lms_student_course_mapping_created_at', 'desc')





            ->paginate($perPage);
        return $result;
    }
}
