<?php

namespace App\Http\Controllers;

use App\EmailSettingModel;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class SystemSettingsController extends Controller
{
    public function __construct()
    {
    }
    // Check Role in DB and then Save
    public function saveRole(Request $request)
    {
        // Server side validation rules
        $validation = Validator::make($request->all(), [
            'centerId' => 'bail | required |numeric ',
            'roleName' => ['bail', 'required', 'regex:/^[a-zA-Z ]+$/'],
        ]);

        if ($validation->fails()) {

            // Server side validation fails
            return response()->json(['error' => $validation->errors()->first(), 'responseData' => 0]);
        } else {
            $centerId = $request->centerId;
            $roleName = trim($request->roleName);
            $isSaveEditClicked = $request->isSaveEditClicked;
            $roleId = $request->roleId;

            if ($isSaveEditClicked == 1) {
                // If save role is clicked
                $getRoleNameCenterWiseQuery = DB::table("roles")->where('lms_center_id', $centerId)->where('name', $roleName)
                    ->get();
                if ($getRoleNameCenterWiseQuery->count() > 0) {
                    // Role Exists
                    return response()->json(['responseData' => 1]);
                } else {
                    $saveRoleNameQuery = DB::table('roles')->insertGetId(
                        [
                            'lms_center_id' => $centerId,
                            'name' => $roleName,

                        ]
                    );
                    if ($saveRoleNameQuery > 0) {
                        // Role Saved
                        return response()->json(['responseData' => 2]);
                    } else {
                        // Failed to save role
                        return response()->json(['responseData' => 3]);
                    }
                }
            } else {
                $updateRole = DB::table('roles')
                    ->where('id', $roleId)
                    ->where('lms_center_id', $centerId)
                    ->update([
                        'name' => $roleName,
                        'updated_at' => now(),

                    ]);
                if ($updateRole > 0) {

                    return response()->json(['responseData' => 4]);
                } else {
                    return response()->json(['responseData' => 5]);
                }
            }
        }
    }

    //Get the Roles
    public function getAllRoles(Request $request)
    {
        $active = [];
        $includeDelete = $request->includeDelete;
        if ($includeDelete == "false") {
            $active = [1];
        } else {
            $active = [1, 0];
        }
        $centerId = $request->centerId;
        $perPage = $request->perPage ? $request->perPage : 50;
        $sortBy = $request->sortBy;
        $orderBy = $request->orderBy;

        $getAllRole = DB::table("roles")
            ->select(['id', 'name', DB::raw("IF(is_role_active = 1, 'Active','Inactive')as is_role_active")])
            ->whereIn('is_role_active', $active)

            ->orderBy($sortBy, $orderBy)->where('lms_center_id', $centerId)
            ->paginate($perPage);


        return $getAllRole;
    }
    //Update Role
    public function updateRole(Request $request)
    {
        $centerId = $request->centerId;
        $roleName = $request->roleName;
        $roleId = $request->roleId;
        $isRoleActive = $request->isRoleActive;
        $updateRole = DB::table('roles')
            ->where('id', $roleId)
            ->where('lms_center_id', $centerId)
            ->update([
                'name' => $roleName,
                'is_role_active' => $isRoleActive,
                'updated_at' => now(),

            ]);
        if ($updateRole > 0) {

            return response()->json(['responseData' => 1]);
        } else {
            return response()->json(['responseData' => 2]);
        }
    }

    // Get Role wise permission
    public function getAssignedUnAssignedPermissionRoleWise(Request $request)
    {
        $centerId = $request->centerId;
        $roleId = $request->roleId;
        return $getPermissionRoleWise = DB::select("select permissions.id as permission_id,permissions.name as permission_name,
        permissions.lms_module_name as Module,if(role_has_permissions.role_id is null,0,1) as is_permission_assigned
         from permissions left join role_has_permissions
        on permissions.id=role_has_permissions.permission_id and role_has_permissions.role_id=$roleId
        where permissions.lms_center_id=$centerId");
    }

    // Assign Permission Role Wise
    public function assignPermissionRoleWise(Request $request)
    {
        $roleId = $request->roleId;
        $permissionId = $request->permissionId;

        $exception = DB::transaction(function () use ($roleId, $permissionId) {

            DB::table('role_has_permissions')->where('role_id', $roleId)->delete();
            for ($x = 0; $x < count($permissionId); $x++) {

                DB::table('role_has_permissions')->updateOrInsert(
                    [
                        'role_id' => $roleId, 'permission_id' => $permissionId[$x]

                    ],
                    [
                        'permission_id' => $permissionId[$x],
                        'role_id' => $roleId,

                    ]
                );
            }
        });

        if (is_null($exception)) {
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            return response()->json(['responseData' => 1]);
        } else {
            return response()->json(['responseData' => 2]);
        }
    }


    // Assign Permission Role Wise
    public function assignIndividualPermissionRoleWise(Request $request)
    {
        $roleId = $request->roleId;
        $permissionId = $request->permissionId;
        $is_permission_assigned = $request->is_permission_assigned;

        $exception = DB::transaction(function () use ($roleId, $permissionId, $is_permission_assigned) {

            if ($is_permission_assigned == false) {
                DB::table('role_has_permissions')
                    ->where('role_id', $roleId)
                    ->where('permission_id', $permissionId)
                    ->delete();
            } else {
                DB::table('role_has_permissions')->updateOrInsert(
                    [
                        'role_id' => $roleId, 'permission_id' => $permissionId

                    ],
                    [
                        'permission_id' => $permissionId,
                        'role_id' => $roleId,

                    ]
                );
            }
        });

        if (is_null($exception)) {
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            return response()->json(['responseData' => 1]);
        } else {
            return response()->json(['responseData' => 2]);
        }
    }

    //Get All Active Roles without pagination
    public function getAllActiveRolesWithoutPagination(Request $request)
    {
        $centerId = $request->centerId;

        $getQuery = DB::table("roles")->select(['id', 'name'])
            ->where('is_role_active', 1)
            ->where('lms_center_id', $centerId)
            ->get();
        return $getQuery;
    }



    //Get All Active Roles without pagination
    public function getAllActiveSourcesWithoutPagination(Request $request)
    {
        $centerId = $request->centerId;

        $getQuery = DB::table("lms_information_source")->select(['lms_information_source_id', 'lms_information_source_name'])
            ->where('is_lms_information_source_active', 1)
            ->where('lms_center_id', $centerId)
            ->get();
        return $getQuery;
    }


    //Get All Active School without pagination
    public function web_get_active_school_without_pagination(Request $request)
    {
        $centerId = $request->centerId;

        $getQuery = DB::table("lms_school_list")->select(['lms_school_id', 'lms_school_name'])
            ->where('is_lms_school_active', 1)
            ->where('lms_center_id', $centerId)
            ->get();
        return $getQuery;
    }

    //Get All Active Course without pagination
    public function getActiveTopicBasedOnSubject(Request $request)
    {
        $centerId = $request->centerId;
        $selectedSubjectId = $request->selectedSubjectId;


        $getQuery = DB::table("lms_topic")->select(['lms_topic_id', 'lms_topic_name'])
            ->where('lms_subject_id', $selectedSubjectId)
            ->where('lms_topic_is_active', 1)
            ->where('lms_center_id', $centerId)
            ->get();
        return $getQuery;
    }
}
