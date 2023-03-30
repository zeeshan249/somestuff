<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\PrefixModel;

class PrefixController extends Controller
{
    public function __construct()
    {
    }
    // Check Prefix in DB and then Save
    public function savePrefix(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'prefixName' => ['bail', 'required', 'regex:/^[a-zA-Z ]+$/', 'max:2'],
        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $prefixName = trim(strtoupper($request->prefixName));
            $prefixSettingId = $request->prefixSettingId;
            $loggedUserId = $request->loggedUserId;
            $result = PrefixModel::savePrefix(
                $centerId,
                $prefixName,
                $prefixSettingId,
                $loggedUserId
            );
            return response()->json($result);
        }
    }

    //Get the Prefix
    public function getAllPrefix(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $sortBy = $request->sortBy;
        $orderBy = $request->orderBy;
        $getData = DB::table("lms_prefix_setting")->select([
            'lms_prefix_setting_id', 'lms_prefix_module_name',
            'lms_prefix',
            'lms_prefix_pattern', DB::raw("IF(lms_prefix_is_active = 1, 'Active','Inactive')as lms_prefix_is_active")
        ])
            ->where('lms_center_id', $centerId)
            ->orderBy($sortBy, $orderBy)
            ->paginate($perPage);
        return $getData;
    }

    //Get the Prefix Module wise
    public function getPrefixModuleWise(Request $request)
    {
        $prefixModuleName = urldecode($request->prefixModuleName);
        $centerId = $request->centerId;
        $getQuery = DB::table("lms_prefix_setting")->select([
            'lms_prefix_setting_id', 'lms_prefix_pattern',
            'lms_prefix', 'lms_is_prefix_assigned'
        ])
            ->where('lms_center_id', $centerId)
            ->where('lms_prefix_module_name', $prefixModuleName)
            ->get();
        return $getQuery;
    }
}
