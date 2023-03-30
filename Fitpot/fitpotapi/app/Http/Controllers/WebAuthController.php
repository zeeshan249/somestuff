<?php

namespace App\Http\Controllers;

use App\Models\AppModel;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebAuthController extends Controller
{
    //this function is for admin panel login
    public function webLogin(Request $request)
    {
        try {
            $mobile = $request->mobile;
            $password = $request->password;
            if (Auth::attempt(['user_mobile' => $mobile, 'password' => $password, 'user_status' => 1])) {

                // Login Success
                $token = Auth::user()->createToken(random_int(100000, 999999))->plainTextToken;
                DB::table('users')
                    ->where('user_id', Auth::user()->user_id)
                    ->update(['auth_token' => $token]);
                $userData['user_id'] = Auth::user()->user_id;
                $userData['user_first_name'] = Auth::user()->user_first_name;
                $userData['user_last_name'] = Auth::user()->user_last_name;
                $userData['user_full_name'] = Auth::user()->user_full_name;
                $userData['user_profile_image'] = Auth::user()->user_profile_image;

                return response()->json(['result' => 'success', 'message' => 'Login Success', 'token' => $token,
                    'userData' => $userData]);

            } else {

                // Login Fail
                return response()->json(['result' => 'error', 'message' => 'Invalid Login Details']);
            }

        } catch (Exception $ex) {

            return response()->json(['result' => "exception", 'message' => 'Something went wrong']);
        }

    }
}
