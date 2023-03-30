<?php

namespace App\Http\Controllers;

use App\CourseModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function __construct()
    {
    }

    // Check Course Code in DB and then Save
    public function saveUpdateCourse(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'loggedUserId' => 'bail | required |numeric ',
            'courseCode' => 'bail | required',
            'courseName' => ['bail', 'required'],
            'courseFees' => 'bail | required |numeric ',
            'courseDuration' => 'bail | required |numeric ',
            'courseImage' => 'bail|sometimes|nullable|mimes:jpeg,jpg,png|max:1024',

        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;
            $courseCode = trim($request->courseCode);
            $courseName = $request->courseName;
            $courseDescription = $request->courseDescription;
            $courseFees = $request->courseFees;
            $courseDuration = $request->courseDuration;
            $isSaveEditClicked = $request->isSaveEditClicked;
            $courseImageNameForEdit = $request->courseImageNameForEdit;
            $courseId = $request->courseId;

            $courseImageName = '';

            if ($request->has('courseImage')) {
                // If course image selected

                $courseImageName = uniqid() . time() . '.' . $request->courseImage->extension();
                $request->courseImage->storeAs('public/course_images', $courseImageName);
                if ($request->courseImage->isValid()) {
                    // Course Image Upload Success
                    if ($isSaveEditClicked == 0) {
                        // If course edit is true

                        // If course is Editing delete the previous image
                        if ($courseImageNameForEdit != '') {
                            if (file_exists(storage_path('app/public/course_images/' . $courseImageNameForEdit))) {
                                unlink(storage_path('app/public/course_images/' . $courseImageNameForEdit));
                            }
                        }
                        $courseImageNameForEdit = '';
                    }
                    $result = CourseModel::saveUpdateCourse(
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
                    );

                    return response()->json($result);
                } else {
                    // Course Image Upload Failed
                    return response()->json(['responseData' => 6]);
                }
            } else {
                // If course image not selected
                $courseImageName=$courseImageNameForEdit;
                $result = CourseModel::saveUpdateCourse(
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
                );
                return response()->json($result);
            }
        }
    }

    //Get the Course
    public function getAllCourse(Request $request)
    {
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 100;
        $includeDelete = $request->includeDelete;
        $filterBy=$request->searchText;
        if ($includeDelete == "false") {
            $active = [1];
        } else {
            $active = [1, 0];
        }
        
        $getData = DB::table("lms_course")->select([
                'lms_course_id', 'lms_course_code', 'lms_course_name',
                'lms_course_description', 'lms_course_fees', 'lms_course_duration', 'lms_course_image',
                DB::raw("IF(lms_course_is_active = 1, 'Active','Inactive')as lms_course_is_active")
            ])
            ->where('lms_center_id', $centerId)
            ->where(function ($q) use ($filterBy) {
                $q->orWhere('lms_course.lms_course_name', 'like', "%$filterBy%")
                    ->orWhere('lms_course.lms_course_duration', 'like', "%$filterBy%")
                    ->orWhere('lms_course.lms_course_code', 'like', "%$filterBy%")
                    ->orWhere('lms_course.lms_course_fees', 'like', "%$filterBy%");
                  

            })
            ->whereIn('lms_course.lms_course_is_active', $active)
            ->paginate($perPage);
        return $getData;
    }
    //Enable Disable course
    public function enableDisableCourse(Request $request)
    {
        $centerId = $request->centerId;
        $courseId = $request->courseId;
        $isCourseActive = $request->isCourseActive;
        $loggedUserId = $request->loggedUserId;
        $result = CourseModel::enableDisableCourse(
            $centerId,
            $courseId,
            $isCourseActive,
            $loggedUserId
        );
        return response()->json($result);
    }

    //Get All Active Course without pagination
    public function getActiveCourseWithoutPagination(Request $request)
    {
        $centerId = $request->centerId;

        $getQuery = DB::table("lms_course")->select(['lms_course_id', 'lms_course_name', 'lms_course_image', 'lms_course_description', 'lms_course_fees', 'lms_course_duration'])
            ->where('lms_course_is_active', 1)
            ->where('lms_center_id', $centerId)
            ->get();
        return $getQuery;
    }

    //Get the Child Course
    public function getAllChildCourse(Request $request)
    {
        $centerId = $request->centerId;
        $filterBy=$request->searchText;
        $perPage = $request->perPage ? $request->perPage : 100;
        $includeDelete = $request->includeDelete;
        if ($includeDelete == "false") {
            $active = [1];
        } else {
            $active = [1, 0];
        }
        $getData = DB::table("lms_child_course")->leftJoin('lms_course', 'lms_course.lms_course_id', '=', 'lms_child_course.lms_course_id')->select([
                'lms_child_course_id', 'lms_course.lms_course_name', 'lms_course.lms_course_id', 'lms_child_course_code', 'lms_child_course_name',
                'lms_child_course_description', 'lms_child_course_fees', 'lms_child_course_duration',
                'lms_child_course_image', 'lms_child_course_is_online',
                DB::raw("IF(lms_child_course_is_active = 1, 'Active','Inactive')as lms_child_course_is_active")
            ])
          
            ->where('lms_child_course.lms_center_id', $centerId)

            ->where(function ($q) use ($filterBy) {
                $q->orWhere('lms_child_course.lms_child_course_code', 'like', "%$filterBy%")
                ->orWhere('lms_course.lms_course_name', 'like', "%$filterBy%")
                    ->orWhere('lms_child_course.lms_child_course_name', 'like', "%$filterBy%")
                    ->orWhere('lms_child_course.lms_child_course_fees', 'like', "%$filterBy%");
    
            })
            ->whereIn('lms_child_course.lms_child_course_is_active', $active)
            ->paginate($perPage);
        return $getData;
    }
    // Check Course Code in DB and then Save
    public function saveUpdateChildCourse(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric',
            'loggedUserId' => 'bail | required |numeric',
            'childCourseCode' => 'bail | required',
            'childCourseName' => ['bail', 'required'],
            'childCourseFees' => 'bail | required |numeric',
            'childCourseDuration' => 'bail | required |numeric',
            'lms_child_course_is_online' => 'required',
            'courseImage' => 'bail|sometimes|nullable|mimes:jpeg,jpg,png|max:1024',

        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;
            $childCourseCode = trim($request->childCourseCode);
            $childCourseName = $request->childCourseName;
            $childCourseDescription = $request->childCourseDescription;
            $childCourseFees = $request->childCourseFees;
            $childCourseDuration = $request->childCourseDuration;
            $isSaveEditClicked = $request->isSaveEditClicked;
            $courseImageNameForEdit = $request->courseImageNameForEdit;
            $courseId = $request->courseId;
            $childCourseId = $request->childCourseId;
            $lms_child_course_is_online = $request->lms_child_course_is_online;

            $courseImageName = '';

            if ($request->has('courseImage')) {
                // If course image selected

                $courseImageName = uniqid() . time() . '.' . $request->courseImage->extension();
                $request->courseImage->storeAs('public/course_images', $courseImageName);
                if ($request->courseImage->isValid()) {
                    // Course Image Upload Success
                    if ($isSaveEditClicked == 0) {
                        // If course edit is true

                        // If course is Editing delete the previous image
                        if ($courseImageNameForEdit != '') {
                            if (file_exists(storage_path('app/public/course_images/' . $courseImageNameForEdit))) {
                                unlink(storage_path('app/public/course_images/' . $courseImageNameForEdit));
                            }
                        }
                    }
                    $result = CourseModel::saveUpdateChildCourse(
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
                    );

                    return response()->json($result);
                } else {
                    // Course Image Upload Failed
                    return response()->json(['responseData' => 6]);
                }
            } else {
                // If course image not selected

                $result = CourseModel::saveUpdateChildCourse(
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
                );
                return response()->json($result);
            }
        }
    }
    //Enable Disable course
    public function enableDisableChildCourse(Request $request)
    {
        $centerId = $request->centerId;
        $childCourseId = $request->childCourseId;
        $isCourseActive = $request->isCourseActive;
        $loggedUserId = $request->loggedUserId;
        $result = CourseModel::enableDisableChildCourse(
            $centerId,
            $childCourseId,
            $isCourseActive,
            $loggedUserId
        );
        return response()->json($result);
    }
}
