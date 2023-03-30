<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingReportController extends Controller
{
    public function  webGetRegisteredPatient(Request $request)
    {
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;
        $doctor_id=$request->doctor_id;

        $getQuery = DB::table("dm_family_member")->select('dm_family_member.family_member_id','dm_family_member.family_member_full_name','dm_family_member.family_member_mobile_number'
            ,'dm_user.user_id'
            )
            ->join('dm_user','dm_user.user_id','dm_family_member.user_id')

            ->join('roles','roles.id','dm_user.role_id')
//            ->where('dm_family_member.is_self',1)
            ->where(function ($q) use ($filterBy) {
                $q
                ->where('dm_family_member.family_member_mobile_number', 'like', "%$filterBy%")
                ->orwhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%");


            })
            ->where('roles.name','Patient')
             ->orderBy('dm_family_member.family_member_created_at','DESC')
            ->paginate(15);
        return response()->json(['result'=>'success','resultData'=>$getQuery], 200);
    }

    public function  getInClinicBookingForPatient(Request $request){
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;
        $doctor_id=$request->doctor_id;

        $getQuery = DB::table("dm_in_clinic_booking")->select('dm_in_clinic_booking.in_clinic_booking_date','dm_in_clinic_booking.in_clinic_booking_made_for_family_id',
        'dm_in_clinic_booking.in_clinic_booking_code','dm_family_member.family_member_full_name','dm_doctor.doctor_full_name','dm_clinic.clinic_full_name')
            ->join('dm_family_member','dm_family_member.family_member_id','dm_in_clinic_booking.in_clinic_booking_made_for_family_id')
            ->join('dm_doctor','dm_doctor.doctor_id','dm_in_clinic_booking.doctor_id')
            ->join('dm_clinic','dm_clinic.clinic_id','dm_in_clinic_booking.clinic_id')
//            ->join('dm_in_clinic_booking','dm_in_clinic_booking.in_clinic_booking_made_for_family_id','dm_family_member.family_member_id')
         //   ->join('dm_video_booking','dm_video_booking.video_booking_made_for_family_id','dm_family_member.family_member_id')



            ->where('dm_in_clinic_booking.in_clinic_booking_made_for_family_id',$request->family_member_id)
//            ->where('dm_family_member.user_id',$request->user_id)

            ->paginate(15);
        return response()->json(['result'=>'success','resultData'=>$getQuery], 200);
    }

    public function  webGetPatientWiseBookingDetails(Request  $request)
    {
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;
        $status= $request->in_clinic_booking_is_active;
        if ($status != null) {
            $status = $request->in_clinic_booking_is_active;
        } else {
            $status = 1;
        }
        $getQuery = DB::table("dm_in_clinic_booking")

            ->join('dm_doctor','dm_in_clinic_booking.doctor_id','dm_doctor.doctor_id')
            ->join('dm_clinic','dm_clinic.clinic_id','dm_in_clinic_booking.clinic_id')
            ->join('dm_specialization','dm_specialization.doctor_id','dm_in_clinic_booking.doctor_id')
            ->join('dm_family_member','dm_family_member.family_member_id','dm_in_clinic_booking.in_clinic_booking_made_for_family_id')
            ->select('dm_in_clinic_booking.in_clinic_booking_id','dm_in_clinic_booking.in_clinic_booking_slot_position','dm_doctor.doctor_full_name','dm_clinic.clinic_full_name','dm_in_clinic_booking.disease_name'
                ,'dm_specialization.specialization_name','dm_in_clinic_booking.in_clinic_booking_current_slot_position',DB::raw('DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date, "%d-%m-%Y") as in_clinic_booking_date'),
                'dm_family_member.family_member_full_name','dm_family_member.family_member_mobile_number',

                \DB::raw('(CASE

                        WHEN dm_in_clinic_booking.in_clinic_booking_is_active = "1" THEN "Active"

                        WHEN dm_in_clinic_booking.in_clinic_booking_is_active = "3" THEN "Completed"

                      WHEN dm_in_clinic_booking.in_clinic_booking_is_active = "2" THEN "Cancel"

                     WHEN dm_in_clinic_booking.in_clinic_booking_is_active = "4" THEN "Absent"
                        END) AS status'),

            )


            ->where('dm_in_clinic_booking.in_clinic_booking_date','>=',$request->in_clinic_booking_from_date)
            ->where('dm_in_clinic_booking.in_clinic_booking_date','<=',$request->in_clinic_booking_to_date)

            ->where(function ($q) use ($filterBy) {
                $q->where('dm_clinic.clinic_full_name', 'like', "%$filterBy%")
                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")
                    ->orWhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%")
                    ->orWhere('dm_family_member.family_member_mobile_number', 'like', "%$filterBy%");
            })
//            ->where(function ($query) use ($doctor_id, $clinic_id) {
//                if($clinic_id != null)
//                {
//                    $query ->where('dm_in_clinic_booking.doctor_id', $doctor_id)
//                        ->where('dm_in_clinic_booking.clinic_id',$clinic_id);
//                }
//            })


            ->where('dm_in_clinic_booking.in_clinic_booking_is_active',$status)
            ->orderBy('dm_in_clinic_booking.in_clinic_booking_date', 'ASC')

            ->paginate($itemsPerPage);



        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }

    public function webGetVideoVisitClinicWise(Request  $request){
        $filterBy = $request->searchText;
        $doctor_id=$request->doctor_id;
        $clinic_id=$request->clinic_id;
        $status= $request->video_booking_is_active;
//        if ($status != null) {
//            $status = $request->video_booking_is_active;
//        } else {
//            $status = 1;
//        }
        $getQuery = DB::table("dm_video_booking")
            ->join('dm_doctor','dm_doctor.doctor_id','dm_video_booking.doctor_id')
            ->join('dm_family_member','dm_family_member.family_member_id','dm_video_booking.video_booking_made_for_family_id')

            ->join('dm_clinic','dm_clinic.user_id','dm_video_booking.video_booking_made_by_user_id')
            ->join('roles','roles.id','dm_video_booking.video_booking_made_by_role_id')
            ->select('dm_clinic.clinic_id','dm_video_booking.video_booking_date','dm_doctor.doctor_full_name','dm_video_booking.video_booking_code'
            ,'dm_family_member.family_member_full_name','dm_clinic.clinic_full_name','dm_family_member.family_member_mobile_number',
                \DB::raw('(CASE

                        WHEN dm_video_booking.video_booking_is_active = "1" THEN "Active"

                        WHEN dm_video_booking.video_booking_is_active = "3" THEN "Completed"

                      WHEN dm_video_booking.video_booking_is_active = "2" THEN "Cancel"

                     WHEN dm_video_booking.video_booking_is_active = "4" THEN "Absent"
                        END) AS status'),

            )


            ->where('roles.name','Clinic')
            ->where('dm_video_booking.video_booking_date','>=',$request->video_booking_from_date)
            ->where('dm_video_booking.video_booking_date','<=',$request->video_booking_to_date)

            ->where(function ($q) use ($status) {
                if($status != null) {
                    $q->where('dm_video_booking.video_booking_is_active', $status);
                }
            })
            ->where(function ($q) use ($filterBy) {
                $q->where('dm_clinic.clinic_full_name', 'like', "%$filterBy%")
                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")
                    ->orWhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%")
                    ->orWhere('dm_family_member.family_member_mobile_number', 'like', "%$filterBy%");

            })
                 ->where(function ($query) use ($doctor_id) {
              if($doctor_id != null)
               {
                   $query
                       ->where('dm_video_booking.doctor_id', $doctor_id);


               }
                         })

            ->where(function ($query) use ($clinic_id) {
                if($clinic_id != null)
                {
                    $query
                        ->where('dm_clinic.clinic_id', $clinic_id);


                }
            })
            ->orderBy('dm_video_booking.video_booking_date', 'ASC')
            ->paginate(30);

        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }
	
	
	 public function  webGetDoctorWisePatientDetails(Request $request){
        $filterBy = $request->searchText;
        $doctor_id=$request->doctor_id;
        $clinic_id=$request->clinic_id;
        $status= $request->booking_is_active;
       $doctor_id=$request->doctor_id;




        if($request->opd_video==1) {

            $getQuery = DB::table("dm_in_clinic_booking")
                ->join('roles','roles.id','dm_in_clinic_booking.in_clinic_booking_made_by_role_id')
                ->join('dm_doctor', 'dm_in_clinic_booking.doctor_id', 'dm_doctor.doctor_id')
                ->join('dm_clinic', 'dm_clinic.clinic_id', 'dm_in_clinic_booking.clinic_id')
                ->join('dm_specialization', 'dm_specialization.doctor_id', 'dm_in_clinic_booking.doctor_id')
                ->join('dm_family_member', 'dm_family_member.family_member_id', 'dm_in_clinic_booking.in_clinic_booking_made_for_family_id')
                ->select('dm_in_clinic_booking.in_clinic_booking_id', 'dm_in_clinic_booking.in_clinic_booking_slot_position', 'dm_doctor.doctor_full_name', 'dm_clinic.clinic_full_name', 'dm_in_clinic_booking.disease_name'
                    , 'dm_specialization.specialization_name', 'dm_in_clinic_booking.in_clinic_booking_current_slot_position', DB::raw('DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date, "%d-%m-%Y") as booking_date'),
                    'dm_family_member.family_member_full_name', 'dm_family_member.family_member_mobile_number','roles.name as booked_by','dm_in_clinic_booking.in_clinic_booking_code as booking_code',

                    \DB::raw('(CASE

                        WHEN dm_in_clinic_booking.in_clinic_booking_is_active = "1" THEN "Active"

                        WHEN dm_in_clinic_booking.in_clinic_booking_is_active = "3" THEN "Completed"

                      WHEN dm_in_clinic_booking.in_clinic_booking_is_active = "2" THEN "Cancel"

                     WHEN dm_in_clinic_booking.in_clinic_booking_is_active = "4" THEN "Absent"
                        END) AS status'),

                )
                ->where(function ($q) use ($status) {
                    if ($status != null) {
                        $q->where('dm_in_clinic_booking.in_clinic_booking_is_active', $status);
                    }
                })


            ->where(function ($q) use ($filterBy) {
                $q->where('dm_clinic.clinic_full_name', 'like', "%$filterBy%")
                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")
                    ->orWhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%")
                    ->orWhere('dm_family_member.family_member_mobile_number', 'like', "%$filterBy%");
            })



                    ->where('dm_in_clinic_booking.doctor_id',$doctor_id)
                ->orderBy('dm_in_clinic_booking.in_clinic_booking_date', 'ASC')
                ->paginate(30);
            return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
        }

        else if($request->opd_video==2)
        {
            $getQuery = DB::table("dm_video_booking")
                ->join('dm_doctor','dm_doctor.doctor_id','dm_video_booking.doctor_id')
                ->join('dm_family_member','dm_family_member.family_member_id','dm_video_booking.video_booking_made_for_family_id')
//                ->join('dm_clinic', 'dm_clinic.user_id', 'dm_video_booking.video_booking_made_by_user_id')

                ->join('roles','roles.id','dm_video_booking.video_booking_made_by_role_id')
                ->select('dm_doctor.doctor_full_name','dm_video_booking.video_booking_code as booking_code'
                    ,'dm_family_member.family_member_full_name','dm_family_member.family_member_mobile_number','roles.name as booked_by',DB::raw('DATE_FORMAT(dm_video_booking.video_booking_date, "%d-%m-%Y") as booking_date')
                    ,
                    \DB::raw('(CASE

                        WHEN dm_video_booking.video_booking_is_active = "1" THEN "Active"

                        WHEN dm_video_booking.video_booking_is_active = "3" THEN "Completed"

                      WHEN dm_video_booking.video_booking_is_active = "2" THEN "Cancel"

                     WHEN dm_video_booking.video_booking_is_active = "4" THEN "Absent"
                        END) AS status'),

                )
                ->where(function ($q) use ($filterBy) {
                    $q
                        ->where('dm_doctor.doctor_full_name', 'like', "%$filterBy%")
                        ->orWhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%")
                        ->orWhere('dm_family_member.family_member_mobile_number', 'like', "%$filterBy%");
                })

                ->where(function ($q) use ($status) {
                    if ($status != null) {
                        $q->where('dm_video_booking.video_booking_is_active', $status);
                    }
                })

                ->where('dm_video_booking.doctor_id',$doctor_id)
                ->orderBy('dm_video_booking.video_booking_date', 'ASC')
                ->paginate(30);
            return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
        }




    }
	
	
	
}
