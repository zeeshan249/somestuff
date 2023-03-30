<?php

namespace App\Http\Controllers;

use App\SchoolModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    public function __construct()
    {

    }
    // Check Information Source in DB and then Save
    public function saveUpdateSchool(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'loggedUserId' => 'bail | required |numeric ',
            'SchoolName' => ['bail', 'required', 'regex:/^[a-zA-Z ]+$/'],

        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;
            $SchoolName = trim($request->SchoolName);
            $isSaveEditClicked = $request->isSaveEditClicked;
            $SchoolId = $request->editSchoolId;

            $result = SchoolModel::saveUpdateSchool($centerId,
                $loggedUserId, $SchoolName, $isSaveEditClicked, $SchoolId);

            return response()->json($result);

        }

    }

    //Get the Information Source
    public function getAllSchool(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 100;
        $getData = DB::table("lms_school_list")->
            select(['lms_school_id', 'lms_school_name',
            DB::raw("IF(is_lms_school_active = 1, 'Active','Inactive')as is_lms_school_active")])
            ->
        where('lms_center_id', $centerId)
            ->paginate($perPage);
        return $getData;
    }
    //Enable Disable Information Source
    public function enableDisableSchool(Request $request)
    {
        $centerId = $request->centerId;
        $SchoolId = $request->SchoolId;
        $isSchoolActive = $request->isSchoolActive;
        $loggedUserId = $request->loggedUserId;
        $result = SchoolModel::enableDisableSchool($centerId,
            $SchoolId, $isSchoolActive, $loggedUserId);
        return response()->json($result);

    }

    //Get All Active Information Source without pagination
    public function getActiveSchoolWithoutPagination(Request $request)
    {
        $centerId = $request->centerId;

        $getQuery = DB::table("lms_information_source")->
            select(['lms_information_source_id', 'lms_information_source_name'])
            ->where('is_lms_information_source_active', 1)
            ->where('lms_center_id', $centerId)
            ->get();
        return $getQuery;

    }

}
