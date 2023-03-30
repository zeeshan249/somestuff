<?php

namespace App\Http\Controllers;

use App\LibraryModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LibraryController extends Controller
{
    public function __construct()
    {
    }
    // Check Course Code in DB and then Save
    public function saveUpdateBookList(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'loggedUserId' => 'bail | required |numeric',
            'lms_book_title' => ['bail', 'required'],
            'lms_book_number' => 'bail | required ',
            'lms_book_subject' => 'bail | required',
            'lms_book_quantity' => 'bail | required',
            'lms_book_return_days' => 'bail | required | numeric',

        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {

            $centerId = $request->centerId;
            $loggedUserId = $request->loggedUserId;
            $lms_book_id = trim($request->lms_book_id);
            $isSaveEditClicked = $request->isSaveEditClicked;

            $lms_course_id = $request->lms_course_id;
            $lms_book_title = $request->lms_book_title;
            $lms_book_number = $request->lms_book_number;
            $lms_book_isbn_number = $request->lms_book_isbn_number;
            $lms_book_publisher = $request->lms_book_publisher;
            $lms_book_author = $request->lms_book_author;
            $lms_book_subject = $request->lms_book_subject;
            $lms_book_quantity = $request->lms_book_quantity;

            $lms_book_current_quantity = $request->lms_book_current_quantity;
            $lms_book_price = $request->lms_book_price;
            $lms_book_return_days = $request->lms_book_return_days;
            $bookCoverImageName = "";
            $oldBookCoverImage = $request->oldBookCoverImage;

            if ($isSaveEditClicked == 0 && $request->has('lms_book_cover_image_path')) {
                // If book list edit is true image has changed then delete the previous image
                if ($request->has('oldBookCoverImage')) {
                    if (file_exists(storage_path('app/public/book_cover_images/' . $oldBookCoverImage))) {
                        unlink(storage_path('app/public/book_cover_images/' . $oldBookCoverImage));
                    }
                }
                $bookCoverImageName = uniqid() . time() . '.' . $request->lms_book_cover_image_path->extension();
                $request->lms_book_cover_image_path->storeAs('public/book_cover_images', $bookCoverImageName);
            } else if ($isSaveEditClicked == 1 && $request->has('lms_book_cover_image_path')) {
                $bookCoverImageName = uniqid() . time() . '.' . $request->lms_book_cover_image_path->extension();
                $request->lms_book_cover_image_path->storeAs('public/book_cover_images', $bookCoverImageName);
            }



            $LibraryModel = new LibraryModel;
            $result = $LibraryModel->saveUpdateBookList(
                $centerId,
                $loggedUserId,
                $lms_book_id,
                $lms_course_id,
                $lms_book_title,
                $lms_book_number,
                $lms_book_isbn_number,
                $lms_book_publisher,
                $lms_book_author,
                $lms_book_subject,
                $lms_book_quantity,
                $lms_book_current_quantity,
                $lms_book_price,
                $lms_book_return_days,
                $bookCoverImageName,
                $isSaveEditClicked
            );
            return response()->json($result);
        }
    }

    //Get all Book List
    public function getAllBookLIst(Request $request)
    {
        $active = [];
        $centerId = $request->centerId;
        $includeDelete = $request->includeDelete;
        $perPage = $request->perPage ? $request->perPage : 100;
        if ($includeDelete == "false") {
            $active = [1];
        } else {
            $active = [1, 0];
        }
        $getData = DB::table("lms_book")
            ->Join("lms_course", \DB::raw("FIND_IN_SET(lms_course.lms_course_id,lms_book.lms_course_id)"), ">", \DB::raw("'0'"))
            ->select([
                'lms_book.lms_course_id',
                'lms_book_id', 'lms_book_title', 'lms_book_number', 'lms_book_isbn_number', 'lms_book_publisher',
                'lms_book_author', 'lms_book_subject',  'lms_book_quantity', 'lms_book_current_quantity', 'lms_book_price', 'lms_book_is_physical',
                'lms_digital_book_path', 'lms_book_return_days', 'lms_book_late_fine', 'lms_book_cover_image_path',
                DB::raw('GROUP_CONCAT(lms_course.lms_course_name order by lms_book.lms_book_id  ) lms_course_name'),
                DB::raw('concat(lms_book_quantity, "/",lms_book_current_quantity) as qtyVsAvlQty'),
                DB::raw('DATE_FORMAT(lms_book_created_date, "%d-%m-%Y") as lms_book_created_date', "%d-%m-%Y"),
                DB::raw("IF(lms_book_status = 1, 'Active','Inactive')as lms_book_status"),
            ])
            ->where('lms_book.lms_center_id', $centerId)
            ->whereIn('lms_book_status', $active)
            ->groupBy('lms_book_id')

            ->paginate($perPage);
        return $getData;
    }

    public function getAllRegisteredStudents(Request $request)
    {

        $perPage = $request->perPage;
        $filterBy = $request->filterBy;
        $centerId = $request->centerId;
        $lms_book_id = $request->lms_book_id;
        $result = DB::table('lms_student')
            ->join('lms_enquiry', 'lms_enquiry.lms_enquiry_id', '=', 'lms_student.lms_enquiry_id')
            ->join('lms_student_course_mapping', 'lms_student.lms_student_id', '=', 'lms_student_course_mapping.lms_student_id')
            ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_student_course_mapping.lms_course_id')
            ->join('lms_child_course', 'lms_student_course_mapping.lms_child_course_id', '=', 'lms_child_course.lms_child_course_id')
            ->leftjoin('lms_batch_details', 'lms_batch_details.lms_batch_id', '=', 'lms_student_course_mapping.lms_batch_id')

            ->where('lms_student.lms_center_id', '=', $centerId)
            ->where(function ($q) use ($filterBy) {
                $q->where('lms_student.lms_student_full_name', 'like', "%$filterBy%")
                    ->orWhere('lms_batch_details.lms_batch_code', 'like', "%$filterBy%");
            })

            ->select(
                'lms_student_course_mapping.lms_registration_id',
                'lms_student.lms_student_id',
                'lms_student.lms_user_id',
                DB::raw(
                    "(select lms_student_book_is_rteurned from lms_student_book_issue where lms_student_book_issue.lms_student_id = lms_student.lms_student_id and lms_student_book_issue.lms_book_id = $lms_book_id and lms_student_book_issue.lms_student_book_is_rteurned = 0 group by lms_student_book_issue.lms_student_id ) as lms_student_book_is_rteurned"
                ),
                'lms_student.lms_center_id',
                'lms_student.lms_student_first_name',
                'lms_student.lms_student_last_name',
                'lms_student.lms_student_full_name',
                'lms_student.lms_student_mobile_number',

                'lms_batch_details.lms_batch_name',
                'lms_batch_details.lms_batch_code',

                'lms_student_course_mapping.lms_registration_code',
                DB::raw("date_format(lms_student_course_mapping.lms_student_course_mapping_created_at,'%d-%m-%y') as lms_student_course_mapping_created_at"),

                'lms_course.lms_course_name',
                'lms_child_course.lms_child_course_name',
                'lms_course.lms_course_id',

                //Enquiry Start
                'lms_enquiry.lms_enquiry_id',
                'lms_enquiry.lms_enquiry_code',
                'lms_enquiry.lms_enquiry_first_name',
                'lms_enquiry.lms_enquiry_last_name',
                'lms_enquiry.lms_enquiry_full_name',
                'lms_enquiry.lms_enquiry_father_name',
                'lms_enquiry.lms_enquiry_mother_name',
                'lms_enquiry.lms_enquiry_gender',
                'lms_enquiry.lms_enquiry_marital_status',
                'lms_enquiry.lms_enquiry_date_of_birth',
                'lms_enquiry.lms_enquiry_date_of_joining',

                'lms_enquiry.lms_enquiry_mobile',
                'lms_enquiry.lms_enquiry_whatsapp_contact',
                'lms_enquiry.lms_enquiry_email',
                'lms_enquiry.lms_enquiry_local_address',
                'lms_enquiry.lms_enquiry_permanent_address',
                'lms_enquiry.lms_enquiry_work_experience',
                'lms_enquiry.lms_enquiry_about',

                'lms_enquiry.lms_enquiry_qualification',
                'lms_enquiry.lms_enquiry_school_name',
                'lms_enquiry.lms_enquiry_remarks',
                'lms_enquiry.lms_information_source_id',
                //Enquiry End
                DB::raw("
                          (case when lms_student.lms_student_is_active  = '0' then 'Inactive'
                          when       lms_student.lms_student_is_active  = '1' then 'Active'
                          ELSE 'Default' end) as 'lms_student_is_active'"),

                DB::raw("
                          (case when lms_student_course_mapping.lms_student_registration_type  = '4' then 'Closed'
                          when       lms_student_course_mapping.lms_student_registration_type  = '1' then 'Online'
                          when       lms_student_course_mapping.lms_student_registration_type  = '2' then 'Internal'
                          when       lms_student_course_mapping.lms_student_registration_type  = '0' then 'Inactive'
                          ELSE 'APP' end) as 'lms_student_registration_type'")
            )
            ->orderBy('lms_student_course_mapping.lms_student_course_mapping_created_at', 'desc')

            ->paginate($perPage);
        return $result;
    }

    //Get all Issued Book List Student Wise
    public function getAllStudentListBookWise(Request $request)
    {
        $centerId = $request->centerId;
        $lms_book_id = $request->lms_book_id;
        $lms_student_book_is_rteurned = $request->lms_student_book_is_rteurned;
        $getData = DB::table("lms_student_book_issue")
            ->Join('lms_student', 'lms_student.lms_student_id', '=', 'lms_student_book_issue.lms_student_id')
            ->Join('lms_student_course_mapping', 'lms_student.lms_student_id', '=', 'lms_student_course_mapping.lms_student_id')
            ->select([
                'lms_student_book_issue_id',
                'lms_book_id', 'lms_student_full_name', 'lms_student.lms_student_code', 'lms_student.lms_user_id', 'lms_registration_code',
                DB::raw('DATE_FORMAT(lms_student_book_return_date, "%d-%m-%Y") as lms_student_book_return_date', "%d-%m-%Y"),
                DB::raw('DATE_FORMAT(lms_student_book_scheduled_return_date, "%d-%m-%Y") as lms_student_book_scheduled_return_date', "%d-%m-%Y"),
                DB::raw('DATE_FORMAT(lms_student_book_issue_date, "%d-%m-%Y") as lms_student_book_issue_date', "%d-%m-%Y"),
                DB::raw("IF(lms_student_book_is_rteurned = 0, 'Active','Inactive')as lms_student_book_is_rteurned"),
            ])
            ->whereIn('lms_student_book_issue.lms_student_book_is_rteurned', $lms_student_book_is_rteurned)
            ->where('lms_student_course_mapping.lms_center_id', $centerId)
            ->where('lms_student_book_issue.lms_book_id', $lms_book_id)
            ->orderBy('lms_student_book_issue.lms_student_book_is_rteurned', 'asc')->get();
        return $getData;
    }

    //IssueBook
    public function issueBook(Request $request)
    {
        $loggedUserId = $request->loggedUserId;
        $lms_book_id = $request->lms_book_id;
        $lms_student_id = $request->lms_student_id;
        $lms_registration_id = $request->lms_registration_id;
        $lms_course_id = $request->lms_course_id;
        $lms_user_id = $request->lms_user_id;

        $result = LibraryModel::issueBook(
            $lms_book_id,
            $loggedUserId,
            $lms_user_id,
            $lms_student_id,
            $lms_registration_id,
            $lms_course_id,
        );
        return response()->json($result);
    }

    //Return Book
    public function returnBook(Request $request)
    {
        $centerId = $request->centerId;
        $loggedUserId = $request->loggedUserId;
        $lms_student_book_issue_id = $request->lms_student_book_issue_id;
        $lms_book_id = $request->lms_book_id;
        $result = LibraryModel::returnBook(
            $centerId,
            $lms_student_book_issue_id,
            $lms_book_id,
            $loggedUserId
        );
        return response()->json($result);
    }
    //Enable Disable Book
    public function enableDisableBook(Request $request)
    {
        $centerId = $request->centerId;
        $lms_book_id = $request->lms_book_id;
        $lms_book_status = $request->lms_book_status;
        $result = LibraryModel::enableDisableBook(
            $centerId,
            $lms_book_id,
            $lms_book_status
        );
        return response()->json($result);
    }
}
