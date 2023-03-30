<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Exception;

use Illuminate\Support\Str;


class CompetitionTypeController extends Controller
{
    public function Get(Request $request)
    {


        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;


        $getQuery = DB::table("competition_type")->select('competition_activity.comp_activity_name','competition_category.comp_category_name','competition_type.comp_activity_id','competition_type.comp_category_id','competition_type.comp_type_name','competition_type.comp_type_name','competition_type.comp_type_id','competition_type.comp_type_status')
            ->join('competition_category', 'competition_category.comp_category_id', '=', 'competition_type.comp_category_id')
            ->join('competition_activity', 'competition_activity.comp_activity_id', '=', 'competition_type.comp_activity_id')

            ->where(function ($q) use ($filterBy) {
                $q->where('competition_type.comp_type_name', 'like', "%$filterBy%");
//                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")

            })
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }

    public function Save(Request $request)
    {

        $comp_category_id = $request->comp_category_id;
        $comp_activity_id = $request->comp_activity_id;
        $comp_type_name = $request->comp_type_name;
        $comp_type_created_by = $request->comp_type_created_by;

//        $status = $request->status;


        try {
            $comp = DB::table('competition_type')->where('comp_type_name', $comp_type_name)->count();
            if ($comp > 0) {
                return response()->json(['success' => 'true', 'message' => 'Competition Type  name already exist enter a new type name'], 200);
            } else {
                $insertedcompetitiontype = DB::table('competition_type')->insertGetId(
                    [
                        'comp_category_id' => $comp_category_id,
                        'comp_activity_id' => $comp_activity_id,
                        'comp_type_name' => trim($comp_type_name),
                        'comp_type_created_by' => $comp_type_created_by,
                    ]);
                return response()->json(['success' => 'true', 'message' => 'competition type added successfully'], 200);
            }
        } catch (Exception $ex) {


            return response()->json(['success' => 'false', 'message' => 'something went wrong'], 200);
        }

    }

    public function Update(Request $request)
    {

        $comp_category_id = $request->comp_category_id;
        $comp_type_id = $request->comp_type_id;
        $comp_activity_id = $request->comp_activity_id;
        $comp_type_name = $request->comp_type_name;

        $db = DB::table('competition_type')->where('comp_type_name', $comp_type_name)->where('comp_type_id', '!=', $comp_type_id)->count();
//        if($db==0){
//            return response()->json(['success' => 'true','message' => 'Competition Type updated successfully'], 200);
//        }
        if ($db) {
            return response()->json([ 'success' => 'true','message' => 'Competition Type  name already exist enter a new type name'], 200);
        } else {

            $updateQuery = DB::table('competition_type')
                ->where('comp_type_id', $comp_type_id)
                ->update([
                    'comp_category_id' => $comp_category_id,
                    'comp_type_id' => $comp_type_id,
                    'comp_activity_id' => $comp_activity_id,
                    'comp_type_name' => $comp_type_name,
                    'comp_type_created_by' => 1,

                ]);
            if ($updateQuery > 0) {

                return response()->json(['success' => 'true','message' => 'Competition Type updated successfully'], 200);
            }

        }
    }

    public function Status(Request  $request){
        $status = $request->comp_type_status;
        $comp_type_id = $request->Id;

        $st = DB::table('competition_type')
            ->where('comp_type_id',  $comp_type_id )
            ->update([
                'comp_type_status' => $status,
            ]);
        if ($st) {

            return response()->json(['success'=>'true','message' => 'Competition Type Status Changed successfully'], 200);
        }


    }

    public function Delete(Request $request)
    {

        $comp_type_id = $request->comp_type_id;
        $deleteQuery = DB::table('competition_type')->where('comp_type_id', $comp_type_id)->delete();
        if ($deleteQuery > 0) {

            return response()->json(['success'=>'true','message' => 'Competition Type Deleted'], 200);
        }
    }

    public function GetWithoutPagination(Request $request)
    {
        $status= $request->comp_type_status;
        if ($status != null) {
            $status = $request->comp_type_status;
        } else {
            $status = 1;
        }



        $getQuery = DB::table("competition_type")->select('competition_type.comp_type_name','competition_type.comp_type_id'
        )

            ->where('competition_type.comp_category_id',$request->comp_category_id)
            ->where('competition_type.comp_activity_id',$request->comp_activity_id)
            ->where('competition_type.comp_type_status',$status)



            ->get();

        return response()->json(['resultData' => $getQuery], 200);
    }




}
