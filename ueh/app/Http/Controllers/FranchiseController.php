<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\FranchiseModel;
use Illuminate\Http\Request;
use DB;
class FranchiseController extends Controller
{


    public  function getAllAppliedFranchiseList(Request $request)
    {

        $per_page = $request->per_page ? $request->per_page : 5;
        $sortBy = $request->sort_by;
        $orderBy = $request->order_by;
        $filterBy = $request->filter_by;
        return FranchiseModel::where('franchise_status', 0)
            ->orderBy($sortBy, $orderBy)
            ->where('franchise_applicant_name', 'like', "%$filterBy%")
            ->paginate($per_page);
    }
    public  function getAllRejectedFranchiseList(Request $request)
    {

        $per_page = $request->per_page ? $request->per_page : 5;
        $sortBy = $request->sort_by;
        $orderBy = $request->order_by;
        $filterBy = $request->filter_by;
        return FranchiseModel::where('franchise_status', 2)
            ->orderBy($sortBy, $orderBy)
            ->where('franchise_applicant_name', 'like', "%$filterBy%")
            ->paginate($per_page);
    }

    public  function getAllApprovedFranchiseList(Request $request)
    {

        $per_page = $request->per_page ? $request->per_page : 5;
        $sortBy = $request->sort_by;
        $orderBy = $request->order_by;
        $filterBy = $request->filter_by;
        $result=DB::table('ueh_franchise')
        ->join('ueh_user','ueh_franchise.user_id','=','ueh_user.user_id')
        ->join('ueh_state','ueh_state.state_id','=','ueh_franchise.state_id')
        ->leftJoin('ueh_ec_member','ueh_ec_member.ec_member_id','=','ueh_franchise.franchise_ec_member_code')
        ->where('ueh_franchise.franchise_status', '=', 1)
        ->select('ueh_user.user_profile_image','ueh_user.user_email_id',
       'ueh_user.user_status','ueh_state.state_name','ueh_franchise.franchise_id',
       'ueh_franchise.franchise_organisation_name','ueh_franchise.franchise_nature_of_business',
       'ueh_franchise.franchise_business_grade','ueh_franchise.franchise_current_student_strength',
       'ueh_franchise.franchise_applicant_name','ueh_franchise.franchise_dob',
       'ueh_franchise.franchise_age','ueh_franchise.franchise_mobile',
    'ueh_franchise.franchise_caste','ueh_franchise.franchise_educational_qualification','ueh_franchise.franchise_address',
    'ueh_franchise.state_id',
    'ueh_franchise.franchise_pin','ueh_franchise.franchise_document_pan',
    'ueh_franchise.franchise_document_aadhar','ueh_franchise.franchise_document_trade_license',
    'ueh_franchise.franchise_document_voter_card','ueh_franchise.franchise_code',
    'ueh_franchise.franchise_ec_member_code',
    'ueh_franchise.franchise_valid_till','ueh_franchise.franchise_application_number',
    'ueh_franchise.franchise_approved_rejected_date',
    'ueh_franchise.franchise_approved_rejected_remarks','ueh_franchise.franchise_applied_date','ueh_franchise.user_id','ueh_franchise.franchise_information_source','ueh_franchise.franchise_type_id','franchise_approved_rejected_by',
    'ueh_franchise.franchise_status','ueh_ec_member.ec_member_applicant_name')
        ->orderBy('ueh_franchise'.'.'.$sortBy, $orderBy)
            ->where('ueh_franchise.franchise_applicant_name', 'like', "%$filterBy%")
        ->paginate($per_page);
        return $result;
    }


   public function approveRejectAppliedFranchise(Request $request)
   {
    $clickedFranchiseId=$request->clickedFranchiseId;
    $approveRejectStatus=$request->approveRejectStatus;
    $approveRejectBy=$request->approveRejectBy;
    $clickedFranchiseMobileNumber=$request->clickedFranchiseMobileNumber;
    $clickedFranchiseDOB=$request->clickedFranchiseDOB;
    $clickedFranchiseName=$request->clickedFranchiseName;
    $approveRejectRemarks=$request->approveRejectRemarks;

    $result=FranchiseModel::approveRejectAppliedFranchise($clickedFranchiseId,
    $approveRejectStatus,$approveRejectBy,$clickedFranchiseMobileNumber,$clickedFranchiseDOB,
$clickedFranchiseName,$approveRejectRemarks);

    return response()->json($result);

   }


    public function getAllECMemberListNotAssignedtoFranchise(Request $request)
    {
        $franchiseId=$request->franchiseId;
        $result=FranchiseModel::getAllECMemberListNotAssignedtoFranchise($franchiseId);
        return response()->json($result);
    }

    public function assignECMemberToFranchise(Request $request)
    {
        $franchiseId=$request->franchiseId;
        $ecMemberId=$request->ecMemberId;

        $result=FranchiseModel::assignECMemberToFranchise($franchiseId,
        $ecMemberId);

        return response()->json($result);
    }

    public  function getApprovedFranchiseIdName(Request $request)
    {


        $result=DB::table('ueh_franchise')

        ->where('ueh_franchise.franchise_status', '=', 1)
        ->select('ueh_franchise.franchise_id',
       'ueh_franchise.franchise_applicant_name')

        ->paginate();
        return $result;
    }


}
