<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\StudentModel;
use Illuminate\Http\Request;
use DB;
class CertificateController extends Controller
{


    public  function getGeneratedCertificateListFranchiseWise(Request $request)
    {

        $per_page = $request->per_page ? $request->per_page : 5;
        $sortBy = $request->sort_by;
        $orderBy = $request->order_by;
        $filterBy = $request->filter_by;
        $franchiseId = $request->franchiseId;
        $result=DB::table('ueh_student')
        ->join('ueh_user','ueh_user.user_id','=','ueh_student.user_id')
        ->join('ueh_state','ueh_state.state_id','=','ueh_student.state_id')
        ->join('ueh_course','ueh_course.course_id','=','ueh_student.course_id')
        ->leftJoin('ueh_certificate','ueh_student.student_id','=','ueh_certificate.student_id')
        ->where('ueh_student.student_name', 'like', "%$filterBy%")
        ->where('ueh_student.student_status', '=', 2)
        ->where('ueh_student.franchise_id', '=', $franchiseId)
        ->select('ueh_user.user_profile_image',
        'ueh_user.user_email_id',
       'ueh_user.user_status',
       'ueh_state.state_name',

       'ueh_student.student_id',
       'ueh_student.student_name',
       'ueh_student.student_guardian_name',
       'ueh_student.course_id',
       'ueh_student.student_dob',
       'ueh_student.student_mobile',
       'ueh_student.student_educational_qualification',
       'ueh_student.student_address',
       'ueh_student.state_id',
    'ueh_student.student_pin',
    'ueh_student.student_document_pan',
    'ueh_student.student_document_aadhar',
    'ueh_student.student_document_voter_card',
    'ueh_student.student_code',
    'ueh_student.student_registration_code',
    'ueh_student.user_id',

    'ueh_student.student_information_source',
    'ueh_student.student_created_at',
    'ueh_student.student_status',
    'ueh_student.franchise_id',
    'ueh_course.course_name',
    'ueh_certificate.certificate_application_number',
    'ueh_certificate.certificate_ueh_number',
    'ueh_certificate.certificate_id',
    'ueh_certificate.certificate_created_at',
    'ueh_certificate.certificate_status',
    'ueh_certificate.certificate_approved_rejected_on')
        ->orderBy('ueh_student'.'.'.$sortBy, $orderBy)

        ->paginate($per_page);
        return $result;
    }





    public  function getApprovedCertificateListFranchiseWise(Request $request)
    {

        $per_page = $request->per_page ? $request->per_page : 5;
        $sortBy = $request->sort_by;
        $orderBy = $request->order_by;
        $filterBy = $request->filter_by;
        $franchiseId = $request->franchiseId;
        $result=DB::table('ueh_student')
        ->join('ueh_user','ueh_user.user_id','=','ueh_student.user_id')
        ->join('ueh_state','ueh_state.state_id','=','ueh_student.state_id')
        ->join('ueh_course','ueh_course.course_id','=','ueh_student.course_id')
        ->leftJoin('ueh_certificate','ueh_student.student_id','=','ueh_certificate.student_id')
        ->where('ueh_student.student_name', 'like', "%$filterBy%")
        ->where('ueh_student.student_status', '=', 3)
        ->where('ueh_student.franchise_id', '=', $franchiseId)
        ->select('ueh_user.user_profile_image',
        'ueh_user.user_email_id',
       'ueh_user.user_status',
       'ueh_state.state_name',

       'ueh_student.student_id',
       'ueh_student.student_name',
       'ueh_student.student_guardian_name',
       'ueh_student.course_id',
       'ueh_student.student_dob',
       'ueh_student.student_mobile',
       'ueh_student.student_educational_qualification',
       'ueh_student.student_address',
       'ueh_student.state_id',
    'ueh_student.student_pin',
    'ueh_student.student_document_pan',
    'ueh_student.student_document_aadhar',
    'ueh_student.student_document_voter_card',
    'ueh_student.student_code',
    'ueh_student.student_registration_code',
    'ueh_student.user_id',

    'ueh_student.student_information_source',
    'ueh_student.student_created_at',
    'ueh_student.student_status',
    'ueh_student.franchise_id',
    'ueh_course.course_name',
    'ueh_certificate.certificate_application_number',
    'ueh_certificate.certificate_ueh_number',
    'ueh_certificate.certificate_id',
    'ueh_certificate.certificate_created_at',
    'ueh_certificate.certificate_status',
    'ueh_certificate.certificate_approved_rejected_on')
        ->orderBy('ueh_student'.'.'.$sortBy, $orderBy)

        ->paginate($per_page);
        return $result;
    }





    public  function getRejectedCertificateListFranchiseWise(Request $request)
    {

        $per_page = $request->per_page ? $request->per_page : 5;
        $sortBy = $request->sort_by;
        $orderBy = $request->order_by;
        $filterBy = $request->filter_by;
        $franchiseId = $request->franchiseId;
        $result=DB::table('ueh_student')
        ->join('ueh_user','ueh_user.user_id','=','ueh_student.user_id')
        ->join('ueh_state','ueh_state.state_id','=','ueh_student.state_id')
        ->join('ueh_course','ueh_course.course_id','=','ueh_student.course_id')
        ->leftJoin('ueh_certificate','ueh_student.student_id','=','ueh_certificate.student_id')
        ->where('ueh_student.student_name', 'like', "%$filterBy%")
        ->where('ueh_student.student_status', '=', 4)
        ->where('ueh_student.franchise_id', '=', $franchiseId)
        ->select('ueh_user.user_profile_image',
        'ueh_user.user_email_id',
       'ueh_user.user_status',
       'ueh_state.state_name',

       'ueh_student.student_id',
       'ueh_student.student_name',
       'ueh_student.student_guardian_name',
       'ueh_student.course_id',
       'ueh_student.student_dob',
       'ueh_student.student_mobile',
       'ueh_student.student_educational_qualification',
       'ueh_student.student_address',
       'ueh_student.state_id',
    'ueh_student.student_pin',
    'ueh_student.student_document_pan',
    'ueh_student.student_document_aadhar',
    'ueh_student.student_document_voter_card',
    'ueh_student.student_code',
    'ueh_student.student_registration_code',
    'ueh_student.user_id',

    'ueh_student.student_information_source',
    'ueh_student.student_created_at',
    'ueh_student.student_status',
    'ueh_student.franchise_id',
    'ueh_course.course_name',
    'ueh_certificate.certificate_application_number',
    'ueh_certificate.certificate_ueh_number',
    'ueh_certificate.certificate_id',
    'ueh_certificate.certificate_created_at',
    'ueh_certificate.certificate_status',
    'ueh_certificate.certificate_approved_rejected_on')
        ->orderBy('ueh_student'.'.'.$sortBy, $orderBy)

        ->paginate($per_page);
        return $result;
    }



}
