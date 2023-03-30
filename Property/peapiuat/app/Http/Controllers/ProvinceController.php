<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{


    // get all user_skills
    public function Get(Request $request)
    {

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $searchText = $request->searchText;

        $getQuery = DB::table("province")->select(['province_id', 'province_name', DB::raw("IF(province_status = 'Active', 'Active','Inactive')as province_status")])

            ->where('province_name', 'like', '%' . $searchText . '%')->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);
        return response()->json(['resultData' => $getQuery], 200);
    }
    //save user_skills
    public function Save(Request $request)
    {


        $createdBy = $request->createdBy;
        $province = DB::table('province')->where('province_name',trim($request->provinceName))->count();

        if ($province>0) {
            return response()->json(['message' => 'Province name already present please enter a new Province Name']);
        }
        else {
            $saveQuery = DB::table('province')->insertGetId(
                [
                    'province_name' => trim($request->provinceName),
                    'created_by' => $createdBy,

                ]
            );
            if ($saveQuery > 0) {
                return response()->json(['message' =>  'Province saved successfully'], 200);
            }
        }
    }

    //Update user_skills
    public function Update(Request $request)
    {

        $provinceName = $request->provinceName;
        $provinceId = $request->provinceId;
        $provinceStatus = $request->provinceStatus;
        $updatedBy = $request->updatedBy;
        $db = DB::table('province')->where('province_name', $provinceName)->where('province_id', '!=',$provinceId )->count();
        if ($db > 0) {
            return response()->json(['message' => 'Province name already present please enter a new Province Name'], 200);
        }
        else {
            $updateQuery = DB::table('province')
                ->where('province_id', $provinceId)
                ->update([
                    'province_name' => $provinceName,
                    'province_status' => $provinceStatus,
                    'updated_at' => now(),
                    'updated_by' => $updatedBy,

                ]);
            if ($updateQuery > 0) {

                return response()->json(['message' => 'Province updated successfully'], 200);
            }
        }
    }

    //Delete user_skills
    public function Delete(Request $request)
    {

        $provinceId = $request->provinceId;
     
        $deleteQuery = DB::table('province')->where('province.province_id', $provinceId)->delete();
        if ($deleteQuery > 0) {

            return response()->json(['message' => 'Item deleted successfully'], 200);
        }
    }
    //web end

    // get all province without pagination
   public function GetWithoutPagination(Request $request)
    {

        $id = $request->id;
        $status = $request->status;
        $getQuery = DB::table("province")->select(['province_id', 'province_name'])
            ->orderBy('province_name');
        if (isset($id)) {
            $getQuery->where('province_id', '=', $id);
            if (isset($status)) {
                $getQuery->where('province_status', '=', $status);
            } else {
                $getQuery->where('province_status', '=', 'Active');

            }
        } else {
            if (isset($status)) {
                $getQuery->where('province_status', '=', $status);
            } else {
                $getQuery->where('province_status', '=', 'Active');

            }

        }

        $getQuery = $getQuery->get();
        return response()->json(['resultData' => $getQuery], 200);
    }
    public function provinceExist(Request $request){
		
        $province = DB::table('province')->where('province_name',$request->provinceName)->count();

       if ($province>0) {
           return response()->json(['status'=>'exist','message' => 'Province name already present please enter a new Province Name']);
       }
       else{
        return response()->json(['status'=>'notexist','message' => 'no entries found']);
       }
       
   }
	
	
		 public function GetBarangayProvinceWithoutPagination(Request $request)
    {

       
        $provinceId = $request->provinceId;

        $status = $request->status;
        $getQuery = DB::table("town")
			->join('province','province.province_id','town.province_id')
			->select(['town.town_id', 'town.town_name','province.province_id'
											  ,'province.province_name'])
			->where('town.town_id',$provinceId)
			
            ->orderBy('province.province_name')
			->get();
       
        return response()->json(['resultData' => $getQuery], 200);
    }
}
