<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookMedicineController extends Controller
{
    public function webGetBookMedicine(Request $request){
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $doctor_id=$request->doctor_id;
        $clinic_id=$request->clinic_id;
        $filterBy = $request->searchText;
        $status= $request->book_medicine_current_status;
        if ($status != null) {
            $status = $request->book_medicine_current_status;
        }
        $getQuery = DB::table("dm_book_medicine")
            ->select('dm_book_medicine.book_medicine_id','dm_book_medicine.delivery_address','dm_book_medicine.mobile_number','dm_book_medicine.book_medicine_notes'
               ,'dm_book_medicine.book_medicine_current_status','dm_book_medicine.user_id',
                'dm_book_medicine.name',
                DB::raw("( SELECT count(distinct dm_book_medicine_docs.book_medicine_docs_id)
                FROM dm_book_medicine_docs where
                 book_medicine_id=dm_book_medicine.book_medicine_id

           ) as totalPrescriptionUploaded"),

                DB::raw('DATE_FORMAT(dm_book_medicine.book_medicine_created_at, "%d-%m-%Y") as booking_date'),


                \DB::raw('(CASE

                        WHEN dm_book_medicine.book_medicine_current_status = "1" THEN "Submitted"

                        WHEN dm_book_medicine.book_medicine_current_status = "2" THEN "Approve"

                      WHEN dm_book_medicine.book_medicine_current_status = "3" THEN "Rejected"

                     WHEN dm_book_medicine.book_medicine_current_status = "4" THEN "Sent"

                     WHEN dm_book_medicine.book_medicine_current_status = "5" THEN "Delivered"
                        END) AS status'),

            )


            ->where(function ($q) use ($status) {
                if ($status != null) {
                    $q->where('dm_book_medicine.book_medicine_current_status', $status)
                    ->where('dm_book_medicine.name', $status);
                }
            })

            ->where(function ($q) use ($filterBy) {
                $q
                    ->orWhere('dm_book_medicine.mobile_number', 'like', "%$filterBy%");

            })

            ->orderBy('dm_book_medicine.book_medicine_id', 'DESC')

            ->paginate($itemsPerPage);



        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }

    public function changeBookMedicineStatus(Request $request){
        $id = $request->book_medicine_id;
        $status = $request->book_medicine_current_status;
        $userId=DB::table('dm_book_medicine')->select('user_id')->where('book_medicine_id',$id)->first();

        try {
            DB::beginTransaction();
        $st = DB::table('dm_book_medicine')
            ->where('book_medicine_id',  $id )
            ->update([
                'book_medicine_current_status' => $status,
            ]);

        $history=DB::table('dm_book_medicine_order_history')->where('book_medicine_id',  $id)->insertGetId([
             'book_medicine_id'=>$id,
             'user_id'=>$userId->user_id,
             'book_medicine_status' => $status,
             'book_medicine_order_history_updated_by'=>$request->updated_by,
             'book_medicine_order_history_updated_at' =>now(),
        ]);
        DB::commit();
        if ($st) {
            return response()->json(['result'=>'success','message' => 'Status Changed Successfully'], 200);
        }
    } catch (Exception $ex) {
        DB::rollback();
    }

    }

    public function webGetPrescriptionDoc(Request $request){
        $getQuery = DB::table('dm_book_medicine_docs')
            ->where('dm_book_medicine_docs.user_id', '=', $request->user_id)
			  ->where('dm_book_medicine_docs.book_medicine_id', '=', $request->book_medicine_id)
            ->select([
                'dm_book_medicine_docs.book_medicine_docs_id',
                'dm_book_medicine_docs.book_medicine_id',
                'dm_book_medicine_docs.book_medicine_doc_name',


                DB::raw('DATE_FORMAT(dm_book_medicine_docs.book_medicine_docs_created_at, "%d-%m-%Y") as book_medicine_docs_created_at', "%d-%m-%Y"),


            ])
          
            ->orderBy('dm_book_medicine_docs.book_medicine_docs_created_at', 'desc')
            ->get();



        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }


}
