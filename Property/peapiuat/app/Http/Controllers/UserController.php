<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public $Namex = "User";

    // get all user_skills
    public function Get(Request $request)
    {

       $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;
        
        $rolecheck=DB::table("users")
        ->join('roles','roles.id','=','users.role_id')
        ->select('roles.name','roles.id')
        ->where('users.user_id',$request->loggedInUserID)
        ->first();
        

        $getQuery = DB::table("users")
        ->join('user_details', 'user_details.user_id', '=', 'users.user_id')

        //            ->join('subdivisions','subdivisions.subdivision_id','=','user_details.subdivision_id')
        //            ->join('town','town.town_id','=','user_details.town_id')
        //            ->join('province','province.province_id','=','user_details.province_id')
        //            ->join('barangay','barangay.barangay_id','=','user_details.barangay_id')
                    ->join('roles','roles.id','=','users.role_id')
        ->select(['users.role_id','users.user_id','users.user_email','users.user_status','user_details.first_name','user_details.last_name'
            ,'users.full_name','user_details.nick_name','user_details.user_details_id','user_details.phone_1','user_details.phone_2'
            ,'user_details.birth_month','user_details.birth_day','user_details.website','user_details.open_property_limit'
            ,"user_details.user_id","user_details.active_user_date_limit","user_details.active_user_date_limit","user_details.is_address_same_as_agency"
            ,"user_details.unit_number","user_details.house_number","user_details.street_name","user_details.building_name","user_details.subdivision_id"
            ,"user_details.barangay_id" ,"user_details.town_id","user_details.province_id","user_details.zip_code"

            ,'user_details.floor','user_details.re_license','user_details.profile_statement','user_details.self_broker','user_details.associated_broker_id'
            ,'user_details.user_skills','user_details.user_skills as user_skills_id'

            ,'user_details.associated_agency_id','user_details.agent_photo','user_details.isFeatured','user_details.address','user_details.year'
            ,'user_details.user_description','roles.name as role_name','user_details.is_address_same_as_agency'
                 ])

            ->where(function ($q) use ($filterBy) {

                $q  ->orWhere('users.user_email', 'like', "%$filterBy%")
                    ->orwhere('users.full_name', 'like', "%$filterBy%");

            })
            ->where(function ($q) use ($rolecheck) {
                if($rolecheck->id!=1){
                    $q  ->whereIn('users.role_id', [3,4,26,30]);
                }
                if($rolecheck->id!=1 && $rolecheck->id==26){
                    $q  ->whereIn('users.role_id', [4,26,30]);
                }
                else{
                    $q->whereIn('users.role_id', [1,3,4,26,30]);      
                }
            })
            ->whereIn('users.user_status',['Active','Inactive'])
            ->where('users.user_id','!=',$request->loggedInUserID)
//            ->where('users.user_status','Inactive')
            ->orderBy($sortColumn, $sortOrder)
           // ->orderBy($sortColumn=="role_name"?'roles.name':($sortColumn=="phone_1"?'user_details.phone_1':$sortColumn), $sortOrder)
            ->paginate($itemsPerPage);
        return response()->json(['resultData' => $getQuery], 200);
    }

    public function GetNewUser(Request $request)
    {

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;

        $getQuery = DB::table("users")->select(['users.role_id','users.user_id','users.user_email','users.user_status','user_details.first_name','user_details.last_name'
            ,'users.full_name','user_details.nick_name','user_details.user_details_id','user_details.phone_1','user_details.phone_2'
            ,'user_details.birth_month','user_details.birth_day','user_details.website','user_details.open_property_limit'
            ,"user_details.user_id","user_details.active_user_date_limit","user_details.active_user_date_limit","user_details.is_address_same_as_agency"
            ,"user_details.unit_number","user_details.house_number","user_details.street_name","user_details.building_name","user_details.subdivision_id"
            ,"user_details.barangay_id" ,"user_details.town_id","user_details.province_id","user_details.zip_code"
            ,'user_details.floor','user_details.re_license','user_details.profile_statement','user_details.self_broker','user_details.associated_broker_id'
            ,'user_details.user_skills','user_details.user_skills as user_skills_id'

            ,'user_details.associated_agency_id','user_details.agent_photo','user_details.isFeatured','user_details.address','user_details.year'
            ,'user_details.user_description','roles.name as role_name'
                 ])
            ->join('user_details', 'user_details.user_id', '=', 'users.user_id')

//            ->join('subdivisions','subdivisions.subdivision_id','=','user_details.subdivision_id')
//            ->join('town','town.town_id','=','user_details.town_id')
//            ->join('province','province.province_id','=','user_details.province_id')
//            ->join('barangay','barangay.barangay_id','=','user_details.barangay_id')
            ->join('roles','roles.id','=','users.role_id')
            ->where(function ($q) use ($filterBy) {

                $q  ->orWhere('users.user_email', 'like', "%$filterBy%")
                    ->orwhere('users.full_name', 'like', "%$filterBy%");

            })
            ->whereIn('users.user_status',['New','Inactive'])
//            ->where('users.user_status','Inactive')
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);
        return response()->json(['resultData' => $getQuery], 200);
    }
    //save user_skills
    public function Save(Request $request)
    {
          
        $UserType = $request->UserType;
        $AssociatedAgency = $request->AssociatedAgency;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $nickName = $request->nickName;
        $selectDate = $request->selectDate;
        $sameAsAgency = $request->sameAsAgency;
        $unitNumber = $request->unitNumber;
        $houseLotNumber = $request->houseLotNumber;
        $streetName = $request->streetName;
        $propertyBuildingName = $request->propertyBuildingName;
        $subdivision = $request->subdivision;
        $barangay = $request->barangay;
        $town = $request->town;
        $province = $request->province;
        $zipCode = $request->zipCode;
        $floorLevel = $request->floorLevel;
        $subdivision = $request->subdivision;
        // $selectBirthDay = $request->selectBirthDay;
        // $selectBirthMonth = $request->selectBirthMonth;
        $rELicence = $request->rELicence;
        $userWebsite = $request->userWebsite;
        $userSkills = $request->userSkills;
        $profileStatement = $request->profileStatement;
        $selfBroker = $request->selfBroker;
        $associatedBroker = $request->associatedBroker;
        $reasonInactive = $request->reasonInactive;
        $inactiveUser = $request->inactiveUser;
        $created_by = $request->created_by;
        $phone1 = $request->phone1;
        $phone2 = $request->phone2;
        $openPropertyLimit = $request->openPropertyLimit;
        $activeUserDateLimit = $request->activeUserDateLimit;
        $email = $request->email;
        $user_info=$request->user_info;
        $otp_role='';
        
        $duplicateMail=DB::table('users')->where('users.user_email',$request->email)->count();
        if ($duplicateMail>0) {
            return response()->json(['message' => 'Email Already Present In the System'], 200);
        }
        else{

        try {
 
            DB::beginTransaction();
            
        
            $rolecheck=DB::table('roles')
                       ->select('roles.name','roles.id')->where('id',$UserType)->first();
                      
            if($rolecheck->name!="Super Admin"){
                $otp_role=$rolecheck->name;
            }
            else{
                $otp_role='Super Admin';
            }
            $password = random_int(100000, 999999);
            $fourRandomDigit = mt_rand(1000,9999);
            
            $insertedUserId = DB::table('users')->insertGetId(
                [
                    'role_id' => $UserType,
                    'password' => bcrypt($password),
                    'password_normal' => $password,
                    'user_email' => $email,
                    'first_name' => ucfirst($firstName),
                    'last_name' => ucfirst($lastName),
                    'full_name' => ucfirst($firstName) . ' ' . ucfirst($lastName),
                    'created_by' => $created_by,
                    'slug' => Str::slug(ucfirst($firstName) . ' ' . ucfirst($lastName)).time(),
                    'otp'=>$otp_role=='Super Admin'?$fourRandomDigit:'',
                    'is_otp_verified'=>$otp_role=='Super Admin'?0:'',
                ]);

            DB::table('user_details')->insertGetId(
                [
                    'user_id' => $insertedUserId,
                    'first_name' => ucfirst($firstName),
                    'last_name' => ucfirst($lastName),
                    'nick_name' => $nickName,
                    'phone_1' => $phone1,
                    'phone_2' => $phone2,
                    'website' => $userWebsite,
                    'user_skills' => $userSkills,
                    'open_property_limit' => $openPropertyLimit,
                    'active_user_date_limit' => $activeUserDateLimit,
                    'is_address_same_as_agency' => $sameAsAgency,
                    'unit_number' => $unitNumber,
                    'house_number' => $houseLotNumber,
                    'street_name' => $streetName,
                    'building_name' => $propertyBuildingName,
                    'subdivision_id' => $subdivision,
                    'barangay_id' => $barangay,
                    'town_id' => $town,
                    'province_id' => $province,
                    'zip_code' => $zipCode,
                    'floor' => $floorLevel,
                    're_license' => $rELicence,
                    'profile_statement' => $profileStatement,
                    'self_broker' => $selfBroker,
                    'associated_broker_id' => $associatedBroker,
                    'associated_agency_id' => $AssociatedAgency,

                ]);
            DB::table('user_tracking')->insertGetId(
                [
                    'user_id' => $insertedUserId,
                    'date_active' => now(),
                    'user_who_activated' => $created_by,

                ]);
          DB::table('notification')->insertGetId([
                'notification_type_id' => 2,
                'notification_subject' => 'One New User Created',
                'user_id' => $request->created_by,
            ]);
            DB::table('model_has_roles')->insertGetId([
                'role_id'=>$UserType,
                'model_id'=>$insertedUserId,
             ]);
            if($rolecheck->name=="Super Admin"){
                $mail_user=DB::table('users')
                ->where('users.user_id',$insertedUserId)
                ->select('users.user_email')
                ->first();
                $mailto=$mail_user->user_email;
         
       \Mail::send('mail.otp', ['email' =>$email,'otp'=>$fourRandomDigit,'password'=>$password], function($message) use($request,$mailto){
   
           $message->to($mailto);
           $message->from("syed@gmail.com");
           $message->subject('Otp details');
       });
           }
           else{
           
       
            \Mail::send('mail.userdetails', ['email' =>$email,'otp'=>$fourRandomDigit,'password'=>$password], function($message) use($request,$email){
                $message->to($email);
                $message->from("syed@gmail.com");
                $message->subject('Login Details');
            });
           }
            DB::commit();
            return response()->json(['message' => 'User saved successfully please check your Email for password and more details'], 200);

        } catch (Exception $ex) {

            DB::rollback();

        }
    }

    }



    public function Status(Request  $request)
    {
        $status = $request->status;
        $user_id = $request->user_id;

        $st = DB::table('users')
            ->where('user_id', $user_id )
            ->update([
                'user_status' => $status,
            ]);
        if ($st) {
            return response()->json(['success'=>'true','message' => ' Status Changed successfully'], 200);
        }
        else{
            return response()->json(['success'=>'false','message' => ' Status Not Changed successfully'], 200);
        }
    }

    public function WebVerifyOTP(Request $request){
        $status = $request->status;
        $user_id = $request->user_id;
        $role_id=$request->role_id;
        $status=DB::table('users')->where('user_id',$request->user_id)->first();
        if($request->verify_otp == $status->otp){
            DB::table('users')
            ->where('user_id', $user_id )
            ->update([
                'user_status' => 'Active',
                'is_otp_verified'=>1
            ]);
            return response()->json(['result'=>'success','message' => ' OTP verified successfully'], 200);
        }
        else{
            return response()->json(['result'=>'error','message' => ' OTP Not Match'], 200);
        }

    }
    //Update user_skills
   public function Update(Request $request)
    {

        $UserType = $request->UserType;
        $AssociatedAgency = $request->AssociatedAgency;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $nickName = $request->nickName;
        $selectDate = $request->selectDate;
        $sameAsAgency = $request->sameAsAgency;
        $unitNumber = $request->unitNumber;
        $houseLotNumber = $request->houseLotNumber;
        $streetName = $request->streetName;
        $propertyBuildingName = $request->propertyBuildingName;
        $subdivision = $request->subdivision;
        $barangay = $request->barangay;
        $town = $request->town;
        $province = $request->province;
        $zipCode = $request->zipCode;
        $floorLevel = $request->floorLevel;
        $subdivision = $request->subdivision;
        // $selectBirthDay = $request->selectBirthDay;
        // $selectBirthMonth = $request->selectBirthMonth;
        $rELicence = $request->rELicence;
        $userWebsite = $request->userWebsite;
        $userSkills = $request->userSkills;
        $profileStatement = $request->profileStatement;
        $selfBroker = $request->selfBroker;
        $associatedBroker = $request->associatedBroker;
        $reasonInactive = $request->reasonInactive;
        $inactiveUser = $request->inactiveUser;
        $created_by = $request->created_by;
        $phone1 = $request->phone1;
        $phone2 = $request->phone2;
        $openPropertyLimit = $request->openPropertyLimit;
        $activeUserDateLimit = $request->activeUserDateLimit;
        $email = $request->email;
        $status=$request->status;


        try {
//  user active inactive section in edit user
            DB::beginTransaction();
         
            $currentbroker=DB::table('user_details')->select('user_details.associated_broker_id')
            ->join('users','users.user_id','user_details.user_id')
            ->where('user_details.user_id',$request->user_id)
            ->where('users.role_id',26)
            ->first();
      



            $insertedUserId = DB::table('users')->where('user_id',$request->user_id)
                ->update (  [


                    'role_id' => $UserType,
                    'user_email' => $email,
                    'first_name' => ucfirst($firstName),
                    'last_name' => ucfirst($lastName),
                    'full_name' => ucfirst($firstName) . ' ' . ucfirst($lastName),
                    'created_by' => $created_by,
                    'slug' => Str::slug(ucfirst($firstName) . ' ' . ucfirst($lastName)),
                    'user_status'=>$request->inactiveUser
                ]);
           
           $userdetails=  DB::table('user_details')->where('user_id',$request->user_id)
                ->update ([

                    'first_name' => ucfirst($firstName),
                    'last_name' => ucfirst($lastName),
                    'nick_name' => $nickName,
                    'phone_1' => $phone1,
                    'phone_2' => $phone2,
                    'website' => $userWebsite,
                    'user_skills' => $userSkills,
                    'open_property_limit' => $openPropertyLimit,
                    'active_user_date_limit' => $activeUserDateLimit,
                    'is_address_same_as_agency' => $sameAsAgency,
                    'unit_number' => $unitNumber,
                    'house_number' => $houseLotNumber,
                    'street_name' => $streetName,
                    'building_name' => $propertyBuildingName,
                    'subdivision_id' => $subdivision,
                    'barangay_id' => $barangay,
                    'town_id' => $town,
                    'province_id' => $province,
                    'zip_code' => $zipCode,
                    'floor' => $floorLevel,
                    're_license' => $rELicence,
                    'profile_statement' => $profileStatement,
                    'self_broker' => $selfBroker,
                    'associated_broker_id' => $associatedBroker,
                    'associated_agency_id' => $AssociatedAgency,

                ]);
            DB::table('user_tracking')->insertGetId(
                [
                    'user_id'=>$request->user_id,
                    'date_active' =>$inactiveUser=='Active'?now():null,
                    'date_inactive'=>$inactiveUser=='Inactive'?now():null,
                    'user_who_activated' => $request->user_id,
                    'user_who_deactivated'=> $request->user_id,
                    'reason_inactive'=>$request->reasonInactive,
                ]);
                if($currentbroker->associated_broker_id != $associatedBroker){
            
                    \Mail::send('mail.addproperty', ["data1"=>''], function($message) use($request){
                        $message->to("zeeshan.mymail@gmail.com");
                        $message->from("syed@gmail.com");
                        $message->subject('Agent Details Broker is Modified');
                    });
    
                    $savenotification = DB::table('notification')->insertGetId([
                        'notification_type_id' => 11,
                        'notification_subject' => 'Agent Details A Broker is  Modified For Agent '.$request->firstName .' '.$request->lastName,
                        'user_id' => $request->updated_by,
                       ]);
                }
            DB::commit();
            return response()->json(['message' => 'User Updated successfully','coverImage'=>$imageName??''], 200);

        } catch (Exception $ex) {

            DB::rollback();

        }
    }

    //Delete user_skills
    public function Delete(Request $request)
    {

        $Id = $request->Id;
        $deleteQuery = DB::table('user_skills')->where('user_skills_id', $Id)->delete();
        if ($deleteQuery > 0) {

            return response()->json(['message' => 'Item deleted successfully'], 200);
        }
    }
    //web end

    // get all user_skills without pagination
    public function GetWithoutPagination(Request $request)
    {

        $id = $request->id;
        $status = $request->status;
        $getQuery = DB::table("user_skills")->select(['user_skills_id', 'user_skills'])
            ->orderBy('user_skills');
        if (isset($id)) {
            $getQuery->where('user_skills_id', '=', $id);
            if (isset($status)) {
                $getQuery->where('user_skills_status', '=', $status);
            } else {
                $getQuery->where('user_skills_status', '=', 'Active');

            }
        } else {
            if (isset($status)) {
                $getQuery->where('user_skills_status', '=', $status);
            } else {
                $getQuery->where('user_skills_status', '=', 'Active');

            }

        }

        $getQuery = $getQuery->get();
        return response()->json(['resultData' => $getQuery], 200);
    }


	// Get Role wise permission
    public function getAssignedUnAssignedPermission(Request $request)
    {
        $roleId = $request->roleId;
        $getPermissionRoleWise = DB::select("select permissions.id as permission_id,permissions.name as 			permission_name,
        permissions.module_name as Module,if(role_has_permissions.role_id is null,0,1) as 					is_permission_assigned
         from permissions left join role_has_permissions
        on permissions.id=role_has_permissions.permission_id and role_has_permissions.role_id=$roleId",
//         DB::raw("ifnull((SELECT roles.name  from
//         roles  where  roles.id=$roleId and roles.is_role_active=1
// ),0) as role_name")
        
    );
		 return response()->json(['roleData' => ['data'=>$getPermissionRoleWise]], 200);
    }
    public function getRolePermissionName(Request $request){
        $roleId = $request->roleId;
        $getRoleName=DB::table('roles')->select('roles.name as roleName')
        ->where('roles.id',$roleId)
        ->first();
        return response()->json(['roleName' => $getRoleName, 200]);
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
                        'role_id' => $roleId, 
                        'permission_id' => $permissionId[$x]

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
			 return response()->json(['resultData' => $getQuery], 200);
        } else {
			 return response()->json(['resultData' => $getQuery], 300);
        }
    }

	// Assign Individual Permission Role Wise
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
			 return response()->json(['resultData' => $getQuery], 200);
        } else {
			 return response()->json(['resultData' => $getQuery], 300);
        }
    }



    public function getAccountDetails(Request $request){
        $getQuery = DB::table("users")->select(['users.role_id','users.user_id','users.user_email','users.user_status','user_details.first_name','user_details.last_name'
    ,'users.full_name','user_details.nick_name','user_details.user_details_id','user_details.phone_1','user_details.phone_2'
    ,'user_details.birth_month','user_details.birth_day','user_details.website','user_details.open_property_limit'
    ,"user_details.user_id","user_details.active_user_date_limit","user_details.active_user_date_limit","user_details.is_address_same_as_agency"
    ,"user_details.unit_number","user_details.house_number","user_details.street_name","user_details.building_name","user_details.subdivision_id"
    ,"user_details.barangay_id" ,"user_details.town_id","user_details.province_id","user_details.zip_code"

    ,'user_details.floor','user_details.re_license','user_details.profile_statement','user_details.self_broker','user_details.associated_broker_id'
    ,'user_details.user_skills','user_details.user_skills as user_skills_id'

    ,'user_details.associated_agency_id','user_details.agent_photo','user_details.isFeatured','user_details.address','user_details.year'
    ,'user_details.user_description','roles.name as role_name'
         ])
    ->join('user_details', 'user_details.user_id', '=', 'users.user_id')
    ->join('roles','roles.id','=','users.role_id')
         ->where('users.user_id',$request->user_id)
         ->get();
    return response()->json(['resultData' => $getQuery], 200);
}

public function UpdateProfile(Request $request){
    

    $UserType = $request->UserType;
    $AssociatedAgency = $request->AssociatedAgency;
    $firstName = $request->firstName;
    $lastName = $request->lastName;
    $nickName = $request->nickName;
    $selectDate = $request->selectDate;
    $sameAsAgency = $request->sameAsAgency;
    $unitNumber = $request->unitNumber;
    $houseLotNumber = $request->houseLotNumber;
    $streetName = $request->streetName;
    $propertyBuildingName = $request->propertyBuildingName;
    $subdivision = $request->subdivision;
    $barangay = $request->barangay;
    $town = $request->town;
    $province = $request->province;
    $zipCode = $request->zipCode;
    $floorLevel = $request->floor;
    $subdivision = $request->subdivision;
    $selectBirthDay = $request->selectBirthDay;
    $selectBirthMonth = $request->selectBirthMonth;
    $rELicence = $request->rELicence;
    $userWebsite = $request->userWebsite;
    $userSkills = $request->userSkills;
    $profileStatement = $request->profileStatement;
    $selfBroker = $request->selfBroker;
    $associatedBroker = $request->associatedBroker;
    $reasonInactive = $request->reasonInactive;
    $inactiveUser = $request->inactiveUser;
    $created_by = $request->created_by;
    $phone1 = $request->phone1;
    $phone2 = $request->phone2;
    $openPropertyLimit = $request->openPropertyLimit;
    $activeUserDateLimit = $request->activeUserDateLimit;
    $email = $request->email;
    $status=$request->status;


    try {
        DB::beginTransaction();
        $verify_password=$request->verify_password;
        $getQuerypass=DB::table('users')->select('password_normal')
        ->where('users.user_id',$request->user_id)->first();
        $fetch=$getQuerypass->password_normal;
     
        if($fetch==$verify_password)
        {
            $selectedImage=DB::table('user_details')->select('user_details.agent_photo')->where('user_details.user_id',$request->user_id)
            ->first();
            if($request->hasfile('profile_image')) {

                $imageName = rand(1111, 9999) . time() . '.' . $request->profile_image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/featuredagent/images');
               
                $request->profile_image->move($destinationPath, $imageName);
            }
            else{
                $imageName=$selectedImage->agent_photo;
            }
        $insertedUserId = DB::table('users')->where('user_id',$request->user_id)
            ->update (  [
                'user_email' => $email,
                'first_name' => ucfirst($firstName),
                'last_name' => ucfirst($lastName),
                'full_name' => ucfirst($firstName) . ' ' . ucfirst($lastName),
                'slug' => Str::slug(ucfirst($firstName) . ' ' . ucfirst($lastName)),
               ]);

        DB::table('user_details')->where('user_id',$request->user_id)
            ->update ([

                'first_name' => ucfirst($firstName),
                'last_name' => ucfirst($lastName),
                'nick_name' => $nickName,
                'phone_1' => $phone1,
                'phone_2' => $phone2,
                'website' => $userWebsite,
                'user_skills' => $userSkills,
                'open_property_limit' => $openPropertyLimit,
                'unit_number' => $unitNumber,
                'house_number' => $houseLotNumber,
                'street_name' => $streetName,
                'building_name' => $propertyBuildingName,
                'subdivision_id' => $subdivision,
                'barangay_id' => $barangay,
                'town_id' => $town,
                'province_id' => $province,
                'zip_code' => $zipCode,
                'floor' => $floorLevel,
                'profile_statement' => $profileStatement,
                'agent_photo'=>$imageName,
         
            ]);
        DB::table('user_tracking')->insertGetId(
            [
                'user_id'=>$request->user_id,
                'date_active' =>$inactiveUser=='Active'?now():null,
                'date_inactive'=>$inactiveUser=='Inactive'?now():null,
                'user_who_activated' => $request->user_id,
                'user_who_deactivated'=> $request->user_id,
                'reason_inactive'=>$request->reasonInactive,
            ]);

        DB::commit();
        return response()->json(['message' => 'User Updated successfully','coverImage'=>$imageName??''], 200);
        }
        else{
            return response()->json(['message' => 'Password Incorrect'], 200); 
        }
    } catch (Exception $ex) {

        DB::rollback();

    }
}

public function deleteUser(Request $request){
$user_id=$request->user_id;
try{
    DB::beginTransaction();
    if($user_id!=null)
    {
   $userdetails= DB::table('user_details')->where('user_id',$request->user_id)->delete();
    }

    if($user_id!=null)
    {
   $usertracking=DB::table('user_tracking')->where('user_id',$request->user_id)->delete();
    }
    if($user_id!=null)
    {
   $users=DB::table('users')->where('user_id',$request->user_id)->delete();
    }
    DB::commit();
    return response()->json(['message' => 'User Deleted Successfully'], 200);
}
 catch (Exception $ex) {

    DB::rollback();

}

}
public function forget_password(Request $request)
{
      
   
 
    $user_info=$request->forget_email;

    
    $fetch=DB::table('users')->select('password_normal','user_email')->where('users.user_email',$user_info)->first();
    if($fetch==null){
        return response()->json(['message' => 'Email Not Found in Database'], 200);
    
    }
    else{
        $pass=$fetch->password_normal;
        \Mail::send('mail.forgetpassword', ['email' =>$user_info,'password'=>$fetch->password_normal], function($message) use($user_info,$pass){
            $message->to($user_info);
            $message->from($user_info);
            $message->subject('Password Details');
        });
       
    }
  
       
   

      
        return response()->json(['message' => 'Password Sent Successfully please check your email'], 200);



}

public function change_password(Request $request)
{
    $user_info=$request->forget_email;
    $current_password=$request->current_password;
    $new_password=$request->new_password;
    $confirm_password=$request->confirm_password;
    $fetch=DB::table('users')->select('password_normal','user_email')->where('users.user_id',$request->user_id)->first();

    if($current_password==$new_password){
        return response()->json(['message' => 'current password is same as  new password please enter different password'], 200);   
    }
    
    if($fetch->password_normal==$new_password){
        return response()->json(['message' => 'current password is same as  new password please enter different password'], 200);   
    }
    if($fetch->password_normal!==$current_password){
        return response()->json(['message' => 'Current Password is Incorrect','success'=>false], 200);   
    }
    
    if($new_password==$confirm_password)
    {
     $update=DB::table('users')->where('user_id',$request->user_id)->update([
       'password_normal'=>$new_password,
       'password'=>bcrypt($new_password)
     ]);
     return response()->json(['message' => 'Password changed successfully'], 200);
    }
    else{
        return response()->json(['message' => 'New Password Confirm Password Does not match','success'=>true], 200);  
    }
  
}
	
	public function agencyaddress(Request $request)
	{
		$address_id=$request->associated_agency_id;
		 $fetch=DB::table('agency')->select('*')->where('agency.agency_id',$address_id)->first();
		return response()->json(['resultData'=>$fetch,'success'=>true], 200);  
		
	}


}
