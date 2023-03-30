<?php

namespace App;

use DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
class DiscountModel extends Model
{
public static function saveEditDiscount(
        $description,
        $amount,
        $valid_from,
        $valid_to,
        $discount_details,
        $discount_type,
        $lms_discount_id,
        $isDiscountEdit

    ) {

        if ($isDiscountEdit == 1) {
            // Edit the Enquiry

            //trans
            DB::beginTransaction();
            try {

                $checkData = DB::table('lms_discount')
                    ->where('lms_discount.description',$description)
                    ->where('lms_discount_id', '!=', $lms_discount_id)
                    ->get();
           
                  
                    if ($checkData->count()  == 0) {

                        DB::table('lms_discount')
                            ->where('lms_discount_id', $lms_discount_id)
                            ->update([
                                'description' => $description,
                                'amount' => $amount,
                                'valid_from' => $valid_from,
                                'valid_to' => $valid_to,
                                'discount_details' => $discount_details,
                                'discount_type' => $discount_type,
                                'updated_at' => now(),
                        
                            ]);
                    } else {
                        // Discount exists
                        $result_data['responseData'] = 2;
                        return $result_data;
                    }
                

                DB::commit();
                // Edit Success
                $result_data['responseData'] = 6;

                return $result_data;
            } catch (Exception $ex) {

                DB::rollback();

                $result_data['responseData'] = 7;
                return $result_data;
            }
            //End

        } else {
            //Save the enquiry
            //trans
            DB::beginTransaction();
            try {
                $checkData= DB::table('lms_discount')->where('description', $description)->get();

                    if ($checkData->count() == 0) {
                        $enquiryCreateQuery = DB::table('lms_discount')->insertGetId(
                            [

                                'description' => $description,
                                'amount' => $amount,
                                'valid_from' => $valid_from,
                                'valid_to' => $valid_to,
                                'discount_details' => $discount_details,
                                'discount_type' => $discount_type,
                            ]
                        );
                    } else {

                        $result_data['responseData'] = 2;
                        return $result_data;
                    }
             
                DB::commit();

                $result_data['responseData'] = 4;
                return $result_data;
               
            } 
            
            catch (Exception $ex) {

                DB::rollback();

                $result_data['responseData'] = 5;
                return $result_data;
            }
        }
    }
}

    ?>