<?php

namespace App;

use DB;
use Exception;
use Illuminate\Database\Eloquent\Model;

class NoticeModel extends Model
{
    protected $primaryKey = "lms_topic_id";
    protected $table = "lms_notice";
    public $timestamps = false;

    // Check Subject Code in DB and then Save
    public static function saveUpdateNotice(
        $centerId,
        $loggedUserId,
        $lms_notice_id,
        $lms_notice_type,
        $isSaveEditClicked,
        $lms_notice_title,
        $lms_notice_description,
        $role_id,
        $lms_staff_first_name,
        $lms_staff_last_name,
        $lms_staff_full_name,
        $lms_staff_profile_image,
        $role_name
    ) {
        if ($isSaveEditClicked == 1) {

            $saveQuery = DB::table('lms_notice')->insertGetId(
                [
                    'lms_center_id' => $centerId,
                    'lms_notice_type' => $lms_notice_type,
                    'lms_notice_title' => $lms_notice_title,
                    'lms_notice_description' => $lms_notice_description,
                    'role_id' => $role_id,
                    'lms_notice_created_by' => $loggedUserId,

                    'lms_staff_last_name' => $lms_staff_last_name,
                    'lms_staff_full_name' => $lms_staff_full_name,
                    'lms_staff_first_name' => $lms_staff_first_name,
                    'lms_staff_profile_image' => $lms_staff_profile_image,
                    'role_name' => $role_name,

                ]
            );
            if ($saveQuery > 0) {
                // course Saved
                $result_data['responseData'] = "2";
            } else {
                // Failed to save course
                $result_data['responseData'] = "3";
            }
        } else {

            $updateQuery = DB::table('lms_notice')
                ->where('lms_notice_id', $lms_notice_id)
                ->where('lms_center_id', $centerId)
                ->update([

                    'lms_center_id' => $centerId,
                    'lms_notice_type' => $lms_notice_type,
                    'lms_notice_title' => $lms_notice_title,
                    'lms_notice_description' => $lms_notice_description,
                    'role_id' => $role_id,
                    'lms_notice_updated_at' => now(),
                    'lms_notice_updated_by' => $loggedUserId,

                    'lms_staff_last_name' => $lms_staff_last_name,
                    'lms_staff_full_name' => $lms_staff_full_name,
                    'lms_staff_first_name' => $lms_staff_first_name,
                    'lms_staff_profile_image' => $lms_staff_profile_image,
                    'role_name' => $role_name,

                ]);
            if ($updateQuery > 0) {
                $result_data['responseData'] = "4";
            }
        }
        return $result_data;
    }

    // Enable Disable Subject
    public static function enableDisableNotice(
        $centerId,
        $lms_notice_id,
        $isNoticeActive,
        $loggedUserId
    ) {
        $updateQuery = DB::table('lms_notice')
            ->where('lms_notice_id', $lms_notice_id)
            ->where('lms_center_id', $centerId)
            ->update(['lms_notice_is_active' => $isNoticeActive, 'lms_notice_updated_at' => now(), 'lms_notice_updated_by' => $loggedUserId]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";
        } else {
            $result_data['responseData'] = "2";
        }
        return $result_data;
    }

    // Is Approved post
    public static function isApprovePost(
        $centerId,
        $postId,
        $isApproved,
        $loggedUserId
    ) {
        $updateQuery = DB::table('lms_post')
            ->where('lms_post_id', $postId)
            ->where('lms_center_id', $centerId)
            ->update(['lms_is_post_approved' => $isApproved]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";
        } else {
            $result_data['responseData'] = "2";
        }
        return $result_data;
    }

    public static function deleteNotification(
        $notification_id,
        $loggedUserId
    ) {

        try {
            DB::beginTransaction();

            $updateQuery = DB::table('lms_notification')
                ->where('notification_id', $notification_id)
                ->delete();
            $query2 = DB::table('lms_send_notification')
                ->where('notification_id', $notification_id)
                ->delete();


            DB::commit();
            $result_data['responseData'] = "1";
        } catch (Exception $ex) {
            DB::rollback();
            $result_data['Result'] = "2";
        }

        return $result_data;
    }
}
