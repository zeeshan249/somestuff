<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['validateLogin']]);
    }
    public function validateLogin(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'mobile' => 'bail | required | min:10 | max:10 ',
            'password' => 'required '
        ]);

        if ($validation->fails()) {

            return response()->json(['error' => $validation->errors()->first(), 'login_flag' => 1]);
        } else {
            if ($jwtToken=Auth::attempt(['user_mobile_number' => $request->mobile, 'password' => $request->password, 'user_status' => 1])) {

                return response()->json(['access_token'=>$jwtToken,'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,'login_flag' => 2,'user_data'=>Auth::user()]);
            } else {

                return response()->json(['error' =>  trans('message.message_invalid_login') , 'login_flag' => 0]);
            }
        }
    }
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => trans('message.message_logout')]);
    }

    public function tokenRefresh()
    {
        return response()->json([
            'access_token' => Auth::refresh(),
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);

    }

 public function getUserDetails()
    {

        return Auth::user();
    }
    public function getUserPermissionDetails()
    {

        return Auth::user()->getAllPermissions()->pluck('name');
    }
}
