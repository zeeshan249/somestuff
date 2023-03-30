<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ExecutiveModel;
use Illuminate\Http\Request;
use DB;
class ExecutiveController extends Controller
{


    public  function getAllAppliedExecutiveList(Request $request)
    {

        $per_page = $request->per_page ? $request->per_page : 5;
        $sortBy = $request->sort_by;
        $orderBy = $request->order_by;
        $filterBy = $request->filter_by;
        return ExecutiveModel::where('ec_member_status', 0)
            ->orderBy($sortBy, $orderBy)
            ->where('ec_member_applicant_name', 'like', "%$filterBy%")
            ->paginate($per_page);
    }
    public  function getAllRejectedExecutiveList(Request $request)
    {

        $per_page = $request->per_page ? $request->per_page : 5;
        $sortBy = $request->sort_by;
        $orderBy = $request->order_by;
        $filterBy = $request->filter_by;
        return ExecutiveModel::where('ec_member_status', 2)
            ->orderBy($sortBy, $orderBy)
            ->where('ec_member_applicant_name', 'like', "%$filterBy%")
            ->paginate($per_page);
    }

    public  function getAllApprovedExecutiveList(Request $request)
    {

        $per_page = $request->per_page ? $request->per_page : 5;
        $sortBy = $request->sort_by;
        $orderBy = $request->order_by;
        $filterBy = $request->filter_by;
        $result=DB::table('ueh_ec_member')
        ->join('ueh_user','ueh_ec_member.user_id','=','ueh_user.user_id')
        ->join('ueh_state','ueh_state.state_id','=','ueh_ec_member.state_id')
        ->where('ueh_ec_member.ec_member_status', '=', 1)
        ->select('ueh_user.user_profile_image',
        'ueh_user.user_email_id',
       'ueh_user.user_status',
       'ueh_state.state_name',
       'ueh_ec_member.ec_member_id',
       'ueh_ec_member.ec_member_applicant_name',
       'ueh_ec_member.ec_member_guardian_name',
       'ueh_ec_member.ec_member_nominee_name',
       'ueh_ec_member.ec_member_nominee_relation',
       'ueh_ec_member.ec_member_dob',
       'ueh_ec_member.ec_member_age',
       'ueh_ec_member.ec_member_mobile',
       'ueh_ec_member.ec_member_caste',
    'ueh_ec_member.ec_member_educational_qualification',
    'ueh_ec_member.ec_member_address',
    'ueh_ec_member.state_id',
    'ueh_ec_member.ec_member_pin',
    'ueh_ec_member.ec_member_account_number',
    'ueh_ec_member.ec_member_account_ifsc',
    'ueh_ec_member.ec_member_bank',
    'ueh_ec_member.ec_member_bank_branch',
    'ueh_ec_member.ec_member_document_pan',
    'ueh_ec_member.ec_member_document_aadhar',
    'ueh_ec_member.ec_member_document_voter_card',
    'ueh_ec_member.ec_member_code',
    'ueh_ec_member.ec_member_applied_date',
    'ueh_ec_member.ec_member_foundation_percentage',
    'ueh_ec_member.ec_member_certificate_percentage',
    'ueh_ec_member.ec_member_designated_location',
    'ueh_ec_member.ec_member_reference_name',
    'ueh_ec_member.ec_member_application_number',
    'ueh_ec_member.ec_member_approved_rejected_date',
    'ueh_ec_member.ec_member_approved_rejected_remarks',
    'ueh_ec_member.user_id',
    'ueh_ec_member.ec_member_information_source',
    'ueh_ec_member.ec_member_approved_rejected_by',
    'ueh_ec_member.ec_member_status')
        ->orderBy('ueh_ec_member'.'.'.$sortBy, $orderBy)
            ->where('ueh_ec_member.ec_member_applicant_name', 'like', "%$filterBy%")
        ->paginate($per_page);
        return $result;
    }


   public function approveRejectAppliedExecutive(Request $request)
   {
    $clickedFranchiseId=$request->clickedFranchiseId;
    $approveRejectStatus=$request->approveRejectStatus;
    $approveRejectBy=$request->approveRejectBy;
    $clickedFranchiseMobileNumber=$request->clickedFranchiseMobileNumber;
    $clickedFranchiseDOB=$request->clickedFranchiseDOB;
    $clickedFranchiseName=$request->clickedFranchiseName;
    $approveRejectRemarks=$request->approveRejectRemarks;

    $result=ExecutiveModel::approveRejectAppliedExecutive($clickedFranchiseId,
    $approveRejectStatus,$approveRejectBy,$clickedFranchiseMobileNumber,$clickedFranchiseDOB,
$clickedFranchiseName,$approveRejectRemarks);

    return response()->json($result);

   }
}
