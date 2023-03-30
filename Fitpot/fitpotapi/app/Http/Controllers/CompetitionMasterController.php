<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Exception;

use Illuminate\Support\Str;


class CompetitionMasterController extends Controller
{
    public function Get(Request $request)
    {


        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;


        $getQuery = DB::table("competition_master")->select('competition_master.comp_master_id','competition_master.comp_master_name' ,'competition_master.comp_master_days'
            ,'competition_master.comp_master_total_km','competition_master.comp_master_minimum_km_per_day','competition_master.comp_master_max_participant'
            ,'competition_master.comp_master_min_participant','competition_master.comp_master_pot_value','competition_master.comp_master_per_partition_value',
        'competition_master.comp_master_created_by','competition_master.comp_activity_id','competition_master.comp_category_id','competition_master.comp_type_id'
        ,'competition_master.daily_loyalty_point','competition_master.achievers_loyalty_point'
        ,'competition_category.comp_category_name','competition_activity.comp_activity_name','competition_type.comp_type_name'
        ,'competition_master.comp_master_start_day','competition_master.comp_master_rest_day','competition_master.comp_master_status',
            \DB::raw('(CASE

                        WHEN competition_master.comp_master_rest_day = "1" THEN "Sunday"

                        WHEN competition_master.comp_master_rest_day = "2" THEN "Monday"

                      WHEN competition_master.comp_master_rest_day = "3" THEN "Tuesday"

                     WHEN competition_master.comp_master_rest_day = "4" THEN "Wednesday"
                      WHEN competition_master.comp_master_rest_day = "5" THEN "Thursday"
                     WHEN competition_master.comp_master_rest_day = "6" THEN "Friday"
                     WHEN competition_master.comp_master_rest_day = "7" THEN "Saturday"
                        END) AS comp_master_resting_day'),
        )

            ->join('competition_category', 'competition_category.comp_category_id', '=', 'competition_master.comp_category_id')
            ->join('competition_activity', 'competition_activity.comp_activity_id', '=', 'competition_master.comp_activity_id')
            ->join('competition_type', 'competition_type.comp_type_id', '=', 'competition_master.comp_type_id')
            ->where(function ($q) use ($filterBy) {
                $q->where('competition_master.comp_master_name', 'like', "%$filterBy%");
//                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")

            })
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }

    public function Save(Request $request)
    {

        $comp_master_name = $request->comp_master_name;
        $comp_master_days= $request->comp_master_days;
        $comp_master_total_km = $request->comp_master_total_km;
        $comp_master_minimum_km_per_day = $request->comp_master_minimum_km_per_day;
        $comp_master_max_participant = $request->comp_master_max_participant;
        $comp_master_min_participant = $request->comp_master_min_participant;
        $comp_master_pot_value = $request->comp_master_pot_value;
        $comp_master_per_partition_value = $request->comp_master_per_partition_value;
        $comp_master_created_by = $request->comp_master_created_by;
        $comp_master_status = $request->comp_master_status;
        $comp_activity_id = $request->comp_activity_id;
        $comp_category_id = $request->comp_category_id;
        $comp_type_id = $request->comp_type_id;
        $daily_loyalty_point = $request->daily_loyalty_point;
        $achievers_loyalty_point = $request->achievers_loyalty_point;

//        $status = $request->status;


        try {
            $comp = DB::table('competition_master')->where('comp_master_name', $request->comp_master_name)->count();
            if ($comp > 0) {
                return response()->json(['success' => 'true', 'message' => 'Competition Master  name already exist enter a new type name'], 200);
            } else {

                $insertedcompetitionmaster = DB::table('competition_master')->insertGetId(
                    [
                        'comp_master_name' => $request->comp_master_name,
            'comp_master_days' => $request->comp_master_days,
            'comp_master_total_km' => $request->comp_master_total_km,
            'comp_master_minimum_km_per_day' => $request->comp_master_minimum_km_per_day,
            'comp_master_max_participant' => $request->comp_master_max_participant,
            'comp_master_min_participant' => $request->comp_master_min_participant,
            'comp_master_pot_value' => $request->comp_master_pot_value,
            'comp_master_per_partition_value' =>   $comp_master_per_partition_value,
            'comp_master_created_by' => $request->comp_master_created_by,
            'comp_master_status' => $request->comp_master_status,
            'comp_activity_id' => $request->comp_activity_id,
            'comp_category_id' => $request->comp_category_id,
            'comp_type_id' => $request->comp_type_id,
            'daily_loyalty_point' => $request->daily_loyalty_point,
            'achievers_loyalty_point' => $request->achievers_loyalty_point,
            'comp_master_start_day' => $request->comp_master_start_day,
            'comp_master_rest_day' => $request->comp_master_rest_day,
                    ]);
                return response()->json(['success' => 'true', 'message' => 'competition Master added successfully'], 200);
            }
        } catch (Exception $ex) {


            return response()->json(['success' => 'false', 'message' => 'something went wrong'], 200);
        }

    }

    public function Update(Request $request)
    {


        $db = DB::table('competition_master')->where('comp_master_name', $request->comp_master_name)->where('comp_master_id', '!=', $request->comp_master_id)->count();
//        if($db==0){
//            return response()->json(['success' => 'true','message' => 'Competition Type updated successfully'], 200);
//        }
        if ($db) {
            return response()->json([ 'success' => 'true','message' => 'Competition Master  name already exist enter a new Competition Master name'], 200);
        } else {
            $updateQuery = DB::table('competition_master')
                ->where('comp_master_id',$request->comp_master_id)
                ->update([
                    'comp_master_name' => $request->comp_master_name,
                    'comp_master_days' => $request->comp_master_days,
                    'comp_master_total_km' => $request->comp_master_total_km,
                    'comp_master_minimum_km_per_day' => $request->comp_master_minimum_km_per_day,
                    'comp_master_max_participant' => $request->comp_master_max_participant,
                    'comp_master_min_participant' => $request->comp_master_min_participant,
                    'comp_master_pot_value' => $request->comp_master_pot_value,
                    'comp_master_per_partition_value' =>  $request->comp_master_per_partition_value,
                    'comp_master_created_by' => $request->comp_master_created_by,
                    'comp_master_status' => $request->comp_master_status,
                    'comp_activity_id' => $request->comp_activity_id,
                    'comp_category_id' => $request->comp_category_id,
                    'comp_type_id' => $request->comp_type_id,
                    'daily_loyalty_point' => $request->daily_loyalty_point,
                    'achievers_loyalty_point' => $request->achievers_loyalty_point,
                    'comp_master_start_day' => $request->comp_master_start_day,
                    'comp_master_rest_day' => $request->comp_master_rest_day,

                ]);
            if ($updateQuery > 0) {

                return response()->json(['success' => 'true','message' => 'Competition Master updated successfully'], 200);
            }
        }
    }

    public function Status(Request  $request)
    {
        $status = $request->comp_master_status;
        $comp_master_id = $request->Id;

        $st = DB::table('competition_master')
            ->where('comp_master_id',  $comp_master_id )
            ->update([
                'comp_master_status' => $status,
            ]);
        if ($st) {

            return response()->json(['success'=>'true','message' => 'Competition Master Status Changed successfully'], 200);
        }


    }

    public function Delete(Request $request)
    {

        $comp_master_id = $request->comp_master_id;
        $deleteQuery = DB::table('competition_master')->where('comp_master_id', $comp_master_id)->delete();
        if ($deleteQuery > 0) {

            return response()->json(['success'=>'true','message' => 'Competition Master Deleted'], 200);
        }
    }




}
