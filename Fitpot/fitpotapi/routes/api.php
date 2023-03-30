<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CompetitionActivityController;
use App\Http\Controllers\CompetitionCategoryController;
use App\Http\Controllers\CompetitionMasterController;
use App\Http\Controllers\CompetitionTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WeekdayController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
Route::get('/viewclear', function () {
    Artisan::call('view:clear');
});
Route::get('/routeclear', function () {
    Artisan::call('route:clear');
});
Route::get('/configcache', function () {
    Artisan::call('config:cache');
});
Route::get('/cacheclear', function () {
    Artisan::call('cache:clear');
});

Route::get('/configclear', function () {
    Artisan::call('config:clear');
});
//app starts here
// Check mobile number
Route::post('checkMobileNumber', [AppController::class, 'checkMobileNumber']);
// Send Signup OTP
Route::get('sendSignupOTP/{mobile}/{otp}', [AppController::class, 'sendSignupOTP']);

// Save mobile number
Route::post('saveMobileNumber', [AppController::class, 'saveMobileNumber']);


 

Route::group(['middleware' => ['auth:sanctum']], function () {

Route::post('checkUserStatus', [AppController::class, 'checkUserStatus']);

    // Update Device Token
    Route::post('updateDeviceToken', [AppController::class, 'updateDeviceToken']);

    // Update Name and Gender
    Route::post('updateNameGender', [AppController::class, 'updateNameGender']);

    // Insert BMI hitory
    Route::post('saveBMIHitory', [AppController::class, 'saveBMIHitory']);

    Route::post('getQuestion', [AppController::class, 'getQuestion']);

    // update user answer
    Route::post('updateUserAnswer', [AppController::class, 'updateUserAnswer']);

    // get device list
    Route::post('getDeviceList', [AppController::class, 'getDeviceList']);

    //save device mapping
    Route::post('saveUserDeviceMapping', [AppController::class, 'saveUserDeviceMapping']);
    //get slider
    Route::post('getSlider', [AppController::class, 'getSlider']);
//get upcoming competition
    Route::get('getUpcomingCompetition', [AppController::class, 'getUpcomingCompetition']);
//Refresh Token
Route::get('refreshToken', [AppController::class, 'refreshToken']);
//Profile Image Upload
Route::post('profileImageUpload', [AppController::class, 'profileImageUpload']);
//Change Password
Route::post('changePassword', [AppController::class, 'changePassword']);
//Update  profile image
Route::post('updateProfileImage', [AppController::class, 'updateProfileImage']);
//Remove  profile image
Route::post('removeProfileImage', [AppController::class, 'removeProfileImage']);

	
// get wallet balance overview

Route::post('getWalletBalanceOverView', [AppController::class, 'getWalletBalanceOverView']);
//get wallet history
Route::get('getWalletHistory', [AppController::class, 'getWalletHistory']);

//get Competition Type
Route::get('getCompetitionType', [AppController::class, 'getCompetitionType']);
//get user competition mapping
Route::get('getTopTenUserListByCompScheduleId', [AppController::class, 'getTopTenUserListByCompScheduleId']);
	//save wallet transaction
Route::post('saveWalletTransaction', [AppController::class, 'saveWalletTransaction']);

//check join comp
Route::get('checkJoinCompetitionCondition', [AppController::class, 'checkJoinCompetitionCondition']);
//join comp
Route::post('joinCompetition', [AppController::class, 'joinCompetition']);
//sync fitness data
Route::post('syncFitnessData', [AppController::class, 'syncFitnessData']);
	//get comp user wise
Route::get('getCompetitionUserWise', [AppController::class, 'getCompetitionUserWise']);
	
	//get comp details user wise
	Route::get('getUserCompDetails', [AppController::class, 'getUserCompDetails']);  
	//get subscription
	Route::get('getSubscription', [AppController::class, 'getSubscription']);
	// subscribe
Route::post('subscribe', [AppController::class, 'subscribe']);
});


//app ends here

// for testing purpose
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sanctum/token', function (Request $request) {

    $user = User::where('user_id', $request->userId)->first();

    return $user->createToken($request->token_name)->plainTextToken;
});

Route::middleware('auth:sanctum')->get('/user/revoke', function (Request $request) {
    $user = $request->user();
    $user->tokens()->delete();
    return 'Deleted';
});

// testing purpose end

// web start

Route::post('webValidateLogin', [RoleController::class, 'webValidateLogin']);
Route::post('webLogin', [WebAuthController::class, 'webLogin']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // get logged user details with role and permission
    Route::get('webGetUsers', [UserController::class, 'Get']);
    Route::get('webGetSubscribedUserReport',[UserController::class, 'subscribeduserdetails']);
    Route::get('webGetUserWiseComepetitionReport',[UserController::class, 'webGetUserWiseComepetitionReport']);
    Route::get('webGetUserReport',[UserController::class, 'GetUserReport']);
    Route::get('webGetRolesWithoutPagination', [UserController::class, 'webGetRolesWithoutPagination']);
    Route::get('webGetUserWithoutPagination', [UserController::class, 'webGetUserWithoutPagination']);
    Route::get('webGetUserDeviceDataReport', [UserController::class, 'webGetDeviceDataReport']);

//    // save roles
    Route::post('webSaveUsers', [UserController::class, 'saveUsers']);
//// update roles
    Route::post('webUpdateUsers', [UserController::class, 'updateUsers']);
//// delete roles
    Route::post('webDeleteUsers', [UserController::class, 'DeleteUsers']);
////status
    Route::post('webChangeUsersStatus', [UserController::class, 'Status']);

    Route::get('webGetAllPermissions', [UserController::class, 'getAllPermissions']);
    Route::post('webSavePermissions',[UserController::class,'savePermissions']);
    Route::post('webDeletePermissions',[UserController::class,'deletePermissions']);
    Route::post('webUpdatePermissions',[UserController::class,'updatePermissions']);
});

//web end
//Competition type Start
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('webGetCompetitionType', [CompetitionTypeController::class, 'Get']);
    Route::post('webChangeCompetitionTypeStatus', [CompetitionTypeController::class, 'Status']);
    Route::post('webSaveCompetitionType', [CompetitionTypeController::class, 'Save']);
    Route::post('webUpdateCompetitionType', [CompetitionTypeController::class, 'Update']);
    Route::post('webDeleteCompetitionType', [CompetitionTypeController::class, 'Delete']);
    Route::get('webGetCompetitionTypeWithoutPagination', [CompetitionTypeController::class, 'GetWithoutPagination']);

});

//Competition Activity Start
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('webGetCompetitionActivity', [CompetitionActivityController::class, 'Get']);
    Route::get('webGetCompetitionActivityWithoutPagination', [CompetitionActivityController::class, 'GetWithoutPagination']);
    Route::post('webSaveCompetitionActivity', [CompetitionActivityController::class, 'Save']);
    Route::post('webUpdateCompetitionActivity', [CompetitionActivityController::class, 'Update']);
    Route::post('webDeleteCompetitionActivity', [CompetitionActivityController::class, 'Delete']);

});


//Competition Category Start
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('webGetCompetitionCategory', [CompetitionCategoryController::class, 'Get']);
    Route::get('webGetCompetitionCategoryWithoutPagination', [CompetitionCategoryController::class, 'GetWithoutPagination']);
    Route::post('webSaveCompetitionCategory', [CompetitionCategoryController::class, 'Save']);
    Route::post('webUpdateCompetitionCategory', [CompetitionCategoryController::class, 'Update']);
    Route::post('webDeleteCompetitionCategory', [CompetitionCategoryController::class, 'Delete']);

});

//Competition Master Start

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('webGetCompetitionMaster', [CompetitionMasterController::class, 'Get']);
    Route::get('webGetCompetitionMasterWithoutPagination', [CompetitionMasterController::class, 'GetWithoutPagination']);
    Route::post('webSaveCompetitionMaster', [CompetitionMasterController::class, 'Save']);
    Route::post('webUpdateCompetitionMaster', [CompetitionMasterController::class, 'Update']);
    Route::post('webDeleteCompetitionMaster', [CompetitionMasterController::class, 'Delete']);
    Route::post('webChangeCompetitionMasterStatus', [CompetitionMasterController::class, 'Status']);
    Route::get('webGetWeekdayWithoutPagination', [WeekdayController::class, 'GetWithoutPagination']);
});

//Devices Start

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('webGetDevices', [DeviceController::class, 'Get']);
    Route::post('webSaveDevices', [DeviceController::class, 'Save']);
    Route::post('webChangeDeviceStatus', [DeviceController::class, 'Status']);
    Route::post('webUpdateDevices', [DeviceController::class, 'Update']);
    Route::post('webDeleteDevices', [DeviceController::class, 'Delete']);
    Route::post('webChangeDeviceAuthStatus', [DeviceController::class, 'authStatus']);

});

//new role

Route::group(['middleware' => ['auth:sanctum']], function () {
  // get logged user details with role and permission
  Route::get('webGetLoggedUserDetailsWithRolesPermission', [RoleController::class, 'webGetLoggedUserDetailsWithRolesPermission']);
  //Logout
  Route::post('webLogout', [RoleController::class, 'webLogout']);
  // get all roles
  Route::get('webGetRoles', [RoleController::class, 'webGetRoles']);
  // save roles
  Route::post('webSaveRoles', [RoleController::class, 'webSaveRoles']);
// update roles
Route::post('webUpdateRoles', [RoleController::class, 'webUpdateRoles']);
// delete roles
  Route::post('webDeleteRoles', [RoleController::class, 'webDeleteRoles']);
//status
  Route::post('webChangeRoleStatus', [RoleController::class, 'Status']);
});


