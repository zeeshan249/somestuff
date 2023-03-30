<?php

namespace App;

use DB;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ExamReportModel extends Model
{
    protected $primaryKey = "lms_staff_id";
    protected $table = "lms_staff";
    public $timestamps = false;
    // Enable Disable Staff
    public static function enableDisableExamSchedule($centerId,
        $scheduleId, $isExamScheduleActive, $loggedUserId) {

        //trans

        $exception = DB::transaction(function () use (
            $centerId,
            $scheduleId, $isExamScheduleActive, $loggedUserId
        ) {

            DB::table('lms_exam_schedule')
                ->where('lms_exam_schedule_id', $scheduleId)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_exam_schedule_is_active' => $isExamScheduleActive,
                    'lms_exam_schedule_updated_at' => now(),
                    'lms_exam_schedule_updated_by' => $loggedUserId,

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

    // Add Edit Exam Schedule
    public static function saveEditExamSchedule($centerId,
        $scheduleId, $loggedUserId, $enquiryUserId, $lms_exam_instruction_id, $lms_course_id,
        $lms_exam_schedule_type, $lms_exam_schedule_name, $lms_exam_schedule_description, $lms_exam_schedule_no_of_question,
        $lms_exam_schedule_max_marks, $lms_exam_schedule_has_negative_marking, $lms_exam_schedule_negative_marking, $lms_exam_schedule_result_display_type, $lms_exam_schedule_live_from, $lms_exam_schedule_live_to,
        $lms_exam_schedule_total_time_alloted, $lms_exam_schedule_pass_marks, $lms_exam_schedule_is_free_paid, $lms_exam_schedule_solution_display_type,
        $isExamScheduleEdit, $examImageName) {

        if ($isExamScheduleEdit == 1) {
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
                        'lms_exam_schedule_no_of_question' => $lms_exam_schedule_no_of_question,
                        'lms_exam_schedule_max_marks' => $lms_exam_schedule_max_marks,
                        'lms_exam_schedule_total_time_alloted' => $lms_exam_schedule_total_time_alloted,
                        'lms_exam_schedule_is_free_paid' => $lms_exam_schedule_is_free_paid,
                        'lms_exam_schedule_solution_display_type' => $lms_exam_schedule_solution_display_type,
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
                $enquiryCreateQuery = DB::table('lms_exam_schedule')->insertGetId(
                    [

                        'lms_center_id' => $centerId,
                        'lms_exam_schedule_created_by' => $loggedUserId,
                        'lms_course_id' => $lms_course_id,
                        'lms_exam_instruction_id' => $lms_exam_instruction_id,
                        'lms_exam_schedule_type' => $lms_exam_schedule_type,
                        'lms_exam_schedule_name' => $lms_exam_schedule_name,
                        'lms_exam_schedule_description' => $lms_exam_schedule_description,
                        'lms_exam_schedule_negative_marking' => $lms_exam_schedule_negative_marking,
                        'lms_exam_schedule_result_display_type' => $lms_exam_schedule_result_display_type,
                        'lms_exam_schedule_no_of_question' => $lms_exam_schedule_no_of_question,
                        'lms_exam_schedule_max_marks' => $lms_exam_schedule_max_marks,
                        'lms_exam_schedule_total_time_alloted' => $lms_exam_schedule_total_time_alloted,
                        'lms_exam_schedule_is_free_paid' => $lms_exam_schedule_is_free_paid,
                        'lms_exam_schedule_solution_display_type' => $lms_exam_schedule_solution_display_type,
                        'lms_exam_schedule_pass_marks' => $lms_exam_schedule_pass_marks,
                        'lms_exam_schedule_has_negative_marking' => $lms_exam_schedule_has_negative_marking,
                        'lms_exam_schedule_live_from' => $lms_exam_schedule_live_from,
                        'lms_exam_schedule_live_to' => $lms_exam_schedule_live_to,
                        'lms_exam_schedule_is_active' => '1',
                        'lms_exam_schedule_image' => $examImageName,

                    ]
                );

                DB::commit();
                // If saved success
                $result_data['responseData'] = 4;
                $result_data['examScheduleId'] = $enquiryCreateQuery;
                //$result_data['enquiryCode'] = $enquiryCode;

                return $result_data;
            } catch (Exception $ex) {

                DB::rollback();

                if (file_exists(storage_path('app/public/course_images/' . $examImageName))) {
                    unlink(storage_path('app/public/course_images/' . $examImageName));
                }

                $result_data['responseData'] = 5;
                return $result_data;
            }

        }

    }

//=============================Instruction Start ================================================================

// Check Instruction in DB and then Save
    public static function saveInstruction($centerId,
        $instructionName, $isSaveEditClicked, $instructionId, $loggedUserId, $instructionContentName) {
        if ($isSaveEditClicked == 1) {
            // If save Department is clicked
            $getQuery = DB::table("lms_exam_instruction")->
                where('lms_center_id', $centerId)->
                where('lms_exam_instruction_title', $instructionName)
                ->get();
            if ($getQuery->count() > 0) {
                // Department Exists
                $result_data['responseData'] = "1";

            } else {
                $saveQuery = DB::table('lms_exam_instruction')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_exam_instruction_title' => $instructionName,
                        'lms_exam_instruction_content' => $instructionContentName,
                        'lms_exam_instruction_created_by' => $loggedUserId,

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
            $updateQuery = DB::table('lms_exam_instruction')
                ->where('lms_exam_instruction_id', $instructionId)
                ->where('lms_center_id', $centerId)
                ->update([
                    'lms_exam_instruction_title' => $instructionName,
                    'lms_exam_instruction_content' => $instructionContentName,
                    'lms_exam_instruction_updated_at' => now(),
                    'lms_exam_instruction_updated_by' => $loggedUserId,

                ]);
            if ($updateQuery > 0) {
                $result_data['responseData'] = "4";

            } else {
                $result_data['responseData'] = "5";

            }
        }
        return $result_data;

    }

    // Enable Disable Instruction
    public static function enableDisableInstruction($centerId
        , $instructionId, $isInstructionActive, $loggedUserId) {
        $updateQuery = DB::table('lms_exam_instruction')
            ->where('lms_exam_instruction_id', $instructionId)
            ->where('lms_center_id', $centerId)
            ->update([
                'lms_exam_instruction_is_active' => $isInstructionActive,
                'lms_exam_instruction_updated_at' => now(),
                'lms_exam_instruction_updated_by' => $loggedUserId,

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";

        } else {
            $result_data['responseData'] = "2";

        }
        return $result_data;

    }
//============================= Instruction End =================================================================

}
