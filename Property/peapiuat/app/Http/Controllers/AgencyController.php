<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class AgencyController extends Controller
{
    public $Namex = "Agency";

    // get all user_skills
    public function Get(Request $request)
    {

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;

        $getQuery = DB::table("agency")->select(['*',
             DB::raw("IF(status = 'Active', 'Active','Inactive')as agent_skill_status")])
//            ->join('specialization','specialization.specialization_id','=','agency.specialization_id')
//            ->join('province','province.province_id','=','agency.province_id')
//            ->join('capability','capability.capability_id','=','agency.capability_id')
////
//            ->join('subdivisions','subdivisions.subdivision_id','=','agency.subdivision_id')
//            ->join('town','town.town_id','=','agency.town_id')
//            ->join('barangay','barangay.barangay_id','=','agency.barangay_id')



            ->where(function ($q) use ($filterBy) {
                  $q->orWhere('agency.agency_name', 'like', "%$filterBy%")
                    ->orWhere('agency.owner_name', 'like', "%$filterBy%")
                    ->orWhere('agency.email_address', 'like', "%$filterBy%")
                    ->orWhere('agency.phone_1', 'like', "%$filterBy%")
                    ->orWhere('agency.phone_2', 'like', "%$filterBy%");
            })
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);
        return response()->json(['resultData' => $getQuery], 200);
    }
    //save user_skills
    public function Save(Request $request)
    {


        $agency_name = $request->agency_name;
        $owner_name = $request->owner_name;
        $contact_person = $request->contact_person;
        $email_address= $request->email_address;
        $phone_1= $request->phone_1;
        $phone_2= $request->phone_2;
        $specialization_id= $request->specialization_id;
        $province_id= $request->province_id;
        $capability_id= $request->capability_id;
        $status= $request->status;
        $unit_number= $request->unit_number;
        $house_number= $request->house_number;
        $street_name= $request->street_name;
        $building_name= $request->building_name;
        $subdivision_id= $request->subdivision_id;
        $barangay_id= $request->barangay_id;
        $town_id= $request->town_id;
        $zip_code= $request->zip_code;
        $province_id= $request->province_id;
        $address_province_id= $request->address_province_id;
        $zip_code= $request->zip_code;
        $floor= $request->floor;
//        try {
            $agency= DB::table('agency')->where('agency_name', $agency_name)->count();
            if ( $agency>0) {
                return response()->json(['message' => 'Agency name already present please enter a new Agency Name '], 200);
            }
            $saveQuery = DB::table('agency')->insertGetId(
                [
                    'agency_name' => $request->agency_name,
                    'owner_name' => $request->owner_name,
                    'contact_person' => $request->contact_person,
                    'email_address' => $request->email_address,
                    'phone_1' => $request->phone_1,
                    'phone_2' => $request->phone_2,
                    'specialization_id' => $request->specialization_id,
                    'province_id' => $request->province_id,
                    'capability_id' => $request->capability_id,
                    'unit_number' => $request->unit_number,
                    'house_number' => $request->house_number,
                    'street_name' => $request->street_name,
                    'building_name' => $request->building_name,
                    'subdivision_id' => $request->subdivision_id,
                    'barangay_id' => $request->barangay_id,
                    'town_id' => $request->town_id,
                    'zip_code' => $request->zip_code,
                    'email_address_secondary'=>$request->email_address_secondary,
                    'address_province_id' => $request->address_province_id,
                    'floor' => $request->floor,
                    'created_by' => $request->created_by,

                ]
            );
            if ($saveQuery > 0) {
                return response()->json(['message' => $agency_name .'  agency added successfully'], 200);
            }
//        }
//        catch (Exception $ex) {
//
//            return response()->json(['message' => 'Something went wrong']);
//        }
    }

    //Update user_skills
    public function Update(Request $request)
    {


        $Id = $request->agency_id;
        $agency_name = $request->agency_name;
        $owner_name = $request->owner_name;
        $contact_person = $request->contact_person;
        $email_address= $request->email_address;
        $phone_1= $request->phone_1;
        $phone_2= $request->phone_2;
        $specialization_id= $request->specialization_id;
        $province_id= $request->province_id;
        $capability_id= $request->capability_id;
        $status= $request->status;
        $unit_number= $request->unit_number;
        $house_number= $request->house_number;
        $street_name= $request->street_name;
        $building_name= $request->building_name;
        $subdivision_id= $request->subdivision_id;
        $barangay_id= $request->barangay_id;
        $town_id= $request->town_id;
        $zip_code= $request->zip_code;
        $province_id= $request->province_id;
        $address_province_id= $request->address_province_id;
        $zip_code= $request->zip_code;
        $floor= $request->floor;
        $updateQuery = DB::table('agency')
            ->where('agency.agency_id', $Id)
            ->update([
                'agency_name' => $request->agency_name,
                'owner_name' => $request->owner_name,
                'contact_person' => $request->contact_person,
                'email_address' => $request->email_address,
                'phone_1' => $request->phone_1,
                'phone_2' => $request->phone_2,
                'specialization_id' => $request->specialization_id,
                'province_id' => $request->province_id,
                'capability_id' => $request->capability_id,
                'status' => $request->status,
                'unit_number' => $request->unit_number,
                'house_number' => $request->house_number,
                'street_name' => $request->street_name,
                'building_name' => $request->building_name,
                'subdivision_id' => $request->subdivision_id,
                'barangay_id' => $request->barangay_id,
                'town_id' => $request->town_id,
                'zip_code' => $request->zip_code,
                'email_address_secondary'=>$request->email_address_secondary,
                'address_province_id' => $request->address_province_id,
                'floor' => $request->floor,
                'created_by' => $request->created_by,
                'reason_for_inactive'=>$request->reason_for_inactive,

            ]);
        if ($updateQuery > 0) {

            return response()->json(['status'=>'true','message' =>  '  updated successfully'], 200);
        }
    }

    //Delete user_skills
    public function Delete(Request $request)
    {


        $deleteQuery = DB::table('agency')->where('agency.agency_id', $request->agency_id)->count();

        if ($deleteQuery>0) {

            return response()->json(['message' => 'Item deleted successfully'], 200);
        }
        else{
            return response()->json(['message' => 'invalid parameter'], 200);
        }
    }
    //web end

    // get all agency without pagination
    public function GetWithoutPagination(Request $request)
    {


        $getQuery = DB::table("agency")->select(['*',
          DB::raw("IF(status = 'Active', 'Active','Inactive')as agent_skill_status")])
//            ->join('specialization','specialization.specialization_id','=','agency.specialization_id')
//            ->join('province','province.province_id','=','agency.province_id')
//            ->join('capability','capability.capability_id','=','agency.capability_id')
////
//            ->join('subdivisions','subdivisions.subdivision_id','=','agency.subdivision_id')
//            ->join('town','town.town_id','=','agency.town_id')
//            ->join('barangay','barangay.barangay_id','=','agency.barangay_id')
            ->where('agency.agency_id',$request->agency_id)

            ->get();
        return response()->json(['resultData' => $getQuery], 200);
    }
    public function WithoutPagination(Request $request)
    {


        $id = $request->agency_id;
        $status = $request->status;
        $getQuery = DB::table("agency")->select(['*'])
            ->orderBy('agency_name');
        if (isset($id)) {
            $getQuery->where('agency_id', '=', $id);
            if (isset($status)) {
                $getQuery->where('status', '=', $status);
            } else {
                $getQuery->where('status', '=', 'Active');

            }
        } else {
            if (isset($status)) {
                $getQuery->where('status', '=', $status);
            } else {
                $getQuery->where('status', '=', 'Active');

            }
            $getQuery = $getQuery->get();
        return response()->json(['resultData' => $getQuery], 200);
    }
}
}
