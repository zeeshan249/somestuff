<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompetitionCategoryController extends Controller
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


        $getQuery = DB::table("competition_category")->select('competition_category.comp_category_name','competition_activity.comp_activity_name')
            ->join('competition_category','competition_activity.comp_activity_id','=','competition_category.comp_activity_id')

            ->where('competition_category.comp_category_name',$status)
            ->where(function ($q) use ($filterBy) {
                $q->where('competition_category.comp_type_name', 'like', "%$filterBy%");
//                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")

            })
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }
    public function GetWithoutPagination(Request $request)
    {
        $status= $request->comp_category_status;
        if ($status != null) {
            $status = $request->comp_category_status;
        } else {
            $status = 1;
        }



        $getQuery = DB::table("competition_category")->select('competition_category.comp_category_name','competition_activity.comp_activity_name','competition_category.comp_category_id')
            ->join('competition_activity','competition_activity.comp_activity_id','=','competition_category.comp_activity_id')
            ->where('competition_category.comp_activity_id',$request->comp_activity_id)
            ->where('competition_category.comp_category_status',$status)



            ->get();

        return response()->json(['resultData' => $getQuery], 200);
    }
}
