<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use App\DepartmentModel;
class DepartmentController extends Controller
{
    public function __construct()
    {

    }
    // Check Department in DB and then Save
    public function saveDepartment(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'departmentName' => ['bail', 'required', 'regex:/^[a-zA-Z ]+$/'],
        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $departmentName = trim($request->departmentName);
            $isSaveEditClicked = $request->isSaveEditClicked;
            $departmentId = $request->departmentId;
            $loggedUserId = $request->loggedUserId;
            $result=DepartmentModel::saveDepartment($centerId,
            $departmentName,$isSaveEditClicked,$departmentId,$loggedUserId);
            return response()->json($result);

        }

    }

    //Get the Department
    public function getAllDepartments(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 15;
        $getData = DB::table("lms_department")->
            select(['lms_department_id', 'lms_department_name', DB::raw("IF(lms_department_is_active = 1, 'Active','Inactive')as lms_department_is_active")])
            ->
            where('lms_center_id', $centerId)
            ->paginate($perPage);
        return $getData;
    }
    //Update Department
    public function updateDepartment(Request $request)
    {
        $centerId = $request->centerId;
        $departmentName = $request->departmentName;
        $departmentId = $request->departmentId;
        $isDepartmentActive = $request->isDepartmentActive;
        $loggedUserId = $request->loggedUserId;
        $result=DepartmentModel::updateDepartment($centerId,
        $departmentName,$departmentId,$isDepartmentActive,$loggedUserId);
        return response()->json($result);

    }

     //Get All Active Department without pagination
     public function getActiveDepartmentWithoutPagination(Request $request)
     {
         $centerId = $request->centerId;

         $getQuery= DB::table("lms_department")->
             select(['lms_department_id', 'lms_department_name'])
             ->where('lms_department_is_active', 1)
             ->where('lms_center_id', $centerId)
             ->get();
             return $getQuery;

     }



}
