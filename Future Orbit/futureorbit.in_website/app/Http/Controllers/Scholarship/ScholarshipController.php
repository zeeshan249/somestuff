<?php

namespace App\Http\Controllers\Scholarship;

use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class ScholarshipController extends Controller
{
    public function index(){
        $schools=DB::table('lms_school_list')->select('*')->where('is_lms_school_active',1)->get();
        return view('Scholarship.scholarship',['schools'=>$schools]);
    }
    public function  submitscholarship(Request  $request){

        $validation = Validator::make(
            $request->all(),
            [
                'student'         => 'required',
                'fathersname'        => 'required',
                'rollno'           => 'required',
                'classname'          => 'required',
                'section'            =>'required',
                'address'            =>'required',
                'mobile'            =>'required|min:10',
                'school'            =>'required'
            ],
            [
                'student.required'                         =>  'Student Name is required.',
                'fathersname.required'                         =>  'Fathers Name is required.',
                'rollno.required'                   =>'Roll No is Required',
                'classname.required'           =>'Please Choose the  Required Class',
                'section.required'            =>'Please Choose The Required Section',
                'school.required'          =>'Please Choose the required school'

            ]

        );

        if ($validation->passes()) {
            try
            {
                $mobile=DB::table('lms_enquiry')->where('lms_enquiry.lms_enquiry_mobile',$request->mobile)->count();
                if($mobile>0)
                {
                    return response()->json(['status'=>'success','msg'=>'You have already applied for Scholarship Test']); 
                }
                $centerId=1;
                DB::beginTransaction();
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

                $insertedUserId = DB::table('lms_enquiry')->insert([
                    'lms_center_id'=>1,
                    'lms_course_id'=>22,
                    'lms_child_course_id'=>21,
                    'lms_information_source_id'=>6,
                    'lms_enquiry_code' => $enquiryCode,
                    'lms_school_id'=>$request->school,
                    'lms_enquiry_school_name'=>$request->school,
                    'lms_enquiry_date' => date('Y-m-d'),
                    'lms_enquiry_mobile' => $request->mobile,
                    'lms_enquiry_father_name'=>$request->fathersname,
                    'lms_enquiry_full_name'=>$request->student,
                    'lms_roll_no'=>$request->rollno,
                    'lms_enquiry_class'=>$request->classname,
                    'lms_enquiry_section'=>$request->section,
                    'lms_enquiry_permanent_address'=>$request->address,
                    'lms_enquiry_local_address'=>$request->address,

                ]);


                DB::commit();



                return response()->json(['status'=>'success','msg'=>'Your Are Successfully registered For the Test Your Reference Number is ' .$enquiryCode]);
            }
            catch (Exception $ex) {

                DB::rollback();
            }

        }
        else{
            return response()->json(['error'=>$validation->errors()->getMessageBag()->toArray()]);
        }
    }
}
