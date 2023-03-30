<?php

namespace App\Http\Controllers;

use App\StaffModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use App\Mail\StaffDetailsMailable;

class StaffController extends Controller
{
    public function __construct()
    {
    }
    public function getAllStaff(Request $request)
    {

        $perPage = $request->perPage ? $request->perPage : 50;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $active = [];
        $includeDelete = $request->includeDelete;
        if ($includeDelete == "false") {
            $active = [1];
        } else {
            $active = [1, 0];
        }
        $result = DB::table('lms_staff')
            ->join('lms_user', 'lms_user.lms_user_id', '=', 'lms_staff.lms_user_id')
            ->join('model_has_roles', 'lms_user.lms_user_id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->leftJoin('lms_designation', 'lms_designation.lms_designation_id', '=', 'lms_staff.lms_designation_id')
            ->leftjoin('lms_department', 'lms_department.lms_department_id', '=', 'lms_staff.lms_department_id')
            ->where('lms_staff.lms_center_id', '=', $centerId)
            ->whereIn('lms_staff.lms_staff_is_active', $active)
            ->where(function ($q) use ($filterBy) {
                $q->where('lms_staff.lms_staff_full_name', 'like', "%$filterBy%")
                    ->orWhere('lms_staff.lms_staff_code', 'like', "%$filterBy%")
                    ->orWhere('roles.name', $filterBy);
            })

            ->select(
                'lms_staff.lms_staff_id',
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
                'model_has_roles.role_id',
                'lms_staff.lms_staff_first_name',
                'lms_staff.lms_staff_last_name',
                'lms_staff.lms_staff_full_name',
                'lms_user.lms_user_mobile',
                'lms_staff.lms_staff_mobile_number',
                'lms_staff.lms_staff_email',
                'lms_staff.lms_staff_profile_image',
                'lms_user.lms_user_device_token',
                'lms_user.lms_is_user_logged',
                DB::raw("IF(lms_staff.lms_staff_is_active = 1, 'Active','Inactive')as lms_staff_is_active"),
                DB::raw('roles.name as role_name'),
                'lms_designation.lms_designation_name',
                'lms_department.lms_department_name'
            )

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
        $result = StaffModel::enableDisableStaff(
            $centerId,
            $staffId,
            $isStaffActive,
            $loggedUserId,
            $staffUserId
        );
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
            'staffFathersName' => 'bail | sometimes|nullable |regex:/^[\pL\s\-]+$/u',
            'staffMothersName' => 'bail | sometimes|nullable |regex:/^[\pL\s\-]+$/u',
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
        } else {
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
            $staffProfileImageName = '';
            if ($request->has('staffProfileImage')) {
                // If profile image selected

                $staffProfileImageName = uniqid() . time() . '.' . $request->staffProfileImage->extension();
                $request->staffProfileImage->storeAs('public/user_profile_images', $staffProfileImageName);
                if ($request->staffProfileImage->isValid()) {
                    // Profile Image Upload Success
                    if ($isStaffBasicEdit == 1) {
                        // If staff edit is true


                        // If Staff is Editing delete the previous image
                        if ($staffProfileImageNameForEdit != '') {
                            if (file_exists(storage_path('app/public/user_profile_images/' . $staffProfileImageNameForEdit))) {
                                unlink(storage_path('app/public/user_profile_images/' . $staffProfileImageNameForEdit));
                            }
                        }
                        $staffProfileImageNameForEdit = $staffProfileImageName;
                    }
                    $result = StaffModel::saveEditStaffBasicInfo(
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
                    );

                    return response()->json($result);
                } else {
                    // Profile Image Upload Failed
                    return response()->json(['responseData' => 1]);
                }
            } else {

                $staffProfileImageName = $staffProfileImageNameForEdit;


                $result = StaffModel::saveEditStaffBasicInfo(
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
                );
                return response()->json($result);
            }
        }
    }

    // Edit Payroll info
    public function editStaffPayrollInfo(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            // Later on check nullable with numeric condition(presently removed from code)
            'centerId' => 'bail | required |numeric ',
            'staffId' => 'bail|sometimes|nullable ',
            'loggedUserId' => 'bail | required |numeric ',
            'staffEpfNo' => 'bail | sometimes|nullable ',
            'staffBasicSalary' => 'bail | sometimes|nullable ',
            'staffContractType' => 'bail | sometimes|nullable ',
            'staffWorkShift' => 'bail | sometimes|nullable ',
            'staffLocation' => 'bail | sometimes|nullable ',
        ]);
        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {
            $centerId = $request->centerId;
            $staffId = $request->staffId;
            $loggedUserId = $request->loggedUserId;

            $staffEpfNo = $request->staffEpfNo;
            $staffBasicSalary = $request->staffBasicSalary;
            $staffContractType = $request->staffContractType;
            $staffWorkShift = $request->staffWorkShift;
            $staffLocation = $request->staffLocation;

            $result = StaffModel::editStaffPayrollInfo(
                $centerId,
                $staffId,
                $loggedUserId,
                $staffEpfNo,
                $staffBasicSalary,
                $staffContractType,
                $staffWorkShift,
                $staffLocation
            );

            return response()->json($result);
        }
    }

    // Edit Payroll info
    public function editStaffBankDetailsInfo(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            // Later on check nullable with numeric condition(presently removed from code)
            'centerId' => 'bail | required |numeric ',
            'staffId' => 'bail|sometimes|nullable ',
            'loggedUserId' => 'bail | required |numeric ',
            'staffAccountTitle' => 'bail | sometimes|nullable ',
            'staffBankAccountNumber' => 'bail | sometimes|nullable ',
            'staffBank' => 'bail | sometimes|nullable ',
            'staffIfscCode' => 'bail | sometimes|nullable ',
            'staffBankBranch' => 'bail | sometimes|nullable ',
        ]);
        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {
            $centerId = $request->centerId;
            $staffId = $request->staffId;
            $loggedUserId = $request->loggedUserId;

            $staffAccountTitle = $request->staffAccountTitle;
            $staffBankAccountNumber = $request->staffBankAccountNumber;
            $staffBank = $request->staffBank;
            $staffIfscCode = $request->staffIfscCode;
            $staffBankBranch = $request->staffBankBranch;

            $result = StaffModel::editStaffBankDetailsInfo(
                $centerId,
                $staffId,
                $loggedUserId,
                $staffAccountTitle,
                $staffBankAccountNumber,
                $staffBank,
                $staffIfscCode,
                $staffBankBranch
            );

            return response()->json($result);
        }
    }

    // Edit Social info
    public function editStaffSocialLinkInfo(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            // Later on check nullable with numeric condition(presently removed from code)
            'centerId' => 'bail | required |numeric ',
            'staffId' => 'bail|sometimes|nullable ',
            'loggedUserId' => 'bail | required |numeric ',
            'staffWhatsApp' => 'bail | sometimes|nullable|digits:10',
            'staffFacebook' => 'bail | sometimes|nullable ',
            'staffTwitter' => 'bail | sometimes|nullable ',
            'staffLinkedin' => 'bail | sometimes|nullable ',
            'staffInstagram' => 'bail | sometimes|nullable ',
        ]);
        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {
            $centerId = $request->centerId;
            $staffId = $request->staffId;
            $loggedUserId = $request->loggedUserId;

            $staffWhatsApp = $request->staffWhatsApp;
            $staffFacebook = $request->staffFacebook;
            $staffTwitter = $request->staffTwitter;
            $staffLinkedin = $request->staffLinkedin;
            $staffInstagram = $request->staffInstagram;

            $result = StaffModel::editStaffSocialLinkInfo(
                $centerId,
                $staffId,
                $loggedUserId,
                $staffWhatsApp,
                $staffFacebook,
                $staffTwitter,
                $staffLinkedin,
                $staffInstagram
            );

            return response()->json($result);
        }
    }

    public function editStaffUploadDocumentInfo(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            // Later on check nullable with numeric condition(presently removed from code)
            'centerId' => 'bail | required |numeric ',
            'staffId' => 'bail|sometimes|nullable ',
            'loggedUserId' => 'bail | required |numeric ',

            'staffJoiningLetter' => 'bail|sometimes|nullable|mimes:jpeg,jpg,png,doc,docx,pdf|max:1024 ',
            'staffResume' => 'bail|sometimes|nullable|mimes:jpeg,jpg,png,doc,docx,pdf|max:1024 ',
            'staffResignationLetter' => 'bail|sometimes|nullable|mimes:jpeg,jpg,png,doc,docx,pdf|max:1024 ',
            'staffAadharCard' => 'bail|sometimes|nullable|mimes:jpeg,jpg,png,doc,docx,pdf|max:1024 ',
            'staffPanCard' => 'bail|sometimes|nullable|mimes:jpeg,jpg,png,doc,docx,pdf|max:1024 ',
            'staffVoterCard' => 'bail|sometimes|nullable|mimes:jpeg,jpg,png,doc,docx,pdf|max:1024 ',

        ]);
        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $staffId = $request->staffId;
            $loggedUserId = $request->loggedUserId;

            $staffJoiningLetterNameForEdit = $request->staffJoiningLetterNameForEdit;
            $staffResumeNameForEdit = $request->staffResumeNameForEdit;
            $staffResignationLetterNameForEdit = $request->staffResignationLetterNameForEdit;
            $staffAadharCardNameForEdit = $request->staffAadharCardNameForEdit;
            $staffPanCardNameForEdit = $request->staffPanCardNameForEdit;
            $staffVoterCardNameForEdit = $request->staffVoterCardNameForEdit;


            $staffJoiningLetterName = '';
            $staffResumeName = '';
            $staffResignationLetterName = '';
            $staffAadharCardName = '';
            $staffPanCardName = '';
            $staffVoterCardName = '';
            if ($request->has('staffJoiningLetter')) {


                $staffJoiningLetterName = uniqid() . time() . '.' . $request->staffJoiningLetter->extension();
                $request->staffJoiningLetter->storeAs('public/staff_documents', $staffJoiningLetterName);
                if ($request->staffJoiningLetter->isValid()) {
                    if ($staffJoiningLetterNameForEdit != '') {
                        if (file_exists(storage_path('app/public/staff_documents/' . $staffJoiningLetterNameForEdit))) {
                            unlink(storage_path('app/public/staff_documents/' . $staffJoiningLetterNameForEdit));
                        }
                    }
                } else {

                    return response()->json(['responseData' => 1]);
                }
            } else {
                $staffJoiningLetterName = $staffJoiningLetterNameForEdit;
            }



            if ($request->has('staffResume')) {


                $staffResumeName = uniqid() . time() . '.' . $request->staffResume->extension();
                $request->staffResume->storeAs('public/staff_documents', $staffResumeName);
                if ($request->staffResume->isValid()) {
                    if ($staffResumeNameForEdit != '') {
                        if (file_exists(storage_path('app/public/staff_documents/' . $staffResumeNameForEdit))) {
                            unlink(storage_path('app/public/staff_documents/' . $staffResumeNameForEdit));
                        }
                    }
                } else {

                    return response()->json(['responseData' => 2]);
                }
            } else {
                $staffResumeName = $staffResumeNameForEdit;
            }

            if ($request->has('staffResignationLetter')) {


                $staffResignationLetterName = uniqid() . time() . '.' . $request->staffResignationLetter->extension();
                $request->staffResignationLetter->storeAs('public/staff_documents', $staffResignationLetterName);
                if ($request->staffResignationLetter->isValid()) {
                    if ($staffResignationLetterNameForEdit != '') {
                        if (file_exists(storage_path('app/public/staff_documents/' . $staffResignationLetterNameForEdit))) {
                            unlink(storage_path('app/public/staff_documents/' . $staffResignationLetterNameForEdit));
                        }
                    }
                } else {

                    return response()->json(['responseData' => 3]);
                }
            } else {
                $staffResignationLetterName = $staffResignationLetterNameForEdit;
            }
        }


        if ($request->has('staffAadharCard')) {


            $staffAadharCardName = uniqid() . time() . '.' . $request->staffAadharCard->extension();
            $request->staffAadharCard->storeAs('public/staff_documents', $staffAadharCardName);
            if ($request->staffAadharCard->isValid()) {
                if ($staffAadharCardNameForEdit != '') {
                    if (file_exists(storage_path('app/public/staff_documents/' . $staffAadharCardNameForEdit))) {
                        unlink(storage_path('app/public/staff_documents/' . $staffAadharCardNameForEdit));
                    }
                }
            } else {

                return response()->json(['responseData' => 4]);
            }
        } else {
            $staffAadharCardName = $staffAadharCardNameForEdit;
        }

        if ($request->has('staffPanCard')) {


            $staffPanCardName = uniqid() . time() . '.' . $request->staffPanCard->extension();
            $request->staffPanCard->storeAs('public/staff_documents', $staffPanCardName);
            if ($request->staffPanCard->isValid()) {
                if ($staffPanCardNameForEdit != '') {
                    if (file_exists(storage_path('app/public/staff_documents/' . $staffPanCardNameForEdit))) {
                        unlink(storage_path('app/public/staff_documents/' . $staffPanCardNameForEdit));
                    }
                }
            } else {

                return response()->json(['responseData' => 5]);
            }
        } else {
            $staffPanCardName = $staffPanCardNameForEdit;
        }
        if ($request->has('staffVoterCard')) {


            $staffVoterCardName = uniqid() . time() . '.' . $request->staffVoterCard->extension();
            $request->staffVoterCard->storeAs('public/staff_documents', $staffVoterCardName);
            if ($request->staffVoterCard->isValid()) {
                if ($staffVoterCardNameForEdit != '') {
                    if (file_exists(storage_path('app/public/staff_documents/' . $staffVoterCardNameForEdit))) {
                        unlink(storage_path('app/public/staff_documents/' . $staffVoterCardNameForEdit));
                    }
                }
            } else {

                return response()->json(['responseData' => 6]);
            }
        } else {
            $staffVoterCardName = $staffVoterCardNameForEdit;
        }

        $result = StaffModel::editStaffUploadDocumentInfo(
            $centerId,
            $staffId,
            $loggedUserId,
            $staffJoiningLetterName,
            $staffResumeName,
            $staffResignationLetterName,
            $staffAadharCardName,
            $staffPanCardName,
            $staffVoterCardName
        );

        return response()->json($result);
    }

    public function getStaffDetailsIdWise(Request $request)
    {
        $staffUserId = $request->staffUserId;
        return DB::table('lms_staff')
            ->join('lms_user', 'lms_user.lms_user_id', '=', 'lms_staff.lms_user_id')
            ->join('model_has_roles', 'lms_user.lms_user_id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->leftJoin('lms_designation', 'lms_designation.lms_designation_id', '=', 'lms_staff.lms_designation_id')
            ->leftjoin('lms_department', 'lms_department.lms_department_id', '=', 'lms_staff.lms_department_id')
            ->where('lms_user.lms_user_id', '=', $staffUserId)


            ->select(
                'lms_staff.lms_staff_id',
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
                'model_has_roles.role_id',
                'lms_staff.lms_staff_first_name',
                'lms_staff.lms_staff_last_name',
                'lms_staff.lms_staff_full_name',
                'lms_staff.lms_staff_mobile_number',
                'lms_staff.lms_staff_email',
                'lms_staff.lms_staff_profile_image',
                'lms_user.lms_user_device_token',
                'lms_user.password_normal',
                'lms_user.lms_is_user_logged',
                DB::raw("IF(lms_staff.lms_staff_is_active = 1, 'Active','Inactive')as lms_staff_is_active"),
                DB::raw('roles.name as role_name'),
                DB::raw("DATE_FORMAT(lms_staff.lms_staff_created_at, '%d-%m-%Y')as lms_staff_created_at"),
                'lms_designation.lms_designation_name',
                'lms_department.lms_department_name'
            )->get();
    }


    public function getAllStaffWithoutPagination(Request $request)
    {
        $result = DB::table('lms_staff')
            ->join('lms_user', 'lms_user.lms_user_id', '=', 'lms_staff.lms_user_id')

            ->select(
                'lms_staff.lms_user_id',
                DB::raw('lms_staff.lms_staff_full_name as lms_full_name'),

            )->get();
        return $result;
    }

    public function sendMail(Request $request)
    {
        $centerId = $request->centerId;
        $staffPassword = $request->staffPassword;
        $staffContactNumber = $request->staffContactNumber;
        $staffEmail = $request->staffEmail;

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

    public function logggedInStatus(Request $request){
      
        try{
        $status=DB::table('lms_user')->where('lms_user_id','=',$request->staffUserId)
        ->update(['lms_is_user_logged'=>$request->status]);
        $result_data['responseData'] = 1;
        return $result_data;
        
        }
        catch(Exception $ex){
            
            $result_data['responseData'] = 2;
            return $result_data;
        }
        return $resultData;
    }
}
