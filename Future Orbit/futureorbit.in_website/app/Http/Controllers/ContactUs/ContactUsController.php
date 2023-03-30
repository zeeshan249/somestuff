<?php

namespace App\Http\Controllers\ContactUs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DB;
class ContactUsController extends Controller
{
    public function contactus(){
        $courses=DB::table('lms_child_course')->select('*')->where('lms_child_course_is_active',1)->get();
        $streams=DB::table('lms_course')->select('*')->where('lms_course_is_active',1)->get();
        $schools=DB::table('lms_school_list')->select('*')->where('is_lms_school_active',1)->get();
        return view('Contact.contactus',['courses'=>$courses,'streams'=>$streams,'schools'=>$schools]);
    }



    public function enquirySubmit(Request $request)
    {
       
          
                $validation = Validator::make(
                    $request->all(),
                    [
                        'classname'         => 'required',
                        'course'               =>'required',
                        'firstname'         => 'required',
                        'lastname'         => 'required',
                        'email'               => 'required',
                        'fathersname'        => 'required',
                        'mobile'           => 'required',
                        'address'          => 'required',
                        'school'            =>'required'
                    ],
                    [
                        'classname.required'                         =>  'Class Name is required.',
                        'course.required'                            =>  'Course is required',
                        'firstname.required'                         =>  'First name is required',
                        'lastname.required'                          =>  'Last name is required',
                        'email.required'                             =>  'Email is required',
                        'fathersname.required'                       => 'Fathers name is required',
                        'mobile.required'                            => 'Mobile name is required',
                        'address.required'                           => 'Address name is required',
                        'school.required'                            => 'School name is required',
                    ]
      
                );

                if ($validation->passes()) {
                    try 
                    {
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
                                'lms_information_source_id'=>2,
                                'lms_course_id'=>$request->classname,
                                'lms_enquiry_school_name'=>$request->school,
                                'lms_school_id'=>$request->school,
                                'lms_child_course_id'=>$request->course,
                                'lms_enquiry_first_name'=>$request->firstname,
                                'lms_enquiry_last_name'=>$request->lastname,
                                'lms_enquiry_full_name'=>$request->firstname,
                                'lms_enquiry_code' => $enquiryCode,
                                'lms_enquiry_email' => $request->email,
                                'lms_enquiry_date' => date('Y-m-d'),
                                'lms_enquiry_mobile' => $request->mobile,
                                'lms_enquiry_remarks'=> $request->description,
                                'lms_enquiry_father_name'=>$request->fathersname
                
                            ]);
                           
                            // Mail::send('mail.contactmail', ['name'=>$request->fullname,'email'=>$request->email,'subject'=>$request->subject
                            //  ,'phone_no'=>$request->phone,'description'=>$request->description], function($message) use($request){
                            //     $message->to($request->email);
                
                            //     $message->subject('Contact Us');
                            // });

                
                        DB::commit();



                      return response()->json(['status'=>'success','msg'=>'Thank you we will come back to you soon']);
                           }
                          catch (Exception $ex) {

                                DB::rollback();
                         }
              
                          }
                 else{
                    return response()->json(['error'=>$validation->errors()->getMessageBag()->toArray()]);
                  }
                       
}
//fetch courses dynamic dependent dropdown ajax
            public function fetchCourses(Request $request)
            {
            $fetchcourses=DB::table('lms_child_course')->select('*')->where('lms_child_course_is_active',1)
            ->where('lms_child_course.lms_course_id',$request->course_id)
            ->get();
            return response()->json(['fetchcourses'=>$fetchcourses]);
            }
            }
