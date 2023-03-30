<?php

namespace App\Http\Controllers;

use App\ExamModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function __construct()
    {

    }


  //Get All Active Exam Types without pagination
  public function getAllActiveExamTypeWithoutPagination(Request $request)
  {
      $centerId = $request->centerId;

      $getQuery= DB::table("lms_exam_schedule")->
          select(['lms_exam_schedule_type'])
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

       $getQuery= DB::table("lms_exam_instruction")->
           select(['lms_exam_instruction_title','lms_exam_instruction_id'])
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

        $getQuery= DB::table("lms_exam_schedule_type")->
            select(['lms_exam_schedule_type'])
            ->where('lms_exam_schedule_type_is_active', 1)
            ->where('lms_center_id', $centerId)
            ->distinct()
            ->get();
            return $getQuery;

    }


    //--------------------------------OLD-------------------------------
    public function getAllExamSchedule(Request $request)
    {
        $perPage = $request->perPage ? $request->perPage : 200;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_exam_schedule')
        ->join('lms_exam_instruction', 'lms_exam_instruction.lms_exam_instruction_id', '=', 'lms_exam_schedule.lms_exam_instruction_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_exam_schedule.lms_course_id')
            ->where('lms_exam_schedule.lms_center_id', '=', $centerId)
            ->Where('lms_exam_schedule.lms_exam_schedule_live_from', '<=', now())
            ->where('lms_exam_schedule.lms_exam_schedule_live_to', '>=', now())


            ->where(function ($q) use ($filterBy) {
                $q->where('lms_exam_schedule.lms_exam_schedule_name', 'like', "%$filterBy%")
                    ->orWhere('lms_course.lms_course_name', 'like', "%$filterBy%")
                    ->orWhere('lms_exam_schedule.lms_exam_schedule_type', 'like', "%$filterBy%");
            })

            ->select('lms_exam_schedule.lms_exam_schedule_id',
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
                'lms_exam_schedule.lms_child_course_id',
                'lms_course.lms_course_id',
                'lms_exam_instruction.lms_exam_instruction_id',
                'lms_exam_instruction.lms_exam_instruction_title',


                DB::raw("IF(lms_exam_schedule.lms_exam_schedule_is_active = 1, 'Active','Inactive')as lms_exam_schedule_is_active_status"),
                DB::raw("IF(lms_exam_schedule.lms_exam_schedule_has_negative_marking = 1, 'Required','Not Required')as lms_exam_schedule_has_negative_marking_status"),
                DB::raw("IF(lms_exam_schedule.lms_exam_schedule_is_free_paid = 1, 'Free','Paid')as lms_exam_schedule_is_free_paid_status"),
                DB::raw('lms_course.lms_course_name as lms_course_name'),
                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_from,'%d-%m-%y') as lms_exam_schedule_live_from"),
                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_to,'%d-%m-%y') as lms_exam_schedule_live_to"),

                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_from,'%Y-%m-%d %H:%i:%s') as lms_exam_schedule_live_from_date"),
                DB::raw("date_format(lms_exam_schedule.lms_exam_schedule_live_to,'%Y-%m-%d %H:%i:%s') as lms_exam_schedule_live_to_date"),



                DB::raw("
                (case 
                when lms_exam_schedule.lms_exam_schedule_live_from <= now() and lms_exam_schedule.lms_exam_schedule_live_to >= now() then 'Live'
                ELSE 'Upcoming'
            end) as 'lms_exam_schedule_is_active_live'")

                )
                ->orderBy('lms_exam_schedule_is_active_live', 'asc')



            ->paginate($perPage);
        return $result;
    }


    public function getAllExamSchedule_upcoming(Request $request)
    {
        $perPage = $request->perPage ? $request->perPage : 200;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_exam_schedule')
        ->join('lms_exam_instruction', 'lms_exam_instruction.lms_exam_instruction_id', '=', 'lms_exam_schedule.lms_exam_instruction_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_exam_schedule.lms_course_id')
            ->where('lms_exam_schedule.lms_center_id', '=', $centerId)
            ->Where('lms_exam_schedule.lms_exam_schedule_live_from', '>=', now())
            ->where('lms_exam_schedule.lms_exam_schedule_live_to', '>=', now())


            ->where(function ($q) use ($filterBy) {
                $q->where('lms_exam_schedule.lms_exam_schedule_name', 'like', "%$filterBy%")
                    ->orWhere('lms_course.lms_course_name', 'like', "%$filterBy%")
                    ->orWhere('lms_exam_schedule.lms_exam_schedule_type', 'like', "%$filterBy%");
            })

            ->select('lms_exam_schedule.lms_exam_schedule_id',
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
                'lms_exam_schedule.lms_child_course_id',
                'lms_course.lms_course_id',
                'lms_exam_instruction.lms_exam_instruction_id',
                'lms_exam_instruction.lms_exam_instruction_title',


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
                ->orderBy('lms_exam_schedule_is_active_live', 'asc')



            ->paginate($perPage);
        return $result;
    }
    public function getAllExamSchedule_over(Request $request)
    {
        $perPage = $request->perPage ? $request->perPage : 200;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $result = DB::table('lms_exam_schedule')
        ->join('lms_exam_instruction', 'lms_exam_instruction.lms_exam_instruction_id', '=', 'lms_exam_schedule.lms_exam_instruction_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_exam_schedule.lms_course_id')
            ->where('lms_exam_schedule.lms_center_id', '=', $centerId)
            ->Where('lms_exam_schedule.lms_exam_schedule_live_to', '<', now())


            ->where(function ($q) use ($filterBy) {
                $q->where('lms_exam_schedule.lms_exam_schedule_name', 'like', "%$filterBy%")
                    ->orWhere('lms_course.lms_course_name', 'like', "%$filterBy%")
                    ->orWhere('lms_exam_schedule.lms_exam_schedule_type', 'like', "%$filterBy%");
            })

            ->select('lms_exam_schedule.lms_exam_schedule_id',
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
                'lms_exam_schedule.lms_child_course_id',
                'lms_course.lms_course_id',
                'lms_exam_instruction.lms_exam_instruction_id',
                'lms_exam_instruction.lms_exam_instruction_title',


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
                ->orderBy('lms_exam_schedule_is_active_live', 'asc')



            ->paginate($perPage);
        return $result;
    }

// Enable Disable Exam Schedule
    public function enableDisableExamSchedule(Request $request)
    {
        $centerId = $request->centerId;
        $scheduleId = $request->scheduleId;
        $isExamScheduleActive = $request->isExamScheduleActive;
        $loggedUserId = $request->loggedUserId;
        $result = ExamModel::enableDisableExamSchedule($centerId,
            $scheduleId, $isExamScheduleActive, $loggedUserId);
        return response()->json($result);

    }

    // Add/Edit Exam Schedule Basic Info
    public function saveEditExamSchedule(Request $request)
    {

        // Server side validation rules
        $validation = Validator::make($request->all(), [
            // Later on check nullable with numeric condition(presently removed from code)
            // 'centerId' => 'bail | required |numeric ',
            // 'enquiryId' => 'bail|sometimes|nullable ',
            // 'loggedUserId' => 'bail | required |numeric ',
            // 'enquiryUserId' => 'bail|sometimes|nullable ',
            // 'lms_exam_instruction_id' => 'bail | required |numeric ',
            // 'selectedCourseId' => 'bail | sometimes|nullable ',
            // 'lms_exam_schedule_type' => 'bail | sometimes|nullable ',
            // 'lms_exam_schedule_name' => 'bail | required |alpha',
            // 'lms_exam_schedule_description' => 'bail | required |alpha',
            // 'lms_exam_schedule_no_of_question' => 'bail | sometimes|nullable |regex:/^[\pL\s\-]+$/u',
            // 'lms_exam_schedule_max_marks' => 'bail | sometimes|nullable |regex:/^[\pL\s\-]+$/u',
            // 'lms_exam_schedule_has_negative_marking' => 'bail | required |alpha ',
            // 'lms_exam_schedule_result_display_type' => 'bail | sometimes|nullable |alpha',
            // 'lms_exam_schedule_live_from' => 'bail | required |date ',
            // 'lms_exam_schedule_live_to' => 'bail | sometimes |nullable|date ',
            // 'lms_exam_schedule_total_time_alloted' => 'bail | required |numeric|digits:10 ',
            // 'enquiryWhatsAppNumber' => 'bail | sometimes|nullable|digits:10 ',
            // 'lms_exam_schedule_is_free_paid' => 'bail | required |email ',
            // 'enquiryProfileImage' => 'bail|sometimes|nullable|mimes:jpeg,jpg,png|max:1024 ',

        ]);
        // if ($validation->fails()) {

            if ($validation->fails()) {


            // Server side validation fails
            return response()->json(['Exam Schedule error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {
            $centerId = $request->centerId;
            $scheduleId = $request->scheduleId;
            $loggedUserId = $request->loggedUserId;
            $enquiryUserId = $request->enquiryUserId;
            $lms_exam_instruction_id = $request->lms_exam_instruction_id;
            $lms_course_id = $request->lms_course_id;
            $lms_child_course_id = $request->lms_child_course_id;


            $lms_exam_schedule_type = $request->lms_exam_schedule_type;

            $lms_exam_schedule_name = $request->lms_exam_schedule_name;
            $lms_exam_schedule_description = $request->lms_exam_schedule_description;
            $lms_exam_schedule_no_of_question = $request->lms_exam_schedule_no_of_question;
            $lms_exam_schedule_max_marks = $request->lms_exam_schedule_max_marks;
            $lms_exam_schedule_has_negative_marking = $request->lms_exam_schedule_has_negative_marking;
            $lms_exam_schedule_negative_marking = $request->lms_exam_schedule_negative_marking;
            $lms_exam_schedule_result_display_type = $request->lms_exam_schedule_result_display_type;
            $lms_exam_schedule_live_from = $request->lms_exam_schedule_live_from;
            $lms_exam_schedule_live_to = $request->lms_exam_schedule_live_to;
            $lms_exam_schedule_total_time_alloted = $request->lms_exam_schedule_total_time_alloted;
            $lms_exam_schedule_pass_marks = $request->lms_exam_schedule_pass_marks;
            $lms_exam_schedule_is_free_paid = $request->lms_exam_schedule_is_free_paid;
            $lms_exam_schedule_solution_display_type = $request->lms_exam_schedule_solution_display_type;
            $isExamScheduleEdit = $request->isExamScheduleEdit;

            $lms_exam_schedule_image= $request->lms_exam_schedule_image;

            $examImageName = $request->examImageName;

            if ($request->has('lms_exam_schedule_image')) {
                // If profile image selected

                $examImageName = uniqid() . time() . '.' . $request->lms_exam_schedule_image->extension();
                $request->lms_exam_schedule_image->storeAs('public/exam_images', $examImageName);
            }




                $result = ExamModel::saveEditExamSchedule($centerId,
                    $scheduleId, $loggedUserId, $enquiryUserId, $lms_exam_instruction_id, $lms_course_id,$lms_child_course_id,
                    $lms_exam_schedule_type, $lms_exam_schedule_name, $lms_exam_schedule_description, $lms_exam_schedule_no_of_question,
                    $lms_exam_schedule_max_marks, $lms_exam_schedule_has_negative_marking,$lms_exam_schedule_negative_marking, $lms_exam_schedule_result_display_type, $lms_exam_schedule_live_from, $lms_exam_schedule_live_to,
                    $lms_exam_schedule_total_time_alloted, $lms_exam_schedule_pass_marks, $lms_exam_schedule_is_free_paid, $lms_exam_schedule_solution_display_type,
                     $isExamScheduleEdit,$examImageName);
                return response()->json($result);


        }

    }



    //===========================Instruction==============================================================================


    //Get all instruction
    public function getAllInstruction(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 15;
        $getData = DB::table("lms_exam_instruction")->
            select(['lms_exam_instruction_id', 'lms_exam_instruction_title','lms_exam_instruction_content', DB::raw("IF(lms_exam_instruction_is_active = 1, 'Active','Inactive')as lms_exam_instruction_is_active")])
            ->
            where('lms_center_id', $centerId)
            ->paginate($perPage);
        return $getData;
    }


    // Check Instruction in DB and then Save
    public function saveInstruction(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'instructionName' => ['bail', 'required'],
        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $instructionName = trim($request->instructionName);
            $instructionContentName = $request->instructionContentName;
            $isSaveEditClicked = $request->isSaveEditClicked;
            $instructionId = $request->instructionId;
            $loggedUserId = $request->loggedUserId;
            $result=ExamModel::saveInstruction($centerId,
            $instructionName,$isSaveEditClicked,$instructionId,$loggedUserId,$instructionContentName);
            return response()->json($result);

        }

    }

//Update Department
public function enableDisableInstruction(Request $request)
{
    $centerId = $request->centerId;
    $instructionId = $request->instructionId;
    $isInstructionActive = $request->isInstructionActive;
    $loggedUserId = $request->loggedUserId;
    $result=ExamModel::enableDisableInstruction($centerId
    ,$instructionId,$isInstructionActive,$loggedUserId);
    return response()->json($result);

}



    //=============================Instruction End ===================================================================



   



}
