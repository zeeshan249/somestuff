<?php

namespace App\Http\Controllers;

use App\ExamReportModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamReportController extends Controller
{
    public function __construct()
    {
    }

    //Get All Active Exam Types without pagination
    public function getAllActiveExamTypeWithoutPagination(Request $request)
    {
        $centerId = $request->centerId;

        $getQuery = DB::table("lms_exam_schedule")->select(['lms_exam_schedule_type'])
            ->where('lms_exam_schedule_is_active', 1)
            ->where('lms_center_id', $centerId)
            ->distinct()
            ->get();
        return $getQuery;
    }

    //Get All Active Instruction Types without pagination
    public function getAllActiveInstructionWithoutPagination(Request $request)
    {
        $centerId = $request->centerId;

        $getQuery = DB::table("lms_exam_instruction")->select(['lms_exam_instruction_title', 'lms_exam_instruction_id'])
            ->where('lms_exam_instruction_is_active', 1)
            ->where('lms_center_id', $centerId)
            ->distinct()
            ->get();
        return $getQuery;
    }

    //Get All Active Instruction Types without pagination
    public function web_get_active_schedule_type_without_pagination(Request $request)
    {
        $centerId = $request->centerId;

        $getQuery = DB::table("lms_exam_schedule_type")->select(['lms_exam_schedule_type'])
            ->where('lms_exam_schedule_type_is_active', 1)
            ->where('lms_center_id', $centerId)
            ->distinct()
            ->get();
        return $getQuery;
    }

    //--------------------------------OLD-------------------------------
    public function getAllExamSchedule_Report(Request $request)
    {
        $perPage = $request->perPage ? $request->perPage : 200;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_exam_schedule')
            ->join('lms_exam_instruction', 'lms_exam_instruction.lms_exam_instruction_id', '=', 'lms_exam_schedule.lms_exam_instruction_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_exam_schedule.lms_course_id')
            ->join('lms_exam_result', 'lms_exam_result.lms_exam_schedule_id', '=', 'lms_exam_schedule.lms_exam_schedule_id')
            ->where('lms_exam_schedule.lms_center_id', '=', $centerId)

            // ->where('lms_exam_schedule.lms_exam_schedule_live_from', '<=', now())

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_exam_schedule.lms_exam_schedule_name', 'like', "%$filterBy%")
                    ->orWhere('lms_course.lms_course_name', 'like', "%$filterBy%")
                    ->orWhere('lms_exam_schedule.lms_exam_schedule_type', 'like', "%$filterBy%");
            })

            ->select(
                'lms_exam_schedule.lms_exam_schedule_id',

                'lms_exam_schedule.lms_exam_schedule_type',
                'lms_exam_schedule.lms_exam_schedule_name',
                'lms_exam_schedule.lms_exam_schedule_description',
                'lms_exam_schedule.lms_exam_schedule_negative_marking',
                'lms_exam_schedule.lms_exam_schedule_result_display_type',
                'lms_exam_schedule.lms_exam_schedule_no_of_question',
                'lms_exam_schedule.lms_exam_schedule_max_marks',
                'lms_exam_schedule.lms_exam_schedule_total_time_alloted',
                'lms_exam_schedule.lms_exam_schedule_is_free_paid',
                'lms_exam_schedule.lms_exam_schedule_pass_marks',
                'lms_exam_schedule.lms_exam_schedule_has_negative_marking',
                'lms_exam_schedule.lms_exam_schedule_solution_display_type',
                'lms_exam_schedule.lms_exam_schedule_image',
                'lms_course.lms_course_id',
                'lms_exam_instruction.lms_exam_instruction_id',
                'lms_exam_instruction.lms_exam_instruction_title',
                DB::raw("(select count(lms_exam_result_details.lms_registration_id) from lms_exam_result_details  where lms_exam_result_details.lms_exam_schedule_id= lms_exam_schedule.lms_exam_schedule_id ) as StudentCount"),
                DB::raw("IF(lms_exam_schedule.lms_exam_schedule_is_active = 1, 'Active','Inactive')as lms_exam_schedule_is_active_status"),
                DB::raw("IF(lms_exam_schedule.lms_exam_schedule_has_negative_marking = 1, 'Required','Not Required')as lms_exam_schedule_has_negative_marking_status"),
                DB::raw("IF(lms_exam_schedule.lms_exam_schedule_is_free_paid = 1, 'Free','Paid')as lms_exam_schedule_is_free_paid_status"),
                DB::raw('lms_course.lms_course_name as lms_course_name'),
                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_from,'%d-%m-%y') as lms_exam_schedule_live_from"),
                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_to,'%d-%m-%y') as lms_exam_schedule_live_to"),

                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_from,'%Y-%m-%d %H:%i:%s') as lms_exam_schedule_live_from_date"),
                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_to,'%Y-%m-%d %H:%i:%s') as lms_exam_schedule_live_to_date"),

                DB::raw("
                (case when lms_exam_schedule.lms_exam_schedule_live_to < now() then 'Over'
                when lms_exam_schedule.lms_exam_schedule_live_from <= now() and lms_exam_schedule.lms_exam_schedule_live_to >= now() then 'Live'
                when lms_exam_schedule.lms_exam_schedule_live_from >= now() and lms_exam_schedule.lms_exam_schedule_live_to >= now() then 'Upcoming'
                ELSE 'Upcoming'
            end) as 'lms_exam_schedule_is_active_live'")

            )
            ->orderBy('lms_exam_schedule.lms_exam_schedule_live_to', 'desc')
            ->orderBy('lms_exam_schedule.lms_exam_schedule_type', 'desc')
            ->groupBy('lms_exam_schedule.lms_exam_schedule_id')

            ->paginate($perPage);
        return $result;
    }


    public function getStudentWiseExamSchedule_Report(Request $request)
    {
        $perPage = $request->perPage ? $request->perPage : 200;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $lms_exam_schedule_id = $request->lms_exam_schedule_id;
        $result = DB::table('lms_exam_schedule')
            ->join('lms_exam_instruction', 'lms_exam_instruction.lms_exam_instruction_id', '=', 'lms_exam_schedule.lms_exam_instruction_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_exam_schedule.lms_course_id')
            ->join('lms_exam_result_details', 'lms_exam_result_details.lms_exam_schedule_id', '=', 'lms_exam_schedule.lms_exam_schedule_id')
            ->join('lms_student', 'lms_student.lms_student_id', '=', 'lms_exam_result_details.lms_student_id')
            // ->join('lms_student', 'lms_student.lms_student_id', '=', 'lms_exam_result_details.lms_student_id')
            ->where('lms_exam_schedule.lms_center_id', '=', $centerId)
            ->where('lms_exam_schedule.lms_exam_schedule_id', '=', $lms_exam_schedule_id)

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_exam_schedule.lms_exam_schedule_name', 'like', "%$filterBy%")
                    ->orWhere('lms_course.lms_course_name', 'like', "%$filterBy%")
                    ->orWhere('lms_exam_schedule.lms_exam_schedule_type', 'like', "%$filterBy%");
            })

            ->select(
                'lms_exam_schedule.lms_exam_schedule_id',
                'lms_student.lms_student_full_name',
                'lms_exam_result_details.lms_total_marks_scored',
                'lms_exam_result_details.lms_total_answer_attempted',
                DB::raw("date_format(lms_exam_result_details.lms_exam_result_created_at,'%d-%m-%y %H:%i:%s') as lms_exam_result_created_at"),
                DB::raw("date_format(lms_exam_result_details.lms_exam_result_details_submitted_at,'%d-%m-%y %H:%i:%s') as lms_exam_result_details_submitted_at"),
                'lms_exam_schedule.lms_exam_schedule_type',
                'lms_exam_schedule.lms_exam_schedule_name',
                'lms_exam_schedule.lms_exam_schedule_description',
                'lms_exam_schedule.lms_exam_schedule_negative_marking',
                'lms_exam_schedule.lms_exam_schedule_result_display_type',
                'lms_exam_schedule.lms_exam_schedule_no_of_question',
                'lms_exam_schedule.lms_exam_schedule_max_marks',
                'lms_exam_schedule.lms_exam_schedule_total_time_alloted',
                'lms_exam_schedule.lms_exam_schedule_is_free_paid',
                'lms_exam_schedule.lms_exam_schedule_pass_marks',
                'lms_exam_schedule.lms_exam_schedule_has_negative_marking',
                'lms_exam_schedule.lms_exam_schedule_solution_display_type',
                'lms_exam_schedule.lms_exam_schedule_image',
                'lms_course.lms_course_id',
                'lms_exam_instruction.lms_exam_instruction_id',
                'lms_exam_instruction.lms_exam_instruction_title',

                DB::raw("IF(lms_exam_result_details.lms_exam_result_details_is_active = 1, 'Active','Submitted')as lms_exam_result_details_is_active"),
                DB::raw("IF(lms_exam_schedule.lms_exam_schedule_has_negative_marking = 1, 'Required','Not Required')as lms_exam_schedule_has_negative_marking_status"),
                DB::raw("IF(lms_exam_schedule.lms_exam_schedule_is_free_paid = 1, 'Free','Paid')as lms_exam_schedule_is_free_paid_status"),
                DB::raw('lms_course.lms_course_name as lms_course_name'),
                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_from,'%d-%m-%y') as lms_exam_schedule_live_from"),
                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_to,'%d-%m-%y') as lms_exam_schedule_live_to"),

                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_from,'%d-%m-%y %H:%i:%s') as lms_exam_schedule_live_from_date"),
                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_to,'%d-%m-%y %H:%i:%s') as lms_exam_schedule_live_to_date"),

                DB::raw("
                (case when lms_exam_schedule.lms_exam_schedule_live_to < now() then 'Over'
                when lms_exam_schedule.lms_exam_schedule_live_from <= now() and lms_exam_schedule.lms_exam_schedule_live_to >= now() then 'Live'
                when lms_exam_schedule.lms_exam_schedule_live_from >= now() and lms_exam_schedule.lms_exam_schedule_live_to >= now() then 'Upcoming'
                ELSE 'Upcoming'
            end) as 'lms_exam_schedule_is_active_live'")

            )
            ->orderBy('lms_exam_result_details.lms_total_marks_scored', 'desc')
            //->orderBy('lms_exam_result_details.lms_exam_result_details_submitted_at', 'desc')

            ->paginate($perPage);
        return $result;
    }


    public function getStudentWiseReport(Request $request)
    {
        $perPage = $request->perPage ? $request->perPage : 200;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $lms_student_id = $request->lms_student_id;
        $result = DB::table('lms_exam_schedule')
            ->join('lms_exam_instruction', 'lms_exam_instruction.lms_exam_instruction_id', '=', 'lms_exam_schedule.lms_exam_instruction_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_exam_schedule.lms_course_id')
            ->join('lms_exam_result_details', 'lms_exam_result_details.lms_exam_schedule_id', '=', 'lms_exam_schedule.lms_exam_schedule_id')
            ->join('lms_student', 'lms_student.lms_student_id', '=', 'lms_exam_result_details.lms_student_id')
            // ->join('lms_student', 'lms_student.lms_student_id', '=', 'lms_exam_result_details.lms_student_id')
            ->where('lms_exam_schedule.lms_center_id', '=', $centerId)
            ->where('lms_exam_result_details.lms_student_id', '=', $lms_student_id)

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_exam_schedule.lms_exam_schedule_name', 'like', "%$filterBy%")
                    ->orWhere('lms_course.lms_course_name', 'like', "%$filterBy%")
                    ->orWhere('lms_exam_schedule.lms_exam_schedule_type', 'like', "%$filterBy%");
            })

            ->select(
                'lms_exam_schedule.lms_exam_schedule_id',
                'lms_student.lms_student_full_name',
                'lms_exam_result_details.lms_total_marks_scored',
                'lms_exam_result_details.lms_total_answer_attempted',
                DB::raw("date_format(lms_exam_result_details.lms_exam_result_created_at,'%d-%m-%y %H:%i:%s') as lms_exam_result_created_at"),
                DB::raw("date_format(lms_exam_result_details.lms_exam_result_details_submitted_at,'%d-%m-%y %H:%i:%s') as lms_exam_result_details_submitted_at"),
                'lms_exam_schedule.lms_exam_schedule_type',
                'lms_exam_schedule.lms_exam_schedule_name',
                'lms_exam_schedule.lms_exam_schedule_description',
                'lms_exam_schedule.lms_exam_schedule_negative_marking',
                'lms_exam_schedule.lms_exam_schedule_result_display_type',
                'lms_exam_schedule.lms_exam_schedule_no_of_question',
                'lms_exam_schedule.lms_exam_schedule_max_marks',
                'lms_exam_schedule.lms_exam_schedule_total_time_alloted',
                'lms_exam_schedule.lms_exam_schedule_is_free_paid',
                'lms_exam_schedule.lms_exam_schedule_pass_marks',
                'lms_exam_schedule.lms_exam_schedule_has_negative_marking',
                'lms_exam_schedule.lms_exam_schedule_solution_display_type',
                'lms_exam_schedule.lms_exam_schedule_image',
                'lms_course.lms_course_id',
                'lms_exam_instruction.lms_exam_instruction_id',
                'lms_exam_instruction.lms_exam_instruction_title',

                DB::raw("IF(lms_exam_result_details.lms_exam_result_details_is_active = 1, 'Active','Submitted')as lms_exam_result_details_is_active"),
                DB::raw("IF(lms_exam_schedule.lms_exam_schedule_has_negative_marking = 1, 'Required','Not Required')as lms_exam_schedule_has_negative_marking_status"),
                DB::raw("IF(lms_exam_schedule.lms_exam_schedule_is_free_paid = 1, 'Free','Paid')as lms_exam_schedule_is_free_paid_status"),
                DB::raw('lms_course.lms_course_name as lms_course_name'),
                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_from,'%d-%m-%y') as lms_exam_schedule_live_from"),
                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_to,'%d-%m-%y') as lms_exam_schedule_live_to"),

                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_from,'%d-%m-%y %H:%i:%s') as lms_exam_schedule_live_from_date"),
                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_to,'%d-%m-%y %H:%i:%s') as lms_exam_schedule_live_to_date"),

                DB::raw("
                (case when lms_exam_schedule.lms_exam_schedule_live_to < now() then 'Over'
                when lms_exam_schedule.lms_exam_schedule_live_from <= now() and lms_exam_schedule.lms_exam_schedule_live_to >= now() then 'Live'
                when lms_exam_schedule.lms_exam_schedule_live_from >= now() and lms_exam_schedule.lms_exam_schedule_live_to >= now() then 'Upcoming'
                ELSE 'Upcoming'
            end) as 'lms_exam_schedule_is_active_live'")

            )
            ->orderBy('lms_exam_result_details.lms_total_marks_scored', 'desc')
            //->orderBy('lms_exam_result_details.lms_exam_result_details_submitted_at', 'desc')

            ->paginate($perPage);
        return $result;
    }
}
