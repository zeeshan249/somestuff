<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function Get(Request $request)
    {
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;
   
        $associatedAgency=DB::table('user_details')
        ->select('user_details.associated_agency_id')->where('user_details.user_id',$request->user_id)
       ->first();

       $getRole=DB::table('users')->join('roles','roles.id','users.role_id')->first();
       $fetchRole=$getRole->id;
       $agency=$associatedAgency->associated_agency_id;
        $getQuery = DB::table("seller")
         ->join('agency','agency.agency_id','seller.associated_agency_id')
         ->join('user_details','user_details.associated_agency_id','seller.associated_agency_id')
        ->select(['seller.seller_id',
            'seller.seller_name',
            'seller.email_address',
            'seller.phone_1',
            'seller.phone_2',
            'seller.property_owner_name',
            'seller.created_at',
            'seller.notes_about_seller',
            'seller.unit_number',
            'seller.house_no',
            'seller.street_name',
            'seller.subdivision_id',
            'seller.barangay_id',
            'seller.town_id',
            'seller.province_id',
            'seller.zipcode',
            'agency.agency_name'

           ])
           ->where(function ($q) use ($agency,$fetchRole) {
            if($fetchRole==26 ){
            $q->where('user_details.associated_agency_id',$agency);
            }
        
             })
            
            ->where(function ($q) use ($filterBy) {
                $q->orWhere('seller.seller_name', 'like', "%$filterBy%")
                    ->orWhere('seller.email_address', 'like', "%$filterBy%")
                    ->orWhere('seller.phone_1', 'like', "%$filterBy%")
                    ->orWhere('seller.property_owner_name', 'like', "%$filterBy%");

            })
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }

    public function  Save(Request $request){
        try {
            $agencyId=$request->agency_id??'';
        $agency= DB::table('seller')->where('seller_name', $request->seller_name)->count();
        if ( $agency>0) {
            return response()->json(['message' => 'Seller name already present please enter a new Seller Name '], 200);
        }
        $fetchUserType=DB::table('users')
        ->join('roles','roles.id','users.role_id')
        ->select('roles.name','roles.id as roleId')->where('users.user_id',$request->user_id)->first();
        if($fetchUserType->roleId==26){
            $userDetails=DB::table('user_details')->select('user_details.associated_agency_id')->where('user_details.user_id',$request->user_id)->first();
         $agencyId=$userDetails->associated_agency_id;
        }
        if($fetchUserType->roleId==4){
         $agencyId=$request->agency_id;
        }
        $saveQuery = DB::table('seller')->insertGetId(
            [
                'seller_name'=>$request->seller_name,
                'email_address'=>$request->email_address,
                'phone_1'=>$request->phone_1,
                'phone_2'=>$request->phone_2,
                'property_owner_name'=>$request->property_owner_name,
                'notes_about_seller'=>$request->notes_about_seller,
                'unit_number'=>$request->unit_number,
                'house_no'=>$request->house_no,
                'street_name'=>$request->street_name,
                'subdivision_id'=>$request->subdivision_id,
                'barangay_id'=>$request->barangay_id,
                'town_id'=>$request->town_id,
                'province_id'=>$request->province_id,
                'zipcode'=>$request->zipcode,
                'associated_agency_id'=>$agencyId

            ]
        );
        if ($saveQuery > 0) {
            return response()->json(['message' => '  Seller  added successfully'], 200);
        }
        }
        catch (Exception $ex) {

            return response()->json(['message' => 'Something went wrong']);
        }
    }

    public function  getSellerById(Request $request){
        $getQuery = DB::table("seller")
        ->join('agency','agency.agency_id','seller.associated_agency_id')
        ->select(['seller.seller_id',
            'seller.seller_name',
            'seller.email_address',
            'seller.phone_1',
            'seller.phone_2',
            'seller.property_owner_name',
            'seller.created_at',
            'seller.notes_about_seller',
            'seller.unit_number',
            'seller.house_no',
            'seller.street_name',
            'seller.subdivision_id',
            'seller.barangay_id',
            'seller.town_id',
            'seller.province_id',
            'seller.zipcode',
            'agency.agency_name'

        ])->where('seller.seller_id',$request->seller_id)
            ->get();
        return response()->json(['resultData' => $getQuery], 200);
    }

    public function Update(Request $request){
        try {
            $agencyId=$request->agency_id??'';
            $agency= DB::table('seller')
                ->where('seller.seller_id','!=',$request->seller_id)
                ->where('seller_name', $request->seller_name)->count();
            if ( $agency>0) {
                return response()->json(['message' => 'Seller name already present please enter a new Seller Name'], 200);
            }
            $fetchUserType=DB::table('users')
            ->join('roles','roles.id','users.role_id')
            ->select('roles.name','roles.id as roleId')->where('users.user_id',$request->user_id)->first();
            if($fetchUserType->roleId==26){
                $userDetails=DB::table('user_details')->select('user_details.associated_agency_id')->where('user_details.user_id',$request->user_id)->first();
             $agencyId=$userDetails->associated_agency_id;
            }
            if($fetchUserType->roleId==4){
             $agencyId=$request->agency_id;
            }
            $saveQuery = DB::table('seller')->where('seller.seller_id',$request->seller_id)
            ->update(
                [
                    'seller_name'=>$request->seller_name,
                    'email_address'=>$request->email_address,
                    'phone_1'=>$request->phone_1,
                    'phone_2'=>$request->phone_2,
                    'property_owner_name'=>$request->property_owner_name,
                    'notes_about_seller'=>$request->notes_about_seller,
                    'unit_number'=>$request->unit_number,
                    'house_no'=>$request->house_no,
                    'street_name'=>$request->street_name,
                    'subdivision_id'=>$request->subdivision_id,
                    'barangay_id'=>$request->barangay_id,
                    'town_id'=>$request->town_id,
                    'province_id'=>$request->province_id,
                    'zipcode'=>$request->zipcode,
                    'associated_agency_id'=>$agencyId

                ]
            );
            if ($saveQuery > 0) {
                return response()->json(['message' => 'Seller  updated successfully'], 200);
            }
        }
        catch (Exception $ex) {

            return response()->json(['message' => 'Something went wrong']);
        }
    }

    public  function  listofsellersreport(Request $request){
		$itemsPerPage=$request->itemsPerPage;
        $filterBy = $request->searchText;
        $sortColumn=$request->sortColumn;
        $sortOrder=$request->sortOrder;
        $getQuery = DB::table("seller")->select(['seller.seller_id',
            'seller.seller_name',
            'seller.email_address',
            'seller.phone_1',
            'seller.phone_2',
            'seller.property_owner_name',
            'seller.created_at',
            'seller.notes_about_seller',
            'seller.unit_number',
            'seller.house_no',
            'seller.street_name',
            'seller.subdivision_id',
            'seller.barangay_id',
            'seller.town_id',
            'seller.province_id',
            'seller.zipcode'

        ])

            ->where(function ($q) use ($filterBy) {
                $q->orWhere('seller.seller_name', 'like', "%$filterBy%")
                    ->orWhere('seller.email_address', 'like', "%$filterBy%")
                    ->orWhere('seller.phone_1', 'like', "%$filterBy%")
                    ->orWhere('seller.property_owner_name', 'like', "%$filterBy%");

            })
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }

    public function GetSellerWithoutPagination(Request $request)
    {
   
        $user_id=$request->user_id;
        $agencyid=DB::table('users')
        ->select('user_details.associated_agency_id')
        ->join('user_details','user_details.user_id','users.user_id')
        ->where('users.user_id',$user_id)
        ->first();
        if($agencyid!==null)
        {
       
      $fetchassociatedseller=  DB::table("seller")->select(['seller.seller_id',
            'seller.seller_name',
            'seller.email_address',
            'seller.phone_1',
            'seller.phone_2',
            'seller.property_owner_name',
            'seller.created_at',
            'seller.notes_about_seller',
            'seller.unit_number',
            'seller.house_no',
            'seller.street_name',
            'seller.subdivision_id',
            'seller.barangay_id',
            'seller.town_id',
            'seller.province_id',
            'seller.zipcode',
      

        ])
        ->where('seller.associated_agency_id',$agencyid->associated_agency_id)
         ->get();
        }
        else{
          return response()->json(['resultData' => []], 200);
        }
        return response()->json(['resultData' => $fetchassociatedseller], 200);
       
  
    }
  public function delete(Request $request){
$getQuery=DB::table('seller')->where('seller.seller_id',$request->seller_id)->delete();
return response()->json(['resultData' => $getQuery,'success'=>true,'message' => 'Deleted Successfully'], 200);
  }
}
