<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingReportController;
use App\Http\Controllers\BookMedicineController;
use App\Http\Controllers\BookTestController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\ClinicSlotController;
use App\Http\Controllers\ClinicSlotDatesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\VideoBookingController;
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
/*============================= Login ======================================*/

Route::post('webValidateLogin', [UserLoginController::class, 'webValidateLogin']);

/*==========================City=========================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('getCity', [CityController::class, 'Get']);
    Route::post('saveCity', [CityController::class, 'Save']);
    Route::post('updateCity', [CityController::class, 'Update']);
    Route::post('deleteCity', [CityController::class, 'delete']);
    Route::post('changeCityStatus', [CityController::class, 'Status']);
    Route::get('getWithoutPaginationCity', [CityController::class, 'getWithoutPaginationCity']);
    Route::get('getCityIdWithoutPagination', [CityController::class, 'getWithoutPaginationCity']);
    Route::get('getCityActive', [CityController::class, 'ActiveCity']);
});

/*==========================Area=========================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('getArea', [AreaController::class, 'Get']);
    Route::post('saveArea', [AreaController::class, 'Save']);
    Route::post('updateArea', [AreaController::class, 'Update']);
    Route::post('changeAreaStatus', [AreaController::class, 'Status']);
    Route::post('deleteArea', [AreaController::class, 'delete']);
    Route::get('getAreaWithoutPagination', [AreaController::class, 'getAreaWithoutPagination']);
    Route::get('getAreaIdWithoutPagination', [AreaController::class, 'getAreaWithoutPagination']);

});

/*==========================Clinic=========================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('webGetClinicDetails', [ClinicController::class, 'Get']);
    Route::post('webChangeClinicActive', [ClinicController::class, 'webChangeClinicActive']);
    Route::post('webChangeMasterClinic', [ClinicController::class, 'webChangeMasterClinic']);
    Route::post('webSaveClinicDetails', [ClinicController::class, 'addClinicDetails']);
    Route::post('webUpdateClinicDetails', [ClinicController::class, 'webUpdateClinicDetails']);
    Route::get('clinicWiseBooking', [ClinicController::class, 'clinicWiseBooking']);
    Route::get('getDoctorDetailsWithoutPagination', [ClinicController::class, 'getDoctorDetailsWithoutPagination']);
    Route::get('webGetDoctorDetails', [ClinicController::class, 'getDoctorDetails']);
    Route::post('webSaveClinicService', [ClinicController::class, 'addClinicService']);
    Route::post('webUpdateClinicService', [ClinicController::class, 'addClinicService']);
    Route::get('webGetClinicService', [ClinicController::class, 'getClinicService']);
    Route::get('webGetClinicTiming', [ClinicController::class, 'webGetClinicTiming']);
    Route::post('webSaveClinicTiming', [ClinicController::class, 'webSaveClinicTiming']);
    Route::post('webUpdateClinicTiming', [ClinicController::class, 'webUpdateClinicTiming']);
});
/*==========================Clinic Slot=========================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('getSlotName', [ClinicSlotController::class, 'getSlotName']);
    Route::get('getSlotDates', [ClinicSlotDatesController::class, 'getAllSlotDates']);
    Route::post('changeDateSlotsStatus', [ClinicSlotDatesController::class, 'slotstatus']);
    Route::post('changeSlotStatus', [ClinicSlotDatesController::class, 'status']);
    Route::post('saveSlotDate', [ClinicSlotDatesController::class, 'saveSlotDate']);
    Route::get('getslotno', [ClinicSlotDatesController::class, 'fetchslotno']);
    Route::post('saveInClinicSlot', [ClinicSlotController::class, 'saveInClinicSlot']);
    Route::get('upcomingBookingDetails', [ClinicController::class, 'upcomingBookingDetails']);
    Route::post('saveDoctorClinicWise', [ClinicSlotController::class, 'saveDoctorClinicWise']);
    Route::post('saveSlotDate', [ClinicSlotDatesController::class, 'saveSlotDate']);
    Route::post('deleteSlotDate', [ClinicSlotDatesController::class, 'deleteSlotDate']);
    Route::post('webUpdateSlotDate', [ClinicSlotDatesController::class, 'webUpdateSlotDate']);
});

/*================Booking Details ==================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('getBookingDetails', [BookingController::class, 'Get']);
    Route::get('clinicActiveDetails', [BookingController::class, 'clinicActiveDetails']);
    Route::get('doctorActiveDetails', [BookingController::class, 'doctorActiveDetails']);

});
/*================ Video Booking Details ==================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('getVideoBookingDetails', [VideoBookingController::class, 'Get']);

    Route::get('getUpcomingVideoBookingDetails', [VideoBookingController::class, 'upcomingVideoBookingDetails']);
    Route::get('webgetCompletedVideoVisitForDoctor', [VideoBookingController::class, 'getCompletedVideoVisitForDoctor']);
    Route::post('webSaveVideoSlotDates', [VideoBookingController::class, 'saveVideoSlotDate']);
    Route::post('webChangeVideoBookingAvailable', [VideoBookingController::class, 'webChangeVideoBookingAvailable']);
    Route::post('webUpdateVideoSlotDate', [VideoBookingController::class, 'updateVideoSlotDate']);
    Route::post('webChangeVideoSlotDatesActive', [VideoBookingController::class, 'webChangeVideoSlotDatesActive']);
    Route::get('webGetVideoSlotDates', [VideoBookingController::class, 'getVideoSlotDates']);
});


/*================Get All User Details ==================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('getAllUserDetails', [UserController::class, 'Get']);
    Route::post('saveDoctorDetails', [UserController::class, 'saveDoctor']);
    Route::post('webUpdateDoctorDetails', [UserController::class, 'updateDoctorDetails']);
    Route::get('webGetDiseaseCategory', [UserController::class, 'webGetDiseaseCategory']);
    Route::post('changeDoctorDetailsStatus', [UserController::class, 'changeDoctorStatus']);
    Route::post('deleteDoctorDetails', [UserController::class, 'deleteDoctorDetails']);
});

/*================Get Patient wise booking Details ==================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('webGetRegisteredPatient', [BookingReportController::class, 'webGetRegisteredPatient']);
    Route::get('webGetInClinicBookingForPatient', [BookingReportController::class, 'getInClinicBookingForPatient']);
    Route::get('webGetVideoBookingForPatient', [BookingReportController::class, 'getVideoBookingForPatient']);
    Route::get('webGetPatientWiseBookingDetails', [BookingReportController::class, 'webGetPatientWiseBookingDetails']);
    Route::get('webGetDoctorWisePatientDetails', [BookingReportController::class, 'webGetDoctorWisePatientDetails']);
    Route::get('webGetVideoVisitClinicWise', [BookingReportController::class, 'webGetVideoVisitClinicWise']);
});

/*=====================Get Book Medicine=====================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('webGetBookMedicine', [BookMedicineController::class, 'webGetBookMedicine']);
    Route::get('webGetPrescriptionDoc', [BookMedicineController::class, 'webGetPrescriptionDoc']);
    Route::post('webChangeBookMedicineStatus', [BookMedicineController::class, 'changeBookMedicineStatus']);
});

/*=====================Get Book Test=====================*/
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('webGetBookTest', [BookTestController::class, 'webGetTestMedicine']);
    Route::get('webGetTestDoc', [BookTestController::class, 'webGetTestDoc']);
    Route::post('webChangeBookTestStatus', [BookTestController::class, 'changeBookTestStatus']);
});
/*==================================================Common=========================== */
Route::post('checkUserStatus', [AppController::class, 'checkUserStatus']);
Route::post('checkMobileNumber', [AppController::class, 'checkMobileNumber']);
Route::post('checkLogin', [AppController::class, 'checkLogin']);
Route::post('updateDeviceToken', [AppController::class, 'updateDeviceToken']);
Route::post('getCity', [AppController::class, 'getCity']);
Route::post('sendPassword', [AppController::class, 'sendPassword']);
Route::post('getArea', [AppController::class, 'getArea']);
Route::post('getSlider', [AppController::class, 'getSlider']);
Route::post('getDiseaseCategory', [AppController::class, 'getDiseaseCategory']);

Route::post('getHealthTips', [AppController::class, 'getHealthTips']);
Route::post('saveHealthTipsLike', [AppController::class, 'saveHealthTipsLike']);
Route::post('deleteHealthTips', [AppController::class, 'deleteHealthTips']);

Route::post('getHealthTipComment', [AppController::class, 'getHealthTipComment']);
Route::post('saveHealthTipcomment', [AppController::class, 'saveHealthTipcomment']);

/*==================================================Customer=========================== */
//Customer/patient
Route::get('sendCustomerSignupOTP/{mobile}/{otp}', [AppController::class, 'sendCustomerSignupOTP']);
Route::post('registerCustomer', [AppController::class, 'registerCustomer']);
Route::post('searchDoctorClinicSpeciality', [AppController::class, 'searchDoctorClinicSpeciality']);
Route::post('getClinicList', [AppController::class, 'getClinicList']);
Route::post('getDctorsList', [AppController::class, 'getDctorsList']);

Route::post('changeCustomerPassword', [AppController::class, 'changeCustomerPassword']);

Route::post('customerProfileImageUpload', [AppController::class, 'customerProfileImageUpload']);
Route::post('updateCustomerProfileImage', [AppController::class, 'updateCustomerProfileImage']);
Route::post('removeCustomerProfileImage', [AppController::class, 'removeCustomerProfileImage']);
Route::post('updateCustomerFirstName', [AppController::class, 'updateCustomerFirstName']);
Route::post('updateCustomerLastName', [AppController::class, 'updateCustomerLastName']);
Route::post('updateCustomerMobileNumber', [AppController::class, 'updateCustomerMobileNumber']);
Route::post('getCustomerPersonalProfileDetails', [AppController::class, 'getCustomerPersonalProfileDetails']);
Route::post('updateCustomerPersonalProfileDetails', [AppController::class, 'updateCustomerPersonalProfileDetails']);

Route::post('getClinicImages', [AppController::class, 'getClinicImages']);
Route::post('getClinicDetails', [AppController::class, 'getClinicDetails']);
Route::post('getClinicTiming', [AppController::class, 'getClinicTiming']);
Route::post('getClinicService', [AppController::class, 'getClinicService']);

Route::post('getDoctorsListClinicWise', [AppController::class, 'getDoctorsListClinicWise']);
Route::post('getDoctorDetails', [AppController::class, 'getDoctorDetails']);
Route::post('getDoctorAssociatedClinic', [AppController::class, 'getDoctorAssociatedClinic']);
Route::post('getDoctorOtherDetails', [AppController::class, 'getDoctorOtherDetails']);
Route::post('getInClinicBookingSlotDates', [AppController::class, 'getInClinicBookingSlotDates']);
Route::post('getInClinicSlotIdPositionDateWise', [AppController::class, 'getInClinicSlotIdPositionDateWise']);
Route::post('getInClinicSlotIdPositionDateWiseForMyBooking', [AppController::class, 'getInClinicSlotIdPositionDateWiseForMyBooking']);

Route::post('getInClinicBookingSlotPosition', [AppController::class, 'getInClinicBookingSlotPosition']);
Route::post('saveUpdateFamilyMember', [AppController::class, 'saveUpdateFamilyMember']);

Route::post('getFamilyMemberList', [AppController::class, 'getFamilyMemberList']);

Route::post('saveInClinicBooking', [AppController::class, 'saveInClinicBooking']);
Route::post('getInClinicBookingList', [AppController::class, 'getInClinicBookingList']);

Route::post('cancelInClinicBooking', [AppController::class, 'cancelInClinicBooking']);

Route::post('getPrivacyPolicy', [AppController::class, 'getPrivacyPolicy']);

// Clinic
Route::post('clinicProfileImageUpload', [AppController::class, 'clinicProfileImageUpload']);
Route::post('updateClinicProfileImage', [AppController::class, 'updateClinicProfileImage']);
Route::post('removeClinicProfileImage', [AppController::class, 'removeClinicProfileImage']);
Route::post('updateClinicFirstName', [AppController::class, 'updateClinicFirstName']);
Route::post('updateClinicLastName', [AppController::class, 'updateClinicLastName']);
Route::post('updateClinicMobileNumber', [AppController::class, 'updateClinicMobileNumber']);
Route::post('saveInClinicBookingByClinic', [AppController::class, 'saveInClinicBookingByClinic']);
Route::post('getInClinicBookingListByClinic', [AppController::class, 'getInClinicBookingListByClinic']);

Route::post('getInClinicBookingSlotDateByClinic', [AppController::class, 'getInClinicBookingSlotDateByClinic']);
Route::post('getDoctorListDateSlotClinicWise', [AppController::class, 'getDoctorListDateSlotClinicWise']);

Route::post('getInClinicBookingByClinicDoctorSlotDate', [AppController::class, 'getInClinicBookingByClinicDoctorSlotDate']);
Route::post('completeInClinicBooking', [AppController::class, 'completeInClinicBooking']);

Route::post('cancelAllInClinicBooking', [AppController::class, 'cancelAllInClinicBooking']);

Route::get('sendAllTypeSMS', [AppController::class, 'sendAllTypeSMS']);
Route::get('getSMSStatus', [AppController::class, 'getSMSStatus']);

Route::post('notifyCustomerAboutDoctorDateSlot', [AppController::class, 'notifyCustomerAboutDoctorDateSlot']);
Route::post('searchDoctor', [AppController::class, 'searchDoctor']);

Route::post('autoCancelInClinicBooking', [AppController::class, 'autoCancelInClinicBooking']);

Route::post('getApolloDoctor', [AppController::class, 'getApolloDoctor']);
Route::post('markDoctorIn', [AppController::class, 'markDoctorIn']);
Route::post('getSpecializationWiseDisease', [AppController::class, 'getSpecializationWiseDisease']);
Route::post('markPatientAbsent', [AppController::class, 'markPatientAbsent']);
// Video Booking
Route::post('getVideoVisitDoctorList', [AppController::class, 'getVideoVisitDoctorList']);
Route::post('getVideoBookingSlotDates', [AppController::class, 'getVideoBookingSlotDates']);
Route::post('notifyCustomerAboutDoctorVideoDateSlot', [AppController::class, 'notifyCustomerAboutDoctorVideoDateSlot']);
Route::post('getVideoSlotIdPositionDateWise', [AppController::class, 'getVideoSlotIdPositionDateWise']);
Route::post('getVideoBookingSlotPosition', [AppController::class, 'getVideoBookingSlotPosition']);
Route::post('saveVideoBooking', [AppController::class, 'saveVideoBooking']);
Route::post('getVideoBookingList', [AppController::class, 'getVideoBookingList']);
Route::post('cancelVideoBooking', [AppController::class, 'cancelVideoBooking']);
Route::post('saveVideoBookingByClinic', [AppController::class, 'saveVideoBookingByClinic']);
Route::post('getVideoBookingListByClinic', [AppController::class, 'getVideoBookingListByClinic']);
//doctor
Route::post('doctorProfileImageUpload', [AppController::class, 'doctorProfileImageUpload']);
Route::post('updateDoctorProfileImage', [AppController::class, 'updateDoctorProfileImage']);
Route::post('removeDoctorProfileImage', [AppController::class, 'removeDoctorProfileImage']);
Route::post('updateDoctorFirstName', [AppController::class, 'updateDoctorFirstName']);
Route::post('updateDoctorLastName', [AppController::class, 'updateDoctorLastName']);
Route::post('updateDoctorMobileNumber', [AppController::class, 'updateDoctorMobileNumber']);
Route::post('getCurrentVideoVisitBookingListForDoctor', [AppController::class, 'getCurrentVideoVisitBookingListForDoctor']);
Route::post('markVideoVisitComplete', [AppController::class, 'markVideoVisitComplete']);
Route::post('getCompletedVideoVisitForDoctor', [AppController::class, 'getCompletedVideoVisitForDoctor']);
Route::post('logout', [AppController::class, 'logout']);
Route::post('uploadChatFile', [AppController::class, 'uploadChatFile']);
Route::post('getInClinicBookingListByDoctor', [AppController::class, 'getInClinicBookingListByDoctor']);

//Book medicine

Route::post('getCustomerBookMedicine', [AppController::class, 'getCustomerBookMedicine']);
Route::post('uploadPrescription', [AppController::class, 'uploadPrescription']);
Route::post('insertPrescriptionName', [AppController::class, 'insertPrescriptionName']);
Route::post('getBookMedicineDoc', [AppController::class, 'getBookMedicineDoc']);
Route::post('deleteBookMedicineDoc', [AppController::class, 'deleteBookMedicineDoc']);
Route::post('saveBookingMedicine', [AppController::class, 'saveBookingMedicine']);

//Book test

Route::post('getCustomerBookTest', [AppController::class, 'getCustomerBookTest']);
Route::post('uploadPrescriptionTest', [AppController::class, 'uploadPrescriptionTest']);
Route::post('insertTestName', [AppController::class, 'insertTestName']);
Route::post('getBookTestDoc', [AppController::class, 'getBookTestDoc']);
Route::post('deleteBookTestDoc', [AppController::class, 'deleteBookTestDoc']);
Route::post('saveBookingTest', [AppController::class, 'saveBookingTest']);

//Country
Route::post('getCountry', [AppController::class, 'getCountry']);
Route::get('sendCustomerSignupOTPForInternationalUser/{mobile}/{otp}', [AppController::class, 'sendCustomerSignupOTPForInternationalUser']);


// dummy function to insert slot date
Route::get('insertSlotDate', [AppController::class, 'insertSlotDate']);
