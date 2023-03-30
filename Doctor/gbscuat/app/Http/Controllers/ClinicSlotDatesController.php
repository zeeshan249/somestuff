<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ClinicSlotDatesController extends Controller
{
    public function getAllSlotDates(Request  $request){
//        $status= $request->clinic_is_active;
//        if ($status != null) {
//            $status = $request->clinic_is_active;
//        } else {
//            $status = 1;
//        }

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;

        $getQuery = DB::table("dm_in_clinic_slot_dates")
            ->select(['dm_in_clinic_slot_dates.in_clinic_slot_dates_id','dm_in_clinic_slot_dates.in_clinic_slot_id','dm_in_clinic_slot_dates.is_booking_available',
                'dm_in_clinic_slot.clinic_id','dm_in_clinic_slot.doctor_id','dm_clinic.clinic_full_name',
                'dm_doctor.doctor_full_name','dm_in_clinic_slot_dates.in_clinic_slot_dates','dm_in_clinic_slot_dates.in_clinic_slot_dates_is_active',
                  'dm_in_clinic_slot_dates.in_clinic_max_slot_position_datewise as max_slot',

                DB::raw('DATE_FORMAT(dm_in_clinic_slot_dates.in_clinic_slot_start_time, "%h-%i %p") as start_time', "%d-%m-%Y"),
                DB::raw('DATE_FORMAT(dm_in_clinic_slot_dates.in_clinic_slot_end_time, "%h-%i %p") as end_time', "%d-%m-%Y")
            ])

            ->join('dm_in_clinic_slot','dm_in_clinic_slot.in_clinic_slot_id','dm_in_clinic_slot_dates.in_clinic_slot_id')
            ->join('dm_clinic','dm_clinic.clinic_id','dm_in_clinic_slot.clinic_id')
            ->join('dm_doctor','dm_doctor.doctor_id','dm_in_clinic_slot.doctor_id')



            ->where('dm_in_clinic_slot_dates.in_clinic_slot_start_time', 'like',  '%'.$filterBy.'%' )
            ->where('dm_in_clinic_slot_dates.in_clinic_slot_dates',$filterBy)


            ->orderBy($sortColumn,$sortOrder)
            ->paginate($itemsPerPage);



        return response()->json([ 'success' => 'true','resultData' => $getQuery], 200);
    }

    public function slotstatus(Request $request)
    {



        try
        {

            $id = $request->in_clinic_slot_dates_id;

            $updateQuery = DB::table('dm_in_clinic_slot_dates')
                ->where('in_clinic_slot_dates_id', $id)
                ->update([
                    'is_booking_available' => $request->is_booking_available,

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

    public function Status(Request  $request)
    {
        $id = $request->in_clinic_slot_dates_id;
        $status = $request->in_clinic_slot_dates_is_active;

        $st = DB::table('dm_in_clinic_slot_dates')
            ->where('in_clinic_slot_dates_id',  $id )
            ->update([
                'in_clinic_slot_dates_is_active' => $status,
            ]);
        if ($st) {

            return response()->json(['result'=>'success','message' => 'Slot Status Changed Successfully'], 200);
        }


    }

    public function  fetchslotno(Request  $request){
        $dates=DB::table('dm_in_clinic_slot')
            ->select('dm_in_clinic_slot.in_clinic_slot_id',
                DB::raw('DATE_FORMAT(dm_in_clinic_slot.in_clinic_slot_start_time, "%h-%i %p") as start_time', "%d-%m-%Y"),
                DB::raw('DATE_FORMAT(dm_in_clinic_slot.in_clinic_slot_end_time, "%h-%i %p") as end_time', "%d-%m-%Y")
            )
            ->where('dm_in_clinic_slot.clinic_id','=',$request->clinic_id)

            ->get();

        return response()->json(['result' => "success",'resultData'=>$dates]);
    }
    public function  saveSlotDate(Request $request)
    {
        $formatstarttime=  date("H:i:s", strtotime($request->in_clinic_slot_start_time));
        $formatendtime=  date("H:i:s", strtotime($request->in_clinic_slot_end_time));
        $duplicate=DB::table('dm_in_clinic_slot_dates')
            ->join('dm_in_clinic_slot','dm_in_clinic_slot.in_clinic_slot_id','dm_in_clinic_slot_dates.in_clinic_slot_id')
            ->where('dm_in_clinic_slot.doctor_id',$request->doctor_id)
            ->where('dm_in_clinic_slot.clinic_id',$request->clinic_id)
            ->where('dm_in_clinic_slot_dates.in_clinic_slot_dates',$request->in_clinic_slot_dates)->get();
          if($duplicate->count()>0){
              return response()->json(['message' => 'slot already added for this clinic','result'=>'success'], 200);
          }

        $queryslot=DB::table('dm_in_clinic_slot')->where('clinic_id',$request->clinic_id)
            ->where('doctor_id',$request->doctor_id)
            ->where('dm_in_clinic_slot.in_clinic_slot_start_time',date("H:i:s", strtotime($request->in_clinic_slot_start_time)))
            ->where('dm_in_clinic_slot.in_clinic_slot_end_time', date("H:i:s", strtotime($request->in_clinic_slot_end_time)))->count();
        if($queryslot==0) {


            $saveQueryslot = DB::table('dm_in_clinic_slot')->insertGetId(
                [
                    'slot_name_id'=>1,
                    'clinic_id'=>$request->clinic_id,
                    'doctor_id'=>$request->doctor_id,
                    'in_clinic_doctor_max_booking_days'=>1,
                    'in_clinic_doctor_booking_week_days'=>1,
                    'in_clinic_max_slot_position'=>$request->max_slot,
                    'in_clinic_slot_start_time'=> $formatstarttime,
                    'in_clinic_slot_end_time' => $formatendtime
                ]
            );


            $saveQuery = DB::table('dm_in_clinic_slot_dates')->insertGetId(
                [

                    'in_clinic_slot_id' => $saveQueryslot,
                    'in_clinic_slot_dates' => $request->in_clinic_slot_dates,
                    'in_clinic_slot_start_time' => Carbon::parse($request->in_clinic_slot_dates . $formatstarttime),
                    'in_clinic_slot_end_time' => Carbon::parse($request->in_clinic_slot_dates . $formatendtime),
                    'in_clinic_max_slot_position_datewise' => $request->max_slot,


                ]
            );

            if ($saveQuery > 0) {
                return response()->json(['message' => 'In Clinic Slot saved successfully','result'=>'success'], 200);
            }
        }
        else if($queryslot>0){
            $getqueryslot=DB::table('dm_in_clinic_slot')->select('dm_in_clinic_slot.in_clinic_slot_id')
                ->where('clinic_id',$request->clinic_id)
                ->where('doctor_id',$request->doctor_id)
                ->where('dm_in_clinic_slot.in_clinic_slot_start_time',date("H:i:s", strtotime($request->in_clinic_slot_start_time)))
                ->where('dm_in_clinic_slot.in_clinic_slot_end_time',date("H:i:s", strtotime($request->in_clinic_slot_end_time)))
                ->first();

            $saveQuery1 = DB::table('dm_in_clinic_slot_dates')->insertGetId(
                [

                    'in_clinic_slot_id' => $getqueryslot->in_clinic_slot_id,
                    'in_clinic_slot_dates' => $request->in_clinic_slot_dates,
                    'in_clinic_slot_start_time' => Carbon::parse($request->in_clinic_slot_dates . $formatstarttime),
                    'in_clinic_slot_end_time' => Carbon::parse($request->in_clinic_slot_dates . $formatendtime),
                    'in_clinic_max_slot_position_datewise' => $request->max_slot,


                ]
            );
            if ($saveQuery1 > 0) {
                return response()->json(['message' => 'In Clinic Slot saved successfully','result'=>'success'], 200);
            }

        }
    }

    public function deleteSlotDate(Request $request){
        $delete=DB::table('dm_in_clinic_slot_dates')
            ->where('dm_in_clinic_slot_dates.in_clinic_slot_dates_id',$request->in_clinic_slot_dates_id)->delete();
        if ($delete) {
            return response()->json(['message' => 'Slot Date Deleted','result'=>'success'], 200);
        }

    }

    public function  webUpdateSlotDate(Request $request)
    {
        $formatstarttime = date("H:i:s", strtotime($request->in_clinic_slot_start_time));
        $formatendtime = date("H:i:s", strtotime($request->in_clinic_slot_end_time));
        try {

            DB::beginTransaction();
            DB::table('dm_in_clinic_slot')->where('dm_in_clinic_slot.in_clinic_slot_id', $request->in_clinic_slot_id)->update([
                'clinic_id' => $request->clinic_id,
                'doctor_id' => $request->doctor_id,
                'in_clinic_max_slot_position' => $request->max_slot,
                'in_clinic_slot_start_time' => $formatstarttime,
                'in_clinic_slot_end_time' => $formatendtime,
            ]);


            DB::table('dm_in_clinic_slot_dates')
                ->where('dm_in_clinic_slot_dates.in_clinic_slot_dates_id',$request->in_clinic_slot_dates_id)

                ->update([
                'in_clinic_slot_id' => $request->in_clinic_slot_id,
                'in_clinic_slot_dates' => $request->in_clinic_slot_dates,
                'in_clinic_slot_start_time' => Carbon::parse($request->in_clinic_slot_dates . $formatstarttime),
                'in_clinic_slot_end_time' => Carbon::parse($request->in_clinic_slot_dates . $formatendtime),
                'in_clinic_max_slot_position_datewise' => $request->max_slot,
            ]);

            DB::commit();
            return response()->json(['message' => 'In Clinic Slot Updated successfully', 'result' => 'success'], 200);

        }
        catch(\Exception $ex){
            DB::rollBack();
        }
    }
}
