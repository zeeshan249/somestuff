<?php

namespace App;

use DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class LibraryModel extends Model
{


    // Check Book Title in DB and then Save
    public static function saveUpdateBookList(
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

    ) {
        if ($isSaveEditClicked == 1) {

            // If save course is clicked
            $getQuery = DB::table("lms_book")->where('lms_center_id', $centerId)->where('lms_book_title', $lms_book_title)
                ->get();
            if ($getQuery->count() > 0) {
                // Book Exists
                $result_data['responseData'] = "1";
            } else {


                $saveQuery = DB::table('lms_book')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_book_created_by' => $loggedUserId,
                        'lms_course_id' => $lms_course_id,
                        'lms_book_title' => $lms_book_title,
                        'lms_book_number' => $lms_book_number,
                        'lms_book_isbn_number' => $lms_book_isbn_number,
                        'lms_book_publisher' => $lms_book_publisher,
                        'lms_book_author' => $lms_book_author,
                        'lms_book_subject' => $lms_book_subject,
                        'lms_book_quantity' => $lms_book_quantity,
                        'lms_book_current_quantity' => $lms_book_current_quantity,
                        'lms_book_price' => $lms_book_price,
                        'lms_book_return_days' => $lms_book_return_days,
                        'lms_book_cover_image_path' => $bookCoverImageName

                    ]
                );
                if ($saveQuery > 0) {
                    $result_data['responseData'] = "2";
                } else {
                    // Failed to save book
                    $result_data['responseData'] = "3";
                }
            }
        } else {

            if ($bookCoverImageName != null) {
                $updateQuery = DB::table('lms_book')
                    ->where('lms_book_id', $lms_book_id)
                    ->where('lms_center_id', $centerId)
                    ->update([
                        'lms_course_id' => $lms_course_id,
                        'lms_book_title' => $lms_book_title,
                        'lms_book_number' => $lms_book_number,
                        'lms_book_isbn_number' => $lms_book_isbn_number,
                        'lms_book_publisher' => $lms_book_publisher,
                        'lms_book_author' => $lms_book_author,
                        'lms_book_subject' => $lms_book_subject,
                        'lms_book_quantity' => $lms_book_quantity,
                        'lms_book_current_quantity' => $lms_book_current_quantity,
                        'lms_book_price' => $lms_book_price,
                        'lms_book_return_days' => $lms_book_return_days,
                        'lms_book_cover_image_path' => $bookCoverImageName

                    ]);
            } else {
                $updateQuery = DB::table('lms_book')
                    ->where('lms_book_id', $lms_book_id)
                    ->where('lms_center_id', $centerId)
                    ->update([
                        'lms_course_id' => $lms_course_id,
                        'lms_book_title' => $lms_book_title,
                        'lms_book_number' => $lms_book_number,
                        'lms_book_isbn_number' => $lms_book_isbn_number,
                        'lms_book_publisher' => $lms_book_publisher,
                        'lms_book_author' => $lms_book_author,
                        'lms_book_subject' => $lms_book_subject,
                        'lms_book_quantity' => $lms_book_quantity,
                        'lms_book_current_quantity' => $lms_book_current_quantity,
                        'lms_book_price' => $lms_book_price,
                        'lms_book_return_days' => $lms_book_return_days,

                    ]);
            }


            if ($updateQuery > 0) {
                $result_data['responseData'] = "4";
            } else {
                $result_data['responseData'] = "3";
            }
        }
        return $result_data;
    }
    // Enable Disable book
    public static function returnBook(
        $centerId,
        $lms_student_book_issue_id,
        $lms_book_id,
        $loggedUserId
    ) {
        $updateQuery = DB::table('lms_student_book_issue')
            ->where('lms_student_book_issue_id', $lms_student_book_issue_id)
            ->update([

                'lms_student_book_is_rteurned' => '1',
                'lms_student_book_return_date' => now(),
                'lms_student_book_return_by' => $loggedUserId,

            ]);

        $updateQuery = DB::table('lms_book')
            ->where('lms_book_id', $lms_book_id)
            ->update([
                'lms_book_current_quantity' =>  DB::raw('lms_book_current_quantity + 1'),
            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";
        } else {
            $result_data['responseData'] = "2";
        }
        return $result_data;
    }


    // Enable Disable book
    public static function issueBook(
        $lms_book_id,
        $loggedUserId,
        $lms_user_id,
        $lms_student_id,
        $lms_registration_id,
        $lms_course_id
    ) {

        // $getQuery = DB::table("lms_book")
        // ->where('lms_book_id', $lms_book_id)
        // ->where('lms_book_title', $lms_book_title)
        //     ->get();

        $getQuery =  DB::table("lms_book")
            ->select(
                DB::raw("if (lms_book.lms_book_current_quantity>0, 'true', 'false') as avlqty")
            )
            ->where("lms_book.lms_book_id", "=", $lms_book_id)
            ->get();

        $getResult = $getQuery->toArray();
        if ($getResult[0]->avlqty == 'false') {
            $result_data['responseData'] = "3";
        } else {

            DB::beginTransaction();
            try {
                $saveQuery = DB::table('lms_student_book_issue')->insertGetId(
                    [
                        'lms_book_id' => $lms_book_id,
                        'lms_user_id' => $lms_user_id,
                        'lms_student_id' => $lms_student_id,
                        'lms_registration_id' => $lms_registration_id,
                        'lms_course_id' => $lms_course_id,
                        'lms_student_book_issue_date' => now(),
                        'lms_student_book_scheduled_return_date' =>
                        DB::raw('date_add(curdate(),interval 7 Day)'),
                        'lms_student_book_issued_by' => $loggedUserId,

                    ]
                );

                $updateQuery = DB::table('lms_book')
                    ->where('lms_book_id', $lms_book_id)
                    ->update([
                        'lms_book_current_quantity' =>  DB::raw('lms_book_current_quantity - 1'),
                    ]);

                DB::commit();
                if ($updateQuery > 0) {
                    $result_data['responseData'] = "1";
                } else {
                    $result_data['responseData'] = "2";
                }
            } catch (Exception $ex) {

                DB::rollback();
                $result_data['responseData'] = $ex;
                return $result_data;
            }
        }
        return $result_data;
    }
    // Enable Disable book
    public static function enableDisableBook(
        $centerId,
        $lms_book_id,
        $lms_book_status
    ) {
        $updateQuery = DB::table('lms_book')
            ->where('lms_book_id', $lms_book_id)
            ->where('lms_center_id', $centerId)
            ->update([

                'lms_book_status' => $lms_book_status,
            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";
        } else {
            $result_data['responseData'] = "2";
        }
        return $result_data;
    }
}
