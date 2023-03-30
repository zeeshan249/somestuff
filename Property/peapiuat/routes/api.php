<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\BrokerAssociationController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\TownController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\AgriTypeController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\CapabilityController;
use App\Http\Controllers\UserSkillsController;
use App\Http\Controllers\ProductModeController;
use App\Http\Controllers\SubdivisionController;
use App\Http\Controllers\AgentController;





use App\Http\Controllers\ZonningCodeController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\PropertyClassificationController;




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
Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
});
// Check mobile number
Route::post('checkMobileNumber', [AppController::class, 'checkMobileNumber']);
// Send Signup OTP
Route::get('sendSignupOTP/{mobile}/{otp}', [AppController::class, 'sendSignupOTP']);

// Save mobile number
Route::post('saveMobileNumber', [AppController::class, 'saveMobileNumber']);

//

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
});

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
 Route::get('GetUser', [UserController::class, 'Get']);
 Route::get('GetNewUser', [UserController::class, 'GetNewUser']);
 Route::post('changeUserStatus', [UserController::class, 'status']);
Route::post('webValidateLogin', [AppController::class, 'webValidateLogin']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // get logged user details with role and permission
    Route::get('webGetLoggedUserDetailsWithRolesPermission', [AppController::class, 'webGetLoggedUserDetailsWithRolesPermission']);

	 // Assign Individual Permission RoleWise
    Route::post('webAssignIndividualPermissionRoleWise', [AppController::class, 'assignIndividualPermissionRoleWise']);

	 // Assign Permission Role Wise
    Route::post('webAssignPermissionRoleWise', [AppController::class, 'assignPermissionRoleWise']);


	 // getAssignedUnAssignedPermission
    Route::get('getAssignedUnAssignedPermission', [UserController::class, 'getAssignedUnAssignedPermission']);
    //getRoleName
    Route::get('getRolePermissionName', [UserController::class, 'getRolePermissionName']);


	//Logout
    Route::post('webLogout', [AppController::class, 'webLogout']);

    // Roles
    Route::get('webGetRoles', [AppController::class, 'webGetRoles']);
    Route::get('webGetRolesWithoutPagination', [AppController::class, 'GetWithoutPagination']);

    Route::post('webSaveRole', [AppController::class, 'webSaveRole']);
    Route::post('webUpdateRole', [AppController::class, 'webUpdateRole']);
    Route::post('webDeleteRole', [AppController::class, 'webDeleteRole']);
    Route::post('webDeleteRoles', [AppController::class, 'webDeleteRole']);


    // Capability
    Route::get('GetCapability', [CapabilityController::class, 'Get']);
    Route::get('GetCapabilityWithoutPagination', [CapabilityController::class, 'GetWithoutPagination']);
    Route::post('SaveCapability', [CapabilityController::class, 'Save']);
    Route::post('UpdateCapability', [CapabilityController::class, 'Update']);
    Route::post('DeleteCapability', [CapabilityController::class, 'Delete']);

    // ZonningCode
    Route::get('GetZonningCode', [
        ZonningCodeController::class, 'Get'
    ]);
    Route::post('SaveZonningCode', [ZonningCodeController::class, 'Save']);
    Route::post('UpdateZonningCode', [ZonningCodeController::class, 'Update']);
    Route::post('DeleteZonningCode', [ZonningCodeController::class, 'Delete']);

    // agriType
    Route::get('GetAgriType', [AgriTypeController::class, 'Get']);
    Route::get('GetAgriTypeWithoutPagination', [AgriTypeController::class, 'GetWithoutPagination']);
    Route::post('SaveAgriType', [AgriTypeController::class, 'Save']);
    Route::post('UpdateAgriType', [AgriTypeController::class, 'Update']);
    Route::post('DeleteAgriType', [AgriTypeController::class, 'Delete']);

    // Specialization
    Route::get('GetSpecialization', [SpecializationController::class, 'Get']);
    Route::get('GetSpecializationWithoutPagination', [SpecializationController::class, 'GetWithoutPagination']);
    Route::post('SaveSpecialization', [SpecializationController::class, 'Save']);
    Route::post('UpdateSpecialization', [
        SpecializationController::class, 'Update'
    ]);
    Route::post('DeleteSpecialization', [
        SpecializationController::class, 'Delete'
    ]);
    // UserSkills
    Route::get('GetUserSkills', [UserSkillsController::class, 'Get']);
    Route::get('GetUserSkillWithoutPagination', [UserSkillsController::class, 'GetWithoutPagination']);

    Route::post('SaveUserSkills', [UserSkillsController::class, 'Save']);
    Route::post('UpdateUserSkills', [
        UserSkillsController::class, 'Update'
    ]);
    Route::post('DeleteUserSkills', [
        UserSkillsController::class, 'Delete'
    ]);

    //agent
    Route::get('GetUserAgents', [AgentController::class, 'agentreport']);
    //user report
    Route::get('GetUserReport', [AgentController::class, 'userreport']);
    Route::get('GetUserToActivated', [AgentController::class, 'usertobeactivated']);
    // Subdivision
Route::get('GetSubdivisionWithoutPagination', [SubdivisionController::class, 'GetWithoutPagination']);
Route::get('GetSubdivision', [SubdivisionController::class, 'Get']);

    Route::post('SaveSubdivision', [SubdivisionController::class, 'Save']);
    Route::post('UpdateSubdivision', [
        SubdivisionController::class, 'Update'
    ]);
    Route::post('DeleteSubdivision', [
        SubdivisionController::class, 'Delete'
    ]);

// Barangay
 Route::get('GetBarangayWithoutPagination', [BarangayController::class, 'GetWithoutPagination']);
	 Route::get('GetAdjacentBarangayWithoutPagination', [BarangayController::class, 'GetAdjacentBarangayWithoutPagination']);
    Route::get('GetBarangay', [BarangayController::class, 'Get']);

Route::post('SaveBarangay', [BarangayController::class, 'Save']);
Route::post('UpdateBarangay', [
    BarangayController::class, 'Update',
]);
Route::post('DeleteBarangay', [
    BarangayController::class, 'Delete',
]);
// Town
	  Route::get('GetTown', [TownController::class, 'Get']);
 Route::get('GetTownWithoutPagination', [TownController::class, 'GetWithoutPagination']);
 Route::get('GetAdjacentTownWithoutPagination', [TownController::class, 'GetAdjacentTownWithoutPagination']);

Route::post('SaveTown', [TownController::class, 'Save']);
Route::post('UpdateTown', [
    TownController::class, 'Update',
]);
Route::post('DeleteTown', [
    TownController::class, 'Delete',
]);

// Province
 Route::get('GetProvinceWithoutPagination', [ProvinceController::class, 'GetWithoutPagination']);

	 Route::get('GetBarangayProvinceWithoutPagination', [ProvinceController::class, 'GetBarangayProvinceWithoutPagination']);
    Route::get('GetProvince', [ProvinceController::class, 'Get']);

Route::post('SaveProvince', [ProvinceController::class, 'Save']);
Route::post('UpdateProvince', [
    ProvinceController::class, 'Update',
]);
Route::post('DeleteProvince', [
    ProvinceController::class, 'Delete',
]);


// User
    Route::post('SaveUser', [UserController::class, 'Save']);
    Route::post('UpdateUser', [UserController::class, 'Update']);
    Route::post('deleteUser', [UserController::class, 'deleteUser']);
    
//Get Master Amenities
    Route::get('GetMasterAmenitiesWithoutPagination', [PropertyController::class, 'GetMasterAmenitiesWithoutPagination']);
    //Agency
    Route::get('getagency', [AgencyController::class, 'Get']);
    // Agency Report
    Route::get('GetAgencies', [AgencyController::class, 'Get']);
    Route::get('GetAgentsBasedAgency', [AgentController::class, 'agentsbasedagency']);

    Route::get('GetAgencyById', [AgencyController::class, 'GetWithoutPagination']);
    Route::get('GetAgencyWithoutPagination', [AgencyController::class, 'WithoutPagination']);

    Route::post('saveagency', [AgencyController::class, 'Save']);
    Route::post('updateagency', [AgencyController::class, 'Update']);

    //Broker
    Route::get('GetBrokerWithoutPagination', [BrokerController::class, 'GetWithoutPagination']);
    //Broker Report
    Route::get('GetBrokers', [BrokerController::class, 'Get']);

    Route::get('getbroker', [BrokerController::class, 'Get']);
    Route::get('getBrokerById', [BrokerController::class, 'getBrokerById']);
    Route::post('savebroker', [BrokerController::class, 'Save']);
    Route::post('updatebroker', [BrokerController::class, 'Update']);
    //Broker Association

    Route::get('GetBrokerAssociationWithoutPagination', [BrokerAssociationController::class, 'GetWithoutPagination']);
    Route::get('getbrokerassociation', [BrokerAssociationController::class, 'Get']);
    Route::get('getBrokerAssociationById', [BrokerAssociationController::class, 'getBrokerAssociationById']);
    //get broker associations report
    Route::get('GetBrokerAssociations', [BrokerAssociationController::class, 'Get']);
    Route::post('savebrokerassociation', [BrokerAssociationController::class, 'Save']);
    Route::post('updatebrokerassociation', [BrokerAssociationController::class, 'Update']);

	//Product Mode

    Route::get('GetProductMode', [ProductModeController::class, 'Get']);

Route::post('SaveProductMode', [ProductModeController::class, 'Save']);
Route::post('UpdateProductMode', [
    ProductModeController::class, 'Update',
]);
Route::post('DeleteProductMode', [
    ProductModeController::class, 'Delete',
]);

//Property classification

Route::get('GetPropertyClassification', [PropertyClassificationController::class, 'Get']);
    //property amenities mapping
Route::get('getPropertyMappingAmenities', [PropertyController::class, 'getPropertyMappingAmenities']);
//save amenities
Route::post('savePropertyMappingAmenities', [PropertyController::class, 'savePropertyMappingAmenities']);
//get Selected Property Amenities
Route::get('getSelectedPropertyAmenities', [PropertyController::class, 'getSelectedPropertyAmenities']);

Route::post('SavePropertyClassification', [PropertyClassificationController::class, 'Save']);
Route::post('UpdatePropertyClassification', [
    PropertyClassificationController::class, 'Update',
]);
Route::post('DeletePropertyClassification', [
    PropertyClassificationController::class, 'Delete',
]);
	Route::get('GetPropertyClassificationWithoutPagination', [PropertyClassificationController::class, 'GetWithoutPagination']);

//Property Type

Route::get('GetPropertyType', [PropertyTypeController::class, 'Get']);

Route::post('SavePropertyType', [PropertyTypeController::class, 'Save']);
Route::post('UpdatePropertyType', [
    PropertyTypeController::class, 'Update',
]);
Route::post('DeletePropertyType', [
    PropertyTypeController::class, 'Delete',
]);
	Route::get('GetPropertyTypeWithoutPagination', [PropertyTypeController::class, 'GetWithoutPagination']);
    Route::get('GetDwellingWithoutPagination', [PropertyTypeController::class, 'GetDwellingWithoutPagination']);
    

//Product category

Route::get('GetProductCategory', [CategoryController::class, 'Get']);

Route::post('SaveProductCategory', [CategoryController::class, 'Save']);
Route::post('UpdateProductCategory', [
    CategoryController::class, 'Update',
]);
Route::post('DeleteProductCategory', [
    CategoryController::class, 'Delete',
]);

	Route::get('GetProductCategoryWithoutPagination', [CategoryController::class, 'GetWithoutPagination']);

});
//seller
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('WebVerifyOTP', [UserController::class, 'WebVerifyOTP']);
    Route::post('UpdateProfile',[UserController::class,'UpdateProfile']);
    Route::post('change_password', [UserController::class, 'change_password']);
    Route::get('webGetAccountDetails', [UserController::class, 'getAccountDetails']);
    Route::get('getTownProvinceDetails', [BarangayController::class, 'getTownProvinceDetails']);
    Route::get('GetSeller', [SellerController::class, 'Get']);
    Route::post('deleteSeller',[SellerController::class,'delete']);
    Route::get('GetSellerWithoutPagination', [SellerController::class, 'GetSellerWithoutPagination']);
    Route::post('saveSeller', [SellerController::class, 'Save']);
    Route::get('getSellerById', [SellerController::class, 'GetSellerById']);
    Route::post('updateSeller', [SellerController::class, 'Update']);
    Route::get('getSellerReports', [SellerController::class, 'listofsellersreport']);
    Route::get('getBrokerLinkedAssociationReport', [BrokerController::class, 'brokerlinkedtobrokerassociation']);
//list of sold or rented properties report
    Route::get('getSoldRentReport', [BrokerController::class, 'listofsoldproperties']);
//list of individual properties posted report
    Route::get('getIndividualsReport', [BrokerController::class, 'listofindividualincludingstatus']);
    //count of properties posted by various users
    Route::get('getCountOfPropertiesReport', [BrokerController::class, 'countofproperties']);
    //    openpendingpropertyreport
    Route::get('getOpenPendingPropertyReport', [BrokerController::class, 'openpendingpropertyreport']);
    //    propertylinkedtobroker
    Route::get('getPropertyBrokerReport', [BrokerController::class, 'propertylinkedtobroker']);

    //    listofattachments
    Route::get('getListOfAttachments', [BrokerController::class, 'getListOfAttachments']);

    Route::get('GetAdjacentSubdivisionWithoutPagination', [SubdivisionController::class, 'GetAdjacentSubdivisionWithoutPagination']);
    Route::get('GetDetailsFromBarangay', [SubdivisionController::class, 'getDetailsFromBarangay']);
    Route::get('/allproperty',[PropertyController::class,'allProperty'])->name('allProperty');
   
    Route::get('/GetAssociatedAgencyAgents',[PropertyController::class,'agentsecondary'])->name('agentsecondary');
    Route::post('/provinceExist',[ProvinceController::class,'provinceExist'])->name('provinceExist');
  Route::get('/GetAssociatedAgencyAddressWithoutPagination',[UserController::class,'agencyaddress'])->name('agentsecondary');
  Route::post('/deleteproperty',[PropertyController::class,'deleteproperty'])->name('deleteproperty'); 
  Route::get('/getPropertyTrackingReport', [PropertyController::class, 'getPropertyTrackingReport']); 
});
Route::get('/getfeatured',[PropertyController::class,'getProperty'])->name('getProperty');

Route::post('/propertyimagesupload',[PropertyController::class,'propertyimagesupload'])->name('propertyimagesupload');

Route::post('/deletepropertyimages',[PropertyController::class,'deletepropertyimages'])->name('deletepropertyimages');
Route::post('/updateproperty',[PropertyController::class,'updateproperty'])->name('updateproperty');
Route::post('/saveproperty',[PropertyController::class,'saveproperty'])->name('saveProperty');
Route::post('/saveimagesupload',[PropertyController::class,'propertyimagesupload'])->name('propertyimagesupload');
Route::get('/showallimagesvideo',[PropertyController::class,'showallimagesvideo'])->name('showallimagesvideo');

Route::post('/propertyimagesisDefault',[PropertyController::class,'propertyimagesisDefault'])->name('propertyimagesisDefault');
Route::post('/propertyamenitiesupdate',[PropertyController::class,'propertyamenitiesupdate'])->name('propertyamenitiesupdate');
Route::get('/agentapi',[AgentController::class,'agentapi'])->name('agentapi');
Route::get('/allagents',[AgentController::class,'allagents'])->name('allagents');
Route::get('/singleagents/{slug?}',[AgentController::class,'singleagents'])->name('singleagents');

Route::get('/getNotification',[PropertyController::class,'getnotifications'])->name('getnotifications');
Route::post('/setNotificationStatus',[PropertyController::class,'NotificationStatus'])->name('getStatus');
Route::post('/deleteNotification',[PropertyController::class,'deleteNotification'])->name('deleteNotification');
Route::get('/unreadNotifications',[PropertyController::class,'unreadNotification'])->name('unreadNotification');
Route::post('forget_password', [UserController::class, 'forget_password']);




//web end
