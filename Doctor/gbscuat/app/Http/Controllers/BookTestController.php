<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookTestController extends Controller
{
    public function webGetTestMedicine(Request $request){
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $doctor_id=$request->doctor_id;
        $clinic_id=$request->clinic_id;
        $filterBy = $request->searchText;
        $status= $request->book_test_current_status;
        if ($status != null) {
            $status = $request->book_test_current_status;
        }
        $getQuery = DB::table("dm_book_test")

            ->select('dm_book_test.book_test_id','dm_book_test.delivery_address','dm_book_test.mobile_number','dm_book_test.book_test_notes'
                ,'dm_book_test.name','dm_book_test.book_test_current_status','dm_book_test.user_id',
                DB::raw("( SELECT count(distinct dm_book_test_docs.book_test_docs_id)
                FROM dm_book_test_docs where

                dm_book_test_docs.book_test_id= dm_book_test.book_test_id

           ) as totalTestUploaded"),

                DB::raw('DATE_FORMAT(dm_book_test.book_test_created_at, "%d-%m-%Y") as booking_date'),


                \DB::raw('(CASE

                        WHEN dm_book_test.book_test_current_status = "1" THEN "Submitted"

                        WHEN dm_book_test.book_test_current_status = "2" THEN "Approve"

                      WHEN dm_book_test.book_test_current_status = "3" THEN "Rejected"

                     WHEN dm_book_test.book_test_current_status = "4" THEN "Sent"

                     WHEN dm_book_test.book_test_current_status = "5" THEN "Delivered"
                        END) AS status'),

            )
            ->where(function ($q) use ($filterBy) {
                $q
                    ->orWhere('dm_book_test.mobile_number', 'like', "%$filterBy%")
                    ->orWhere('dm_book_test.name', 'like', "%$filterBy%");

            })

            ->where(function ($q) use ($status) {
                if ($status != null) {
                    $q->where('dm_book_test.book_test_current_status', $status);
                }
            })

            ->orderBy('dm_book_test.book_test_id', 'DESC')

            ->paginate($itemsPerPage);



        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }


    public function changeBookTestStatus(Request $request){
        $id = $request->book_test_id;
        $status = $request->book_test_current_status;
        $userId=DB::table('dm_book_test')->select('user_id')->where('book_test_id',$id)->first();

        try {
            DB::beginTransaction();
            $st = DB::table('dm_book_test')
            ->where('book_test_id',  $id )
            ->update([
                'book_test_current_status' => $status,
            ]);

            $history=DB::table('dm_book_test_order_history')->where('book_test_id',  $id)->insertGetId([
             'book_test_id'=>$id,
             'user_id'=>$userId->user_id,
             'book_test_status' => $status,
             'book_test_order_history_updated_by'=> $request->updated_by,
             'book_test_order_history_updated_at' =>now(),
            
        ]);
        DB::commit();
        if ($st) {
            return response()->json(['result'=>'success','message' => 'Status Changed Successfully'], 200);
        }
    } catch (Exception $ex) {
        DB::rollback();
    }

    }


    public function webGetTestDoc(Request $request){
        $getQuery = DB::table('dm_book_test_docs')
            ->where('dm_book_test_docs.book_test_id', '=', $request->book_test_id)
        ->where('dm_book_test_docs.user_id', '=', $request->user_id)

        ->select([
            'dm_book_test_docs.book_test_docs_id',
            'dm_book_test_docs.book_test_id',
            'dm_book_test_docs.book_test_doc_name',


            DB::raw('DATE_FORMAT(dm_book_test_docs.book_test_docs_created_at, "%d-%m-%Y") as book_test_docs_created_at', "%d-%m-%Y"),


        ])

        ->orderBy('dm_book_test_docs.book_test_docs_created_at', 'desc')
        ->get();
        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }


}
