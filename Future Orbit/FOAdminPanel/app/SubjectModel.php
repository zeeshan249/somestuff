<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    protected $primaryKey = "lms_subject_id";
    protected $table = "lms_subject";
    public $timestamps = false;

     // Check Subject Code in DB and then Save
    public static function saveUpdateSubject($centerId,
    $loggedUserId, $subjectCode, $subjectName,
    $isSaveEditClicked, $courseId,$subjectId) {
        if ($isSaveEditClicked == 1) {

            // If save course is clicked
            $getQuery = DB::table("lms_subject")->
                where('lms_center_id', $centerId)->
                where('lms_subject_code', $subjectCode)
                ->get();
            if ($getQuery->count() > 0) {
                // Course Code Exists
               
                $result_data['responseData'] = "1";

            } else {

                $saveQuery = DB::table('lms_subject')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_subject_code' => $subjectCode,
                        'lms_subject_name' => $subjectName,
                        'lms_course_id' => $courseId,
                        'lms_subject_created_by'=>$loggedUserId


                    ]
                );
                if ($saveQuery > 0) {
                    // course Saved
                    $result_data['responseData'] = "2";

                } else {
                    // Failed to save course
                    $result_data['responseData'] = "3";
                }
            }

        } else {

            $getQuery = DB::table("lms_subject")->
            where('lms_center_id', $centerId)->
            where('lms_subject_code', $subjectCode)
            ->where('lms_subject_id', '!=', $subjectId)
            ->get();
            if ($getQuery->count() > 0) {
                // Course Code Exists
                $result_data['responseData'] = "1";

            }
            else{
                $updateQuery = DB::table('lms_subject')
                ->where('lms_subject_id', $subjectId)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_course_id' => $courseId,
                    'lms_subject_name' => $subjectName,
                    'lms_subject_code' => $subjectCode,
                    'lms_subject_updated_at' => now(),
                    'lms_subject_updated_by'=>$loggedUserId

                ]);
            if ($updateQuery > 0) {
                $result_data['responseData'] = "4";

            }
            }

        }
        return $result_data;

    }

    // Enable Disable Subject
    public static function enableDisableSubject($centerId,
    $subjectId,$isSubjectActive,$loggedUserId) {
        $updateQuery = DB::table('lms_subject')
            ->where('lms_subject_id', $subjectId)
            ->where('lms_center_id', $centerId)
            ->update([

                'lms_subject_is_active' => $isSubjectActive,
                'lms_subject_updated_at' => now(),
                'lms_subject_updated_by'=>$loggedUserId

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";

        } else {
            $result_data['responseData'] = "2";

        }
        return $result_data;

    }
}
