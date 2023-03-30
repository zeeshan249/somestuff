<?php

namespace App\Http\Controllers;

use App\StaffModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class StaffController extends Controller
{
    public function __construct()
    {

    }
    public function getAllStaff(Request $request)
    {

        $perPage = $request->per_page ? $request->perPage : 15;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_staff')
            ->join('lms_user', 'lms_user.lms_user_id', '=', 'lms_staff.lms_user_id')
            ->join('model_has_roles', 'lms_user.lms_user_id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->leftJoin('lms_designation', 'lms_designation.lms_designation_id', '=', 'lms_staff.lms_designation_id')
            ->leftjoin('lms_department', 'lms_department.lms_department_id', '=', 'lms_staff.lms_department_id')
            ->where('lms_staff.lms_center_id', '=', $centerId)
            ->where(function ($q) use ($filterBy) {
                $q->where('lms_user.lms_user_full_name', 'like', "%$filterBy%")
                    ->orWhere('lms_staff.lms_staff_code', 'like', "%$filterBy%")
                    ->orWhere('roles.name', $filterBy);
            })

            ->select('lms_staff.lms_staff_id',
                'lms_staff.lms_department_id',
                'lms_staff.lms_designation_id',
                'lms_staff.lms_user_id',
                'lms_staff.lms_staff_code',
                'lms_staff.lms_staff_qualification',
                'lms_staff.lms_staff_work_experience',
                'lms_staff.lms_staff_father_name',
                'lms_staff.lms_staff_mother_name',
                'lms_staff.lms_staff_emergency_contact',
                'lms_staff.lms_staff_date_of_birth',
                'lms_staff.lms_staff_marital_status',
                'lms_staff.lms_staff_date_of_joining',
                'lms_staff.lms_staff_date_of_leaving',
                'lms_staff.lms_staff_local_address',
                'lms_staff.lms_staff_permanent_address',
                'lms_staff.lms_staff_about',
                'lms_staff.lms_staff_gender',
                'lms_staff.lms_staff_account_title',
                'lms_staff.lms_staff_bank_account_number',
                'lms_staff.lms_staff_bank_name',
                'lms_staff.lms_staff_bank_ifsc_code',
                'lms_staff.lms_staff_bank_branch',
                'lms_staff.lms_staff_pay_scale',
                'lms_staff.lms_staff_basic_salary',
                'lms_staff.lms_staff_epf_number',
                'lms_staff.lms_staff_contract_type',
                'lms_staff.lms_staff_shift',
                'lms_staff.lms_staff_location',
                'lms_staff.lms_staff_whatsapp',
                'lms_staff.lms_staff_facebook',
                'lms_staff.lms_staff_twitter',
                'lms_staff.lms_staff_linkedin',
                'lms_staff.lms_staff_instagram',
                'lms_staff.lms_staff_resume_path',
                'lms_staff.lms_staff_joining_letter_path',
                'lms_staff.lms_staff_resignation_letter_path',
                'lms_staff.lms_staff_aadhar_path',
                'lms_staff.lms_staff_pan_path',
                'lms_staff.lms_staff_voter_card_path',
                'lms_staff.lms_staff_other_document_name',
                'lms_staff.lms_staff_other_document_path',
                'model_has_roles.role_id',
                'lms_user.lms_user_first_name',
                'lms_user.lms_user_last_name',
                'lms_user.lms_user_full_name',
                'lms_user.lms_user_mobile',
                'lms_user.lms_user_email',
                'lms_user.lms_user_profile_image',
                'lms_user.lms_user_device_token',
                DB::raw("IF(lms_staff.lms_staff_is_active = 1, 'Active','Inactive')as lms_staff_is_active"),
                DB::raw('roles.name as role_name'),
                'lms_designation.lms_designation_name',
                'lms_department.lms_department_name')

            ->paginate($perPage);
        return $result;
    }
// Enable Disable Staff
    public function enableDisableStaff(Request $request)
    {
        $centerId = $request->centerId;
        $staffId = $request->staffId;
        $isStaffActive = $request->isStaffActive;
        $loggedUserId = $request->loggedUserId;
        $staffUserId = $request->staffUserId;
        $result = StaffModel::enableDisableStaff($centerId,
            $staffId, $isStaffActive, $loggedUserId, $staffUserId);
        return response()->json($result);

    }

    // Add/Edit Staff Basic Info
    public function saveEditStaffBasicInfo(Request $request)
    {

        // Server side validation rules
        $validation = Validator::make($request->all(), [
            // Later on check nullable with numeric condition(presently removed from code)
            'centerId' => 'bail | required |numeric ',
            'staffId' => 'bail|sometimes|nullable ',
            'loggedUserId' => 'bail | required |numeric ',
            'staffUserId' => 'bail|sometimes|nullable ',
            'staffRoleId' => 'bail | required |numeric ',
            'staffDesignationId' => 'bail | sometimes|nullable ',
            'staffDepartmentId' => 'bail | sometimes|nullable ',
            'staffFirstName' => 'bail | required |alpha',
            'staffLastName' => 'bail | required |alpha',
            'staffFathersName' => 'bail | sometimes|nullable |alpha',
            'staffMothersName' => 'bail | sometimes|nullable |alpha',
            'staffGender' => 'bail | required |alpha ',
            'staffMaritalStatus' => 'bail | sometimes|nullable |alpha',
            'staffDOB' => 'bail | required |date ',
            'staffDOJ' => 'bail | sometimes |nullable|date ',
            'staffContactNumber' => 'bail | required |numeric|digits:10 ',
            'staffEmergencyContactNumber' => 'bail | sometimes|nullable|digits:10 ',
            'staffEmail' => 'bail | required |email ',
            'staffProfileImage' => 'bail|sometimes|nullable|mimes:jpeg,jpg,png|max:1024 ',


        ]);
        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        }
        else
        {
            $centerId = $request->centerId;
            $staffId = $request->staffId;
            $loggedUserId = $request->loggedUserId;
            $staffUserId = $request->staffUserId;
            $staffRoleId = $request->staffRoleId;
            $staffDesignationId = $request->staffDesignationId;
            $staffDepartmentId = $request->staffDepartmentId;
            $staffFirstName = $request->staffFirstName;
            $staffLastName = $request->staffLastName;
            $staffFathersName = $request->staffFathersName;
            $staffMothersName = $request->staffMothersName;
            $staffGender = $request->staffGender;
            $staffMaritalStatus = $request->staffMaritalStatus;
            $staffDOB = $request->staffDOB;
            $staffDOJ = $request->staffDOJ;
            $staffContactNumber = $request->staffContactNumber;
            $staffEmergencyContactNumber = $request->staffEmergencyContactNumber;
            $staffEmail = $request->staffEmail;
            $staffCurrentAddress = $request->staffCurrentAddress;
            $staffPermanentAddress = $request->staffPermanentAddress;
            $staffQualification = $request->staffQualification;
            $staffWorkExp = $request->staffWorkExp;
            $staffAbout = $request->staffAbout;
            $isStaffBasicEdit = $request->isStaffBasicEdit;
            $staffProfileImageNameForEdit = $request->staffProfileImageNameForEdit;
            $staffProfileImageName='';
            if($request->has('staffProfileImage'))
            {
                // If profile image selected

                $staffProfileImageName = uniqid() . time() . '.' . $request->staffProfileImage->extension();
                $request->staffProfileImage->storeAs('public/user_profile_images',  $staffProfileImageName );
                if ($request->staffProfileImage->isValid()) {
                    // Profile Image Upload Success
                    if($isStaffBasicEdit==1)
                    {
                        // If staff edit is true

                        // If Staff is Editing delete the previous image
                        if($staffProfileImageNameForEdit!='')
                        {
                        if (file_exists(storage_path('app/public/user_profile_images/' . $staffProfileImageNameForEdit))) {
                            unlink(storage_path('app/public/user_profile_images/' . $staffProfileImageNameForEdit));
                        }
                    }
                    }
                    $result = StaffModel::saveEditStaffBasicInfo($centerId,
                    $staffId, $loggedUserId, $staffUserId, $staffRoleId, $staffDesignationId,
                    $staffDepartmentId,$staffFirstName, $staffLastName, $staffFathersName,
                    $staffMothersName,$staffGender, $staffMaritalStatus, $staffDOB, $staffDOJ,
                     $staffContactNumber, $staffEmergencyContactNumber, $staffEmail,
                     $staffProfileImageName,$staffCurrentAddress, $staffPermanentAddress,
                     $staffQualification, $staffWorkExp, $staffAbout, $isStaffBasicEdit ,$staffProfileImageNameForEdit);

                     return response()->json($result);
                }
                 else
                 {
                        // Profile Image Upload Failed
                        return response()->json(['responseData' => 1]);
                }
            }
            else
            {
                // If profile image not selected
                if($isStaffBasicEdit==1)
                    {
                        // If staff edit is true

                        // If Staff is Editing delete the previous image
                        if($staffProfileImageNameForEdit!='')
                        {
                        if (file_exists(storage_path('app/public/user_profile_images/' . $staffProfileImageNameForEdit))) {
                            unlink(storage_path('app/public/user_profile_images/' . $staffProfileImageNameForEdit));
                        }
                    }
                }
                $result = StaffModel::saveEditStaffBasicInfo($centerId,
                $staffId, $loggedUserId, $staffUserId, $staffRoleId, $staffDesignationId,
                $staffDepartmentId,$staffFirstName, $staffLastName, $staffFathersName,
                $staffMothersName,$staffGender, $staffMaritalStatus, $staffDOB, $staffDOJ,
                 $staffContactNumber, $staffEmergencyContactNumber, $staffEmail,
                 $staffProfileImageName,$staffCurrentAddress, $staffPermanentAddress,
                 $staffQualification, $staffWorkExp, $staffAbout,$isStaffBasicEdit ,$staffProfileImageNameForEdit);
                 return response()->json( $result);
            }




        }



    }

}
