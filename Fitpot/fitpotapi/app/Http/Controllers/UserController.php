<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function Get(Request $request)
    {
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy= $request->searchText;
        $getQuery = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')


            ->select(  'roles.name as role','users.user_mobile','users.user_full_name' ,'users.user_email','users.user_age' ,'users.user_id' ,
            'users.user_height','users.user_weight','users.user_status',
          
            \DB::raw('(CASE

            WHEN users.is_subscribed = "1" THEN "Subscribed"

            WHEN users.is_subscribed = "0" THEN "Not Subscribed"

            END) AS is_subscribed'),
            DB::raw("(SELECT IFNULL((subscription_master.subscription_name),0) FROM subscription_master  where subscription_master.subscription_master_id=
            users.subscription_master_id  and subscription_master.subscription_master_status=1
   ) as subscription_type"),

                 )
                 ->where(function ($q) use ($filterBy) {
                    $q->where('users.user_full_name', 'like', "%$filterBy%")
                        ->orWhere('users.user_mobile', 'like', "%$filterBy%")
                        ->orWhere('users.user_email', 'like', "%$filterBy%");
                    
                    })
           
            ->
            orderBy('users.user_signup_date', 'DESC')
          ->paginate();


        return response()->json(['resultData' => $getQuery], 200);
        
    }
    public function getUserReport(Request $request){
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy= $request->searchText;
        $getQuery = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')


            ->select(  'roles.name as role','users.user_mobile','users.user_full_name' ,'users.user_email','users.user_age' ,'users.user_id' ,
            'users.user_height','users.user_weight',
            \DB::raw('(CASE

            WHEN users.user_status = "1" THEN "Active"

            WHEN users.user_status = "0" THEN "Inactive"

            END) AS user_status'),
            \DB::raw('(CASE

            WHEN users.is_subscribed = "1" THEN "Subscribed"

            WHEN users.is_subscribed = "0" THEN "Not Subscribed"

            END) AS is_subscribed'),
            DB::raw("(SELECT IFNULL((subscription_master.subscription_name),0) FROM subscription_master  where subscription_master.subscription_master_id=
            users.subscription_master_id  and subscription_master.subscription_master_status=1
   ) as subscription_type"),

                 )
                 ->where(function ($q) use ($filterBy) {
                    $q->where('users.user_full_name', 'like', "%$filterBy%")
                        ->orWhere('users.user_mobile', 'like', "%$filterBy%")
                        ->orWhere('users.user_email', 'like', "%$filterBy%");
                    
                    })
           
            ->
            orderBy('users.user_signup_date', 'DESC')
       ->paginate();


        return response()->json(['resultData' => $getQuery], 200);
    }
    public function Status(Request  $request)
    {
        $roleId = $request->user_id;
        $status = $request->user_status;

        $st = DB::table('users')->where('user_id', $roleId)
            ->update([
                'user_status' => $status,
            ]);
        if ($st) {

            return response()->json(['result' => "success",'message' => 'User  Status Changed successfully'], 200);
        }


    }
    public function  saveUsers(Request $request)
    {


        $roleId = $request->UserType;
        $mobile = $request->user_mobile;
        $password = random_int(100000, 999999);
        try {
        $insertedUserId = DB::table('users')->insertGetId(
            [
                'role_id' =>  $roleId,
                'user_mobile'=>$mobile,
                'password' => bcrypt($password),
                'password_normal' => $password,
                'user_email' => $request->user_email,
                'user_first_name' => ucfirst($request->user_first_name),
                'user_last_name' => ucfirst($request->user_last_name),
                'user_age' => $request->user_age,
                'user_weight' => $request->user_weight,
                'user_height' => $request->user_height,
                'user_gender'=>$request->user_gender,
                'user_profile_image'=>0,
                'user_device_type'=>$request->user_device_type,
                'is_subscribed'=>$request->is_subscribed,
                'question_id'=>$request->question_id,
                'question_answer'=>$request->question_answer,
                'bmi_score'=>$request->bmi_score,
                'device_id'=>$request->device_id,
                'user_full_name' => ucfirst($request->user_first_name) . ' ' . ucfirst($request->user_last_name),


            ]);
        if ($insertedUserId) {

            return response()->json(['result' => "success",'message' => 'User  Save Changed successfully'], 200);
        }
        } catch (Exception $ex) {

            DB::rollback();
            return response()->json(['result' => "error",'message' => 'Something Went Wrong'], 200);
        }

    }
    public function DeleteUsers(Request $request)
    {


        $deleteQuery = DB::table('users')
            ->where('user_id',  $request->user_id )->delete();
        if ($deleteQuery > 0) {

            return response()->json(['success' => "true",'message' => 'User Deleted'], 200);
        }
    }
    public function updateUsers(Request $request){



            $roleId = $request->UserType;
            $mobile = $request->user_mobile;
            $password = random_int(100000, 999999);
            try {
                $insertedUserId = DB::table('users')->where('user_id',$request->user_id)
                    ->update([

                        'role_id' =>  $roleId,
                        'user_mobile'=>$mobile,
                        'password' => bcrypt($password),
                        'password_normal' => $password,
                        'user_email' => $request->user_email,
                        'user_first_name' => ucfirst($request->user_first_name),
                        'user_last_name' => ucfirst($request->user_last_name),
                        'user_age' => $request->user_age,
                        'user_weight' => $request->user_weight,
                        'user_height' => $request->user_height,
                        'user_gender'=>$request->user_gender,
                        'user_profile_image'=>0,
                        'user_device_type'=>$request->user_device_type,
                        'is_subscribed'=>$request->is_subscribed,
                        'question_id'=>$request->question_id,
                        'question_answer'=>$request->question_answer,
                        'bmi_score'=>$request->bmi_score,
                        'device_id'=>$request->device_id,
                        'user_full_name' => ucfirst($request->user_first_name) . ' ' . ucfirst($request->user_last_name),


                    ]);
                if ($insertedUserId) {

                    return response()->json(['result' => "success",'message' => 'User  Save Changed successfully'], 200);
                }
            } catch (Exception $ex) {

                DB::rollback();
                return response()->json(['result' => "error",'message' => 'Something Went Wrong'], 200);
            }

        }

        public function getAllPermissions(Request  $request){
            $itemsPerPage = $request->itemsPerPage;
            $sortColumn = $request->sortColumn;
            $sortOrder = $request->sortOrder;
            $searchText = $request->searchText;
            $getQuery = DB::table('permissions')



                ->select(  '*' )
                ->where('name', 'like', '%' . $searchText . '%')->
                orderBy($sortColumn, $sortOrder)
                ->paginate($itemsPerPage);


            return response()->json(['resultData' => $getQuery], 200);
        }

    public function savePermissions(Request  $request)

    {
  try {
      $insertedUserId = DB::table('permissions')->insertGetId(
          [

              'name'=>$request->name,
              'guard_name' => 'api',
              'module_name'=>'Roles & Permissions'
          ]);
      if ($insertedUserId) {

          return response()->json(['result' => "success",'message' => 'Permission Updated'], 200);
      }
  } catch (Exception $ex) {

      DB::rollback();
      return response()->json(['result' => "error",'message' => 'Something Went Wrong'], 200);
  }



    }
    public function deletePermissions(Request $request){
        $id = $request->id;
        $deleteQuery = DB::table('permissions')->where('id', $id)->delete();
        if ($deleteQuery > 0) {

            return response()->json(['success'=>'true','message' => 'Permission Removed'], 200);
        }
    }
    public function  updatePermissions(Request $request){
        $updateQuery = DB::table('permissions')
            ->where('id',$request->id)
            ->update([
                'name' => $request->name,


            ]);
        if ($updateQuery > 0) {

            return response()->json(['result' => 'success','message' => 'Permission Updated'], 200);
        }
    }

    public function subscribeduserdetails(Request $request)
    {
        $filterBy= $request->searchText;
     $getQuery=DB::table('user_subscription_mapping')
     ->join('subscription_master', 'subscription_master.subscription_master_id', '=', 'user_subscription_mapping.subscription_master_id')
     ->join('wallet_history', 'wallet_history.wallet_history_id', '=', 'user_subscription_mapping.wallet_history_id')
     ->join('users', 'users.user_id', '=', 'user_subscription_mapping.user_id')
     
     
     ->select('user_subscription_mapping.subscription_mapping_id','users.user_mobile','users.user_full_name','subscription_master.subscription_name',
     'wallet_history.wallet_description','wallet_history.wallet_balance_added_deducted_amount',
     
     DB::raw('DATE_FORMAT(user_subscription_mapping.subscription_mapping_date, "%d-%m-%Y") as subscription_start_date', "%d-%m-%Y"),
     DB::raw('DATE_FORMAT(user_subscription_mapping.subscription_mapping_expiry_date, "%d-%m-%Y") as subscription_end_date', "%d-%m-%Y"),
     DB::raw('DATE_FORMAT(wallet_history.wallet_history_date, "%d-%m-%Y") as subscribed_date', "%d-%m-%Y"),
     )
     ->where(function ($q) use ($filterBy) {
        $q->where('users.user_full_name', 'like', "%$filterBy%")
            ->orWhere('users.user_mobile', 'like', "%$filterBy%")
            ->orWhere('subscription_master.subscription_name', 'like', "%$filterBy%")
            ->orWhere('users.user_email', 'like', "%$filterBy%");
        
        })
     ->where('user_subscription_mapping.subscription_mapping_status',1)
     ->orderBy('wallet_history.wallet_history_date','DESC')
     ->paginate();
     return response()->json(['resultData' => $getQuery], 200);
    }


    public function webGetUserWiseComepetitionReport(Request $request)
    {
        $filterBy= $request->searchText;
     $getQuery=DB::table('user_comp_mapping')
     ->join('competition_schedule', 'competition_schedule.comp_schedule_id', '=', 'user_comp_mapping.comp_schedule_id')
     ->join('users', 'users.user_id', '=', 'user_comp_mapping.user_id')
     ->join('competition_master', 'competition_master.comp_master_id', '=', 'competition_schedule.comp_master_id')
     
     ->select('competition_master.comp_master_name','users.user_mobile','users.user_full_name','competition_master.comp_master_total_km',
     
     DB::raw('DATE_FORMAT(user_comp_mapping.comp_schedule_start_date, "%d-%m-%Y") as comp_schedule_start_date', "%d-%m-%Y"),
     DB::raw('DATE_FORMAT(user_comp_mapping.comp_schedule_end_date, "%d-%m-%Y") as comp_schedule_end_date', "%d-%m-%Y"),
    
     )
     ->where(function ($q) use ($filterBy) {
        $q->where('users.user_full_name', 'like', "%$filterBy%")
            ->orWhere('users.user_mobile', 'like', "%$filterBy%")
            ->orWhere('users.user_mobile', 'like', "%$filterBy%")
            ->orWhere('competition_master.comp_master_name', 'like', "%$filterBy%");
        
        })
     ->where('user_comp_mapping.comp_mapping_status',1)
   
     ->paginate();
     return response()->json(['resultData' => $getQuery], 200);
    }

    public function webGetRolesWithoutPagination(Request $request){
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $searchText = $request->searchText;


        $getQuery = DB::table("roles")->select(['id', 'name', DB::raw("IF(is_role_active = 1, 'Active','Inactive')as is_role_active")])

          ->where('roles.is_role_active',1)
        ->get();
        return response()->json(['resultData' =>  $getQuery], 200);

    }

    public function webGetDeviceDataReport(Request $request){
        $data=[];
        $dateFrom=$request->from_date;
        $dateTo=$request->to_date;
        $user_id=$request->user_id;
        $calorie = DB::table('user_fitness_calorie')
        ->select(DB::raw("SUM(calorie_burnt) as total_calorie_burnt"))
        ->where('user_id', $user_id)
        ->where('sync_date', '>=',$dateFrom)
        ->where('sync_date','<=', $dateTo)
        ->first();

        $distance = DB::table('user_fitness_distance')
        ->select(DB::raw("SUM(distance_covered) as total_distance"))
        ->where('user_id', $user_id)
        ->where('sync_date', '>=',$dateFrom)
        ->where('sync_date','<=', $dateTo)
        ->first();

    
        $step = DB::table('user_fitness_step')
        ->select(DB::raw("SUM(step_covered) as total_step"))
        ->where('user_id', $user_id)
        ->where('sync_date', '>=',$dateFrom)
        ->where('sync_date','<=', $dateTo)
        ->first();
     
    
        

   
            array_push($data, [
                
                'total_calorie_burnt' => ceil($calorie->total_calorie_burnt),
                'total_distance' =>   ceil($distance->total_distance),
                'total_user_fitness_step' =>   ceil( $step->total_step),
                'total'=>1
            ]);
     
       
 
      
        return response()->json(['resultData' =>  $data], 200);  
    }

    public function webGetUserWithoutPagination(){
        $user=DB::table('users')->select('users.user_id','users.user_full_name')
        ->where('users.user_status',1)
        ->get();
        return response()->json(['resultData' =>  $user], 200);  
    }
    
}
