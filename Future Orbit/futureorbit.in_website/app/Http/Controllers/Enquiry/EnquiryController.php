<?php

namespace App\Http\Controllers\Enquiry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DB;

class EnquiryController extends Controller
{
    public function enquiry(){
        $courses=DB::table('lms_child_course')->select('*')->where('lms_child_course_is_active',1)->get();
        $streams=DB::table('lms_course')->select('*')->where('lms_course_is_active',1)->get();
        $schools=DB::table('lms_school_list')->select('*')->where('is_lms_school_active',1)->get();
        return view('Enquiry.enquiry',['courses'=>$courses,'streams'=>$streams,'schools'=>$schools]);
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
                        'fathersname.required'                       => 'Fathers name is required',
                        'mobile.required'                            => 'Mobile name is required',
                        'address.required'                           => 'Address name is required',
                        'school.required'                            => 'School name is required',
                    ]
      
                );

                if ($validation->passes()) {
                    try 
                    {
                               
                      
                        DB::beginTransaction();
                        $bookingCodePrefix = "EW" . date("ym");
                        $bookingCode = IdGenerator::generate(['table' => 'lms_enquiry', 'field' => 'lms_enquiry_code', 'length' => 12, 'prefix' => $bookingCodePrefix,
                            'reset_on_prefix_change' => true]);
                        
                            $insertedUserId = DB::table('lms_contact_us')->insert([
                                'lms_center_id'=>1,
                                'lms_information_source_id'=>2,
                                'lms_course_id'=>$request->classname,
                                'lms_child_course_id'=>$request->course,
                                'lms_enquiry_code' => $bookingCode,
                                'email' => $request->email,
                                'subject' => $request->subject,
                                'phone_no' => $request->phone,
                                'description'=> $request->description
                
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

    
}
