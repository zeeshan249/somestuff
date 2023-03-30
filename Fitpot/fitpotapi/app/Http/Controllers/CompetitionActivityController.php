<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompetitionActivityController extends Controller
{
    public function Get(Request $request)
    {
        $status= $request->comp_type_status;
        if ($status != null) {
            $status = $request->comp_type_status;
        } else {
            $status = 1;
        }

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;


        $getQuery = DB::table("competition_activity")->select('competition_activity.comp_activity_name','competition_activity.comp_activity_id')

            ->where('competition_activity.comp_activity_status',$status)
            ->where(function ($q) use ($filterBy) {
                $q->where('competition_activity.comp_activity_name', 'like', "%$filterBy%");
//                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")

            })
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }
    public function GetWithoutPagination(Request $request)
    {
        $status= $request->comp_type_status;
        if ($status != null) {
            $status = $request->comp_activity_status;
        } else {
            $status = 1;
        }



        $getQuery = DB::table("competition_activity")->select('competition_activity.comp_activity_name','competition_activity.comp_activity_id')

              ->where('competition_activity.comp_activity_status',$status)
              ->get();

        return response()->json(['resultData' => $getQuery], 200);
    }

}
