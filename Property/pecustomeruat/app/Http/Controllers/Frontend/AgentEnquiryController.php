<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Enquiry;
use DB;
class AgentEnquiryController extends Controller
{
    public function agentenquiry(Request $request)
    {


        $validator= Validator::make($request->all(),[

            'email' => 'required|string|email|max:255',
            'phone'=>'required',
            'description' => 'required',
        ]);

        if($validator->passes()){
            $user = Enquiry::create([

                'agent_id' => $request->agent_ids,
                'email' => $request->email,
                'phone' => $request->phone,
                'description' => $request->description,
                'enquirytype'=>'General',
                'status' => 'Active'
            ]);


            Mail::send('components.emailformat', ["data1"=>$user], function($message) use($request){
                $message->to($request->email);

                $message->subject('Enquiry Form');
            });
               $savenotification = DB::table('notification')->insertGetId([
                'notification_type_id' => 7,
                'notification_subject' => 'An Agent Enquiry from '.$request->email,
                'user_id' => 10,
               ]);
                return response()->json(['status'=>'success','msg'=>'Thank you we will come back to you soon']);

        }
        else{
            return response()->json(['error'=>$validator->errors()->getMessageBag()->toArray()]);
        }


    }

}
