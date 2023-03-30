<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Enquiry;
use DB;
class ContactUsController extends Controller
{
    public function contact(){
       
        return view('Frontend.contact');
    }

    public function contactenquiry(Request $request)
    {


        $validator= Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|string|email|max:255',
            'subject' => 'required',
            'message' => 'required',

        ]);

        if($validator->passes()){
            $user = Enquiry::create([

                'email' => $request->email,
                'enquiry' => $request->subject,
                'description' => $request->message,
                'enquirytype'=>'General',
                'status' => 'Active'
            ]);

            if($user){
                \Mail::send('components.contactmail', ['data1' =>$user], function($message) use($request){

                    $message->to($request->email);

                    $message->subject('Enquiry Form');
                });
                $savenotification = DB::table('notification')->insertGetId([
                    'notification_type_id' => 5,
                    'notification_subject' => 'One User Has Made An Enquiry',
                    'user_id' => 10,
                ]);
                return response()->json(['status'=>'success','msg'=>'Thank you we will come back to you soon']);
            }


        }
        else{
            return response()->json(['error'=>$validator->errors()->getMessageBag()->toArray()]);
        }


    }

}
