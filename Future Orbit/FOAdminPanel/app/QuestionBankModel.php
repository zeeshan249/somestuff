<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class QuestionBankModel extends Model
{

    //Add Remove QuestionBankModel
    // Check Instruction in DB and then Save
    public static function SaveCopyQuestion($centerId,
        $QuestionList, $CourseId, $SubjectId, $TopicId, $loggedUserId) {
        DB::beginTransaction();
        try {

            $insertQuery = DB::insert(
                DB::raw("INSERT INTO `lms_question_bank`
(
`lms_center_id`,
`lms_course_id`,
`lms_subject_id`,
`lms_topic_id`,
`lms_question_difficulty_level_id`,
`lms_question_bank_type_single_multiple`,
`lms_question_bank_has_image`,
`lms_question_bank_image_path`,
`lms_question_bank_text`,
`lms_question_bank_tag`,
`lms_question_bank_options_1`,
`lms_question_bank_options_2`,
`lms_question_bank_options_3`,
`lms_question_bank_options_4`,
`lms_question_bank_options_5`,
`lms_question_bank_options_1_has_image`,
`lms_question_bank_options_2_has_image`,
`lms_question_bank_options_3_has_image`,
`lms_question_bank_options_4_has_image`,
`lms_question_bank_options_5_has_image`,
`lms_question_bank_correct_answers`,
`lms_question_bank_marks`,
`lms_question_bank_no_of_option`,
`lms_question_bank_solution_has_image`,
`lms_question_bank_solution`,
`lms_question_bank_is_active`,
`lms_question_bank_created_by`,
`lms_question_copyId`)

select
$centerId,
$CourseId,
$SubjectId,
$TopicId,
`lms_question_difficulty_level_id`,
`lms_question_bank_type_single_multiple`,
`lms_question_bank_has_image`,
`lms_question_bank_image_path`,
`lms_question_bank_text`,
`lms_question_bank_tag`,
`lms_question_bank_options_1`,
`lms_question_bank_options_2`,
`lms_question_bank_options_3`,
`lms_question_bank_options_4`,
`lms_question_bank_options_5`,
`lms_question_bank_options_1_has_image`,
`lms_question_bank_options_2_has_image`,
`lms_question_bank_options_3_has_image`,
`lms_question_bank_options_4_has_image`,
`lms_question_bank_options_5_has_image`,
`lms_question_bank_correct_answers`,
`lms_question_bank_marks`,
`lms_question_bank_no_of_option`,
`lms_question_bank_solution_has_image`,
`lms_question_bank_solution`,
`lms_question_bank_is_active`,
$loggedUserId,



`lms_question_bank_id`
from `lms_question_bank`
where `lms_question_bank_id` in($QuestionList)
")
            );

            if ($insertQuery > 0) {
                //Success
                $result_data['responseData'] = "2";

            } else {
                // Failed
                $result_data['responseData'] = "1";

            }

            DB::commit();
            return $result_data;
        } catch (Exception $ex) {
            DB::rollback();
            $result_data['responseData'] = "3";
            return $result_data;
        }

    }

    // Add Edit Exam Schedule
    public static function saveEditQuestionBank($centerId, $loggedUserId, $isQuestionBankEdit, $lms_question_bank_id,
        $lms_subject_id, $lms_topic_id, $lms_course_id, $lms_question_difficulty_level_id, $lms_question_bank_type_single_multiple,
        $lms_question_bank_correct_answers, $lms_question_bank_marks,
        $lms_question_bank_no_of_option, $lms_question_bank_text, $lms_question_bank_has_image, $questionImagePathImageName,
        $lms_question_bank_options_1, $lms_question_bank_options_1_has_image
        , $lms_question_bank_options_2, $lms_question_bank_options_2_has_image
        , $lms_question_bank_options_3, $lms_question_bank_options_3_has_image
        , $lms_question_bank_options_4, $lms_question_bank_options_4_has_image, $lms_question_bank_solution, $lms_question_bank_solution_has_image, $lms_question_bank_tag
    ) {

        if ($isQuestionBankEdit == 1) {
            // Edit the Question

            //trans
            DB::beginTransaction();
            try {

                DB::table('lms_question_bank')
                    ->where('lms_question_bank_id', $lms_question_bank_id)
                    ->where('lms_center_id', $centerId)
                    ->update([

                        'lms_question_bank_updated_by' => $loggedUserId,
                        'lms_question_bank_updated_at' => now(),

                        'lms_subject_id' => $lms_subject_id,
                        'lms_topic_id' => $lms_topic_id,
                        'lms_course_id' => $lms_course_id,
                        'lms_question_difficulty_level_id' => $lms_question_difficulty_level_id,
                        'lms_question_bank_type_single_multiple' => $lms_question_bank_type_single_multiple,
                        'lms_question_bank_correct_answers' => $lms_question_bank_correct_answers,
                        'lms_question_bank_marks' => $lms_question_bank_marks,
                        'lms_question_bank_no_of_option' => $lms_question_bank_no_of_option,
                        'lms_question_bank_text' => $lms_question_bank_text,
                        'lms_question_bank_has_image' => $lms_question_bank_has_image,
                        'lms_question_bank_image_path' => $questionImagePathImageName,

                        'lms_question_bank_options_1' => $lms_question_bank_options_1,
                        'lms_question_bank_options_1_has_image' => $lms_question_bank_options_1_has_image,

                        'lms_question_bank_options_2' => $lms_question_bank_options_2,
                        'lms_question_bank_options_2_has_image' => $lms_question_bank_options_2_has_image,

                        'lms_question_bank_options_3' => $lms_question_bank_options_3,
                        'lms_question_bank_options_3_has_image' => $lms_question_bank_options_3_has_image,

                        'lms_question_bank_options_4' => $lms_question_bank_options_4,
                        'lms_question_bank_options_4_has_image' => $lms_question_bank_options_4_has_image,

                        'lms_question_bank_solution' => $lms_question_bank_solution,
                        'lms_question_bank_solution_has_image' => $lms_question_bank_solution_has_image,

                        'lms_question_bank_tag' => $lms_question_bank_tag,

                    ]);

                DB::commit();
                // Edit Success
                $result_data['responseData'] = 6;

                return $result_data;

            } catch (Exception $ex) {

                DB::rollback();

                $result_data['responseData'] = 7;
                return $result_data;
            }
            //End

        } else {
            //Save the enquiry
            //trans
            DB::beginTransaction();
            try {

                $questionBankCreateQuery = DB::table('lms_question_bank')->insertGetId(
                    [

                        'lms_center_id' => $centerId,
                        'lms_question_bank_created_by' => $loggedUserId,
                        'lms_question_bank_created_at' => now(),
                        'lms_subject_id' => $lms_subject_id,
                        'lms_topic_id' => $lms_topic_id,
                        'lms_course_id' => $lms_course_id,
                        'lms_question_difficulty_level_id' => $lms_question_difficulty_level_id,
                        'lms_question_bank_type_single_multiple' => $lms_question_bank_type_single_multiple,
                        'lms_question_bank_correct_answers' => $lms_question_bank_correct_answers,
                        'lms_question_bank_marks' => $lms_question_bank_marks,
                        'lms_question_bank_no_of_option' => $lms_question_bank_no_of_option,
                        'lms_question_bank_text' => $lms_question_bank_text,
                        'lms_question_bank_has_image' => $lms_question_bank_has_image,
                        'lms_question_bank_image_path' => $questionImagePathImageName,

                        'lms_question_bank_options_1' => $lms_question_bank_options_1,
                        'lms_question_bank_options_1_has_image' => $lms_question_bank_options_1_has_image,

                        'lms_question_bank_options_2' => $lms_question_bank_options_2,
                        'lms_question_bank_options_2_has_image' => $lms_question_bank_options_2_has_image,

                        'lms_question_bank_options_3' => $lms_question_bank_options_3,
                        'lms_question_bank_options_3_has_image' => $lms_question_bank_options_3_has_image,

                        'lms_question_bank_options_4' => $lms_question_bank_options_4,
                        'lms_question_bank_options_4_has_image' => $lms_question_bank_options_4_has_image,

                        'lms_question_bank_solution' => $lms_question_bank_solution,
                        'lms_question_bank_solution_has_image' => $lms_question_bank_solution_has_image,

                        'lms_question_bank_tag' => $lms_question_bank_tag,
                    ]
                );

                DB::commit();
                // If saved success
                $result_data['responseData'] = 4;
                $result_data['lms_question_bank_id'] = $questionBankCreateQuery;
                //$result_data['enquiryCode'] = $enquiryCode;

                return $result_data;
            } catch (Exception $ex) {

                DB::rollback();

                if (file_exists(storage_path('app/public/question_images/' . $questionImagePathImageName))) {
                    unlink(storage_path('app/public/question_images/' . $questionImagePathImageName));
                }

                $result_data['responseData'] = 5;
                return $result_data;
            }

        }

    }

    // Add Edit Exam Schedule
    public static function saveEditQuestionBank_withOption5($centerId, $loggedUserId, $isQuestionBankEdit, $lms_question_bank_id,
        $lms_subject_id, $lms_topic_id, $lms_course_id, $lms_question_difficulty_level_id, $lms_question_bank_type_single_multiple,
        $lms_question_bank_correct_answers, $lms_question_bank_marks,
        $lms_question_bank_no_of_option, $lms_question_bank_text, $lms_question_bank_has_image, $questionImagePathImageName,
        $lms_question_bank_options_1, $lms_question_bank_options_1_has_image
        , $lms_question_bank_options_2, $lms_question_bank_options_2_has_image
        , $lms_question_bank_options_3, $lms_question_bank_options_3_has_image
        , $lms_question_bank_options_4, $lms_question_bank_options_4_has_image
        , $lms_question_bank_options_5, $lms_question_bank_options_5_has_image, $lms_question_bank_solution, $lms_question_bank_solution_has_image, $lms_question_bank_tag) {

        if ($isQuestionBankEdit == 1) {
            // Edit the Enquiry

            //trans
            DB::beginTransaction();
            try {

                DB::table('lms_exam_schedule')
                    ->where('lms_exam_schedule_id', $scheduleId)
                    ->where('lms_center_id', $centerId)
                    ->update([

                        'lms_exam_schedule_updated_by' => $loggedUserId,
                        'lms_exam_schedule_updated_at' => now(),

                        'lms_course_id' => $lms_course_id,
                        'lms_exam_instruction_id' => $lms_exam_instruction_id,
                        'lms_exam_schedule_type' => $lms_exam_schedule_type,
                        'lms_exam_schedule_name' => $lms_exam_schedule_name,
                        'lms_exam_schedule_description' => $lms_exam_schedule_description,
                        'lms_exam_schedule_negative_marking' => $lms_exam_schedule_negative_marking,
                        'lms_exam_schedule_result_display_type' => $lms_exam_schedule_result_display_type,

                        'lms_exam_schedule_max_marks' => $lms_exam_schedule_max_marks,
                        'lms_exam_schedule_total_time_alloted' => $lms_exam_schedule_total_time_alloted,
                        'lms_exam_schedule_is_free_paid' => $lms_exam_schedule_is_free_paid,
                        'lms_exam_schedule_pass_marks' => $lms_exam_schedule_pass_marks,
                        'lms_exam_schedule_has_negative_marking' => $lms_exam_schedule_has_negative_marking,
                        'lms_exam_schedule_live_from' => $lms_exam_schedule_live_from,
                        'lms_exam_schedule_live_to' => $lms_exam_schedule_live_to,
                        'lms_exam_schedule_is_active' => '1',
                        'lms_exam_schedule_image' => $examImageName,

                    ]);

                DB::commit();
                // Edit Success
                $result_data['responseData'] = 6;

                return $result_data;

            } catch (Exception $ex) {

                DB::rollback();

                $result_data['responseData'] = 7;
                return $result_data;
            }
            //End

        } else {
            //Save the enquiry
            //trans
            DB::beginTransaction();
            try {

                $questionBankCreateQuery = DB::table('lms_question_bank')->insertGetId(
                    [

                        'lms_center_id' => $centerId,
                        'lms_question_bank_created_by' => $loggedUserId,
                        'lms_question_bank_created_at' => now(),
                        'lms_subject_id' => $lms_subject_id,
                        'lms_topic_id' => $lms_topic_id,
                        'lms_course_id' => $lms_course_id,
                        'lms_question_difficulty_level_id' => $lms_question_difficulty_level_id,
                        'lms_question_bank_type_single_multiple' => $lms_question_bank_type_single_multiple,
                        'lms_question_bank_correct_answers' => $lms_question_bank_correct_answers,
                        'lms_question_bank_marks' => $lms_question_bank_marks,
                        'lms_question_bank_no_of_option' => $lms_question_bank_no_of_option,
                        'lms_question_bank_text' => $lms_question_bank_text,
                        'lms_question_bank_has_image' => $lms_question_bank_has_image,
                        'lms_question_bank_image_path' => $questionImagePathImageName,

                        'lms_question_bank_options_1' => $lms_question_bank_options_1,
                        'lms_question_bank_options_1_has_image' => $lms_question_bank_options_1_has_image,

                        'lms_question_bank_options_2' => $lms_question_bank_options_2,
                        'lms_question_bank_options_2_has_image' => $lms_question_bank_options_2_has_image,

                        'lms_question_bank_options_3' => $lms_question_bank_options_3,
                        'lms_question_bank_options_3_has_image' => $lms_question_bank_options_3_has_image,

                        'lms_question_bank_options_4' => $lms_question_bank_options_4,
                        'lms_question_bank_options_4_has_image' => $lms_question_bank_options_4_has_image,

                        'lms_question_bank_options_5' => $lms_question_bank_options_5,
                        'lms_question_bank_options_5_has_image' => $lms_question_bank_options_5_has_image,

                        'lms_question_bank_solution' => $lms_question_bank_solution,
                        'lms_question_bank_solution_has_image' => $lms_question_bank_solution_has_image,

                        'lms_question_bank_tag' => $lms_question_bank_tag,

                    ]
                );

                DB::commit();
                // If saved success
                $result_data['responseData'] = 4;
                $result_data['lms_question_bank_id'] = $questionBankCreateQuery;
                //$result_data['enquiryCode'] = $enquiryCode;

                return $result_data;
            } catch (Exception $ex) {

                DB::rollback();

                if (file_exists(storage_path('app/public/question_images/' . $questionImagePathImageName))) {
                    unlink(storage_path('app/public/question_images/' . $questionImagePathImageName));
                }

                $result_data['responseData'] = 5;
                return $result_data;
            }

        }

    }

    //Add Remove QuestionBankModel
    // Check Instruction in DB and then Save
    public static function AddRemoveQuestion($centerId, $scheduleId, $questionBankId, $lms_exam_wise_question_id, $addOrRemove, $loggedUserId)
    {
        DB::beginTransaction();
        try {

            if ($addOrRemove == "Add") {
                $insertQuery = DB::table('lms_exam_wise_question')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_exam_schedule_id' => $scheduleId,
                        'lms_question_bank_id' => $questionBankId,
                        'lms_exam_wise_question_created_by' => $loggedUserId,

                    ]
                );
                $insertQuery = DB::update(DB::raw("update lms_exam_schedule set total_assigned_question= total_assigned_question+1 where lms_exam_schedule_id=$scheduleId"));
                if ($insertQuery > 0) {
                    // Department Saved
                    $result_data['responseData'] = "2";

                } else {
                    // Failed to save Department
                    $result_data['responseData'] = "1";

                }
            } else {
                $deleteQuery = DB::delete("delete from lms_exam_wise_question where lms_exam_wise_question_id=?", [$lms_exam_wise_question_id]);
                $updateQuery = DB::update(DB::raw("update lms_exam_schedule set total_assigned_question= total_assigned_question-1 where lms_exam_schedule_id=$scheduleId"));

                if ($deleteQuery > 0) {
                    $result_data['responseData'] = "2";

                } else {
                    $result_data['responseData'] = "1";

                }
            }

            DB::commit();
            return $result_data;
        } catch (Exception $ex) {
            DB::rollback();
            $result_data['responseData'] = "3";
            return $result_data;
        }

    }

// Enable Disable Question Bank
    public static function deleteQuestonBank($centerId,
        $questionBankId, $isQuestionBankActive, $loggedUserId) {

//trans

        $exception = DB::transaction(function () use (
            $centerId,
            $questionBankId, $isQuestionBankActive, $loggedUserId
        ) {

            DB::table('lms_question_bank')
                ->where('lms_question_bank_id', $questionBankId)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_question_bank_is_active' => $isQuestionBankActive,
                    'lms_question_bank_updated_at' => now(),
                    'lms_question_bank_updated_by' => $loggedUserId,

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
