<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DesignationModel;
class DesignationController extends Controller
{
    public function __construct()
    {

    }
    // Check Designation in DB and then Save
    public function saveDesignation(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'designationName' => ['bail', 'required', 'regex:/^[a-zA-Z ]+$/'],
        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $designationName = trim($request->designationName);
            $isSaveEditClicked = $request->isSaveEditClicked;
            $designationId = $request->designationId;
            $loggedUserId = $request->loggedUserId;
            $result=DesignationModel::saveDesignation($centerId,
            $designationName,$isSaveEditClicked,$designationId,$loggedUserId);
            return response()->json($result);

        }

    }

    //Get the Designation
    public function getAllDesignations(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 15;
        $getData = DB::table("lms_designation")->
            select(['lms_designation_id', 'lms_designation_name', DB::raw("IF(lms_designation_is_active = 1, 'Active','Inactive')as lms_designation_is_active")])
            ->
            where('lms_center_id', $centerId)
            ->paginate($perPage);
        return $getData;
    }
    //Update Designation
    public function updateDesignation(Request $request)
    {
        $centerId = $request->centerId;
        $designationName = $request->designationName;
        $designationId = $request->designationId;
        $isDesignationActive = $request->isDesignationActive;
        $loggedUserId = $request->loggedUserId;
        $result=DesignationModel::updateDesignation($centerId,
        $designationName,$designationId,$isDesignationActive,$loggedUserId);
        return response()->json($result);

    }

     //Get All Active Designation without pagination
     public function getActiveDesignationWithoutPagination(Request $request)
     {
         $centerId = $request->centerId;

         $getQuery= DB::table("lms_designation")->
             select(['lms_designation_id', 'lms_designation_name'])
             ->where('lms_designation_is_active', 1)
             ->where('lms_center_id', $centerId)
             ->get();
             return $getQuery;

     }

}
