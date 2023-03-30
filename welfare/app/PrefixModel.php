<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class PrefixModel extends Model
{
    protected $primaryKey = "lms_prefix_setting_id";
    protected $table = "lms_prefix_setting";
    public $timestamps = false;

    // Check Prefix in DB and then Save
    public static function savePrefix($centerId,
    $prefixName,$prefixSettingId,$loggedUserId) {


         //trans

         $exception = DB::transaction(function () use (
            $centerId,
            $prefixName,$prefixSettingId,$loggedUserId
        ) {


            $getQuery =  DB::table('lms_center_details')
                ->select(['lms_center_code'])
                ->where('lms_center_id', $centerId)
                ->get();

                $saveQuery = DB::table('lms_prefix_setting')
                ->where('lms_prefix_setting_id', $prefixSettingId)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_prefix' => $prefixName,
                    'lms_prefix_pattern' => $prefixName.$getQuery[0]->lms_center_code.date('y')."000001" ,
                    'lms_is_prefix_assigned'=>1,
                    'lms_prefix_updated_at'=>now(),
                    'lms_prefix_updated_by' => $loggedUserId,

                ]);
        });

        if (is_null($exception)) {

            $result_data['responseData'] = "1";

        } else {

            $result_data['responseData'] = "2";

        }
        //End




        return $result_data;

    }


}
