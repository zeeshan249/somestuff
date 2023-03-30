<?php

namespace App\Http\Controllers;

use App\Models\AppModel;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{

    // To check User Status
    public function checkUserStatus(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $result = $app_model->checkUserStatus($userId);
        return $result;
    }

    // To check Mobile Number
    public function checkMobileNumber(Request $request)
    {
        $app_model = new AppModel;
        $mobileNumber = $request->mobileNumber;
        $result = $app_model->checkMobileNumber($mobileNumber);
        return $result;
    }

    public function saveMobileNumber(Request $request)
    {
        $app_model = new AppModel;

        $mobileNumber = $request->mobileNumber;
        $deviceType = $request->deviceType;
        $isRegisteredUser = $request->isRegisteredUser;
        $userId = $request->userId;
        $userDeviceToken = $request->userDeviceToken;
        return $app_model->saveMobileNumber($mobileNumber, $deviceType, $isRegisteredUser, $userId, $userDeviceToken);

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

    // Send Sign up OTP
    public function sendSignupOTP($mobile, $otp)
    {
        try
        {
            $smstext = rawurlencode("<#>  Your mobile verification code is: " . $otp . " , Please don't share this code with anyone.Regards, P Maiti nUZVlP++W2a");
            $ch = curl_init("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=256dda14-3d85-4e46-83aa-1d12103bc1e2&senderid=PRIMAI&channel=2&DCS=0&flashsms=0&number=$mobile&text=%3C%23%3E%20Your%20mobile%20verification%20code%20is:%20" . $otp . ",%20Please%20don%27t%20share%20this%20code%20with%20anyone.%20Regards,%20P%20Maiti%20pJEbpuWf6Bj&route=31&EntityId=1301162038261824606&dlttemplateid=1307162100179461666");

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

    // to update name an gender
    public function updateNameGender(Request $request)
    {
        $app_model = new AppModel;

        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $gender = $request->gender;
        $userId = $request->userId;
        return $app_model->updateNameGender($firstName, $lastName, $gender, $userId);

    }

    // to save bmi hitory
    public function saveBMIHitory(Request $request)
    {
        $app_model = new AppModel;

        $userId = $request->userId;
        $userAge = $request->userAge;
        $userWeight = $request->userWeight;
        $userHeight = $request->userHeight;
        $bmiScore = $request->bmiScore;
        return $app_model->saveBMIHitory($userId, $userAge, $userWeight, $userHeight, $bmiScore);

    }

    public function getQuestion(Request $request)
    {
        $app_model = new AppModel;
        $result = $app_model->getQuestion();
        return $result;
    }

    // to update user answer
    public function updateUserAnswer(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $answer = $request->answer;
        $questionId = $request->questionId;
        return $app_model->updateUserAnswer($userId, $answer, $questionId);

    }

    // to get device list
    public function getDeviceList(Request $request)
    {
        $app_model = new AppModel;
        $devicePlatform = $request->devicePlatform;

        return $app_model->getDeviceList($devicePlatform);

    }

    // save device mapping
    public function saveUserDeviceMapping(Request $request)
    {
        $app_model = new AppModel;
        $deviceId = $request->deviceId;
        $userId = $request->userId;
        return $app_model->saveUserDeviceMapping($deviceId, $userId);

    }

    //get slider
    public function getSlider(Request $request)
    {
        $app_model = new AppModel;
        $sliderPosition = $request->sliderPosition;

        $result = $app_model->getSlider($sliderPosition);
        return $result;
    }

    // get upcoming competition
     public function getUpcomingCompetition(Request $request)
    {
        $app_model = new AppModel;
        $compTypeId = $request->compTypeId;
        return $app_model->getUpcomingCompetition($compTypeId);
    }
	 public function refreshToken(Request $request)
    {
        try
        {
            DB::beginTransaction();

            $userId = $request->userId;
            DB::table('personal_access_tokens')->where('tokenable_id', $userId)->delete();
            $user = User::where('user_id', $userId)->first();
            $token = $user->createToken($password)->plainTextToken;
            DB::table('users')
                ->where('user_id', $userId)
                ->update(['auth_token' => $token]);
            DB::commit();

            return response()->json(['result' => "success", 'message' => 'Refresh token generated', 'token' =>  $token]);
        } catch (Exception $ex) {
            DB::rollback();

            return response()->json(['result' => "error", 'message' => 'Something went wrong']);
        }

    }
	 //Profile image upload
    public function profileImageUpload(Request $request)
    {
		 
        $profileImageName = $request->name;
        $profileCurrentImageName = $request->currentPictureName;
        if (file_exists(storage_path('app/public/profile_images/' . $profileCurrentImageName))) {
            unlink(storage_path('app/public/profile_images/' . $profileCurrentImageName));
       }

        $request->file->storeAs('public/profile_images', $profileImageName);
        if ($request->file('file')->isValid()) {
          return response()->json(['result' => "success", 'message' => 'Image Uploaded Successfully']);

        } else {
           return response()->json(['result' => "error", 'message' => 'Image Uploaded Failed']);

        }
       
    }
    //update profile image
    public function updateProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $fileName = $request->fileName;
       return  $app_model->updateProfileImage($userId, $fileName);
       
    }
    // Remove profile Image
    public function removeProfileImage(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $fileName = $request->fileName;
       return $app_model->removeProfileImage($userId, $fileName);
        
    }
	 // Change Password
     public function changePassword(Request $request)
    {
        $app_model = new AppModel;
        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $userId = $request->userId;
        return $app_model->changePassword($oldPassword, $newPassword, $userId);

    }
	
	  public function getWalletBalanceOverView(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        return $app_model->getWalletBalanceOverView($userId);

    }
	public function getWalletHistory(Request $request)
    {
        $app_model = new AppModel;
     $userId = $request->userId;
     $isPaymentFromGateway = $request->isPaymentFromGateway;
     $isExpense = $request->isExpense;
  $isExpenseFlag = $request->isExpenseFlag;
        return $app_model->getWalletHistory($userId,$isPaymentFromGateway, $isExpense,$isExpenseFlag);
    }
	
	// get  competition type
    public function getCompetitionType(Request $request)
    {
        $app_model = new AppModel;
        $isViewAll = $request->isViewAll;
        return $app_model->getCompetitionType($isViewAll);
    }
    //get user competition mapping
    public function getTopTenUserListByCompScheduleId(Request $request)
    {
        $app_model = new AppModel;
        $compScheduleId=$request->compScheduleId;
        return $app_model->getTopTenUserListByCompScheduleId($compScheduleId);
    }

   //Save wallet transaction
    public function saveWalletTransaction(Request $request)
        {
           
            $app_model = new AppModel;
            $userId=$request->userId;
            $walletBalanceAmountFromPaymentGateway=$request->walletBalanceAmountFromPaymentGateway;
            $walletBalanceAmountFromCompetition=$request->walletBalanceAmountFromCompetition;
            $transactionId=$request->transactionId;
            $walletDescription=$request->walletDescription;
            $walletBalanceAddedDeductedAmount=$request->walletBalanceAddedDeductedAmount;
            $isWalletBalanceAdded=$request->isWalletBalanceAdded;
            $isWalletBalanceFromPaymentGateway=$request->isWalletBalanceFromPaymentGateway;
            $compScheduleId = $request->compScheduleId;

            return $app_model->saveWalletTransaction($userId,$walletBalanceAmountFromPaymentGateway,$walletBalanceAmountFromCompetition,
            $transactionId,  $walletDescription, $walletBalanceAddedDeductedAmount,$isWalletBalanceAdded,
            $isWalletBalanceFromPaymentGateway,$compScheduleId );
        }


    
        //check join comp
         public function checkJoinCompetitionCondition(Request $request)
        {
           
            $app_model = new AppModel;
            $userId=$request->userId;
            $compScheduleId = $request->compScheduleId;
    $compScheduleStartDate= $request->compScheduleStartDate;
    $compScheduleEndDate= $request->compScheduleEndDate;
    $userPotPaticipationValue = $request->userPotPaticipationValue;


            return $app_model->checkJoinCompetitionCondition($userId,$compScheduleId, $compScheduleStartDate,
             $compScheduleEndDate, $userPotPaticipationValue );
        }

    // join comp
    public function joinCompetition(Request $request)
    {

        $app_model = new AppModel;
        $userId = $request->userId;
        $compScheduleId = $request->compScheduleId;
        $compScheduleStartDate = $request->compScheduleStartDate;
        $compScheduleEndDate = $request->compScheduleEndDate;
        $walletId = $request->walletId;
        $paymentAmount = $request->paymentAmount;
        $isPaymentGatewayWallet = $request->isPaymentGatewayWallet;

        $userPotPaticipationValue = $request->userPotPaticipationValue;
        $compMasterId = $request->compMasterId;
     $walletDescription = $request->walletDescription;

        return $app_model->joinCompetition($userId, $compScheduleId, $compScheduleStartDate,
            $compScheduleEndDate, $walletId, $paymentAmount, $isPaymentGatewayWallet, $userPotPaticipationValue,
            $compMasterId, $walletDescription
        );
    }
  // sync fitness data
     public function syncFitnessData(Request $request)
    {

        $app_model = new AppModel;
        $userId = $request->userId;
        $deviceId = $request->deviceId;
        $fitnessData = $request->fitnessData;
     

        return $app_model->syncFitnessData($userId, $deviceId, $fitnessData
        
        );
    }
	 // get comp user wise
     public function getCompetitionUserWise(Request $request)
    {
        $app_model = new AppModel;
        $userId = $request->userId;
        $compMappingStatus = $request->compMappingStatus;
      
        return $app_model->getCompetitionUserWise($userId, $compMappingStatus);
    }
	// get comp details user wise
 public function getUserCompDetails(Request $request){
        $app_model = new AppModel;
        $compScheduleId = $request->compScheduleId;
        $userId = $request->userId;
      

        return $app_model->getUserCompDetails(  $compScheduleId, $userId      
        );
    }
	//get subscription
  
    public function getSubscription(Request $request){
        $app_model = new AppModel;
        $userId=$request->userId;
        return $app_model->getSubscription($userId);
    }
	 // subscribe
      public function subscribe(Request $request)
    {

        $app_model = new AppModel;
        $userId = $request->userId;
        $subscriptionMasterId = $request->subscriptionMasterId;
        $walletId = $request->walletId;
        $paymentAmount = $request->paymentAmount;
        $isPaymentGatewayWallet = $request->isPaymentGatewayWallet;
        $walletDescription = $request->walletDescription;

        return $app_model->subscribe($userId, $subscriptionMasterId, $walletId, $paymentAmount, 
        $isPaymentGatewayWallet, $walletDescription
        );
    }
}
