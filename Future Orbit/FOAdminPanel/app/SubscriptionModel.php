<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class SubscriptionModel extends Model
{

    // Check Subject Code in DB and then Save
    public static function saveUpdateSubscription(
        $centerId,
        $loggedUserId,
        $lms_exam_card_name,
        $lms_exam_card_payment_month_duration,
        $isSaveEditClicked,
        $lms_exam_card_charge_per_month,
        $lms_exam_card_id,
        $lms_course_id
    ) {
        if ($isSaveEditClicked == 1) {

            // If save course is clicked
            $getQuery = DB::table("lms_exam_card")->where('lms_center_id', $centerId)->where('lms_exam_card_name', $lms_exam_card_name)
                ->get();
            if ($getQuery->count() > 0) {
                // Course Code Exists

                $result_data['responseData'] = "1";
            } else {

                $saveQuery = DB::table('lms_exam_card')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_course_id' => $lms_course_id,
                        'lms_exam_card_name' => $lms_exam_card_name,
                        'lms_exam_card_payment_month_duration' => $lms_exam_card_payment_month_duration,
                        'lms_exam_card_charge_per_month' => $lms_exam_card_charge_per_month,
                        'lms_exam_card_charge_total_amount' => $lms_exam_card_charge_per_month * $lms_exam_card_payment_month_duration,
                        'lms_exam_card_created_by' => $loggedUserId



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

            $getQuery = DB::table("lms_exam_card")->where('lms_center_id', $centerId)->where('lms_exam_card_name', $lms_exam_card_name)
                ->where('lms_exam_card_id', '!=', $lms_exam_card_id)
                ->get();
            if ($getQuery->count() > 0) {
                // Course Code Exists
                $result_data['responseData'] = "1";
            } else {
                $updateQuery = DB::table('lms_exam_card')
                    ->where('lms_exam_card_id', $lms_exam_card_id)
                    ->where('lms_center_id', $centerId)
                    ->update([
                        'lms_course_id' => $lms_course_id,
                        'lms_exam_card_charge_per_month' => $lms_exam_card_charge_per_month,
                        'lms_exam_card_payment_month_duration' => $lms_exam_card_payment_month_duration,
                        'lms_exam_card_name' => $lms_exam_card_name,
                        'lms_exam_card_updated_at' => now(),


                    ]);
                if ($updateQuery > 0) {
                    $result_data['responseData'] = "4";
                }
            }
        }
        return $result_data;
    }

    // Enable Disable Subject
    public static function enableDisableSubscription(
        $centerId,
        $lms_exam_card_id,
        $lms_exam_card_card_is_active
    ) {
        $updateQuery = DB::table('lms_exam_card')
            ->where('lms_exam_card_id', $lms_exam_card_id)
            ->where('lms_center_id', $centerId)
            ->update([

                'lms_exam_card_card_is_active' => $lms_exam_card_card_is_active,
                'lms_exam_card_updated_at' => now(),
            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";
        } else {
            $result_data['responseData'] = "2";
        }
        return $result_data;
    }

    public static function addSubscription(
        $centerId,
        $lms_user_id,
        $lms_registration_id,
        $lms_student_id,
        $lms_exam_card_id,
        $lms_exam_card_payment_month_duration,
        $lms_exam_card_charge_per_month,
        $loggedUserId
    ) {

        $getQuery = DB::table("lms_exam_card_user_wise")
            ->where('lms_exam_card_id', $lms_exam_card_id)
            ->where('lms_registration_id', $lms_registration_id)
            ->where('lms_exam_card_applied_is_active', 1)
            ->where('lms_exam_card_expiry_date', '>=', now())
            ->get();
        if ($getQuery->count() > 0) {
            $result_data['responseData'] = "3";
        } else {

            $saveQuery = DB::table('lms_exam_card_user_wise')->insertGetId(
                [
                    'lms_center_id' => $centerId,
                    'lms_user_id' => $lms_user_id,
                    'lms_registration_id' => $lms_registration_id,
                    'lms_student_id' => $lms_student_id,
                    'lms_exam_card_amount' => $lms_exam_card_charge_per_month,
                    'lms_exam_card_id' => $lms_exam_card_id,
                    'lms_exam_card_expiry_date' =>
                    DB::raw('DATE_ADD(curdate(), INTERVAL ' .  $lms_exam_card_payment_month_duration . ' MONTH)'),
                    'lms_exam_card_created_by' => $loggedUserId



                ]
            );

            if ($saveQuery > 0) {
                $result_data['responseData'] = "1";
            } else {
                $result_data['responseData'] = "2";
            }
        }
        return $result_data;
    }


    public static function enableDisableStudentSubscription(
        $centerId,
        $lms_exam_card_user_wise_id,
        $lms_exam_card_applied_is_active
    ) {
        $updateQuery = DB::table('lms_exam_card_user_wise')
            ->where('lms_exam_card_user_wise_id', $lms_exam_card_user_wise_id)
            ->where('lms_center_id', $centerId)
            ->update([

                'lms_exam_card_applied_is_active' => $lms_exam_card_applied_is_active,
            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";
        } else {
            $result_data['responseData'] = "2";
        }
        return $result_data;
    }
}
