<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoOPDController extends Controller
{
    public function Get(Request $request)
    {
        try {
            
           
       // echo response()->json($request);

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $searchText = $request->searchText;


        $getQuery = DB::table("dm_no_opd_ot")
            ->select('dm_no_opd_ot.no_opd_id','dm_no_opd_ot.doctor_id','dm_no_opd_ot.no_opd_date','dm_no_opd_ot.status','dm_doctor.doctor_full_name')
            ->join('dm_doctor','dm_doctor.doctor_id','dm_no_opd_ot.doctor_id')
            ->where('no_opd_date', 'like', '%' . $searchText . '%')
            ->orwhere('dm_doctor.doctor_full_name', 'like', '%' . $searchText . '%')
            ->orderBy($sortColumn, $sortOrder)

            ->paginate($itemsPerPage);

        }
        catch (Exception $ex) {

            return response()->json(['success'=>'false','result' => "exception", 'message' => 'Something went wrong']);
        }


        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }

    public function Save(Request  $request){
        $doctor_id = $request->doctor_id;
        $no_opd_date = $request->no_opd_date;

        foreach($no_opd_date as $date)
        {
            $saveQuery = DB::table('dm_no_opd_ot')->insertGetId(
            [
                'doctor_id' => $doctor_id,
                'no_opd_date' => $date,

            ]
        );
        }
        
        
        if ($saveQuery > 0) {
            return response()->json(['success'=>'true','message' => 'Data Saved successfully'], 200);
        }
       
    }

    public function Status(Request  $request){
        $status = $request->status;
        $Id = $request->Id;
        try {
            $updateQuery = DB::table('dm_no_opd_ot')
                ->where('no_opd_id', $Id)
                ->update([
                    'status' => $status,


                ]);
            if ($updateQuery > 0) {

                return response()->json(['success'=>'true','message' => 'Status Changed successfully'], 200);
            }
        }
        catch (Exception $ex) {

            return response()->json(['success'=>'false','result' => "exception", 'message' => 'Something went wrong']);
        }
    }
    public function delete(Request $request)
    {

        $Id = $request->no_opd_id;
        $deleteQuery = DB::table('dm_no_opd_ot')->where('no_opd_id', $Id)->delete();
        if ($deleteQuery > 0) {

            return response()->json(['success'=>'true','message' => 'Record deleted successfully'], 200);
        }
    }

    

}
