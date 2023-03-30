<?php

namespace App;

use DB;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{

    public $centerId = "1";

    /*==================================================Common=========================== */
    // To check User Status
    public function checkUserStatus($userId, $roleId)
    {
        try {
            if ($roleId == "1") {
                // For student
                $getQuery = DB::table('lms_user')
                    ->leftJoin('lms_student', 'lms_user.lms_user_id', '=', 'lms_student.lms_user_id')
                    ->where('lms_user.lms_user_id', '=', $userId)
                    ->where('lms_user.lms_center_id', '=', $this->centerId)

                    ->select([
                        'lms_user.lms_user_id',
                        'lms_user.role_id',
                        'lms_user.lms_user_mobile',
                        'lms_user.lms_user_is_migrated_to_firebase',
                        'lms_user.lms_user_can_change_profile_image',
                        DB::raw('DATE_FORMAT(lms_user.lms_user_created_at, "%d-%m-%Y") as lms_user_created_at', "%d-%m-%Y"),
                        'lms_user.lms_user_is_active',
                        'lms_user.lms_logout_user',
                        'lms_user.lms_user_firebase_id',
                        'lms_user.lms_is_user_logged',
                        'lms_user.lms_user_login_code',

                        'lms_student.lms_student_id',
                        'lms_student.lms_student_first_name',
                        'lms_student.lms_student_last_name',
                        'lms_student.lms_student_full_name',
                        'lms_student.lms_student_profile_image',
                        'lms_student.lms_student_email',
                        'lms_student.lms_student_code',

                    ])
                    ->get();
            } else {
                // For other staff
                $getQuery = DB::table('lms_user')
                    ->leftJoin('lms_staff', 'lms_user.lms_user_id', '=', 'lms_staff.lms_user_id')
                    ->where('lms_user.lms_user_id', '=', $userId)
                    ->where('lms_user.lms_center_id', '=', $this->centerId)
                    ->select([
                        'lms_user.lms_user_id',
                        'lms_user.role_id',
                        'lms_user.lms_user_mobile',
                        'lms_user.lms_user_is_migrated_to_firebase',
                        'lms_user.lms_user_can_change_profile_image',
                        DB::raw('DATE_FORMAT(lms_user.lms_user_created_at, "%d-%m-%Y") as lms_user_created_at', "%d-%m-%Y"),
                        'lms_user.lms_user_is_active',
                        'lms_user.lms_logout_user',
                        'lms_user.lms_user_firebase_id',
                        'lms_user.lms_is_user_logged',
                        'lms_user.lms_user_login_code',

                        'lms_staff.lms_staff_id',
                        'lms_staff.lms_staff_first_name',
                        'lms_staff.lms_staff_last_name',
                        'lms_staff.lms_staff_full_name',
                        'lms_staff.lms_staff_profile_image',

                    ])
                    ->get();
            }
            DB::table('lms_user_history')->insertGetId(
                [
                    'lms_user_id' => $userId,
                    'lms_center_id' => $this->centerId,
                    'lms_history_date_time' => now(),
                    'lms_screeen_type' => 'Splash',
                ]
            );

            DB::table('lms_user')
                ->where('lms_user_id', $userId)
                ->where('lms_user.lms_center_id', '=', $this->centerId)
                ->update(['lms_user_last_login' => now()]);

        } catch (Exception $ex) {

        }

        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // To check Mobile Number
    public function checkMobileNumber($mobileNumber)
    {

        $getRoleQuery = DB::table('lms_user')
            ->where('lms_user.lms_user_mobile', '=', $mobileNumber)
            ->where('lms_user.lms_center_id', '=', $this->centerId)
            ->get();

        if ($getRoleQuery->count() > 0) {
            $getRoleResult = $getRoleQuery->toArray();
            if ($getRoleResult[0]->role_id == "1") {
                // For Student
                $getQuery = DB::table('lms_user')
                    ->leftJoin('lms_student', 'lms_user.lms_user_id', '=', 'lms_student.lms_user_id')
                    ->where('lms_user.lms_user_mobile', '=', $mobileNumber)
                    ->where('lms_user.lms_center_id', '=', $this->centerId)
                    ->select([
                        'lms_user.lms_user_id',
                        'lms_user.role_id',
                        'lms_user.lms_user_mobile',
                        'lms_user.lms_user_is_migrated_to_firebase',
                        'lms_user.lms_user_can_change_profile_image',
                        DB::raw('DATE_FORMAT(lms_user.lms_user_created_at, "%d-%m-%Y") as lms_user_created_at', "%d-%m-%Y"),
                        'lms_user.lms_user_is_active',
                        'lms_user.lms_logout_user',
                        'lms_user.lms_user_firebase_id',
                        'lms_user.lms_is_user_logged',
                        'lms_user.lms_user_login_code',

                        'lms_student.lms_student_id',
                        'lms_student.lms_student_first_name',
                        'lms_student.lms_student_last_name',
                        'lms_student.lms_student_full_name',
                        'lms_student.lms_student_profile_image',
                        'lms_student.lms_student_email',
                        'lms_student.lms_student_code',

                    ])
                    ->get();
            } else {
                // For other staff
                $getQuery = DB::table('lms_user')
                    ->leftJoin('lms_staff', 'lms_user.lms_user_id', '=', 'lms_staff.lms_user_id')
                    ->where('lms_user.lms_user_mobile', '=', $mobileNumber)
                    ->where('lms_user.lms_center_id', '=', $this->centerId)
                    ->select([
                        'lms_user.lms_user_id',
                        'lms_user.role_id',
                        'lms_user.lms_user_mobile',
                        'lms_user.lms_user_is_migrated_to_firebase',
                        'lms_user.lms_user_can_change_profile_image',
                        DB::raw('DATE_FORMAT(lms_user.lms_user_created_at, "%d-%m-%Y") as lms_user_created_at', "%d-%m-%Y"),
                        'lms_user.lms_user_is_active',
                        'lms_user.lms_logout_user',
                        'lms_user.lms_user_firebase_id',
                        'lms_user.lms_is_user_logged',
                        'lms_user.lms_user_login_code',

                        'lms_staff.lms_staff_id',
                        'lms_staff.lms_staff_first_name',
                        'lms_staff.lms_staff_last_name',
                        'lms_staff.lms_staff_full_name',
                        'lms_staff.lms_staff_profile_image',

                    ])
                    ->get();
            }
            $getResult = $getQuery->toArray();
            return $getResult;
        } else {
            return [];
        }

    }

    // To check login
    public function checkLogin($mobile, $password, $userDeviceToken, $userCode)
    {

        $getBcryptPasswordQuery = DB::table('lms_user')
            ->where('lms_user_mobile', '=', $mobile)
            ->where('lms_user.lms_center_id', '=', $this->centerId)
            ->select(['password', 'role_id'])
            ->get();
        if ($getBcryptPasswordQuery->count() > 0) {
            $bcryptPassword = $getBcryptPasswordQuery[0]->password;
            if (password_verify($password, $bcryptPassword)) {

                if ($getBcryptPasswordQuery[0]->role_id == "1") {
                    // For Student

                    $getQuery = DB::table('lms_user')
                        ->leftJoin('lms_student', 'lms_user.lms_user_id', '=', 'lms_student.lms_user_id')
                        ->where('lms_user.lms_user_mobile', '=', $mobile)
                        ->where('lms_user.lms_center_id', '=', $this->centerId)

                        ->select([
                            'lms_user.lms_user_id',
                            'lms_user.role_id',
                            'lms_user.lms_user_mobile',
                            'lms_user.lms_user_is_migrated_to_firebase',
                            'lms_user.lms_user_can_change_profile_image',
                            DB::raw('DATE_FORMAT(lms_user.lms_user_created_at, "%d-%m-%Y") as lms_user_created_at', "%d-%m-%Y"),
                            'lms_user.lms_user_is_active',
                            'lms_user.lms_logout_user',
                            'lms_user.lms_user_firebase_id',
                            'lms_user.lms_is_user_logged',
                            'lms_user.lms_user_login_code',

                            'lms_student.lms_student_id',
                            'lms_student.lms_student_first_name',
                            'lms_student.lms_student_last_name',
                            'lms_student.lms_student_full_name',
                            'lms_student.lms_student_profile_image',
                            'lms_student.lms_student_email',
                            'lms_student.lms_student_code',

                        ])
                        ->get();
                } else {
                    // For other staff
                    $getQuery = DB::table('lms_user')
                        ->leftJoin('lms_staff', 'lms_user.lms_user_id', '=', 'lms_staff.lms_user_id')
                        ->where('lms_user.lms_user_mobile', '=', $mobile)
                        ->where('lms_user.lms_center_id', '=', $this->centerId)
                        ->select([
                            'lms_user.lms_user_id',
                            'lms_user.role_id',
                            'lms_user.lms_user_mobile',
                            'lms_user.lms_user_is_migrated_to_firebase',
                            'lms_user.lms_user_can_change_profile_image',
                            DB::raw('DATE_FORMAT(lms_user.lms_user_created_at, "%d-%m-%Y") as lms_user_created_at', "%d-%m-%Y"),
                            'lms_user.lms_user_is_active',
                            'lms_user.lms_logout_user',
                            'lms_user.lms_user_firebase_id',
                            'lms_user.lms_is_user_logged',
                            'lms_user.lms_user_login_code',

                            'lms_staff.lms_staff_id',
                            'lms_staff.lms_staff_first_name',
                            'lms_staff.lms_staff_last_name',
                            'lms_staff.lms_staff_full_name',
                            'lms_staff.lms_staff_profile_image',

                        ])
                        ->get();
                }

                $getResult = $getQuery->toArray();
                DB::table('lms_user')
                    ->where('lms_user_id', $getResult[0]->lms_user_id)
                    ->where('lms_user.lms_center_id', '=', $this->centerId)
                    ->update(['lms_is_user_logged' => 1, 'lms_user_login_code' => $userCode]);

                $this->updateDeviceToken($getResult[0]->lms_user_id, $userDeviceToken);
                return $getResult;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function logoutUser($userId)
    {
        DB::table('lms_user')
            ->where('lms_user_id', $userId)
            ->where('lms_user.lms_center_id', '=', $this->centerId)
            ->update(['lms_is_user_logged' => 0]);

        $resultData['result'] = "success";

        return $resultData;
    }

// Update Device Token
    public function updateDeviceToken($userId, $userDeviceToken)
    {
        DB::table('lms_user')
            ->where('lms_user_id', $userId)
            ->where('lms_user.lms_center_id', '=', $this->centerId)
            ->update(['lms_user_device_token' => $userDeviceToken]);

        $getResult['result'] = "success";
        return $getResult;
    }

    // Get common about us
    public function getCommonAboutUs()
    {
        $getQuery = DB::table('lms_about_us')
            ->where('about_us_status', '=', 1)
            ->where('lms_center_id', '=', $this->centerId)

            ->select()
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }
    // To get CourseList
    public function getCourseList()
    {

        $getQuery = DB::table('lms_course')
            ->where('lms_course_is_active', '=', 1)
            ->where('lms_center_id', '=', $this->centerId)
            ->select(['lms_course_id',
                'lms_course_name',
                'lms_course_image',
                'lms_course_description',
                'lms_course_fees',
                'lms_course_code',
            ])
            ->paginate(20);
        return $getQuery;

    }

    // To get gallery list
    public function getGalleryList()
    {

        $getQuery = DB::table('lms_gallery')
            ->where('lms_gallery_status', '=', 1)
            ->where('lms_center_id', '=', $this->centerId)
            ->select(['lms_gallery_id',
                'lms_gallery_name',
                'lms_gallery_image',
                'lms_gallery_description',
            ])
            ->paginate(20);
        return $getQuery;

    }

// To Change password
    public function changePassword($oldPassword, $newPassword, $userId)
    {
        try {
            $getQuery = DB::table('lms_user')
                ->where('lms_user_id', '=', $userId)
                ->where('lms_center_id', '=', $this->centerId)
                ->select(['password'])
                ->first();
            $bcryptPassword = $getQuery->password;
            if (password_verify($oldPassword, $bcryptPassword)) {

                DB::table('lms_user')
                    ->where('lms_user_id', $userId)
                    ->where('lms_center_id', '=', $this->centerId)
                    ->update([
                        'password' => bcrypt($newPassword),
                        'password_normal' => $newPassword,

                    ]);

                $resultData['result'] = "success";
            } else {
                $resultData['result'] = "wrong";
            }
        } catch (Exception $ex) {
            $resultData['result'] = "exception";
        }

        return $resultData;
    }

    // Update profile image
    public function updateStudentProfileImage($userId, $fileName)
    {
        try {
            DB::beginTransaction();
            DB::table('lms_student')
                ->where('lms_user_id', $userId)
                ->where('lms_center_id', '=', $this->centerId)
                ->update(['lms_student_profile_image' => $fileName]);

            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
        }

        return $resultData;
    }
    // Remove profile image
    public function removeStudentProfileImage($userId, $fileName)
    {
        try {
            DB::beginTransaction();
            DB::table('lms_student')
                ->where('lms_user_id', $userId)
                ->where('lms_center_id', '=', $this->centerId)
                ->update(['lms_student_profile_image' => null]);

            if (file_exists(storage_path('app/public/user_profile_images/' . $fileName))) {
                unlink(storage_path('app/public/user_profile_images/' . $fileName));
            }
            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
        }

        return $resultData;
    }

    // update first name
    public function updateStudentFirstName($userId, $firstName, $fullName)
    {

        try {
            DB::beginTransaction();
            DB::table('lms_student')
                ->where('lms_user_id', $userId)
                ->where('lms_center_id', '=', $this->centerId)
                ->update(['lms_student_first_name' => ucfirst($firstName), 'lms_student_full_name' => $fullName]);

            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
        }

        return $resultData;
    }
    //update last name
    public function updateStudentLastName($userId, $lastName, $fullName)
    {

        try {
            DB::beginTransaction();
            DB::table('lms_student')
                ->where('lms_user_id', $userId)
                ->where('lms_center_id', '=', $this->centerId)
                ->update(['lms_student_last_name' => ucfirst($lastName), 'lms_student_full_name' => $fullName]);

            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
        }

        return $resultData;
    }

    // update mobile number
    public function updateStudentMobileNumber($userId, $mobileNumber)
    {

        $getQuery = DB::table('lms_user')->
            where('lms_user_mobile', $mobileNumber)
            ->where('lms_user_id', '!=', $userId)
            ->where('lms_center_id', '=', $this->centerId)
            ->get();
        if ($getQuery->count() == 0) {
            try {

                DB::beginTransaction();
                DB::table('lms_user')
                    ->where('lms_user_id', $userId)
                    ->where('lms_center_id', '=', $this->centerId)

                    ->update(['lms_user_mobile' => $mobileNumber]);
                DB::table('lms_student')
                    ->where('lms_user_id', $userId)
                    ->where('lms_center_id', '=', $this->centerId)

                    ->update(['lms_student_mobile_number' => $mobileNumber]);

                DB::commit();
                $resultData['result'] = "success";
            } catch (Exception $ex) {
                DB::rollback();
            }
        } else {
            $resultData['result'] = "exists";
        }
        return $resultData;
    }

    // Get common about us
    public function getStudentCourseMapping($studentId)
    {
        $getQuery = DB::table('lms_student_course_mapping')
            ->leftJoin('lms_course', 'lms_course.lms_course_id', '=', 'lms_student_course_mapping.lms_course_id')
            ->leftJoin('lms_batch_details', 'lms_batch_details.lms_batch_id', '=', 'lms_student_course_mapping.lms_batch_id')
            ->leftJoin('lms_child_course', 'lms_child_course.lms_child_course_id', '=', 'lms_student_course_mapping.lms_child_course_id')
            ->where('lms_student_course_mapping.lms_student_id', '=', $studentId)
            ->where('lms_student_course_mapping.lms_student_course_mapping_status', '=', 1)
            ->select(['lms_student_course_mapping.lms_registration_id',
                'lms_student_course_mapping.lms_registration_code',
                'lms_student_course_mapping.lms_child_course_id',
                'lms_course.lms_course_name',
                'lms_course.lms_course_code',
                'lms_course.lms_course_id',
                'lms_course.lms_course_image',
                DB::raw('DATE_FORMAT(lms_student_course_mapping.lms_student_course_mapping_date, "%d-%m-%Y") as lms_student_course_mapping_date', "%d-%m-%Y"),
                'lms_batch_details.lms_batch_id',
                'lms_batch_details.lms_batch_code',
                'lms_batch_details.lms_batch_name',
                'lms_child_course.lms_child_course_name',
            ])
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // To get exam schedule course wise
    public function getExamScheduleCourseWise($studentId, $courseId, $examScheduleType, $isViewAll, $childCourseId)
    {
        if ($isViewAll == "1") {
            $getQuery = DB::table('lms_exam_schedule')
                ->where('lms_exam_schedule.lms_course_id', '=', $courseId)
                ->where('lms_exam_schedule.lms_child_course_id', '=', $childCourseId)
                ->where('lms_exam_schedule.lms_center_id', '=', $this->centerId)
                ->where('lms_exam_schedule.lms_exam_schedule_is_active', '=', 1)
                ->where('lms_exam_schedule.lms_exam_schedule_type', '=', $examScheduleType)
                ->whereRaw('lms_exam_schedule.lms_exam_schedule_no_of_question=lms_exam_schedule.total_assigned_question')

                ->select([
                    'lms_exam_schedule.total_assigned_question',
                    'lms_exam_schedule.lms_exam_schedule_id',
                    'lms_exam_schedule.lms_exam_instruction_id',
                    'lms_exam_schedule.lms_exam_schedule_name',
                    'lms_exam_schedule.lms_exam_schedule_no_of_question',
                    'lms_exam_schedule.lms_exam_schedule_description',
                    'lms_exam_schedule.lms_exam_schedule_max_marks',
                    'lms_exam_schedule.lms_exam_schedule_total_time_alloted',
                    'lms_exam_schedule.lms_exam_schedule_is_free_paid', // 1 free 0 paid
                    'lms_exam_schedule.lms_exam_schedule_pass_marks',
                    'lms_exam_schedule.lms_exam_schedule_has_negative_marking',
                    'lms_exam_schedule.lms_exam_schedule_result_display_type',
                    'lms_exam_schedule.lms_exam_schedule_image',
                    'lms_exam_schedule.lms_exam_schedule_type',

                    DB::raw('DATE_FORMAT(lms_exam_schedule.lms_exam_schedule_live_to, "%d-%m-%Y %h:%i %p") as lms_exam_schedule_live_to', "%d-%m-%Y %h:%i %p"),
                    DB::raw('DATE_FORMAT(lms_exam_schedule.lms_exam_schedule_live_from, "%d-%m-%Y %h:%i %p") as lms_exam_schedule_live_from', "%d-%m-%Y %h:%i %p"),
                    DB::raw("(SELECT count(distinct lms_exam_result.lms_student_id)
     FROM lms_exam_result where
     lms_exam_schedule.lms_exam_schedule_id=lms_exam_result.lms_exam_schedule_id

) as total_attempt"),

                    DB::raw(" (SELECT  group_concat(distinct(lms_exam_result.lms_is_exam_complete)) from  lms_exam_result
where lms_exam_result.lms_exam_schedule_id=lms_exam_schedule.lms_exam_schedule_id
and  lms_exam_result.lms_student_id=$studentId

) as lms_is_exam_complete"),
                    DB::raw(" (SELECT lms_exam_result_details.lms_exam_result_resume_time
     from  lms_exam_result_details
where lms_exam_result_details.lms_exam_schedule_id=lms_exam_schedule.lms_exam_schedule_id
and  lms_exam_result_details.lms_student_id=$studentId
) as lms_exam_result_resume_time"),

                    DB::raw(" (select CASE
WHEN now() between lms_exam_schedule.lms_exam_schedule_live_from and lms_exam_schedule.lms_exam_schedule_live_to  THEN 'Live'
WHEN now() > lms_exam_schedule.lms_exam_schedule_live_from THEN 'Expired'
ELSE 'Upcoming'
END

) as exam_live_upcoming_expired"),

                    DB::raw(" (select CASE
WHEN now() between lms_exam_schedule.lms_exam_schedule_live_from and lms_exam_schedule.lms_exam_schedule_live_to  THEN 1
WHEN now() > lms_exam_schedule.lms_exam_schedule_live_from THEN 2
ELSE 3
END

) as exam_live_upcoming_expired_sorting"),

                ])
                ->orderBy('exam_live_upcoming_expired_sorting', 'asc')

                ->paginate(20);

        } else {
            $getQuery = DB::table('lms_exam_schedule')

                ->where('lms_exam_schedule.lms_course_id', '=', $courseId)
                ->where('lms_exam_schedule.lms_child_course_id', '=', $childCourseId)
                ->where('lms_exam_schedule.lms_center_id', '=', $this->centerId)
                ->where('lms_exam_schedule.lms_exam_schedule_type', '=', $examScheduleType)
                ->where('lms_exam_schedule.lms_exam_schedule_is_active', '=', 1)
                ->whereRaw('lms_exam_schedule.lms_exam_schedule_no_of_question=lms_exam_schedule.total_assigned_question')

                ->select([

                    'lms_exam_schedule.total_assigned_question',
                    'lms_exam_schedule.lms_exam_schedule_id',

                    'lms_exam_schedule.lms_exam_instruction_id',
                    'lms_exam_schedule.lms_exam_schedule_name',
                    'lms_exam_schedule.lms_exam_schedule_no_of_question',
                    'lms_exam_schedule.lms_exam_schedule_description',
                    'lms_exam_schedule.lms_exam_schedule_max_marks',
                    'lms_exam_schedule.lms_exam_schedule_total_time_alloted',
                    'lms_exam_schedule.lms_exam_schedule_is_free_paid', // 1 free 0 paid
                    'lms_exam_schedule.lms_exam_schedule_pass_marks',
                    'lms_exam_schedule.lms_exam_schedule_has_negative_marking',
                    'lms_exam_schedule.lms_exam_schedule_result_display_type',
                    'lms_exam_schedule.lms_exam_schedule_image',
                    'lms_exam_schedule.lms_exam_schedule_type',
                    DB::raw('DATE_FORMAT(lms_exam_schedule.lms_exam_schedule_live_to, "%d-%m-%Y %h:%i %p") as lms_exam_schedule_live_to', "%d-%m-%Y %h:%i %p"),
                    DB::raw('DATE_FORMAT(lms_exam_schedule.lms_exam_schedule_live_from, "%d-%m-%Y %h:%i %p") as lms_exam_schedule_live_from', "%d-%m-%Y %h:%i %p"),
                    DB::raw("(SELECT count(distinct lms_exam_result.lms_student_id)
                FROM lms_exam_result where
                lms_exam_schedule.lms_exam_schedule_id=lms_exam_result.lms_exam_schedule_id

       ) as total_attempt"),

                    DB::raw(" (SELECT  group_concat(distinct(lms_exam_result.lms_is_exam_complete)) from  lms_exam_result
       where lms_exam_result.lms_exam_schedule_id=lms_exam_schedule.lms_exam_schedule_id
           and  lms_exam_result.lms_student_id=$studentId

      ) as lms_is_exam_complete"),
                    DB::raw(" (SELECT lms_exam_result_details.lms_exam_result_resume_time
                from  lms_exam_result_details
       where lms_exam_result_details.lms_exam_schedule_id=lms_exam_schedule.lms_exam_schedule_id
       and  lms_exam_result_details.lms_student_id=$studentId
   ) as lms_exam_result_resume_time"),

                    DB::raw(" (select CASE
   WHEN now() between lms_exam_schedule.lms_exam_schedule_live_from and lms_exam_schedule.lms_exam_schedule_live_to  THEN 'Live'
   WHEN now() > lms_exam_schedule.lms_exam_schedule_live_from THEN 'Expired'
   ELSE 'Upcoming'
   END

      ) as exam_live_upcoming_expired"),
                    DB::raw(" (select CASE
WHEN now() between lms_exam_schedule.lms_exam_schedule_live_from and lms_exam_schedule.lms_exam_schedule_live_to  THEN 1
WHEN now() > lms_exam_schedule.lms_exam_schedule_live_from THEN 2
ELSE 3
END

) as exam_live_upcoming_expired_sorting"),

                ])
                ->orderBy('exam_live_upcoming_expired_sorting', 'asc')

                ->paginate(20);

        }
        return $getQuery;

    }

    // To get exam card by user and course
    public function getExamCardByStudentCourseWise($studentId, $courseId)
    {

        $getQuery = DB::table('lms_exam_card_user_wise')
            ->join('lms_exam_card', 'lms_exam_card.lms_exam_card_id', '=', 'lms_exam_card_user_wise.lms_exam_card_id')
            ->where('lms_exam_card.lms_exam_card_card_is_active', '=', 1)
            ->where('lms_exam_card.lms_course_id', '=', $courseId)
            ->where('lms_exam_card_user_wise.lms_student_id', '=', $studentId)
            ->select([

                'lms_exam_card_user_wise.lms_exam_card_id',
                DB::raw(" (select CASE
                WHEN now()<=lms_exam_card_user_wise.lms_exam_card_expiry_date THEN 'Active'
                WHEN now() > lms_exam_card_user_wise.lms_exam_card_expiry_date THEN 'Expired'
                END
                   ) as lms_exam_card_is_active_expire"),

            ])

            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // To get exam instruction
    public function getExamInstruction($examScheduleId)
    {

        $getQuery = DB::select("select
        lms_exam_schedule.lms_exam_schedule_no_of_question,
        lms_exam_schedule.lms_exam_schedule_max_marks,
        lms_exam_schedule.lms_exam_schedule_total_time_alloted,
         lms_exam_schedule.lms_exam_schedule_pass_marks,
         lms_exam_schedule.lms_exam_schedule_has_negative_marking,
        lms_exam_schedule.lms_exam_schedule_negative_marking,

         lms_exam_instruction.lms_exam_instruction_content,

         (select group_concat(distinct lms_topic.lms_topic_name
         order by lms_topic.lms_topic_name)
          from   lms_exam_wise_question
         join lms_question_bank on
          lms_question_bank.lms_question_bank_id=lms_exam_wise_question.lms_question_bank_id
         join lms_topic
         on lms_question_bank.lms_topic_id= lms_topic.lms_topic_id
         where lms_exam_wise_question.lms_exam_schedule_id=$examScheduleId
          )  as 'topic_names',



          (select  group_concat( cnt)  cnt
          from
          (
           SELECT COUNT(*) cnt
             from   lms_question_bank
         join lms_exam_wise_question on   lms_question_bank.lms_question_bank_id=
         lms_exam_wise_question.lms_question_bank_id
         join lms_topic on lms_question_bank.lms_topic_id= lms_topic.lms_topic_id
         where lms_exam_wise_question.lms_exam_schedule_id=$examScheduleId
          group by lms_question_bank.lms_topic_id  order by lms_topic.lms_topic_name
          ) q

          )  as 'topic_wise_question_count'
          from lms_exam_schedule

         join lms_exam_instruction  on lms_exam_instruction.lms_exam_instruction_id=lms_exam_schedule.lms_exam_instruction_id



         where lms_exam_schedule.lms_exam_schedule_id=$examScheduleId");
        return $getQuery;
    }

    public function getExamQuestion($examScheduleId)
    {

        $getQuery = DB::table('lms_exam_schedule')
            ->join('lms_exam_wise_question', 'lms_exam_schedule.lms_exam_schedule_id', '=', 'lms_exam_wise_question.lms_exam_schedule_id')
            ->join('lms_question_bank', 'lms_question_bank.lms_question_bank_id', '=', 'lms_exam_wise_question.lms_question_bank_id')
            ->join('lms_question_difficulty_level', 'lms_question_difficulty_level.lms_question_difficulty_level_id', '=', 'lms_question_bank.lms_question_difficulty_level_id')
            ->join('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_question_bank.lms_topic_id')
            ->leftJoin('lms_exam_result', 'lms_question_bank.lms_question_bank_id', '=', 'lms_exam_result.lms_question_bank_id')

            ->where('lms_exam_schedule.lms_exam_schedule_id', '=', $examScheduleId)
            ->where('lms_exam_schedule.lms_center_id', '=', $this->centerId)
            ->where('lms_question_bank.lms_question_bank_is_active', '=', 1)

            ->select([
                'lms_exam_schedule.lms_exam_schedule_name',
                'lms_exam_schedule.lms_exam_schedule_no_of_question',
                'lms_exam_schedule.lms_exam_schedule_max_marks',
                'lms_exam_schedule.lms_exam_schedule_total_time_alloted',
                'lms_exam_schedule.lms_exam_schedule_is_free_paid',
                'lms_exam_schedule.lms_exam_schedule_pass_marks',
                'lms_exam_schedule.lms_exam_schedule_has_negative_marking',
                'lms_exam_schedule.lms_exam_schedule_negative_marking',

                'lms_question_bank.lms_question_bank_id',
                'lms_question_bank.lms_subject_id',
                'lms_question_bank.lms_topic_id',
                'lms_question_bank.lms_question_difficulty_level_id',
                'lms_question_bank.lms_question_bank_type_single_multiple',
                'lms_question_bank.lms_question_bank_has_image',
                'lms_question_bank.lms_question_bank_image_path',
                'lms_question_bank.lms_question_bank_text',
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

                'lms_topic.lms_topic_name',

                'lms_question_difficulty_level.lms_question_difficulty_level_name',
                'lms_exam_result.lms_user_answers'])
            ->orderBy('lms_question_bank.lms_question_bank_id')
            ->groupBy('lms_question_bank.lms_question_bank_id')

            ->paginate(20);
        return $getQuery;
    }

    // To save exam
    public function saveExam($studentId, $userId,
        $registrationId,
        $examScheduleId, $isExamComplete,
        $examResumeTime, $examAnswerData,
        $isSubmitButtonClicked, $courseId,
        $startExamTime, $endExamTime
    ) {
        $answer_data = json_decode($examAnswerData);

        $exception = DB::transaction(function () use ($studentId, $userId,
            $registrationId,
            $examScheduleId, $isExamComplete,
            $examResumeTime, $answer_data,
            $isSubmitButtonClicked, $courseId, $startExamTime, $endExamTime) {

            for ($x = 0; $x < count($answer_data); $x++) {

                $is_question_attempted = "0";
                $is_answer_correct = null;
                $marks_scored = "0";

                if ($answer_data[$x]->lms_user_answers === "" || $answer_data[$x]->lms_user_answers === null) {
                } else {
                    $is_question_attempted = "1";

                    if ($answer_data[$x]->lms_user_answers === $answer_data[$x]->lms_question_bank_correct_answers) {
                        $is_answer_correct = "1";
                        $marks_scored = $answer_data[$x]->lms_question_bank_marks;
                    } else {
                        $total_option_correct = count(array_intersect(explode(",", $answer_data[$x]->lms_user_answers), explode(",", $answer_data[$x]->lms_question_bank_correct_answers)));

                        if ($total_option_correct == 0) {
                            $is_answer_correct = "0";
                            if ($answer_data[$x]->lms_exam_schedule_negative_marking == 0) {
                                $marks_scored = 0;
                            } else {
                                //  $marks_scored = -($answer_data[$x]->lms_question_bank_marks - $answer_data[$x]->lms_question_bank_marks * ($answer_data[$x]->lms_exam_schedule_negative_marking));
                                $marks_scored = -($answer_data[$x]->lms_exam_schedule_negative_marking);
                            }
                        } else {

                            $marks_scored_partially = ($answer_data[$x]->lms_question_bank_marks) / count(explode(',', ($answer_data[$x]->lms_question_bank_correct_answers))) * $total_option_correct;
                            if ($answer_data[$x]->lms_exam_schedule_negative_marking == 0) {
                                $marks_scored = $marks_scored_partially;
                            } else {

                                $marks_scored = $marks_scored_partially - $answer_data[$x]->lms_question_bank_marks * $answer_data[$x]->lms_exam_schedule_negative_marking;
                            }
                            $is_answer_correct = "2";
                        }
                    }
                }

                DB::table('lms_exam_result')->updateOrInsert(
                    [
                        'lms_user_id' => $userId,
                        'lms_student_id' => $studentId,
                        'lms_registration_id' => $registrationId,
                        'lms_exam_schedule_id' => $examScheduleId,
                        'lms_question_bank_id' => $answer_data[$x]->lms_question_bank_id,

                    ],
                    [
                        'lms_user_id' => $userId,
                        'lms_student_id' => $studentId,
                        'lms_registration_id' => $registrationId,
                        'lms_exam_schedule_id' => $examScheduleId,
                        'lms_question_bank_id' => $answer_data[$x]->lms_question_bank_id,
                        'lms_topic_id' => $answer_data[$x]->lms_topic_id,
                        'lms_subject_id' => $answer_data[$x]->lms_subject_id,
                        'lms_user_answers' => $answer_data[$x]->lms_user_answers,
                        'lms_is_exam_complete' => $isExamComplete,
                        'lms_exam_resume_time' => $examResumeTime,
                        'lms_correct_answer' => $answer_data[$x]->lms_question_bank_correct_answers,
                        'lms_question_marks' => $answer_data[$x]->lms_question_bank_marks,
                        'lms_negative_marking' => $answer_data[$x]->lms_exam_schedule_negative_marking,
                        'lms_marks_scored' => $marks_scored,
                        'lms_is_question_attempted' => $is_question_attempted,
                        'lms_is_answer_correct' => $is_answer_correct,
                        'lms_course_id' => $courseId,

                    ]
                );

                $query_to_update_totals = DB::select("sELECT
                    sum(lms_exam_result.lms_is_question_attempted) as Attempted,
                    SUM(IF(lms_exam_result.lms_is_answer_correct = '2', 1,0)) AS Partly_Correct,
                    SUM(IF(lms_exam_result.lms_is_answer_correct = '1', 1,0)) AS Correct,
                    SUM(IF(lms_exam_result.lms_is_answer_correct = '0', 1,0)) AS Incorrect,
                    SUM(lms_exam_result.lms_marks_scored) AS marks_scored,
                    SUM(lms_exam_result.lms_question_marks) AS lms_question_marks,
                    lms_exam_schedule.lms_exam_schedule_no_of_question
                    FROM lms_exam_result JOIN lms_exam_schedule
                    on lms_exam_result.lms_exam_schedule_id = lms_exam_schedule.lms_exam_schedule_id
                    where lms_exam_result.lms_student_id=$studentId AND lms_exam_schedule.lms_exam_schedule_id=$examScheduleId");
                DB::table('lms_exam_result_details')->updateOrInsert(
                    [
                        'lms_user_id' => $userId,
                        'lms_student_id' => $studentId,
                        'lms_registration_id' => $registrationId,

                        'lms_exam_schedule_id' => $examScheduleId,
                    ],
                    [
                        'lms_user_id' => $userId,
                        'lms_student_id' => $studentId,
                        'lms_registration_id' => $registrationId,

                        'lms_exam_schedule_id' => $examScheduleId,
                        'lms_exam_result_resume_time' => $examResumeTime,

                        'lms_total_marks_scored' => $query_to_update_totals[0]->marks_scored,
                        'lms_total_question' => $query_to_update_totals[0]->lms_exam_schedule_no_of_question,
                        'lms_total_answer_attempted' => $query_to_update_totals[0]->Attempted,

                        'lms_exam_start_time' => $startExamTime,
                        'lms_exam_end_time' => $endExamTime,

                    ]
                );
                if ($isSubmitButtonClicked === "1") {

                    $query_to_update_totals = DB::select("sELECT
    sum(lms_exam_result.lms_is_question_attempted) as Attempted,
    SUM(IF(lms_exam_result.lms_is_answer_correct = '2', 1,0)) AS Partly_Correct,
    SUM(IF(lms_exam_result.lms_is_answer_correct = '1', 1,0)) AS Correct,
    SUM(IF(lms_exam_result.lms_is_answer_correct = '0', 1,0)) AS Incorrect,
    SUM(lms_exam_result.lms_marks_scored) AS marks_scored,
    SUM(lms_exam_result.lms_question_marks) AS lms_question_marks,
    lms_exam_schedule.lms_exam_schedule_no_of_question
    FROM lms_exam_result JOIN lms_exam_schedule
    on lms_exam_result.lms_exam_schedule_id = lms_exam_schedule.lms_exam_schedule_id
    where lms_exam_result.lms_student_id=$studentId AND lms_exam_schedule.lms_exam_schedule_id=$examScheduleId");

                    DB::table('lms_exam_result_details')->updateOrInsert(
                        [
                            'lms_user_id' => $userId,
                            'lms_student_id' => $studentId,
                            'lms_registration_id' => $registrationId,

                            'lms_exam_schedule_id' => $examScheduleId,
                        ],
                        [

                            'lms_total_marks_scored' => $query_to_update_totals[0]->marks_scored,
                            'lms_total_question' => $query_to_update_totals[0]->lms_exam_schedule_no_of_question,
                            'lms_total_answer_attempted' => $query_to_update_totals[0]->Attempted,
                            'lms_exam_result_details_is_active' => '2',

                        ]
                    );
                }
            }
        });

        if (is_null($exception)) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return $resultData;

    }

    // get exam review

    public function getExamReview($studentId, $examScheduleId)
    {
        $getQuery = DB::select("select
        lms_exam_wise_question.lms_exam_wise_question_id,
        lms_exam_wise_question.lms_question_bank_id,
        lms_exam_wise_question.lms_exam_schedule_id,

lms_exam_result.lms_is_question_attempted,
lms_exam_result.lms_student_id

from lms_exam_wise_question left join lms_exam_result
on lms_exam_wise_question.lms_question_bank_id=lms_exam_result.lms_question_bank_id
and  lms_exam_result.lms_student_id=$studentId
where lms_exam_wise_question.lms_exam_schedule_id=$examScheduleId
order by lms_exam_wise_question.lms_question_bank_id
");

        return $getQuery;
    }

    public function getExamAnalysisUserWise($examScheduleId, $studentId)
    {

        $getQuery = DB::select("select lms_user_id,lms_total_marks_scored ,
FIND_IN_SET( lms_total_marks_scored, (
SELECT GROUP_CONCAT(DISTINCT lms_total_marks_scored
ORDER BY lms_total_marks_scored DESC )
FROM lms_exam_result_details )
) AS rank,(select count(*) from lms_exam_result_details
where  lms_exam_result_details.lms_exam_schedule_id=$examScheduleId)
as total_user, (SELECT
SUM(IF(lms_is_question_attempted = 1, 1,0))  from
lms_exam_result where lms_exam_result.lms_student_id=$studentId
 AND lms_exam_result.lms_exam_schedule_id=$examScheduleId
 ) as attempted,
  (SELECT
SUM(IF(lms_is_question_attempted = 0, 1,0))
 from
 lms_exam_result where lms_exam_result.lms_student_id=$studentId
 AND lms_exam_result.lms_exam_schedule_id=$examScheduleId
 ) as not_attempted,
 (SELECT SUM(IF(lms_exam_result.lms_is_answer_correct = 2, 1,0))   from
 lms_exam_result where lms_exam_result.lms_student_id=$studentId
 AND lms_exam_result.lms_exam_schedule_id=$examScheduleId ) as
partly_correct,
 (SELECT SUM(IF(lms_exam_result.lms_is_answer_correct = 0, 1,0))   from
 lms_exam_result where lms_exam_result.lms_student_id=$studentId
 AND lms_exam_result.lms_exam_schedule_id=$examScheduleId

 ) as
incorrect,

(SELECT SUM(IF(lms_exam_result.lms_is_answer_correct = 1, 1,0))  from
lms_exam_result where lms_exam_result.lms_student_id=$studentId
AND lms_exam_result.lms_exam_schedule_id=$examScheduleId ) as
correct,
(SELECT SUM(lms_exam_result.lms_question_marks)  from
lms_exam_result where lms_exam_result.lms_student_id=$studentId
AND lms_exam_result.lms_exam_schedule_id=$examScheduleId ) as
lms_question_marks,

(SELECT lms_exam_schedule_no_of_question  from
lms_exam_schedule where lms_exam_schedule.lms_exam_schedule_id=$examScheduleId ) as

lms_exam_schedule_no_of_question,

(SELECT lms_exam_schedule_max_marks  from
lms_exam_schedule where lms_exam_schedule.lms_exam_schedule_id=$examScheduleId ) as

lms_exam_schedule_max_marks

FROM lms_exam_result_details
where lms_student_id=$studentId and lms_exam_result_details.lms_exam_schedule_id=$examScheduleId");
        return $getQuery;
    }

    // get exam analysis top user
    public function getExamAnalysisTopUser($examScheduleId)
    {

        $getQuery = DB::select("select
        lms_exam_result_details.lms_user_id,
        lms_student.lms_student_full_name,
        lms_exam_schedule.lms_exam_schedule_max_marks,
        lms_exam_result_details.lms_total_marks_scored,
        lms_exam_result_details.lms_total_question,
        lms_exam_result_details.lms_total_answer_attempted,
        lms_student.lms_student_profile_image,
        lms_student.lms_student_first_name,lms_student.lms_student_last_name,
IF (@score=lms_exam_result_details.lms_total_marks_scored, @rank:=@rank, @rank:=@rank+1) rank,
@score:=lms_exam_result_details.lms_total_marks_scored score
FROM lms_exam_result_details  join lms_student  on lms_exam_result_details.lms_student_id
= lms_student.lms_student_id
join lms_exam_schedule  on lms_exam_schedule.lms_exam_schedule_id=lms_exam_result_details.lms_exam_schedule_id,
(SELECT @score:=0, @rank:=0) r
where lms_exam_result_details.lms_exam_schedule_id=$examScheduleId
and lms_exam_result_details.lms_exam_result_details_is_active=2
ORDER BY lms_total_marks_scored DESC limit 20");
        return $getQuery;
    }
    // get exam analysis topic wise
    public function getExamAnalysisTopicWise($examScheduleId, $studentId)
    {

        $getQuery = DB::select("select topic.lms_topic_id,
        topic.lms_topic_name,
sum(result.lms_is_question_attempted) as attempted,
SUM(IF(result.lms_is_question_attempted = 0, 1,0)) AS unattempted,
SUM(IF(result.lms_is_answer_correct = 2, 1,0)) AS partly_correct,
SUM(IF(result.lms_is_answer_correct = 1, 1,0)) AS correct,
SUM(IF(result.lms_is_answer_correct = 0, 1,0)) AS incorrect,
SUM(result.lms_marks_scored) AS lms_marks_scored,
SUM(result.lms_question_marks) AS lms_question_marks,
(SELECT lms_exam_schedule_max_marks  from
lms_exam_schedule where lms_exam_schedule.lms_exam_schedule_id=$examScheduleId ) as

lms_exam_schedule_max_marks
FROM lms_exam_result result
join lms_topic topic
on result.lms_topic_id= topic.lms_topic_id

where lms_student_id=$studentId and result.lms_exam_schedule_id=$examScheduleId group by lms_topic_id");
        return $getQuery;
    }

    // get exam answer
    public function getExamAnswer($examScheduleId, $studentId)
    {

        $getQuery = DB::table('lms_exam_result')
            ->join('lms_question_bank', 'lms_question_bank.lms_question_bank_id', '=', 'lms_exam_result.lms_question_bank_id')
            ->join('lms_question_difficulty_level', 'lms_question_difficulty_level.lms_question_difficulty_level_id', '=', 'lms_question_bank.lms_question_difficulty_level_id')
            ->join('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_question_bank.lms_topic_id')
            ->leftJoin('lms_saved_note', 'lms_question_bank.lms_question_bank_id', '=', 'lms_saved_note.lms_question_bank_id')
            ->where('lms_exam_result.lms_exam_schedule_id', '=', $examScheduleId)

            ->where('lms_exam_result.lms_student_id', '=', $studentId)

            ->select([

                'lms_question_bank.lms_question_bank_id',
                'lms_question_bank.lms_subject_id',
                'lms_question_bank.lms_topic_id',
                'lms_question_bank.lms_question_difficulty_level_id',
                'lms_question_bank.lms_question_bank_type_single_multiple',
                'lms_question_bank.lms_question_bank_has_image',
                'lms_question_bank.lms_question_bank_image_path',
                'lms_question_bank.lms_question_bank_text',
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

                'lms_exam_result.lms_user_answers',
                'lms_topic.lms_topic_name',

                'lms_question_difficulty_level.lms_question_difficulty_level_name',

                'lms_saved_note.lms_saved_note_id',
                DB::raw(" (SELECT  lms_exam_schedule.lms_exam_schedule_solution_display_type   from
                lms_exam_schedule where lms_exam_schedule.lms_exam_schedule_id=$examScheduleId

                ) as
                lms_exam_schedule_solution_display_type"),

            ])
            ->orderBy('lms_exam_result.lms_exam_result_id')

            ->paginate(20);

        return $getQuery;

    }

    //save post
    public function savePost($userId, $roleId, $postContent, $postHasImage,
        $postImage, $postHasUrl) {
        $saveQuery = DB::table('lms_post')->insertGetId(
            [
                'lms_user_id' => $userId,
                'lms_center_id' => $this->centerId,
                'role_id' => $roleId,
                'lms_post_content' => $postContent,
                'lms_post_has_image' => $postHasImage,
                'lms_post_image' => $postImage,
                'lms_post_has_url' => $postHasUrl,
            ]
        );
        if ($saveQuery > 0) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return $resultData;
    }

    // To get post
    public function getPost($userId, $postFlag, $roleId)
    {
        $getQuery = "";
        $getQuery1 = "";
        if ($postFlag == "0") {
            $getQuery = DB::table('lms_post')
                ->join('lms_student', 'lms_student.lms_user_id', '=', 'lms_post.lms_user_id')
                ->where('lms_post.lms_post_is_active', '=', 1)
                ->where('lms_post.lms_center_id', '=', $this->centerId)
                ->where('lms_post.lms_is_post_approved', '=', 1)
                ->select([
                    'lms_post.lms_post_id',
                    'lms_post.lms_user_id',
                    'lms_post.lms_post_content',
                    'lms_post.lms_post_has_image',
                    'lms_post.lms_post_image',
                    'lms_post.lms_post_has_url',
                    'lms_post.lms_post_url',
                    'lms_student.lms_student_first_name as first_name',
                    'lms_student.lms_student_last_name  as last_name',
                    'lms_student.lms_student_full_name as full_name',
                    'lms_student.lms_student_profile_image as profile_image',
                    'lms_post.lms_is_post_approved',
                    DB::raw('DATE_FORMAT(lms_post.lms_post_created_at, "%d-%m-%Y") as lms_post_created_at', "%d-%m-%Y"),
                    DB::raw("(SELECT count(*) FROM lms_post_like
                    where lms_post.lms_post_id=lms_post_like.lms_post_id
         ) as total_like"),
                    DB::raw("(SELECT group_concat(lms_post_like.lms_user_id)
                FROM lms_post_like
                where  lms_post.lms_post_id=lms_post_like.lms_post_id and
         lms_post_like.lms_user_id=$userId
        ) as all_liked_users"),
                    DB::raw("(SELECT count(*) FROM lms_post_comment
                     where lms_post.lms_post_id=lms_post_comment.lms_post_id
       ) as total_comment"),
                    DB::raw("(SELECT group_concat(lms_post_comment.lms_user_id)
                 FROM lms_post_comment
                  where  lms_post.lms_post_id=lms_post_comment.lms_post_id
        and lms_post_comment.lms_user_id=$userId
      ) as all_comment_users"),
                ]);

            $getQuery1 = DB::table('lms_post')
                ->join('lms_staff', 'lms_staff.lms_user_id', '=', 'lms_post.lms_user_id')
                ->where('lms_post.lms_post_is_active', '=', 1)
                ->where('lms_post.lms_center_id', '=', $this->centerId)
                ->where('lms_post.lms_is_post_approved', '=', 1)
                ->select([
                    'lms_post.lms_post_id',
                    'lms_post.lms_user_id',
                    'lms_post.lms_post_content',
                    'lms_post.lms_post_has_image',
                    'lms_post.lms_post_image',
                    'lms_post.lms_post_has_url',
                    'lms_post.lms_post_url',
                    'lms_staff.lms_staff_first_name as first_name',
                    'lms_staff.lms_staff_last_name  as last_name',
                    'lms_staff.lms_staff_full_name as full_name',
                    'lms_staff.lms_staff_profile_image as profile_image',
                    'lms_post.lms_is_post_approved',
                    DB::raw('DATE_FORMAT(lms_post.lms_post_created_at, "%d-%m-%Y") as lms_post_created_at', "%d-%m-%Y"),
                    DB::raw("(SELECT count(*) FROM lms_post_like
                    where lms_post.lms_post_id=lms_post_like.lms_post_id
         ) as total_like"),
                    DB::raw("(SELECT group_concat(lms_post_like.lms_user_id)
                FROM lms_post_like
                where  lms_post.lms_post_id=lms_post_like.lms_post_id and
         lms_post_like.lms_user_id=$userId
        ) as all_liked_users"),
                    DB::raw("(SELECT count(*) FROM lms_post_comment
                     where lms_post.lms_post_id=lms_post_comment.lms_post_id
       ) as total_comment"),
                    DB::raw("(SELECT group_concat(lms_post_comment.lms_user_id)
                 FROM lms_post_comment
                  where  lms_post.lms_post_id=lms_post_comment.lms_post_id
        and lms_post_comment.lms_user_id=$userId
      ) as all_comment_users"),
                ])->unionAll($getQuery);
            $querySql = $getQuery1->toSql();
            $getQuery1 = DB::table(DB::raw("($querySql order by lms_post_created_at asc) as a"))->mergeBindings($getQuery1)

                ->paginate();

        } else if ($postFlag == "1") {
            $getQuery = DB::table('lms_post')
                ->join('lms_student', 'lms_student.lms_user_id', '=', 'lms_post.lms_user_id')
                ->where('lms_post.lms_post_is_active', '=', 1)
                ->where('lms_post.lms_center_id', '=', $this->centerId)
                ->where('lms_post.lms_is_post_approved', '=', 1)
                ->where('lms_post.lms_user_id', '=', $userId)
                ->select([
                    'lms_post.lms_post_id',
                    'lms_post.lms_user_id',
                    'lms_post.lms_post_content',
                    'lms_post.lms_post_has_image',
                    'lms_post.lms_post_image',
                    'lms_post.lms_post_has_url',
                    'lms_post.lms_post_url',
                    'lms_student.lms_student_first_name as first_name',
                    'lms_student.lms_student_last_name  as last_name',
                    'lms_student.lms_student_full_name as full_name',
                    'lms_student.lms_student_profile_image as profile_image',
                    'lms_post.lms_is_post_approved',
                    DB::raw('DATE_FORMAT(lms_post.lms_post_created_at, "%d-%m-%Y") as lms_post_created_at', "%d-%m-%Y"),
                    DB::raw("(SELECT count(*) FROM lms_post_like
                    where lms_post.lms_post_id=lms_post_like.lms_post_id
         ) as total_like"),
                    DB::raw("(SELECT group_concat(lms_post_like.lms_user_id)
                FROM lms_post_like
                where  lms_post.lms_post_id=lms_post_like.lms_post_id and
         lms_post_like.lms_user_id=$userId
        ) as all_liked_users"),
                    DB::raw("(SELECT count(*) FROM lms_post_comment
                     where lms_post.lms_post_id=lms_post_comment.lms_post_id
       ) as total_comment"),
                    DB::raw("(SELECT group_concat(lms_post_comment.lms_user_id)
                 FROM lms_post_comment
                  where  lms_post.lms_post_id=lms_post_comment.lms_post_id
        and lms_post_comment.lms_user_id=$userId
      ) as all_comment_users"),
                ]);

            $getQuery1 = DB::table('lms_post')
                ->join('lms_staff', 'lms_staff.lms_user_id', '=', 'lms_post.lms_user_id')
                ->where('lms_post.lms_post_is_active', '=', 1)
                ->where('lms_post.lms_center_id', '=', $this->centerId)
                ->where('lms_post.lms_is_post_approved', '=', 1)
                ->where('lms_post.lms_user_id', '=', $userId)
                ->select([
                    'lms_post.lms_post_id',
                    'lms_post.lms_user_id',
                    'lms_post.lms_post_content',
                    'lms_post.lms_post_has_image',
                    'lms_post.lms_post_image',
                    'lms_post.lms_post_has_url',
                    'lms_post.lms_post_url',
                    'lms_staff.lms_staff_first_name as first_name',
                    'lms_staff.lms_staff_last_name  as last_name',
                    'lms_staff.lms_staff_full_name as full_name',
                    'lms_staff.lms_staff_profile_image as profile_image',
                    'lms_post.lms_is_post_approved',
                    DB::raw('DATE_FORMAT(lms_post.lms_post_created_at, "%d-%m-%Y") as lms_post_created_at', "%d-%m-%Y"),
                    DB::raw("(SELECT count(*) FROM lms_post_like
                    where lms_post.lms_post_id=lms_post_like.lms_post_id
         ) as total_like"),
                    DB::raw("(SELECT group_concat(lms_post_like.lms_user_id)
                FROM lms_post_like
                where  lms_post.lms_post_id=lms_post_like.lms_post_id and
         lms_post_like.lms_user_id=$userId
        ) as all_liked_users"),
                    DB::raw("(SELECT count(*) FROM lms_post_comment
                     where lms_post.lms_post_id=lms_post_comment.lms_post_id
       ) as total_comment"),
                    DB::raw("(SELECT group_concat(lms_post_comment.lms_user_id)
                 FROM lms_post_comment
                  where  lms_post.lms_post_id=lms_post_comment.lms_post_id
        and lms_post_comment.lms_user_id=$userId
      ) as all_comment_users"),
                ])->unionAll($getQuery);
            $querySql = $getQuery1->toSql();
            $getQuery1 = DB::table(DB::raw("($querySql order by lms_post_created_at asc) as a"))->mergeBindings($getQuery1)

                ->paginate();

        }

        return $getQuery1;
    }

    //To insert  post like
    public function savePostLike($userId, $postId, $roleId)
    {

        try {
            DB::beginTransaction();
            $getQuery = DB::table('lms_post_like')
                ->where('lms_post_id', $postId)
                ->where('lms_user_id', $userId)
                ->get();
            if ($getQuery->count() > 0) {
                $deleteQuery = DB::table('lms_post_like')
                    ->where('lms_post_id', $postId)
                    ->where('lms_user_id', $userId)
                    ->delete();

                $resultData['result'] = "delete";
            } else {
                $saveQuery = DB::table('lms_post_like')->insertGetId(
                    [
                        'lms_post_id' => $postId,
                        'lms_user_id' => $userId,
                        'role_id' => $roleId,
                        'lms_center_id' => $this->centerId,
                    ]
                );
                if ($saveQuery > 0) {
                    $resultData['result'] = "success";
                } else {
                    $resultData['result'] = "fail";
                }
            }

            DB::commit();
            return $resultData;

        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
            return $resultData;
        }

    }

    //To delete post
    public function deletePost($postId, $postImageName)
    {

        try {
            DB::beginTransaction();
            $deleteQuery = DB::table('lms_post')
                ->where('lms_post_id', $postId)
                ->delete();

            DB::commit();
            if ($postImageName != null) {
                if (file_exists(storage_path('app/public/post_images/' . $postImageName))) {
                    unlink(storage_path('app/public/post_images/' . $postImageName));
                }
            }
            $resultData['result'] = "delete";
            return $resultData;
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
            return $resultData;
        }

    }

    // To get the all post
    public function getPostComment($postId, $roleId)
    {

        if ($roleId == "1") {
            $getQuery = DB::table('lms_post_comment')
                ->join('lms_student', 'lms_student.lms_user_id', '=', 'lms_post_comment.lms_user_id')
                ->where('lms_post_comment.lms_post_id', '=', $postId)
                ->where('lms_post_comment.lms_post_comment_is_active', '=', 1)
                ->select([
                    'lms_post_comment.lms_post_comment_id',
                    'lms_post_comment.lms_post_comment',
                    'lms_student.lms_student_first_name as first_name',
                    'lms_student.lms_student_last_name  as last_name',
                    'lms_student.lms_student_full_name as full_name',
                    'lms_student.lms_student_profile_image as profile_image',
                    DB::raw('DATE_FORMAT(lms_post_comment.lms_post_comment_date, "%d-%m-%Y") as lms_post_comment_date', "%d-%m-%Y"),
                    DB::raw("(SELECT count(*) FROM lms_post_comment  where lms_post_comment.lms_post_id=$postId
          ) as total_post_count"),
                ])

                ->orderBy(DB::raw("DATE_FORMAT(lms_post_comment.lms_post_comment_date,'%d-%m-%Y')"), 'desc')
                ->paginate();
            return $getQuery;
        } else {
            $getQuery = DB::table('lms_post_comment')
                ->join('lms_staff', 'lms_staff.lms_user_id', '=', 'lms_post_comment.lms_user_id')
                ->where('lms_post_comment.lms_post_id', '=', $postId)
                ->where('lms_post_comment.lms_post_comment_is_active', '=', 1)
                ->select([
                    'lms_post_comment.lms_post_comment_id',
                    'lms_post_comment.lms_post_comment',
                    'lms_staff.lms_staff_first_name as first_name',
                    'lms_staff.lms_staff_last_name  as last_name',
                    'lms_staff.lms_staff_full_name as full_name',
                    'lms_staff.lms_staff_profile_image as profile_image',
                    DB::raw('DATE_FORMAT(lms_post_comment.lms_post_comment_date, "%d-%m-%Y") as lms_post_comment_date', "%d-%m-%Y"),
                    DB::raw("(SELECT count(*) FROM lms_post_comment  where lms_post_comment.lms_post_id=$postId
          ) as total_post_count"),
                ])

                ->orderBy(DB::raw("DATE_FORMAT(lms_post_comment.lms_post_comment_date,'%d-%m-%Y')"), 'desc')
                ->paginate();
            return $getQuery;
        }

    }

    //To save  comment
    public function savePostComment($userId, $postId, $roleId, $postComment)
    {

        try {
            DB::beginTransaction();

            $saveQuery = DB::table('lms_post_comment')->insertGetId(
                ['lms_post_id' => $postId,
                    'lms_user_id' => $userId,
                    'role_id' => $roleId,
                    'lms_post_comment' => $postComment,
                    'lms_center_id' => $this->centerId,
                ]
            );
            if ($saveQuery > 0) {
                $resultData['result'] = "success";
            } else {
                $resultData['result'] = "fail";
            }
            DB::commit();
            return $resultData;
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
            return $resultData;
        }
    }

    // Save Enquiry
    public static function saveEnquiry($centerId, $courseId, $firstName, $lastName, $mobileNumber, $email, $address, $childCourseId)
    {
        try {

            DB::beginTransaction();
            $getQuery = DB::table('lms_enquiry')
                ->where('lms_course_id', $courseId)
                ->where('lms_enquiry_mobile', $mobileNumber)
                ->get();
            if ($getQuery->count() > 0) {
                $resultData['result'] = "exists";

            } else {
                $getCenterCodeQuery = DB::table('lms_center_details')
                    ->select(['lms_center_code'])
                    ->where('lms_center_id', $centerId)
                    ->get();

                $getEnquiryCodePrefixQuery = DB::table('lms_prefix_setting')
                    ->select(['lms_prefix'])
                    ->where('lms_center_id', $centerId)
                    ->where('lms_prefix_module_name', "Enquiry Code")
                    ->get();
                $enquiryCodePrefix = $getEnquiryCodePrefixQuery[0]->lms_prefix . $getCenterCodeQuery[0]->lms_center_code . date('y');
                $enquiryCode = IdGenerator::generate([
                    'table' => 'lms_enquiry', 'length' => 14, 'prefix' => $enquiryCodePrefix,
                    'reset_on_prefix_change' => true, 'field' => 'lms_enquiry_code',
                ]);
                //Check Email or SMS will be sent
                $checkEmailSMSSentQuery = DB::table('lms_notification_setting')
                    ->select(['lms_notification_setting_is_mail', 'lms_notification_setting_is_sms', 'lms_notification_setting_is_notification', 'lms_notification_setting_template'])
                    ->where('lms_center_id', $centerId)
                    ->where('lms_notification_setting_id', 2)
                    ->get();

                $enquiryCreateQuery = DB::table('lms_enquiry')->insertGetId(
                    [

                        'lms_enquiry_first_name' => ucfirst($firstName),
                        'lms_enquiry_last_name' => ucfirst($lastName),
                        'lms_enquiry_full_name' => ucfirst($firstName) . ' ' . ucfirst($lastName),
                        'lms_enquiry_email' => $email,
                        'lms_enquiry_mobile' => $mobileNumber,
                        'lms_center_id' => $centerId,
                        'lms_course_id' => $courseId,
                        'lms_enquiry_code' => $enquiryCode,
                        'lms_enquiry_local_address' => $address,
                        'lms_child_course_id' => $childCourseId,
                    ]
                );
                $resultData['result'] = $enquiryCode;

            }

            DB::commit();

            // if ($checkEmailSMSSentQuery[0]->lms_notification_setting_is_mail == "1") {
            //     //send Mail
            //    EnquiryModel::sendMail($centerId, $enquiryCode, $enquiryContactNumber, $enquiryEmail);

            // }
            // if ($checkEmailSMSSentQuery[0]->lms_notification_setting_is_sms == "1") {
            //     //send SMS
            //     EnquiryModel::sendSMS($centerId, $enquiryPassword, $enquiryContactNumber, $checkEmailSMSSentQuery[0]->lms_notification_setting_template, $enquiryFirstName);
            // }

            // if ($checkEmailSMSSentQuery[0]->lms_notification_setting_is_sms == "1" && $checkEmailSMSSentQuery[0]->lms_notification_setting_is_mail == "1") {
            //     //send SMS & Email Both
            //     EnquiryModel::sendMail($centerId, $enquiryCode, $enquiryContactNumber, $enquiryEmail);
            //     EnquiryModel::sendSMS($centerId,  $enquiryContactNumber, $checkEmailSMSSentQuery[0]->lms_notification_setting_template, $enquiryFirstName);
            // }
            // If saved success

            return $resultData;
        } catch (Exception $ex) {

            DB::rollback();

            $resultData['result'] = "exception";
            return $resultData;
        }

    }

    // To get CourseList
    public function getOnlineCourseList()
    {

        $getQuery = DB::table('lms_course')
            ->where('lms_center_id', '=', $this->centerId)
            ->where('lms_course_is_online', '=', 1)
            ->where('lms_course_is_active', '=', 1)

            ->select(['lms_course_id',
                'lms_course_name',
                'lms_course_image',
                'lms_course_description',
                'lms_course_fees',
                'lms_course_code',
            ])
            ->paginate(20);
        return $getQuery;

    }

    // Save Enquiry
    public static function registerUser($centerId, $courseId, $firstName, $lastName, $mobileNumber, $password, $childCourseId)
    {
        try {

            DB::beginTransaction();

            $userId = DB::table('lms_user')->insertGetId(
                [
                    'role_id' => 1,
                    'password' => bcrypt($password),
                    'password_normal' => $password,
                    'lms_user_mobile' => $mobileNumber,
                    'lms_center_id' => $centerId,
                ]
            );
            $getCenterCodeQuery = DB::table('lms_center_details')
                ->select(['lms_center_code'])
                ->where('lms_center_id', $centerId)
                ->get();

            $getStudentCodePrefixQuery = DB::table('lms_prefix_setting')
                ->select(['lms_prefix'])
                ->where('lms_center_id', $centerId)
                ->where('lms_prefix_module_name', "Student Code")
                ->get();
            $studentCodePrefix = $getStudentCodePrefixQuery[0]->lms_prefix . $getCenterCodeQuery[0]->lms_center_code . date('y');
            $studentCode = IdGenerator::generate([
                'table' => 'lms_student', 'length' => 14, 'prefix' => $studentCodePrefix,
                'reset_on_prefix_change' => true, 'field' => 'lms_student_code',
            ]);
            $enquiryId = DB::table('lms_enquiry')->insertGetId(
                [

                    'lms_enquiry_first_name' => ucfirst($firstName),
                    'lms_enquiry_last_name' => ucfirst($lastName),
                    'lms_enquiry_full_name' => ucfirst($firstName) . ' ' . ucfirst($lastName),
                    'lms_enquiry_mobile' => $mobileNumber,
                    'lms_center_id' => $centerId,
                    'lms_course_id' => $courseId,
                    'lms_enquiry_code' => $enquiryCode,
                    'lms_enquiry_status' => 3,
                    'lms_child_course_id' => $childCourseId,
                ]
            );

            $studentId = DB::table('lms_student')->insertGetId(
                [
                    'lms_center_id' => $centerId,
                    'lms_user_id' => $userId,
                    'role_id' => 1,
                    'lms_student_code' => $studentCode,
                    'lms_student_first_name' => ucfirst($firstName),
                    'lms_student_last_name' => ucfirst($lastName),
                    'lms_student_full_name' => ucfirst($firstName) . ' ' . ucfirst($lastName),
                    'lms_student_mobile_number' => $mobileNumber,
                    'lms_enquiry_id' => $enquiryId,

                ]
            );

            $getEnquiryCodePrefixQuery = DB::table('lms_prefix_setting')
                ->select(['lms_prefix'])
                ->where('lms_center_id', $centerId)
                ->where('lms_prefix_module_name', "Enquiry Code")
                ->get();
            $enquiryCodePrefix = $getEnquiryCodePrefixQuery[0]->lms_prefix . $getCenterCodeQuery[0]->lms_center_code . date('y');
            $enquiryCode = IdGenerator::generate([
                'table' => 'lms_enquiry', 'length' => 14, 'prefix' => $enquiryCodePrefix,
                'reset_on_prefix_change' => true, 'field' => 'lms_enquiry_code',
            ]);

            $getRegistrationCodePrefixQuery = DB::table('lms_prefix_setting')
                ->select(['lms_prefix'])
                ->where('lms_center_id', $centerId)
                ->where('lms_prefix_module_name', "Registration Code")
                ->get();
            $registrationCodePrefix = $getRegistrationCodePrefixQuery[0]->lms_prefix . $getCenterCodeQuery[0]->lms_center_code . date('y');
            $registrationCode = IdGenerator::generate([
                'table' => 'lms_student_course_mapping', 'length' => 14, 'prefix' => $registrationCodePrefix,
                'reset_on_prefix_change' => true, 'field' => 'lms_registration_code',
            ]);

            DB::table('lms_student_course_mapping')->insertGetId(
                [

                    'lms_center_id' => $centerId,
                    'lms_course_id' => $courseId,
                    'lms_user_id' => $userId,
                    'lms_student_id' => $studentId,
                    'lms_registration_code' => $registrationCode,
                    'lms_child_course_id' => $childCourseId,
                    'lms_student_registration_type' => 3,

                ]
            );

            DB::commit();
            $resultData['result'] = "success";
            return $resultData;
        } catch (Exception $ex) {

            DB::rollback();

            $resultData['result'] = "exception";
            return $resultData;
        }

    }
    public function sendPassword($mobileNumber)
    {
        try {
            $getQuery = DB::table('lms_user')->where('lms_user_mobile', $mobileNumber)->get();
            if ($getQuery->count() == 0) {
                $resultData['result'] = "MobileInvalid";
                return $resultData;
            } else {
                $resultData['result'] = "success";
                $this->sendSMSPassword($mobileNumber, $getQuery[0]->password_normal);
                return $resultData;

            }
        } catch (Exception $ex) {
            $resultData['result'] = "Exception";
            return $resultData;
        }

    }
    public function sendSMSPassword($mobile, $password)
    {
        try
        {

            $smstext = rawurlencode("Your Password is: " . $password . " Regards, PMAITI");
            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=256dda14-3d85-4e46-83aa-1d12103bc1e2&senderid=PRIMAI&channel=2&DCS=0&flashsms=0&number=$mobile&text=$smstext&route=31&EntityId=1301162038261824606&dlttemplateid=1307162100179461666");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
            $result = curl_exec($ch);
            if (curl_error($ch)) {
                $result = curl_errno($ch);
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);
    }

    // To get notice
    public function getNoticeList($roleId, $userId,$batchId)
    {
        $getQuery = DB::table("lms_notice")

            ->leftJoin("lms_notice_read_notification", function ($join) use ($userId, $roleId,$batchId) {
                $join->on("lms_notice.lms_notice_id", "=", "lms_notice_read_notification.lms_notice_id")
                    ->where("lms_notice_read_notification.lms_user_id", "=", $userId);

            })
            ->whereRaw('FIND_IN_SET("' . $roleId . '",lms_notice.role_id)')
            ->where('lms_notice.lms_batch_id','=',$batchId)
            ->where('lms_notice.lms_notice_is_active', '=', 1)
            ->select("lms_notice.lms_notice_id", "lms_notice.lms_notice_title",
                "lms_notice.lms_notice_description", "lms_notice.lms_notice_type",
                "lms_notice.lms_notice_image", "lms_notice.lms_notice_has_image",
                "lms_notice.lms_staff_first_name", "lms_notice.lms_staff_last_name",
                "lms_notice.lms_staff_full_name", "lms_notice.lms_staff_profile_image",
                "lms_notice.role_name",
                DB::raw('IF (lms_notice_read_notification.lms_notice_read_notification_id IS NULL,"unread","read") as notification_status'),
                DB::raw('DATE_FORMAT(lms_notice.lms_notice_created_at, "%d-%m-%Y") as lms_notice_created_at', "%d-%m-%Y"),
                DB::raw("(select  (select count(`lms_notice`.`lms_notice_id`) from lms_notice where FIND_IN_SET($roleId,lms_notice.role_id)) -
(select count(lms_notice_read_notification.lms_user_id) from lms_notice_read_notification where `lms_notice_read_notification`.`lms_user_id` = $userId)

           ) as total_unread_count")

            )

            ->orderBy('lms_notice.lms_notice_created_at', 'desc')
            ->orderBy('notification_status', 'desc')

            ->paginate();
        return $getQuery;

    }

    //To save read notice
    public function saveReadNotice($lmsNoticeId, $userId)
    {

        try {
            DB::beginTransaction();

            DB::table('lms_notice_read_notification')
                ->updateOrInsert(
                    ['lms_notice_id' => $lmsNoticeId, 'lms_user_id' => $userId],
                    ['lms_notice_id' => $lmsNoticeId, 'lms_user_id' => $userId]
                );

            DB::commit();

            $resultData['result'] = "success";
            return $resultData;
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
            return $resultData;
        }

    }

    // get batch list
    public function getBatchList($facultyId)
    {

        $getQuery = DB::table('lms_batch_details')
            ->join('lms_batch_slot', 'lms_batch_details.lms_batch_id', '=', 'lms_batch_slot.lms_batch_id')
            ->join('lms_course', 'lms_batch_details.lms_course_id', '=', 'lms_course.lms_course_id')
            ->where('lms_batch_slot.lms_user_id', '=', $facultyId)

            ->where('lms_batch_details.lms_batch_is_active', '=', 1)

            ->select([

                'lms_batch_details.lms_batch_id',
                'lms_batch_details.lms_batch_code',
                'lms_batch_details.lms_batch_name',
                'lms_batch_details.lms_child_course_id',
                DB::raw('DATE_FORMAT(lms_batch_details.lms_batch_start_date, "%d-%m-%Y") as lms_batch_start_date', "%d-%m-%Y"),
                DB::raw('DATE_FORMAT(lms_batch_details.lms_batch_end_date, "%d-%m-%Y") as lms_batch_end_date', "%d-%m-%Y"),
                'lms_course.lms_course_code',
                'lms_course.lms_course_name',
                'lms_batch_details.lms_course_id',

                DB::raw(" (select CASE
                 WHEN now() between lms_batch_details.lms_batch_start_date and lms_batch_details.lms_batch_end_date  THEN 1
                 WHEN now() > lms_batch_details.lms_batch_end_date THEN 2
                 ELSE 3
                 END

                 ) as batch_live_upcoming_completed"), // 1 live 2 completed 3 upcoming

            ])
            ->distinct()
            ->orderBy('lms_batch_details.lms_batch_created_date')

            ->paginate();

        return $getQuery;

    }

    // get batch schedule
    public function getBatchSchedule($batchId)
    {
        $getQuery = DB::table('lms_batch_slot')
            ->join('lms_subject', 'lms_batch_slot.lms_subject_id', '=', 'lms_subject.lms_subject_id')
            ->join('lms_staff', 'lms_batch_slot.lms_user_id', '=', 'lms_staff.lms_user_id')

            ->where('lms_batch_slot.lms_batch_id', '=', $batchId)

            ->where('lms_batch_slot.lms_batch_slot_is_active', '=', 1)

            ->select([

                'lms_batch_slot.lms_batch_slot_id',
                'lms_batch_slot.lms_batch_slot_start_time',
                'lms_batch_slot.lms_batch_slot_end_time',
                'lms_batch_slot.lms_batch_slot_day_text',
                'lms_subject.lms_subject_name',
                'lms_subject.lms_subject_code',
                'lms_staff.lms_staff_first_name',
                'lms_staff.lms_staff_last_name',
                'lms_staff.lms_staff_full_name',
                'lms_staff.lms_staff_profile_image',

            ])

            ->orderBy('lms_batch_slot.lms_batch_slot_day')

            ->paginate();

        return $getQuery;
    }

    public function saveHomework($userId,
        $batchId,
        $subjectId,
        $topicId,
        $title,
        $description,
        $marks,
        $assignmentLastSubmissionDate) {

        try {
            DB::beginTransaction();

            DB::table('lms_assignment')->insertGetId(
                [

                    'lms_center_id' => $this->centerId,
                    'lms_user_id' => $userId,
                    'lms_batch_id' => $batchId,
                    'lms_subject_id' => $subjectId,
                    'lms_topic_id' => $topicId,
                    'lms_assignment_title' => $title,
                    'lms_assignment_description' => $description,
                    'lms_assignment_score' => $marks,
                    'lms_assignment_submission_last_date' => $assignmentLastSubmissionDate,
                    'lms_assignment_created_by' => $userId,

                ]
            );

            DB::commit();

            $resultData['result'] = "success";
            return $resultData;
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
            return $resultData;
        }

    }

    // Get subject
    public function getSubject($courseId)
    {
        $getQuery = DB::table('lms_subject')
            ->where('lms_subject_is_active', '=', 1)
            ->where('lms_center_id', '=', $this->centerId)
            ->where('lms_course_id', '=', $courseId)

            ->select()
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // Get Topic
    public function getTopic($subjectId)
    {
        $getQuery = DB::table('lms_topic')
            ->where('lms_topic_is_active', '=', 1)
            ->where('lms_center_id', '=', $this->centerId)
            ->where('lms_subject_id', '=', $subjectId)

            ->select()
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // get assigment list for teacher(used)
    public function getAssignmentListForTeacher($batchId, $userId)
    {
        $getQuery = DB::table('lms_assignment')
            ->leftJoin('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_assignment.lms_subject_id')
            ->leftJoin('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_assignment.lms_topic_id')

            ->where('lms_assignment.lms_batch_id', '=', $batchId)

            ->where('lms_assignment.lms_assignment_created_by', '=', $userId)
            ->where('lms_assignment.lms_assignment_status', '=', 1)

            ->select([

                'lms_assignment.lms_assignment_id',
                'lms_assignment.lms_assignment_title',
                'lms_assignment.lms_assignment_description',
                'lms_assignment.lms_assignment_upload_status',
                'lms_assignment.lms_assignment_score',
                DB::raw('DATE_FORMAT(lms_assignment.lms_assignment_submission_last_date, "%d-%m-%Y") as lms_assignment_submission_last_date', "%d-%m-%Y"),

                'lms_subject.lms_subject_id',
                'lms_subject.lms_subject_name',
                'lms_topic.lms_topic_id',
                'lms_topic.lms_topic_name',

                DB::raw("(SELECT count(distinct lms_submitted_assignment_document.lms_user_id)
                FROM lms_submitted_assignment_document where
                lms_submitted_assignment_document.lms_assignment_id=lms_assignment.lms_assignment_id
                and lms_submitted_assignment_document.lms_submitted_assignment_upload_status=1

           ) as total_assignment_submitted"),
                DB::raw("(SELECT count(distinct lms_assignment_document.lms_assignment_document_id)
                FROM lms_assignment_document where
                lms_assignment_document.lms_assignment_id=lms_assignment.lms_assignment_id


           ) as total_assignment_doc_uploaded"),
                DB::raw(" (select CASE
                WHEN date(now()) <= lms_assignment.lms_assignment_submission_last_date  THEN 1
                WHEN now() > lms_assignment.lms_assignment_submission_last_date THEN 2

           END

           ) as assignment_can_upload"), // 1 can uplload 2 dont upload

            ])

            ->orderBy('lms_assignment.lms_assignment_submission_last_date', 'desc')

            ->paginate();

        return $getQuery;
    }
// used
    public function getUploadedAssignmentDocByTeacher($assignmentId)
    {

        // For student
        $getQuery = DB::table('lms_assignment_document')

            ->where('lms_assignment_id', '=', $assignmentId)
            ->where('lms_assignment_document_status', '=', 1)

            ->select([
                'lms_assignment_document_id',
                'lms_assignment_document_path',

            ])
            ->get();

        $getResult = $getQuery->toArray();
        return $getResult;
    }

    public function getSubmittedStudentListForAssignmentForTeacher($assignmentId)
    {
        $getQuery = DB::table('lms_submitted_assignment_document')
            ->leftJoin('lms_student', 'lms_student.lms_user_id', '=', 'lms_submitted_assignment_document.lms_user_id')
            ->where('lms_submitted_assignment_document.lms_submitted_assignment_document_status', '=', 1)
            ->where('lms_submitted_assignment_document.lms_submitted_assignment_upload_status', '=', 1)
            ->where('lms_submitted_assignment_document.lms_assignment_id', '=', $assignmentId)

            ->select([

                'lms_submitted_assignment_document.lms_registration_id',
                DB::raw('DATE_FORMAT(lms_submitted_assignment_document.lms_submitted_assignment_document_date, "%d-%m-%Y") as lms_submitted_assignment_document_date', "%d-%m-%Y"),
                'lms_student.lms_user_id',
                'lms_student.lms_student_id',
                'lms_student.lms_student_first_name',
                'lms_student.lms_student_last_name',
                'lms_student.lms_student_full_name',
                'lms_student.lms_student_profile_image',
                'lms_student.lms_student_mobile_number',
                'lms_submitted_assignment_document.lms_submitted_assignment_evaluation_status',
                'lms_submitted_assignment_document.lms_assignment_evaluation_marks',

            ])

            ->orderBy('lms_submitted_assignment_document.lms_submitted_assignment_document_date')
            ->distinct()
            ->paginate();

        return $getQuery;
    }

    //used
    public function finishUploadAssignment($assignmentId)
    {

        try {
            DB::beginTransaction();

            DB::table('lms_assignment')
                ->where('lms_assignment_id', $assignmentId)
                ->update(['lms_assignment_upload_status' => 1]);

            DB::commit();

            $resultData['result'] = "success";
            return $resultData;
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
            return $resultData;
        }

    }

    public function evaluateAssignment($assignmentId, $userId, $studentId, $registrationId, $evaluatedBy,
        $evaluationMarks) {

        try {
            DB::beginTransaction();

            DB::table('lms_submitted_assignment_document')
                ->where('lms_assignment_id', $assignmentId)
                ->where('lms_user_id', $userId)
                ->where('lms_student_id', $studentId)
                ->where('lms_registration_id', $registrationId)
                ->update(['lms_submitted_assignment_evaluation_status' => 1,
                    'lms_submitted_assignment_evaluation_date' => now(),
                    'lms_submitted_assignment_evaluated_by' => $evaluatedBy,
                    'lms_assignment_evaluation_marks' => $evaluationMarks]);

            DB::commit();

            $resultData['result'] = "success";
            return $resultData;
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
            return $resultData;
        }

    }

    public function getUploadedAssignmentDocByStudentForTeacher($assignmentId, $userId, $studentId, $registrationId)
    {
        $getQuery = DB::table('lms_submitted_assignment_document')

            ->where('lms_submitted_assignment_document_status', '=', 1)
            ->where('lms_assignment_id', '=', $assignmentId)

            ->where('lms_user_id', $userId)
            ->where('lms_student_id', $studentId)
            ->where('lms_registration_id', $registrationId)

            ->select([

                'lms_submitted_assignment_document.lms_submitted_assignment_document_path',
                'lms_submitted_assignment_document_id',
                'lms_submitted_assignment_evaluation_status',
                'lms_submitted_assignment_upload_status',
                'lms_assignment_evaluation_marks',

            ])

            ->orderBy('lms_submitted_assignment_document_date')

            ->get();

        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // get assigment list for student
    public function getAssignmentListForStudent($batchId)
    {
        $getQuery = DB::table('lms_assignment')
            ->leftJoin('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_assignment.lms_subject_id')
            ->leftJoin('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_assignment.lms_topic_id')
            ->leftJoin('lms_staff', 'lms_staff.lms_user_id', '=', 'lms_assignment.lms_user_id')
            ->where('lms_assignment.lms_batch_id', '=', $batchId)
            ->where('lms_assignment.lms_assignment_status', '=', 1)
            ->where('lms_assignment.lms_assignment_upload_status', '=', 1)
            ->select([
                'lms_assignment.lms_assignment_id',
                'lms_assignment.lms_assignment_title',
                'lms_assignment.lms_assignment_description',
                DB::raw('DATE_FORMAT(lms_assignment.lms_assignment_submission_last_date, "%d-%m-%Y") as lms_assignment_submission_last_date', "%d-%m-%Y"),
                'lms_subject.lms_subject_id',
                'lms_subject.lms_subject_name',
                'lms_topic.lms_topic_id',
                'lms_topic.lms_topic_name',
                DB::raw(" (select CASE
                 WHEN date(now()) <= lms_assignment.lms_assignment_submission_last_date  THEN 1
                 WHEN now() > lms_assignment.lms_assignment_submission_last_date THEN 2
            END

            ) as assignment_can_upload"),
                'lms_staff.lms_staff_first_name',
                'lms_staff.lms_staff_last_name',
                'lms_staff.lms_staff_full_name',
                'lms_staff.lms_staff_profile_image',
                'lms_assignment.lms_assignment_score',

            ])

            ->orderBy('lms_assignment.lms_assignment_submission_last_date', 'desc')
            ->paginate();

        return $getQuery;
    }

    public function finishUploadAssignmentByStudent($assignmentId, $userId,
        $studentId, $registrationId) {

        try {
            DB::beginTransaction();

            DB::table('lms_submitted_assignment_document')
                ->where('lms_assignment_id', $assignmentId)
                ->where('lms_user_id', $userId)
                ->where('lms_student_id', $studentId)
                ->where('lms_registration_id', $registrationId)
                ->update(['lms_submitted_assignment_upload_status' => 1]);

            DB::commit();

            $resultData['result'] = "success";
            return $resultData;
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
            return $resultData;
        }

    }

    // Get subject
    public function getBatchSlotBatchWise($batchId, $slotDay, $userId)
    {
        $getQuery = DB::table('lms_batch_slot')
            ->leftJoin('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_batch_slot.lms_subject_id')
            ->where('lms_batch_slot.lms_batch_slot_is_active', '=', 1)
           // ->where('lms_batch_slot.lms_center_id', '=', $this->centerId)
            ->where('lms_batch_slot.lms_batch_id', '=', $batchId)
            ->where('lms_batch_slot.lms_batch_slot_day_text', '=', $slotDay)
             ->where('lms_batch_slot.lms_user_id', '=', $userId)

            ->select([
                'lms_batch_slot.lms_batch_slot_id',
                'lms_batch_slot.lms_batch_slot_start_time',
                'lms_batch_slot.lms_batch_slot_end_time',
                'lms_batch_slot.lms_batch_slot_day',
                'lms_batch_slot.lms_batch_slot_day_text',
                'lms_batch_slot.lms_subject_id',
                'lms_subject.lms_subject_name',
            ])
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    // get assigment list for student
    public function getStudentListBatchWise($batchId)
    {
        $getQuery = DB::table('lms_student_course_mapping')
            ->leftJoin('lms_student', 'lms_student.lms_student_id', '=', 'lms_student_course_mapping.lms_student_id')

            ->where('lms_student_course_mapping.lms_batch_id', '=', $batchId)

            ->where('lms_student_course_mapping.lms_student_course_mapping_status', '=', 1)
            ->where('lms_student.lms_student_is_active', '=', 1)

            ->select([

                'lms_student_course_mapping.lms_registration_id',
                'lms_student_course_mapping.lms_user_id',
                'lms_student_course_mapping.lms_student_id',

                'lms_student_course_mapping.lms_registration_code',
                'lms_student.lms_student_code',
                'lms_student.lms_student_first_name',
                'lms_student.lms_student_last_name',
                'lms_student.lms_student_full_name',
                'lms_student.lms_student_profile_image',
                'lms_student.lms_student_mobile_number',

            ])

            ->orderBy('lms_student.lms_student_first_name')

            ->paginate();

        return $getQuery;
    }

    public function saveAttendance($batchId, $staffId,
        $courseId,
        $childCourseId, $attendanceDate,
        $batchSlotId, $slotDay,
        $slotDayText, $attendanceData, $isHoliday) {
        $attendanceParsedData = json_decode($attendanceData);

        $exception = DB::transaction(function () use ($batchId, $staffId,
            $courseId,
            $childCourseId, $attendanceDate,
            $batchSlotId, $slotDay,
            $slotDayText, $attendanceParsedData, $isHoliday) {

            for ($x = 0; $x < count($attendanceParsedData); $x++) {

                DB::table('lms_attendance')->updateOrInsert(
                    [
                        'lms_student_id' => $attendanceParsedData[$x]->lms_student_id,
                        'lms_registration_id' => $attendanceParsedData[$x]->lms_registration_id,
                        'lms_user_id' => $attendanceParsedData[$x]->lms_user_id,
                        'lms_attendance_date' => $attendanceDate,
                        'lms_batch_id' => $batchId,
                        'lms_batch_slot_id' => $batchSlotId,

                    ],
                    [
                        'lms_batch_id' => $batchId,
                        'lms_student_id' => $attendanceParsedData[$x]->lms_student_id,
                        'lms_staff_id' => $staffId,
                        'lms_course_id' => $courseId,
                        'lms_user_id' => $attendanceParsedData[$x]->lms_user_id,
                        'lms_registration_id' => $attendanceParsedData[$x]->lms_registration_id,
                        'lms_child_course_id' => $childCourseId,
                        'lms_attendance_date' => $attendanceDate,

                        'lms_batch_slot_id' => $batchSlotId,
                        'lms_batch_slot_day' => $slotDay,
                        'lms_attendance_status' => $isHoliday == "true" ? "3" : $attendanceParsedData[$x]->attendanceStatus,
                        'lms_attendance_created_by' => $staffId,
                        'lms_batch_slot_day_text' => $slotDayText,

                    ]
                );

            }
        });

        if (is_null($exception)) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return $resultData;

    }

    public function getAttendanceStudentWise($batchId, $registrationId, $fromDate, $toDate)
    {

        $getQuery = DB::select("select DATE_FORMAT(lms_attendance_date, '%d-%m-%Y') as lms_attendance_date,
         lms_attendance_status,
         lms_batch_slot.lms_batch_slot_start_time,lms_batch_slot.lms_batch_slot_end_time,
         lms_subject.lms_subject_name,


(SELECT count(lms_attendance_status) from lms_attendance where lms_attendance_status=1 and  lms_batch_id=$batchId
 and lms_registration_id=$registrationId  and
         cast(lms_attendance_date as date ) between STR_TO_DATE('$fromDate','%Y-%m-%d') and STR_TO_DATE('$toDate','%Y-%m-%d') )as 'Present',


         (SELECT count(lms_attendance_status) from lms_attendance where lms_attendance_status=2 and  lms_batch_id=$batchId
 and lms_registration_id=$registrationId  and
         cast(lms_attendance_date as date ) between STR_TO_DATE('$fromDate','%Y-%m-%d') and STR_TO_DATE('$toDate','%Y-%m-%d') )as 'Absent',


         (SELECT count(lms_attendance_status) from lms_attendance where lms_attendance_status=3 and  lms_batch_id=$batchId
 and lms_registration_id=$registrationId  and
         cast(lms_attendance_date as date ) between STR_TO_DATE('$fromDate','%Y-%m-%d') and STR_TO_DATE('$toDate','%Y-%m-%d') )as 'Holiday'



        from lms_attendance join lms_batch_slot on lms_attendance.lms_batch_slot_id=lms_batch_slot.lms_batch_slot_id

        join lms_subject on lms_subject.lms_subject_id=lms_batch_slot.lms_subject_id

        where lms_attendance.lms_batch_id=$batchId and lms_registration_id=$registrationId
         and cast(lms_attendance_date as date) between STR_TO_DATE('$fromDate','%Y-%m-%d') and STR_TO_DATE('$toDate','%Y-%m-%d')
        ");

        return $getQuery;
    }

    public function getChildCourse($courseId)
    {
        $getQuery = DB::table('lms_child_course')
            ->where('lms_child_course_is_active', '=', 1)
            ->where('lms_center_id', '=', $this->centerId)
            ->where('lms_course_id', '=', $courseId)

            ->select()
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    public function getOnlineChildCourse($courseId)
    {
        $getQuery = DB::table('lms_child_course')
            ->where('lms_child_course_is_active', '=', 1)
            ->where('lms_center_id', '=', $this->centerId)
            ->where('lms_course_id', '=', $courseId)
            ->where('lms_child_course_is_online', '=', 1)

            ->select()
            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;
    }

    public function getLibrary($userId, $libraryFlag)
    {
        $getQuery = "";
        if ($libraryFlag == "0") {
            // digital

            $getQuery = DB::table('lms_student_book_issue')
                ->leftJoin('lms_course', 'lms_course.lms_course_id', '=', 'lms_student_book_issue.lms_course_id')
                ->leftJoin('lms_book', 'lms_book.lms_book_id', '=', 'lms_student_book_issue.lms_book_id')
                ->where('lms_book.lms_book_status', '=', 1)
                ->where('lms_student_book_issue.lms_user_id', $userId)
                ->where('lms_book.lms_book_is_physical', 0)

                ->select([
                    'lms_book.lms_book_title',
                    'lms_book.lms_book_number',
                    'lms_book.lms_book_isbn_number',
                    'lms_book.lms_book_publisher',
                    'lms_book.lms_book_author',
                    'lms_book.lms_book_subject',
                    'lms_book.lms_book_quantity',
                    'lms_book.lms_book_current_quantity',
                    'lms_book.lms_book_price',
                    'lms_book.lms_book_is_physical',
                    'lms_book.lms_digital_book_path',
                    'lms_book.lms_book_download_days',
                    'lms_book.lms_book_return_days',
                    'lms_student_book_issue.lms_student_book_issue_id',

                    DB::raw('DATE_FORMAT(lms_student_book_issue.lms_student_book_issue_date, "%d-%m-%Y") as lms_student_book_issue_date', "%d-%m-%Y"),
                    DB::raw(" (select CASE
WHEN lms_student_book_issue.lms_student_book_return_date <lms_student_book_issue.lms_student_book_issue_date+lms_book.lms_book_return_days THEN 'Before Time'
WHEN lms_student_book_issue.lms_student_book_return_date =lms_student_book_issue.lms_student_book_issue_date+lms_book.lms_book_return_days THEN 'On Time'
WHEN lms_student_book_issue.lms_student_book_return_date >lms_student_book_issue.lms_student_book_issue_date+lms_book.lms_book_return_days THEN 'Late'

END

) as book_return_delay_status"),

                    DB::raw(" (select CASE
WHEN current_date <= DATE_ADD(lms_student_book_issue.lms_student_book_issue_date, INTERVAL lms_book.lms_book_download_days DAY) THEN 'Live'
else
'Expire'
END

) as is_download_expired"),

                    DB::raw('DATE_FORMAT(lms_student_book_issue.lms_student_book_return_date, "%d-%m-%Y") as lms_student_book_return_date', "%d-%m-%Y"),
                    'lms_student_book_issue.lms_student_book_late_fine',
                    'lms_student_book_issue.lms_student_book_download_count',
                    'lms_student_book_issue.lms_student_book_is_rteurned',
                    'lms_course.lms_course_name',
                    DB::raw('DATE_FORMAT(DATE_ADD(lms_student_book_issue.lms_student_book_issue_date, INTERVAL lms_book.lms_book_return_days DAY), "%d-%m-%Y") as lms_tentaive_return_date', "%d-%m-%Y"),

                ])
                ->orderBy('lms_student_book_issue.lms_student_book_is_rteurned', 'desc')
                ->paginate();
            return $getQuery;

        } else if ($libraryFlag == "1") {
            //Physical

            $getQuery = DB::table('lms_student_book_issue')
                ->leftJoin('lms_course', 'lms_course.lms_course_id', '=', 'lms_student_book_issue.lms_course_id')
                ->leftJoin('lms_book', 'lms_book.lms_book_id', '=', 'lms_student_book_issue.lms_book_id')
                ->where('lms_book.lms_book_status', '=', 1)
                ->where('lms_student_book_issue.lms_user_id', $userId)

                ->where('lms_book.lms_book_is_physical', 1)

                ->select([
                    'lms_book.lms_book_title',
                    'lms_book.lms_book_number',
                    'lms_book.lms_book_isbn_number',
                    'lms_book.lms_book_publisher',
                    'lms_book.lms_book_author',
                    'lms_book.lms_book_subject',
                    'lms_book.lms_book_quantity',
                    'lms_book.lms_book_current_quantity',
                    'lms_book.lms_book_price',
                    'lms_book.lms_book_is_physical',
                    'lms_book.lms_digital_book_path',
                    'lms_book.lms_book_download_days',
                    'lms_book.lms_book_return_days',
                    'lms_student_book_issue_id',

                    DB::raw('DATE_FORMAT(lms_student_book_issue.lms_student_book_issue_date, "%d-%m-%Y") as lms_student_book_issue_date', "%d-%m-%Y"),
                    DB::raw(" (select CASE
WHEN current_date <= DATE_ADD(lms_student_book_issue.lms_student_book_issue_date, INTERVAL lms_book.lms_book_download_days DAY) THEN 'Live'
else
'Expire'
END

) as is_download_expired"),

                    DB::raw(" (select CASE
WHEN lms_student_book_issue.lms_student_book_return_date <lms_student_book_issue.lms_student_book_issue_date+lms_book.lms_book_return_days THEN 'Before Time'
WHEN lms_student_book_issue.lms_student_book_return_date =lms_student_book_issue.lms_student_book_issue_date+lms_book.lms_book_return_days THEN 'On Time'
WHEN lms_student_book_issue.lms_student_book_return_date >lms_student_book_issue.lms_student_book_issue_date+lms_book.lms_book_return_days THEN 'Late'

END

) as book_return_delay_status"),
                    DB::raw('DATE_FORMAT(lms_student_book_issue.lms_student_book_return_date, "%d-%m-%Y") as lms_student_book_return_date', "%d-%m-%Y"),
                    'lms_student_book_issue.lms_student_book_late_fine',
                    'lms_student_book_issue.lms_student_book_download_count',
                    'lms_student_book_issue.lms_student_book_is_rteurned',
                    'lms_course.lms_course_name',
                    DB::raw('DATE_FORMAT(DATE_ADD(lms_student_book_issue.lms_student_book_issue_date, INTERVAL lms_book.lms_book_return_days DAY), "%d-%m-%Y") as lms_tentaive_return_date', "%d-%m-%Y"),

                ])
                ->orderBy('lms_student_book_issue.lms_student_book_is_rteurned', 'desc')
                ->paginate();
            return $getQuery;

        }

        return $getQuery;
    }

    // Update profile image
    public function updateTeacherProfileImage($userId, $fileName)
    {
        try {
            DB::beginTransaction();
            DB::table('lms_staff')
                ->where('lms_user_id', $userId)
                ->where('lms_center_id', '=', $this->centerId)
                ->update(['lms_staff_profile_image' => $fileName]);

            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
        }

        return $resultData;
    }
    // Remove profile image
    public function removeTeacherProfileImage($userId, $fileName)
    {
        try {
            DB::beginTransaction();
            DB::table('lms_staff')
                ->where('lms_user_id', $userId)
                ->where('lms_center_id', '=', $this->centerId)
                ->update(['lms_staff_profile_image' => null]);

            if (file_exists(storage_path('app/public/user_profile_images/' . $fileName))) {
                unlink(storage_path('app/public/user_profile_images/' . $fileName));
            }
            DB::commit();
            $resultData['result'] = "success";
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
        }

        return $resultData;
    }

    public function getVideoPlayList($videoStatus)
    {
        $getQuery = DB::table('lms_youtube_video_playlist')
            ->leftjoin('lms_youtube_video', 'lms_youtube_video_playlist.playlist_id', '=', 'lms_youtube_video.playlist_id')
            ->where('lms_youtube_video.video_status', '=', $videoStatus)
            ->where('lms_youtube_video_playlist.playlist_status', '=', 1)

            ->select([
                'lms_youtube_video_playlist.playlist_id',
                'lms_youtube_video_playlist.playlist_name',
                'lms_youtube_video_playlist.playlist_image_url',
                'lms_youtube_video.video_status',

                DB::raw(" (SELECT count(lms_youtube_video.video_id)
                    FROM lms_youtube_video  where  lms_youtube_video.playlist_id=lms_youtube_video_playlist.playlist_id
                     and lms_youtube_video.video_status=$videoStatus
          ) as total_videos"),

            ])
            ->paginate();
        return $getQuery;

    }

    public function getVideo($playListId, $videoStatus)
    {
        $getQuery = DB::table('lms_youtube_video')

            ->where('lms_youtube_video.playlist_id', '=', $playListId)
            ->where('lms_youtube_video.video_status', '=', $videoStatus)
            ->where('lms_youtube_video.is_video_active', '=', 1)

            ->select([
                'lms_youtube_video.video_id',
                'lms_youtube_video.you_tube_video_id',
                'lms_youtube_video.you_tube_video_url',
                'lms_youtube_video.you_tube_video_api_key',
                'lms_youtube_video.you_tube_video_title',
                'lms_youtube_video.you_tube_video_description',
                'lms_youtube_video.you_tube_video_thumbnail_image',
                'lms_youtube_video.is_video_paid',

                DB::raw('DATE_FORMAT(lms_youtube_video.youtube_video_scheduled_at, "%d-%m-%Y") as youtube_video_scheduled_at', "%d-%m-%Y"),
                DB::raw('DATE_FORMAT(lms_youtube_video.youtube_video_created_at, "%d-%m-%Y") as youtube_video_created_at', "%d-%m-%Y"),

            ])
            ->paginate();
        return $getQuery;

    }

    public function deleteAssignmentDoc($assignmenDocId, $docName)
    {

        try {
            DB::beginTransaction();
            if (file_exists(storage_path('app/public/assignment_images/' . $docName))) {
                unlink(storage_path('app/public/assignment_images/' . $docName));
            }

            DB::table('lms_assignment_document')
                ->where('lms_assignment_document_id', $assignmenDocId)
                ->delete();
            DB::commit();

            $resultData['result'] = "success";
            return $resultData;
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
            return $resultData;
        }

    }

    public function deleteAssignment($assignmentId)
    {

        try {
            DB::beginTransaction();

            DB::table('lms_assignment')
                ->where('lms_assignment_id', $assignmentId)
                ->delete();
            DB::commit();

            $resultData['result'] = "success";
            return $resultData;
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
            return $resultData;
        }

    }

    public function deleteStudentAssignmentDoc($assignmenDocId, $docName)
    {

        try {
            DB::beginTransaction();
            if (file_exists(storage_path('app/public/assignment_images/' . $docName))) {
                unlink(storage_path('app/public/assignment_images/' . $docName));
            }

            DB::table('lms_submitted_assignment_document')
                ->where('lms_submitted_assignment_document_id', $assignmenDocId)
                ->delete();
            DB::commit();

            $resultData['result'] = "success";
            return $resultData;
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
            return $resultData;
        }

    }

    // implemented to resolve the exam issue

    public function getExamQuestionAndInsertInExamResult($examScheduleId, $studentId, $userId,
        $registrationId, $isExamComplete, $courseId) {

        try {
            DB::beginTransaction();
            $getQuery = DB::table('lms_exam_schedule')
                ->join('lms_exam_wise_question', 'lms_exam_schedule.lms_exam_schedule_id', '=', 'lms_exam_wise_question.lms_exam_schedule_id')
                ->join('lms_question_bank', 'lms_question_bank.lms_question_bank_id', '=', 'lms_exam_wise_question.lms_question_bank_id')
                ->join('lms_question_difficulty_level', 'lms_question_difficulty_level.lms_question_difficulty_level_id', '=', 'lms_question_bank.lms_question_difficulty_level_id')
                ->join('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_question_bank.lms_topic_id')
                ->leftJoin('lms_exam_result', 'lms_question_bank.lms_question_bank_id', '=', 'lms_exam_result.lms_question_bank_id')

                ->where('lms_exam_schedule.lms_exam_schedule_id', '=', $examScheduleId)
                ->where('lms_exam_schedule.lms_center_id', '=', $this->centerId)
                ->where('lms_question_bank.lms_question_bank_is_active', '=', 1)

                ->select([
                    'lms_exam_schedule.lms_exam_schedule_name',
                    'lms_exam_schedule.lms_exam_schedule_no_of_question',
                    'lms_exam_schedule.lms_exam_schedule_max_marks',
                    'lms_exam_schedule.lms_exam_schedule_total_time_alloted',
                    'lms_exam_schedule.lms_exam_schedule_is_free_paid',
                    'lms_exam_schedule.lms_exam_schedule_pass_marks',
                    'lms_exam_schedule.lms_exam_schedule_has_negative_marking',
                    'lms_exam_schedule.lms_exam_schedule_negative_marking',

                    'lms_question_bank.lms_question_bank_id',
                    'lms_question_bank.lms_subject_id',
                    'lms_question_bank.lms_topic_id',
                    'lms_question_bank.lms_question_difficulty_level_id',
                    'lms_question_bank.lms_question_bank_type_single_multiple',
                    'lms_question_bank.lms_question_bank_has_image',
                    'lms_question_bank.lms_question_bank_image_path',
                    'lms_question_bank.lms_question_bank_text',
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

                    'lms_topic.lms_topic_name',

                    'lms_question_difficulty_level.lms_question_difficulty_level_name',
                    'lms_exam_result.lms_user_answers'])
                ->orderBy('lms_question_bank.lms_question_bank_id')
                ->groupBy('lms_question_bank.lms_question_bank_id')

                ->get();

            $getQueryResult = $getQuery->toArray();
            for ($i = 0; $i < count($getQueryResult); $i++) {
                DB::table('lms_exam_result')->insertGetId(
                    [
                        'lms_user_id' => $userId,
                        'lms_student_id' => $studentId,
                        'lms_registration_id' => $registrationId,
                        'lms_exam_schedule_id' => $examScheduleId,
                        'lms_question_bank_id' => $getQueryResult[$i]->lms_question_bank_id,
                        'lms_topic_id' => $getQueryResult[$i]->lms_topic_id,
                        'lms_subject_id' => $getQueryResult[$i]->lms_subject_id,
                        'lms_is_exam_complete' => $isExamComplete,
                        'lms_correct_answer' => $getQueryResult[$i]->lms_question_bank_correct_answers,
                        'lms_question_marks' => $getQueryResult[$i]->lms_question_bank_marks,
                        'lms_negative_marking' => $getQueryResult[$i]->lms_exam_schedule_negative_marking,
                        'lms_course_id' => $courseId,
                        'lms_exam_result_index' => $i,
                    ]
                );

            }

            DB::commit();

            $resultData['result'] = "success";
            return $resultData;
        } catch (Exception $ex) {
            DB::rollback();
            $resultData['result'] = "exception";
            return $resultData;
        }

    }

    public function getExamQuestionNew($examScheduleId)
    {

        $getQuery = DB::table('lms_exam_schedule')
            ->join('lms_exam_wise_question', 'lms_exam_schedule.lms_exam_schedule_id', '=', 'lms_exam_wise_question.lms_exam_schedule_id')
            ->join('lms_question_bank', 'lms_question_bank.lms_question_bank_id', '=', 'lms_exam_wise_question.lms_question_bank_id')
            ->join('lms_question_difficulty_level', 'lms_question_difficulty_level.lms_question_difficulty_level_id', '=', 'lms_question_bank.lms_question_difficulty_level_id')
            ->join('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_question_bank.lms_topic_id')
            ->leftJoin('lms_exam_result', 'lms_question_bank.lms_question_bank_id', '=', 'lms_exam_result.lms_question_bank_id')

            ->where('lms_exam_schedule.lms_exam_schedule_id', '=', $examScheduleId)
            ->where('lms_exam_schedule.lms_center_id', '=', $this->centerId)
            ->where('lms_question_bank.lms_question_bank_is_active', '=', 1)

            ->select([

                'lms_exam_schedule.lms_exam_schedule_name',
                'lms_exam_schedule.lms_exam_schedule_no_of_question',
                'lms_exam_schedule.lms_exam_schedule_max_marks',
                'lms_exam_schedule.lms_exam_schedule_total_time_alloted',
                'lms_exam_schedule.lms_exam_schedule_is_free_paid',
                'lms_exam_schedule.lms_exam_schedule_pass_marks',
                'lms_exam_schedule.lms_exam_schedule_has_negative_marking',
                'lms_exam_schedule.lms_exam_schedule_negative_marking',

                'lms_question_bank.lms_question_bank_id',
                'lms_question_bank.lms_subject_id',
                'lms_question_bank.lms_topic_id',
                'lms_question_bank.lms_question_difficulty_level_id',
                'lms_question_bank.lms_question_bank_type_single_multiple',
                'lms_question_bank.lms_question_bank_has_image',
                'lms_question_bank.lms_question_bank_image_path',
                'lms_question_bank.lms_question_bank_text',
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

                'lms_topic.lms_topic_name',

                'lms_question_difficulty_level.lms_question_difficulty_level_name',
                'lms_exam_result.lms_user_answers',
                DB::raw('(select now()) as "start_time"'),
                DB::raw('(select date_add(now(),interval (select  lms_exam_schedule_total_time_alloted from lms_exam_schedule where lms_exam_schedule_id=' . $examScheduleId . ') minute)) as "end_time"'),

            ])
            ->groupBy('lms_question_bank.lms_question_bank_id')
            ->orderBy('lms_question_bank.lms_question_bank_id')

            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;

    }

    public function getExamResultByExamResultId($userId, $studentId, $registrationId, $examScheduleId, $questionBankId)
    {

        $getQuery = DB::table('lms_exam_result')

            ->where('lms_user_id', '=', $userId)
            ->where('lms_student_id', '=', $studentId)
            ->where('lms_registration_id', '=', $registrationId)
            ->where('lms_exam_schedule_id', '=', $examScheduleId)
            ->where('lms_question_bank_id', '=', $questionBankId)

            ->select([
                'lms_exam_result.lms_user_answers',
            ])

            ->get();
        $getResult = $getQuery->toArray();
        return $getResult;

    }
    //end
    public function getAllTopic($subjectId,$searchText){
        $filterBy=$searchText;
        $getQuery = DB::table('lms_topic')
        ->join('lms_subject','lms_subject.lms_subject_id','lms_topic.lms_subject_id')
        ->join('lms_course','lms_course.lms_course_id','lms_topic.lms_course_id')
        ->where('lms_topic.lms_subject_id', '=', $subjectId)
        ->select('lms_topic.lms_topic_id','lms_topic.lms_topic_name','lms_topic.lms_subject_id','lms_subject.lms_subject_name','lms_course.lms_course_id','lms_course.lms_course_name'
        ,'lms_topic.lms_topic_code',
        DB::raw('DATE_FORMAT(lms_topic.lms_topic_created_at, "%d-%m-%Y") as created_date', "%d-%m-%Y"),
        DB::raw("( SELECT count(lms_youtube_video.video_id)
        FROM lms_youtube_video,lms_youtube_video_playlist where
        
        lms_youtube_video.topic_id= lms_topic.lms_topic_id and
        lms_youtube_video_playlist.playlist_id= lms_youtube_video.playlist_id and
       

        lms_topic.lms_topic_is_active=1 
        and lms_youtube_video.is_video_active=1
     
        and lms_youtube_video.video_status=1
        and lms_youtube_video_playlist.playlist_status=1
  
     

   ) as totalVideo"),



DB::raw("( SELECT count(lms_youtube_video.playlist_id)
FROM lms_youtube_video,lms_youtube_video_playlist where

lms_youtube_video.topic_id= lms_topic.lms_topic_id and
lms_youtube_video_playlist.playlist_id= lms_youtube_video.playlist_id and


lms_topic.lms_topic_is_active=1 
and lms_youtube_video.is_video_active=1

and lms_youtube_video.video_status=1
and lms_youtube_video_playlist.playlist_status=1



) as totalPlaylist"),

        )
        ->where(function ($q) use ($filterBy) {
               $q
                ->where('lms_topic.lms_topic_name', 'like', "%$filterBy%");
                  })
        ->where('lms_topic.lms_topic_is_active', '=', 1)
       
       ->paginate();
  
        return $getQuery;
      }

      public function getAllFees($registrationId,$studentId){
        $result = DB::table('lms_monthly_fee_generate')
        ->select(
            'lms_student.lms_user_id',
            'lms_student.lms_student_id',
            'lms_monthly_fee_generate.fee_id',
            'lms_monthly_fee_generate.lms_student_reg_id',
            'lms_monthly_fee_generate.lms_final_monthly_amount',
            'lms_discount.description',
            'lms_monthly_fee_generate.is_paid',
            'lms_monthly_fee_generate.lms_fee_description',
            'lms_fees_generate.lms_total_fee_discount',
            'lms_fees_generate.lms_actual_fee',
            'lms_student_course_mapping.lms_registration_id',
            'lms_monthly_fee_generate.lms_receipt_no',
            DB::raw("date_format(lms_monthly_fee_generate.lms_fees_date,'%b-%y') as lms_fees_date")
        )
        ->join('lms_fees_generate', 'lms_fees_generate.lms_student_id', '=', 'lms_monthly_fee_generate.lms_student_id')
        ->join('lms_discount', 'lms_discount.lms_discount_id', '=', 'lms_fees_generate.lms_discount_id')
        ->join('lms_student', 'lms_student.lms_student_id', '=', 'lms_monthly_fee_generate.lms_student_id')
        ->join('lms_student_course_mapping', 'lms_student_course_mapping.lms_student_id', '=', 'lms_monthly_fee_generate.lms_student_id')
        ->where('lms_monthly_fee_generate.lms_student_id', $studentId)
        ->where('lms_student_course_mapping.lms_registration_id', $registrationId)
    
        ->get();

    return $result;
      }

      public function getAllVoucher($registrationId,$studentId){
        $result = DB::table('lms_issued_voucher')
        ->select(
            'lms_issued_voucher.issue_voucher_id',
            'lms_issued_voucher.issue_voucher_number', 
            'lms_issued_voucher.voucher_amount',
            'lms_voucher_details.voucher_description',
            'lms_issued_voucher.voucher_issue_status',
            DB::raw("date_format(lms_issued_voucher.valid_from,'%b-%y') as valid_from"),
            DB::raw("date_format(lms_issued_voucher.valid_to,'%b-%y') as valid_to"),
            DB::raw("
            (case when lms_issued_voucher.voucher_issue_status  = '3' then 'Expired'
            when       lms_issued_voucher.voucher_issue_status  = '1' then 'Issued'
            when       lms_issued_voucher.voucher_issue_status  = '2' then 'Redeemed'
            ELSE 'Default' end) as 'voucher_issue_status'"),
        )
        ->join('lms_voucher_details', 'lms_voucher_details.voucher_id', '=', 'lms_issued_voucher.voucher_id')
        ->join('lms_student_course_mapping', 'lms_student_course_mapping.lms_student_id', '=', 'lms_issued_voucher.student_id')
        ->where('lms_issued_voucher.student_id','=', $studentId)
        ->where('lms_student_course_mapping.lms_registration_id','=', $registrationId)
        ->get();

    return $result;
      }
}
