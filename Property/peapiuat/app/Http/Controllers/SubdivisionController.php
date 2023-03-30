<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class SubdivisionController extends Controller
{
    public $Namex = "Subdivision";

    // get all user_skills
    public function Get(Request $request)
    {


        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $searchText = $request->searchText;
        $getQuery = DB::table("subdivisions as t1")
            ->leftJoin('province', 't1.province_id', '=', 'province.province_id')
            ->leftJoin('town', 't1.town_id', '=', 'town.town_id')
            ->leftJoin('barangay as t2', 't1.barangay_id', '=', 't2.barangay_id')
  			->leftJoin('subdivisions as adjSub', DB::raw("FIND_IN_SET(adjSub.subdivision_id,t1.adjacent_subdivision)"), ">", \DB::raw("'0'"))
            ->groupBy('t1.subdivision_id')
            ->
            select(['t1.subdivision_id', 't1.subdivision_name', DB::raw("IF(t1.subdivision_status = 'Active', 'Active','Inactive')as subdivision_status"),
                't1.zip_code','t1.province_id','t1.town_id','t1.barangay_id','province.province_name','town.town_name','t2.barangay_name',

                DB::raw("GROUP_CONCAT(adjSub.subdivision_name) as adjacent_subdivision"),
                DB::raw("GROUP_CONCAT(adjSub.subdivision_id) as adjacent_subdivision_id"),
                DB::raw('DATE_FORMAT(t1.created_at, "%d-%m-%Y") as created_at', "%d-%m-%Y"),

            ])
         ->where(function ($q) use ($searchText) {
			 if($searchText != null)
			 {
                $q->where('adjSub.subdivision_name', 'like', '%' . $searchText . '%')
                 ->orWhere('t1.subdivision_name', 'like', '%' . $searchText . '%');
			 }
          })
		
          ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);

    }
    //save user_skills
    public function Save(Request $request)
    {
        $barangay_id = $request->barangay_id;
        $town_id = $request->town_id;
        $province_id = $request->province_id;
        $zip_code = $request->zip_code;
        $subdivision_name = $request->subdivision_name;
        $created_by = $request->created_by;
        $adjacent_subdivision=$request->adjacent_subdivision;
        
       $barangayDetails=DB::table('barangay')->select('*')->where('barangay_id',$barangay_id)->first();
      $duplicatesubdivision=DB::table('subdivisions')
         ->select('subdivisions.subdivision_name')
         ->where('subdivisions.subdivision_name',$subdivision_name)
         ->where('subdivisions.barangay_id',$barangay_id)
         ->count();
         if( $duplicatesubdivision>0){
            return response()->json(['success'=>false,'message' =>'Subdivision Present on This barangay'], 200);
         }

        $saveQuery = DB::table('subdivisions')->insertGetId(
            [
                'barangay_id'=> $barangay_id,
                'town_id' => $barangayDetails->town_id,
                'province_id' => $barangayDetails->province_id,
                'zip_code' =>$barangayDetails->zip_code,
                'subdivision_name' => $subdivision_name,

                'created_by' =>  $created_by,
                'adjacent_subdivision' =>  $adjacent_subdivision

            ]
        );
        if ($saveQuery > 0) {
            return response()->json(['message' =>'Subdivision saved successfully'], 200);
        }
    }

    //Update user_skills
    public function Update(Request $request)
    {
   
     

        $updated_by = $request->updated_by??'';
        $barangay_id = $request->barangay_id??'';
        $town_id = $request->town_id??'';
        $province_id = $request->province_id??'';
        $zip_code = $request->zip_code??'';
        $subdivision_name = $request->subdivision_name??'';
        $created_by = $request->created_by??'';
        $adjacent_subdivision=$request->adjacent_subdivision??'';
		 $subdivision_status=$request->subdivision_status??'';
      
          $barangayDetails=DB::table('barangay')->select('*')->where('barangay_id',$request->barangay_id)->first();
          $duplicatesubdivision=DB::table('subdivisions')
          ->select('subdivisions.subdivision_name')
          ->where('subdivisions.subdivision_name',$subdivision_name)
          ->where('subdivisions.barangay_id',$barangay_id)
          ->where('subdivisions.subdivision_id','!=',$request->subdivision_id)
          ->count();
          if( $duplicatesubdivision>0){
             return response()->json(['success'=>false,'message' =>'Subdivision Present on Your Selected Barangay'], 200);
          }
      
         $saveQuery = DB::table('subdivisions')->where('subdivision_id',$request->subdivision_id)
         ->update([
                'barangay_id'=> $request->barangay_id,
                'town_id' => $barangayDetails->town_id,
                'province_id' => $barangayDetails->province_id,
                'zip_code' =>$barangayDetails->zip_code,
                'subdivision_name' => $request->subdivision_name,
                'subdivision_status'=>$request->subdivision_status,
                'created_by' =>  $created_by,
                'adjacent_subdivision' =>  $adjacent_subdivision

            ]);
        if ($saveQuery > 0) {
            return response()->json(['message' =>'Subdivision updated successfully'], 200);
        }
        else{
            return response()->json(['result'=>'error','message' =>'Subdivision not Updated'], 200);
        }
    }

    //Delete
    public function Delete(Request $request)
    {

        $Id = $request->subdivision_id;
        $deleteQuery = DB::table('subdivisions')->where('subdivision_id', $Id)->delete();
        if ($deleteQuery) {

            return response()->json(['message' => 'Item deleted successfully'], 200);
        }
    }
    //web end

    // get all subdivisionwithout pagination
    public function GetWithoutPagination(Request $request)
    {

        $Name = $request->Name;
        $Id = $request->subdivision_id;

        $updated_by = $request->updated_by;
        $barangayId = $request->barangayId;
        $town_id = $request->town_id;
        $province_id = $request->province_id;
        $zip_code = $request->zip_code;
        $subdivision_name = $request->subdivision_name;
        $created_by = $request->created_by;
        $adjacent_subdivision=$request->adjacent_subdivision;
        $getQuery = DB::table("subdivisions")->select(['subdivision_id', 'subdivision_name'])
            ->orderBy('subdivision_name');
        if (isset($barangayId) ) {
            $getQuery->where('barangay_id', '=',$barangayId);
          
            if (isset($status)) {
                $getQuery->where('subdivision_status', '=', $status);
            } else {
                $getQuery->where('subdivision_status', '=', 'Active');

            }
        } else {
            if (isset($status)) {
                $getQuery->where('subdivision_status', '=', $status);
            } else {
                $getQuery->where('subdivision_status', '=', 'Active');

            }

        }

        $getQuery = $getQuery->get();
        return response()->json(['resultData' => $getQuery], 200);
    }

    public function GetAdjacentSubdivisionWithoutPagination(Request $request)
    {
        // town,province,barangay
        $townId=$request->townId;
        $provinceId = $request->provinceId;
		$barangayId = $request->barangayId;
        $getQuery = DB::table("subdivisions")
        ->join('barangay','barangay.barangay_id','subdivisions.barangay_id')
        ->select('subdivision_id', 'subdivision_name',
       
        DB::raw("(SELECT concat(subdivisions.subdivision_name,', Barangay:-',barangay.barangay_name)) as adjacentSubdivision"),
        )
			  ->where(function ($q) use ($barangayId,$townId,$provinceId) {
                if($provinceId!=null){
                    $q->where('subdivisions.province_id',$provinceId);
                        
                    }
                 
                  if($townId!=null){
                    $q->where('subdivisions.town_id',$townId);
                        
                    }
                 if($barangayId!=null){
                      $q->where('subdivisions.barangay_id','!=',$barangayId);
                          
                    }
          })
        ->where('subdivisions.subdivision_status','Active')->get();
           
        return response()->json(['resultData' => $getQuery], 200);
     
    }

    public function getDetailsFromBarangay(Request $request){
        $status = $request->status;
        $getQuery = DB::table("subdivisions")
        
        ->select('subdivision_id', 'subdivision_name','subdivisions.town_id','subdivisions.province_id','subdivisions.zip_code')
       
        ->where('subdivisions.barangay_id',$request->barangayId)
        ->first();
        return response()->json(['resultData' => $getQuery], 200);  
    }

    public function GetBarangayForSubdivisionWithoutPagination(Request $request)
    {
        
        $townId = $request->townId;
        $provinceId = $request->provinceId;
        $barangayId= $request->barangayId;
      
		 
        $getQuery = DB::table("barangay")->select(['barangay_id', 'barangay_name'])
           
        ->where(function ($q) use ($provinceId,$townId,$barangayId) {

            if($provinceId!=null){
              $q->where('barangay.province_id',$provinceId);
                  
              }
           
            if($townId!=null){
              $q->where('barangay.town_id',$townId);
                  
              }
        //    if($barangayId!=null){
        //         $q->where('barangay.barangay_id','!=',$barangayId);
                    
        //       }
          })
        ->where('barangay.barangay_status','Active')
        ->orderBy('barangay_name')
        ->get();
      
        return response()->json(['resultData' => $getQuery], 200);
    }
}
