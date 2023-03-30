<?php
namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
class AssignmentModel extends Model
{
    // Check Subject Code in DB and then Save
    public static function saveUpdateAssignment(
                $centerId,
                $loggedUserId,
                $lms_user_id,
                $lms_assignment_id,
                $isSaveEditClicked,
                $lms_assignment_title,
                $lms_assignment_description,
                $lms_batch_id,
                $lms_subject_id,
                $lms_topic_id,
                 $lms_assignment_submission_last_date,
                $lms_assignment_score,
                $lms_course_id,
                $classId
             
    ) {
        if ($isSaveEditClicked == 1) {

            $saveQuery = DB::table('lms_assignment')->insertGetId(
                [
                    'lms_center_id' => $centerId,
                    'lms_assignment_title' => $lms_assignment_title,
                    'lms_assignment_description' => $lms_assignment_description,
                    'lms_user_id' => $lms_user_id,
                    'lms_assignment_created_by' => $loggedUserId,
                    'lms_batch_id' => $lms_batch_id,
                    'lms_subject_id' => $lms_subject_id,
                    'lms_topic_id' => $lms_topic_id,
                    'lms_assignment_submission_last_date' => $lms_assignment_submission_last_date,
                    'lms_assignment_score' => $lms_assignment_score,
                    'lms_course_id'=>$lms_course_id,
                    'lms_child_course_id'=>$classId,
                                   ]
            );
            if ($saveQuery > 0) {
                // course Saved
                $result_data['responseData'] = "2";
            } else {
                // Failed to save course
                $result_data['responseData'] = "3";
            }
        } else {

            $updateQuery = DB::table('lms_assignment')
                ->where('lms_assignment_id', $lms_assignment_id)
                ->where('lms_center_id', $centerId)
                ->update([

                    'lms_center_id' => $centerId,
                    'lms_assignment_title' => $lms_assignment_title,
                    'lms_assignment_description' => $lms_assignment_description,
                    'lms_user_id' => $lms_user_id,
                    'lms_assignment_updated_at' => now(),
                    'lms_assignment_updated_by' => $loggedUserId,

                    'lms_batch_id' => $lms_batch_id,
                    'lms_subject_id' => $lms_subject_id,
                    'lms_topic_id' => $lms_topic_id,
                    'lms_assignment_submission_last_date' => $lms_assignment_submission_last_date,
                    'lms_assignment_score' => $lms_assignment_score,
                     'lms_course_id'=>$lms_course_id,
                     'lms_child_course_id'=>$classId,
                    

                ]);
            if ($updateQuery > 0) {
                $result_data['responseData'] = "4";
            }
        }
        return $result_data;
    }



    // Enable Disable Course
    public static function evaluateAssignment($assignmentId,
        $studentId, $loggedUserId) {
        $updateQuery = DB::table('lms_submitted_assignment_document')
            ->where('lms_assignment_id', $assignmentId)
            ->where('lms_student_id', $studentId)
            ->update([

                'lms_submitted_assignment_evaluation_status' => 1,
                'lms_submitted_assignment_evaluation_date' => now(),
                'lms_submitted_assignment_evaluated_by' => $loggedUserId,

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";

        } else {
            $result_data['responseData'] = "2";

        }
        return $result_data;

    }

 // Delete Assignment
    public static function deleteAssignment(
       $lms_assignment_document_id,
            $loggedUserId
    ) {
        $updateQuery = DB::table('lms_assignment_document')
            ->where('lms_assignment_document_id', $lms_assignment_document_id)
            ->update([

                'lms_assignment_document_status' => 0,
                'lms_assignment_document_updated_at' => now(),
                'lms_assignment_document_updated_by' => $loggedUserId,

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";
        } else {
            $result_data['responseData'] = "2";
        }
        return $result_data;
    }

    //Enable Disable Assignment
    public static function enableDisableAssignment(
       $lms_assignment_id,$loggedUserId, $lms_assignment_upload_status
    ) {
        $updateQuery = DB::table('lms_assignment')
            ->where('lms_assignment_id', $lms_assignment_id)
            ->update([

              //  'lms_assignment_status' => 0,
                'lms_assignment_upload_status'=>$lms_assignment_upload_status,
                'lms_assignment_updated_at' => now(),
                'lms_assignment_updated_by' => $loggedUserId,

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";
        } else {
            $result_data['responseData'] = "2";
        }
        return $result_data;
    }

     // Upload Assignment
    public static function uploadAssignment(
                        $centerId,
                        $loggedUserId,
                      $assignmentImageName,
                      $lms_assignment_id
    ) {
         $saveQuery = DB::table('lms_assignment_document')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_assignment_document_path' => $assignmentImageName,
                        'lms_assignment_document_created_by' => $loggedUserId,
                        'lms_assignment_id' => $lms_assignment_id,

                    ]
                );
        if ($saveQuery > 0) {
            $result_data['responseData'] = "1";
        } else {
            $result_data['responseData'] = "2";
        }
        return $result_data;
    }

}
