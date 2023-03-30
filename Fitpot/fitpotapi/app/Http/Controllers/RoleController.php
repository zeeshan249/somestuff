<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class RoleController extends Controller
{
        // get all roles

        public function webValidateLogin(Request $request)
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


        public function webGetRoles(Request $request)
        {
            try
            {
                $itemsPerPage = $request->itemsPerPage;
                $sortColumn = $request->sortColumn;
                $sortOrder = $request->sortOrder;
                $searchText = $request->searchText;
    
                $getQuery = DB::table("roles")->
                    select(['id', 'name',  'is_role_active'])
    
                    ->where('name', 'like', '%' . $searchText . '%')->
                    orderBy($sortColumn, $sortOrder)
                    ->paginate($itemsPerPage);
                return response()->json(['result' => "success", 'resultData' => $getQuery]);
    
            } catch (Exception $ex) {
    
                return response()->json(['result' => "exception", 'message' => 'Something went wrong']);
            }
        }
    
        public function webGetRolesWithoutPagination(Request $request)
        {
            try
            {
    
    
                $getQuery = DB::table("roles")->
                select(['id', 'name',  'is_role_active'])
    
                    ->where('is_role_active',1)
                    ->get();
    
                return response()->json(['result' => "success", 'resultData' => $getQuery]);
    
            } catch (Exception $ex) {
    
                return response()->json(['result' => "exception", 'message' => 'Something went wrong']);
            }
        }
        //save Role
        public function webSaveRoles(Request $request)
        {
    
            try
            {
                $roleName = trim($request->roleName);
                $saveQuery = DB::table('roles')->insertGetId(
                    [
                         'name' => $roleName,
    
                    ]
                );
                if ($saveQuery > 0) {
                    return response()->json(['result' => "success", 'message' => 'Role saved successfully']);
    
                } else {
    
                    return response()->json(['result' => "error", 'message' => 'Something went wrong']);
    
                }
    
            } catch (Exception $ex) {
    
                return response()->json(['result' => "exception", 'message' => 'Something went wrong']);
            }
    
        }
    
        //Update Role
        public function webUpdateRoles(Request $request)
        {
    
            try
            {
                $roleName = $request->roleName;
                $roleId = $request->id;
    
                $updateQuery = DB::table('roles')
                    ->where('id', $roleId)
                    ->update([
                        'name' => $roleName,
    
                        'updated_at' => now(),
    
                    ]);
                if ($updateQuery > 0) {
    
                    return response()->json(['result' => "success", 'message' => 'Role updated successfully']);
    
                } else {
                    return response()->json(['result' => "error", 'message' => 'Something went wrong']);
    
                }
    
            } catch (Exception $ex) {
    
                return response()->json(['result' => "exception", 'message' => 'Something went wrong']);
            }
    
        }
    
        //Delete Role
        public function webDeleteRoles(Request $request)
        {
    
            try
            {
    
                $roleId = $request->id;
                $deleteQuery = DB::table('roles')->where('id', $roleId)->delete();
    
                if ($deleteQuery > 0) {
    
                    return response()->json(['result' => "success", 'message' => 'Role deleted successfully']);
    
                } else {
                    return response()->json(['result' => "error", 'message' => 'Something went wrong']);
    
                }
    
            } catch (Exception $ex) {
    
                return response()->json(['result' => "exception", 'message' => 'Something went wrong']);
            }
    
        }
        public function Status(Request  $request)
        {
            $roleId = $request->id;
            $status = $request->is_role_active;
    
            $st = DB::table('roles')->where('id', $roleId)
                ->update([
                    'is_role_active' => $status,
                ]);
            if ($st) {
    
                return response()->json(['result' => "success",'message' => 'Role  Status Changed successfully'], 200);
            }
    
    
        }


          // Logged user details with roles and permissions
    public function webGetLoggedUserDetailsWithRolesPermission()
    {

        try {
            $userRoles = Auth::user()->getRoleNames();
            $userPermissions = Auth::user()->getAllPermissions()->pluck('name');
            $userData['user_first_name'] = Auth::user()->user_first_name;
            $userData['user_last_name'] = Auth::user()->user_last_name;
            $userData['user_full_name'] = Auth::user()->user_full_name;
            $userData['user_profile_image'] = Auth::user()->user_profile_image;

            return response()->json(['result' => 'success', 'userData' => $userData, 'userRole' => $userRoles,
                'userPermission' => $userPermissions]);

        } catch (Exception $ex) {

            return response()->json(['result' => "exception", 'message' => 'Something went wrong']);
        }

    }

    // Logout
    public function webLogout()
    {
        try {

            Auth::user()->tokens()->delete();
            return response()->json(['result' => 'success', 'message' => 'Logged out succesfully']);

        } catch (Exception $ex) {

            return response()->json(['result' => "exception", 'message' => 'Something went wrong']);
        }

    }


}
