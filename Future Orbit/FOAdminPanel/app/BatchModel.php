<?php

namespace App;

use DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class BatchModel extends Model
{

    public function getWeekDays($day){
if($day==1)
return "Sunday";
else if ($day == 2)
    return "Monday";
    else if ($day == 3)
    return "Tuesday";
    else if ($day == 4)
    return "Wednesday";
    else if ($day == 5)
    return "Thursday";
    else if ($day == 6)
    return "Friday";
    else return "Saturday";
}


    // Check Subject Code in DB and then Save
    public function saveUpdateBatch($centerId,
        $loggedUserId,
        $lms_batch_id,
        $lms_batch_code,
        $isSaveEditClicked,
        $lms_batch_name,
        $lms_batch_start_date, $lms_batch_end_date,
        $lms_course_id, $slotDetails, $lms_child_course_id

    ) {
        $slotDetailsData = json_decode($slotDetails);
        // dd($slotDetailsData);

        if ($isSaveEditClicked == 1) {

            // If save course is clicked
            $getQuery = DB::table("lms_batch_details")->
                where('lms_center_id', $centerId)->
                where('lms_batch_name', $lms_batch_name)
                ->get();
            if ($getQuery->count() > 0) {
                // Course Code Exists

                $result_data['responseData'] = "1";

            } else {
                $getCenterCodeQuery = DB::table('lms_center_details')
                    ->select(['lms_center_code'])
                    ->where('lms_center_id', $centerId)
                    ->get();

                $getBatchCodePrefixQuery = DB::table('lms_prefix_setting')
                    ->select(['lms_prefix'])
                    ->where('lms_center_id', $centerId)
                    ->where('lms_prefix_module_name', "Batch Code")
                    ->get();
                $batchCodePrefix = $getBatchCodePrefixQuery[0]->lms_prefix . $getCenterCodeQuery[0]->lms_center_code . date('y');
                $batchCode = IdGenerator::generate([
                    'table' => 'lms_batch_details', 'length' => 10, 'prefix' => $batchCodePrefix,
                    'reset_on_prefix_change' => true, 'field' => 'lms_batch_code',
                ]);

                $saveQuery = DB::table('lms_batch_details')->insertGetId(
                    [
                        'lms_center_id' => $centerId,
                        'lms_course_id' => $lms_course_id,
                        'lms_batch_code' => $batchCode,
                        'lms_batch_name' => $lms_batch_name,
                        'lms_batch_start_date' => $lms_batch_start_date,
                        'lms_batch_end_date' => $lms_batch_end_date,
                        'lms_batch_create_by' => $loggedUserId,
                        'lms_child_course_id' => $lms_child_course_id,

                    ]
                );
                if ($saveQuery > 0) {
                    $saveSlotQuery = 0;
                    try
                    {
                        DB::beginTransaction();
                        for ($x = 0; $x < count($slotDetailsData); $x++) {

                            $saveSlotQuery = DB::table('lms_batch_slot')->insertGetId(
                                [
                                    'lms_batch_id' => $saveQuery,
                                    'lms_center_id' => $centerId,
                                    'lms_batch_slot_start_time' => $slotDetailsData[$x]->lms_batch_slot_start_time,
                                    'lms_batch_slot_end_time' => $slotDetailsData[$x]->lms_batch_slot_end_time,
                                    'lms_batch_slot_day' => $slotDetailsData[$x]->lms_batch_slot_day,
                                    'lms_batch_slot_day_text' => $this->getWeekDays($slotDetailsData[$x]->lms_batch_slot_day) ,
                                    'lms_user_id' => $slotDetailsData[$x]->lms_user_id,
                                    'lms_subject_id' => $slotDetailsData[$x]->lms_subject_id,
                                    'lms_batch_slot_created_by' => $loggedUserId,

                                ]
                            );

                        }

                        DB::commit();
                        if ($saveSlotQuery > 0) {
                            $result_data['responseData'] = "2";

                        }

                    } catch (Exception $ex) {

                        DB::rollback();

                        $result_data['responseData'] = "3";

                    }

                    // batch Saved

                } else {
                    // Failed to save batch
                    $result_data['responseData'] = "3";
                }
            }

        } else {

            $getQuery = DB::table("lms_batch_details")->
                where('lms_center_id', $centerId)->
                where('lms_batch_name', $lms_batch_name)->
                where('lms_batch_id', '!=', $lms_batch_id)
                ->get();
            if ($getQuery->count() > 0) {
                // Course Code Exists
                $result_data['responseData'] = "1";

            } else {
                $updateQuery = DB::table('lms_batch_details')
                    ->where('lms_batch_id', $lms_batch_id)
                    ->where('lms_center_id', $centerId)
                    ->update([
                        'lms_center_id' => $centerId,
                        'lms_course_id' => $lms_course_id,
                        'lms_batch_name' => $lms_batch_name,
                        'lms_batch_start_date' => $lms_batch_start_date,
                        'lms_batch_end_date' => $lms_batch_end_date,
                        'lms_batch_updated_by' => $loggedUserId,
                        'lms_batch_updated_date' => now(),
                        'lms_child_course_id' => $lms_child_course_id,

                    ]);
                if ($updateQuery > 0) {

                    $updateSlotQuery = 0;
                    try
                    {
                        DB::beginTransaction();
                        for ($x = 0; $x < count($slotDetailsData); $x++) {

                            if ($slotDetailsData[$x]->lms_batch_slot_id != null) {
                                $updateSlotQuery = DB::table('lms_batch_slot')
                                    ->where('lms_batch_slot_id', $slotDetailsData[$x]->lms_batch_slot_id)
                                    ->where('lms_center_id', $centerId)
                                    ->update([

                                        'lms_batch_id' => $lms_batch_id,
                                        'lms_center_id' => $centerId,
                                        'lms_batch_slot_start_time' => $slotDetailsData[$x]->lms_batch_slot_start_time,
                                        'lms_batch_slot_end_time' => $slotDetailsData[$x]->lms_batch_slot_end_time,
                                        'lms_batch_slot_day' => $slotDetailsData[$x]->lms_batch_slot_day,
                                        'lms_batch_slot_day_text' => $this->getWeekDays($slotDetailsData[$x]->lms_batch_slot_day) ,
                                        'lms_user_id' => $slotDetailsData[$x]->lms_user_id,
                                        'lms_subject_id' => $slotDetailsData[$x]->lms_subject_id,
                                    ]
                                    );

                            } else {
                                $updateSlotQuery = DB::table('lms_batch_slot')->insertGetId(
                                    [
                                        'lms_batch_id' => $lms_batch_id,
                                        'lms_center_id' => $centerId,
                                        'lms_batch_slot_start_time' => $slotDetailsData[$x]->lms_batch_slot_start_time,
                                        'lms_batch_slot_end_time' => $slotDetailsData[$x]->lms_batch_slot_end_time,
                                        'lms_batch_slot_day' => $slotDetailsData[$x]->lms_batch_slot_day,
                                        'lms_user_id' => $slotDetailsData[$x]->lms_user_id,
                                        'lms_subject_id' => $slotDetailsData[$x]->lms_subject_id,
                                        'lms_batch_slot_created_by' => $loggedUserId,

                                    ]
                                );

                            }

                        }

                        DB::commit();
                        if ($updateSlotQuery > 0) {
                            $result_data['responseData'] = "4";

                        }

                    } catch (Exception $ex) {

                        DB::rollback();

                        $result_data['responseData'] = "3";

                    }

                }
            }

        }
        return $result_data;

    }

    //  Disable slot
    public static function disableSlot($centerId,
        $lms_batch_slot_id,
        $lms_batch_slot_is_active) {
        $updateQuery = DB::table('lms_batch_slot')
            ->where('lms_batch_slot_id', $lms_batch_slot_id)
            ->where('lms_center_id', $centerId)
            ->update([

                'lms_batch_slot_is_active' => $lms_batch_slot_is_active,
            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";

        } else {
            $result_data['responseData'] = "2";

        }
        return $result_data;

    }
    //  Disable slot
    public static function studentAssignBatch($centerId,
        $lms_batch_id, $lms_registration_id, $lms_batch_mapping_by
    ) {
        $updateQuery = DB::table('lms_student_course_mapping')
            ->where('lms_registration_id', $lms_registration_id)
            ->where('lms_center_id', $centerId)
            ->update([

                'lms_batch_id' => $lms_batch_id,
                'lms_batch_mapping_by' => $lms_batch_mapping_by,
                'lms_batch_mapping_date' => now(),
            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";

        } else {
            $result_data['responseData'] = "2";

        }
        return $result_data;

    }
    // Enable Disable batch
    public static function enableDisableBatch($centerId,
        $lms_batch_id,
        $lms_batch_is_active) {
        $updateQuery = DB::table('lms_batch_details')
            ->where('lms_batch_id', $lms_batch_id)
            ->where('lms_center_id', $centerId)
            ->update([

                'lms_batch_is_active' => $lms_batch_is_active,
                'lms_batch_updated_date' => now(),
            ]);
        if ($updateQuery > 0) {
            $result_data['responseData'] = "1";

        } else {
            $result_data['responseData'] = "2";

        }
        return $result_data;

    }
}
