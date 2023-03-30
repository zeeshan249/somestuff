<?php

namespace App\Http\Controllers;

use App\InformationSourceModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InformationSourceController extends Controller
{
    public function __construct()
    {

    }
    // Check Information Source in DB and then Save
    public function saveUpdateInformationSource(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'loggedUserId' => 'bail | required |numeric ',
            'informationSourceName' => ['bail', 'required', 'regex:/^[a-zA-Z ]+$/'],

        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;
            $informationSourceName = trim($request->informationSourceName);
            $isSaveEditClicked = $request->isSaveEditClicked;
            $informationSourceId = $request->informationSourceId;

            $result = InformationSourceModel::saveUpdateInformationSource($centerId,
                $loggedUserId, $informationSourceName, $isSaveEditClicked, $informationSourceId);

            return response()->json($result);

        }

    }

    //Get the Information Source
    public function getAllInformationSource(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 15;
        $getData = DB::table("lms_information_source")->
            select(['lms_information_source_id', 'lms_information_source_name',
            DB::raw("IF(is_lms_information_source_active = 1, 'Active','Inactive')as is_lms_information_source_active")])
            ->
        where('lms_center_id', $centerId)
            ->paginate($perPage);
        return $getData;
    }
    //Enable Disable Information Source
    public function enableDisableInformationSource(Request $request)
    {
        $centerId = $request->centerId;
        $informationSourceId = $request->informationSourceId;
        $isInformationSourceActive = $request->isInformationSourceActive;
        $loggedUserId = $request->loggedUserId;
        $result = InformationSourceModel::enableDisableInformationSource($centerId,
            $informationSourceId, $isInformationSourceActive, $loggedUserId);
        return response()->json($result);

    }

    //Get All Active Information Source without pagination
    public function getActiveInformationSourceWithoutPagination(Request $request)
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
