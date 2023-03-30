<?php

namespace App\Http\Controllers;

use App\NoticeModel;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
    public function __construct()
    {
    }
    // Check Course Code in DB and then Save
    public function saveUpdateNotice(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'loggedUserId' => 'bail | required |numeric ',
            'lms_notice_title' => 'bail | required',
            'lms_notice_description' => 'bail| required',

        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

             $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;
            $lms_notice_title = $request->lms_notice_title;
            $lms_notice_description = $request->lms_notice_description;
            $role_id = trim($request->role_id);
            $lms_notice_type = $request->lms_notice_type;
            $isSaveEditClicked = $request->isSaveEditClicked;

            $lms_notice_id = $request->lms_notice_id;

            $lms_staff_first_name = $request->lms_staff_first_name;
            $lms_staff_last_name = $request->lms_staff_last_name;
            $lms_staff_full_name = $request->lms_staff_full_name;
            $lms_staff_profile_image = $request->lms_staff_profile_image;
            $role_name = $request->role_name;

            $result = NoticeModel::saveUpdateNotice(
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
             

            );
            return response()->json($result);
        }
    }

    //Enable Disable course
    public function enableDisableNotice(Request $request)
    {
        $centerId = $request->centerId;
        $lms_notice_id = $request->lms_notice_id;
        $isNoticeActive = $request->isNoticeActive;
        $loggedUserId = $request->loggedUserId;
        $result = NoticeModel::enableDisableNotice(
            $centerId,
            $lms_notice_id,
            $isNoticeActive,
            $loggedUserId
        );
        return response()->json($result);
    }

    //Get the notice
    public function getAllNotice(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $filterBy = $request->filterBy;
        $getData = DB::table("lms_notice")->leftJoin('lms_staff', 'lms_staff.lms_user_id', '=', 'lms_notice.lms_notice_created_by')->leftJoin('lms_user', 'lms_user.lms_user_id', '=', 'lms_staff.lms_user_id')->leftJoin('roles', 'roles.id', '=', 'lms_notice.role_id')

            ->where(function ($q) use ($filterBy) {
                $q->where('lms_notice.lms_notice_type', 'like', "%$filterBy%")
                    ->orWhere('lms_notice.lms_notice_title', 'like', "%$filterBy%")
                    ->orWhere('lms_notice.lms_notice_description', 'like', "%$filterBy%");
            })
            ->where('lms_notice.lms_notice_is_active', '=', 1)
            ->select([
                'lms_notice.lms_notice_title', 'lms_notice.lms_notice_description', 'lms_notice.lms_notice_type',
                'roles.name as role_name', 'lms_notice.role_id as role_id', 'lms_notice.lms_notice_id',
                DB::raw("date_format(lms_notice.lms_notice_created_at,'%d-%m-%y') as lms_notice_created_at"),
                DB::raw("IF(lms_notice.lms_notice_is_active = 1, 'Active','Inactive')as lms_notice_is_active")
            ])->where('lms_notice.lms_center_id', $centerId)
            ->orderBy('lms_notice.lms_notice_is_active', 'desc')
            ->orderBy('lms_notice.lms_notice_created_at', 'desc')

            ->paginate($perPage);
        return $getData;
    }

    //Get all roles
    public function getAllRoles(Request $request)
    {
        $centerId = $request->centerId;
        $getData = DB::table("roles")->select(['roles.id', 'roles.name'])->where('roles.lms_center_id', $centerId)->where('roles.is_role_active', '1')->get();
        return $getData;
    }

    //--------------------POST-------------------------------

    //Get the notice
    public function getAllPost(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $filterBy = $request->filterBy;
        $getData = DB::table('lms_post')
            ->Join('lms_student', 'lms_post.lms_user_id', '=', 'lms_student.lms_user_id')
            ->where('lms_post.lms_post_is_active', '=', 1)
            ->where('lms_post.lms_center_id', '=', $centerId)
            ->where(function ($q) use ($filterBy) {
                $q->where('lms_post.lms_post_content', 'like', "%$filterBy%");
            })
            ->select([
                'lms_post.lms_post_id',
                'lms_post.lms_user_id',
                'lms_post.lms_post_content',
                'lms_post.lms_post_has_image',
                'lms_post.lms_post_image',
                'lms_post.lms_post_has_url',
                'lms_post.lms_post_url',
                DB::raw("IF(lms_post.lms_post_is_active = 1, 'Active','Inactive')as lms_post_is_active"),
                'lms_student.lms_student_full_name as full_name',

                //'lms_student.lms_student_profile_image as profile_image',
                DB::raw("IF(lms_post.lms_is_post_approved = 0, 'Protected','Approved')as lms_is_post_approved"),
                DB::raw('DATE_FORMAT(lms_post.lms_post_created_at, "%d-%m-%Y") as lms_post_created_at', "%d-%m-%Y"),
            ]);

        $getData_2 = DB::table('lms_post')
            ->Join('lms_staff', 'lms_post.lms_user_id', '=', 'lms_staff.lms_user_id')
            ->where('lms_post.lms_post_is_active', '=', 1)
            ->where('lms_post.lms_center_id', '=', $centerId)
            ->select([
                'lms_post.lms_post_id',
                'lms_post.lms_user_id',
                'lms_post.lms_post_content',
                'lms_post.lms_post_has_image',
                'lms_post.lms_post_image',
                'lms_post.lms_post_has_url',
                'lms_post.lms_post_url',
                // 'lms_student.lms_student_profile_image as profile_image',
                DB::raw("IF(lms_post.lms_post_is_active = 1, 'Active','Inactive')as lms_post_is_active"),
                'lms_staff.lms_staff_full_name as full_name',
                DB::raw("IF(lms_post.lms_is_post_approved = 0, 'Protected','Approved')as lms_is_post_approved"),
                DB::raw('DATE_FORMAT(lms_post.lms_post_created_at, "%d-%m-%Y") as lms_post_created_at', "%d-%m-%Y"),
            ])
            ->unionAll($getData);

            $querySql = $getData_2->toSql();	
			$getData_2 = DB::table(DB::raw("($querySql order by lms_post_created_at asc) as a"))->mergeBindings($getData_2)


            //->orderBy(DB::raw("DATE_FORMAT(lms_post.lms_post_created_at,'%d-%m-%Y %h:%i:%s')"), 'desc')

            ->paginate($perPage);
        return $getData_2;
    }

    //Enable Disable course
    public function isApprovePost(Request $request)
    {
        $centerId = $request->centerId;
        $postId = $request->postId;
        $isApproved = $request->isApproved;
        $loggedUserId = $request->loggedUserId;
        $result = NoticeModel::isApprovePost(
            $centerId,
            $postId,
            $isApproved,
            $loggedUserId
        );
        return response()->json($result);
    }

    //--------------------Notification-------------------------------

    public function saveNotification(Request $request)
    {

        $notification_title = $request->title;
        $notification_body = $request->body;
        $notification_has_image = $request->notificationHasImage;
        $notification_image = $request->notificationImage;
        $loggedUserId = $request->loggedUserId;
        $notification_image_name = null;
        $userId = $request->userId;
        $notificationDate = $request->notificationDate;
        try {
            if ($notification_has_image === "1") {

                $notification_image_name = uniqid() . time() . '.' . $request->notificationImage->extension();
                $request->notificationImage->storeAs('public/notification_images', $notification_image_name);
                if ($request->file('notificationImage')->isValid()) {

                    DB::beginTransaction();
                    $notification_id = DB::table('lms_notification')->insertGetId(
                        [
                            'notification_title' => $notification_title,
                            'notification_body' => $notification_body,
                            'notification_has_image' => $notification_has_image,
                            'notification_image' => $notification_image_name,
                            'notification_created_by' => $loggedUserId,
                            'notification_to_be_send_date' => $notificationDate,

                        ]

                    );
                    $all_user_id_from_db = DB::table('lms_user')->whereIn('lms_user_id', explode(",", $userId))->get();
                    $notification_data = DB::table('lms_notification')
                        ->where('notification_id', '=', $notification_id)
                        ->first();
                    $insert_data = collect();
                    foreach ($all_user_id_from_db as $key => $value) {
                        $insert_data->push([
                            'notification_id' => $notification_data->notification_id,
                            'user_id' => $value->lms_user_id,
                            'notification_to_be_send_date' => $notificationDate,
                        ]);
                    }
                    foreach ($insert_data->chunk(500) as $chunk) {

                        DB::table('lms_send_notification')->insert(
                            $chunk->toArray()
                        );
                    }

                    DB::commit();
                    $result['Result'] = "Success";
                } else {
                    $result['Result'] = "ImageUploadFailed";
                }
            } else {
                DB::beginTransaction();

                $notification_id = DB::table('lms_notification')->insertGetId(
                    [
                        'notification_title' => $notification_title,
                        'notification_body' => $notification_body,
                        'notification_has_image' => $notification_has_image,
                        'notification_image' => $notification_image_name,
                        'notification_created_by' => $loggedUserId,
                        'notification_to_be_send_date' => $notificationDate,

                    ]
                );

                $all_user_id_from_db = DB::table('lms_user')->whereIn('lms_user_id', explode(",", $userId))->get();
                $notification_data = DB::table('lms_notification')
                    ->where('notification_id', '=', $notification_id)
                    ->first();
                $insert_data = collect();
                foreach ($all_user_id_from_db as $key => $value) {
                    $insert_data->push([
                        'notification_id' => $notification_data->notification_id,
                        'user_id' => $value->lms_user_id,
                        'notification_to_be_send_date' => $notificationDate,
                    ]);
                }
                foreach ($insert_data->chunk(500) as $chunk) {

                    DB::table('lms_send_notification')->insert(
                        $chunk->toArray()
                    );
                }

                DB::commit();
                $result['Result'] = "Success";
            }
        } catch (Exception $e) {
            DB::rollback();
            $result['Result'] = "fail";
            if (file_exists(storage_path('app/public/notification_images/' . $notification_image_name))) {
                unlink(storage_path('app/public/notification_images/' . $notification_image_name));
            }
        }
        return response()->json($result);
    }

    //Get the notification
    public function getAllNotification(Request $request)
    {
        $perPage = $request->perPage ? $request->perPage : 50;
        $getData = DB::table("lms_notification")->select([
            'notification_id',
            'notification_title',
            'notification_body',
            'notification_has_image',
            'notification_image',
            DB::raw("date_format(notification_to_be_send_date,'%d-%m-%y') as notification_to_be_send_date")
        ])->orderBy('notification_to_be_send_date', 'desc')

            ->paginate($perPage);
        return $getData;
    }


    public function deleteNotification(Request $request)
    {

        $notification_id = $request->notification_id;
        $loggedUserId = $request->loggedUserId;
        $result = NoticeModel::deleteNotification(
            $notification_id,
            $loggedUserId
        );
        return response()->json($result);
    }
}
