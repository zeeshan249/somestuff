<?php

namespace App\Models;

use App\Models\User;
use DB;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{

    // To check User Status
    public function checkUserStatus($userId)
    {
        try {
            $getQuery = DB::table('users')
               ->leftJoin('subscription_master', 'subscription_master.subscription_master_id', '=', 'users.subscription_master_id')
                ->where('user_id', '=', $userId)
                ->select([
                    'user_id',
                    'role_id',
                    'user_mobile',
                    'user_first_name',
                    'user_last_name',
                    'user_full_name',
                    'user_email',
                    'user_age',
                    'user_weight',
                    'user_height',
                    'user_gender',
                    'user_profile_image',
                    'user_status',
                    'is_subscribed',
                    'question_id',
                    'question_answer',
                    'device_id',
                    'bmi_score',
                    'user_last_fitness_sync_date',
                    DB::raw('DATE_FORMAT(user_signup_date, "%d-%m-%Y") as user_signup_date', "%d-%m-%Y"),
                     'users.subscription_master_id',
                ])
                ->get();
            $getResult = $getQuery->toArray();
            if ($getQuery->count() > 0) {
                if ($getResult[0]->user_status == 1) {
                    return response()->json(['userData' => $getResult, 'result' => 'success', 'message' => 'success']);
                } else {
                    return response()->json(['userData' => [], 'result' => 'blocked', 'message' => 'Account is suspended/blocked']);
                }
            } else {
                return response()->json(['userData' => [], 'result' => 'not found', 'message' => 'User not found']);
            }

        } catch (Exception $ex) {
            return response()->json(['userData' => [], 'result' => 'error', 'message' => 'Something went wrong']);
        }
    }

    // To check Mobile Number
    public function checkMobileNumber($mobileNumber)
    {
        try {
            $getQuery = DB::table('users')
            ->join('subscription_master', 'subscription_master.subscription_master_id', '=', 'users.subscription_master_id')
                ->where('user_mobile', '=', $mobileNumber)
                
                ->select([
                    'user_id',
                    'role_id',
                    'user_mobile',
                    'user_first_name',
                    'user_last_name',
                    'user_full_name',
                    'user_email',
                    'user_age',
                    'user_weight',
                    'user_height',
                    'user_gender',
                    'user_profile_image',
                    'user_status',
                    'is_subscribed',
                    'question_id',
                    'question_answer',
                    'device_id',
                    'bmi_score',
                    'user_last_fitness_sync_date',
                    DB::raw('DATE_FORMAT(user_signup_date, "%d-%m-%Y") as user_signup_date', "%d-%m-%Y"),
                     'users.subscription_master_id',
                ])
                ->get();
            if ($getQuery->count() > 0) {
                if ($getQuery[0]->user_status == 1) {
                    return response()->json(['userData' => $getQuery, 'result' => 'success', 'message' => 'success']);
                } else {
                    return response()->json(['userData' => [], 'result' => 'blocked', 'message' => 'Account is suspended/blocked']);
                }
            } else {
                return response()->json(['userData' => [], 'result' => 'not found', 'message' => 'User not found']);
            }
        } catch (Exception $ex) {
            return response()->json(['userData' => [], 'result' => 'error', 'message' => $ex->getMessage()]);
        }

    }

    // save mobile number
    public static function saveMobileNumber($mobileNumber, $deviceType, $isRegisteredUser, $userId, $userDeviceToken)
    {
        try {
            $newUserId = '';
            DB::beginTransaction();
            $password = random_int(100000, 999999);
            if ($isRegisteredUser == "1") {
                // existing user
                $newUserId = $userId;
                $user = User::where('user_id', $userId)->first();
                $token = $user->createToken($password)->plainTextToken;
                DB::table('users')
                    ->where('user_id', $userId)
                    ->update(['auth_token' => $token, 'user_device_token' => $userDeviceToken]);

            } else {
                // New User
                $newUserId = DB::table('users')->insertGetId(
                    [

                        'user_mobile' => $mobileNumber,
                        'password' => bcrypt($password),
                        'password_normal' => $password,
                        'user_device_type' => $deviceType,
                        'role_id' => 3,
                    ]
                );
                $user = User::where('user_id', $newUserId)->first();
                $token = $user->createToken($password)->plainTextToken;
                DB::table('users')
                    ->where('user_id', $newUserId)
                    ->update(['auth_token' => $token, 'user_device_token' => $userDeviceToken]);

            }

            DB::commit();
            return response()->json(['result' => 'success', 'token' => $token, 'userId' => $newUserId]);

        } catch (Exception $ex) {

            DB::rollback();

            return response()->json(['result' => "error", 'message' => 'Something went wrong']);
        }

    }

    // Update Device Token
    public function updateDeviceToken($userId, $userDeviceToken)
    {
        DB::table('users')
            ->where('user_id', $userId)
            ->update(['user_device_token' => $userDeviceToken]);

        $getResult['result'] = "success";
        return $getResult;
    }

    // update name and gender
    public static function updateNameGender($firstName, $lastName, $gender, $userId)
    {
        try {

            DB::beginTransaction();

            DB::table('users')
                ->where('user_id', $userId)
                ->update([
                    'user_first_name' => ucfirst($firstName),
                    'user_last_name' => ucfirst($lastName),
                    'user_full_name' => ucfirst($firstName) . ' ' . ucfirst($lastName),
                    'user_gender' => $gender,
                ]);

            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'Details updated successfully']);

        } catch (Exception $ex) {

            DB::rollback();

            return response()->json(['result' => "error", 'message' => 'Something went wrong']);
        }

    }

    // save bmi history
    public static function saveBMIHitory($userId, $userAge, $userWeight, $userHeight, $bmiScore)
    {
        try {

            DB::beginTransaction();
            DB::table('bmi_history')->insertGetId(
                [

                    'user_id' => $userId,
                    'user_age' => $userAge,
                    'user_weight' => $userWeight,
                    'user_height' => $userHeight,
                    'bmi_score' => $bmiScore,

                ]
            );

            DB::table('users')
                ->where('user_id', $userId)
                ->update([
                    'user_age' => $userAge,
                    'user_weight' => $userWeight,
                    'user_height' => $userHeight,
                    'bmi_score' => $bmiScore,
                ]);

            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'BMI updated successfully']);

        } catch (Exception $ex) {

            DB::rollback();

            return response()->json(['result' => "error", 'message' => 'Something went wrong']);
        }

    }

    public function getQuestion()
    {
        try {
            $getQuery = DB::table('questions')
                ->where('question_status', '=', 1)
                ->select([
                    'question_id',
                    'question_text',
                    'option_1',
                    'option_2',
                    'option_3',
                    'option_4',
                ])
                ->get();
            $getResult = $getQuery->toArray();

            return response()->json(['questionData' => $getResult, 'result' => 'success', 'message' => 'success']);

        } catch (Exception $ex) {
            return response()->json(['questionData' => [], 'result' => 'error', 'message' => 'Something went wrong']);
        }
    }

    // to update user answer
    public static function updateUserAnswer($userId, $answer, $questionId)
    {
        try {

            DB::beginTransaction();

            DB::table('users')
                ->where('user_id', $userId)
                ->update([
                    'question_id' => $questionId,
                    'question_answer' => $answer,

                ]);

            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'Answer updated successfully']);

        } catch (Exception $ex) {

            DB::rollback();

            return response()->json(['result' => "error", 'message' => 'Something went wrong']);
        }

    }
    // to get device list
    public static function getDeviceList($devicePlatform)
    {
        try {
            $getQuery = DB::table('device')

                ->select([
                    'device_id',
                    'device_name',
                    'device_type',
                    'device_logo',
                    'is_device_auth_required',
                    'device_auth_param',
                    'device_auth_url',
                    'is_device_app_installation_required',
                    'device_app_android_url',
                    'device_app_ios_url',
                    'android_package_name',
                    'ios_package_name',

                ])
                ->where('device_status', 1)
                ->whereRaw('FIND_IN_SET("' . $devicePlatform . '",device_os_type)')
                ->get();

            $getResult = $getQuery->toArray();

            return response()->json(['deviceData' => $getResult, 'result' => 'success', 'message' => 'success']);
        } catch (Exception $ex) {

            return response()->json(['result' => "error", 'message' => 'Something went wrong']);
        }

    }

    // save device user mapping
    public static function saveUserDeviceMapping($deviceId, $userId)
    {
        try {

            DB::beginTransaction();
            $insertId = DB::table('user_device_mapping')->insertGetId(
                [

                    'device_id' => $deviceId,
                    'user_id' => $userId,

                ]
            );
            DB::table('user_device_mapping')
                ->where('device_id', '!=', $deviceId)
                ->where('user_id', '=', $userId)
                ->update([
                    'device_mapping_status' => 0,

                ]);

            DB::table('users')
                ->where('user_id', '=', $userId)
                ->update([
                    'device_id' => $deviceId,

                ]);

            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'Device details updated successfully']);

        } catch (Exception $ex) {

            DB::rollback();

            return response()->json(['result' => "error", 'message' => 'Something went wrong']);
        }

    }
    //get slider
    public function getSlider($sliderPosition)
    {
        try {
            $getQuery = DB::table('slider')
                ->where('slider_status', '=', 1)
                ->where('slider_position', '=', $sliderPosition)
                ->whereRaw('now() between slider_start_date and slider_end_date')
                ->select([
                    'slider_id',
                    'slider_name',
                    'slider_image',
                    'slider_action',
                ])
                ->get();
            $getResult = $getQuery->toArray();

            return response()->json(['sliderData' => $getResult, 'result' => 'success', 'message' => 'success']);

        } catch (Exception $ex) {
            return response()->json(['sliderData' => [], 'result' => 'error', 'message' => 'Something went wrong']);
        }
    }
    // get upcoming competition
    public function getUpcomingCompetition($compTypeId)
    {
        try {

            $getQuery = DB::table('competition_master')
                ->join('competition_type', 'competition_type.comp_type_id', '=', 'competition_master.comp_type_id')
                ->join('competition_schedule', 'competition_schedule.comp_master_id', '=', 'competition_master.comp_master_id')
                ->join('competition_activity', 'competition_activity.comp_activity_id', '=', 'competition_master.comp_activity_id')
                ->join('competition_category', 'competition_category.comp_category_id', '=', 'competition_master.comp_category_id')
                ->join('comp_rule', 'comp_rule.rule_id', '=', 'competition_master.rule_id')
                ->join('privacy_rule', 'privacy_rule.privacy_id', '=', 'competition_master.privacy_id')
                ->where('competition_master.comp_master_status', '=', 1)
                ->where('competition_type.comp_type_id', '=', $compTypeId)
          ->whereRaw('competition_schedule.comp_schedule_start_date>date_add(curdate(),interval competition_schedule.comp_display_filter_days Day)')      
                ->select(['competition_master.comp_master_id',
                    'competition_master.comp_master_name',
                    'competition_master.comp_master_days',
                    'competition_master.comp_master_total_km',
                    'competition_master.comp_master_minimum_km_per_day',
                    'competition_master.comp_master_max_participant',
                    'competition_master.comp_master_min_participant',
                    'competition_master.comp_master_pot_value',
                    'competition_master.comp_master_per_partition_value',
                    'competition_master.comp_master_rest_day',
                    'competition_master.comp_master_rest_day_frequency',
                    'competition_master.daily_loyalty_point',
                    'competition_master.achievers_loyalty_point',
                    'competition_master.comp_master_image',

                    'competition_type.comp_type_id',
                    'competition_type.comp_type_name',

                    'competition_category.comp_category_id',
                    'competition_category.comp_category_name',
                    'competition_category.comp_category_image',

                    'competition_activity.comp_activity_id',
                    'competition_activity.comp_activity_name',
                    'competition_activity.comp_activity_image',

                    'comp_rule.rule_id',
                    'comp_rule.rule_details',

                    'privacy_rule.privacy_id',
                    'privacy_rule.privacy_details',
                    'competition_schedule.comp_schedule_id',
                    DB::raw('DATE_FORMAT(competition_schedule.comp_schedule_start_date, "%d-%m-%Y") as comp_schedule_start_date', "%d-%m-%Y"),
                    DB::raw('DATE_FORMAT(competition_schedule.comp_schedule_end_date, "%d-%m-%Y") as comp_schedule_end_date', "%d-%m-%Y"),

                ])
                ->distinct()
                ->paginate();

            return response()->json(['compData' => $getQuery, 'result' => 'success', 'message' => 'success']);

        } catch (Exception $ex) {
            return response()->json(['compData' => [], 'result' => 'error', 'message' => 'Something went wrong']);
        }
    }

    //Change Password
    public function changePassword($oldPassword, $newPassword, $userId)
    {
        try {
            DB::beginTransaction();

            $getQuery = DB::table('users')
                ->where('user_id', '=', $userId)
                ->select(['password'])
                ->first();
            $bcryptPassword = $getQuery->password;
            if (password_verify($oldPassword, $bcryptPassword)) {

                DB::table('users')
                    ->where('user_id', $userId)
                    ->update([
                        'password' => bcrypt($newPassword),
                        'password_normal' => $newPassword,

                    ]);

                DB::commit();
                return response()->json(['result' => "success", 'message' => 'Password Changed Successfully']);

            } else {
                return response()->json(['result' => "wrong", 'message' => 'Incorrect Old Password']);

            }
        } catch (Exception $ex) {
            DB::rollback();

            return response()->json(['result' => "error", 'message' => 'Something went wrong']);

        }

    }
    // Update profile image
    public function updateProfileImage($userId, $fileName)
    {
        try {
            DB::beginTransaction();
            DB::table('users')
                ->where('user_id', $userId)
                ->update(['user_profile_image' => $fileName]);

            DB::commit();
            return response()->json(['result' => "success", 'message' => 'Profile Image Updated Successfully']);

        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['result' => "error", 'message' => 'Something went wrong']);

        }

    }
    // Remove profile image
    public function removeProfileImage($userId, $fileName)
    {
        try {
            DB::beginTransaction();
            DB::table('users')
                ->where('user_id', $userId)
                ->update(['user_profile_image' => '0']);

            if (file_exists(storage_path('app/public/profile_images/' . $fileName))) {
                unlink(storage_path('app/public/profile_images/' . $fileName));
            }
            DB::commit();
            return response()->json(['result' => "success", 'message' => 'Profile Image Removed Successfully']);

        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['result' => "error", 'message' => 'Something went wrong']);

        }

    }
    //get wallet balance overview
    public function getWalletBalanceOverView($userId)
    {
        try {
            DB::beginTransaction();

            $getQuery = DB::table('wallet')
                ->join('wallet_history', 'wallet_history.wallet_id', '=', 'wallet.wallet_id')
                ->where('wallet.user_id', '=', $userId)
                ->select(['wallet.wallet_balance_amount_from_payment_gateway', 'wallet.wallet_balance_amount_from_competition',
                    'wallet.total_wallet_balance_amount', 'wallet.wallet_id',

                    DB::raw("(SELECT IFNULL(sum(wallet_history.wallet_balance_added_deducted_amount),0) FROM wallet_history  where wallet.wallet_id=
         wallet_history.wallet_id and wallet_history.user_id=$userId and wallet_history.is_wallet_balance_added=1
) as wallet_balance_added_amount"),

                    DB::raw("(SELECT IFNULL(sum(wallet_history.wallet_balance_added_deducted_amount),0) FROM wallet_history  where wallet.wallet_id=
         wallet_history.wallet_id and wallet_history.user_id=$userId and wallet_history.is_wallet_balance_added=0
) as wallet_balance_deducted_amount"),

                ])
                ->get();
            $getResult = $getQuery->toArray();
            if ($getQuery->count() > 0) {
                return response()->json(['result' => "success", 'income' => $getResult[0]->wallet_balance_added_amount,
                    'expense' => $getResult[0]->wallet_balance_deducted_amount, 'wallet_balance_amount_from_payment_gateway' => $getResult[0]->wallet_balance_amount_from_payment_gateway,
                    'wallet_balance_amount_from_competition' => $getResult[0]->wallet_balance_amount_from_competition,
                    'total_wallet_balance_amount' => $getResult[0]->total_wallet_balance_amount,
                    'wallet_id' => $getResult[0]->wallet_id,

                ]);
            } else {
                return response()->json(['result' => "fail", 'message' => 'Wallet balance not found']);
            }
        } catch (Exception $ex) {
            DB::rollback();

            return response()->json(['result' => "error", 'message' => 'Something went wrong']);

        }

    }

    // get wallet history
    public function getWalletHistory($userId, $isPaymentFromGateway, $isExpense, $isExpenseFlag)
    {
        try {
            if ($isExpenseFlag == "0") {
                $getQuery = DB::table('wallet_history')

                    ->where('user_id', '=', $userId)
                    ->where('is_wallet_balance_from_payment_gateway', '=', $isPaymentFromGateway)
                    ->where('is_wallet_balance_added', '!=', 0)
                    ->select(['wallet_history_id',
                        'wallet_id',
                        'transaction_id',
                        'wallet_description',
                        'wallet_balance_added_deducted_amount',
                        'is_wallet_balance_added',
                        DB::raw('DATE_FORMAT(wallet_history_date, "%d-%m-%Y") as wallet_history_date', "%d-%m-%Y"),

                    ])
                    ->paginate();

                return response()->json(['walletHistoryData' => $getQuery, 'result' => 'success', 'message' => 'success']);

            } else {
                $getQuery = DB::table('wallet_history')

                    ->where('user_id', '=', $userId)
                    ->where('is_wallet_balance_added', '=', $isExpense)
                    ->select(['wallet_history_id',
                        'wallet_id',
                        'transaction_id',
                        'wallet_description',
                        'wallet_balance_added_deducted_amount',
                        'is_wallet_balance_added',
                        DB::raw('DATE_FORMAT(wallet_history_date, "%d-%m-%Y") as wallet_history_date', "%d-%m-%Y"),

                    ])
                    ->paginate();

                return response()->json(['walletHistoryData' => $getQuery, 'result' => 'success', 'message' => 'success']);

            }

        } catch (Exception $ex) {
            return response()->json(['walletHistoryData' => [], 'result' => 'error', 'message' => 'Something went wrong']);
        }
    }
    // get upcoming competition
    public function getCompetitionType($isViewAll)
    {
        try {
            if ($isViewAll == "1") {
                // all
                $getQuery = DB::table('competition_type')
                    ->join('competition_category', 'competition_category.comp_category_id', '=', 'competition_type.comp_category_id')
                    ->join('competition_activity', 'competition_activity.comp_activity_id', '=', 'competition_type.comp_activity_id')
                    ->where('competition_type.comp_type_status', '=', 1)
                    ->where('competition_category.comp_category_status', '=', 1)
                    ->where('competition_activity.comp_activity_status', '=', 1)

                    ->select(['competition_type.comp_type_id',
                        'competition_type.comp_category_id',
                        'competition_type.comp_activity_id',
                        'competition_type.comp_type_name',
                        'competition_category.comp_category_name',
                        'competition_category.comp_category_image',
                        'competition_activity.comp_activity_name',
                        'competition_activity.comp_activity_image',

                    ])

                    ->paginate();

                return response()->json(['compTypeData' => $getQuery, 'result' => 'success', 'message' => 'success']);

            } else {
                $getQuery = DB::table('competition_type')
                    ->join('competition_category', 'competition_category.comp_category_id', '=', 'competition_type.comp_category_id')
                    ->join('competition_activity', 'competition_activity.comp_activity_id', '=', 'competition_type.comp_activity_id')
                    ->where('competition_type.comp_type_status', '=', 1)
                    ->where('competition_category.comp_category_status', '=', 1)
                    ->where('competition_activity.comp_activity_status', '=', 1)

                    ->select(['competition_type.comp_type_id',
                        'competition_type.comp_category_id',
                        'competition_type.comp_activity_id',
                        'competition_type.comp_type_name',
                        'competition_category.comp_category_name',
                        'competition_category.comp_category_image',
                        'competition_activity.comp_activity_name',
                        'competition_activity.comp_activity_image',

                    ])

                    ->paginate(10);

                return response()->json(['compTypeData' => $getQuery, 'result' => 'success', 'message' => 'success']);

            }

        } catch (Exception $ex) {
            return response()->json(['compTypeData' => [], 'result' => 'error', 'message' => 'Something went wrong']);
        }
    }

    public function getTopTenUserListByCompScheduleId($compScheduleId)
    {
        try
        {
            $getQuery = DB::table('user_comp_mapping')
                ->join('users', 'users.user_id', 'user_comp_mapping.user_id')
                ->select(['user_comp_mapping.user_id', 'user_comp_mapping.comp_schedule_id'
                    , 'users.user_first_name', 'users.user_last_name', 'users.user_profile_image',

                    DB::raw("(SELECT IFNULL(count(user_comp_mapping.comp_mapping_id),0) FROM user_comp_mapping  where user_comp_mapping.comp_schedule_id=$compScheduleId and user_comp_mapping.comp_mapping_status=1
) as total_user"),

                ])

                ->where('user_comp_mapping.comp_schedule_id', $compScheduleId)
                ->where('user_comp_mapping.comp_mapping_status', 1)
                ->orderBy('user_comp_mapping.comp_mapping_date', 'desc')
                ->limit(10)
                ->get();

            return response()->json(['topTenUserListByCompScheduleId' => $getQuery, 'result' => 'success', 'message' => 'success']);
        } catch (Exception $ex) {
            return response()->json(['topTenUserListByCompScheduleId' => [], 'result' => 'error', 'message' => 'Something went wrong']);
        }
    }

    //Sabe wallet transaction
    public function saveWalletTransaction($userId, $walletBalanceAmountFromPaymentGateway, $walletBalanceAmountFromCompetition,
        $transactionId, $walletDescription, $walletBalanceAddedDeductedAmount, $isWalletBalanceAdded,
        $isWalletBalanceFromPaymentGateway, $compScheduleId) {

        try {
            DB::beginTransaction();
            $walletId = '';
            $transactionCode = '';
            $totalWalletBalanceAmount = '';
            $getUserWalletBalanceQuery = DB::table('wallet')->where('user_id', $userId)

                ->get();
            $getUserWalletBalanceResult = $getUserWalletBalanceQuery->toArray();

            if ($getUserWalletBalanceQuery->count() == 0) {
                // insert wallet balance

                $totalWalletBalanceAmount = $walletBalanceAmountFromPaymentGateway + $walletBalanceAmountFromCompetition;

                $walletId = DB::table('wallet')->insertGetId(
                    [
                        'user_id' => $userId,
                        'wallet_balance_amount_from_payment_gateway' => $walletBalanceAmountFromPaymentGateway,
                        'wallet_balance_amount_from_competition' => $walletBalanceAmountFromCompetition,
                        'total_wallet_balance_amount' => $totalWalletBalanceAmount,

                    ]
                );

            } else {
                // update wallet balance
                $walletId = $getUserWalletBalanceResult[0]->wallet_id;
                $totalWalletBalanceAmount = $walletBalanceAmountFromPaymentGateway + $getUserWalletBalanceResult[0]->wallet_balance_amount_from_payment_gateway + $walletBalanceAmountFromCompetition + $walletBalanceAmountFromCompetition + $getUserWalletBalanceResult[0]->wallet_balance_amount_from_competition;

                DB::table('wallet')
                    ->where('user_id', $userId)
                    ->update(['wallet_balance_amount_from_payment_gateway' => $walletBalanceAmountFromPaymentGateway + $getUserWalletBalanceResult[0]->wallet_balance_amount_from_payment_gateway,
                        'wallet_balance_amount_from_competition' => $walletBalanceAmountFromCompetition + $getUserWalletBalanceResult[0]->wallet_balance_amount_from_competition,
                        'total_wallet_balance_amount' => $totalWalletBalanceAmount,
                    ]);

            }
            $transactionCodePrefix = "TR" . date("ym");
            $transactionCode = IdGenerator::generate(['table' => 'wallet_history', 'field' => 'transaction_id', 'length' => 18, 'prefix' => $transactionCodePrefix,
                'reset_on_prefix_change' => true]);

            $wallethistoryid = DB::table('wallet_history')->insertGetId(
                [
                    'wallet_id' => $walletId,
                    'user_id' => $userId,
                    'transaction_id' => $transactionCode,
                    'wallet_description' => $walletDescription,
                    'wallet_balance_added_deducted_amount' => $walletBalanceAddedDeductedAmount,
                    'is_wallet_balance_added' => $isWalletBalanceAdded,
                    'is_wallet_balance_from_payment_gateway' => $isWalletBalanceFromPaymentGateway,
                    'payment_code' => $isWalletBalanceFromPaymentGateway ? $transactionId : null,
                    'comp_schedule_id' => $compScheduleId != null ? $compScheduleId : null,

                ]
            );
            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'Wallet balance Updated']);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['result' => 'error', 'message' => $ex->getMessage()]);
        }

    }
    //check join comp
    public function checkJoinCompetitionCondition($userId, $compScheduleId, $compScheduleStartDate,
        $compScheduleEndDate, $userPotPaticipationValue) {

        try {

            $getUserCompMappingQuery = DB::table('user_comp_mapping')->where('user_id', $userId)
                ->where('comp_schedule_id', $compScheduleId)
                ->where('comp_schedule_start_date', date('Y-m-d', strtotime($compScheduleStartDate)))
                ->where('comp_schedule_end_date', date('Y-m-d', strtotime($compScheduleEndDate)))

                ->get();
            $getUserCompMappingQueryResult = $getUserCompMappingQuery->toArray();

            if ($getUserCompMappingQuery->count() == 0) {
                //Check wallet balance
                $getUserWalletBalanceQuery = DB::table('wallet')->where('user_id', $userId)

                    ->get();
                $getUserWalletBalanceResult = $getUserWalletBalanceQuery->toArray();
                if ($getUserWalletBalanceQuery->count() == 0 || $userPotPaticipationValue > $getUserWalletBalanceResult[0]->total_wallet_balance_amount) {
                    return response()->json(['result' => 'error', 'message' => 'Insufficient wallet balance.Please add wallet balance to join the cometition']);

                } else {
                    return response()->json(['result' => 'success', 'message' => 'success']);

                }

            } else {
                // user already joined
                return response()->json(['result' => 'joined', 'message' => 'You have already joined the competition']);

            }

        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['result' => 'error', 'message' => 'Something went wrong']);
        }

    }
    // join comp
    public function joinCompetition($userId, $compScheduleId, $compScheduleStartDate,
        $compScheduleEndDate, $walletId, $paymentAmount, $isPaymentGatewayWallet, $userPotPaticipationValue,
        $compMasterId, $walletDescription
    ) {

        try {

            DB::beginTransaction();
            $userCompMappingId = DB::table('user_comp_mapping')->insertGetId(
                [
                    'user_id' => $userId,
                    'comp_schedule_id' => $compScheduleId,
                    'comp_schedule_start_date' => date('Y-m-d', strtotime($compScheduleStartDate)),
                    'comp_schedule_end_date' => date('Y-m-d', strtotime($compScheduleEndDate)),

                ]
            );

            DB::table('user_comp_mapping_transaction')->insertGetId(
                [
                    'user_id' => $userId,
                    'comp_schedule_id' => $compScheduleId,
                    'comp_mapping_id' => $userCompMappingId,
                    'wallet_id' => $walletId,
                    'payment_amount' => $paymentAmount,
                    'payment_from_wallet_competition_balance' => $isPaymentGatewayWallet == "1" ? $paymentAmount : "0",
                    'payment_from_wallet_competition_payment_gateway' => $isPaymentGatewayWallet == "0" ? $paymentAmount : "0",
                ]
            );

            $getUserWalletBalanceQuery = DB::table('wallet')
                ->where('user_id', $userId)
                ->where('wallet_id', $walletId)
                ->get();
            $getUserWalletBalanceResult = $getUserWalletBalanceQuery->toArray();

            DB::table('wallet')
                ->where('user_id', $userId)
                ->where('wallet_id', $walletId)
                ->update(
                    [
                        'wallet_balance_amount_from_payment_gateway' => $isPaymentGatewayWallet == "1" ? $getUserWalletBalanceResult[0]->wallet_balance_amount_from_payment_gateway - $paymentAmount : $getUserWalletBalanceResult[0]->wallet_balance_amount_from_payment_gateway,
                        'wallet_balance_amount_from_competition' => $isPaymentGatewayWallet == "0" ? $getUserWalletBalanceResult[0]->wallet_balance_amount_from_competition - $paymentAmount : $getUserWalletBalanceResult[0]->wallet_balance_amount_from_competition,
                        'total_wallet_balance_amount' => $getUserWalletBalanceResult[0]->total_wallet_balance_amount - $paymentAmount,
                    ]);

            $transactionCodePrefix = "TR" . date("ym");
            $transactionCode = IdGenerator::generate(['table' => 'wallet_history', 'field' => 'transaction_id', 'length' => 18, 'prefix' => $transactionCodePrefix,
                'reset_on_prefix_change' => true]);

            $wallethistoryid = DB::table('wallet_history')->insertGetId(
                [
                    'wallet_id' => $walletId,
                    'user_id' => $userId,
                    'transaction_id' => $transactionCode,
                    'wallet_description' => $walletDescription,
                    'wallet_balance_added_deducted_amount' => $paymentAmount,
                    'is_wallet_balance_added' => 0,
                    'is_wallet_balance_from_payment_gateway' => $isPaymentGatewayWallet,
                    'payment_code' => null,
                    'comp_schedule_id' => $compScheduleId,

                ]
            );

            $getCompMasterQuery = DB::table('competition_master')
                ->where('comp_master_id', $compMasterId)
                ->get();
            $getCompMasterResult = $getCompMasterQuery->toArray();

            DB::table('competition_master')
                ->where('comp_master_id', $compMasterId)

                ->update(
                    [

                        'comp_master_pot_value' => $getCompMasterResult[0]->comp_master_pot_value + $paymentAmount,
                    ]);
            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'You have joined the competition']);

        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['result' => 'error', 'message' => $ex->getMessage()]);
        }

    }

    public function syncFitnessData($userId, $deviceId, $fitnessData
    ) {

        try {

            DB::beginTransaction();
            DB::table('users')
                ->where('user_id', $userId)

                ->update(
                    [

                        'user_last_fitness_sync_date' => now(),
                    ]);

            $fitnessDataInJsonArray = json_decode($fitnessData);
            for ($i = 0; $i < count($fitnessDataInJsonArray); $i++) {
                $dateFrom = date('Y-m-d h:i:s', strtotime($fitnessDataInJsonArray[$i]->date_from));
                $dateTo = date('Y-m-d h:i:s', strtotime($fitnessDataInJsonArray[$i]->date_to));

                //calorie
                $fitnessCalorieDataQuery = DB::table('user_fitness_calorie')

                    ->where('user_id', $userId)
                    ->where('start_date', $dateFrom)
                    ->where('end_date', $dateTo)
                    ->where('device_id', $deviceId)
                    ->get();
                if ($fitnessCalorieDataQuery->count() > 0) {

                } else {
                    //insert
                    if ($fitnessDataInJsonArray[$i]->data_type == "ACTIVE_ENERGY_BURNED") {
                        $insertDataId = DB::table('user_fitness_calorie')->insertGetId(

                            [
                                'user_id' => $userId,
                                'device_id' => $deviceId,
                                'start_date' => $dateFrom,
                                'end_date' => $dateTo,
                                'calorie_burnt' => $fitnessDataInJsonArray[$i]->value->numericValue,
                            ]

                        );

                    }

                }
                //Distance Android
                $fitnessDistanceAndroidDataQuery = DB::table('user_fitness_distance')

                    ->where('user_id', $userId)
                    ->where('start_date', $dateFrom)
                    ->where('end_date', $dateTo)
                    ->where('device_id', $deviceId)
                    ->get();
                if ($fitnessDistanceAndroidDataQuery->count() > 0) {

                } else {
                    //insert
                    if ($fitnessDataInJsonArray[$i]->data_type == "DISTANCE_DELTA") {
                        $insertDataId = DB::table('user_fitness_distance')->insertGetId(

                            [
                                'user_id' => $userId,
                                'device_id' => $deviceId,
                                'start_date' => $dateFrom,
                                'end_date' => $dateTo,
                                'distance_covered' => $fitnessDataInJsonArray[$i]->value->numericValue,
                            ]

                        );

                    }

                }
                // Distance Ios
                $fitnessDistanceIosDataQuery = DB::table('user_fitness_distance')

                    ->where('user_id', $userId)
                    ->where('start_date', $dateFrom)
                    ->where('end_date', $dateTo)
                    ->where('device_id', $deviceId)
                    ->get();
                if ($fitnessDistanceIosDataQuery->count() > 0) {

                } else {
                    //insert
                    if ($fitnessDataInJsonArray[$i]->data_type == "DISTANCE_WALKING_RUNNING") {
                        $insertDataId = DB::table('user_fitness_distance')->insertGetId(

                            [
                                'user_id' => $userId,
                                'device_id' => $deviceId,
                                'start_date' => $dateFrom,
                                'end_date' => $dateTo,
                                'distance_covered' => $fitnessDataInJsonArray[$i]->value->numericValue,
                            ]

                        );

                    }

                }
                //Heart
                $fitnessHeartDataQuery = DB::table('user_fitness_heart')

                    ->where('user_id', $userId)
                    ->where('start_date', $dateFrom)
                    ->where('end_date', $dateTo)
                    ->where('device_id', $deviceId)
                    ->get();
                if ($fitnessHeartDataQuery->count() > 0) {

                } else {
                    //insert
                    if ($fitnessDataInJsonArray[$i]->data_type == "HEART_RATE") {
                        $insertDataId = DB::table('user_fitness_heart')->insertGetId(

                            [
                                'user_id' => $userId,
                                'device_id' => $deviceId,
                                'start_date' => $dateFrom,
                                'end_date' => $dateTo,
                                'heart_rate' => $fitnessDataInJsonArray[$i]->value->numericValue,
                            ]

                        );

                    }

                }
                //Steps
                $fitnessStepDataQuery = DB::table('user_fitness_step')

                    ->where('user_id', $userId)
                    ->where('start_date', $dateFrom)
                    ->where('end_date', $dateTo)
                    ->where('device_id', $deviceId)
                    ->get();
                if ($fitnessStepDataQuery->count() > 0) {

                } else {
                    //insert
                    if ($fitnessDataInJsonArray[$i]->data_type == "STEPS") {
                        $insertDataId = DB::table('user_fitness_step')->insertGetId(

                            [
                                'user_id' => $userId,
                                'device_id' => $deviceId,
                                'start_date' => $dateFrom,
                                'end_date' => $dateTo,
                                'step_covered' => $fitnessDataInJsonArray[$i]->value->numericValue,
                            ]

                        );

                    }

                }

            }

            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'Data synced']);

        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['result' => 'error', 'message' => 'Something went wrong']);
            // return response()->json(['result' => 'error', 'message' => $ex->getMessage()]);
        }

    }

    // get comp user wise
    public function getCompetitionUserWise($userId, $compMappingStatus)
    {
        try {

            $getQuery = DB::table('user_comp_mapping')
                ->join('competition_schedule', 'competition_schedule.comp_schedule_id', '=', 'user_comp_mapping.comp_schedule_id')
                ->join('competition_master', 'competition_master.comp_master_id', '=', 'competition_schedule.comp_master_id')
                ->join('competition_type', 'competition_type.comp_type_id', '=', 'competition_master.comp_type_id')

                ->join('competition_activity', 'competition_activity.comp_activity_id', '=', 'competition_master.comp_activity_id')
                ->join('competition_category', 'competition_category.comp_category_id', '=', 'competition_master.comp_category_id')
                ->join('comp_rule', 'comp_rule.rule_id', '=', 'competition_master.rule_id')
                ->join('privacy_rule', 'privacy_rule.privacy_id', '=', 'competition_master.privacy_id')
                ->where('user_comp_mapping.comp_mapping_status', '=', $compMappingStatus)
                ->where('user_comp_mapping.user_id', '=', $userId)

                ->select(['competition_master.comp_master_id',
                    'competition_master.comp_master_name',
                    'competition_master.comp_master_days',
                    'competition_master.comp_master_total_km',
                    'competition_master.comp_master_minimum_km_per_day',
                    'competition_master.comp_master_max_participant',
                    'competition_master.comp_master_min_participant',
                    'competition_master.comp_master_pot_value',
                    'competition_master.comp_master_per_partition_value',
                    'competition_master.comp_master_rest_day',
                    'competition_master.comp_master_rest_day_frequency',
                    'competition_master.daily_loyalty_point',
                    'competition_master.achievers_loyalty_point',
                    'competition_master.comp_master_image',

                    'competition_type.comp_type_id',
                    'competition_type.comp_type_name',

                    'competition_category.comp_category_id',
                    'competition_category.comp_category_name',
                    'competition_category.comp_category_image',

                    'competition_activity.comp_activity_id',
                    'competition_activity.comp_activity_name',
                    'competition_activity.comp_activity_image',

                    'comp_rule.rule_id',
                    'comp_rule.rule_details',

                    'privacy_rule.privacy_id',
                    'privacy_rule.privacy_details',
                    'competition_schedule.comp_schedule_id',
                    DB::raw('DATE_FORMAT(competition_schedule.comp_schedule_start_date, "%d-%m-%Y") as comp_schedule_start_date', "%d-%m-%Y"),
                    DB::raw('DATE_FORMAT(competition_schedule.comp_schedule_end_date, "%d-%m-%Y") as comp_schedule_end_date', "%d-%m-%Y"),

                ])

                ->paginate();

            return response()->json(['compData' => $getQuery, 'result' => 'success', 'message' => 'success']);

        } catch (Exception $ex) {
            return response()->json(['compData' => [], 'result' => 'error', 'message' => 'Something went wrong']);

        }
    }

    // get comp details user wise
    public function getUserCompDetails($compScheduleId, $userId)
    {
        try {

            $getQuery = DB::table('user_comp_details')

                ->where('user_comp_details.comp_schedule_id', '=', $compScheduleId)
                ->where('user_comp_details.user_id', '=', $userId)

                ->select(['user_comp_details.user_comp_details_id', 'user_comp_details.user_id', 'user_comp_details.comp_schedule_id',
                    'comp_loyalty_point', 'daily_loyalty_point', 'daily_achieved_loyalty_point', 'total_target', 'daily_target', 'daily_target_achieved',
                    'daily_target_remaining', 'calorie_burnt', 'steps_covered', 'user_comp_details_status',

                    DB::raw('DATE_FORMAT(user_comp_details.comp_details_date, "%d-%m-%Y") as comp_details_date', "%d-%m-%Y"),
                    DB::raw('DATE_FORMAT(user_comp_details.comp_details_date, "%d-%m-%Y") as comp_details_date', "%d-%m-%Y"),
                    DB::raw("(SELECT IFNULL(sum(user_comp_details.daily_target_remaining),0) FROM user_comp_details
                                  where user_comp_details.user_id=$userId and user_comp_details.comp_schedule_id=$compScheduleId
                       ) as totalTargetRemaining"),

                ])

                ->paginate();

            return response()->json(['userCompDetailsData' => $getQuery, 'result' => 'success', 'message' => 'success']);

        } catch (Exception $ex) {
            return response()->json(['userCompDetailsData' => [], 'result' => 'error', 'message' => 'Something went wrong']);

        }
    }
    //get subscription
    public function getSubscription($userId)
    {
        try {

            $getQuery = DB::table('subscription_master')
                ->join('subscription_benifit', 'subscription_benifit.subscription_master_id', 'subscription_master.subscription_master_id')
                ->select(['subscription_master.subscription_name', 'subscription_master.subscription_fee',
                    'subscription_benifit.subscription_benifit_id', 'subscription_benifit.subscription_benifit_description', 'subscription_benifit.subscription_master_id',
                    'subscription_benifit.subscription_benifit_value', 'subscription_benifit.subscription_benifit_unit',

                    DB::raw("ifnull((SELECT user_subscription_mapping.subscription_master_id  from
                    user_subscription_mapping join subscription_master on   user_subscription_mapping.subscription_master_id=
         subscription_master.subscription_master_id where  user_subscription_mapping.user_id=$userId and user_subscription_mapping.subscription_mapping_status=1
),0) as user_current_subscription_master_id"),
 DB::raw("ifnull(DATE_FORMAT((SELECT user_subscription_mapping.subscription_mapping_date  from
                    user_subscription_mapping join subscription_master on   user_subscription_mapping.subscription_master_id=
         subscription_master.subscription_master_id where  user_subscription_mapping.user_id=$userId and user_subscription_mapping.subscription_mapping_status=1
),'%d-%m-%Y'),0) as subscription_mapping_date"),
 DB::raw("ifnull(DATE_FORMAT((SELECT user_subscription_mapping.subscription_mapping_expiry_date  from
                    user_subscription_mapping join subscription_master on   user_subscription_mapping.subscription_master_id=
         subscription_master.subscription_master_id where  user_subscription_mapping.user_id=$userId and user_subscription_mapping.subscription_mapping_status=1
),'%d-%m-%Y'),0) as subscription_mapping_expiry_date"),

                ])
                ->where('subscription_benifit.subscription_benifit_status', 1)
                ->where('subscription_master.subscription_master_status', 1)
                ->get();
            return response()->json(['subscriptionData' => $getQuery, 'result' => 'success', 'message' => 'success']);

        } catch (Exception $ex) {
            return response()->json(['subscriptionData' => [], 'result' => 'error', 'message' => $ex->getMessage()]);

        }
    }
    public function subscribe($userId, $subscriptionMasterId, $walletId, $paymentAmount,
        $isPaymentGatewayWallet, $walletDescription
    ) {

        try {

            DB::beginTransaction();

            $getSubscriptionMasterQuery = DB::table('subscription_master')
                ->where('subscription_master_id', $subscriptionMasterId)
                ->get();
            $getSubscriptionMasterResult = $getSubscriptionMasterQuery->toArray();
            $expiryInDay = $getSubscriptionMasterResult[0]->subscription_expiry_in_days;
            $currentDateTime = date_format(now(), 'Y-m-d H:i:s');

            $insertSubscriptionMappingId = DB::table('user_subscription_mapping')->insertGetId(
                [

                    'subscription_master_id' => $subscriptionMasterId,
                    'user_id' => $userId,
                    'subscription_mapping_expiry_date' => DB::raw("DATE_ADD('$currentDateTime' ,INTERVAL $expiryInDay day)"),
                    'subscription_mapping_date' => $currentDateTime,
                ]
            );
            DB::table('user_subscription_mapping')
                ->where('subscription_master_id', '!=', $subscriptionMasterId)
                ->where('user_id', '=', $userId)
                ->update([
                    'subscription_mapping_status' => 0,

                ]);

            DB::table('users')
                ->where('user_id', '=', $userId)
                ->update([
                    'is_subscribed' => 1,

                ]);
                DB::table('users')
    ->where('user_id', '=', $userId)
    ->update([
        'subscription_master_id' => $subscriptionMasterId,

    ]);


            $getUserWalletBalanceQuery = DB::table('wallet')
                ->where('user_id', $userId)
                ->where('wallet_id', $walletId)
                ->get();
            $getUserWalletBalanceResult = $getUserWalletBalanceQuery->toArray();

            DB::table('wallet')
                ->where('user_id', $userId)
                ->where('wallet_id', $walletId)
                ->update(
                    [
                        'wallet_balance_amount_from_payment_gateway' => $isPaymentGatewayWallet == "1" ? $getUserWalletBalanceResult[0]->wallet_balance_amount_from_payment_gateway - $paymentAmount : $getUserWalletBalanceResult[0]->wallet_balance_amount_from_payment_gateway,
                        'wallet_balance_amount_from_competition' => $isPaymentGatewayWallet == "0" ? $getUserWalletBalanceResult[0]->wallet_balance_amount_from_competition - $paymentAmount : $getUserWalletBalanceResult[0]->wallet_balance_amount_from_competition,
                        'total_wallet_balance_amount' => $getUserWalletBalanceResult[0]->total_wallet_balance_amount - $paymentAmount,
                    ]);

            $transactionCodePrefix = "TR" . date("ym");
            $transactionCode = IdGenerator::generate(['table' => 'wallet_history', 'field' => 'transaction_id', 'length' => 18, 'prefix' => $transactionCodePrefix,
                'reset_on_prefix_change' => true]);

            $wallethistoryid = DB::table('wallet_history')->insertGetId(
                [
                    'wallet_id' => $walletId,
                    'user_id' => $userId,
                    'transaction_id' => $transactionCode,
                    'wallet_description' => $walletDescription,
                    'wallet_balance_added_deducted_amount' => $paymentAmount,
                    'is_wallet_balance_added' => 0,
                    'is_wallet_balance_from_payment_gateway' => $isPaymentGatewayWallet,
                    'payment_code' => null,
                    'comp_schedule_id' => null,

                ]
            );
            DB::table('user_subscription_mapping')

                ->where('user_id', '=', $userId)
                ->update([
                    'wallet_history_id' => $wallethistoryid,

                ]);

            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'You have subscribed to the selected plan']);

        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['result' => 'error', 'message' => 'Something went wrong']);

        }

    }

}
