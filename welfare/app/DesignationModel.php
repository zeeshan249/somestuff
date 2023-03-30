<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class DesignationModel extends Model
{
    protected $primaryKey = "lms_designation_id";
    protected $table = "lms_designation";
    public $timestamps = false;

    // Check Designation in DB and then Save
    public static function saveDesignation($centerId,
        $designationName, $isSaveEditClicked, $designationId, $loggedUserId) {
        if ($isSaveEditClicked == 1) {
            // If save Designation is clicked
            $getQuery = DB::table("lms_designation")->
                where('lms_center_id', $centerId)->
                where('lms_designation_name', $designationName)
                ->get();
            if ($getQuery->count() > 0) {
                // Designation Exists
                $result_data['responseData'] = "1";

            } else {
                $saveQuery = DB::table('lms_designation')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_designation_name' => $designationName,
                        'lms_designation_created_by' => $loggedUserId,

                    ]
                );
                if ($saveQuery > 0) {
                    // Designation Saved
                    $result_data['responseData'] = "2";

                } else {
                    // Failed to save Designation
                    $result_data['responseData'] = "3";

                }
            }

        } else {
            $updateQuery = DB::table('lms_designation')
                ->where('lms_designation_id', $designationId)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_designation_name' => $designationName,
                    'lms_designation_updated_at' => now(),
                    'lms_designation_updated_by' => $loggedUserId,

                ]);
            if ($updateQuery > 0) {
                $result_data['responseData'] = "4";

            } else {
                $result_data['responseData'] = "5";

            }
        }
        return $result_data;

    }

    // Enable Disable Designation
    public static function updateDesignation($centerId,
        $designationName, $designationId, $isDesignationActive, $loggedUserId) {
        $updateQuery = DB::table('lms_designation')
            ->where('lms_designation_id', $designationId)
            ->where('lms_center_id', $centerId)
            ->update([
                'lms_designation_name' => $designationName,
                'lms_designation_is_active' => $isDesignationActive,
                'lms_designation_updated_at' => now(),
                'lms_designation_updated_by' => $loggedUserId,

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";

        } else {
            $result_data['responseData'] = "2";

        }
        return $result_data;

    }
}
