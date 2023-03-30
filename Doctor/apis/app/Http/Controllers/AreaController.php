<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function Get(Request $request)
    {

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $searchText = $request->searchText;


        $getQuery = DB::table("dm_area")
            ->join('dm_city','dm_city.city_id','=','dm_area.city_id')
            ->select('dm_area.city_id','area_id','area_name','area_is_active','dm_city.city_name','dm_city.city_name as city')

            ->where('area_name', 'like', '%' . $searchText . '%')->orderBy($sortColumn, $sortOrder)

            ->paginate($itemsPerPage);

            $getCity = DB::table("dm_city")->where('city_is_active',1)->get();


        return response()->json(['resultData' =>  $getQuery,'getCity'=>$getCity,'success'=>'true'], 200);
    }

    public function Save(Request  $request){


        $area_name= DB::table('dm_area')->where('area_name',trim($request->area_name))->count();
        if ( $area_name>0) {
            return response()->json(['message' => 'Area name already present please enter a new Area Name '], 200);
        }
        else {
            $saveQuery = DB::table('dm_area')->insertGetId(
                [
                    'area_name' => trim($request->area_name),
                    'city_id'=>$request->city_id,
                    'area_is_active' => 1,

                ]
            );
            if ($saveQuery > 0) {
                return response()->json(['message' => 'Area saved successfully','success'=>'true'], 200);
            }
        }
    }

    public function Update(Request  $request){
        $area_name = trim($request->area_name);
        $Id = $request->Id;
        $city_id=$request->city_id;

        $db = DB::table('dm_area')->where('area_name', $area_name)->where('area_id', '!=', $Id )->count();

        if ($db > 0) {
            return response()->json(['message' => 'Area name name already present please enter a new Area name'], 200);
        }
        else {
            $updateQuery = DB::table('dm_area')
                ->where('area_id', $Id)
                ->update([
                      'area_name' => $area_name,
                      'city_id'=>$city_id

                ]);
            if ($updateQuery > 0) {

                return response()->json(['message' =>  'Area updated successfully' ,'success'=>'true'], 200);
            }
        }
    }

    public function Status(Request  $request){
        $area_status = $request->area_status;
        $Id = $request->Id;
        try {
            $updateQuery = DB::table('dm_area')
                ->where('area_id', $Id)
                ->update([
                    'area_is_active' => $area_status,
                ]);
            if ($updateQuery > 0) {

                return response()->json(['message' => 'Area Status Changed successfully' ,'success'=>'true'], 200);
            }
        }
        catch (Exception $ex) {

            return response()->json(['result' => "exception", 'message' => 'Something went wrong']);
        }
    }

    public function delete(Request $request)
    {

        $Id = $request->area_id;
        $deleteQuery = DB::table('dm_area')->where('area_id', $Id)->delete();
        if ($deleteQuery > 0) {

            return response()->json(['success'=>'true','message' => 'Area deleted successfully'], 200);
        }
    }

    public function GetAreaWithoutPagination(Request $request)
    {



        $getQuery = DB::table("dm_area")
           // ->join('dm_city','dm_city.city_id','=','dm_area.city_id')
            ->select('dm_area.city_id','area_id','area_name','area_is_active')
//           ->whereIn('dm_area.city_id',[$request->city_id])
           ->whereIn('dm_area.city_id', explode(',', $request->city_id))


            ->where('area_is_active',1)

             ->get();


        return response()->json(['resultData' =>  $getQuery,'success'=>'true'], 200);
    }

}
