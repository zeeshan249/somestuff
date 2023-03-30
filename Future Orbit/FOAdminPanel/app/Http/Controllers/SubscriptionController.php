<?php

namespace App\Http\Controllers;

use App\SubscriptionModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function __construct()
    {
    }
    // Check Course Code in DB and then Save
    public function saveUpdateSubscription(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'loggedUserId' => 'bail | required |numeric ',
            'lms_exam_card_name' => 'bail | required',
            'lms_exam_card_payment_month_duration' => ['bail', 'required', 'numeric'],
            'lms_exam_card_charge_per_month' => 'bail | required |numeric ',
            'lms_course_id' => 'bail | required',

        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;

            $lms_exam_card_name = trim($request->lms_exam_card_name);
            $lms_exam_card_payment_month_duration = $request->lms_exam_card_payment_month_duration;
            $isSaveEditClicked = $request->isSaveEditClicked;
            $lms_exam_card_charge_per_month = $request->lms_exam_card_charge_per_month;
            $lms_exam_card_id = $request->lms_exam_card_id;
            $lms_course_id = $request->lms_course_id;

            $result = SubscriptionModel::saveUpdateSubscription(
                $centerId,
                $loggedUserId,
                $lms_exam_card_name,
                $lms_exam_card_payment_month_duration,
                $isSaveEditClicked,
                $lms_exam_card_charge_per_month,
                $lms_exam_card_id,
                $lms_course_id,
            );
            return response()->json($result);
        }
    }

    //Get all Subscription
    public function getAllSubscription(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 15;
        $getData = DB::table("lms_exam_card")->leftJoin('lms_course', 'lms_course.lms_course_id', '=', 'lms_exam_card.lms_course_id')->select([
            'lms_exam_card_id', 'lms_exam_card.lms_course_id', 'lms_course_name', 'lms_exam_card_payment_month_duration',
            'lms_exam_card_name', 'lms_exam_card_charge_per_month',
            DB::raw("IF(lms_exam_card_card_is_active = 1, 'Active','Inactive')as lms_exam_card_card_is_active"),
        ])
            ->where('lms_exam_card.lms_center_id', $centerId)
            ->orderBy('lms_exam_card.lms_exam_card_card_is_active', 'desc')
            ->paginate($perPage);
        return $getData;
    }

    //Enable Disable subscription
    public function enableDisableSubscription(Request $request)
    {
        $centerId = $request->centerId;
        $lms_exam_card_id = $request->lms_exam_card_id;
        $lms_exam_card_card_is_active = $request->lms_exam_card_card_is_active;
        $result = SubscriptionModel::enableDisableSubscription(
            $centerId,
            $lms_exam_card_id,
            $lms_exam_card_card_is_active
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
        $lms_exam_card_id = $request->lms_exam_card_id;
        $centerId = $request->centerId;
        $lms_course_id = $request->lms_course_id;
        $perPage = $request->perPage ? $request->perPage : 15;
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
            ->leftJoin("lms_exam_card", "lms_exam_card_user_wise.lms_exam_card_id", "=", "lms_exam_card.lms_exam_card_id")
            ->select(
                "*",
                "lms_exam_card.lms_course_id",
                DB::raw("IF (lms_exam_card.lms_exam_card_id IS NULL,'Inactive','Active') as card_active"),

            )
            ->where("lms_course.lms_course_id", "=", $lms_course_id)
            ->where("lms_exam_card_user_wise.lms_exam_card_applied_is_active", "=", 1)
            ->where("lms_exam_card.lms_exam_card_id", "=", $lms_exam_card_id)
            ->where('lms_exam_card.lms_center_id', $centerId)
            ->orderBy('lms_exam_card.lms_exam_card_card_is_active', 'desc')
            ->paginate($perPage);
        return $getData;
    }

    public function addSubscription(Request $request)
    {
        $centerId = $request->centerId;
        $loggedUserId = $request->loggedUserId;


        $lms_student_id = $request->lms_student_id;
        $lms_user_id = $request->lms_user_id;
        $lms_registration_id = $request->lms_registration_id;

        $lms_exam_card_id = $request->lms_exam_card_id;
        $lms_exam_card_payment_month_duration = $request->lms_exam_card_payment_month_duration;
        $lms_exam_card_charge_per_month = $request->lms_exam_card_charge_per_month;


        $result = SubscriptionModel::addSubscription(
            $centerId,
            $lms_user_id,
            $lms_registration_id,
            $lms_student_id,
            $lms_exam_card_id,
            $lms_exam_card_payment_month_duration,
            $lms_exam_card_charge_per_month,
            $loggedUserId
        );
        return response()->json($result);
    }


    public function enableDisableStudentSubscription(Request $request)
    {
        $centerId = $request->centerId;
        $lms_exam_card_user_wise_id = $request->lms_exam_card_user_wise_id;
        $lms_exam_card_applied_is_active = $request->lms_exam_card_applied_is_active;
        $result = SubscriptionModel::enableDisableStudentSubscription(
            $centerId,
            $lms_exam_card_user_wise_id,
            $lms_exam_card_applied_is_active
        );
        return response()->json($result);
    }
}
