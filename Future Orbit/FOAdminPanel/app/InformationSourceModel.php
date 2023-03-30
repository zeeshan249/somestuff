<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class InformationSourceModel extends Model
{
    protected $primaryKey = "lms_information_source_id";
    protected $table = "lms_information_source";
    public $timestamps = false;

     // Check Information Source in DB and then Save
    public static function saveUpdateInformationSource($centerId,
    $loggedUserId, $informationSourceName, $isSaveEditClicked, $informationSourceId) {
        if ($isSaveEditClicked == 1) {

            // If save information source is clicked
            $getQuery = DB::table("lms_information_source")->
                where('lms_center_id', $centerId)->
                where('lms_information_source_name', $informationSourceName)
                ->get();
            if ($getQuery->count() > 0) {
                // Information source Name  Exists
                $result_data['responseData'] = "1";

            } else {

                $saveQuery = DB::table('lms_information_source')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_information_source_name' => $informationSourceName,
                        'lms_information_source_created_by'=>$loggedUserId


                    ]
                );
                if ($saveQuery > 0) {
                    // Information Source Saved
                    $result_data['responseData'] = "2";

                } else {
                    // Failed to save Information Source
                    $result_data['responseData'] = "3";


                }
            }

        } else {

            $getQuery = DB::table("lms_information_source")->
            where('lms_center_id', $centerId)->
            where('lms_information_source_name', $informationSourceName)
            ->where('lms_information_source_id', '!=', $informationSourceId)
            ->get();
            if ($getQuery->count() > 0) {
                // Information Source name Exists

                $result_data['responseData'] = "1";

            }
            else{
                $updateQuery = DB::table('lms_information_source')
                ->where('lms_information_source_id', $informationSourceId)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_information_source_name' => $informationSourceName,
                    'lms_information_source_updated_at' => now(),
                    'lms_information_source_updated_by'=>$loggedUserId

                ]);
            if ($updateQuery > 0) {
                $result_data['responseData'] = "4";

            } else {
                $result_data['responseData'] = "5";


            }
            }

        }
        return $result_data;

    }

    // Enable Disable Information Source
    public static function enableDisableInformationSource($centerId,
    $informationSourceId,$isInformationSourceActive,$loggedUserId) {
        $updateQuery = DB::table('lms_information_source')
            ->where('lms_information_source_id', $informationSourceId)
            ->where('lms_center_id', $centerId)
            ->update([

                'is_lms_information_source_active' => $isInformationSourceActive,
                'lms_information_source_updated_at' => now(),
                'lms_information_source_updated_by'=>$loggedUserId

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";

        } else {
            $result_data['responseData'] = "2";

        }
        return $result_data;

    }
}
