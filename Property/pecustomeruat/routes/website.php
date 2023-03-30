<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutUsController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\AgentController;
use App\Http\Controllers\Frontend\ContactUsController;
use App\Http\Controllers\Frontend\SignUpController;
use App\Http\Controllers\Frontend\AgentEnquiryController;
use App\Http\Controllers\Frontend\PropertyEnquiryController;
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


Route::get('/',[HomeController::class,'index'])->name('index');
Route::get('/about',[AboutUsController::class,'about'])->name('about');
Route::get('/property-list',[HomeController::class,'propertylist'])->name('propertylist');
Route::get('/blogs',[BlogController::class,'blogs'])->name('blogs');
Route::get('/agents',[AgentController::class,'agents'])->name('agents');
Route::get('/contact',[ContactUsController::class,'contact'])->name('contact');
Route::get('/agentpage/{slug?}',[AgentController::class,'agentpage'])->name('agentpage');
Route::get('/singleproperty/{slug?}',[HomeController::class,'singleproperty'])->name('single-property');
Route::get('/blogdetails',[BlogController::class,'blogdetail'])->name('blogdetails');

Route::get('/getpropertyfilter',[HomeController::class,'propertyfilter'])->name('getpropertyfilter');
Route::get('/getsearchfilter',[HomeController::class,'getsearchfilter'])->name('getsearchfilter');
Route::post('/property-enquiry',[PropertyEnquiryController::class,'propertyenquiry'])->name('property-enquiry');
Route::post('/agentenquiry',[AgentEnquiryController::class,'agentenquiry'])->name('agentenquiry');
Route::post('/contactenquiry',[ContactUsController::class,'contactenquiry'])->name('contactenquiry');
Route::get('manyactivation/{id}',[SignUpController::class,'activation'])->name('activation');

Route::get('/searchagents/{full_name?}',[AgentController::class,'searchagents'])->name('searchagents');
Route::post('/normalsearch',[HomeController::class,'normalsearch'])->name('normalsearch');

Route::get('/propertysearchfilter',[HomeController::class,'propertysearchfilter'])->name('propertysearchfilter');
Route::post('/signup',[SignUpController::class,'signup'])->name('signup');


