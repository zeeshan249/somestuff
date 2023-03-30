<?php

namespace App\Http\Controllers;

use App\DiscountModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    public function __construct()
    {
    }
   
    public function getAllDiscount(Request $request)
    {

        $perPage = $request->perPage ? $request->perPage : 15;
        $filterBy = $request->filterBy;
        $result = DB::table('lms_discount')
            ->where(function ($q) use ($filterBy) {
                $q->where('lms_discount.description', 'like', "%$filterBy%")
                    ->orWhere('lms_discount.amount', 'like', "%$filterBy%")
                    ->orWhere('lms_discount.discount_details', $filterBy)
                    ->orWhere('lms_discount.discount_type', $filterBy);
            })

            ->select(
                'lms_discount.lms_discount_id',
                'lms_discount.description',
                'lms_discount.amount',
                'lms_discount.discount_details',
                'lms_discount.discount_type',
                DB::raw("date_format(lms_discount.valid_from,'%d-%m-%y') as valid_from"),
                DB::raw("date_format(lms_discount.valid_to,'%d-%m-%y') as valid_to"),
                DB::raw("
                        (case when lms_discount.status  = '0' then 'Inactive'
                     
                        ELSE 'Active' end) as 'status'"),

               DB::raw("date_format(lms_discount.created_at,'%d-%m-%y') as created_at"),
            )
            ->orderBy('lms_discount.created_at','desc')
            ->paginate($perPage);
        return $result;
    }

   // Add/Edit Enquiry Basic Info
   public function saveEditDiscount(Request $request)
   {
      
       // Server side validation rules
       $validation = Validator::make($request->all(), [
          
           'description' => 'required',
           'amount' => 'required',
           'valid_from' => 'required',
           'valid_to' => 'required',
           'discount_details' => 'required',
           'discount_type' => 'required',
   

       ]);
       if ($validation->fails()) {

           // Server side validation fails
           return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
       } else {
           $description = $request->description;
           $amount = $request->amount;
           $valid_from = $request->valid_from;
           $valid_to = $request->valid_to;
           $discount_details = $request->discount_details;
           $discount_type = $request->discount_type;
           $updated_at=$request->updated_at;
           $lms_discount_id=$request->lms_discount_id;
           $isDiscountEdit = $request->isDiscountEdit;
           

           $result = DiscountModel::saveEditDiscount(
               $description,
               $amount,
               $valid_from,
               $valid_to,
               $discount_details,
               $discount_type,
               $lms_discount_id,
               $isDiscountEdit,
           );
           return response()->json($result);
       }
   }



}
