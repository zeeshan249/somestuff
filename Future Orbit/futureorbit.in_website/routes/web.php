<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutUs\AboutUsController;
use App\Http\Controllers\ContactUs\ContactUsController;
use App\Http\Controllers\Enquiry\EnquiryController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Faq\FaqController;
use App\Http\Controllers\Exam\ExamController;
use App\Http\Controllers\Scholarship\ScholarshipController;
use App\Http\Controllers\Teacher\TeacherController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/',[HomeController::class,'index'])->name('index');
Route::get('/aboutus',[AboutUsController::class,'aboutus'])->name('aboutus');
Route::get('/contactus',[ContactUsController::class,'contactus'])->name('contactus');
Route::get('/enquiry',[EnquiryController::class,'enquiry'])->name('enquiry');
Route::get('/allcourses',[CourseController::class,'allcourses'])->name('allcourses');
Route::get('/coursedetails/{id?}',[CourseController::class,'coursedetails'])->name('coursedetails');
Route::get('/allexams',[ExamController::class,'allexams'])->name('allexams');
Route::get('/faq',[FaqController::class,'faq'])->name('faq');
//ajax function
Route::get('/fetchCourses',[ContactUsController::class,'fetchCourses'])->name('fetchCourses');
//end of ajax route
Route::post('/enquirysubmit',[ContactUsController::class,'enquirySubmit'])->name('enquirySubmit');

//Route::get('/scholarshiptest',[ScholarshipController::class,'index'])->name('scholarshiptest');
Route::get('/teacher/{id}',[TeacherController::class,'index'])->name('teacher');
//Route::post('/submitscholarship',[ScholarshipController::class,'submitscholarship'])->name('submitscholarship');
