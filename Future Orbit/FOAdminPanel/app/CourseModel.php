<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class CourseModel extends Model
{
    protected $primaryKey = "lms_course_id";
    protected $table = "lms_course";
    public $timestamps = false;
    // Check Course Code in DB and then Save
    public static function saveUpdateCourse(
        $centerId,
        $loggedUserId,
        $courseCode,
        $courseName,
        $courseFees,
        $courseDuration,
        $isSaveEditClicked,
        $courseImageNameForEdit,
        $courseImageName,
        $courseDescription,
        $courseId
    ) {
        if ($isSaveEditClicked == 1) {

            // If save course is clicked
            $getQuery = DB::table("lms_course")->where('lms_center_id', $centerId)->where('lms_course_code', $courseCode)
                ->get();
            if ($getQuery->count() > 0) {
                // Course Code Exists
                if ($courseImageName != '') {
                    if (file_exists(storage_path('app/public/course_images/' . $courseImageName))) {
                        unlink(storage_path('app/public/course_images/' . $courseImageName));
                    }
                }
                $result_data['responseData'] = "1";
            } else {

                $saveQuery = DB::table('lms_course')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_course_code' => $courseCode,
                        'lms_course_name' => $courseName,
                        'lms_course_description' => $courseDescription,
                        'lms_course_fees' => $courseFees,
                        'lms_course_duration' => $courseDuration,
                        'lms_course_image' => $courseImageName,
                        'lms_course_created_by' => $loggedUserId,

                    ]
                );
                if ($saveQuery > 0) {
                    // course Saved
                    $result_data['responseData'] = "2";
                } else {
                    // Failed to save course
                    $result_data['responseData'] = "3";
                    if ($courseImageName != '') {
                        if (file_exists(storage_path('app/public/course_images/' . $courseImageName))) {
                            unlink(storage_path('app/public/course_images/' . $courseImageName));
                        }
                    }
                }
            }
        } else {

            $getQuery = DB::table("lms_course")->where('lms_center_id', $centerId)->where('lms_course_code', $courseCode)
                ->where('lms_course_id', '!=', $courseId)
                ->get();
            if ($getQuery->count() > 0) {
                // Course Code Exists
                if ($courseImageName != '') {
                    if (file_exists(storage_path('app/public/course_images/' . $courseImageName))) {
                        unlink(storage_path('app/public/course_images/' . $courseImageName));
                    }
                }
                $result_data['responseData'] = "1";
            } else {
                $updateQuery = DB::table('lms_course')
                    ->where('lms_course_id', $courseId)
                    ->where('lms_center_id', $centerId)
                    ->update([
                        'lms_course_code' => $courseCode,
                        'lms_course_name' => $courseName,
                        'lms_course_description' => $courseDescription,
                        'lms_course_fees' => $courseFees,
                        'lms_course_duration' => $courseDuration,
                        'lms_course_image' => $courseImageNameForEdit,
                        'lms_course_updated_at' => now(),
                        'lms_course_updated_by' => $loggedUserId,

                    ]);
                if ($updateQuery > 0) {
                    $result_data['responseData'] = "4";
                } else {
                    $result_data['responseData'] = "5";
                    if ($courseImageName != '') {
                        if (file_exists(storage_path('app/public/course_images/' . $courseImageName))) {
                            unlink(storage_path('app/public/course_images/' . $courseImageName));
                        }
                    }
                }
            }
        }
        return $result_data;
    }

    // Enable Disable Course
    public static function enableDisableCourse(
        $centerId,
        $courseId,
        $isCourseActive,
        $loggedUserId
    ) {
        $updateQuery = DB::table('lms_course')
            ->where('lms_course_id', $courseId)
            ->where('lms_center_id', $centerId)
            ->update([

                'lms_course_is_active' => $isCourseActive,
                'lms_course_updated_at' => now(),
                'lms_course_updated_by' => $loggedUserId,

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";
        } else {
            $result_data['responseData'] = "2";
        }
        return $result_data;
    }

    //--------------------------------------------------------
    // Check Course Code in DB and then Save
    public static function saveUpdateChildCourse(
        $centerId,
        $loggedUserId,
        $childCourseCode,
        $childCourseName,
        $childCourseFees,
        $childCourseDuration,
        $isSaveEditClicked,
        $courseImageNameForEdit,
        $courseImageName,
        $childCourseDescription,
        $courseId,
        $childCourseId,
        $lms_child_course_is_online
    ) {
        if ($isSaveEditClicked == 1) {

            // If save course is clicked
            $getQuery = DB::table("lms_child_course")->where('lms_center_id', $centerId)->where('lms_child_course_code', $childCourseCode)
                ->get();
            if ($getQuery->count() > 0) {
                // Course Code Exists
                if ($courseImageName != '') {
                    if (file_exists(storage_path('app/public/course_images/' . $courseImageName))) {
                        unlink(storage_path('app/public/course_images/' . $courseImageName));
                    }
                }
                $result_data['responseData'] = "1";
            } else {

                $saveQuery = DB::table('lms_child_course')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_course_id' => $courseId,
                        'lms_child_course_code' => $childCourseCode,
                        'lms_child_course_name' => $childCourseName,
                        'lms_child_course_description' => $childCourseDescription,
                        'lms_child_course_fees' => $childCourseFees,
                        'lms_child_course_duration' => $childCourseDuration,
                        'lms_child_course_image' => $courseImageName,
                        'lms_child_course_created_by' => $loggedUserId,
                        'lms_child_course_is_online' => $lms_child_course_is_online,

                    ]
                );
                if ($saveQuery > 0) {
                    // course Saved
                    $result_data['responseData'] = "2";
                } else {
                    // Failed to save course
                    $result_data['responseData'] = "3";
                    if ($courseImageName != '') {
                        if (file_exists(storage_path('app/public/course_images/' . $courseImageName))) {
                            unlink(storage_path('app/public/course_images/' . $courseImageName));
                        }
                    }
                }
            }
        } else {

            $getQuery = DB::table("lms_child_course")->where('lms_center_id', $centerId)->where('lms_child_course_code', $childCourseCode)
                ->where('lms_child_course_id', '!=', $childCourseId)
                ->get();
            if ($getQuery->count() > 0) {
                // Course Code Exists
            //    if ($courseImageName != '') {
              //      if (file_exists(storage_path('app/public/course_images/' . $courseImageName))) {
              //          unlink(storage_path('app/public/course_images/' . $courseImageName));
              //      }
             //   }
                $result_data['responseData'] = "1";
            } else {
                $updateQuery = DB::table('lms_child_course')
                    ->where('lms_child_course_id', $childCourseId)
                    ->where('lms_center_id', $centerId)
                    ->update([
                        'lms_course_id' => $courseId,
                        'lms_child_course_code' => $childCourseCode,
                        'lms_child_course_name' => $childCourseName,
                        'lms_child_course_description' => $childCourseDescription,
                        'lms_child_course_fees' => $childCourseFees,
                        'lms_child_course_duration' => $childCourseDuration,
                        'lms_child_course_image' => $courseImageName,
                        'lms_child_course_updated_at' => now(),
                        'lms_child_course_updated_by' => $loggedUserId,
                        'lms_child_course_is_online' => $lms_child_course_is_online,

                    ]);
                if ($updateQuery > 0) {
                    $result_data['responseData'] = "4";
                } else {
                    $result_data['responseData'] = "5";
                    if ($courseImageName != '') {
                        if (file_exists(storage_path('app/public/course_images/' . $courseImageName))) {
                            unlink(storage_path('app/public/course_images/' . $courseImageName));
                        }
                    }
                }
            }
        }
        return $result_data;
    }

    // Enable Disable Child Course
    public static function enableDisableChildCourse(
        $centerId,
        $childCourseId,
        $isCourseActive,
        $loggedUserId
    ) {
        $updateQuery = DB::table('lms_child_course')
            ->where('lms_child_course_id', $childCourseId)
            ->where('lms_center_id', $centerId)
            ->update([

                'lms_child_course_is_active' => $isCourseActive,
                'lms_child_course_updated_at' => now(),
                'lms_child_course_updated_by' => $loggedUserId,

            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";
        } else {
            $result_data['responseData'] = "2";
        }
        return $result_data;
    }
}
