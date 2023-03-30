<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['validateLogin']]);
    }
    // To validate the user login with server side validation
    public function validateLogin(Request $request)
    {
        // Server Side validation
        $validation = Validator::make($request->all(), [
            'mobile' => 'bail | required |numeric ',
            'password' => 'bail | required '
        ]);


        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'login_flag' => 1]);
        }

        else {
            if ($jwtToken=Auth::attempt(['lms_user_mobile' => $request->mobile, 'password' => $request->password, 'lms_user_is_active' => 1,'lms_center_id'=>1])) {

                // Login Success
                User::where('lms_user_id', Auth::user()->lms_user_id)
                ->update([
                    'lms_user_last_login_date' =>now()
                 ]);

                return response()->json(['access_token'=>$jwtToken,'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,'login_flag' => 2,'user_data'=>Auth::user()

                ]);
            } else {

                // Login Fail
                return response()->json(['error' =>  trans('label.label_invalid_login') , 'login_flag' => 0]);
            }
        }
    }
    //User Logout
    public function logout()
    {
        Auth::logout();

    }

    public function tokenRefresh()
    {
        return response()->json([
            'access_token' => Auth::refresh(),
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);

    }

    // Logged user details with roles and permissions
 public function getLoggedUserDetailsWithRolesPermission()
    {
        $userRoles= Auth::user()->getRoleNames();
        $userPermissions = Auth::user()->getAllPermissions()->pluck('name');
        return response()->json(['userData'=>Auth::user(),'userRole'=>$userRoles,
        'userPermission'=>$userPermissions
        ]);

    }

//Get All Active User _ Advocate without pagination
     public function getActiveAdvocatetWithoutPagination(Request $request)
     {
            return $getQuery = DB::select("select lms_user.lms_user_id, lms_user.lms_user_full_name,
            concat(lms_user.lms_user_id,' ',lms_user.lms_user_full_name) as AdvocateName
            from lms_user join model_has_roles
                    on lms_user.lms_user_id=model_has_roles.model_id
                    where model_has_roles.role_id=3 and lms_user.lms_user_is_active=1 order by lms_user.lms_user_full_name");
     }



}
