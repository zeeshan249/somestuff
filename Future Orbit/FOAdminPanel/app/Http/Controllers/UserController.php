<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['validateLogin']]);
    }


public function getStaffAttendanceStatus(Request $request) {
        $centerId = $request->centerId;
        $loggedUserId = $request->loggedUserId;
        $roleId = $request->roleId;
        
        $getQuery = DB::table("lms_staff_attendance_details")
            ->where('lms_center_id', $centerId)
            ->where('lms_user_id', $loggedUserId)
            ->where('lms_staff_attendance_date', date('Y-m-d'))
            ->get();
        if ($getQuery->count() > 0) {
           
                   $result_data['responseData'] = $getQuery[0]->lms_staff_clock_out_status;

        } else {
              $result_data['responseData'] = "0";
        }
        return $result_data;
    }



    public function staffAttendance(Request $request) {
        $centerId = $request->centerId;
        $loggedUserId = $request->loggedUserId;
        $roleId = $request->roleId;
        $longitude=$request->longitude;
        $latitude=$request->latitude;

        $getQuery = DB::table("lms_staff_attendance_details")
            ->where('lms_center_id', $centerId)
            ->where('lms_user_id', $loggedUserId)
            ->where('lms_staff_attendance_date', date('Y-m-d'))
            ->get();
        if ($getQuery->count() > 0) {
             DB::table('lms_staff_attendance_details')
                ->where('lms_user_id', $loggedUserId)
                ->where('lms_center_id', $centerId)
                 ->where('lms_staff_attendance_date', date('Y-m-d'))
                ->update([
                    'lms_staff_clock_out_date' => now(),
                    'lms_staff_clock_out_status'=> 2,
                    'lms_staff_attendance_out_longitude' => $longitude,
                    'lms_staff_attendance_out_latitude'=>$latitude
                    
                ]);
                 $result_data['responseData'] = "1";
        } else {
            $saveQuery = DB::table('lms_staff_attendance_details')->insertGetId(
                [
                    'lms_center_id' => $centerId,
                    'lms_user_id' => $loggedUserId,
                    'role_id'=>$roleId,
                    'lms_staff_clock_out_status'=> 1,
                     'lms_staff_attendance_in_longitude' => $longitude,
                    'lms_staff_attendance_in_latitude'=>$latitude

                ]
            );
            if ($saveQuery > 0) {
                // Department Saved
                $result_data['responseData'] = "2";
            } else {
                // Failed to save Department
                $result_data['responseData'] = "3";
            }
        }

        //End
        return $result_data;
    }








    // To validate the user login with server side validation
    public function validateLogin(Request $request)
    {
        // Server Side validation
        $validation = Validator::make($request->all(), [
            'mobile' => 'bail | required |numeric ',
            'password' => 'bail | required ',
        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'login_flag' => 1]);
        } else {
            if ($jwtToken = Auth::attempt(['lms_user_mobile' => $request->mobile, 'password' => $request->password, 'lms_user_is_active' => 1, 'lms_center_id' => 1])) {

                // Login Success
                User::where('lms_user_id', Auth::user()->lms_user_id)
                    ->update([
                        'lms_user_last_login_date' => now(),
                    ]);

                if (Auth::user()->role_id == 1) {
                    //for student
                    //  return response()->json(['access_token'=>$jwtToken,'token_type' => 'bearer',
                    //                 'expires_in' => Auth::factory()->getTTL() * 60,'login_flag' => 2,'user_data'=>Auth::user()

                    //                 ]);

                } else {
                    // for staff
                    $getQuery = DB::table('lms_user')
                        ->leftJoin('lms_staff', 'lms_user.lms_user_id', '=', 'lms_staff.lms_user_id')
                        ->leftJoin('roles', 'lms_user.role_id', '=', 'roles.id')
                        ->where('lms_user.lms_user_mobile', '=', $request->mobile)
                        ->select([
                            'lms_user.lms_user_id',
                            'lms_user.role_id',
                            'lms_user.lms_user_mobile',
                            'lms_user.lms_user_is_migrated_to_firebase',
                            'lms_user.lms_user_can_change_profile_image',
                            DB::raw('DATE_FORMAT(lms_user.lms_user_created_at, "%d-%m-%Y") as lms_user_created_at', "%d-%m-%Y"),
                            'lms_user.lms_user_is_active',
                            'lms_user.lms_logout_user',
                            'lms_user.lms_user_firebase_id',
                            DB::raw('DATE_FORMAT(lms_user.lms_user_last_login_date, "%d-%m-%Y %H:%i") as lms_user_last_login_date', "%d-%m-%Y"),

                            'lms_staff.lms_staff_id',
                            'lms_staff.lms_staff_first_name',
                            'lms_staff.lms_staff_last_name',
                            'lms_staff.lms_staff_full_name',
                            'lms_staff.lms_staff_profile_image',

                            'roles.name',

                        ])
                        ->get();
                    return response()->json([
                        'access_token' => $jwtToken, 'token_type' => 'bearer',
                        'expires_in' => Auth::factory()->getTTL() * 6000, 'login_flag' => 2, 'user_data' => $getQuery,

                    ]);
                }
            } else {

                // Login Fail
                return response()->json(['error' => trans('label.label_invalid_login'), 'login_flag' => 0]);
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
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }

    // Logged user details with roles and permissions
    public function getLoggedUserDetailsWithRolesPermission()
    {
        $userRoles = Auth::user()->getRoleNames();
        $userPermissions = Auth::user()->getAllPermissions()->pluck('name');
        if (Auth::user()->role_id == 1) {
            //for student
            //  return response()->json(['access_token'=>$jwtToken,'token_type' => 'bearer',
            //                 'expires_in' => Auth::factory()->getTTL() * 60,'login_flag' => 2,'user_data'=>Auth::user()

            //                 ]);

        } else {
            // for staff
            $getQuery = DB::table('lms_user')
                ->leftJoin('lms_staff', 'lms_user.lms_user_id', '=', 'lms_staff.lms_user_id')
                ->where('lms_user.lms_user_mobile', '=', Auth::user()->lms_user_mobile)
                ->select([
                    'lms_user.lms_user_id',
                    'lms_user.role_id',
                    'lms_user.lms_user_mobile',
                    'lms_user.lms_user_is_migrated_to_firebase',
                    'lms_user.lms_user_can_change_profile_image',
                    DB::raw('DATE_FORMAT(lms_user.lms_user_created_at, "%d-%m-%Y") as lms_user_created_at', "%d-%m-%Y"),
                    'lms_user.lms_user_is_active',
                    'lms_user.lms_logout_user',
                    'lms_user.lms_user_firebase_id',

                    'lms_staff.lms_staff_id',
                    'lms_staff.lms_staff_first_name',
                    'lms_staff.lms_staff_last_name',
                    'lms_staff.lms_staff_full_name',
                    'lms_staff.lms_staff_profile_image',
                    'lms_staff.lms_staff_mobile_number',

                ])
                ->get();
        }
        return response()->json([
            'userData' => $getQuery, 'userRole' => $userRoles,
            'userPermission' => $userPermissions,
        ]);
    }

    //Enable Disable course
    public function loggedUserChangePassword(Request $request)
    {
        $centerId = $request->centerId;
        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $loggedUserId = $request->loggedUserId;
        $result = User::loggedUserChangePassword(
            $centerId,
            $oldPassword,
            $newPassword,
            $loggedUserId
        );
        return response()->json($result);
        //return $result;

    }
}
