<?php

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('web_login', 'UserController@validateLogin')
        ->name('web_login');
    Route::post('web_logout', 'UserController@logout')->name('web_logout');
    Route::post('web_token_refresh', 'UserController@tokenRefresh')->name('web_token_refresh');
    Route::post('web_get_logged_user_details_with_role_permission', 'UserController@getLoggedUserDetailsWithRolesPermission')->name('web_get_logged_user_details_with_role_permission');



});



Route::group(['middleware' => ['auth:api','permission:Add Role']], function () {

    // Save Role
    Route::post('web_save_role', 'SystemSettingsController@saveRole')->name('web_save_role');

});
Route::group(['middleware' => ['auth:api','permission:Roles Permissions']], function () {

    // View All Roles
    Route::get('web_get_all_roles', 'SystemSettingsController@getAllRoles')->name('web_get_all_roles');

});

Route::group(['middleware' => ['auth:api','permission:Edit Role']], function () {

    // Edit Role
    Route::post('web_update_role', 'SystemSettingsController@updateRole')->name('web_update_role');

});



Route::group(['middleware' => ['auth:api','permission:Assign Permission']], function () {
    // View & Assign Permission
    Route::post('web_get_assigned_unassigned_permission_role_wise', 'SystemSettingsController@getAssignedUnAssignedPermissionRoleWise')->name('web_get_assigned_unassigned_permission_role_wise');
    Route::post('web_assign_permission_role_wise', 'SystemSettingsController@assignPermissionRoleWise')->name('web_assign_permission_role_wise');

});




Route::group(['middleware' => ['auth:api','permission:Department']], function () {

    // View All Department
    Route::get('web_get_all_departments', 'DepartmentController@getAllDepartments')->name('web_get_all_departments');

});

Route::group(['middleware' => ['auth:api','permission:Add Department']], function () {

    // Save Department
    Route::post('web_save_department', 'DepartmentController@saveDepartment')->name('web_save_department');

});

Route::group(['middleware' => ['auth:api','permission:Edit Role']], function () {

    // Edit Department
    Route::post('web_update_department', 'DepartmentController@updateDepartment')->name('web_update_department');

});




Route::group(['middleware' => ['auth:api','permission:Designation']], function () {

    // View All Designation
    Route::get('web_get_all_designations', 'DesignationController@getAllDesignations')->name('web_get_all_designations');

});

Route::group(['middleware' => ['auth:api','permission:Add Designation']], function () {

    // Save Designation
    Route::post('web_save_designation', 'DesignationController@saveDesignation')->name('web_save_designation');

});

Route::group(['middleware' => ['auth:api','permission:Edit Designation']], function () {

    // Edit Designation
    Route::post('web_update_designation', 'DesignationController@updateDesignation')->name('web_update_designation');

});




Route::group(['middleware' => ['auth:api','permission:Prefix']], function () {

    // View All Prefix
    Route::get('web_get_all_prefix', 'PrefixController@getAllPrefix')->name('web_get_all_prefix');

});

Route::group(['middleware' => ['auth:api','permission:Edit Prefix']], function () {

    // Save Prefix
    Route::post('web_save_prefix', 'PrefixController@savePrefix')->name('web_save_prefix');

});



Route::group(['middleware' => ['auth:api','permission:Staff']], function () {

    // View All Staff
    Route::get('web_get_all_staff', 'StaffController@getAllStaff')->name('web_get_all_staff');

});

Route::group(['middleware' => ['auth:api','permission:Staff']], function () {

    // View All Active Roles
    Route::get('web_get_all_active_roles_without_pagination', 'SystemSettingsController@getAllActiveRolesWithoutPagination')->name('web_get_all_active_roles_without_pagination');

});


Route::group(['middleware' => ['auth:api','permission:Edit Staff']], function () {

    // Enable disable staff
    Route::post('web_enable_disable_staff', 'StaffController@enableDisableStaff')->name('web_enable_disable_staff');

});

Route::group(['middleware' => ['auth:api']], function () {

    // Get Prefix Module Wise
    Route::get('web_get_prefix_module_wise', 'PrefixController@getPrefixModuleWise')->name('web_get_prefix_module_wise');

});

Route::group(['middleware' => ['auth:api']], function () {

    // Get Active Designation without pagination
    Route::get('web_get_active_designation_without_pagination', 'DesignationController@getActiveDesignationWithoutPagination')->name('web_get_active_designation_without_pagination');

});

Route::group(['middleware' => ['auth:api']], function () {

    // Get Active Department without pagination
    Route::get('web_get_active_department_without_pagination', 'DepartmentController@getActiveDepartmentWithoutPagination')->name('web_get_active_department_without_pagination');

    Route::get('web_get_active_court_without_pagination', 'DepartmentController@getActiveCourtWithoutPagination')->name('web_get_active_court_without_pagination');

});

Route::group(['middleware' => ['auth:api','permission:Add Staff|Edit Staff']], function () {

    // save staff basic info
    Route::post('web_save_edit_staff_basic_info', 'StaffController@saveEditStaffBasicInfo')->name('web_save_edit_staff_basic_info');

});

Route::group(['middleware' => ['auth:api']], function () {

    //Get All Active User _ Advocate without pagination
    Route::get('web_get_active_advocate_without_pagination', 'UserController@getActiveAdvocatetWithoutPagination')->name('web_get_active_advocate_without_pagination');

});

Route::group(['middleware' => ['auth:api']], function () {

    // save daily collection
    Route::post('save_daily_collection_details', 'CollectionController@saveDailyCollection')->name('save_daily_collection_details');
    // get all collection
    Route::get('web_get_all_collection', 'CollectionController@getAllCollection')->name('web_get_all_collection');

    // get all collection datewise
    Route::get('web_get_all_collection_datewise', 'CollectionController@getAllCollectionDateWise')->name('web_get_all_collection_datewise');

    // get all collection datewise headwise
    Route::get('web_get_all_collection_datewise_headwise', 'CollectionController@getAllCollectionDateWiseHeadWise')->name('web_get_all_collection_datewise_headwise');

    // get all collection datewise advocatewise
    Route::get('web_get_all_collection_datewise_advocatewise', 'CollectionController@getAllCollectionDateWiseAdvocateWise')->name('web_get_all_collection_datewise_advocatewise');



      // get all collection headwise
    Route::get('web_get_all_collection_headwise', 'CollectionController@getAllCollectionHeadWise')->name('web_get_all_collection_headwise');


    // get total collection headwise
    Route::get('web_get_total_collection_headwise', 'CollectionController@getTotalCollectionHeadWise')->name('web_get_total_collection_headwise');

});

//Advocate Refubd Entry
Route::group(['middleware' => ['auth:api']], function () {

    //Get All Advocate without pagination who is eligible for refund
    Route::get('web_get_active_advocate_refund_eligble_without_pagination', 'CollectionController@getActiveAdvocatetRefundEligbleWithoutPagination')->name('web_get_active_advocate_refund_eligble_without_pagination');

    // get all pending refund
    Route::get('web_get_all_pending_refund_advocate', 'CollectionController@getAllPendingRefundAdvocate')->name('web_get_all_pending_refund_advocate');


    // get all pending refund by Receipt Nuber
    Route::get('web_get_all_pending_refund_by_receipt_number', 'CollectionController@getAllPendingRefundByReceiptNumber')->name('web_get_all_pending_refund_by_receipt_number');


        // get all completed refund by advocate
    Route::get('web_get_all_completed_refund_advocate', 'CollectionController@getAllCompletedRefundAdvocate')->name('web_get_all_completed_refund_advocate');

      // update daily refund by Advocate
    Route::get('select_refund_session_wise', 'CollectionController@getAllRefundSessionWise')->name('select_refund_session_wise');

 // update daily refund by Advocate
    Route::post('update_refund_by_receipt', 'CollectionController@updateRefundByReceipt')->name('update_refund_by_receipt');

// update daily refund by Notary
    Route::post('update_refund_by_notary', 'CollectionController@update_refund_by_notary')->name('update_refund_by_notary');

    // update daily refund by Advocate
    Route::post('update_refund_by_advocate', 'CollectionController@updateRefundByAdvocate')->name('update_refund_by_advocate');


});

//Refund Details
Route::group(['middleware' => ['auth:api']], function () {

    //Norary Refund
    Route::get('web_get_all_collection_and_refund_receiptwise', 'CollectionController@getAllCollectionAndRefundReceiptWise')->name('web_get_all_collection_and_refund_receiptwise');
    
    Route::get('web_get_head_wise_collection_and_refund', 'CollectionController@getHeadWiseCollectionAndRefund')->name('web_get_head_wise_collection_and_refund');
    
    Route::get('web_get_advocate_wise_collection_and_refund', 'CollectionController@getAdvocateWiseCollectionAndRefund')->name('web_get_advocate_wise_collection_and_refund');



    //Get All Advocate without pagination who is eligible for refund
    Route::get('web_get_advocate_collection_and_refund_receiptwise', 'CollectionController@getAdvocateCollectionAndRefundReceiptWise')->name('web_get_advocate_collection_and_refund_receiptwise');
    //Get All Advocate without pagination who is eligible for refund
    Route::get('web_get_advocate_head_wise_collection_and_refund', 'CollectionController@getAdvocateHeadWiseCollectionAndRefund')->name('web_get_advocate_head_wise_collection_and_refund');
    //Get All Advocate without pagination who is eligible for refund
    Route::get('web_get_advocate_wise_collection_and_refund_for_advocate', 'CollectionController@getAdvocateWiseCollectionAndRefundAdvocate')->name('web_get_advocate_wise_collection_and_refund_for_advocate');




    //Daily Refund
     // get all collection datewise
    Route::get('web_get_all_refund_datewise', 'CollectionController@getAllRefundDateWise')->name('web_get_all_refund_datewise');

    // get all collection datewise headwise
    Route::get('web_get_all_refund_datewise_headwise', 'CollectionController@getAllRefundHeadWise')->name('web_get_all_refund_datewise_headwise');

    // get all collection datewise advocatewise
    Route::get('web_get_all_refund_datewise_advocatewise', 'CollectionController@getAllRefundDateWiseHeadWise')->name('web_get_all_refund_datewise_advocatewise');

});


//Dashboard DailyCollection
Route::group(['middleware' => ['auth:api']], function () {

    //Get All Advocate without pagination who is eligible for refund
    Route::get('web_get_active_advocate_refund_eligble_without_pagination', 'CollectionController@getActiveAdvocatetRefundEligbleWithoutPagination')->name('web_get_active_advocate_refund_eligble_without_pagination');

    // get all collection
    Route::get('get_dashboard_daily_collection', 'CollectionController@getDashboardDailyCollection')->name('get_dashboard_daily_collection');
});




