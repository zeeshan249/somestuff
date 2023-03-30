<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VideoBookingController extends Controller
{
    public function Get(Request $request)
    {

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $doctor_id=$request->doctor_id;

        $filterBy = $request->searchText;
        $status= $request->video_booking_is_active;
        if ($status != null) {
            $status = $request->video_booking_is_active;
        } else {
            $status = 1;
        }
        $getQuery = DB::table("dm_video_booking")

            ->join('dm_doctor','dm_video_booking.doctor_id','dm_doctor.doctor_id')
            ->join('dm_family_member','dm_family_member.family_member_id','dm_video_booking.video_booking_made_for_family_id')
            ->join('roles','roles.id','dm_video_booking.video_booking_made_by_role_id')

            ->select('dm_video_booking.video_booking_id','dm_video_booking.video_slot_dates_id','dm_doctor.doctor_full_name'
                ,'dm_family_member.family_member_mobile_number'
                ,DB::raw('DATE_FORMAT(dm_video_booking.video_booking_date, "%d-%m-%Y") as video_booking_date'),'dm_family_member.family_member_full_name',
                'roles.name as booking_made_by',

                \DB::raw('(CASE

                        WHEN dm_video_booking.video_booking_is_active = "1" THEN "Active"

                        WHEN dm_video_booking.video_booking_is_active = "3" THEN "Completed"

                      WHEN dm_video_booking.video_booking_is_active = "2" THEN "Cancel"

                     WHEN dm_video_booking.video_booking_is_active = "4" THEN "Absent"
                        END) AS status'),
//
            )



            ->where('dm_video_booking.video_booking_date','>=',$request->video_booking_from_date)
            ->where('dm_video_booking.video_booking_date','<=',$request->video_booking_to_date)

            ->where(function ($q) use ($filterBy) {
                $q
                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")
                    ->orWhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%");
            })

            ->where(function ($query) use ($doctor_id) {
                if($doctor_id != null)
                {
                    $query ->where('dm_video_booking.doctor_id', $doctor_id);

                }
            })


            ->where('dm_video_booking.video_booking_is_active',$status)
            ->orderBy($sortColumn, $sortOrder)

            ->paginate($itemsPerPage);



        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }
//    public function getCurrentVideoVisitBookingListForDoctor(Request $request){
//
//        $pageNumber = $request->pageNumber;
//        $itemToLoad = $request->itemToLoad;
//        if ($pageNumber == 1) {
//            $pageNumber = 0;
//        } else {
//            $pageNumber = $itemToLoad * $pageNumber;
//            $pageNumber = $pageNumber - $itemToLoad;
//        }
//
//        $getQuery = DB::table("dm_video_booking")
//
//            ->join('dm_doctor','dm_video_booking.doctor_id','dm_doctor.doctor_id')
//            ->join('dm_user','dm_user.user_id','dm_video_booking.video_booking_made_by_user_id')
//            ->join('dm_family_member','dm_family_member.family_member_id','dm_video_booking.video_booking_made_for_family_id')
//            ->join('roles','roles.id','dm_video_booking.video_booking_made_by_role_id')
//            ->where('dm_video_booking.video_booking_date','=','2022-08-13')
//            ->where('dm_video_booking.video_booking_is_active',1)
//            ->select('dm_video_booking.video_booking_id','dm_video_booking.video_slot_dates_id','dm_doctor.doctor_full_name',
//                'dm_doctor.doctor_first_name','dm_doctor.doctor_last_name','dm_doctor.doctor_profile_image'
//                ,'dm_family_member.family_member_mobile_number','dm_family_member.family_member_full_name',
//                'dm_family_member.family_member_first_name',  'dm_family_member.family_member_last_name',
//                'dm_user.device_token as patient_token',   'dm_doctor.doctor_device_token'
//                ,'dm_family_member.family_member_profile_image'
//                ,DB::raw("(SELECT count(*) FROM dm_video_booking
//                 where
//                 dm_video_booking.video_booking_is_active=1
//                 and dm_video_booking.video_booking_date= '2022-08-13'
//
//        ) as totalVideoBooking")
//
//                ,DB::raw('DATE_FORMAT(dm_video_booking.video_booking_date, "%d-%m-%Y") as video_booking_date'),'dm_family_member.family_member_full_name',
//                'roles.name as booking_made_by')
//
//
//
//
//
//            ->limit($itemToLoad)
//            ->offset($pageNumber)
//            ->orderBy(DB::raw("DATE_FORMAT(dm_video_booking.video_booking_date,'%d-%m-%Y')"), 'desc')
//            ->get();
//
//
//        $data_response = array();
//        if (count($getQuery) <= 0) {
//            array_push($data_response, array('data_status' => 'end'));
//
//            echo json_encode($data_response);
//        } else {
//            array_push($data_response, array('data_status' => 'ok'));
//            array_push($data_response, array('data' => $getQuery));
//
//            echo json_encode($data_response);
//        }
//
//
//
//
//    }


    public function getCompletedVideoVisitForDoctor(Request  $request)
    {

        $pageNumber = $request->pageNumber;
        $itemToLoad = $request->itemToLoad;

        if ($pageNumber == 1) {
            $pageNumber = 0;
        } else {
            $pageNumber = $itemToLoad * $pageNumber;
            $pageNumber = $pageNumber - $itemToLoad;
        }

        $getQuery = DB::table("dm_video_booking")

            ->join('dm_doctor', 'dm_video_booking.doctor_id', 'dm_doctor.doctor_id')
            ->join('dm_user', 'dm_user.user_id', 'dm_video_booking.video_booking_made_by_user_id')
            ->join('dm_family_member', 'dm_family_member.family_member_id', 'dm_video_booking.video_booking_made_for_family_id')
            ->join('roles', 'roles.id', 'dm_video_booking.video_booking_made_by_role_id')
//            ->whereBetween('video_booking_date',["'$startDate'","'$endDate'"])
            ->where('dm_video_booking.video_booking_date','>=',$request->start_date)
            ->where('dm_video_booking.video_booking_date','<=',$request->end_date)
            ->where('dm_video_booking.video_booking_is_active',3)
            ->where('dm_video_booking.doctor_id', 95)
            ->select('dm_video_booking.video_booking_id',
                'dm_video_booking.video_slot_dates_id',
                'dm_doctor.doctor_full_name',
                'dm_doctor.doctor_first_name',
                'dm_doctor.doctor_last_name',
                'dm_doctor.doctor_profile_image',
                'dm_family_member.family_member_mobile_number',
                'dm_family_member.family_member_full_name',
                'dm_family_member.family_member_first_name',
                'dm_family_member.family_member_last_name',
                'dm_user.device_token as patient_device_token',
                'dm_doctor.doctor_device_token',
                'dm_family_member.family_member_profile_image',
                DB::raw('DATE_FORMAT(dm_video_booking.video_booking_date, "%d-%m-%Y") as video_booking_date'),
                DB::raw('DATE_FORMAT(now(), "%d-%m-%Y") as server_current_date'),


            )
            ->limit($itemToLoad)
            ->offset($pageNumber)
            ->orderBy('dm_family_member.family_member_first_name', 'asc')
            ->get();

        $data_response = array();
        if (count($getQuery) <= 0) {
            array_push($data_response, array('data_status' => 'end'));
            echo json_encode($data_response);
        } else {
            array_push($data_response, array('data_status' => 'ok'));
            array_push($data_response, array('data' => $getQuery));
            echo json_encode($data_response);
        }

    }

    public function upcomingVideoBookingDetails(Request $request){


        $doctor_id=$request->doctor_id;

        $status= $request->video_booking_is_active;
        if ($status != null) {
            $status = $request->video_booking_is_active;
        } else {
            $status = 1;
        }
        $getQuery=   DB::table("dm_video_booking")

            ->join('dm_doctor','dm_doctor.doctor_id','dm_video_booking.doctor_id')
            ->join('roles','roles.id','dm_video_booking.video_booking_made_by_role_id')
            ->join('dm_video_slot_dates','dm_video_slot_dates.video_slot_dates_id','dm_video_booking.video_slot_dates_id')


            ->select(DB::raw('DATE_FORMAT(dm_video_booking.video_booking_date, "%d-%m-%Y") as video_booking_date'),'roles.name as booked_by','dm_doctor.doctor_full_name'
                , DB::raw("(SELECT count(*) FROM dm_video_booking
         where
         dm_video_booking.doctor_id =dm_doctor.doctor_id and
         dm_video_booking.video_booking_is_active=1
          and dm_video_booking.video_booking_date= '$request->video_booking_date'


        ) as totalVideoBooking",

                )
            )




     ->where('dm_video_booking.video_booking_date','=',$request->video_booking_date)

     ->where(function ($query) use ($doctor_id) {
         if($doctor_id != null)
         {
             $query
                 ->where('dm_video_booking.doctor_id',$doctor_id);
         }
     })
     ->where('dm_video_booking.video_booking_is_active',$status)
     ->orderBy('dm_video_booking.video_booking_date', 'ASC')
            ->groupBy('dm_video_booking.doctor_id')
     ->get();

        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }


  public function  getVideoSlotDates(Request  $request){
      $itemsPerPage = $request->itemsPerPage;
      $sortColumn =$request->sortColumn;
      $sortOrder = $request->sortOrder;
      $filterBy = $request->searchText;
      $doctor_id=$request->doctor_id;
      $getQuery = DB::table("dm_video_slot_dates")
          ->select('dm_video_slot_dates.video_slot_dates_id','dm_video_slot_dates.video_slot_id','dm_video_slot_dates.video_slot_dates','dm_video_slot_dates.video_slot_dates_is_active',
                   'dm_video_slot_dates.video_booking_available','dm_doctor.doctor_full_name','dm_doctor.doctor_id',


              DB::raw('DATE_FORMAT(dm_video_slot_dates.video_slot_start_time, "%h-%i %p") as start_time', "%d-%m-%Y"),
              DB::raw('DATE_FORMAT(dm_video_slot_dates.video_slot_end_time, "%h-%i %p") as end_time', "%d-%m-%Y")
          )

          ->join('dm_video_slot','dm_video_slot.video_slot_id','dm_video_slot_dates.video_slot_id')
          ->join('dm_doctor','dm_doctor.doctor_id','dm_video_slot_dates.doctor_id')

//          ->where(function ($q) use ($doctor_id) {
//              $q->where('dm_video_slot_dates.doctor_id', $doctor_id);
//
//          })

         ->where('dm_video_slot_dates.video_slot_dates','>=',$filterBy)


          ->orderBy($sortColumn,$sortOrder)
          ->paginate($itemsPerPage);



      return response()->json([ 'success' => 'true','resultData' => $getQuery], 200);
  }











    public function  saveVideoSlotDate(Request $request)
    {


        $queryslot=DB::table('dm_video_slot')->where('doctor_id',$request->doctor_id)->get();
         $dm_doctor_video=DB::table('dm_doctor_video')->where('doctor_id',$request->doctor_id)->get();



        if($queryslot->count()==0 && $dm_doctor_video->count()==0) {
                $dm_doctor_video=DB::table('dm_doctor_video')->insertGetId([
                   'doctor_id'=>$request->doctor_id,
                    'video_consultation_fee_is_visible'=>0,
                    'video_consultation_is_avialable'=>1,
                    'video_consultation_fee'=>400,
                    'video_consultation_service_fee'=>25,
                    'video_cancellation_days'=>1,
                    'video_book_before_days'=>0
                ]);

            $savevideoslot = DB::table('dm_video_slot')->insertGetId(
                [


                    'doctor_id'=>$request->doctor_id,
                    'slot_name_id'=>1,
                    'video_doctor_max_booking_days'=>100,
                    'video_clinic_doctor_booking_week_days'=>"1,2,3",
                    'video_doctor_is_available_date_wise'=>1,
                    'video_slot_max_position'=>10,
                    'video_slot_time_interval'=>15,

                ]
            );


            $savedate = DB::table('dm_video_slot_dates')->insertGetId(
                [

                    'video_slot_id' => $savevideoslot,
                    'doctor_id' => $request->doctor_id,
                    'video_slot_dates' => $request->video_slot_dates,
                    'video_slot_start_time' => Carbon::parse($request->video_slot_dates . "10:00:00"),
                    'video_slot_end_time' => Carbon::parse($request->video_slot_dates . "10:00:05"),

                    'video_max_slot_position_datewise' => 100,


                ]
            );

            for($i=0;$i<=6;$i++){
                $datewise=DB::table('dm_video_slot_time_date_wise')->insertGetId([
                    'video_slot_dates_id'=>$savedate,
                    'doctor_id'=>$request->doctor_id,
                    'video_slot_start_time'=>Carbon::parse($request->video_slot_dates . "10:00:00"),
                    'video_slot_end_time'=>Carbon::parse($request->video_slot_dates . "10:00:05")
                ]);
            }


                return response()->json(['message' => 'Video Slot saved successfully','result'=>'success'], 200);

        }
        else if($queryslot->count()>0){

            $getqueryslot=DB::table('dm_video_slot')->select('dm_video_slot.video_slot_id')

                ->where('doctor_id',$request->doctor_id)

                ->first();

            $savedate1 = DB::table('dm_video_slot_dates')->insertGetId(
                [

                    'video_slot_id' => $getqueryslot->video_slot_id,
                    'doctor_id' => $request->doctor_id,
                    'video_slot_dates' => $request->video_slot_dates,
                    'video_slot_start_time' => Carbon::parse($request->video_slot_dates . "10:00:00"),
                    'video_slot_end_time' => Carbon::parse($request->video_slot_dates . "10:00:05"),



                ]
            );

            for($i=0;$i<=6;$i++){
                $datewise=DB::table('dm_video_slot_time_date_wise')->insertGetId([
                    'video_slot_dates_id'=>$savedate1,
                    'doctor_id'=>$request->doctor_id,
                    'video_slot_start_time'=>Carbon::parse($request->video_slot_dates . "10:00:00"),
                    'video_slot_end_time'=>Carbon::parse($request->video_slot_dates . "10:00:05")
                ]);
            }

                return response()->json(['message' => 'Video Slotty saved successfully','result'=>'success'], 200);


        }


    }

    public function  updateVideoSlotDate(Request $request)
    {
          $video_slot=DB::table('dm_video_slot')->where('doctor_id',$request->doctor_id)->first();

            $savedate1 = DB::table('dm_video_slot_dates')->where('video_slot_dates_id',$request->video_slot_dates_id)->update([
                    'doctor_id'=>$request->doctor_id,
                    'video_slot_id'=> $video_slot->video_slot_id,
                    'video_slot_dates' => $request->video_slot_dates,
                    'video_slot_start_time' => Carbon::parse($request->video_slot_dates . "10:00:00"),
                    'video_slot_end_time' => Carbon::parse($request->video_slot_dates . "10:00:05"),

                    'video_max_slot_position_datewise' => 100,


                ]
            );


                $datewise=DB::table('dm_video_slot_time_date_wise')->where('video_slot_dates_id',$request->video_slot_dates_id)->update([
                    'doctor_id'=>$request->doctor_id,

                    'video_slot_start_time'=>Carbon::parse($request->video_slot_dates . "10:00:00"),
                    'video_slot_end_time'=>Carbon::parse($request->video_slot_dates . "10:00:05")
                ]);

            return response()->json(['message' => 'Video Slot updated successfully','result'=>'success'], 200);

    }

    public function webChangeVideoBookingAvailable(Request  $request)
    {

        try
        {

            $id = $request->video_slot_dates_id;

            $updateQuery = DB::table('dm_video_slot_dates')
                ->where('video_slot_dates_id', $id)
                ->update([
                    'video_booking_available' => $request->video_booking_available,

                ]);
            if ($updateQuery > 0) {

                return response()->json(['result' => "success", 'message' => 'Slot updated successfully']);

            } else {
                return response()->json(['result' => "error", 'message' => 'Something went wrong']);

            }

        } catch (Exception $ex) {

            return response()->json(['result' => "exception", 'message' => 'Something went wrong']);
        }
    }

    public function webChangeVideoSlotDatesActive(Request  $request)
    {
        $id = $request->video_slot_dates_id;
        $status = $request->video_slot_dates_is_active;

        $st = DB::table('dm_video_slot_dates')
            ->where('video_slot_dates_id',  $id )
            ->update([
                'video_slot_dates_is_active' => $status,
            ]);
        if ($st) {

            return response()->json(['result'=>'success','message' => 'Slot Status Changed Successfully'], 200);
        }

    }










}
