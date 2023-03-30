<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class  TopicModel extends Model
{
    protected $primaryKey = "lms_topic_id";
    protected $table = "lms_topic";
    public $timestamps = false;

     // Check Subject Code in DB and then Save
    public static function saveUpdateTopic($centerId,
    $loggedUserId, $topicCode, $topicName,
    $isSaveEditClicked, $courseId,$subjectId,$topicId,$classId) {
     
        if ($isSaveEditClicked == 1) {

            // If save course is clicked
            $getQuery = DB::table("lms_topic")->
                where('lms_center_id', $centerId)->
                where('lms_topic_code', $topicCode)
                ->get();
            if ($getQuery->count() > 0) {
                // Course Code Exists
               
                $result_data['responseData'] = "1";

            } else {

                $saveQuery = DB::table('lms_topic')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_topic_code' => $topicCode,
                        'lms_topic_name' => $topicName,
                        'lms_course_id' => $courseId,
                        'lms_subject_id' => $subjectId,
                        'lms_topic_created_by'=>$loggedUserId,
                        'lms_child_course_id'=>$classId


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

            $getQuery = DB::table("lms_topic")->
            where('lms_center_id', $centerId)->
            where('lms_topic_code', $topicCode)
            ->where('lms_topic_id', '!=', $topicId)
            ->get();
            if ($getQuery->count() > 0) {
                // Course Code Exists
                $result_data['responseData'] = "1";

            }
            else{
                $updateQuery = DB::table('lms_topic')
                ->where('lms_topic_id', $topicId)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_course_id' => $courseId,
                    'lms_topic_name' => $topicName,
                    'lms_topic_code' => $topicCode,
                    'lms_child_course_id'=>$classId,
                    'lms_course_id' => $courseId,
                    'lms_subject_id' => $subjectId,
                    'lms_topic_updated_at' => now(),
                    'lms_topic_updated_by'=>$loggedUserId

                ]);
            if ($updateQuery > 0) {
                $result_data['responseData'] = "4";

            }
            }

        }
        return $result_data;

    }

    // Enable Disable Subject
    public static function enableDisableTopic($centerId,
    $topicId,$isTopicActive,$loggedUserId) {
        $updateQuery = DB::table('lms_topic')
            ->where('lms_topic_id', $topicId)
            ->where('lms_center_id', $centerId)
            ->update(['lms_topic_is_active' => $isTopicActive,'lms_topic_updated_at' => now(),'lms_topic_updated_by'=>$loggedUserId]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";

        } else {
            $result_data['responseData'] = "2";

        }
        return $result_data;

    }
}
