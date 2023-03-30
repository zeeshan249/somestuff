<?php

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

Route::get('/cachereset', function () {
    Artisan::call('cache-reset');
});

//For Mobile App
Route::post('checkUserStatus', 'AppController@checkUserStatus');
Route::post('checkMobileNumber', 'AppController@checkMobileNumber');
Route::post('checkLogin', 'AppController@checkLogin');
Route::post('updateDeviceToken', 'AppController@updateDeviceToken');
Route::post('getCommonAboutUs', 'AppController@getCommonAboutUs');
Route::post('getCourseList', 'AppController@getCourseList');
Route::post('getGalleryList', 'AppController@getGalleryList');

Route::get('sendStudentSignupOTP/{mobile}/{otp}', [AppController::class, 'sendStudentSignupOTP']);
Route::post('changePassword', 'AppController@changePassword');
Route::post('studentProfileImageUpload', 'AppController@studentProfileImageUpload');
Route::post('updateStudentProfileImage', 'AppController@updateStudentProfileImage');
Route::post('removeStudentProfileImage', 'AppController@removeStudentProfileImage');
Route::post('updateStudentFirstName', 'AppController@updateStudentFirstName');
Route::post('updateStudentLastName', 'AppController@updateStudentLastName');
Route::post('updateStudentMobileNumber', 'AppController@updateStudentMobileNumber');
Route::post('getStudentCourseMapping', 'AppController@getStudentCourseMapping');

Route::post('getExamScheduleCourseWise', 'AppController@getExamScheduleCourseWise');
Route::post('getExamCardByStudentCourseWise', 'AppController@getExamCardByStudentCourseWise');
Route::post('getExamInstruction', 'AppController@getExamInstruction');
Route::post('getExamQuestion', 'AppController@getExamQuestion');
Route::post('saveExam', 'AppController@saveExam');
Route::post('getExamReview', 'AppController@getExamReview');

Route::post('getExamAnalysisUserWise', 'AppController@getExamAnalysisUserWise');
Route::post('getExamAnalysisTopUser', 'AppController@getExamAnalysisTopUser');
Route::post('getExamAnalysisTopicWise', 'AppController@getExamAnalysisTopicWise');
Route::post('getExamAnswer', 'AppController@getExamAnswer');
Route::get('send_notification', 'AppController@send_notification');

//End

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',

], function ($router) {

    Route::post('web_login', 'UserController@validateLogin')
        ->name('web_login');
    Route::post('web_logout', 'UserController@logout')->name('web_logout');
    Route::post('web_token_refresh', 'UserController@tokenRefresh')->name('web_token_refresh');
    Route::post('web_get_logged_user_details_with_role_permission', 'UserController@getLoggedUserDetailsWithRolesPermission')->name('web_get_logged_user_details_with_role_permission');
 
});

Route::group(['middleware' => ['auth:api', 'permission:Add Role']], function () {

    // Save Role
    Route::post('web_save_role', 'SystemSettingsController@saveRole')->name('web_save_role');
    //Change Password
    Route::post('web_get_logged_change_password', 'UserController@loggedUserChangePassword')->name('web_get_logged_change_password');
});
Route::group(['middleware' => ['auth:api', 'permission:Roles Permissions']], function () {

    // View All Roles
    Route::get('web_get_all_roles', 'SystemSettingsController@getAllRoles')->name('web_get_all_roles');
});

Route::group(['middleware' => ['auth:api', 'permission:Edit Role']], function () {

    // Edit Role
    Route::post('web_update_role', 'SystemSettingsController@updateRole')->name('web_update_role');
});

Route::group(['middleware' => ['auth:api', 'permission:Assign Permission']], function () {
    // View & Assign Permission
    Route::post('web_get_assigned_unassigned_permission_role_wise', 'SystemSettingsController@getAssignedUnAssignedPermissionRoleWise')->name('web_get_assigned_unassigned_permission_role_wise');
    Route::post('web_assign_permission_role_wise', 'SystemSettingsController@assignPermissionRoleWise')->name('web_assign_permission_role_wise');
    Route::post('web_assign_individual_permission_role_wise', 'SystemSettingsController@assignIndividualPermissionRoleWise')->name('web_assign_individual_permission_role_wise');
});

Route::group(['middleware' => ['auth:api', 'permission:Department']], function () {

    // View All Department
    Route::get('web_get_all_departments', 'DepartmentController@getAllDepartments')->name('web_get_all_departments');
});

Route::group(['middleware' => ['auth:api', 'permission:Add Department']], function () {

    // Save Department
    Route::post('web_save_department', 'DepartmentController@saveDepartment')->name('web_save_department');
});

Route::group(['middleware' => ['auth:api', 'permission:Edit Role']], function () {

    // Edit Department
    Route::post('web_update_department', 'DepartmentController@updateDepartment')->name('web_update_department');
});

Route::group(['middleware' => ['auth:api', 'permission:Designation']], function () {

    // View All Designation
    Route::get('web_get_all_designations', 'DesignationController@getAllDesignations')->name('web_get_all_designations');
});

Route::group(['middleware' => ['auth:api', 'permission:Add Designation']], function () {

    // Save Designation
    Route::post('web_save_designation', 'DesignationController@saveDesignation')->name('web_save_designation');
});

Route::group(['middleware' => ['auth:api', 'permission:Edit Designation']], function () {

    // Edit Designation
    Route::post('web_update_designation', 'DesignationController@updateDesignation')->name('web_update_designation');
});

Route::group(['middleware' => ['auth:api', 'permission:Prefix']], function () {

    // View All Prefix
    Route::get('web_get_all_prefix', 'PrefixController@getAllPrefix')->name('web_get_all_prefix');
});

Route::group(['middleware' => ['auth:api', 'permission:Edit Prefix']], function () {

    // Save Prefix
    Route::post('web_save_prefix', 'PrefixController@savePrefix')->name('web_save_prefix');
});

Route::group(['middleware' => ['auth:api', 'permission:Staff']], function () {

    // View All Staff
    Route::get('web_get_all_staff', 'StaffController@getAllStaff')->name('web_get_all_staff');

    Route::get('web_get_all_staff_without_pagination', 'StaffController@getAllStaffWithoutPagination')->name('web_get_all_staff_without_pagination');
});

Route::group(['middleware' => ['auth:api', 'permission:Staff']], function () {

    // View All Active Roles
    Route::get('web_get_all_active_roles_without_pagination', 'SystemSettingsController@getAllActiveRolesWithoutPagination')->name('web_get_all_active_roles_without_pagination');
});

Route::group(['middleware' => ['auth:api', 'permission:Edit Staff']], function () {

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
});

Route::group(['middleware' => ['auth:api', 'permission:Add Staff|Edit Staff']], function () {

    // save staff basic info
    Route::post('web_save_edit_staff_basic_info', 'StaffController@saveEditStaffBasicInfo')->name('web_save_edit_staff_basic_info');
});

Route::group(['middleware' => ['auth:api', 'permission:Add Staff|Edit Staff']], function () {

    // Edit payroll info
    Route::post('web_edit_staff_payroll_info', 'StaffController@editStaffPayrollInfo')->name('web_edit_staff_payroll_info');
});

Route::group(['middleware' => ['auth:api', 'permission:Add Staff|Edit Staff']], function () {

    // Edit payroll info
    Route::post('web_edit_staff_bank_details_info', 'StaffController@editStaffBankDetailsInfo')->name('web_edit_staff_bank_details_info');
});

Route::group(['middleware' => ['auth:api', 'permission:Add Staff|Edit Staff']], function () {

    // Edit social link info
    Route::post('web_edit_staff_social_link_info', 'StaffController@editStaffSocialLinkInfo')->name('web_edit_staff_social_link_info');
});

Route::group(['middleware' => ['auth:api', 'permission:Add Staff|Edit Staff']], function () {

    // Edit social link info
    Route::post('web_edit_staff_upload_document_info', 'StaffController@editStaffUploadDocumentInfo')->name('web_edit_staff_upload_document_info');
});

Route::group(['middleware' => ['auth:api', 'permission:Staff']], function () {

    // Get Staff Details ID wise
    Route::post('web_get_staff_details_id_wise', 'StaffController@getStaffDetailsIdWise')->name('web_get_staff_details_id_wise');
});

Route::group(['middleware' => ['auth:api', 'permission:Add Course|Edit Course']], function () {

    // Save Edit Course
    Route::post('web_save_update_course', 'CourseController@saveUpdateCourse')->name('web_save_update_course');
});

Route::group(['middleware' => ['auth:api', 'permission:Staff']], function () {

    // View All Course
    Route::get('web_get_all_course', 'CourseController@getAllCourse')->name('web_get_all_course');
});

Route::group(['middleware' => ['auth:api', 'permission:Edit Course']], function () {

    // Enable disable course
    Route::post('web_enable_disable_course', 'CourseController@enableDisableCourse')->name('web_enable_disable_course');
});

Route::group(['middleware' => ['auth:api', 'permission:Subject']], function () {

    // View All Subject
    Route::get('web_get_all_subject', 'SubjectController@getAllSubject')->name('web_get_all_subject');
    // View All Active Courses for Subject Page
    Route::get('web_get_all_active_courses_without_pagination', 'SubjectController@getActiveCourseWithoutPagination')->name('web_get_all_active_courses_without_pagination');
    // Save Edit Subject
    Route::post('web_save_update_subject', 'SubjectController@saveUpdateSubject')->name('web_save_update_subject');
    // Enable disable Subject
    Route::post('web_enable_disable_subject', 'SubjectController@enableDisableSubject')->name('web_enable_disable_subject');
});

Route::group(['middleware' => ['auth:api', 'permission:Topic']], function () {

    // View All Subject
    Route::get('web_get_all_topic', 'TopicController@getAllTopic')->name('web_get_all_topic');

    // View All Active Courses for Subject Page
    Route::get('web_get_all_active_subject_based_on_course_without_pagination', 'TopicController@getActiveSubjectBasedOnCourseWithoutPagination')->name('web_get_all_active_subject_based_on_course_without_pagination');
    // Save Edit Subject
    Route::post('web_save_update_topic', 'TopicController@saveUpdateTopic')->name('web_save_update_topic');
    // Enable disable Subject
    Route::post('web_enable_disable_topic', 'TopicController@enableDisableTopic')->name('web_enable_disable_topic');
});

Route::group(['middleware' => ['auth:api', 'permission:Edit Information Source']], function () {

    // Enable disable Information Source
    Route::post('web_enable_disable_information_source', 'InformationSourceController@enableDisableInformationSource')->name('web_enable_disable_information_source');
});

Route::group(['middleware' => ['auth:api', 'permission:Add Information Source|Edit Information Source']], function () {

    // Save Edit Information source
    Route::post('web_save_update_information_source', 'InformationSourceController@saveUpdateInformationSource')->name('web_save_update_information_source');
});

Route::group(['middleware' => ['auth:api', 'permission:Staff']], function () {

    // View All Information Source
    Route::get('web_get_all_information_source', 'InformationSourceController@getAllInformationSource')->name('web_get_all_information_source');
});

Route::group(['middleware' => ['auth:api', 'permission:Staff']], function () {

    // View All Information Source
    Route::get('web_get_all_school', 'SchoolController@getAllSchool')->name('web_get_all_school');
    // Save Edit Information source
    Route::post('web_save_update_school', 'SchoolController@saveUpdateSchool')->name('web_save_update_school');
    Route::post('web_enable_disable_school', 'SchoolController@enableDisableSchool')->name('web_enable_disable_school');
});

Route::group(['middleware' => ['auth:api', 'permission:Staff']], function () {

    // View All Active Enquiry Sources
    Route::get('web_get_all_active_sources_without_pagination', 'SystemSettingsController@getAllActiveSourcesWithoutPagination')->name('web_get_all_active_sources_without_pagination');
});

Route::group(['middleware' => ['auth:api', 'permission:Add Enquiry|Edit Enquiry|Delete Enquiry']], function () {

    // View All Enquiry
    Route::get('web_get_all_enquiry', 'EnquiryController@getAllEnquiry')->name('web_get_all_enquiry');
    // Enable disable Enquiry
    Route::post('web_enable_disable_enquiry', 'EnquiryController@enableDisableEnquiry')->name('web_enable_disable_enquiry');
});

Route::group(['middleware' => ['auth:api']], function () {
    // Get Active Courses without pagination
    Route::get('web_get_active_course_without_pagination', 'CourseController@getActiveCourseWithoutPagination')->name('web_get_active_course_without_pagination');
});

Route::group(['middleware' => ['auth:api']], function () {
    // Get Active Courses without pagination
    Route::get('web_get_active_school_without_pagination', 'SystemSettingsController@web_get_active_school_without_pagination')->name('web_get_active_school_without_pagination');
});

Route::group(['middleware' => ['auth:api', 'permission:Add Staff|Edit Staff']], function () {

    // save staff basic info
    Route::post('web_save_edit_enquiry_basic_info', 'EnquiryController@saveEditEnquiryBasicInfo')->name('web_save_edit_enquiry_basic_info');
});

//Exam------------------------------

Route::group(['middleware' => ['auth:api', 'permission:Exam Schedule']], function () {

    // View All Active Enquiry Sources
    Route::get('web_get_all_active_exam_type_without_pagination', 'ExamController@getAllActiveExamTypeWithoutPagination')->name('web_get_all_active_exam_type_without_pagination');

    //Get All Exam Schedule
    Route::get('web_get_all_exam_schedule', 'ExamController@getAllExamSchedule')->name('web_get_all_exam_schedule');
    Route::get('web_get_all_exam_schedule_over', 'ExamController@getAllExamSchedule_over')->name('web_get_all_exam_schedule_over');
    Route::get('web_get_all_exam_schedule_upcoming', 'ExamController@getAllExamSchedule_upcoming')->name('web_get_all_exam_schedule_upcoming');

    // View All Active Enquiry Sources
    Route::get('web_get_all_active_instruction_without_pagination', 'ExamController@getAllActiveInstructionWithoutPagination')->name('web_get_all_active_instruction_without_pagination');

    // Get Active Schedule Type without pagination
    Route::get('web_get_active_schedule_type_without_pagination', 'ExamController@web_get_active_schedule_type_without_pagination')->name('web_get_active_schedule_type_without_pagination');

    // save Exam Schedule
    Route::post('web_save_edit_exam_schedule', 'ExamController@saveEditExamSchedule')->name('web_save_edit_exam_schedule');

    // Enable disable Exam schedule
    Route::post('web_enable_disable_exam_schedule', 'ExamController@enableDisableExamSchedule')->name('web_enable_disable_exam_schedule');

    // View All Instruction
    Route::get('web_get_all_instruction', 'ExamController@getAllInstruction')->name('web_get_all_instruction');

    // Save Instruction
    Route::post('web_save_instruction', 'ExamController@saveInstruction')->name('web_save_instruction');

    // Disable Instruction
    Route::post('web_enable_disable_instruction', 'ExamController@enableDisableInstruction')->name('web_enable_disable_instruction');

    // Active Topic Based on Subject
    Route::get('web_get_all_active_topic_based_on_subject_without_pagination', 'SystemSettingsController@getActiveTopicBasedOnSubject')->name('web_get_all_active_topic_based_on_subject_without_pagination');

    // Active Difficulty Level
    Route::get('web_get_active_difficulty_level_wp', 'QuestionBankController@getActiveDifficultyLevel')->name('web_get_active_difficulty_level_wp');
    // save Question Bank
    Route::post('web_save_edit_qestion_bank', 'QuestionBankController@saveEditQuestionBank')->name('web_save_edit_qestion_bank');

    //Get Question Bank
    Route::get('web_get_all_question_bank', 'QuestionBankController@getAllQuestionBank')->name('web_get_all_question_bank');

    //Get Question Bank Based on Condition
    Route::get('web_get_all_question_bank_based_on_condition', 'QuestionBankController@getAllQuestionBankBasedOnCondition')->name('web_get_all_question_bank_based_on_condition');

    // save Question Bank
    Route::post('web_save_copy_question_bank', 'QuestionBankController@SaveCopyQuestion')->name('web_save_copy_question_bank');

    //Get Question Bank CourseWise Based on Exam
    Route::get('web_get_all_question_bank_exam_wise', 'QuestionBankController@getAllQuestionBankExamWise')->name('web_get_all_question_bank_exam_wise');

    //Get Question & Maerks Added
    Route::get('web_get_question_marks_added_exam_wise', 'QuestionBankController@getAddedMarksQuestionExamWise')->name('web_get_question_marks_added_exam_wise');

    // save Question Bank
    Route::post('web_add_or_remove_question', 'QuestionBankController@AddRemoveQuestion')->name('web_add_or_remove_question');

    Route::post('web_delete_question_bank', 'QuestionBankController@deleteQuestonBank')->name('web_delete_question_bank');
});

//Student Registration
Route::group(['middleware' => ['auth:api', 'permission:Add Staff|Edit Staff']], function () {

    // save staff basic info
    Route::post('web_register_user', 'EnquiryController@registerUser')->name('web_register_user');
});

//Notice
Route::group(['middleware' => ['auth:api']], function () {

    // List All Notice
    Route::get('web_get_all_notice', 'NoticeController@getAllNotice')->name('web_get_all_notice');
    Route::get('web_get_all_role_without_pagination', 'NoticeController@getAllRoles')->name('web_get_all_role_without_pagination');
    // Save update notice
    Route::post('web_save_update_notice', 'NoticeController@saveUpdateNotice')->name('web_save_update_notice');
    Route::post('web_enable_disable_notice', 'NoticeController@enableDisableNotice')->name('web_enable_disable_notice');
});

//Post
Route::group(['middleware' => ['auth:api']], function () {

    // List All Notice
    Route::get('web_get_all_post', 'NoticeController@getAllPost')->name('web_get_all_post');
    // Route::get('web_get_all_role_without_pagination', 'NoticeController@getAllRoles')->name('web_get_all_role_without_pagination');
    // // Save update notice
    // Route::post('web_save_update_notice', 'NoticeController@saveUpdateNotice')->name('web_save_update_notice');
    Route::post('web_is_approve_post', 'NoticeController@isApprovePost')->name('web_is_approve_post');
});

Route::group(['middleware' => ['auth:api']], function () {

    // List All notification
    Route::get('web_get_all_notification', 'NoticeController@getAllNotification')->name('web_get_all_notification');
    // Route::get('web_get_all_role_without_pagination', 'NoticeController@getAllRoles')->name('web_get_all_role_without_pagination');
    // Save update notice
    Route::post('web_save_notification', 'NoticeController@saveNotification')->name('web_save_notification');
    Route::post('web_delete_notification', 'NoticeController@deleteNotification')->name('web_delete_notification');
});

//Subscription
Route::group(['middleware' => ['auth:api']], function () {

    // Get - Subscription
    Route::get('web_get_all_subscription', 'SubscriptionController@getAllSubscription')->name('web_get_all_subscription');
    Route::get('web_get_all_assigned_subscription', 'SubscriptionController@getAllAssignedSubscription')->name('web_get_all_assigned_subscription');

    // Post - Subscription
    Route::post('web_save_update_subscription', 'SubscriptionController@saveUpdateSubscription')->name('web_save_update_subscription');
    Route::post('web_enable_disable_subscription', 'SubscriptionController@enableDisableSubscription')->name('web_enable_disable_subscription');
    Route::post('web_assign_subscription', 'SubscriptionController@addSubscription')->name('web_assign_subscription');
    Route::post('web_enable_disable_student_subscription', 'SubscriptionController@enableDisableStudentSubscription')->name('web_enable_disable_student_subscription');
});

//Batch
Route::group(['middleware' => ['auth:api']], function () {

    // Get - Batch
    Route::get('web_get_all_batch', 'BatchController@getAllBatch')->name('web_get_all_batch');
    Route::get('web_get_all_active_faculties_without_pagination', 'BatchController@getActiveFaculties')->name('web_get_all_active_faculties_without_pagination');

    Route::get('web_get_slot_details_by_Batch_without_pagination', 'BatchController@getAllSlotDetailsByBatch')->name('web_get_slot_details_by_Batch_without_pagination');
    Route::get('web_get_get_all_student_batch_wise', 'BatchController@getAllBatchWiseStudent')->name('web_get_get_all_student_batch_wise');
    Route::get('web_get_all_students_not_in_batch', 'BatchController@getAllStudentNotInBatch')->name('web_get_all_students_not_in_batch');
    Route::get('web_get_all_students_not_in_batch_without_pagination', 'BatchController@getAllStudentNotInBatchWithoutPagination')->name('web_get_all_students_not_in_batch_without_pagination');
    Route::get('web_get_all_batch_wise_slot_details', 'BatchController@getAllBatchWiseSlotDetails')->name('web_get_all_batch_wise_slot_details');
    //  Post - Batch
    Route::post('web_save_update_batch', 'BatchController@saveUpdateBatch')->name('web_save_update_batch');
    Route::post('web_enable_disable_batch', 'BatchController@enableDisableBatch')->name('web_enable_disable_batch');
    Route::post('web_disable_slot', 'BatchController@disableSlot')->name('web_disable_slot');

    Route::post('web_student_assign_batch', 'BatchController@studentAssignBatch')->name('web_student_assign_batch');

    Route::get('web_get_all_batch_without_pagination', 'BatchController@getAllBatchWithoutPagination')->name('web_get_all_batch_without_pagination');
});
//Attendance
Route::group(['middleware' => ['auth:api']], function () {

    // Get - Batch
    Route::get('web_get_all_batch_attendance', 'BatchController@getAllBatchAttendance')->name('web_get_all_batch_attendance');
    Route::get('web_get_all_attendance_dates', 'BatchController@getAttendanceDates')->name('web_get_all_attendance_dates');
    Route::get('web_get_all_attendance_date_wise', 'BatchController@getAttendanceDateWise')->name('web_get_all_attendance_date_wise');
});
//Students

Route::group(['middleware' => ['auth:api', 'permission:Staff']], function () {

    // View All Students- APP
    Route::get('web_get_all_students', 'EnquiryController@getAllRegisteredStudents')->name('web_get_all_students');

    // View All Students- Internal
    Route::get('web_get_all_students_internal', 'EnquiryController@getAllRegisteredStudentsInternal')->name('web_get_all_students_internal');

    // View All Students- Batch
    Route::get('web_get_all_students_batch', 'EnquiryController@getAllRegisteredStudentsBatch')->name('web_get_all_students_batch');

    //   // View All Students
    Route::get('web_get_all_students_all', 'EnquiryController@getAllRegisteredStudentsAll')->name('web_get_all_students_all');
    //Update Enquiry Details
    Route::post('web_update_student_details', 'EnquiryController@updateStudentDetails')->name('web_update_student_details');

    Route::get('web_get_student_attendance_date_wise', 'BatchController@getStudentAttendanceDateWise')->name('web_get_student_attendance_date_wise');
});

//Report
Route::group(['middleware' => ['auth:api']], function () {

    //Get All Exam Schedule
    Route::get('web_get_all_exam_schedule_report', 'ExamReportController@getAllExamSchedule_Report')->name('web_get_all_exam_schedule_report');
    Route::get('web_get_all_exam_student_wise_report', 'ExamReportController@getStudentWiseExamSchedule_Report')->name('web_get_all_exam_student_wise_report');
    Route::get('web_get_all_exam_student_report', 'ExamReportController@getStudentWiseReport')->name('web_get_all_exam_student_report');
});

//Child Course

Route::group(['middleware' => ['auth:api']], function () {

    // View All Course
    Route::get('web_get_all_child_course', 'CourseController@getAllChildCourse')->name('web_get_all_child_course');
    // Save Edit Course
    Route::post('web_save_update_child_course', 'CourseController@saveUpdateChildCourse')->name('web_save_update_child_course');
    // Enable disable course
    Route::post('web_enable_disable_child_course', 'CourseController@enableDisableChildCourse')->name('web_enable_disable_child_course');
    // View All Active Courses for Subject Page
    Route::get('web_get_all_active_child_course_wp', 'TopicController@getActiveChildCourseWP')->name('web_get_all_active_child_course_wp');
});

//Assignment
Route::group(['middleware' => ['auth:api']], function () {

    Route::get('web_get_all_assignment_documents', 'AssignmentController@getDocumentAssignmentWise')->name('web_get_all_assignment_documents');
    Route::get('web_get_all_assignment', 'AssignmentController@getAllAssignment')->name('web_get_all_assignment');
    Route::get('web_get_get_all_submitted_assignment', 'AssignmentController@getAllSubmittedAssignment')->name('web_get_get_all_submitted_assignment');
    Route::get('web_get_submitted_assignment_details', 'AssignmentController@getSubmittedAssignmentDetails')->name('web_get_submitted_assignment_details');
    Route::post('web_evaluate_assignment', 'AssignmentController@evaluateAssignment')->name('web_evaluate_assignment');
    Route::post('web_save_update_assignment', 'AssignmentController@saveUpdateAssignment')->name('web_evaluate_assignment');
    Route::post('web_upload_assignment', 'AssignmentController@uploadAssignment')->name('web_upload_assignment');
    Route::post('web_delete_assignment', 'AssignmentController@deleteAssignment')->name('web_delete_assignment');
    Route::post('web_enable_disable_assignment', 'AssignmentController@enableDisableAssignment')->name('web_enable_disable_assignment');
});


//Library
Route::group(['middleware' => ['auth:api']], function () {

    Route::get('web_get_all_book_list', 'LibraryController@getAllBookLIst')->name('web_get_all_book_list');
    Route::get('web_get_all_student_book_wise', 'LibraryController@getAllStudentListBookWise')->name('web_get_all_student_book_wise');
    Route::get('web_get_all_students_book_issue', 'LibraryController@getAllRegisteredStudents')->name('web_get_all_students_book_issue');
    Route::get('web_get_send_email', 'StaffController@sendMail')->name('web_get_send_email');

    Route::post('web_save_update_book_list', 'LibraryController@saveUpdateBookList')->name('web_save_update_book_list');
    Route::post('web_enable_disable_book', 'LibraryController@enableDisableBook')->name('web_enable_disable_book');
    Route::post('web_enable_return_book', 'LibraryController@returnBook')->name('web_enable_return_book');
    Route::post('web_enable_issue_book', 'LibraryController@issueBook')->name('web_enable_issue_book');
    Route::post('web_staff_attendance', 'UserController@staffAttendance')->name('web_staff_attendance');
    Route::get('web_staff_attendance_status', 'UserController@getStaffAttendanceStatus')->name('web_staff_attendance_status');

      
     
});


