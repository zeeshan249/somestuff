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





Route::post('/d',  'MobileApp\AppController@register');
Route::post('get_about_us', 'MobileApp\AppController@get_about_us');
Route::post('get_course', 'MobileApp\AppController@get_course');
Route::post('get_gallery', 'MobileApp\AppController@get_gallery');
Route::post('get_state', 'MobileApp\AppController@get_state');
Route::post('upload_franchise_document', 'MobileApp\AppController@upload_franchise_document');
Route::post('save_franchise_details', 'MobileApp\AppController@save_franchise_details');
Route::get('send_franchise_create_sms/{applicantName}/{mobileNumber}/{franchiseNumber}', 'MobileApp\AppController@send_franchise_create_sms');
Route::post('get_franchise_type', 'MobileApp\AppController@get_franchise_type');
Route::post('get_franchise_apply_details', 'MobileApp\AppController@get_franchise_apply_details');
Route::post('check_user_active_status', 'MobileApp\AppController@check_user_active_status');
Route::post('get_user_details', 'MobileApp\AppController@get_user_details');
Route::post('check_login', 'MobileApp\AppController@check_login');
Route::post('update_device_token', 'MobileApp\AppController@update_device_token');
Route::post('profile_image_upload', 'MobileApp\AppController@profile_image_upload');
Route::post('remove_profile_image', 'MobileApp\AppController@remove_profile_image');
Route::post('update_profile_image', 'MobileApp\AppController@update_profile_image');
Route::post('change_password', 'MobileApp\AppController@change_password');
Route::post('fetch_whats_new', 'MobileApp\AppController@fetch_whats_new');
Route::post('get_last_10_franchise', 'MobileApp\AppController@get_last_10_franchise');
Route::post('save_ec_member_details', 'MobileApp\AppController@save_ec_member_details');
Route::post('upload_ec_member_document', 'MobileApp\AppController@upload_ec_member_document');
Route::get('send_ec_member_create_sms/{applicantName}/{mobileNumber}/{ecMemberApplicationNumber}', 'MobileApp\AppController@send_ec_member_create_sms');
Route::post('get_ec_member_apply_details', 'MobileApp\AppController@get_ec_member_apply_details');
Route::post('save_student_details', 'MobileApp\AppController@save_student_details');
Route::post('get_student_details_franchise_wise', 'MobileApp\AppController@get_student_details_franchise_wise');
Route::post('generate_student_certificate', 'MobileApp\AppController@generate_student_certificate');
Route::get('send_generate_certificate_sms/{studentName}/{certificateNumber}/{mobileNumber}', 'MobileApp\AppController@send_generate_certificate_sms');
Route::post('get_ec_member_list', 'MobileApp\AppController@get_ec_member_list');
Route::post('get_franchise_list', 'MobileApp\AppController@get_franchise_list');

Route::post('save_share_details', 'MobileApp\AppController@save_share_details');
Route::post('save_feedback', 'MobileApp\AppController@save_feedback');



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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

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

Route::middleware('auth:api')->group(function () {



    Route::get('web_get_all_applied_franchise_list', 'FranchiseController@getAllAppliedFranchiseList');

Route::get('web_get_all_rejected_franchise_list', 'FranchiseController@getAllRejectedFranchiseList');
Route::get('web_get_all_approved_franchise_list', 'FranchiseController@getAllApprovedFranchiseList');
Route::post('web_get_ec_member_list_not_assigned_to_franchise', 'FranchiseController@getAllECMemberListNotAssignedtoFranchise');
Route::post('web_approve_reject_applied_franchise', 'FranchiseController@approveRejectAppliedFranchise');
Route::post('web_assign_ec_member_to_franchise', 'FranchiseController@assignECMemberToFranchise');


Route::get('web_get_all_applied_executive_list', 'ExecutiveController@getAllAppliedExecutiveList');
Route::get('web_get_all_rejected_executive_list', 'ExecutiveController@getAllRejectedExecutiveList');
Route::get('web_get_all_approved_executive_list', 'ExecutiveController@getAllApprovedExecutiveList');
Route::post('web_approve_reject_applied_executive', 'ExecutiveController@approveRejectAppliedExecutive');



Route::get('web_get_all_active_student_franchise_wise_list', 'StudentController@getActiveStudentListFranchiseWise');
Route::get('web_get_all_certificate_request_generated_student_franchise_wise_list', 'StudentController@getCertificateRequestGeneratedStudentListFranchiseWise');
Route::get('web_get_all_certified_student_franchise_wise_list', 'StudentController@getCertifiedStudentListFranchiseWise');
Route::post('web_approve_reject_certificate', 'StudentController@approveRejectCertificate');



Route::get('web_get_all_generated_certificate_franchise_wise_list', 'CertificateController@getGeneratedCertificateListFranchiseWise');
Route::get('web_get_all_approved_certificate_franchise_wise_list', 'CertificateController@getApprovedCertificateListFranchiseWise');
Route::get('web_get_rejected_certificate_franchise_wise_list', 'CertificateController@getRejectedCertificateListFranchiseWise');

Route::post('web_get_approved_franchise_id_name', 'FranchiseController@getApprovedFranchiseIdName');
});
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('web_login', 'UserController@validateLogin')
        ->name('web_login');
    Route::post('web_logout', 'UserController@logout')->name('web_logout');
    Route::post('web_token_refresh', 'UserController@tokenRefresh')->name('web_token_refresh');
    Route::post('web_get_user_details', 'UserController@getUserDetails')->name('web_get_user_details');
    Route::post('web_get_user_permission_details', 'UserController@getUserPermissionDetails')->name('web_get_user_permission_details');


});
