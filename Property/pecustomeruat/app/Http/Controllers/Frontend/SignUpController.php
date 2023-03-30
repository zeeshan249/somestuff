<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class SignUpController extends Controller
{
    public function signup(Request $request)
    {

        $msg=[
            'firstname.required'=>'*Firstname is required',
            'lastname.required'=>'*Lastname is required',
            'user_email.required'=>'*Email is required',
            'phone1.required'=>'*Phone is required',
         
       
        ];

        $validator= Validator::make($request->all(),[
            'firstname' => 'required',
            'lastname' => 'required',
            'user_email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'phone1' => 'required',
      


        ],$msg);
    //    max:10,     'phone1.max'=>'*Primary Phone no should be 10 digits'
        if($validator->passes()){
            try {
                DB::beginTransaction();

            $getRenNum = Str::random(32);
            $insertedUserId = DB::table('users')->insertGetId([

                'first_name' => $request->firstname,
                'last_name' => $request->lastname,
                'full_name'=>$request->firstname.$request->lastname,
                'slug'=>Str::slug($request->firstname.$request->lastname),
                'created_by'=>1,
                'user_email'=>$request->user_email,
                'password_normal' => $request->password,
                'password'=>Hash::make($request->password),
                'role_id'=>$request->role,
                'email_verification'=>0

            ]);

            DB::table('user_details')->insertGetId(
                [
                    'user_id' => $insertedUserId,
                    'first_name' => ucfirst($request->firstname),
                    'last_name' => ucfirst($request->lastname),
                    'phone_1' =>$request->phone1,
                    'phone_2' =>$request->sec_phone,
                    'nick_name' =>$request->nickname,
        

                ]);


            $act=route('activation',$insertedUserId);

            Mail::send('components.registerVerification', ["password"=>$request->password,"mail"=>"dd",'act'=>$act], function($message) use($request){
                $message->to($request->user_email);
                // $message->from($request->user_email,'Property');
                $message->subject('Verification');
            });

                $savenotification = DB::table('notification')->insertGetId([
                    'notification_type_id' => 6,
                    'notification_subject' => 'One Agent Has Signed Up',
                    'user_id' => 10,
                ]);


                $modelhasroles=DB::table('model_has_roles')->insertGetId([
                   'role_id'=>$request->role,
                   'model_id'=>$insertedUserId,
                ]);

              DB::commit();
                return response()->json(['status'=>'success','msg'=>'Thank you Please check your mail']);
            } catch (Exception $ex) {

                DB::rollback();

            }

        }
        else{
            return response()->json(['error'=>$validator->errors()->getMessageBag()->toArray()]);
        }


    }


    public function activation($id){
//        dd($id);
        $activate = User::where('user_id',$id)->first();
//        $email=$activate->email;
//        Session::put('emailvalue', $email);
        if($activate && $activate->email_verification == false){
            $updateQuery = DB::table('users')
                ->where('user_id', $id)
                ->update([
             'email_verification' => 1,
             'user_status'=>'Inactive',
                ]);
         if($updateQuery) {
//            Session::flash('success','Your email has been activated. Please Set Password For Your Email.');
             return redirect()->route('index')->with('message', 'Your email has been activated');
         }
        }
        else if($activate && $activate->email_verification == true) {


            return redirect()->route('index')->with('message','Your email has already been activated please sign in');
        }

    }
}
