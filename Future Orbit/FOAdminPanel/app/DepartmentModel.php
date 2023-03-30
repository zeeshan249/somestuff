<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class DepartmentModel extends Model
{
    protected $primaryKey = "lms_department_id";
    protected $table = "lms_department";
    public $timestamps = false;

     // Check Department in DB and then Save
    public static function saveDepartment($centerId,
        $departmentName, $isSaveEditClicked, $departmentId,$loggedUserId) {
        if ($isSaveEditClicked == 1) {
            // If save Department is clicked
            $getQuery = DB::table("lms_department")->
                where('lms_center_id', $centerId)->
                where('lms_department_name', $departmentName)
                ->get();
            if ($getQuery->count() > 0) {
                // Department Exists
                $result_data['responseData'] = "1";

            } else {
                $saveQuery = DB::table('lms_department')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_department_name' => $departmentName,
                        'lms_department_created_by'=>$loggedUserId


                    ]
                );
                if ($saveQuery > 0) {
                    // Department Saved
                    $result_data['responseData'] = "2";

                } else {
                    // Failed to save Department
                    $result_data['responseData'] = "3";

                }
            }

        } else {
            $updateQuery = DB::table('lms_department')
                ->where('lms_department_id', $departmentId)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_department_name' => $departmentName,
                    'lms_department_updated_at' => now(),
                    'lms_department_updated_by'=>$loggedUserId

                ]);
            if ($updateQuery > 0) {
                $result_data['responseData'] = "4";

            } else {
                $result_data['responseData'] = "5";

            }
        }
        return $result_data;

    }

    // Enable Disable Department
    public static function updateDepartment($centerId,
    $departmentName,$departmentId,$isDepartmentActive,$loggedUserId) {
        $updateQuery = DB::table('lms_department')
            ->where('lms_department_id', $departmentId)
            ->where('lms_center_id', $centerId)
            ->update([
                'lms_department_name' => $departmentName,
                'lms_department_is_active' => $isDepartmentActive,
                'lms_department_updated_at' => now(),
                'lms_department_updated_by'=>$loggedUserId

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";

        } else {
            $result_data['responseData'] = "2";

        }
        return $result_data;

    }
}
