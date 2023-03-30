<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeekdayController extends Controller
{
    public function GetWithoutPagination(Request $request)
    {
        $status= $request->comp_type_status;
        if ($status != null) {
            $status = $request->comp_activity_status;
        } else {
            $status = 1;
        }



        $getQuery = DB::table("week_days")->select(['*'])


            ->get();

        return response()->json(['resultData' => $getQuery], 200);
    }
}
