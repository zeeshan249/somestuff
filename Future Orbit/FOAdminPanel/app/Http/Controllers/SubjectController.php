<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use App\SubjectModel;
class SubjectController extends Controller
{
    public function __construct()
    {

    }
    // Check Course Code in DB and then Save
    public function saveUpdateSubject(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'loggedUserId' => 'bail | required |numeric ',
            'subjectCode'=> 'bail | required',
            'subjectName'=>  ['bail', 'required', 'regex:/^[a-zA-Z ]+$/'],
            'courseId'=> 'bail | required |numeric ',
           

        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;
            $subjectCode = trim($request->subjectCode);
            $subjectName = $request->subjectName;
            $isSaveEditClicked = $request->isSaveEditClicked;
            $courseId = $request->courseId;
            $subjectId = $request->subjectId;
            


                $result = SubjectModel::saveUpdateSubject($centerId,
                $loggedUserId, $subjectCode, $subjectName,
                $isSaveEditClicked, $courseId,$subjectId);
                return response()->json($result);
            }



        }

    

    //Get the Subject
    public function getAllSubject(Request $request)
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
        $getData = DB::table("lms_subject")->
            leftJoin('lms_course', 'lms_course.lms_course_id', '=', 'lms_subject.lms_course_id')->
            select(['lms_subject_id', 'lms_subject.lms_course_id', 'lms_course_name','lms_subject_code','lms_subject_name',
              DB::raw("IF(lms_subject_is_active = 1, 'Active','Inactive')as lms_subject_is_active")])
            ->
            where('lms_subject.lms_center_id', $centerId)
            ->where(function ($q) use ($filterBy) {
                $q->orWhere('lms_subject.lms_subject_code', 'like', "%$filterBy%")
                ->orWhere('lms_subject.lms_subject_name', 'like', "%$filterBy%")
                ->orWhere('lms_course.lms_course_name', 'like', "%$filterBy%");
            })
            ->whereIn('lms_subject.lms_subject_is_active', $active)
            ->paginate($perPage);
            
        return $getData;
    }

    //Enable Disable course
    public function enableDisableSubject(Request $request)
    {
        $centerId = $request->centerId;
        $subjectId = $request->subjectId;
        $isSubjectActive = $request->isSubjectActive;
        $loggedUserId = $request->loggedUserId;
        $result=SubjectModel::enableDisableSubject($centerId,
        $subjectId,$isSubjectActive,$loggedUserId);
        return response()->json($result);

    }

     //Get All Active Course without pagination
     public function getActiveCourseWithoutPagination(Request $request)
     {
         $centerId = $request->centerId;

         $getQuery= DB::table("lms_course")->
             select(['lms_course_id', 'lms_course_name'])
             ->where('lms_course_is_active', 1)
             ->where('lms_center_id', $centerId)
             ->get();
             return $getQuery;

     }




     // Code for Subject Controller
      

}
