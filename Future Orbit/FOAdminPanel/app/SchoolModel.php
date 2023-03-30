<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class SchoolModel extends Model
{
    protected $primaryKey = "lms_school_id";
    protected $table = "lms_school_list";
    public $timestamps = false;

     // Check School in DB and then Save
    public static function saveUpdateSchool($centerId,
    $loggedUserId, $SchoolName, $isSaveEditClicked, $SchoolId) {
        if ($isSaveEditClicked == 1) {

            // If save School is clicked
            $getQuery = DB::table("lms_school_list")->
                where('lms_center_id', $centerId)->
                where('lms_school_name', $SchoolName)
                ->get();
            if ($getQuery->count() > 0) {
                // School Name  Exists
                $result_data['responseData'] = "1";

            } else {

                $saveQuery = DB::table('lms_school_list')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_school_name' => $SchoolName,
                        'lms_school_created_by'=>$loggedUserId


                    ]
                );
                if ($saveQuery > 0) {
                    // School Saved
                    $result_data['responseData'] = "2";

                } else {
                    // Failed to save School
                    $result_data['responseData'] = "3";


                }
            }

        } else {

            $getQuery = DB::table("lms_school_list")->
            where('lms_center_id', $centerId)->
            where('lms_school_name', $SchoolName)
            ->where('lms_school_id', '!=', $SchoolId)
            ->get();
            if ($getQuery->count() > 0) {
                $result_data['responseData'] = "1";
            }
            else{
                $updateQuery = DB::table('lms_school_list')
                ->where('lms_school_id', $SchoolId)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_school_name' => $SchoolName,
                    'lms_school_updated_at' => now(),
                    'lms_school_updated_by'=>$loggedUserId

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

    // Enable Disable School
    public static function enableDisableSchool($centerId,
    $SchoolId,$isSchoolActive,$loggedUserId) {
        $updateQuery = DB::table('lms_school_list')
            ->where('lms_school_id', $SchoolId)
            ->where('lms_center_id', $centerId)
            ->update([

                'is_lms_school_active' => $isSchoolActive,
                'lms_school_updated_at' => now(),
                'lms_school_updated_by'=>$loggedUserId

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";

        } else {
            $result_data['responseData'] = "2";

        }
        return $result_data;

    }
}
