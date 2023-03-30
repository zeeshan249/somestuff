<?php

namespace App\Http\Controllers;

use App\TopicModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    public function __construct()
    {

    }
    // Check Course Code in DB and then Save
    public function saveUpdateTopic(Request $request)
    {
      
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'loggedUserId' => 'bail | required |numeric ',
            'topicCode' => 'bail | required',
            'topicName' => 'bail| required',
            'courseId' => 'bail | required',

        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {
              
            $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;
            $courseId = $request->courseId;
            $subjectId = $request->subjectId;
       
            $topicCode = trim($request->topicCode);
            $topicName = $request->topicName;
            $isSaveEditClicked = $request->isSaveEditClicked;

            $topicId = $request->topicId;
            $classId = $request->classId;
            $result = TopicModel::saveUpdateTopic($centerId,
                $loggedUserId, $topicCode, $topicName,
                $isSaveEditClicked, $courseId, $subjectId, $topicId,$classId);
            return response()->json($result);
        }

    }

    //Get the Subject
    public function getAllTopic(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 100;
        $filterBy=$request->searchText;  
        $includeDelete = $request->includeDelete;
        if ($includeDelete == "false") {
            $active = [1];
        } else {
            $active = [1, 0];
        }
        $getData = DB::table("lms_topic")->
            leftJoin('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_topic.lms_subject_id')->
            leftJoin('lms_course', 'lms_course.lms_course_id', '=', 'lms_topic.lms_course_id')->
            leftJoin('lms_child_course', 'lms_topic.lms_child_course_id', '=', 'lms_child_course.lms_child_course_id')->
            select(['lms_topic.lms_subject_id', 'lms_topic.lms_course_id', 'lms_subject_name', 'lms_course_name', 'lms_topic_id','lms_topic_name','lms_child_course.lms_child_course_id',
            'lms_topic_code', 'lms_child_course.lms_child_course_name',
            DB::raw("( SELECT count(distinct lms_youtube_video.video_id)
            FROM lms_youtube_video where

            lms_youtube_video.topic_id= lms_topic.lms_topic_id

       ) as totalVideo"),
            DB::raw("IF(lms_topic_is_active = 1, 'Active','Inactive')as lms_topic_is_active")])->

            where('lms_topic.lms_center_id', $centerId)
            ->where(function ($q) use ($filterBy) {
                $q->orWhere('lms_topic.lms_topic_code', 'like', "%$filterBy%")
                    ->orWhere('lms_topic.lms_topic_name', 'like', "%$filterBy%")
                    ->orWhere('lms_child_course.lms_child_course_name', 'like', "%$filterBy%");
               
                  

            })
            ->whereIn('lms_topic.lms_topic_is_active', $active)
            ->orderBy('lms_topic.lms_topic_created_at','DESC')
            ->paginate($perPage);
        return $getData;
    }

    //Enable Disable course
    public function enableDisableTopic(Request $request)
    {
        $centerId = $request->centerId;
        $topicId = $request->topicId;
        $isTopicActive = $request->isTopicActive;
        $loggedUserId = $request->loggedUserId;
        $result = TopicModel::enableDisableTopic($centerId,
            $topicId, $isTopicActive, $loggedUserId);
        return response()->json($result);

    }

    //Get All Active Course without pagination
    public function getActiveSubjectBasedOnCourseWithoutPagination(Request $request)
    {
        $centerId = $request->centerId;
        $courseId = $request->courseId;

        $getQuery = DB::table("lms_subject")->
            select(['lms_subject_id', 'lms_subject_name'])
            ->where('lms_course_id', $courseId)
            ->where('lms_subject_is_active', 1)
            ->where('lms_center_id', $centerId)
            ->get();
        return $getQuery;

    }
    
    public function getActiveClassBasedOnStreamWithoutPagination(Request $request)
    {
       
        $centerId = $request->centerId;
        $courseId = $request->courseId;

        $getQuery = DB::table("lms_child_course")->
            select(['lms_child_course_id', 'lms_child_course_name'])
            ->where('lms_course_id', $courseId)
            ->where('lms_child_course_is_active', 1)
     
            ->get();
        return $getQuery;

    }

    //Get All Active Course without pagination
    public function getActiveChildCourseWP(Request $request)
    {
        $centerId = $request->centerId;
        $courseId = $request->courseId;

        $getQuery = DB::table("lms_child_course")->
            select(['lms_child_course_id', 'lms_child_course_name'])
            ->where('lms_course_id', $courseId)
            ->where('lms_child_course_is_active', 1)
            ->where('lms_center_id', $centerId)
            ->get();
        return $getQuery;

    }

}
