<?php

namespace App\Http\Controllers;

use App\QuestionBankModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionBankController extends Controller
{
    public function __construct()
    {

    }

    public function SaveCopyQuestion(Request $request)
    {
        $centerId = $request->centerId;
        $QuestionList = $request->QuestionList;
        $CourseId = $request->CourseId;
        $SubjectId = $request->SubjectId;
        $TopicId = $request->TopicId;

        $loggedUserId = $request->loggedUserId;
        $result = QuestionBankModel::SaveCopyQuestion($centerId,
            $QuestionList, $CourseId, $SubjectId, $TopicId, $loggedUserId);
        return response()->json($result);

    }

    //Get All Active Difficulty without pagination
    public function getActiveDifficultyLevel(Request $request)
    {
        $centerId = $request->centerId;

        $getQuery = DB::table("lms_question_difficulty_level")->
            select(['lms_question_difficulty_level_id', 'lms_question_difficulty_level_name'])
            ->where('lms_question_difficulty_level_is_active', 1)
            ->where('lms_center_id', $centerId)
            ->get();
        return $getQuery;

    }
    public function getAllQuestionBankBasedOnCondition(Request $request)
    {

        $perPage = $request->perPage ? $request->perPage : 100;
        $centerId = $request->centerId;
        $courseId = $request->courseId;
        $subjectId = $request->subjectId;
        $topicId = $request->topicId;

        $result = DB::table('lms_question_bank')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_question_bank.lms_course_id')
            ->join('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_question_bank.lms_subject_id')
            ->join('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_question_bank.lms_topic_id')
            ->join('lms_question_difficulty_level', 'lms_question_difficulty_level.lms_question_difficulty_level_id', '=', 'lms_question_bank.lms_question_difficulty_level_id')
            ->where('lms_question_bank.lms_center_id', '=', $centerId)
            ->where('lms_question_bank.lms_question_bank_is_active', '=', '1')
            ->where('lms_course.lms_course_id', $courseId)
            ->where('lms_subject.lms_subject_id', $subjectId)
            ->where('lms_topic.lms_topic_id', $topicId)

        // ->where(function ($q) use ($filterBy) {
        //     $q->where('lms_course.lms_course_name', $filterBy)
        //         ->orWhere('lms_subject.lms_subject_name', 'like', "%$filterBy%")
        //         ->orWhere('lms_topic.lms_topic_name', 'like', "%$filterBy%")
        //         ->orWhere('lms_question_bank.lms_question_bank_text', 'like', "%$filterBy%")
        //         ->orWhere('lms_question_bank.lms_question_bank_tag', 'like', "%$filterBy%");
        // })

            ->select('lms_question_bank.lms_question_bank_id',
                'lms_question_bank.lms_question_bank_text',
                'lms_question_bank.lms_question_bank_image_path',
                'lms_question_bank.lms_question_bank_has_image',

                'lms_question_bank.lms_question_difficulty_level_id',
                'lms_question_bank.lms_question_bank_options_1',
                'lms_question_bank.lms_question_bank_options_2',
                'lms_question_bank.lms_question_bank_options_3',
                'lms_question_bank.lms_question_bank_options_4',
                'lms_question_bank.lms_question_bank_options_5',
                'lms_question_bank.lms_question_bank_options_1_has_image',
                'lms_question_bank.lms_question_bank_options_2_has_image',
                'lms_question_bank.lms_question_bank_options_3_has_image',
                'lms_question_bank.lms_question_bank_options_4_has_image',
                'lms_question_bank.lms_question_bank_options_5_has_image',
                'lms_question_bank.lms_question_bank_correct_answers',
                'lms_question_bank.lms_question_bank_marks',
                'lms_question_bank.lms_question_bank_no_of_option',
                'lms_question_bank.lms_question_bank_solution',
                'lms_question_bank.lms_question_bank_solution_has_image',
                'lms_question_bank.lms_question_bank_tag',

                'lms_course.lms_course_name',
                'lms_course.lms_course_id',
                'lms_subject.lms_subject_name',
                'lms_subject.lms_subject_id',
                'lms_topic.lms_topic_name',
                'lms_topic.lms_topic_id',
                'lms_question_bank.lms_question_bank_type_single_multiple as lms_question_bank_type_single_multiple_value',

                DB::raw("IF(lms_question_bank.lms_question_bank_type_single_multiple = 0, 'S','M')as lms_question_bank_type_single_multiple"),
                DB::raw("IF(lms_question_bank.lms_question_bank_is_active = 1, 'Active','Inactive')as lms_question_bank_is_active"),

                DB::raw("
              (case when lms_question_difficulty_level.lms_question_difficulty_level_name = 'Easy' then 'E'
              when lms_question_difficulty_level.lms_question_difficulty_level_name  = 'Medium' then 'M'
              when lms_question_difficulty_level.lms_question_difficulty_level_name  = 'Hard' then 'H'
              ELSE 'aa'
          end) as 'lms_question_difficulty_level_name'")

            )->orderBy('lms_question_bank.lms_question_bank_id', 'desc');

        if ($perPage == -1) {
            return $result->paginate($result->get()->count());
        } else {
            return $result->paginate($perPage);
        }
        // dd($courseId);

    }

    // Add/Edit Exam Schedule Basic Info
    public function saveEditQuestionBank(Request $request)
    {

        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'loggedUserId' => 'bail | required |numeric ',
            'lms_subject_id' => 'bail|required ',
            'lms_topic_id' => 'bail | required |numeric ',
            'lms_course_id' => 'bail | sometimes|required ',
            'lms_question_difficulty_level_id' => 'bail | required',
            'lms_question_bank_type_single_multiple' => 'required|min:0',
            'lms_question_bank_correct_answers' => 'bail | required',
            'lms_question_bank_marks' => 'bail | required | numeric',
            'lms_question_bank_text' => 'bail | required',

        ]);
        // if ($validation->fails()) {

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {
            $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;

            $isQuestionBankEdit = $request->isQuestionBankEdit;
            $lms_question_bank_id = $request->lms_question_bank_id;
            $lms_subject_id = $request->lms_subject_id;
            $lms_topic_id = $request->lms_topic_id;
            $lms_course_id = $request->lms_course_id;
            $lms_question_difficulty_level_id = $request->lms_question_difficulty_level_id;
            $lms_question_bank_type_single_multiple = $request->lms_question_bank_type_single_multiple;
            $lms_question_bank_correct_answers = $request->lms_question_bank_correct_answers;
            $lms_question_bank_marks = $request->lms_question_bank_marks;
            $lms_question_bank_no_of_option = $request->lms_question_bank_no_of_option;
            $lms_question_bank_text = $request->lms_question_bank_text;
            $lms_question_bank_tag = $request->lms_question_bank_tag;

            //Question
            $lms_question_bank_has_image = $request->lms_question_bank_has_image;
            $lms_question_bank_image_path = $request->lms_question_bank_image_path;
            $questionImagePathImageName = $request->lms_question_bank_image_path;

            if ($request->has('lms_question_bank_image_path')) {
                // If profile image selected

                $questionImagePathImageName = uniqid() . time() . '.' . $request->lms_question_bank_image_path->extension();
                $request->lms_question_bank_image_path->storeAs('public/question_images', $questionImagePathImageName);
            }

            //Option 1
            $lms_question_bank_options_1_has_image = $request->lms_question_bank_options_1_has_image;
            $lms_question_bank_options_1_text = $request->lms_question_bank_options_1_text;
            $lms_question_bank_options_1 = $request->lms_question_bank_options_1;
            if ($lms_question_bank_options_1_text == "TextOption1") {
                $lms_question_bank_options_1 = $request->lms_question_bank_options_1;
            } else {
                $lms_question_bank_options_1 = uniqid() . time() . '.' . $request->lms_question_bank_options_1->extension();
                $request->lms_question_bank_options_1->storeAs('public/answer_images', $lms_question_bank_options_1);
            }

            //Option 2
            $lms_question_bank_options_2_has_image = $request->lms_question_bank_options_2_has_image;
            $lms_question_bank_options_2_text = $request->lms_question_bank_options_2_text;
            $lms_question_bank_options_2 = $request->lms_question_bank_options_2;
            if ($lms_question_bank_options_2_text == "TextOption2") {
                $lms_question_bank_options_2 = $request->lms_question_bank_options_2;
            } else {
                $lms_question_bank_options_2 = uniqid() . time() . '.' . $request->lms_question_bank_options_2->extension();
                $request->lms_question_bank_options_2->storeAs('public/answer_images', $lms_question_bank_options_2);
            }

            //Option 3
            $lms_question_bank_options_3_has_image = $request->lms_question_bank_options_3_has_image;
            $lms_question_bank_options_3_text = $request->lms_question_bank_options_3_text;
            $lms_question_bank_options_3 = $request->lms_question_bank_options_3;
            if ($lms_question_bank_options_3_text == "TextOption3") {
                $lms_question_bank_options_3 = $request->lms_question_bank_options_3;
            } else {
                $lms_question_bank_options_3 = uniqid() . time() . '.' . $request->lms_question_bank_options_3->extension();
                $request->lms_question_bank_options_3->storeAs('public/answer_images', $lms_question_bank_options_3);
            }

            //Option 4
            $lms_question_bank_options_4_has_image = $request->lms_question_bank_options_4_has_image;
            $lms_question_bank_options_4_text = $request->lms_question_bank_options_4_text;
            $lms_question_bank_options_4 = $request->lms_question_bank_options_4;
            if ($lms_question_bank_options_4_text == "TextOption4") {
                $lms_question_bank_options_4 = $request->lms_question_bank_options_4;
            } else {
                $lms_question_bank_options_4 = uniqid() . time() . '.' . $request->lms_question_bank_options_4->extension();
                $request->lms_question_bank_options_4->storeAs('public/answer_images', $lms_question_bank_options_4);
            }

            //Solution
            $lms_question_bank_solution_has_image = $request->lms_question_bank_solution_has_image;
            $lms_question_bank_solution_text = $request->lms_question_bank_solution_text;
            $lms_question_bank_solution = $request->lms_question_bank_solution;
            if ($lms_question_bank_solution_text == "Solution") {
                $lms_question_bank_solution = $request->lms_question_bank_solution;
            } else {
                $lms_question_bank_solution = uniqid() . time() . '.' . $request->lms_question_bank_solution->extension();
                $request->lms_question_bank_solution->storeAs('public/solution_images', $lms_question_bank_solution);
            }

            if ($lms_question_bank_no_of_option == "5") {
                //Option 5
                $lms_question_bank_options_5_has_image = $request->lms_question_bank_options_5_has_image;
                $lms_question_bank_options_5_text = $request->lms_question_bank_options_5_text;
                $lms_question_bank_options_5 = $request->lms_question_bank_options_5;
                if ($lms_question_bank_options_5_text == "TextOption5") {
                    $lms_question_bank_options_5 = $request->lms_question_bank_options_5;
                } else {
                    $lms_question_bank_options_5 = uniqid() . time() . '.' . $request->lms_question_bank_options_5->extension();
                    $request->lms_question_bank_options_5->storeAs('public/answer_images', $lms_question_bank_options_5);
                }

                $result = QuestionBankModel::saveEditQuestionBank_withOption5($centerId, $loggedUserId, $isQuestionBankEdit, $lms_question_bank_id, $lms_subject_id, $lms_topic_id, $lms_course_id,
                    $lms_question_difficulty_level_id, $lms_question_bank_type_single_multiple, $lms_question_bank_correct_answers, $lms_question_bank_marks,
                    $lms_question_bank_no_of_option, $lms_question_bank_text, $lms_question_bank_has_image, $questionImagePathImageName,
                    $lms_question_bank_options_1, $lms_question_bank_options_1_has_image
                    , $lms_question_bank_options_2, $lms_question_bank_options_2_has_image
                    , $lms_question_bank_options_3, $lms_question_bank_options_3_has_image
                    , $lms_question_bank_options_4, $lms_question_bank_options_4_has_image
                    , $lms_question_bank_options_5, $lms_question_bank_options_5_has_image
                    , $lms_question_bank_solution, $lms_question_bank_solution_has_image,
                    $lms_question_bank_solution, $lms_question_bank_tag
                );
            } else {
                $result = QuestionBankModel::saveEditQuestionBank($centerId, $loggedUserId, $isQuestionBankEdit, $lms_question_bank_id, $lms_subject_id, $lms_topic_id, $lms_course_id,
                    $lms_question_difficulty_level_id, $lms_question_bank_type_single_multiple, $lms_question_bank_correct_answers, $lms_question_bank_marks,
                    $lms_question_bank_no_of_option, $lms_question_bank_text, $lms_question_bank_has_image, $questionImagePathImageName,
                    $lms_question_bank_options_1, $lms_question_bank_options_1_has_image
                    , $lms_question_bank_options_2, $lms_question_bank_options_2_has_image
                    , $lms_question_bank_options_3, $lms_question_bank_options_3_has_image
                    , $lms_question_bank_options_4, $lms_question_bank_options_4_has_image
                    , $lms_question_bank_solution, $lms_question_bank_solution_has_image
                    , $lms_question_bank_tag

                );
            }
            return response()->json($result);

        }

    }

/// Get All Question Bank

    public function getAllQuestionBank(Request $request)
    {

        $perPage = $request->perPage ? $request->perPage : 100;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_question_bank')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_question_bank.lms_course_id')
            ->join('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_question_bank.lms_subject_id')
            ->join('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_question_bank.lms_topic_id')
            ->join('lms_question_difficulty_level', 'lms_question_difficulty_level.lms_question_difficulty_level_id', '=', 'lms_question_bank.lms_question_difficulty_level_id')
            ->where('lms_question_bank.lms_center_id', '=', $centerId)
            ->where('lms_question_bank.lms_question_bank_is_active', '=', '1')

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_course.lms_course_name', $filterBy)
                    ->orWhere('lms_subject.lms_subject_name', 'like', "%$filterBy%")
                    ->orWhere('lms_topic.lms_topic_name', 'like', "%$filterBy%")
                    ->orWhere('lms_question_bank.lms_question_bank_text', 'like', "%$filterBy%")
                    ->orWhere('lms_question_bank.lms_question_bank_tag', 'like', "%$filterBy%");
            })

            ->select('lms_question_bank.lms_question_bank_id',
                'lms_question_bank.lms_question_bank_text',
                'lms_question_bank.lms_question_bank_image_path',
                'lms_question_bank.lms_question_bank_has_image',

                'lms_question_bank.lms_question_difficulty_level_id',
                'lms_question_bank.lms_question_bank_options_1',
                'lms_question_bank.lms_question_bank_options_2',
                'lms_question_bank.lms_question_bank_options_3',
                'lms_question_bank.lms_question_bank_options_4',
                'lms_question_bank.lms_question_bank_options_5',
                'lms_question_bank.lms_question_bank_options_1_has_image',
                'lms_question_bank.lms_question_bank_options_2_has_image',
                'lms_question_bank.lms_question_bank_options_3_has_image',
                'lms_question_bank.lms_question_bank_options_4_has_image',
                'lms_question_bank.lms_question_bank_options_5_has_image',
                'lms_question_bank.lms_question_bank_correct_answers',
                'lms_question_bank.lms_question_bank_marks',
                'lms_question_bank.lms_question_bank_no_of_option',
                'lms_question_bank.lms_question_bank_solution',
                'lms_question_bank.lms_question_bank_solution_has_image',
                'lms_question_bank.lms_question_bank_tag',

                'lms_course.lms_course_name',
                'lms_course.lms_course_id',
                'lms_subject.lms_subject_name',
                'lms_subject.lms_subject_id',
                'lms_topic.lms_topic_name',
                'lms_topic.lms_topic_id',
                'lms_question_bank.lms_question_bank_type_single_multiple as lms_question_bank_type_single_multiple_value',

                DB::raw("IF(lms_question_bank.lms_question_bank_type_single_multiple = 0, 'S','M')as lms_question_bank_type_single_multiple"),
                DB::raw("IF(lms_question_bank.lms_question_bank_is_active = 1, 'Active','Inactive')as lms_question_bank_is_active"),

                DB::raw("
              (case when lms_question_difficulty_level.lms_question_difficulty_level_name = 'Easy' then 'E'
              when lms_question_difficulty_level.lms_question_difficulty_level_name  = 'Medium' then 'M'
              when lms_question_difficulty_level.lms_question_difficulty_level_name  = 'Hard' then 'H'
              ELSE 'aa'
          end) as 'lms_question_difficulty_level_name'")

            )->orderBy('lms_question_bank.lms_question_bank_id', 'desc');

        if ($perPage == -1) {
            return $result->paginate($result->get()->count());
        } else {
            return $result->paginate($perPage);
        }
    }

    /// Get All Question Bank Exam Wise

    public function getAllQuestionBankExamWise(Request $request)
    {

        $perPage = $request->perPage ? $request->perPage : 50;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $scheduleId = $request->scheduleId;
        $selectedSubjectId= $request->selectedSubjectId;
        $selectedTopicId = $request->selectedTopicId;
        $isSearchByQuestionBank = $request->isSearchByQuestionBank;

        if($isSearchByQuestionBank== true)
        {
            $result = DB::table('lms_exam_schedule')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_exam_schedule.lms_course_id')
            ->join('lms_question_bank', 'lms_question_bank.lms_course_id', '=', 'lms_exam_schedule.lms_course_id')

            ->leftJoin('lms_exam_wise_question', function ($join) use ($scheduleId) {
                $join->on('lms_exam_wise_question.lms_question_bank_id', '=', 'lms_question_bank.lms_question_bank_id');
                $join->where('lms_exam_wise_question.lms_exam_schedule_id', '=', $scheduleId);
            })

            ->join('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_question_bank.lms_subject_id')
            ->join('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_question_bank.lms_topic_id')
            ->join('lms_question_difficulty_level', 'lms_question_difficulty_level.lms_question_difficulty_level_id', '=', 'lms_question_bank.lms_question_difficulty_level_id')
            ->where('lms_question_bank.lms_center_id', '=', $centerId)
            ->where('lms_exam_schedule.lms_exam_schedule_id', '=', $scheduleId)
            ->where('lms_question_bank.lms_question_bank_is_active', '=', '1')
            ->where('lms_topic.lms_topic_id', '=', $selectedTopicId)
            ->where('lms_subject.lms_subject_id', '=', $selectedSubjectId)
           
 

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_course.lms_course_name', $filterBy)
                    ->orWhere('lms_subject.lms_subject_name', 'like', "%$filterBy%")
                    ->orWhere('lms_topic.lms_topic_name', 'like', "%$filterBy%")
                    ->orWhere('lms_question_bank.lms_question_bank_text', 'like', "%$filterBy%");
            })

            ->select('lms_question_bank.lms_question_bank_id',
                'lms_exam_schedule.lms_exam_schedule_id',
                'lms_question_bank.lms_question_bank_text',
                'lms_question_bank.lms_question_bank_image_path',
                'lms_question_bank.lms_question_bank_has_image',
                'lms_exam_wise_question.lms_exam_wise_question_id',
                'lms_question_bank.lms_question_difficulty_level_id',
                'lms_question_bank.lms_question_bank_options_1',
                'lms_question_bank.lms_question_bank_options_2',
                'lms_question_bank.lms_question_bank_options_3',
                'lms_question_bank.lms_question_bank_options_4',
                'lms_question_bank.lms_question_bank_options_5',
                'lms_question_bank.lms_question_bank_options_1_has_image',
                'lms_question_bank.lms_question_bank_options_2_has_image',
                'lms_question_bank.lms_question_bank_options_3_has_image',
                'lms_question_bank.lms_question_bank_options_4_has_image',
                'lms_question_bank.lms_question_bank_options_5_has_image',
                'lms_question_bank.lms_question_bank_correct_answers',
                'lms_question_bank.lms_question_bank_marks',
                'lms_question_bank.lms_question_bank_no_of_option',
                'lms_question_bank.lms_question_bank_solution',
                'lms_question_bank.lms_question_bank_solution_has_image',
                'lms_question_bank.lms_question_bank_tag',

                'lms_course.lms_course_name',
                'lms_course.lms_course_id',
                'lms_subject.lms_subject_name',
                'lms_subject.lms_subject_id',
                'lms_topic.lms_topic_name',
                'lms_topic.lms_topic_id',

                DB::raw("
              (case when lms_question_difficulty_level.lms_question_difficulty_level_name = 'Easy' then 'E'
              when lms_question_difficulty_level.lms_question_difficulty_level_name  = 'Medium' then 'M'
              when lms_question_difficulty_level.lms_question_difficulty_level_name  = 'Hard' then 'H'
              ELSE 'aa'
          end) as 'lms_question_difficulty_level_name'"),
                DB::raw("IF(lms_question_bank.lms_question_bank_type_single_multiple = 0, 'S','M')as lms_question_bank_type_single_multiple"),
                DB::raw("IF(lms_question_bank.lms_question_bank_is_active = 1, 'Active','Inactive')as lms_question_bank_is_active"),
                DB::raw("IF(lms_exam_wise_question.lms_question_bank_id >= 0, 'A','N')as lms_question_added_not_added")

            )->orderBy('lms_exam_wise_question.lms_exam_schedule_id', 'desc');

        if ($perPage == -1) {
            return $result->paginate($result->get()->count());
        } else {
            return $result->paginate($perPage);
        }
        }
else
{

        $result = DB::table('lms_exam_schedule')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_exam_schedule.lms_course_id')
            ->join('lms_question_bank', 'lms_question_bank.lms_course_id', '=', 'lms_exam_schedule.lms_course_id')

            ->leftJoin('lms_exam_wise_question', function ($join) use ($scheduleId) {
                $join->on('lms_exam_wise_question.lms_question_bank_id', '=', 'lms_question_bank.lms_question_bank_id');
                $join->where('lms_exam_wise_question.lms_exam_schedule_id', '=', $scheduleId);
            })

            ->join('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_question_bank.lms_subject_id')
            ->join('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_question_bank.lms_topic_id')
            ->join('lms_question_difficulty_level', 'lms_question_difficulty_level.lms_question_difficulty_level_id', '=', 'lms_question_bank.lms_question_difficulty_level_id')
            ->where('lms_question_bank.lms_center_id', '=', $centerId)
            ->where('lms_exam_schedule.lms_exam_schedule_id', '=', $scheduleId)
            ->where('lms_question_bank.lms_question_bank_is_active', '=', '1')
           

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_course.lms_course_name', $filterBy)
                    ->orWhere('lms_subject.lms_subject_name', 'like', "%$filterBy%")
                    ->orWhere('lms_topic.lms_topic_name', 'like', "%$filterBy%")
                    ->orWhere('lms_question_bank.lms_question_bank_text', 'like', "%$filterBy%");
            })

            ->select('lms_question_bank.lms_question_bank_id',
                'lms_exam_schedule.lms_exam_schedule_id',
                'lms_question_bank.lms_question_bank_text',
                'lms_question_bank.lms_question_bank_image_path',
                'lms_question_bank.lms_question_bank_has_image',
                'lms_exam_wise_question.lms_exam_wise_question_id',
                'lms_question_bank.lms_question_difficulty_level_id',
                'lms_question_bank.lms_question_bank_options_1',
                'lms_question_bank.lms_question_bank_options_2',
                'lms_question_bank.lms_question_bank_options_3',
                'lms_question_bank.lms_question_bank_options_4',
                'lms_question_bank.lms_question_bank_options_5',
                'lms_question_bank.lms_question_bank_options_1_has_image',
                'lms_question_bank.lms_question_bank_options_2_has_image',
                'lms_question_bank.lms_question_bank_options_3_has_image',
                'lms_question_bank.lms_question_bank_options_4_has_image',
                'lms_question_bank.lms_question_bank_options_5_has_image',
                'lms_question_bank.lms_question_bank_correct_answers',
                'lms_question_bank.lms_question_bank_marks',
                'lms_question_bank.lms_question_bank_no_of_option',
                'lms_question_bank.lms_question_bank_solution',
                'lms_question_bank.lms_question_bank_solution_has_image',
                'lms_question_bank.lms_question_bank_tag',

                'lms_course.lms_course_name',
                'lms_course.lms_course_id',
                'lms_subject.lms_subject_name',
                'lms_subject.lms_subject_id',
                'lms_topic.lms_topic_name',
                'lms_topic.lms_topic_id',

                DB::raw("
              (case when lms_question_difficulty_level.lms_question_difficulty_level_name = 'Easy' then 'E'
              when lms_question_difficulty_level.lms_question_difficulty_level_name  = 'Medium' then 'M'
              when lms_question_difficulty_level.lms_question_difficulty_level_name  = 'Hard' then 'H'
              ELSE 'aa'
          end) as 'lms_question_difficulty_level_name'"),
                DB::raw("IF(lms_question_bank.lms_question_bank_type_single_multiple = 0, 'S','M')as lms_question_bank_type_single_multiple"),
                DB::raw("IF(lms_question_bank.lms_question_bank_is_active = 1, 'Active','Inactive')as lms_question_bank_is_active"),
                DB::raw("IF(lms_exam_wise_question.lms_question_bank_id >= 0, 'A','N')as lms_question_added_not_added")

            )->orderBy('lms_exam_wise_question.lms_exam_schedule_id', 'desc');

        if ($perPage == -1) {
            return $result->paginate($result->get()->count());
        } else {
            return $result->paginate($perPage);
        }
    }
    }

    public function getAddedMarksQuestionExamWise(Request $request)
    {
        $centerId = $request->centerId;
        $scheduleId = $request->scheduleId;
        $result = DB::select("select lms_exam_wise_question.lms_exam_schedule_id ,sum(lms_question_bank.lms_question_bank_marks) as QuestionMarks, count(lms_question_bank.lms_question_bank_marks) as QuestionNumber
      from lms_question_bank join lms_exam_wise_question on lms_exam_wise_question.lms_question_bank_id = lms_question_bank.lms_question_bank_id
      where lms_exam_wise_question.lms_exam_schedule_id = $scheduleId
      group by lms_exam_wise_question.lms_exam_schedule_id ");
        return $result;
    }

    //Update Department
    public function AddRemoveQuestion(Request $request)
    {
        $centerId = $request->centerId;
        $scheduleId = $request->scheduleId;
        $questionBankId = $request->questionBankId;
        $lms_exam_wise_question_id = $request->lms_exam_wise_question_id;
        $addOrRemove = $request->addOrRemove;
        $loggedUserId = $request->loggedUserId;
        $result = QuestionBankModel::AddRemoveQuestion($centerId
            , $scheduleId, $questionBankId, $lms_exam_wise_question_id, $addOrRemove, $loggedUserId);
        return response()->json($result);

    }

//Enable Disable Question Bank
    public function deleteQuestonBank(Request $request)
    {
        $centerId = $request->centerId;
        $questionBankId = $request->questionBankId;
        $isQuestionBankActive = $request->isQuestionBankActive;
        $loggedUserId = $request->loggedUserId;
        $result = QuestionBankModel::deleteQuestonBank($centerId,
            $questionBankId, $isQuestionBankActive, $loggedUserId);
        return response()->json($result);

    }

}
