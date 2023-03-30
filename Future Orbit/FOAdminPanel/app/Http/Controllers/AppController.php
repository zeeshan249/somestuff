<?php

namespace App\Http\Controllers;

use App\AppModel;
use DB;
use Exception;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /*==================================================Common=========================== */
    public $centerId = "1";
    // To check User Status
    public function checkUserStatus(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $roleId = $request->roleId;
        $result = $app_model->checkUserStatus($userId, $roleId);
        return response()->json(['data' => $result]);
    }

    // To check Mobile Number
    public function checkMobileNumber(Request $request)
    {
        $app_model = new AppModel;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->checkMobileNumber($mobileNumber);
        return response()->json(['data' => $result]);
    }

    // To check login
    public function checkLogin(Request $request)
    {
        $app_model = new AppModel;
        $mobile = $request->mobile;
        $password = $request->password;
        $userDeviceToken = $request->userDeviceToken;
        $userCode = $request->userCode;

        $result = $app_model->checkLogin($mobile, $password, $userDeviceToken, $userCode);
        return response()->json(['data' => $result]);
    }

    public function logoutUser(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $result = $app_model->logoutUser($userId);
        return response()->json(['data' => $result]);

    }

    // To update device token
    public function updateDeviceToken(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $userDeviceToken = $request->userDeviceToken;
        $result = $app_model->updateDeviceToken($userId, $userDeviceToken);
        return response()->json($result);
    }
    // Get Common About us
    public function getCommonAboutUs(Request $request)
    {
        $app_model = new AppModel;
        $result = $app_model->getCommonAboutUs();
        return response()->json(['data' => $result]);
    }
    // To get course
    public function getCourseList(Request $request)
    {

        $app_model = new AppModel;
        return $app_model->getCourseList();
    }

    // To get gallery list
    public function getGalleryList(Request $request)
    {

        $app_model = new AppModel;
        return $app_model->getGalleryList();
    }

    // Customer/Patient
    // Send Sign up OTP
    public function sendStudentSignupOTP($mobile, $otp)
    {
        try
        {

            $smstext = rawurlencode("<#>  Your mobile verification code is: " . $otp . " , Please don't share this code with anyone.Regards, P Maiti pJEbpuWf6Bj");
            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=256dda14-3d85-4e46-83aa-1d12103bc1e2&senderid=PRIMAI&channel=2&DCS=0&flashsms=0&number=$mobile&text=$smstext&route=31&EntityId=1301162038261824606&dlttemplateid=1307162100179461666");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
            $result = curl_exec($ch);
            if (curl_error($ch)) {
                $result = curl_errno($ch);
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);
    }

    public function sendPassword(Request $request)
    {
        $app_model = new AppModel;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->sendPassword($mobileNumber);
        return response()->json(['data' => $result]);
    }

    // To change password
    public function changePassword(Request $request)
    {
        $app_model = new AppModel;
        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $userId = $request->userId;
        $result = $app_model->changePassword($oldPassword, $newPassword, $userId);
        return response()->json(['data' => $result]);
    }

// Upload profile image

    // Update first name
    public function updateStudentFirstName(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $firstName = $request->firstName;
        $fullName = $request->fullName;
        $result = $app_model->updateStudentFirstName($userId, $firstName, $fullName);
        return response()->json($result);
    }
    // Update last name
    public function updateStudentLastName(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $lastName = $request->lastName;
        $fullName = $request->fullName;
        $result = $app_model->updateStudentLastName($userId, $lastName, $fullName);
        return response()->json($result);
    }
    //update mobile number
    public function updateStudentMobileNumber(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->updateStudentMobileNumber($userId, $mobileNumber);
        return response()->json($result);
    }

    // Get Common About us
    public function getStudentCourseMapping(Request $request)
    {
        $app_model = new AppModel;
        $studentId = $request->studentId;
        $result = $app_model->getStudentCourseMapping($studentId);
        return response()->json(['data' => $result]);
    }

    // To get exam schedule course wise
    public function getExamScheduleCourseWise(Request $request)
    {

        $app_model = new AppModel;
        $studentId = $request->studentId;
        $courseId = $request->courseId;
        $examScheduleType = $request->examScheduleType;
        $isViewAll = $request->isViewAll;
        $childCourseId = $request->childCourseId;

        return $app_model->getExamScheduleCourseWise($studentId, $courseId, $examScheduleType, $isViewAll, $childCourseId);
    }

    // To get exam card by user and category
    public function getExamCardByStudentCourseWise(Request $request)
    {
        $studentId = $request->studentId;
        $courseId = $request->courseId;
        $app_model = new AppModel;
        $result = $app_model->getExamCardByStudentCourseWise($studentId, $courseId);
        return response()->json(['data' => $result]);
    }

    // To get exam instruction
    public function getExamInstruction(Request $request)
    {
        $examScheduleId = $request->examScheduleId;
        $app_model = new AppModel;
        $result = $app_model->getExamInstruction($examScheduleId);
        return response()->json(['data' => $result]);
    }

    // To get exam question
    public function getExamQuestion(Request $request)
    {
        $examScheduleId = $request->examScheduleId;
        $app_model = new AppModel;
        return $app_model->getExamQuestion($examScheduleId);
    }

    // To save exam result
    public function saveExam(Request $request)
    {
        $app_model = new AppModel;
        $studentId = $request->studentId;
        $userId = $request->userId;
        $registrationId = $request->registrationId;
        $examScheduleId = $request->examScheduleId;
        $isExamComplete = $request->isExamComplete;
        $examResumeTime = $request->examResumeTime;
        $examAnswerData = $request->examAnswerData;
        $isSubmitButtonClicked = $request->isSubmitButtonClicked;
        $courseId = $request->courseId;
        $startExamTime = $request->startExamTime;
        $endExamTime = $request->endExamTime;

        $result = $app_model->saveExam($studentId, $userId,
            $registrationId,
            $examScheduleId, $isExamComplete,
            $examResumeTime, $examAnswerData,
            $isSubmitButtonClicked, $courseId,
            $startExamTime, $endExamTime
        );
        return response()->json(['data' => $result]);
    }

// Review
    // Review data for daily quiz
    public function getExamReview(Request $request)
    {
        $studentId = $request->studentId;
        $examScheduleId = $request->examScheduleId;
        $app_model = new AppModel;
        $result = $app_model->getExamReview($studentId, $examScheduleId);
        return response()->json(['data' => $result]);
    }

// Exam Analysis user wise
    public function getExamAnalysisUserWise(Request $request)
    {
        $examScheduleId = $request->examScheduleId;
        $studentId = $request->studentId;
        $app_model = new AppModel;
        $result = $app_model->getExamAnalysisUserWise($examScheduleId, $studentId);
        return response()->json(['data' => $result]);
    }

// Exam Analysis top user
    public function getExamAnalysisTopUser(Request $request)
    {
        $examScheduleId = $request->examScheduleId;
        $app_model = new AppModel;
        $result = $app_model->getExamAnalysisTopUser($examScheduleId);
        return response()->json(['data' => $result]);
    }

// get exam analysis topic wise
    public function getExamAnalysisTopicWise(Request $request)
    {
        $examScheduleId = $request->examScheduleId;
        $studentId = $request->studentId;
        $app_model = new AppModel;
        $result = $app_model->getExamAnalysisTopicWise($examScheduleId, $studentId);
        return response()->json(['data' => $result]);
    }

// get exam answer
    public function getExamAnswer(Request $request)
    {
        $examScheduleId = $request->examScheduleId;
        $studentId = $request->studentId;
        $app_model = new AppModel;
        return $app_model->getExamAnswer($examScheduleId, $studentId);
    }

    //save post

    public function savePost(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $roleId = $request->roleId;
        $postContent = $request->postContent;
        $postHasImage = $request->postHasImage;
        $postImage = $request->postImage;
        $postHasUrl = $request->postHasUrl;
        $result = $app_model->savePost($userId, $roleId, $postContent, $postHasImage,
            $postImage, $postHasUrl);
        return response()->json(['data' => $result]);
    }

    // upload post image
    public function postImageUpload(Request $request)
    {
        $postImageName = $request->name;
        $request->file->storeAs('public/post_images', $postImageName);
        if ($request->file->isValid()) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json(['data' => $resultData]);

    }
    public function studentProfileImageUpload(Request $request)
    {
        $profileImageName = $request->name;
        $profileCurrentImageName = $request->currentPictureName;
        if (file_exists(storage_path('app/public/user_profile_images/' . $profileCurrentImageName))) {
            unlink(storage_path('app/public/user_profile_images/' . $profileCurrentImageName));
        }

        $request->file->storeAs('public/user_profile_images', $profileImageName);
        if ($request->file->isValid()) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json(['data' => $resultData]);
    }
    //update profile image
    public function updateStudentProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $fileName = $request->fileName;
        $result = $app_model->updateStudentProfileImage($userId, $fileName);
        return response()->json(['data' => $result]);
    }
    // Remove profile Image
    public function removeStudentProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $fileName = $request->fileName;
        $result = $app_model->removeStudentProfileImage($userId, $fileName);
        return response()->json(['data' => $result]);
    }
    // To get the post
    public function getPost(Request $request)
    {

        $userId = $request->userId;
        $postFlag = $request->postFlag;
        $roleId = $request->roleId;
        $app_model = new AppModel;
        return $app_model->getPost($userId, $postFlag, $roleId);
    }

    // To insert  post like
    public function savePostLike(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $postId = $request->postId;
        $roleId = $request->roleId;
        $result = $app_model->savePostLike($userId, $postId, $roleId);
        return response()->json(['data' => $result]);
    }

    // To delete  post
    public function deletePost(Request $request)
    {
        $app_model = new AppModel;
        $postId = $request->postId;
        $postImageName = $request->postImageName;
        $result = $app_model->deletePost($postId, $postImageName);
        return response()->json(['data' => $result]);
    }

    // To get the comment
    public function getPostComment(Request $request)
    {
        $postId = $request->postId;
        $roleId = $request->roleId;
        $app_model = new AppModel;
        return $app_model->getPostComment($postId, $roleId);
    }

    // To save   comment
    public function savePostComment(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $postId = $request->postId;
        $roleId = $request->roleId;
        $postComment = $request->postComment;
        $result = $app_model->savePostComment($userId, $postId, $roleId, $postComment);
        return response()->json(['data' => $result]);
    }

    // To save enquiry
    public function saveEnquiry(Request $request)
    {
        $app_model = new AppModel;
        $courseId = $request->courseId;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $mobileNumber = $request->mobileNumber;
        $email = $request->email;
        $address = $request->address;
        $childCourseId = $request->childCourseId;
        $result = $app_model->saveEnquiry($this->centerId, $courseId, $firstName, $lastName, $mobileNumber, $email, $address, $childCourseId);
        return response()->json(['data' => $result]);
    }

    // To get course
    public function getOnlineCourseList(Request $request)
    {

        $app_model = new AppModel;
        return $app_model->getOnlineCourseList();
    }

    // To register user
    public function registerUser(Request $request)
    {
        $app_model = new AppModel;
        $courseId = $request->courseId;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $mobileNumber = $request->mobileNumber;
        $password = $request->password;
        $childCourseId = $request->childCourseId;
        $result = $app_model->registerUser($this->centerId, $courseId, $firstName, $lastName,
            $mobileNumber, $password, $childCourseId);
        return response()->json(['data' => $result]);
    }
    // To get the post
    public function getNoticeList(Request $request)
    {

        $roleId = $request->roleId;
        $userId = $request->userId;
        $batchId = $request->batchId;
        $app_model = new AppModel;
        return $app_model->getNoticeList($roleId,$userId, $batchId);
    }

    public function saveReadNotice(Request $request)
    {

        $lmsNoticeId = $request->lmsNoticeId;
        $userId = $request->userId;
        $app_model = new AppModel;
        return $app_model->saveReadNotice($lmsNoticeId, $userId);
    }

    public function getBatchList(Request $request)
    {

        $facultyId = $request->facultyId;
        $app_model = new AppModel;
        return $app_model->getBatchList($facultyId);
    }

    public function getBatchSchedule(Request $request)
    {

        $batchId = $request->batchId;
        $app_model = new AppModel;
        return $app_model->getBatchSchedule($batchId);
    }

    public function saveHomework(Request $request)
    {

        $userId = $request->userId;
        $batchId = $request->batchId;
        $subjectId = $request->subjectId;
        $topicId = $request->topicId;
        $title = $request->title;
        $description = $request->description;
        $marks = $request->marks;

        $assignmentLastSubmissionDate = $request->assignmentLastSubmissionDate;
        $app_model = new AppModel;
        $result = $app_model->saveHomework($userId,
            $batchId,
            $subjectId,
            $topicId,
            $title,
            $description,
            $marks,
            $assignmentLastSubmissionDate);

        return response()->json(['data' => $result]);
    }

    public function getSubject(Request $request)
    {
        $courseId = $request->courseId;
        $app_model = new AppModel;
        $result = $app_model->getSubject($courseId);
        return response()->json(['data' => $result]);
    }

    public function getTopic(Request $request)
    {
        $app_model = new AppModel;
        $subjectId = $request->subjectId;
        $result = $app_model->getTopic($subjectId);
        return response()->json(['data' => $result]);
    }

    public function getAssignmentListForTeacher(Request $request)
    {

        $batchId = $request->batchId;
        $userId = $request->userId;

        $app_model = new AppModel;
        return $app_model->getAssignmentListForTeacher($batchId, $userId);
    }

    public function assignmentUploadByTeacher(Request $request)
    {
        $assignmentImageName = $request->assignmentImageName;
        $assignmentId = $request->assignmentId;
        $userId = $request->userId;
        $request->file->storeAs('public/assignment_images', $assignmentImageName);
        if ($request->file->isValid()) {

            $insertQuery = DB::table('lms_assignment_document')->insertGetId(
                [
                    'lms_center_id' => $this->centerId,
                    'lms_assignment_id' => $assignmentId,
                    'lms_assignment_document_path' => $assignmentImageName,
                    'lms_assignment_document_created_by' => $userId,

                ]
            );
            if ($insertQuery > 0) {
                $resultData['result'] = "success";
            } else {
                $resultData['result'] = "fail";
                if (file_exists(storage_path('app/public/assignment_images/' . $assignmentImageName))) {
                    unlink(storage_path('app/public/assignment_images/' . $assignmentImageName));
                }

            }
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json(['data' => $resultData]);

    }

    public function getUploadedAssignmentDocByTeacher(Request $request)
    {
        $app_model = new AppModel;
        $assignmentId = $request->assignmentId;
        $result = $app_model->getUploadedAssignmentDocByTeacher($assignmentId);
        return response()->json(['data' => $result]);
    }

    public function getSubmittedStudentListForAssignmentForTeacher(Request $request)
    {

        $assignmentId = $request->assignmentId;

        $app_model = new AppModel;
        return $app_model->getSubmittedStudentListForAssignmentForTeacher($assignmentId);
    }

    public function finishUploadAssignment(Request $request)
    {

        $assignmentId = $request->assignmentId;
        $app_model = new AppModel;
        $result = $app_model->finishUploadAssignment($assignmentId);

        return response()->json(['data' => $result]);
    }

    public function evaluateAssignment(Request $request)
    {

        $assignmentId = $request->assignmentId;
        $userId = $request->userId;
        $studentId = $request->studentId;
        $registrationId = $request->registrationId;
        $evaluatedBy = $request->evaluatedBy;
        $evaluationMarks = $request->evaluationMarks;

        $app_model = new AppModel;
        $result = $app_model->evaluateAssignment($assignmentId, $userId, $studentId, $registrationId, $evaluatedBy, $evaluationMarks);

        return response()->json(['data' => $result]);
    }

    public function getUploadedAssignmentDocByStudentForTeacher(Request $request)
    {
        $app_model = new AppModel;
        $assignmentId = $request->assignmentId;
        $userId = $request->userId;
        $studentId = $request->studentId;
        $registrationId = $request->registrationId;
        $result = $app_model->getUploadedAssignmentDocByStudentForTeacher($assignmentId, $userId, $studentId, $registrationId);
        return response()->json(['data' => $result]);

    }

    public function getAssignmentListForStudent(Request $request)
    {

        $batchId = $request->batchId;
        $app_model = new AppModel;
        return $app_model->getAssignmentListForStudent($batchId);
    }

    public function assignmentUploadByStudent(Request $request)
    {
        $assignmentImageName = $request->assignmentImageName;
        $assignmentId = $request->assignmentId;
        $userId = $request->userId;
        $studentId = $request->studentId;
        $registrationId = $request->registrationId;
        $request->file->storeAs('public/assignment_images', $assignmentImageName);
        if ($request->file->isValid()) {

            $insertQuery = DB::table('lms_submitted_assignment_document')->insertGetId(
                [
                    'lms_center_id' => $this->centerId,
                    'lms_assignment_id' => $assignmentId,
                    'lms_user_id' => $userId,
                    'lms_student_id' => $studentId,
                    'lms_registration_id' => $registrationId,
                    'lms_submitted_assignment_document_path' => $assignmentImageName,

                ]
            );
            if ($insertQuery > 0) {
                $resultData['result'] = "success";
            } else {
                $resultData['result'] = "fail";
                if (file_exists(storage_path('app/public/assignment_images/' . $assignmentImageName))) {
                    unlink(storage_path('app/public/assignment_images/' . $assignmentImageName));
                }

            }
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json(['data' => $resultData]);

    }

    public function finishUploadAssignmentByStudent(Request $request)
    {

        $assignmentId = $request->assignmentId;
        $userId = $request->userId;
        $studentId = $request->studentId;
        $registrationId = $request->registrationId;
        $app_model = new AppModel;
        $result = $app_model->finishUploadAssignmentByStudent($assignmentId, $userId,
            $studentId, $registrationId);

        return response()->json(['data' => $result]);
    }

    public function getBatchSlotBatchWise(Request $request)
    {
        $batchId = $request->batchId;
        $slotDay = $request->slotDay;
        $userId = $request->userId;

        $app_model = new AppModel;
        $result = $app_model->getBatchSlotBatchWise($batchId, $slotDay, $userId);
        return response()->json(['data' => $result]);
    }

    public function getStudentListBatchWise(Request $request)
    {

        $batchId = $request->batchId;
        $app_model = new AppModel;
        return $app_model->getStudentListBatchWise($batchId);
    }

    public function saveAttendance(Request $request)
    {
        $app_model = new AppModel;
        $batchId = $request->batchId;
        $staffId = $request->staffId;
        $courseId = $request->courseId;
        $childCourseId = $request->childCourseId;
        $attendanceDate = $request->attendanceDate;
        $batchSlotId = $request->batchSlotId;
        $slotDay = $request->slotDay;
        $slotDayText = $request->slotDayText;
        $attendanceData = $request->attendanceData;
        $isHoliday = $request->isHoliday;

        $result = $app_model->saveAttendance($batchId, $staffId,
            $courseId,
            $childCourseId, $attendanceDate,
            $batchSlotId, $slotDay,
            $slotDayText, $attendanceData, $isHoliday);
        return response()->json(['data' => $result]);
    }

    public function getAttendanceStudentWise(Request $request)
    {
        $batchId = $request->batchId;
        $registrationId = $request->registrationId;
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $app_model = new AppModel;
        $result = $app_model->getAttendanceStudentWise($batchId, $registrationId, $fromDate, $toDate);
        return response()->json(['data' => $result]);
    }

    public function getChildCourse(Request $request)
    {
        $courseId = $request->courseId;
        $app_model = new AppModel;
        $result = $app_model->getChildCourse($courseId);
        return response()->json(['data' => $result]);
    }

    public function getOnlineChildCourse(Request $request)
    {
        $courseId = $request->courseId;
        $app_model = new AppModel;
        $result = $app_model->getOnlineChildCourse($courseId);
        return response()->json(['data' => $result]);
    }

    public function getLibrary(Request $request)
    {

        $userId = $request->userId;
        $libraryFlag = $request->libraryFlag;

        $app_model = new AppModel;
        return $app_model->getLibrary($userId, $libraryFlag);
    }

    public function teacherProfileImageUpload(Request $request)
    {
        $profileImageName = $request->name;
        $profileCurrentImageName = $request->currentPictureName;
        if (file_exists(storage_path('app/public/user_profile_images/' . $profileCurrentImageName))) {
            unlink(storage_path('app/public/user_profile_images/' . $profileCurrentImageName));
        }

        $request->file->storeAs('public/user_profile_images', $profileImageName);
        if ($request->file->isValid()) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json(['data' => $resultData]);
    }
    //update profile image
    public function updateTeacherProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $fileName = $request->fileName;
        $result = $app_model->updateTeacherProfileImage($userId, $fileName);
        return response()->json(['data' => $result]);
    }
    // Remove profile Image
    public function removeTeacherProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $fileName = $request->fileName;
        $result = $app_model->removeTeacherProfileImage($userId, $fileName);
        return response()->json(['data' => $result]);
    }

    public function getVideoPlayList(Request $request)
    {

        $videoStatus = $request->videoStatus;
        $app_model = new AppModel;
        return $app_model->getVideoPlayList($videoStatus);
    }
    public function getVideo(Request $request)
    {

        $videoStatus = $request->videoStatus;
        $playListId = $request->playListId;
        $app_model = new AppModel;
        return $app_model->getVideo($playListId, $videoStatus);
    }

    public function send_notification()
    {

        $all_notification_data = DB::table('lms_notification')
            ->join('lms_send_notification', 'lms_send_notification.notification_id', '=', 'lms_notification.notification_id')
            ->join('lms_user', 'lms_user.lms_user_id', '=', 'lms_send_notification.user_id')
            ->where('lms_send_notification.notification_send_status', "0")
            ->where('lms_send_notification.notification_to_be_send_date', date("Y-m-d"))
            ->select([
                'lms_send_notification.send_notification_id',
                'lms_notification.notification_title', 'lms_notification.notification_body',
                'lms_notification.notification_has_image', 'lms_notification.notification_image',
                'lms_notification.notification_action_type', 'lms_user.lms_user_device_token',
            ])
            ->get();

        foreach ($all_notification_data as $key => $value) {
            $this->notification($value);
        }
    }
    public function notification($value)
    {

        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $sendNotificationData = null;
        if ($value->notification_has_image == "1") {
            $sendNotificationData = [
                "title" => $value->notification_title,
                "body" => asset('storage/notification_images/' . $value->notification_image),
                "has_notification_image" => "1",
                "notification_action_type" => $value->notification_action_type,

            ];
        } else {
            $sendNotificationData = [
                "title" => $value->notification_title,
                "body" => $value->notification_body,
                "has_notification_image" => "0",
                "notification_action_type" => $value->notification_action_type,

            ];
        }

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to' => $value->lms_user_device_token, //single token

            'data' => $sendNotificationData,
        ];

        $headers = [
            'Authorization: key=AAAAMtHu4RQ:APA91bE9cwzrw6JhL3AmTTjQXQ_5vL-wH-kkHlh7lrupL5GvCgVHRBRS60nWHNbpsj9_ISZVHRSTVjxNsqb8XFlgBYxSOxZAuotWIv_tqBMdHLvuHDA2oYkwR3mdia9mD4lvjp7Okc6B',
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        $decoded_result = json_decode($result, true);

        curl_close($ch);
        //echo  $decoded_result['success'];
        //echo  $decoded_result['results'][0]['message_id'];

        $notification_status = null;
if ($decoded_result == null) {
    return;
}

        if ($decoded_result['success'] == 1) {
            $notification_status = "1";
        } else {
            $notification_status = "0";
        }

        DB::table('lms_send_notification')
            ->where('send_notification_id', $value->send_notification_id)
            ->update([
                'multicast_id' => $decoded_result['multicast_id'], 'message_id' => '123',
                'notification_send_status' => $notification_status,
                'notification_send_at' => now(),
            ]);
        return true;
    }

    public function deleteAssignmentDoc(Request $request)
    {

        $assignmenDocId = $request->assignmenDocId;
        $docName = $request->docName;

        $app_model = new AppModel;
        $result = $app_model->deleteAssignmentDoc($assignmenDocId, $docName);

        return response()->json(['data' => $result]);
    }
    public function deleteAssignment(Request $request)
    {

        $assignmentId = $request->assignmentId;
        $app_model = new AppModel;
        $result = $app_model->deleteAssignment($assignmentId);

        return response()->json(['data' => $result]);
    }

    public function deleteStudentAssignmentDoc(Request $request)
    {

        $assignmenDocId = $request->assignmenDocId;
        $docName = $request->docName;

        $app_model = new AppModel;
        $result = $app_model->deleteStudentAssignmentDoc($assignmenDocId, $docName);

        return response()->json(['data' => $result]);
    }

    // implemented to resolve the exam issue
    public function getExamQuestionAndInsertInExamResult(Request $request)
    {

        $examScheduleId = $request->examScheduleId;
        $studentId = $request->studentId;
        $userId = $request->userId;
        $registrationId = $request->registrationId;
        $isExamComplete = $request->isExamComplete;
        $courseId = $request->courseId;
        $app_model = new AppModel;
        $result = $app_model->getExamQuestionAndInsertInExamResult($examScheduleId, $studentId, $userId,
            $registrationId, $isExamComplete, $courseId);

        return response()->json(['data' => $result]);
    }

    // To get exam question
    public function getExamQuestionNew(Request $request)
    {
        $examScheduleId = $request->examScheduleId;
        $app_model = new AppModel;
        $result = $app_model->getExamQuestionNew($examScheduleId);
        return response()->json(['data' => $result]);

    }
    public function getExamResultByExamResultId(Request $request)
    {
        $userId = $request->userId;
        $studentId = $request->studentId;
        $registrationId = $request->registrationId;
        $examScheduleId = $request->examScheduleId;
        $questionBankId = $request->questionBankId;
        $app_model = new AppModel;
        $result = $app_model->getExamResultByExamResultId($userId, $studentId, $registrationId, $examScheduleId, $questionBankId);
        return response()->json(['data' => $result]);

    }

    //end

    public function autoSubmitExam(Request $request)
    {

        $getQuery = DB::select('SELECT * FROM lms_exam_result_details
where lms_exam_end_time < now()');

        if (count($getQuery) > 0) {

            for ($x = 0; $x < count($getQuery); $x++) {

                DB::table('lms_exam_result')
                    ->where('lms_user_id', $getQuery[$x]->lms_user_id)
                    ->where('lms_student_id', $getQuery[$x]->lms_student_id)
                    ->where('lms_registration_id', $getQuery[$x]->lms_registration_id)
                    ->where('lms_exam_schedule_id', $getQuery[$x]->lms_exam_schedule_id)

                    ->update(['lms_is_exam_complete' => 1]);

            }

        }

    }

    public function getAllTopic(Request $request){
        $searchText=$request->searchText;
        $subjectId = $request->subjectId;
        $app_model = new AppModel;
        $result = $app_model->getAllTopic($subjectId,$searchText);
        return $result;

    }
    public function getAllFees(Request $request){
        $registrationId=$request->registrationId;
        $studentId = $request->studentId;
        $app_model = new AppModel;
        $result = $app_model->getAllFees($registrationId,$studentId);
        return $result; 
    }
    
    public function getAllVoucher(Request $request){
        $registrationId=$request->registrationId;
        $studentId = $request->studentId;
        $app_model = new AppModel;
        $result = $app_model->getAllVoucher($registrationId,$studentId);
        return $result; 
    }
}
