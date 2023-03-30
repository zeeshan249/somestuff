<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Exception;


class BrokerAssociationController extends Controller
{
    public $Namex = "Broker";


    public function Get(Request $request)
    {
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;

        $getQuery = DB::table("broker_association")->select(['broker_association.broker_association_name',
            'broker_association.broker_association_id',
            'broker_association.contact_person',
            'broker_association.email_address',
            'broker_association.phone_1',
            'broker_association.phone_2',
            'broker_association.unit_number',
            'broker_association.house_number',
            'broker_association.street_name',
            'broker_association.building_name',
            'broker_association.subdivision_id',
            'broker_association.barangay_id',
            'broker_association.town_id',
            'broker_association.province_id',
            'broker_association.address_province_id',
            'broker_association.zip_code',
            'broker_association.floor',
            'broker_association.status',
            'broker_association.reason_for_inactive',
            DB::raw("IF(status = 'Active', 'Active','Inactive')as broker_association_status")])

//            ->join('province','province.province_id','=','broker_association.province_id')
//
//
//            ->join('subdivisions','subdivisions.subdivision_id','=','broker_association.subdivision_id')
//            ->join('town','town.town_id','=','broker_association.town_id')
//            ->join('barangay','barangay.barangay_id','=','broker_association.barangay_id')

//            ->where('broker_association.broker_association_name', 'like', '%' . $searchText . '%')
            ->where(function ($q) use ($filterBy) {
                $q->orWhere('broker_association.broker_association_name', 'like', "%$filterBy%")
                    ->orWhere('broker_association.email_address', 'like', "%$filterBy%")
                    ->orWhere('broker_association.phone_1', 'like', "%$filterBy%");

            })
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }

    public function Save(Request $request)
    {

//        try {
           $comp1 = DB::table('broker_association')->where('broker_association_name',$request->broker_association_name)
         ->count();
        if ($comp1 > 0) {
            return response()->json(['success' => 'true', 'message' => 'Broker Association Name already Exist'], 200);
        }
            $saveQuery = DB::table('broker_association')->insertGetId(
                [
                    'broker_association_name' => $request->broker_association_name??'',

                    'contact_person' => $request->contact_person??'',
                    'email_address' => $request->email_address??'',
                    'phone_1' => $request->phone_1??'',
                    'phone_2' => $request->phone_2??'',

                    'province_id' => $request->province_id??'',

                    'status' => "Inactive",
                    'unit_number' => $request->unit_number??'',
                    'house_number' => $request->house_number??'',
                    'street_name' => $request->street_name??'',
                    'building_name' => $request->building_name??'',
                    'subdivision_id' => $request->subdivision_id??'',
                    'barangay_id' => $request->barangay_id??'',
                    'town_id' => $request->town_id??'',
                    'zip_code' => $request->zip_code??'',
                    'capability_id'=>$request->capability_id??'',
                    'address_province_id'=>$request->address_province_id??'',
                    'floor' => $request->floor??'',
                    'created_by' => $request->created_by??''

                ]
            );
            if ($saveQuery > 0) {
                return response()->json(['message' => $request->broker_association_name .' broker association added successfully'], 200);
            }
//        }
//        catch (Exception $ex) {
//
//            return response()->json(['message' => 'Something went wrong']);
//        }
    }


    public function  getBrokerAssociationById(Request  $request){
        $getQuery=DB::table('broker_association')->select('*')
            ->where('broker_association.broker_association_id',$request->broker_association_id)
            ->get();
            return response()->json(['resultData' => $getQuery], 200);
    }

    public function Update(Request $request)
    {
       //->leftJoin('subdivisions as adjSub', DB::raw("FIND_IN_SET(adjSub.subdivision_id,t1.adjacent_subdivision)"), ">", \DB::raw("'0'"))
        //->groupBy('t1.subdivision_id')

           $status=$request->status;
           $broker_association_id=$request->broker_association_id;

        if($status=="Inactive"){
        $check = DB::table('broker')->select('broker.broker_id','broker.broker_name')
        ->whereRaw("FIND_IN_SET($broker_association_id,broker.broker_association_id)")
            
        ->orderBy('broker.broker_id', 'desc')
        ->count();
        if($check>0){
            return response()->json(['success'=>'true','message' =>  'Broker Cannot be deactived since its associated with one or more broker associations'], 200);
        }
        }
        
      
 

               $updateQuery1 = DB::table('broker_association')
                   ->where('broker_association.broker_association_id', $request->broker_association_id)
                   ->update([
                       'broker_association_name' => $request->broker_association_name,
                       'contact_person' => $request->contact_person,
                       'email_address' => $request->email_address,
                       'phone_1' => $request->phone_1,
                       'phone_2' => $request->phone_2,

                       'province_id' => $request->province_id,

                       'status' => $request->status,
                       'unit_number' => $request->unit_number,
                       'house_number' => $request->house_number,
                       'street_name' => $request->street_name,
                       'building_name' => $request->building_name,
                       'subdivision_id' => $request->subdivision_id,
                       'barangay_id' => $request->barangay_id,
                       'town_id' => $request->town_id,
                       'zip_code' => $request->zip_code,
                       'reason_for_inactive'=>$request->reason_for_inactive,
                       'floor' => $request->floor,
                       'created_by' => $request->created_by,

                   ]);


               if ($updateQuery1 > 0) {
//
                   return response()->json(['success'=>'true','message' =>  'updated successfully'], 200);
               }
           
     }

    //Delete user_skills
    public function Delete(Request $request)
    {

        if ($request->broker_asociation_id) {
            $table = DB::table('broker')->where('broker_asociation_id', $request->broker_asociation_id)->count();
            if ($table > 0) {
                return response()->json(['message' => 'cannot delete the broker association associated with multiple brokers'], 200);
            }
            else {
                $deleteQuery = DB::table('broker_association')->where('broker_association.broker_association_id', $request->broker_asociation_id)->delete();
                if ($deleteQuery > 0) {

                    return response()->json(['message' => 'Item deleted successfully'], 200);
                }
            }
        }
    }
    //web end

    // get all agency without pagination
    public function GetWithoutPagination(Request $request)
    {

        $id = $request->id;
        $status = $request->status;
        $getQuery = DB::table("broker_association")->select(['broker_association_id', 'broker_association_name'])
            ->orderBy('broker_association_name');
        if (isset($id)) {
            $getQuery->where('broker_association_id', '=', $id);
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

        }

        $getQuery = $getQuery->get();
        return response()->json(['resultData' => $getQuery], 200);
    }




//->leftJoin('broker', DB::raw("FIND_IN_SET(broker_association.id,broker.broker_association_id)"))

}
