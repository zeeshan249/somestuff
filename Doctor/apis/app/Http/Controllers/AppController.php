<?php

namespace App\Http\Controllers;

use App\Models\AppModel;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Exception;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /*==================================================Common=========================== */
    // To check User Status
    public function checkUserStatus(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $roleId = $request->roleId;
        $result = $app_model->checkUserStatus($userId, $roleId);
        return response()->json($result);
    }

    // To check Mobile Number
    public function checkMobileNumber(Request $request)
    {
        $app_model = new AppModel;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->checkMobileNumber($mobileNumber);
        return response()->json($result);
    }

    // To check login
    public function checkLogin(Request $request)
    {
        $app_model = new AppModel;
        $mobile = $request->mobile;
        $password = $request->password;
        $userDeviceToken = $request->userDeviceToken;
        $result = $app_model->checkLogin($mobile, $password, $userDeviceToken);
        return response()->json($result);
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
    // To get city
    public function getCity(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        $app_model = new AppModel;
        $app_model->getCity($pageNumber, $itemToLoad, $searchText);
    }

    // To send password
    public function sendPassword(Request $request)
    {
        $app_model = new AppModel;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->sendPassword($mobileNumber);
        return response()->json($result);
    }
// To get area
    public function getArea(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        $cityId = $request->cityId;
        $app_model = new AppModel;
        $app_model->getArea($pageNumber, $itemToLoad, $searchText, $cityId);
    }

    // To get the slider
    public function getSlider(Request $request)
    {
        $app_model = new AppModel;
        $sliderPosition = $request->sliderPosition;
        $areaId = $request->areaId;
        $cityId = $request->cityId;
        $result = $app_model->getSlider($sliderPosition, $areaId, $cityId);
        return response()->json($result);
    }
    // To get Disease Category
    public function getDiseaseCategory(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        $cityId = $request->cityId;
        $areaId = $request->areaId;
        $position = $request->position;
        $app_model = new AppModel;
        $app_model->getDiseaseCategory($pageNumber, $itemToLoad, $searchText, $cityId, $areaId, $position);
    }

    // To get Health Tips
    public function getHealthTips(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $userId = $request->userId;
        $roleId = $request->roleId;
        $app_model = new AppModel;
        $app_model->getHealthTips($pageNumber, $itemToLoad, $userId, $roleId);
    }

    
    public function getHealthTips1(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $userId = $request->userId;
        $roleId = $request->roleId;
        $app_model = new AppModel;
        $app_model->getHealthTips1($pageNumber, $itemToLoad, $userId, $roleId);
    }

    // To save health tips like
    public function saveHealthTipsLike(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $healthTipsId = $request->healthTipsId;
        $userFirstName = $request->userFirstName;
        $userLastName = $request->userLastName;
        $userFullName = $request->userFullName;
        $userProfileImage = $request->userProfileImage;
        $result = $app_model->saveHealthTipsLike($userId, $healthTipsId, $userFirstName,
            $userLastName, $userFullName, $userProfileImage);
        return response()->json($result);
    }

    // To delete health tips like
    public function deleteHealthTips(Request $request)
    {
        $app_model = new AppModel;
        $healthTipsId = $request->healthTipsId;
        $healthTipsImage = $request->healthTipsImage;

        $result = $app_model->deleteHealthTips($healthTipsId, $healthTipsImage);
        return response()->json($result);
    }

    //get health tip comment
    public function getHealthTipComment(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $healthTipsId = $request->healthTipsId;
        $app_model = new AppModel;
        $app_model->getHealthTipComment($healthTipsId, $pageNumber, $itemToLoad);
    }

    // To save comment
    public function saveHealthTipcomment(Request $request)
    {
        $app_model = new AppModel;
        $healthTipsId = $request->healthTipsId;
        $userId = $request->userId;
        $userFirstName = $request->userFirstName;
        $userLastName = $request->userLastName;
        $userFullName = $request->userFullName;
        $userProfileImage = $request->userProfileImage;
        $comment = $request->comment;
        $result = $app_model->saveHealthTipcomment($healthTipsId, $userId, $comment, $userFirstName,
            $userLastName, $userFullName, $userProfileImage);
        return response()->json($result);
    }

/*==================================================Customer=========================== */

    // Customer/Patient
    // Send Sign up OTP
    public function sendCustomerSignupOTP($mobile, $otp)
    {
        try
        {
           
            $ch="https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=qB37ddQ1W0Sc6izWDZ4gFQ&senderid=RRSMSG&channel=2&DCS=0&flashsms=0&number=".$mobile."&text=Your%20login%20OTP%20code%20is%20".$otp."%20RP";

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $ch,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 961b96b9-0e70-8963-4d5d-8c99cb156417"
              ),
            ));


            $result = curl_exec($curl);
            if (curl_error($curl)) {
                $result = curl_errno($curl);
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);
    }
// To register  user
   public function registerCustomer(Request $request)
    {
        $app_model = new AppModel;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $mobile = $request->mobile;
        $password = $request->password;
        $deviceToken = $request->deviceToken;
        $countryId = $request->countryId;

        $result = $app_model->registerCustomer($firstName, $lastName, $mobile, $password, $deviceToken,$countryId);
        
        return response()->json($result);
    }

    // search doctor clinic speciality
    public function searchDoctorClinicSpeciality(Request $request)
    {
        $app_model = new AppModel;
        $searchText = $request->searchText;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $cityId = $request->cityId;
        $areaId = $request->areaId;
        $result = $app_model->searchDoctorClinicSpeciality($searchText, $pageNumber, $itemToLoad
            , $cityId, $areaId);

    }

    // To get clinic list
    public function getClinicList(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        $cityId = $request->cityId;
        $areaId = $request->areaId;
        $position = $request->position;
        $app_model = new AppModel;
        $app_model->getClinicList($pageNumber, $itemToLoad, $searchText, $cityId, $areaId, $position);
    }

    // To get Doctor List
    public function getDctorsList(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        $cityId = $request->cityId;
        $areaId = $request->areaId;
        $position = $request->position;
        $diseaseCategoryId = $request->diseaseCategoryId;
        $app_model = new AppModel;
        $app_model->getDctorsList($pageNumber, $itemToLoad, $searchText, $cityId, $areaId, $position, $diseaseCategoryId);
    }

    // To change password
    public function changeCustomerPassword(Request $request)
    {
        $app_model = new AppModel;
        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $userId = $request->userId;
        $result = $app_model->changeCustomerPassword($oldPassword, $newPassword, $userId);
        return response()->json($result);
    }

// Upload profile image
    public function customerProfileImageUpload(Request $request)
    {
        $profileImageName = $request->name;
        $profileCurrentImageName = $request->currentPictureName;
        // if (file_exists(storage_path('app/public/user_profile_pic/' . $profileCurrentImageName))) {
        //     unlink(storage_path('app/public/user_profile_pic/' . $profileCurrentImageName));
        // }

        $request->file->storeAs('public/user_profile_pic', $profileImageName);
        if ($request->file->isValid()) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json($resultData);
    }
    //update profile image
    public function updateCustomerProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $fileName = $request->fileName;
        $result = $app_model->updateCustomerProfileImage($userId, $fileName);
        return response()->json($result);
    }
    // Remove profile Image
    public function removeCustomerProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $fileName = $request->fileName;
        $result = $app_model->removeCustomerProfileImage($userId, $fileName);
        return response()->json($result);
    }

    // Update first name
    public function updateCustomerFirstName(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $firstName = $request->firstName;
        $fullName = $request->fullName;
        $result = $app_model->updateCustomerFirstName($userId, $firstName, $fullName);
        return response()->json($result);
    }
    // Update last name
    public function updateCustomerLastName(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $lastName = $request->lastName;
        $fullName = $request->fullName;
        $result = $app_model->updateCustomerLastName($userId, $lastName, $fullName);
        return response()->json($result);
    }
    //update mobile number
    public function updateCustomerMobileNumber(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->updateCustomerMobileNumber($userId, $mobileNumber);
        return response()->json($result);
    }

    // To get the customer personal profile
    public function getCustomerPersonalProfileDetails(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $result = $app_model->getCustomerPersonalProfileDetails($userId);
        return response()->json($result);
    }
    //update customer personal details
    public function updateCustomerPersonalProfileDetails(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $email = $request->email;
        $dob = $request->dob;
        $gender = $request->gender;
        $bloodGroup = $request->bloodGroup;
        $martitalStatus = $request->martitalStatus;
        $height = $request->height;
        $weight = $request->weight;
        $address = $request->address;
        $result = $app_model->updateCustomerPersonalProfileDetails($userId, $email, $dob, $gender,
            $bloodGroup, $martitalStatus, $height, $weight, $address);
        return response()->json($result);
    }

    // To get the clinic images
    public function getClinicImages(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $result = $app_model->getClinicImages($clinicId);
        return response()->json($result);
    }

    // To get the individual clinic details
    public function getClinicDetails(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $result = $app_model->getClinicDetails($clinicId);
        return response()->json($result);
    }

    // To get the clinic timing
    public function getClinicTiming(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $result = $app_model->getClinicTiming($clinicId);
        return response()->json($result);
    }

    // To get the clinic service
    public function getClinicService(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $result = $app_model->getClinicService($clinicId);
        return response()->json($result);
    }

    // To get Doctor List clinic wise
    public function getDoctorsListClinicWise(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $clinicId = $request->clinicId;
        $app_model = new AppModel;
        $app_model->getDoctorsListClinicWise($pageNumber, $itemToLoad, $clinicId);
    }

    // To get the doctor details
    public function getDoctorDetails(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;
        $result = $app_model->getDoctorDetails($doctorId);
        return response()->json($result);
    }

    // To get the doctor associated clinic
    public function getDoctorAssociatedClinic(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;
        $clinicId = $request->clinicId;
        $result = $app_model->getDoctorAssociatedClinic($doctorId, $clinicId);
        return response()->json($result);
    }

    // To get the doctor associated clinic
    public function getDoctorOtherDetails(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;
        $result = $app_model->getDoctorOtherDetails($doctorId);
        return response()->json($result);
    }

    // To get the booking slot
    public function getInClinicBookingSlotDates(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $doctorId = $request->doctorId;
        $isAdmin = $request->isAdmin;
        $result = $app_model->getInClinicBookingSlotDates($clinicId, $doctorId, $isAdmin);
        return response()->json($result);
    }

    // To get the in clinic slot id and position date wise
    public function getInClinicSlotIdPositionDateWise(Request $request)
    {
        $app_model = new AppModel;
        $inClinicSlotBookingDate = $request->inClinicSlotBookingDate;
        $inClinicSlotId = $request->inClinicSlotId;
        $clinicId = $request->clinicId;
        $doctorId = $request->doctorId;
        $result = $app_model->getInClinicSlotIdPositionDateWise($inClinicSlotBookingDate, $inClinicSlotId,
            $clinicId, $doctorId);
        return response()->json($result);

    }

    // To get the in clinic slot id and position date wise
    public function getInClinicSlotIdPositionDateWiseForMyBooking(Request $request)
    {
        $app_model = new AppModel;
        $inClinicSlotBookingDate = $request->inClinicSlotBookingDate;
        $inClinicSlotId = $request->inClinicSlotId;

        $result = $app_model->getInClinicSlotIdPositionDateWiseForMyBooking($inClinicSlotBookingDate, $inClinicSlotId);
        return response()->json($result);
    }

    // To get the booking slot position
    public function getInClinicBookingSlotPosition(Request $request)
    {
        $app_model = new AppModel;
        $inClinicSlotId = $request->inClinicSlotId;
        $inClinicBookingDate = $request->inClinicBookingDate;
        $slotNameId = $request->slotNameId;
        $clinicId = $request->clinicId;
        $doctorId = $request->doctorId;
        $inClinicMaxSlotPositionDateWise = $request->inClinicMaxSlotPositionDateWise;
        $result = $app_model->getInClinicBookingSlotPosition($inClinicSlotId,
            $inClinicBookingDate, $slotNameId, $clinicId, $doctorId, $inClinicMaxSlotPositionDateWise);
        return response()->json($result);
    }

    // save update family member
    public function saveUpdateFamilyMember(Request $request)
    {
        $app_model = new AppModel;
        $familyId = $request->familyId;
        $userId = $request->userId;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $mobileNumber = $request->mobileNumber;
        $profileImage = $request->profileImage;
        $email = $request->email;
        $dob = $request->dob;
        $gender = $request->gender;
        $bloodGroup = $request->bloodGroup;
        $maritalStatus = $request->maritalStatus;
        $height = $request->height;
        $weight = $request->weight;
        $address = $request->address;
        $relation = $request->relation;

        $result = $app_model->saveUpdateFamilyMember($familyId, $userId, $firstName, $lastName, $mobileNumber,
            $profileImage, $email, $dob, $gender, $bloodGroup, $maritalStatus,
            $height, $weight, $address, $relation
        );
        return response()->json($result);
    }

    // To get the family member list
    public function getFamilyMemberList(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $result = $app_model->getFamilyMemberList($userId);
        return response()->json($result);
    }

    // save inclinic booking
    public function saveInClinicBooking(Request $request)
    {
        $app_model = new AppModel;
        $inClinicSlotId = $request->inClinicSlotId;
        $inClinicSlotDateId = $request->inClinicSlotDateId;
        $slotNameId = $request->slotNameId;
        $clinicId = $request->clinicId;
        $doctorId = $request->doctorId;
        $bookingMadeByRoleId = $request->bookingMadeByRoleId;
        $bookingMadeByUserId = $request->bookingMadeByUserId;
        $bookingMadeForFamilyId = $request->bookingMadeForFamilyId;
        $isBookingDoneForSelf = $request->isBookingDoneForSelf;
        $bookingSlotPosition = $request->bookingSlotPosition;
        $bookingDate = $request->bookingDate;
        $inClinicPrice = $request->inClinicPrice;
        $paymentMethodId = $request->paymentMethodId;
        $rewardId = $request->rewardId;
        $rewardTransactionId = $request->rewardTransactionId;
        $offerId = $request->offerId;
        $paidAmount = $request->paidAmount;
        $offerPrice = $request->offerPrice;
        $inClinicServiceFee = $request->inClinicServiceFee;
        $inClinicCancellationDays = $request->inClinicCancellationDays;
        $specialization_disease_mapping_id = $request->specialization_disease_mapping_id;
        $disease_name = $request->disease_name;

        $result = $app_model->saveInClinicBooking($inClinicSlotId, $inClinicSlotDateId,
            $slotNameId, $clinicId, $doctorId, $bookingMadeByRoleId, $bookingMadeByUserId,
            $bookingMadeForFamilyId, $isBookingDoneForSelf, $bookingSlotPosition,
            $bookingDate, $inClinicPrice, $paymentMethodId,
            $rewardId, $rewardTransactionId, $offerId, $paidAmount, $offerPrice,
            $inClinicServiceFee, $inClinicCancellationDays, $specialization_disease_mapping_id,
            $disease_name
        );
        return response()->json($result);
    }

    // To get the in clinic booking  list
    public function getInClinicBookingList(Request $request)
    {
        $app_model = new AppModel;
        $bookigDoneByUserId = $request->bookigDoneByUserId;
        $bookigStatus = $request->bookigStatus;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        
        $result = $app_model->getInClinicBookingList($bookigDoneByUserId,
            $bookigStatus, $pageNumber, $itemToLoad, $searchText);

    }

    // save inclinic booking
    public function cancelInClinicBooking(Request $request)
    {
        $app_model = new AppModel;
        $in_clinic_booking_id = $request->in_clinic_booking_id;
        $familyMobileNumber = $request->familyMobileNumber;
        $doctorName = $request->doctorName;
        $clinicName = $request->clinicName;
        $bookingDate = $request->bookingDate;
        $inClinicSlotDatesId = $request->inClinicSlotDatesId;
        $inClinicSlotId = $request->inClinicSlotId;

        $result = $app_model->cancelInClinicBooking($in_clinic_booking_id, $familyMobileNumber,
            $doctorName, $clinicName, $bookingDate, $inClinicSlotDatesId, $inClinicSlotId);
        return response()->json($result);
    }

    // To get privacy policy
    public function getPrivacyPolicy(Request $request)
    {
        $app_model = new AppModel;
        $legalId = $request->legalId;
        $result = $app_model->getPrivacyPolicy($legalId);
        return response()->json($result);
    }

    //clinic

    // Upload profile image
    public function clinicProfileImageUpload(Request $request)
    {
        $profileImageName = $request->name;
        $profileCurrentImageName = $request->currentPictureName;
        if (file_exists(storage_path('app/public/user_profile_pic/' . $profileCurrentImageName))) {
            unlink(storage_path('app/public/user_profile_pic/' . $profileCurrentImageName));
        }

        $request->file->storeAs('public/user_profile_pic', $profileImageName);
        if ($request->file->isValid()) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json($resultData);
    }
    //update profile image
    public function updateClinicProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $fileName = $request->fileName;
        $result = $app_model->updateClinicProfileImage($clinicId, $fileName);
        return response()->json($result);
    }
    // Remove profile Image
    public function removeClinicProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $fileName = $request->fileName;
        $result = $app_model->removeClinicProfileImage($clinicId, $fileName);
        return response()->json($result);
    }

    // Update first name
    public function updateClinicFirstName(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $firstName = $request->firstName;
        $fullName = $request->fullName;
        $result = $app_model->updateClinicFirstName($clinicId, $firstName, $fullName);
        return response()->json($result);
    }
    // Update last name
    public function updateClinicLastName(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $lastName = $request->lastName;
        $fullName = $request->fullName;
        $result = $app_model->updateClinicLastName($clinicId, $lastName, $fullName);
        return response()->json($result);
    }
    //update mobile number
    public function updateClinicMobileNumber(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $userId = $request->userId;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->updateClinicMobileNumber($clinicId, $userId, $mobileNumber);
        return response()->json($result);
    }

    // save inclinic booking by clinic
    public function saveInClinicBookingByClinic(Request $request)
    {
        $app_model = new AppModel;
        $familyId = $request->familyId;
        $patientFirstName = $request->patientFirstName;
        $patientLastName = $request->patientLastName;
        $patientMobileNumber = $request->patientMobileNumber;
        $isExistingPatient = $request->isExistingPatient;
        $inClinicSlotId = $request->inClinicSlotId;
        $inClinicSlotDateId = $request->inClinicSlotDateId;
        $slotNameId = $request->slotNameId;
        $clinicId = $request->clinicId;
        $doctorId = $request->doctorId;
        $bookingMadeByRoleId = $request->bookingMadeByRoleId;
        $bookingMadeByUserId = $request->bookingMadeByUserId;

        $isBookingDoneForSelf = $request->isBookingDoneForSelf;
        $bookingSlotPosition = $request->bookingSlotPosition;
        $bookingDate = $request->bookingDate;
        $inClinicPrice = $request->inClinicPrice;
        $paymentMethodId = $request->paymentMethodId;
        $rewardId = $request->rewardId;
        $rewardTransactionId = $request->rewardTransactionId;
        $offerId = $request->offerId;
        $paidAmount = $request->paidAmount;
        $offerPrice = $request->offerPrice;
        $inClinicServiceFee = $request->inClinicServiceFee;
        $inClinicCancellationDays = $request->inClinicCancellationDays;
        $specialization_disease_mapping_id = $request->specialization_disease_mapping_id;
        $disease_name = $request->disease_name;
        $source = $request->source;
		$old_new = $request->old_new;
        $type = $request->type;
        $location = $request->location;

        $result = $app_model->saveInClinicBookingByClinic($familyId, $patientFirstName, $patientLastName, $patientMobileNumber, $isExistingPatient, $inClinicSlotId, $inClinicSlotDateId,
            $slotNameId, $clinicId, $doctorId, $bookingMadeByRoleId, $bookingMadeByUserId,
            $isBookingDoneForSelf, $bookingSlotPosition,
            $bookingDate, $inClinicPrice, $paymentMethodId,
            $rewardId, $rewardTransactionId, $offerId, $paidAmount, $offerPrice, $inClinicServiceFee, $inClinicCancellationDays, $specialization_disease_mapping_id, $disease_name, $source, $old_new, $type, $location
        );
        return response()->json($result);
    }

    // To get the in clinic booking  list
    public function getInClinicBookingListByClinic(Request $request)
    {
        $app_model = new AppModel;
        $bookigDoneForClinicId = $request->bookigDoneForClinicId;
        $bookigStatus = $request->bookigStatus;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        
       $result = $app_model->getInClinicBookingListByClinic($bookigDoneForClinicId,
            $bookigStatus, $pageNumber, $itemToLoad, $searchText);

    }

    // To get the booking slot date by clinic
    public function getInClinicBookingSlotDateByClinic(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $result = $app_model->getInClinicBookingSlotDateByClinic($clinicId);
        return response()->json($result);
    }

    // To get the in clinic booking  list date slot clinic wise
    public function getDoctorListDateSlotClinicWise(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $inClinicSlotDatesId = $request->inClinicSlotDatesId;
        $slotNameId = $request->slotNameId;

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->getDoctorListDateSlotClinicWise($clinicId,
            $inClinicSlotDatesId, $slotNameId, $pageNumber, $itemToLoad);

    }

    // To get the in clinic booking  list
    public function getInClinicBookingByClinicDoctorSlotDate(Request $request)
    {
        $app_model = new AppModel;
        $bookingStatus = $request->bookingStatus;
        $clinicId = $request->clinicId;
        $inClinicSlotDatesId = $request->inClinicSlotDatesId;
        $slotNameId = $request->slotNameId;
        $doctorId = $request->doctorId;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->getInClinicBookingByClinicDoctorSlotDate($bookingStatus, $clinicId,
            $inClinicSlotDatesId, $slotNameId, $doctorId, $pageNumber, $itemToLoad);

    }

    // save inclinic booking
    public function completeInClinicBooking(Request $request)
    {
        $app_model = new AppModel;
        $in_clinic_booking_id = $request->in_clinic_booking_id;
        $inClinicSlotDatesId = $request->inClinicSlotDatesId;
        $inClinicSlotId = $request->inClinicSlotId;

        $result = $app_model->completeInClinicBooking($in_clinic_booking_id, $inClinicSlotDatesId, $inClinicSlotId);
        return response()->json($result);
    }

    // To get the in clinic booking  list date slot clinic wise
    public function cancelAllInClinicBooking(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $inClinicSlotDatesId = $request->inClinicSlotDatesId;
        $slotNameId = $request->slotNameId;
        $doctorId = $request->doctorId;

        $result = $app_model->cancelAllInClinicBooking($clinicId,
            $inClinicSlotDatesId, $slotNameId, $doctorId);
        return response()->json($result);
    }

    public function sendAllTypeSMS(Request $request)
    {
        $app_model = new AppModel;
        $result = $app_model->sendAllTypeSMS();
        return response()->json($result);
    }

    public function getSMSStatus(Request $request)
    {
        $app_model = new AppModel;
        $result = $app_model->getSMSStatus();
        return response()->json($result);
    }

    // To notify customer about doctor date slot
    public function notifyCustomerAboutDoctorDateSlot(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $doctorId = $request->doctorId;
        $userId = $request->userId;
        $result = $app_model->notifyCustomerAboutDoctorDateSlot($clinicId,
            $doctorId, $userId);
        return response()->json($result);
    }

    // search doctor
    public function searchDoctor(Request $request)
    {
        $app_model = new AppModel;
        $searchText = $request->searchText;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->searchDoctor($searchText, $pageNumber,
            $itemToLoad
        );

    }

    public function autoCancelInClinicBooking(Request $request)
    {
        $app_model = new AppModel;
        $result = $app_model->autoCancelInClinicBooking();
        return response()->json($result);
    }

    // To get the doctor associated clinic
    public function getApolloDoctor(Request $request)
    {
        $app_model = new AppModel;
        $clinicId = $request->clinicId;
        $result = $app_model->getApolloDoctor($clinicId);
        return response()->json($result);
    }

    // dummy function to insert slot date
    public function insertSlotDate(Request $request)
    {

        $in_clinic_slot_id = $request->in_clinic_slot_id;
        $in_clinic_slot_start_time = $request->in_clinic_slot_start_time;
        $in_clinic_slot_end_time = $request->in_clinic_slot_end_time;

        $getInClinicSlotQuery = DB::table('dm_in_clinic_slot')
            ->where('in_clinic_slot_id', '=', $in_clinic_slot_id)
            ->get();

        if ($getInClinicSlotQuery->count() > 0) {
            $getInClinicSlotResult = $getInClinicSlotQuery->toArray();
            $currentDate = date('Y-m-d');
            $endDate = date('Y-m-d', strtotime('+90 days'));

            $oneday = new DateInterval("P1D");

            $currentDate = new DateTime($currentDate);
            $endDate = new DateTime($endDate);

            $days = array();

            $excludedDays = $getInClinicSlotResult[0]->in_clinic_doctor_booking_week_days;
            $excludedDaysinArray = explode(",", $excludedDays);
            if ($excludedDays == 0) {
                foreach (new DatePeriod($currentDate, $oneday, $endDate->add($oneday)) as $day) {
                    array_push($days, $day->format("Y-m-d"));
                }

            } else {
                foreach (new DatePeriod($currentDate, $oneday, $endDate->add($oneday)) as $day) {
                    $day_num = $day->format("N");

                    for ($x = 0; $x < count($excludedDaysinArray); $x++) {

                        if ($excludedDaysinArray[$x] == $day_num) {
                            array_push($days, $day->format("Y-m-d"));
                        }

                    }

                }
            }

        }
        DB::beginTransaction();
        try {

            foreach ($days as $day) {
                $resultData = DB::table('dm_in_clinic_slot_dates')->insertGetId(
                    [
                        'in_clinic_slot_id' => $in_clinic_slot_id,
                        'in_clinic_slot_dates' => $day,
                        'in_clinic_slot_start_time' => $getInClinicSlotResult[0]->in_clinic_slot_start_time,
                        'in_clinic_slot_end_time' => $getInClinicSlotResult[0]->in_clinic_slot_end_time,
                        'in_clinic_max_slot_position_datewise' => $getInClinicSlotResult[0]->in_clinic_max_slot_position,

                    ]
                );
            }
            DB::commit();
            return response()->json(['result' => $resultData]);
        } catch (Exception $ex) {

            DB::rollback();
            $resultData['result'] = "Exception";
            return response()->json($resultData);

        }

    }

    public function markDoctorIn(Request $request)
    {
        $app_model = new AppModel;
        $inClinicSlotDatesId = $request->inClinicSlotDatesId;
        $inClinicSlotId = $request->inClinicSlotId;

        $result = $app_model->markDoctorIn($inClinicSlotDatesId, $inClinicSlotId);
        return response()->json($result);
    }
    // To get disease specialization wise
    public function getSpecializationWiseDisease(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;
        $result = $app_model->getSpecializationWiseDisease($doctorId);
        return response()->json($result);
    }
    // mark patient absent
    public function markPatientAbsent(Request $request)
    {
        $app_model = new AppModel;
        $in_clinic_booking_id = $request->in_clinic_booking_id;
        $familyMobileNumber = $request->familyMobileNumber;
        $doctorName = $request->doctorName;
        $clinicName = $request->clinicName;
        $bookingDate = $request->bookingDate;
        $inClinicSlotDatesId = $request->inClinicSlotDatesId;
        $inClinicSlotId = $request->inClinicSlotId;

        $result = $app_model->markPatientAbsent($in_clinic_booking_id, $familyMobileNumber,
            $doctorName, $clinicName, $bookingDate, $inClinicSlotDatesId, $inClinicSlotId);
        return response()->json($result);
    }

    // Video Section

	//get video doctor list
     public function getVideoVisitDoctorList(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        $cityId = $request->cityId;
        $areaId = $request->areaId;
        $position = $request->position;
        $diseaseCategoryId = $request->diseaseCategoryId;
        $app_model = new AppModel;
        $app_model->getVideoVisitDoctorList($pageNumber, $itemToLoad, $searchText, $cityId, $areaId, $position, $diseaseCategoryId);
    }

    // To get the video booking slot
     public function getVideoBookingSlotDates(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;
        $result = $app_model->getVideoBookingSlotDates( $doctorId);
        return response()->json($result);
    }

	  // To notify customer about doctor date slot
    public function notifyCustomerAboutDoctorVideoDateSlot(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;
        $userId = $request->userId;
        $result = $app_model->notifyCustomerAboutDoctorVideoDateSlot(
            $doctorId, $userId);
        return response()->json($result);
    }

    // To get the in video slot id and position date wise
   public function getVideoSlotIdPositionDateWise(Request $request)
    {
        $app_model = new AppModel;
        $videoSlotBookingDate = $request->videoSlotBookingDate;
        $videoSlotId = $request->videoSlotId;
        $doctorId = $request->doctorId;
        $result = $app_model->getVideoSlotIdPositionDateWise($videoSlotBookingDate, $videoSlotId,
             $doctorId);
        return response()->json($result);

    }


   public function getVideoBookingSlotPosition(Request $request)
    {
        $app_model = new AppModel;
        $videoSlotDateId = $request->videoSlotDateId;
        $videoSlotId = $request->videoSlotId;
        $videoBookingDate = $request->videoBookingDate;
        $slotNameId = $request->slotNameId;

        $doctorId = $request->doctorId;
        $videoMaxSlotPositionDateWise = $request->videoMaxSlotPositionDateWise;
        $result = $app_model->getVideoBookingSlotPosition($videoSlotDateId, $videoSlotId, $videoBookingDate, $slotNameId,
            $doctorId, $videoMaxSlotPositionDateWise);
        return response()->json($result);
    }
    public function saveVideoBooking(Request $request)
    {
        $app_model = new AppModel;
        $videoSlotTimeDateWiseId = $request->videoSlotTimeDateWiseId;
        $slotDateId = $request->slotDateId;
        $doctorId = $request->doctorId;
        $slotNameId = $request->slotNameId;
        $slotId = $request->slotId;
        $bookingMadeByRoleId = $request->bookingMadeByRoleId;
        $bookingMadeByUserId = $request->bookingMadeByUserId;
        $bookingMadeForFamilyId = $request->bookingMadeForFamilyId;
        $isBookingDoneForSelf = $request->isBookingDoneForSelf;
        $bookingDate = $request->bookingDate;
        $videoAppointmentFee = $request->videoAppointmentFee;
        $videoServiceFee = $request->videoServiceFee;
        $videoCancellationDays = $request->videoCancellationDays;
        $specialization_disease_mapping_id = $request->specialization_disease_mapping_id;
        $disease_name = $request->disease_name;
        $videoStartTime = $request->videoStartTime;
        $videoEndTime = $request->videoEndTime;
        $paymentMethodId = $request->paymentMethodId;
        $rewardId = $request->rewardId;
        $rewardTransactionId = $request->rewardTransactionId;
        $offerId = $request->offerId;
        $paidAmount = $request->paidAmount;
        $offerPrice = $request->offerPrice;
        
        $remark = '';
        if($request->remark!='')
        {
            $remark = $request->remark;
        }

        $result = $app_model->saveVideoBooking($videoSlotTimeDateWiseId, $slotDateId, $doctorId,
            $slotNameId, $slotId, $bookingMadeByRoleId, $bookingMadeByUserId, $bookingMadeForFamilyId,
            $isBookingDoneForSelf, $bookingDate, $videoAppointmentFee, $videoServiceFee,
            $videoCancellationDays, $specialization_disease_mapping_id, $disease_name, $videoStartTime,
            $videoEndTime, $paymentMethodId, $rewardId, $rewardTransactionId, $offerId, $paidAmount, $offerPrice, $remark);
        return response()->json($result);
    }

    public function getVideoBookingList(Request $request)
    {
        $app_model = new AppModel;
        $bookigDoneByUserId = $request->bookigDoneByUserId;
        $bookigStatus = $request->bookigStatus;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->getVideoBookingList($bookigDoneByUserId,
            $bookigStatus, $pageNumber, $itemToLoad);

    }

    public function cancelVideoBooking(Request $request)
    {
        $app_model = new AppModel;
        $video_booking_id = $request->video_booking_id;
        $video_slot_time_date_wise_id = $request->video_slot_time_date_wise_id;

        $familyMobileNumber = $request->familyMobileNumber;
        $doctorName = $request->doctorName;
        $bookingDate = $request->bookingDate;
        $videoSlotDatesId = $request->videoSlotDatesId;
        $videoSlotId = $request->videoSlotId;

        $result = $app_model->cancelVideoBooking($video_booking_id, $video_slot_time_date_wise_id,
            $familyMobileNumber, $doctorName, $bookingDate, $videoSlotDatesId, $videoSlotId);
        return response()->json($result);
    }

     public function saveVideoBookingByClinic(Request $request)
    {
        $app_model = new AppModel;
        $videoSlotTimeDateWiseId = $request->videoSlotTimeDateWiseId;
        $familyId = $request->familyId;
        $patientFirstName = $request->patientFirstName;
        $patientLastName = $request->patientLastName;
        $patientMobileNumber = $request->patientMobileNumber;
        $isExistingPatient = $request->isExistingPatient;
        $videoSlotId = $request->videoSlotId;
        $videoSlotDateId = $request->videoSlotDateId;
        $slotNameId = $request->slotNameId;
        $doctorId = $request->doctorId;
        $bookingMadeByRoleId = $request->bookingMadeByRoleId;
        $bookingMadeByUserId = $request->bookingMadeByUserId;
        $isBookingDoneForSelf = $request->isBookingDoneForSelf;
        $videoStartTime = $request->videoStartTime;
        $videoEndTime = $request->videoEndTime;
        $bookingDate = $request->bookingDate;

        $videoPrice = $request->videoPrice;
        $paymentMethodId = $request->paymentMethodId;
        $rewardId = $request->rewardId;
        $rewardTransactionId = $request->rewardTransactionId;
        $offerId = $request->offerId;
        $paidAmount = $request->paidAmount;
        $offerPrice = $request->offerPrice;

        $videoServiceFee = $request->videoServiceFee;
        $videoCancellationDays = $request->videoCancellationDays;
        $specialization_disease_mapping_id = $request->specialization_disease_mapping_id;
        $disease_name = $request->disease_name;
        $source = $request->source;

        $result = $app_model->saveVideoBookingByClinic($videoSlotTimeDateWiseId, $familyId,
            $patientFirstName, $patientLastName,
            $patientMobileNumber, $isExistingPatient, $videoSlotId, $videoSlotDateId,
            $slotNameId, $doctorId, $bookingMadeByRoleId, $bookingMadeByUserId,
            $isBookingDoneForSelf, $videoStartTime, $videoEndTime,
            $bookingDate, $videoPrice, $paymentMethodId,
            $rewardId, $rewardTransactionId, $offerId, $paidAmount, $offerPrice, $videoServiceFee,
            $videoCancellationDays, $specialization_disease_mapping_id, $disease_name, $source
        );
        return response()->json($result);
    }

	  public function getVideoBookingListByClinic(Request $request)
    {
        $app_model = new AppModel;
        $bookigDoneForClinicId = $request->bookigDoneForClinicId;
        $bookigStatus = $request->bookigStatus;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->getVideoBookingListByClinic($bookigDoneForClinicId,
            $bookigStatus, $pageNumber, $itemToLoad);

    }
	 // Upload profile image
    public function doctorProfileImageUpload(Request $request)
    {
        $profileImageName = $request->name;
        $profileCurrentImageName = $request->currentPictureName;
        if (file_exists(storage_path('app/public/user_profile_pic/' . $profileCurrentImageName))) {
            unlink(storage_path('app/public/user_profile_pic/' . $profileCurrentImageName));
        }

        $request->file->storeAs('public/user_profile_pic', $profileImageName);
        if ($request->file->isValid()) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json($resultData);
    }
    //update profile image
    public function updateDoctorProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;
        $fileName = $request->fileName;
        $result = $app_model->updateDoctorProfileImage($doctorId, $fileName);
        return response()->json($result);
    }
    // Remove profile Image
    public function removeDoctorProfileImage(Request $request)
    {
        $app_model = new AppModel;
       $doctorId = $request->doctorId;
        $fileName = $request->fileName;
        $result = $app_model->removeDoctorProfileImage($doctorId, $fileName);
        return response()->json($result);
    }

    // Update first name
    public function updateDoctorFirstName(Request $request)
    {
        $app_model = new AppModel;
       $doctorId = $request->doctorId;

        $firstName = $request->firstName;
        $fullName = $request->fullName;
        $result = $app_model->updateDoctorFirstName($doctorId, $firstName, $fullName);
        return response()->json($result);
    }
    // Update last name
    public function updateDoctorLastName(Request $request)
    {
        $app_model = new AppModel;
         $doctorId = $request->doctorId;
        $lastName = $request->lastName;
        $fullName = $request->fullName;
        $result = $app_model->updateDoctorLastName($doctorId, $lastName, $fullName);
        return response()->json($result);
    }
    //update mobile number
    public function updateDoctorMobileNumber(Request $request)
    {
        $app_model = new AppModel;
       $doctorId = $request->doctorId;

        $userId = $request->userId;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->updateDoctorMobileNumber($doctorId, $userId, $mobileNumber);
        return response()->json($result);
    }
	 public function getCurrentVideoVisitBookingListForDoctor(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $doctorId = $request->doctorId;

        $app_model = new AppModel;
        $app_model->getCurrentVideoVisitBookingListForDoctor($pageNumber, $itemToLoad,$doctorId);
    }

  public function markVideoVisitComplete(Request $request)
    {
        $app_model = new AppModel;
        $video_booking_id = $request->video_booking_id;

        $result = $app_model->markVideoVisitComplete($video_booking_id);
        return response()->json($result);
    }
	 public function getCompletedVideoVisitForDoctor(Request $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $doctorId = $request->doctorId;


        $app_model = new AppModel;
        $app_model->getCompletedVideoVisitForDoctor($pageNumber, $itemToLoad, $doctorId);
    }
   public function logout(Request $request)
    {
        $app_model = new AppModel;
        $user_id = $request->user_id;

        $result = $app_model->logout($user_id);
        return response()->json($result);
    }
	  public function uploadChatFile(Request $request)
    {
        $chatFileName = $request->name;


        $request->file->storeAs('public/chat_file', $chatFileName);
        if ($request->file->isValid()) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json($resultData);
    }

  public function getInClinicBookingListByDoctor(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;
        $bookigStatus = $request->bookigStatus;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $searchText = $request->searchText;
        
        $result = $app_model->getInClinicBookingListByDoctor($doctorId,
            $bookigStatus, $pageNumber, $itemToLoad, $searchText);

    }
	  public function getCustomerBookMedicine(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->getCustomerBookMedicine($userId,
            $pageNumber, $itemToLoad);

    }
	  public function uploadPrescription(Request $request)
    {
        $fileName = $request->name;


        $request->file->storeAs('public/prescription_doc', $fileName);
        if ($request->file->isValid()) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json($resultData);
    }

    public function insertPrescriptionName(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
          $fileName = $request->fileName;
          $bookMedicineId = $request->bookMedicineId;

        $result = $app_model->insertPrescriptionName($userId, $fileName, $bookMedicineId);
        return response()->json($result);
    }

  public function getBookMedicineDoc(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $bookMedicineId = $request->bookMedicineId;

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->getBookMedicineDoc($userId,   $bookMedicineId ,
            $pageNumber, $itemToLoad);

    }

  public function deleteBookMedicineDoc(Request $request)
    {
        $app_model = new AppModel;
        $bookMedicineDocId = $request->bookMedicineDocId;
       $fileName = $request->fileName;

        $result = $app_model->deleteBookMedicineDoc($bookMedicineDocId,$fileName);
        return response()->json($result);
    }
  public function saveBookingMedicine(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $name=$request->name;
        $deliveryAddress = $request->deliveryAddress;
        $prescriptionNote = $request->prescriptionNote;
        $mobileNumber = $request->mobileNumber;

        $result = $app_model->saveBookingMedicine($userId,$name, $deliveryAddress, $prescriptionNote,
            $mobileNumber);
        return response()->json($result);
    }

    public function getCustomerBookTest(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->getCustomerBookTest($userId,
            $pageNumber, $itemToLoad);

    }


    public function uploadPrescriptionTest(Request $request)
    {
        $fileName = $request->name;
        $request->file->storeAs('public/book_test_doc', $fileName);
        if ($request->file->isValid()) {
            $resultData['result'] = "success";
        } else {
            $resultData['result'] = "fail";
        }
        return response()->json($resultData);
    }

    public function getBookTestDoc(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $bookTestId = $request->bookTestId;

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;
        $result = $app_model->getBookTestDoc($userId,   $bookTestId ,
            $pageNumber, $itemToLoad);

    }

    public function insertTestName(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $fileName = $request->fileName;
        $bookTestId = $request->bookTestId;

        $result = $app_model->insertTestName($userId, $fileName, $bookTestId);
        return response()->json($result);
    }


    public function saveBookingTest(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $name=$request->name;
        $deliveryAddress = $request->deliveryAddress;
        $prescriptionNote = $request->prescriptionNote;
        $mobileNumber = $request->mobileNumber;

        $result = $app_model->saveBookingTest($userId, $name,$deliveryAddress, $prescriptionNote,
            $mobileNumber);
        return response()->json($result);
    }

    public function deleteBookTestDoc(Request $request)
    {
        $app_model = new AppModel;
        $bookTestDocId = $request->bookTestDocId;
        $fileName = $request->fileName;

        $result = $app_model->deleteBookTestDoc($bookTestDocId,$fileName);
        return response()->json($result);
    }
   public function getCountry(Request $request)
    {
        $app_model = new AppModel;
        $result = $app_model->getCountry();
        return response()->json($result);
    }
public function sendCustomerSignupOTPForInternationalUser($mobile, $otp)
    {
        try
        {
            $smstext = rawurlencode("<#>  Your mobile verification code is: " . $otp . " , Please don't share this code with anyone.Regards, GBSC Global Brain and Spine");

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=E2IHkUTtJkuZdHRE2uywTA&senderid=GLOBSC&channel=INT&DCS=0&flashsms=0&number=".$mobile."&text=Your%20mobile%20verification%20code%20is%3A%20".$otp."%2C%20Please%20don't%20share%20this%20code%20with%20anyone.%20Regards%2C%20GBSC%20Global%20Brain%20And%20Spine%20Care%20App",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 353d1ba5-b37b-acfc-525e-99c9a1022b91"
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              $result = $err;
            } else {
              $result = $response;
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);
    }

    public function appointmentDocUpload(Request $request)
    {
        $app_model = new AppModel;
        try
        {
            $name = [];
            $original_name = [];
            foreach ($request->file('reports') as $key => $value) {
                $image = time().'_'.$value->getClientOriginalName();
                $destinationPath = storage_path('app/public/appointment_files');
                $value->move($destinationPath, $image);
                $name[] = $image;
                $original_name[] = $value->getClientOriginalName();
            }
           
            $filenames=implode(",",$name);
            $original_file_name=implode(",",$original_name);
            
            $result = '';
            if($filenames!='')
            {
                $result = $app_model->insertAppointmentDoc($filenames,$original_file_name);
            }
          
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result);   
    }

    public function getAppointmentDoc(Request $request)
    {
        $app_model = new AppModel;
        try
        {
            $bookingType=$request->bookingType;
            $in_clinic_booking_id = $request->in_clinic_booking_id;
            $video_booking_id = $request->video_booking_id;

            $file_list = $app_model->getAppointmentDoc($bookingType,$in_clinic_booking_id,$video_booking_id);
            
            $url=url('');
            $url_ary=explode("/",$url);
            array_pop($url_ary);
			array_pop($url_ary);
            $storage_url=implode("/",$url_ary);
           
            $file_data=array();
            for($i=0;$i<count($file_list);$i++)
            {
                $id=$file_list[$i]->id;
                $file_name=$file_list[$i]->original_file_name;
                $url=$storage_url.'/storage/app/public/appointment_files/'.$file_list[$i]->document_files;
                $file_data[]=array('id'=>$id,'file_name'=>$file_name,'url' => $url);
            }
            $result['result'] = "success";
            $result['data'] =  $file_data;
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result); 
        
    }

    public function updateBookingId(Request $request)
    {
        $app_model = new AppModel;
        try
        {
            $imageID = $request->imageID;
            $bookingType =  $request->bookingType;
            $bookingId = $request->bookingId;
           
            $result=array();
            if(!empty($imageID) && ($bookingType==0 || $bookingType==1) && ($bookingId!='' && $bookingId!=0))
            {
                

                $result = $app_model->updateBookingId($imageID,$bookingType,$bookingId);
            }
            
            
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result); 
    }

    public function updateBookingReport(Request $request)
    {
        $app_model = new AppModel;
        try
        {
            $result = array();
            $bookingId = $request->bookingId;
            $bookingType = $request->bookingType;

            if($bookingId>0)
            {

                $name = [];
                $original_name = [];
                if(!empty($request->file('reports')))
                {
                    foreach ($request->file('reports') as $key => $value) {
                    $image = time()."_".$value->getClientOriginalName();
                    $destinationPath = storage_path('app/public/appointment_files');
                    $value->move($destinationPath, $image);
                    $name[] = $image;
                    $original_name[] = $value->getClientOriginalName();
                    }

                    
                    if(!empty($name))
                    {
                        $result = $app_model->updateBookingReport($bookingId,$bookingType,$name,$original_name);
                    }
                }
                
            }
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result); 
    }

    public function deleteAppointmentDoc(Request $request)
    {
        $app_model = new AppModel;
        try
        {
            $result = array();
            $imageID = $request->imageID;
            if($imageID>0)
            {
                $result = $app_model->deleteAppointmentDoc($imageID);
            }
        
            
        } catch (Exception $ex) {
            $result = $ex->getMessage();
        }

        return response()->json($result); 
    }
    
    public function getClinicSlotDates(Request  $request){

        $app_model = new AppModel;

        $itemToLoad = $request->itemToLoad;
        $pageNumber = $request->pageNumber;
        
        try
        {
            //$result = array();
            $result = $app_model->getClinicSlotDates($itemToLoad,$pageNumber);
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }

            return response()->json($result); 
    }

    /* Admitted Patient Start */
     public function getRegisteredPatient(Request $request)
    {
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;
        
        $getQuery = DB::table("dm_family_member")->select('dm_family_member.family_member_id as patient_id','dm_family_member.family_member_full_name as patient_full_name','dm_family_member.family_member_mobile_number'
            ,'dm_user.user_id','dm_family_member.uhid',
            'dm_patient_case_history.bed_number',
            'dm_patient_case_history.case_history',
            'dm_patient_case_history.treatment_type',
            'dm_patient_case_history.patient_admin_date',
            'dm_patient_case_history.patient_discharge_date',
            'dm_patient_case_history.status',
            'dm_patient_case_history.days_after_discharge_chat_window',
            DB::raw('if(dm_patient_case_history.high_risk=1,"Yes","No") as high_risk')
             )

            ->join('dm_user','dm_user.user_id','dm_family_member.user_id')
            ->join('dm_patient_case_history','dm_patient_case_history.patient_id','dm_family_member.family_member_id')
            ->join('roles','roles.id','dm_user.role_id')
            ->where('dm_family_member.is_self',1)
            ->where('dm_family_member.uhid','<>','')
            ->where(function ($q) use ($filterBy) {
                $q
                ->where('dm_family_member.family_member_mobile_number', 'like', "%$filterBy%")
                ->orwhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%");


            })
            ->where('dm_user.role_id',1)
            //->where('roles.name','Patient')
            ->groupBy('dm_family_member.family_member_id')
             ->orderBy('dm_family_member.family_member_created_at','DESC')
            ->paginate(15);
        return response()->json(['result'=>'success','resultData'=>$getQuery], 200);
    }

    public function getPatientListWithoutUhid(Request $request)
    {
        
        
        $getQuery = DB::table("dm_family_member")->select('dm_family_member.family_member_id as patient_id','dm_family_member.family_member_full_name as patient_full_name','dm_family_member.family_member_mobile_number as patient_mobile_number'
            ,'dm_user.user_id',
             DB::raw('CONCAT(dm_family_member.family_member_full_name, " - ", dm_family_member.family_member_mobile_number) AS patient_name_mobile')
            )
            ->join('dm_user','dm_user.user_id','dm_family_member.user_id')

            ->join('roles','roles.id','dm_user.role_id')
            ->where('dm_family_member.is_self',1)
            ->where('dm_family_member.uhid','=','')
            ->where('dm_user.role_id',1)
            //->where('roles.name','Patient')
             ->orderBy('dm_family_member.family_member_created_at','DESC')
            ->get();
        return response()->json(['result'=>'success','resultData'=>$getQuery], 200);
    }

     //update UHID
    public function updateUserUHID(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $uhid = $request->uhId;

        $db = DB::table('dm_user')->where('uhid', $uhid)->count();

        if ($db > 0) {
            return response()->json(['result'=>'error','message' => 'This UHID already present please enter a new UHID'], 200);
        }
        else {
            $updateQuery = DB::table('dm_user')
                ->where('user_id', $userId)
                ->update([
                    'uhid' => $uhid,


                ]);
            if ($updateQuery) {

                return response()->json(['success'=>'true','message' =>  'UHID updated successfully'], 200);
            }
        }

    }

    public function admitPatientByAdmin(Request $request)
    {
        $app_model = new AppModel;
        
        $uhid = $request->uhid;
        $patient_id = $request->patient_id;
       
        $bed_number = $request->bed_number;
        $case_history = $request->case_history;
        if($request->high_risk=='Yes')
        {
            $high_risk = 1;
        }
        else
        {
            $high_risk = 0;
        }

        if($request->treatment_type!='')
        {
            $treatment_type = $request->treatment_type;
        }
        else
        {
            $treatment_type = 'Nonsurgical';
        }

        // $patient_admin_date = $request->patient_admin_date;
        // $patient_discharge_date = $request->patient_discharge_date;
        // $days_after_discharge_chat_window = $request->days_after_discharge_chat_window;
        $patient_admin_date = date('Y-m-d');
        $status = 'Admit';

        $db = DB::table('dm_family_member')->where('uhid', $uhid)->count();

        $insertQuery = 0;
        $updateQuery = 0;
        if ($db > 0) {
            return response()->json(['result'=>'error','message' => 'This UHID already present please enter a new UHID'], 200);
        }
        else {
            DB::beginTransaction();
            $updateQuery = DB::table('dm_family_member')
                        ->where('family_member_id', $patient_id)
                        ->update([
                            'uhid' => $uhid, 
                        ]);

            $insertQuery = DB::table('dm_patient_case_history')->insertGetId(
                    ['patient_id' => $patient_id,
                        'uhid' => $uhid,
                        'treatment_type' => $treatment_type,
                        'bed_number' => $bed_number,
                        'case_history' => $case_history,
                        'high_risk' => $high_risk,
                        'patient_admin_date' => $patient_admin_date,
                        //'patient_discharge_date' => $patient_discharge_date,
                        //'days_after_discharge_chat_window' => $days_after_discharge_chat_window,
                        'status' => $status,
                        
                    ]
                );
            DB::commit();
            
                return response()->json(['result' => 'success','message' =>  'This Patient has been Admitted'], 200);
            
        }

    }

    
    public function UpdateAdmitPatientDetails(Request $request){
        try {
          
            $uhid = $request->uhid;
            $patient_id = $request->patient_id;
            
            $bed_number = $request->bed_number;
            $case_history = $request->case_history;
            if($request->high_risk=='Yes')
            {
                $high_risk = 1;
            }
            else
            {
                $high_risk = 0;
            }
            
            if($request->treatment_type!='')
            {
                $treatment_type = $request->treatment_type;
            }
            else
            {
                $treatment_type = 'Nonsurgical';
            }

            $patient_admin_date = $request->patient_admin_date;
            $patient_discharge_date = $request->patient_discharge_date;
            $days_after_discharge_chat_window = $request->days_after_discharge_chat_window;
            $status = $request->status;

            DB::beginTransaction();
            
            $doctorid=  DB::table('dm_patient_case_history')->where('patient_id',$request->patient_id)->where('uhid',$uhid)->update(
                [
                    'bed_number' => $bed_number,
                    'treatment_type' => $treatment_type,
                    'case_history' => $case_history,
                    'high_risk' => $high_risk,
                    'patient_admin_date' => $patient_admin_date,
                    //'patient_discharge_date' => $patient_discharge_date,
                    //'days_after_discharge_chat_window' => $days_after_discharge_chat_window,
                    'status' => $status,
                ]);


            DB::commit();
            return response()->json(['result' => 'success','message' => 'Details Updated successfully'], 200);
        }catch (Exception $ex) {

            DB::rollback();

        }

    }


  public function addChatGroup(Request $request)
    {
        $app_model = new AppModel;
        $max_member = $request->max_member;
        
        $getUhid = '';
        $getUhid = DB::table("dm_family_member")
                ->select('uhid','family_member_full_name')
                ->where('family_member_id', $request->PatientId)->get()->toArray();

        $uhid=$getUhid[0]->uhid;
               
        //$db = DB::table('dm_chat_group')->where('group_name', $group_name)->count();

        // if ($db > 0) {
        //     return response()->json(['result'=>'error','message' => 'This group name already present please enter a new group name'], 200);
        // }
        // else {
            $insertedGroupId = DB::table('dm_chat_group')->insertGetId(
                [
                    'group_name' => $getUhid[0]->family_member_full_name,
                    'uhid' => $uhid,
                    'max_member' => $max_member,
                ]
            );

           
            
            DB::table('dm_group_members')->insertGetId(
                [
                    'group_id' => $insertedGroupId,
                    'user_id' => $request->PatientId,
                    'login_id' => $request->PatientId,
                    'role_id' => '1',
                    'uhid' =>$uhid,
                ]
            );
               

            $doctor_expl=explode(",",$request->DoctorId);
              
                for($i=0;$i<count($doctor_expl);$i++)
                {
                    if($doctor_expl[$i]>0)
                    {

                        $doctor_user_id=DB::table('dm_doctor')->where('doctor_id',$doctor_expl[$i])->select(['doctor_id','user_id'])->first();

                        DB::table('dm_group_members')->insertGetId(
                            [
                                'group_id' => $insertedGroupId,
                                'login_id' => $doctor_user_id->doctor_id,
                                'user_id' => $doctor_user_id->user_id,
                                'role_id' => '3',
                                'uhid' =>$uhid,
                            ]
                        );
                  
                    }   

                }

            

            $staff_user_id=DB::table('dm_staff')->select(['staff_id','user_id'])->first();
                DB::table('dm_group_members')->insertGetId(
                                [
                                    'group_id' => $insertedGroupId,
                                    'login_id' => $staff_user_id->staff_id,
                                    'user_id' => $staff_user_id->user_id,
                                    'role_id' => '4',
                                    'uhid' =>$uhid,
                                ]
                            );

            $updateQuery = DB::table('dm_patient_case_history')
            ->where('patient_id', $request->PatientId)
            ->where('uhid',$uhid)
            ->update([
                'group_id' => $insertedGroupId,
            ]);


            if ($insertedGroupId) {

                return response()->json(['success'=>'true','message' =>  'group added successfully'], 200);
            }
        //}

    }

	public function getChatGroup(Request $request)
    {
        try {
        
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;
        $group_id  = $request->group_id;
        $searchText = $request->searchText;

        $getQuery = DB::table("dm_chat_group")

            ->select('dm_chat_group.group_name','dm_chat_group.group_is_active','dm_chat_group.group_id','dm_family_member.family_member_mobile_number as patient_mobile_number')
            
            ->join('dm_group_members','dm_group_members.group_id','dm_chat_group.group_id')
            ->join('dm_family_member','dm_family_member.family_member_id','dm_group_members.login_id')
            ->where('dm_group_members.role_id',1)
            ->where('dm_group_members.is_family_member',0);

        if($searchText!='')
        {
            $getQuery = $getQuery->where(function ($getQuery) use ($searchText) {
            $getQuery->where('dm_chat_group.group_name', 'like', '%' . $searchText . '%')
            ->orwhere('dm_family_member.family_member_mobile_number', 'like', '%' . $searchText . '%');
            });
        }
            
             $getQuery = $getQuery->groupBy('dm_chat_group.group_id')
            ->paginate($itemsPerPage);

        }
        catch (Exception $ex) {

            return response()->json(['result'=>'error','result' => "exception", 'message' => 'Something went wrong']);
        }


        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }

    
   public function addDoctorInGroup(Request $request)
    {
        $app_model = new AppModel;
        $group_id = $request->group_id;
        $doctor_id = $request->doctor_id;
        $getGroupQuery = DB::table('dm_chat_group')->where('group_id', $group_id)->where('group_is_active',1)->get();
     
        if ($getGroupQuery->count() > 0) {
            $getGroupQuery = $getGroupQuery->toArray();

            $checkDoctorAdded = DB::table('dm_group_members')->where('group_id', $group_id)->whereIn('login_id',$doctor_id)->where('role_id',3)->get();

            if($checkDoctorAdded->count()>=1)
             {
                return response()->json(['result'=>'error','message' =>  'This Doctor already Added'], 200);
             }   
            $uhid=$getGroupQuery[0]->uhid;
            $max_member = $getGroupQuery[0]->max_member;

            $getGroupMember = DB::table('dm_group_members')->where('group_id', $group_id)->count();


            if($getGroupMember < $max_member)
            {
                for($i=0;$i<count($doctor_id);$i++)
                {
                    if($doctor_id[$i]>0)
                    {

                        DB::table('dm_group_members')->insertGetId(
                            [
                                'group_id' => $group_id,
                                'login_id' => $doctor_id[$i],
                                'role_id' => '3',
                                'uhid' =>$uhid,
                            ]
                        );
                  
                    }   

                }

                return response()->json(['result'=>'success','message' =>  'doctor has been added in group successfully'], 200);
            }
            else
            {
                
                 return response()->json(['result'=>'error','message' =>  'Maximum group member limit exceeds'], 200);
            }

            

        }
        else
        {
            return response()->json(['result'=>'error','message' => 'This group is not active'], 200);
        }
        
       
    }

     public function addFamilyMemberInGroup(Request $request)
    {
        $app_model = new AppModel;
        $group_id = $request->group_id;
        $family_member_id = $request->family_member_id;
        $relation_id = $request->relation_id;
        
        $getGroupQuery = DB::table('dm_chat_group')->where('group_id', $group_id)->where('group_is_active',1)->get();
        
        if ($getGroupQuery->count() > 0) {
            $getGroupQuery = $getGroupQuery->toArray();

            $checkMemberExist = DB::table('dm_group_members')->where('group_id', $group_id)->where('role_id',1)->where('login_id',$family_member_id)->get();
            if($checkMemberExist->count() >=1)
            {
                return response()->json(['result'=>'error','message' =>  'This Member already added in group.'], 200);
            }
			
			$checkPatientExist = DB::table('dm_group_members')->where('role_id',1)->where('is_family_member', 0)->where('login_id',$family_member_id)->where('status', 1)->count();
            if($checkPatientExist > 0)
            {   
                return response()->json(['result'=>'error','message' =>  'This family member can not be add As he/she is admitted.'], 200);
            }
			
            $uhid=$getGroupQuery[0]->uhid;
            $uhid=$getGroupQuery[0]->uhid;
            $max_member = $getGroupQuery[0]->max_member;

            $getGroupMember = DB::table('dm_group_members')->where('group_id', $group_id)->count();

            if($getGroupMember < $max_member)
            {

                DB::table('dm_group_members')->insertGetId(
                    [
                        'group_id' => $group_id,
                        'login_id' => $family_member_id,
                        'role_id' => '1',
                        'is_family_member' =>1,
                        'relation_id' => $relation_id,
                        'uhid' =>$uhid,
                    ]
                );

                return response()->json(['result'=>'success','message' =>  'Family Member has been added in group successfully'], 200);
            }
            else
            {
                
                 return response()->json(['result'=>'error','message' =>  'Maximum group member limit exceeds'], 200);
            }

            

        }
        else
        {
            return response()->json(['result'=>'error','message' => 'This group is not active'], 200);
        }
        
       
    }

    public function GetWithoutPaginationDoctor(Request $request)
    {

        //$id = $request->id;
        //$status = $request->status;
        $getQuery = DB::table("dm_doctor")->select(['doctor_id','doctor_full_name','doctor_is_active'])
            ->where('doctor_is_active',1)
            ->orderBy('doctor_id');


        $getQuery = $getQuery->get();

         $getDoctor = DB::table("dm_doctor")->where('doctor_is_active',1)->get();
         
        return response()->json(['success'=>'true','getDoctor'=>$getDoctor,'resultData' => $getQuery], 200);
    }


    public function getWithoutPaginationPatient(Request $request)
    {
        $getGroupQuery=DB::table('dm_group_members')->select('login_id')->where('role_id',1)->where('is_family_member',0)->get();
        
        $getGroupData= $getGroupQuery->toArray();
        $group_userid=array();
        foreach($getGroupData as $group_data)
        {
            $group_userid[]=$group_data->login_id;
        }
        
       $getQuery = DB::table("dm_family_member")->select('dm_family_member.family_member_id','dm_family_member.family_member_full_name','dm_family_member.family_member_mobile_number'
            ,'dm_family_member.user_id','dm_family_member.uhid',

            DB::raw('CONCAT(dm_family_member.family_member_full_name, " - ", dm_family_member.family_member_mobile_number) AS patient_name_mobile')
            )
            ->join('dm_user','dm_user.user_id','dm_family_member.user_id')

            ->join('roles','roles.id','dm_user.role_id')
            ->whereNotIn('dm_family_member.family_member_id',$group_userid)
            ->where('dm_family_member.is_self',1)
             ->where('dm_family_member.uhid','<>','')
             ->where('dm_user.role_id',1)
            //->where('roles.name','Patient')
             ->orderBy('dm_family_member.family_member_created_at','DESC');
        $getQuery = $getQuery->get();

        $getPatient = DB::table("dm_family_member")->select('dm_family_member.family_member_id','dm_family_member.family_member_full_name','dm_family_member.family_member_mobile_number'
            ,'dm_user.user_id','dm_family_member.uhid',
            DB::raw('CONCAT(dm_family_member.family_member_full_name, " - ", dm_family_member.family_member_mobile_number) AS patient_name_mobile')
            )
            ->join('dm_user','dm_user.user_id','dm_family_member.user_id')

            ->join('roles','roles.id','dm_user.role_id')
            ->where('dm_family_member.is_self',1)
             ->where('dm_family_member.uhid','<>','')
            ->where('dm_user.role_id',1)->get();

         //$getPatient = DB::table("dm_doctor")->where('doctor_is_active',1)->get();
         
        return response()->json(['success'=>'true','getPatient'=>$getPatient,'resultData' => $getQuery], 200);
    }
    
    public function changeGroupStatus(Request $request)
    {
        $status = $request->group_is_active;
        $group_id = $request->group_id;

        $st = DB::table('dm_chat_group')
            ->where('group_id',   $group_id )
            ->update([
                'group_is_active' => $status,
            ]);

        $st1 = DB::table('dm_group_members')
            ->where('group_id',   $group_id )
            ->update([
                'status' => $status,
            ]);

        if($status==0)
        {
            $dischargeQuery = DB::table('dm_patient_case_history')
            ->where('group_id', $group_id)
            ->update([
                'status' => 'Discharge', 
                'patient_discharge_date' => date('Y-m-d')
            ]);
        }
        else if($status==1)
        {
            $admitQuery = DB::table('dm_patient_case_history')
            ->where('group_id', $group_id)
            ->update([
                'status' => 'Admit', 
                'patient_discharge_date' => null,
                'patient_admin_date' => date('Y-m-d')
            ]);
        }
        if ($st) {

            return response()->json(['success'=>'true','message' => 'Group Status Changed successfully'], 200);
        }
    }
    
    public function getAllFamilyMemberList(Request $request)
    {

        $getQuery = DB::table("dm_family_member")->select(['family_member_id','family_member_full_name',
            DB::raw('CONCAT(family_member_full_name, " - ",family_member_mobile_number) AS family_member_name_mobile')
        ])
            ->where('family_member_is_active',1)
            ->orderBy('family_member_id');


        $getQuery = $getQuery->get();

        return response()->json(['success'=>'true','resultData' => $getQuery], 200);
    }

    public function getAllRelationList(Request $request)
    {

        $getQuery = DB::table("dm_patient_relation")->select(['relation_id','relation_name'])
            ->where('status',1)
            ->orderBy('relation_id');


        $getQuery = $getQuery->get();

        return response()->json(['success'=>'true','resultData' => $getQuery], 200);
    }

     public function addGroupFamilyMember(Request $request)
    {
        $app_model = new AppModel;
       
        $uhid = $request->uhid;
        $relation_id = $request->relation_id;
        $user_id = $request->user_id;

        try
        {
            $result = array();
            $result = $app_model->addGroupFamilyMember($uhid,$relation_id,$user_id);
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  

        return response()->json($result);  
    }
    
    public function getMemberApproveList(Request $request)
    {
        $app_model = new AppModel;

        $login_user_id = $request->login_user_id;

        try
        {
            //$result = array();
            $result = $app_model->getMemberApproveList($login_user_id);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  

        return response()->json($result);  
    }

     public function getRelationList(Request $request)
    {
        $app_model = new AppModel;

        try
        {
            $result = array();
            $result = $app_model->getRelationList();
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }
    
     public function getAdmittedPatientDetails(Request $request)
    {
        $app_model = new AppModel;
        $uhid = $request->uhid;

        try
        {
            $result = array();
            $result = $app_model->getAdmittedPatientDetails($uhid);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  
        return response()->json($result);  
    }
    
    public function getListAllGroupByDoctor(Request $request)
    {
        $app_model = new AppModel;
        $doctorId = $request->doctorId;

        try
        {
            $result = array();
            $result = $app_model->getListAllGroupByDoctor($doctorId);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }
    
    public function getListAllGroupByStaff(Request $request)
    {
        $app_model = new AppModel;
        $staffId = $request->staffId;

        try
        {
            $result = array();
            $result = $app_model->getListAllGroupByStaff($staffId);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }

    public function LeftFromGroup(Request $request)
    {
        $app_model = new AppModel;
        $uhid = $request->uhid;
        $userId = $request->userId;
        $groupId = $request->groupId;
        $roleId = $request->roleId;
        
        try
        {
            $result = array();
            $result = $app_model->LeftFromGroup($uhid,$userId,$groupId,$roleId);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }

    public function addUhidByStaff(Request $request)
    {
        $app_model = new AppModel;
        $uhid = $request->uhid;
        $patientId = $request->patientId;
               
        try
        {
            $result = array();
            $result = $app_model->addUhidByStaff($uhid,$patientId);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }
    
    public function getPendingPatientList(Request $request)
    {
        $app_model = new AppModel;
        
        try
        {
            $result = array();
            $result = $app_model->getPendingPatientList();
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }
    
    public function getActivePatientList(Request $request)
    {
        $app_model = new AppModel;
        
        try
        {
            $result = array();
            $result = $app_model->getActivePatientList();
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }

    public function getDischargedPatientList(Request $request)
    {
        $app_model = new AppModel;
        

        try
        {
            $result = array();
            $result = $app_model->getDischargedPatientList();
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }

    public function getDoctorsList(Request $request)
    {
        $app_model = new AppModel;
        $searchText = $request->searchText;

        try
        {
            $result = array();
            $result = $app_model->getDoctorsList($searchText);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }

    public function SearchPatientList(Request $request)
    {
        $app_model = new AppModel;
        $searchText = $request->searchText;

        try
        {
            $result = array();
            $result = $app_model->SearchPatientList($searchText);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }

    public function submitAdmitPatientDetails(Request $request)
    {
        $app_model = new AppModel;
        $uhid = $request->uhid;
        $patientId = $request->patientId;
        $bedNumber = $request->bedNumber;
        $caseHistory = $request->caseHistory;
        $highRisk = $request->highRisk;
        $patientAdmitDate = $request->patientAdmitDate;
        $closeChatDays = $request->closeChatDays;
        $treatmentType = $request->treatmentType;
        $patientDischargeDate = $request->patientDischargeDate;

        try
        {
            $result = array();
            $result = $app_model->submitAdmitPatientDetails($uhid, $patientId, $bedNumber, $caseHistory, $highRisk, $patientAdmitDate, $closeChatDays, $treatmentType, $patientDischargeDate);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }

    public function addGroupByStaff(Request $request)
    {
        $app_model = new AppModel;
        
        $patientId = $request->patientId;
        $doctorId = $request->doctorId;
        $staffId = $request->staffId;
        $groupName = $request->groupName;
        $maxMember = $request->maxMember;
        
        try
        {
            $result = array();
            $result = $app_model->addGroupByStaff($patientId, $doctorId, $staffId, $groupName, $maxMember);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }

    public function addMemberInGroupByStaff(Request $request)
    {
        $app_model = new AppModel;
        
        $uhid = $request->uhid;
        $groupId = $request->groupId;
        $doctorId = $request->doctorId;
        $familyMemberId = $request->familyMemberId;
        $relationId = $request->relationId;
       
        try
        {
            $result = array();
            $result = $app_model->addMemberInGroupByStaff($uhid, $groupId, $doctorId, $familyMemberId, $relationId);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }

    public function getAllGroupList(Request $request)
    {
        $app_model = new AppModel;
        
        try
        {
            $result = array();
            $result = $app_model->getAllGroupList();
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }

    public function disableGroup(Request $request)
    {
        $app_model = new AppModel;
       
        $uhid = $request->uhid;
        $groupId = $request->groupId;
        
        try
        {
            $result = array();
            $result = $app_model->disableGroup($uhid, $groupId);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }

    public function getAdmitPatientNotInGroup(Request $request)
    {
        $app_model = new AppModel;
                      
        try
        {
            $result = array();
            $result = $app_model->getAdmitPatientNotInGroup();
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }
    
     public function getAllGroupMembers(Request $request)
    {
        

         try {
        
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        //$filterBy = $request->searchText;
        //$member_id  = $request->member_id;
        $searchText = $request->searchText;

        $group_id = $request->group_id;
        
        $getQuery = DB::table("dm_chat_group")->select(
            'dm_chat_group.group_id',
            'dm_group_members.member_id',
            'dm_family_member.family_member_full_name as member_name',
            'dm_group_members.status',
            DB::raw('if(dm_group_members.role_id=1,"Patient","") as "role"')
            )

            ->join('dm_group_members','dm_group_members.group_id','dm_chat_group.group_id')
            ->join('dm_family_member','dm_family_member.family_member_id','dm_group_members.login_id')
            ->where('dm_chat_group.group_id',$group_id)
            ->where('dm_group_members.role_id',1)
            ->where('dm_group_members.is_family_member',0);
            

        $getMemberQuery = DB::table("dm_chat_group")->select(
            'dm_chat_group.group_id',
            'dm_group_members.member_id',
            'dm_family_member.family_member_full_name as member_name',
            'dm_group_members.status',
            DB::raw('if(dm_group_members.is_family_member=1,"Family Member","") as "role"')
            )

            ->join('dm_group_members','dm_group_members.group_id','dm_chat_group.group_id')
            ->join('dm_family_member','dm_family_member.family_member_id','dm_group_members.login_id')
            ->where('dm_chat_group.group_id',$group_id)
            ->where('dm_group_members.role_id',1)
            ->where('dm_group_members.is_family_member',1)
            ->where('dm_group_members.relation_id','<>','');
           

        $getDoctorQuery = DB::table("dm_chat_group")->select(
            'dm_chat_group.group_id',
            'dm_group_members.member_id',
            'dm_doctor.doctor_full_name as member_name',
            'dm_group_members.status',
            DB::raw('if(dm_group_members.role_id=3,"Doctor","") as "role"')
            )

            ->join('dm_group_members','dm_group_members.group_id','dm_chat_group.group_id')
            ->join('dm_doctor','dm_doctor.doctor_id','dm_group_members.login_id')
            ->where('dm_chat_group.group_id',$group_id)
            ->where('dm_group_members.role_id',3)
            ->union($getQuery)
            ->union($getMemberQuery)
            //->orderBy('dm_group_members.member_id')
            ->get();


        }
        catch (Exception $ex) {

            return response()->json(['result'=>'error','result' => "exception", 'message' => 'Something went wrong']);
        }

       // return response()->json(['result'=>'success','resultData'=>$getDoctorQuery], 200);
        return response()->json(['success'=>'true','resultData' =>  $getDoctorQuery], 200);

    }

    public function changeMemberStatus(Request  $request){
        $member_id = $request->member_id;
        $status = $request->status;

            $updateQuery = DB::table('dm_group_members')
                ->where('member_id', $member_id)
                ->update([
                    'status' => $status,


                ]);
            if ($updateQuery) {

                return response()->json(['success'=>'true','message' =>  'Member Status updated successfully'], 200);
            
            }
    }
    
    public function editAdmitPatientDetails(Request $request)
    {
        $app_model = new AppModel;
        $uhid = $request->uhid;
        $patientId = $request->patientId;
        $groupId  = $request->groupId;
        $maxMember = $request->maxMember;
        $bedNumber = $request->bedNumber;
        $caseHistory = $request->caseHistory;
        $highRisk = $request->highRisk;
        $patientAdmitDate = $request->patientAdmitDate;
        $closeChatDays = $request->closeChatDays;
        $treatmentType = $request->treatmentType;
        $patientDischargeDate = $request->patientDischargeDate;

        try
        {
            $result = array();
            $result = $app_model->editAdmitPatientDetails($uhid, $patientId, $bedNumber, $caseHistory, $highRisk, $patientAdmitDate, $closeChatDays, $treatmentType, $patientDischargeDate, $groupId, $maxMember);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }
    
    public function enableGroup(Request $request)
    {
        $app_model = new AppModel;
       
        $uhid = $request->uhid;
        $groupId = $request->groupId;
        
        try
        {
            $result = array();
            $result = $app_model->enableGroup($uhid, $groupId);
           
        }
        catch (Exception $ex) {
            $result = $ex->getMessage();
        }  


        return response()->json($result);  
    }
    
     public function deleteMemberByAdmin(Request $request)
    {
        $member_id = $request->member_id;
       
        $st = DB::table('dm_group_members')
            ->where('member_id', $member_id )
            ->delete();

        if ($st) {

            return response()->json(['success'=>'true','message' => 'Group member deleted successfully'], 200);
        }
    }
    
    /* Admited Patiend End */ 
 

 
}
