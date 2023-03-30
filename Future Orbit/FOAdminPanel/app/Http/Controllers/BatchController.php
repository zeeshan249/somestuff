<?php

namespace App\Http\Controllers;

use App\BatchModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BatchController extends Controller
{
    public function __construct()
    {
    }
    // Check Course Code in DB and then Save
    public function saveUpdateBatch(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'loggedUserId' => 'bail | required |numeric ',

            'lms_batch_name' => ['bail', 'required'],
            'lms_course_id' => 'bail | required |numeric ',
            'lms_batch_start_date' => 'bail | required',
            'lms_batch_end_date' => 'bail | required',
            'lms_child_course_id' => 'bail | required',

        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;

            $lms_batch_id = trim($request->lms_batch_id);
            $lms_batch_code = $request->lms_batch_code;
            $isSaveEditClicked = $request->isSaveEditClicked;
            $lms_batch_name = $request->lms_batch_name;
            $lms_batch_start_date = $request->lms_batch_start_date;
            $lms_batch_end_date = $request->lms_batch_end_date;
            $lms_course_id = $request->lms_course_id;
            $slotDetails = $request->slotDetails;
            $lms_child_course_id = $request->lms_child_course_id;
            $BatchModel = new BatchModel;
            $result = $BatchModel->saveUpdateBatch(
                $centerId,
                $loggedUserId,
                $lms_batch_id,
                $lms_batch_code,
                $isSaveEditClicked,
                $lms_batch_name,
                $lms_batch_start_date,
                $lms_batch_end_date,
                $lms_course_id,
                $slotDetails,
                $lms_child_course_id
            );
            return response()->json($result);
        }
    }

    //Get all Batch
    public function getAllBatch(Request $request)
    {
        $active = [];
        $filterBy=$request->searchText;
        $centerId = $request->centerId;
        $includeDelete = $request->includeDelete;
        $perPage = $request->perPage ? $request->perPage : 100;
        if ($includeDelete == "false") {
            $active = [1];
        } else {
            $active = [1, 0];
        }
        $getData = DB::table("lms_batch_details")->leftJoin('lms_course', 'lms_course.lms_course_id', '=', 'lms_batch_details.lms_course_id')->select([
            'lms_batch_id', 'lms_batch_code', 'lms_batch_name', 'lms_course.lms_course_name', 'lms_child_course_id',
            'lms_course.lms_course_id', 'lms_batch_details.lms_batch_start_date', 'lms_batch_details.lms_batch_end_date',
            DB::raw('DATE_FORMAT(lms_batch_details.lms_batch_start_date, "%d-%m-%Y") as lms_batch_start_date_edit', "%d-%m-%Y"),
            DB::raw('DATE_FORMAT(lms_batch_details.lms_batch_end_date, "%d-%m-%Y") as lms_batch_end_date_edit', "%d-%m-%Y"),

            DB::raw("IF(lms_batch_is_active = 1, 'Active','Inactive')as lms_batch_is_active"),
        ])
            ->where('lms_batch_details.lms_center_id', $centerId)
            ->where(function ($q) use ($filterBy) {
                $q->orWhere('lms_batch_details.lms_batch_code', 'like', "%$filterBy%")
                  ->orWhere('lms_batch_details.lms_batch_name', 'like', "%$filterBy%")
                  ->orWhere('lms_course.lms_course_name', 'like', "%$filterBy%");
          })
            ->whereIn('lms_batch_details.lms_batch_is_active', $active)
            ->orderBy('lms_batch_details.lms_batch_id', 'desc')

            ->paginate($perPage);
        return $getData;
    }

    public function getAllBatchWiseSlotDetails(Request $request)
    {
        $active = [];
        $centerId = $request->centerId;
        $batchId = $request->batchId;
        $perPage = $request->perPage ? $request->perPage : 15;

        $getData = DB::table("lms_batch_slot")
            ->join('lms_user', 'lms_user.lms_user_id', '=', 'lms_batch_slot.lms_user_id')
            ->join('lms_staff', 'lms_staff.lms_user_id', '=', 'lms_user.lms_user_id')
            ->join('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_batch_slot.lms_subject_id')
            ->select([
                'lms_subject.lms_subject_name', 'lms_batch_slot_id',
                'lms_staff.lms_staff_full_name', 'lms_staff.lms_staff_profile_image', 'lms_staff.lms_staff_mobile_number', 'lms_staff.lms_staff_id', 'lms_user.lms_user_id', 'lms_batch_slot.lms_batch_slot_start_time', 'lms_batch_slot.lms_batch_slot_end_time', 'lms_batch_slot.lms_batch_slot_day_text',
                DB::raw("IF(lms_batch_slot.lms_batch_slot_is_active = 1, 'Active','Inactive')as lms_batch_slot_is_active"),
            ])
            ->where('lms_batch_slot.lms_center_id', $centerId)
            ->where('lms_batch_slot.lms_batch_id', $batchId)
            ->orderBy('lms_batch_slot.lms_batch_slot_id', 'desc')

            ->paginate($perPage);
        return $getData;
    }
    //Get all Students Not in Batch
    public function getAllStudentNotInBatch(Request $request)
    {
        $centerId = $request->centerId;
        $lms_course_id = $request->lms_course_id;
        $perPage = $request->perPage ? $request->perPage : 15;

        $getData = DB::table("lms_student_course_mapping")
            ->Join('lms_student', 'lms_student_course_mapping.lms_student_id', '=', 'lms_student.lms_student_id')
            ->select([
                'lms_student_full_name', 'lms_registration_id', 'lms_student_code', 'lms_registration_code', 'lms_student_profile_image', 'lms_batch_id',
                DB::raw('DATE_FORMAT(lms_student_course_mapping.lms_batch_mapping_date, "%d-%m-%Y") as lms_batch_mapping_date', "%d-%m-%Y"),
            ])
            ->where('lms_student_course_mapping.lms_center_id', $centerId)
            ->Where('lms_student_course_mapping.lms_course_id', $lms_course_id)
            ->Where('lms_student_course_mapping.lms_batch_id', null)
            ->where('lms_student_course_mapping.lms_student_course_mapping_status', '1')
            ->orderBy('lms_student_course_mapping.lms_registration_code', 'desc')

            ->paginate($perPage);
        return $getData;
    }

    //Get all Batch Wise Students
    public function getAllBatchWiseStudent(Request $request)
    {
        $centerId = $request->centerId;
        $lms_batch_id = $request->lms_batch_id;
        $getData = DB::table("lms_student_course_mapping")
            ->leftJoin('lms_student', 'lms_student_course_mapping.lms_student_id', '=', 'lms_student.lms_student_id')
            ->select([
                'lms_student_course_mapping.lms_user_id',
                'lms_student_full_name', 'lms_registration_id', 'lms_student_code', 'lms_registration_code', 'lms_student_profile_image', 'lms_batch_id',
                DB::raw('DATE_FORMAT(lms_student_course_mapping.lms_batch_mapping_date, "%d-%m-%Y") as lms_batch_mapping_date', "%d-%m-%Y"),
            ])
            ->where('lms_student_course_mapping.lms_center_id', $centerId)
            ->Where('lms_student_course_mapping.lms_batch_id', $lms_batch_id)
            ->where('lms_student_course_mapping.lms_student_course_mapping_status', '1')
            ->orderBy('lms_student_course_mapping.lms_batch_mapping_date', 'desc')
            ->get();
        return $getData;
    }

    //Get All Active Faculties without pagination
    public function getActiveFaculties(Request $request)
    {
        $centerId = $request->centerId;

        $getQuery = DB::table("lms_staff")->select(['lms_user_id', 'lms_staff_full_name'])
            ->where('lms_staff_is_active', 1)
            ->where('lms_center_id', $centerId)
            ->get();
        return $getQuery;
    }
    //Get All Active Slot Details without pagination
    public function getAllSlotDetailsByBatch(Request $request)
    {
        $centerId = $request->centerId;
        $lms_batch_id = $request->lms_batch_id;
        $getQuery = DB::table("lms_batch_slot")->select([
            'lms_batch_slot_id', 'lms_batch_slot_start_time',

            'lms_batch_slot_end_time', 'lms_batch_slot_day', 'lms_subject_id', 'lms_user_id'
        ])
            ->where('lms_batch_slot_is_active', 1)
            ->where('lms_batch_id', $lms_batch_id)
            ->where('lms_center_id', $centerId)
            ->get();
        return $getQuery;
    }
    //Student Assign Batch
    public function studentAssignBatch(Request $request)
    {
        $centerId = $request->centerId;
        $lms_batch_id = $request->lms_batch_id;
        $lms_registration_id = $request->lms_registration_id;
        $lms_batch_mapping_by = $request->lms_batch_mapping_by;

        $result = BatchModel::studentAssignBatch(
            $centerId,
            $lms_batch_id,
            $lms_registration_id,
            $lms_batch_mapping_by
        );
        return response()->json($result);
    }
    //Disable slot
    public function disableSlot(Request $request)
    {
        $centerId = $request->centerId;
        $lms_batch_slot_id = $request->lms_batch_slot_id;
        $lms_batch_slot_is_active = $request->lms_batch_slot_is_active;
        $result = BatchModel::disableSlot(
            $centerId,
            $lms_batch_slot_id,
            $lms_batch_slot_is_active
        );
        return response()->json($result);
    }

    //Enable Disable batch
    public function enableDisableBatch(Request $request)
    {
        $centerId = $request->centerId;
        $lms_batch_id = $request->lms_batch_id;
        $lms_batch_is_active = $request->lms_batch_is_active;
        $result = BatchModel::enableDisableBatch(
            $centerId,
            $lms_batch_id,
            $lms_batch_is_active
        );
        return response()->json($result);
    }

    //Get All Active Course without pagination
    public function getActiveCourseWithoutPagination(Request $request)
    {
        $centerId = $request->centerId;

        $getQuery = DB::table("lms_course")->select(['lms_course_id', 'lms_course_name'])
            ->where('lms_course_is_active', 1)
            ->where('lms_center_id', $centerId)
            ->get();
        return $getQuery;
    }

    // Code for Subscription Assign
    public function getAllAssignedSubscription(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("lms_student")
            ->join("lms_student_course_mapping", function ($join) {
                $join->on("lms_student_course_mapping.lms_student_id", "=", "lms_student.lms_student_id");
            })
            ->join("lms_course", function ($join) {
                $join->on("lms_course.lms_course_id", "=", "lms_student_course_mapping.lms_course_id");
            })
            ->leftJoin("lms_exam_card_user_wise", function ($join) {
                $join->on("lms_student.lms_student_id", "=", "lms_exam_card_user_wise.lms_student_id");
            })
            ->leftJoin("lms_exam_card", function ($join) {
                $join->on("lms_exam_card_user_wise.lms_exam_card_id", "=", "lms_exam_card.lms_exam_card_id")
                    ->where("lms_exam_card.lms_exam_card_id", "=", 5);
            })
            ->select(
                "*",
                "lms_exam_card.lms_course_id",
                DB::raw("IF (lms_exam_card.lms_exam_card_id IS NULL,'Inactive','Active') as card_active"),

            )
            ->where("lms_course.lms_course_id", "=", 11)

            ->where('lms_exam_card.lms_center_id', $centerId)
            ->orderBy('lms_exam_card.lms_exam_card_card_is_active', 'desc')
            ->paginate($perPage);
        return $getData;
    }

    //Attendance Report Start
    //Get all Batch
    // public function getAllBatchAttendance(Request $request)
    // {
    //     $active = [];
    //     $centerId = $request->centerId;
    //     $includeDelete = $request->includeDelete;
    //     $perPage = $request->perPage ? $request->perPage : 15;
    //     if ($includeDelete == "false") {
    //         $active = [1];
    //     } else {
    //         $active = [1, 0];
    //     }
    //     $getData = DB::table("lms_batch_details")->leftJoin('lms_course', 'lms_course.lms_course_id', '=', 'lms_batch_details.lms_course_id')->select([
    //         'lms_batch_id', 'lms_batch_code', 'lms_batch_name', 'lms_course.lms_course_name', 'lms_child_course_id',
    //         'lms_course.lms_course_id', 'lms_batch_details.lms_batch_start_date', 'lms_batch_details.lms_batch_end_date',
    //         DB::raw('DATE_FORMAT(lms_batch_details.lms_batch_start_date, "%d-%m-%Y") as lms_batch_start_date_edit', "%d-%m-%Y"),
    //         DB::raw('DATE_FORMAT(lms_batch_details.lms_batch_end_date, "%d-%m-%Y") as lms_batch_end_date_edit', "%d-%m-%Y"),
    //         DB::raw("IF(lms_batch_is_active = 1, 'Active','Inactive')as lms_batch_is_active"),
    //     ])
    //         ->where('lms_batch_details.lms_center_id', $centerId)
    //         ->whereIn('lms_batch_details.lms_batch_is_active', $active)
    //         ->orderBy('lms_batch_details.lms_batch_id', 'desc')

    //         ->paginate($perPage);
    //     return $getData;
    // }

    public function getAllBatchAttendance(Request $request)
    {
        $active = [];
        $centerId = $request->centerId;
        $startdate = $request->startDate;
        $enddate = $request->endDate;
        $includeDelete = $request->includeDelete;
        $perPage = $request->perPage ? $request->perPage : 50;
        if ($includeDelete == "false") {
            $active = [1];
        } else {
            $active = [1, 0];
        }
        $getData = DB::table("lms_batch_details")
        ->join('lms_attendance','lms_attendance.lms_batch_id','=','lms_batch_details.lms_batch_id')
        ->leftJoin('lms_course', 'lms_course.lms_course_id', '=', 'lms_batch_details.lms_course_id')->select([
            'lms_batch_details.lms_batch_id', 'lms_batch_details.lms_batch_code', 'lms_batch_name', 'lms_course.lms_course_name', 'lms_batch_details.lms_child_course_id',
            'lms_course.lms_course_id', 'lms_batch_details.lms_batch_start_date', 'lms_batch_details.lms_batch_end_date',
            DB::raw('DATE_FORMAT(lms_batch_details.lms_batch_start_date, "%d-%m-%Y") as lms_batch_start_date_edit', "%d-%m-%Y"),
            DB::raw('DATE_FORMAT(lms_batch_details.lms_batch_end_date, "%d-%m-%Y") as lms_batch_end_date_edit', "%d-%m-%Y"),
            DB::raw("IF(lms_batch_is_active = 1, 'Active','Inactive')as lms_batch_is_active"),
            DB::raw(" COUNT(distinct lms_attendance.lms_batch_id,lms_attendance.lms_attendance_date) AS totalAttendance"),
        ])
            ->where('lms_batch_details.lms_center_id', $centerId)
            ->whereIn('lms_batch_details.lms_batch_is_active', $active)
            ->where(function ($q) use ($startdate, $enddate) {
                if ($startdate != null) {
                    $q
                        ->where('lms_attendance.lms_attendance_date', '>=', $startdate);
                }
                if ($enddate != null) {
                    $q
                        ->where('lms_attendance.lms_attendance_date', '<=', $enddate);
                }
            })
            ->groupBy('lms_attendance.lms_batch_id')
            ->orderBy('lms_batch_details.lms_batch_id', 'desc')

            ->paginate($perPage);
        return $getData;
    }
    //End

    public function getAllBatchWithoutPagination(Request $request)
    {

        $getData = DB::table("lms_batch_details")

            ->select([
                'lms_batch_id', 'lms_batch_code', 'lms_batch_name',  DB::raw("concat(lms_batch_code,' - ',lms_batch_name) as lms_batch_code_name"),
            ])
            ->where('lms_batch_is_active', 1)
            ->get();

        return $getData;
    }

    public function getAllStudentNotInBatchWithoutPagination(Request $request)
    {

        $getData = DB::table("lms_student_course_mapping")
            ->leftJoin('lms_student', 'lms_student_course_mapping.lms_student_id', '=', 'lms_student.lms_student_id')


            ->select([
                'lms_student.lms_user_id',
                DB::raw('lms_student.lms_student_full_name as lms_full_name'),
            ])

            ->Where('lms_student_course_mapping.lms_batch_id', null)
            ->where('lms_student_course_mapping.lms_student_course_mapping_status', '1')
            ->orderBy('lms_student_course_mapping.lms_registration_code', 'desc')

            ->get();
        return $getData;
    }

    public function getAttendanceDates(Request $request)
    {
        $batchId = $request->batchId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $startdate = $request->startDate;
        $enddate = $request->endDate;
        $getData = DB::table("lms_attendance")
            ->leftJoin('lms_batch_details', 'lms_attendance.lms_batch_id', '=', 'lms_batch_details.lms_batch_id')
            ->leftJoin('lms_batch_slot', 'lms_batch_slot.lms_batch_slot_id', '=', 'lms_attendance.lms_batch_slot_id')
            ->leftJoin('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_batch_slot.lms_subject_id')
            ->select([

                DB::raw('DATE_FORMAT(lms_attendance.lms_attendance_date, "%d-%m-%Y") as lms_attendance_date', "%d-%m-%Y"),
                'lms_batch_details.lms_batch_code',
                'lms_batch_details.lms_batch_name',
                'lms_attendance.lms_batch_id',
                'lms_attendance.lms_batch_slot_day_text',
                'lms_subject.lms_subject_name',
                'lms_batch_slot_start_time',
                'lms_batch_slot_end_time',
                'lms_attendance.lms_batch_slot_id',
                DB::raw('concat(lms_attendance.lms_batch_slot_id,"-",lms_attendance.lms_attendance_date) as lms_batch_slot_id_misc'),
                DB::raw('DATE_FORMAT(lms_batch_details.lms_batch_start_date, "%d-%m-%Y") as lms_batch_start_date', "%d-%m-%Y"),
                DB::raw('DATE_FORMAT(lms_batch_details.lms_batch_end_date, "%d-%m-%Y") as lms_batch_end_date', "%d-%m-%Y"),
            ])->where('lms_attendance.lms_batch_id', $batchId)
            ->where(function ($q) use ($startdate, $enddate) {
                if ($startdate != null) {
                    $q
                        ->where('lms_attendance.lms_attendance_date', '>=', $startdate);
                }
                if ($enddate != null) {
                    $q
                        ->where('lms_attendance.lms_attendance_date', '<=', $enddate);
                }
            })
            ->groupBy('lms_attendance.lms_batch_slot_id', 'lms_attendance.lms_attendance_date')
            ->orderBy('lms_attendance.lms_attendance_date', 'desc')

            ->paginate($perPage);
        return $getData;
    }

    // public function getAttendanceDates(Request $request)
    // {
    //     $batchId = $request->batchId;
    //     $perPage = $request->perPage ? $request->perPage : 15;
    //     $getData = DB::table("lms_attendance")
    //         ->leftJoin('lms_batch_details', 'lms_attendance.lms_batch_id', '=', 'lms_batch_details.lms_batch_id')
    //         ->leftJoin('lms_batch_slot', 'lms_batch_slot.lms_batch_slot_id', '=', 'lms_attendance.lms_batch_slot_id')
    //         ->leftJoin('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_batch_slot.lms_subject_id')
    //         ->select([

    //             DB::raw('DATE_FORMAT(lms_attendance.lms_attendance_date, "%d-%m-%Y") as lms_attendance_date', "%d-%m-%Y"),
    //             'lms_batch_details.lms_batch_code',
    //             'lms_batch_details.lms_batch_name',
    //             'lms_attendance.lms_batch_id',
    //             'lms_attendance.lms_batch_slot_day_text',
    //             'lms_subject.lms_subject_name',
    //             'lms_batch_slot_start_time',
    //             'lms_batch_slot_end_time',
    //             'lms_attendance.lms_batch_slot_id',
    //             DB::raw('concat(lms_attendance.lms_batch_slot_id,"-",lms_attendance.lms_attendance_date) as lms_batch_slot_id_misc'),
    //             DB::raw('DATE_FORMAT(lms_batch_details.lms_batch_start_date, "%d-%m-%Y") as lms_batch_start_date', "%d-%m-%Y"),
    //             DB::raw('DATE_FORMAT(lms_batch_details.lms_batch_end_date, "%d-%m-%Y") as lms_batch_end_date', "%d-%m-%Y"),
    //         ])->where('lms_attendance.lms_batch_id', $batchId)

    //         ->groupBy('lms_attendance.lms_batch_slot_id', 'lms_attendance.lms_attendance_date')
    //         ->orderBy('lms_attendance.lms_attendance_date', 'desc')

    //         ->paginate($perPage);
    //     return $getData;
    // }


    public function getAttendanceDateWise(Request $request)
    {
        $batchId = $request->batchId;
        $slotId = $request->slotId;
        $attendanceDate = $request->attendanceDate;

        $getQuery = DB::select("select  lms_attendance.lms_attendance_Id, DATE_FORMAT(lms_attendance_date, '%d-%m-%Y') as lms_attendance_date,
         lms_attendance_status,lms_student_code,
         lms_batch_slot.lms_batch_slot_start_time,lms_batch_slot.lms_batch_slot_end_time,
         lms_subject.lms_subject_name,
         lms_student.lms_student_full_name,
            if(lms_attendance.lms_attendance_status=1,'Present',if(lms_attendance.lms_attendance_status=2,'Absent','Holiday')) as 'AttendanceStatus'

        from lms_attendance join lms_batch_slot on lms_attendance.lms_batch_slot_id=lms_batch_slot.lms_batch_slot_id

        join lms_subject on lms_subject.lms_subject_id=lms_batch_slot.lms_subject_id

        left join lms_student on lms_student.lms_user_id=lms_attendance.lms_user_id
        
        where lms_attendance.lms_batch_id=$batchId  and lms_attendance.lms_batch_slot_id=$slotId
         and cast(lms_attendance_date as date) between STR_TO_DATE('$attendanceDate','%Y-%m-%d') and STR_TO_DATE('$attendanceDate','%Y-%m-%d')
        ");

        return $getQuery;
    }


    public function getStudentAttendanceDateWise(Request $request)
    {
        $lms_user_id = $request->lms_user_id;

        $getQuery = DB::select("select  lms_attendance.lms_attendance_Id, DATE_FORMAT(lms_attendance_date, '%d-%m-%Y') as lms_attendance_date,
         lms_attendance_status,lms_student_code,
         lms_batch_slot.lms_batch_slot_start_time,lms_batch_slot.lms_batch_slot_end_time,
         lms_subject.lms_subject_name,
         lms_student.lms_student_full_name,lms_batch_details.lms_batch_code,
        if(lms_attendance.lms_attendance_status=1,'Present',if(lms_attendance.lms_attendance_status=2,'Absent','Holiday')) as 'AttendanceStatus'

        from lms_attendance join lms_batch_slot on lms_attendance.lms_batch_slot_id=lms_batch_slot.lms_batch_slot_id

        join lms_subject on lms_subject.lms_subject_id=lms_batch_slot.lms_subject_id

        left join lms_student on lms_student.lms_user_id=lms_attendance.lms_user_id

        left join lms_batch_details on lms_batch_details.lms_batch_id=lms_attendance.lms_batch_id
        
        where lms_attendance.lms_user_id=$lms_user_id order by lms_attendance.lms_attendance_date desc");

        return $getQuery;
    }
}
