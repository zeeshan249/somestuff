<?php

namespace App\Http\Controllers;

use App\AssignmentModel;
use App\CourseModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class AssignmentController extends Controller
{
    public function __construct()
    {

    }


     //Upload Assignment
    public function uploadAssignment(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric',
            'loggedUserId' => 'bail | required |numeric',
            'assignmentImage' => 'bail|sometimes|nullable|mimes:jpeg,jpg,png,pdf,docx|max:1024',

        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;
            $lms_assignment_id =$request->lms_assignment_id;
            $assignmentImageName = '';

            if ($request->has('assignmentImage')) {
                // If course image selected

                $assignmentImageName = uniqid() . time() . '.' . $request->assignmentImage->extension();
                $request->assignmentImage->storeAs('public/assignment_images', $assignmentImageName);
                if ($request->assignmentImage->isValid()) {
                 
                    $result = AssignmentModel::uploadAssignment(
                        $centerId,
                        $loggedUserId,
                      $assignmentImageName,
                      $lms_assignment_id
                    );

                   return response()->json($result); //Success
                } else {
                    // Course Image Upload Failed
                    return response()->json(['responseData' => 3]); //Failed
                }
            } 
        }
    }

    //Get the Assignment
    public function getAllAssignment(Request $request)
    {
        $active = [];
        $perPage = $request->perPage ? $request->perPage : 15;
        $filterBy = $request->filterBy;
         $centerId = $request->centerId;
          $includeDelete = $request->includeDelete;
         if ($includeDelete == "false") {
            $active = [1];
        } else {
            $active = [1, 0];
        }
        $getData = DB::table("lms_assignment")
            ->Join('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_assignment.lms_subject_id')
            ->Join('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_assignment.lms_topic_id')
            ->Join('lms_batch_details', 'lms_batch_details.lms_batch_id', '=', 'lms_assignment.lms_batch_id')
            ->leftjoin('lms_child_course', 'lms_child_course.lms_child_course_id', '=', 'lms_assignment.lms_child_course_id')
            
            ->select(['lms_assignment.lms_assignment_id',
              
                DB::raw('DATE_FORMAT(lms_assignment.lms_assignment_created_at, "%d-%m-%Y") as lms_assignment_created_at', "%d-%m-%Y"),
                DB::raw('DATE_FORMAT(lms_assignment.lms_assignment_submission_last_date, "%Y-%m-%d") as lms_assignment_submission_last_date', "%d-%m-%Y"),
                DB::raw('IF(lms_assignment.lms_assignment_upload_status = 1, "Submitted","Created")as lms_assignment_upload_status'),
                'lms_assignment.lms_assignment_title', 'lms_assignment.lms_assignment_description','lms_assignment.lms_assignment_score',
                'lms_subject.lms_subject_name', 'lms_topic.lms_topic_name',
                'lms_assignment.lms_batch_id',
                'lms_assignment.lms_subject_id',
                'lms_assignment.lms_topic_id',
                'lms_assignment.lms_course_id',
                'lms_child_course.lms_child_course_name',
                'lms_child_course.lms_child_course_id',
                'lms_batch_details.lms_batch_name',
                 DB::raw("IF(lms_assignment_status = 1, 'Active','Inactive')as lms_assignment_status")
              
                

            ])
            ->where(function ($q) use ($filterBy) {
                $q->where('lms_assignment.lms_assignment_title', 'like', "%$filterBy%")
                ->orWhere('lms_topic.lms_topic_name', 'like', "%$filterBy%")
                ->orWhere('lms_subject.lms_subject_name', 'like', "%$filterBy%");
            })
            ->where('lms_assignment.lms_center_id', '=', $centerId)
              ->whereIn('lms_assignment.lms_assignment_status', $active)
            // ->groupBy('lms_assignment.lms_assignment_id')
              ->orderBy('lms_assignment.lms_assignment_submission_last_date', "desc")
            ->paginate($perPage);
        return $getData;
    }

    //Get the Assignment
    public function getDocumentAssignmentWise(Request $request)
    {
       
          $centerId = $request->centerId;
          $lms_assignment_id = $request->lms_assignment_id;
            $perPage = $request->perPage ? $request->perPage : 500;
                $getData = DB::table("lms_assignment")
               
                ->Join('lms_assignment_document', 'lms_assignment_document.lms_assignment_id', '=', 'lms_assignment.lms_assignment_id')
                ->select(['lms_assignment.lms_assignment_id',
                          
               'lms_assignment_document.lms_assignment_document_path',
                DB::raw('DATE_FORMAT(lms_assignment_document.lms_assignment_document_created_at, "%d-%m-%Y") as lms_assignment_document_created_at', "%d-%m-%Y"),
                'lms_assignment_document.lms_assignment_document_id',
                

            ])
           
            ->where('lms_assignment.lms_center_id', '=', $centerId)
            ->where('lms_assignment.lms_assignment_id', '=', $lms_assignment_id)
            ->where('lms_assignment_document.lms_assignment_document_status', '=','1')
               ->paginate($perPage);
           
        return $getData;
    }
    //Save/Update Assignment
public function saveUpdateAssignment(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'loggedUserId' => 'bail | required |numeric ',
            'lms_assignment_title' => 'bail | required',
            'lms_assignment_description' => 'bail| required',
            'lms_topic_id' => 'bail| required',
            'lms_subject_id' => 'bail| required',
            'lms_assignment_submission_last_date' => 'bail| required',
            'lms_assignment_score' => 'bail| required',

        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;
            $lms_assignment_title = $request->lms_assignment_title;
            $lms_assignment_description = $request->lms_assignment_description;
            $isSaveEditClicked = $request->isSaveEditClicked;
            $lms_assignment_id = $request->lms_assignment_id;
             $lms_assignment_submission_last_date = $request->lms_assignment_submission_last_date;
              $lms_assignment_score = $request->lms_assignment_score;

             $lms_course_id = $request->lms_course_id;
            $lms_batch_id = $request->lms_batch_id;
            $lms_subject_id = $request->lms_subject_id;
            $lms_topic_id = $request->lms_topic_id;
            $lms_user_id = $request->loggedUserId;
            $classId= $request->classId;

            $result = AssignmentModel::saveUpdateAssignment(
                $centerId,
                $loggedUserId,
                $lms_user_id,
                $lms_assignment_id,
                $isSaveEditClicked,
                $lms_assignment_title,
                $lms_assignment_description,
                $lms_batch_id,
                $lms_subject_id,
                $lms_topic_id,
                $lms_assignment_submission_last_date,
                $lms_assignment_score,
                $lms_course_id,
                $classId
           

            );
            return response()->json($result);
        }
    }
    //Get the Submitted Assignment
    public function getAllSubmittedAssignment(Request $request)
    {

        $perPage = $request->perPage ? $request->perPage : 15;

        $getData = DB::table("lms_submitted_assignment_document")
            ->Join('lms_assignment', 'lms_assignment.lms_assignment_id', '=', 'lms_submitted_assignment_document.lms_assignment_id')
            ->Join('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_assignment.lms_subject_id')
            ->Join('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_assignment.lms_topic_id')
            ->Join('lms_student', 'lms_student.lms_student_id', '=', 'lms_submitted_assignment_document.lms_student_id')
            ->select(['lms_submitted_assignment_document.lms_submitted_assignment_document_id',
                'lms_submitted_assignment_document.lms_assignment_id',
                'lms_submitted_assignment_document.lms_submitted_assignment_document_path',
                DB::raw('DATE_FORMAT(lms_submitted_assignment_document.lms_submitted_assignment_document_date, "%d-%m-%Y") as lms_submitted_assignment_document_date', "%d-%m-%Y"),
                DB::raw('DATE_FORMAT(lms_submitted_assignment_document.lms_submitted_assignment_evaluation_date, "%d-%m-%Y") as lms_submitted_assignment_evaluation_date', "%d-%m-%Y"),
                DB::raw("IF(lms_submitted_assignment_document.lms_submitted_assignment_evaluation_status = 1, 'Evaluated','Not Evaluated')as lms_submitted_assignment_evaluation_status"),
                DB::raw("IF(lms_submitted_assignment_document.lms_submitted_assignment_upload_status = 1, 'Active','Partial')as lms_submitted_assignment_upload_status"),
                'lms_assignment.lms_assignment_title', 'lms_assignment.lms_assignment_description',
                DB::raw('DATE_FORMAT(lms_assignment.lms_assignment_submission_last_date, "%d-%m-%Y") as lms_assignment_submission_last_date', "%d-%m-%Y"),
                DB::raw('DATE_FORMAT(lms_assignment.lms_assignment_created_at, "%d-%m-%Y") as lms_assignment_created_at', "%d-%m-%Y"),
                'lms_subject.lms_subject_name', 'lms_topic.lms_topic_name',
                'lms_student.lms_student_full_name', 'lms_student.lms_student_code',
                 'lms_student.lms_student_id',

            ])

            ->where('lms_assignment.lms_assignment_status', 1)
            ->where('lms_submitted_assignment_document.lms_submitted_assignment_upload_status', 1)
            ->where('lms_submitted_assignment_document.lms_assignment_id', $request->assignmentId)
            

            ->paginate($perPage);
        return $getData;
    }

    public function getSubmittedAssignmentDetails(Request $request)
    {

        $assignmentId = $request->assignmentId;
        $studentId = $request->studentId;

        $getData = DB::table("lms_submitted_assignment_document")

            ->select([
                'lms_submitted_assignment_document.lms_submitted_assignment_document_path',
            ])

            ->where('lms_assignment_id', $assignmentId)
            ->where('lms_student_id', $studentId)
            ->get();
        return $getData;
    }

    //Enable Disable course
    public function evaluateAssignment(Request $request)
    {
       $assignmentId = $request->assignmentId;
      $studentId = $request->studentId;

        $loggedUserId = $request->loggedUserId;
        $result = AssignmentModel::evaluateAssignment($assignmentId,
            $studentId, $loggedUserId);
        return response()->json($result);

    }


    //Delete Assignment
    public function deleteAssignment(Request $request)
    {
        $lms_assignment_document_id = $request->lms_assignment_document_id;
        $loggedUserId = $request->loggedUserId;
        $result = AssignmentModel::deleteAssignment(
            $lms_assignment_document_id,
            $loggedUserId
        );
        return response()->json($result);
    }

    //Enable Disable Assignment
    public function enableDisableAssignment(Request $request)
    {

        $lms_assignment_id = $request->lms_assignment_id;
        $loggedUserId = $request->loggedUserId;
        $lms_assignment_upload_status  = $request->lms_assignment_upload_status;
        $result = AssignmentModel::enableDisableAssignment(
            $lms_assignment_id,
            $loggedUserId,
            $lms_assignment_upload_status
        );
        return response()->json($result);
    }

}
