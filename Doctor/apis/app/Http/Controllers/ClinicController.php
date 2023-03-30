<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClinicController extends Controller
{
    public function Get(Request $request)
    {


        $status= $request->clinic_is_active;
        if ($status != null) {
            $status = $request->clinic_is_active;
        } else {
            $status = 1;
        }

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn ='dm_clinic.'.$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;


        $getQuery = DB::table("dm_clinic")
            ->join('dm_city', 'dm_city.city_id', '=', 'dm_clinic.city_id')
            ->join('dm_area', 'dm_area.area_id', '=', 'dm_clinic.area_id')
//            ->join('dm_clinic_service', 'dm_clinic_service.clinic_id', '=', 'dm_clinic.clinic_id')
//            ->join('dm_clinic_timing', 'dm_clinic_timing.clinic_timing_id', '=', 'dm_clinic.clinic_id')

//            ->join('dm_doctor_clinic_wise', 'dm_doctor_clinic_wise.clinic_id', '=', 'dm_clinic.clinic_id')


            ->select('dm_clinic.clinic_id','dm_clinic.area_id', 'dm_clinic.city_id', 'dm_area.area_name','dm_city.city_name', 'dm_clinic.clinic_mobile_number', 'dm_clinic.clinic_full_name'
                ,'dm_clinic.clinic_profile_image','dm_clinic.clinic_address','dm_clinic.clinic_owner_name','dm_clinic.clinic_setup_date','dm_clinic.clinic_first_name','dm_clinic.clinic_last_name'
                ,'dm_clinic.clinic_email_id','dm_clinic.clinic_address','dm_clinic.clinic_whatsapp','dm_clinic.clinic_facebook'
                ,'dm_clinic.clinic_longitude','dm_clinic.clinic_latitude','dm_clinic.clinic_is_active','dm_clinic.clinic_description','dm_clinic.is_master_clinic'
               ,'dm_clinic.clinic_is_approved'
            )
//,'dm_clinic_service.clinic_service_name','dm_clinic_timing.clinic_days','dm_clinic_timing.clinic_timing'
            ->where(function ($q) use ($filterBy) {
                $q->where('dm_clinic.clinic_full_name', 'like', "%$filterBy%");
//                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")
//                    ->orWhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%");
            })


            ->orderBy('dm_clinic.cinic_order_by', 'asc')
			->orderBy('dm_clinic.clinic_full_name', 'ASC')
            ->paginate($itemsPerPage);


        return response()->json([ 'success' => 'true','resultData' => $getQuery], 200);
    }

    public function clinicWiseBooking(Request $request){
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;

        $clinic_id=$request->clinic_id;
//        $filterBy = $request->searchText;
        $status= $request->in_clinic_booking_is_active;
        if ($status != null) {
            $status = $request->in_clinic_booking_is_active;
        } else {
            $status = 1;
        }
    $getQuery=   DB::table("dm_in_clinic_booking")


            ->join('dm_clinic','dm_clinic.clinic_id','dm_in_clinic_booking.clinic_id')
            ->join('dm_doctor','dm_doctor.doctor_id','dm_in_clinic_booking.doctor_id')

            ->select(DB::raw('DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date, "%d-%m-%Y") as in_clinic_booking_date'),'dm_clinic.clinic_full_name','dm_clinic.clinic_id','dm_in_clinic_booking.doctor_id','dm_doctor.doctor_full_name',
                DB::raw("count(dm_in_clinic_booking.in_clinic_booking_is_active) as total_booking",

            )
                )

              ->groupBy('dm_in_clinic_booking.clinic_id')
             ->groupBy('dm_doctor.doctor_id')
            ->where('dm_in_clinic_booking.in_clinic_booking_date','=',$request->in_clinic_booking_date)
            ->where(function ($query) use ($clinic_id) {
            if($clinic_id != null)
            {
                $query
                    ->where('dm_in_clinic_booking.clinic_id',$clinic_id);           //passing clinic_id
            }
                  })
        ->where('dm_in_clinic_booking.in_clinic_booking_is_active',$status)
            ->orderBy($sortColumn, $sortOrder)
              ->get();
//            ->paginate($itemsPerPage);
        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }

    public function upcomingBookingDetails(Request $request){

        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
		
        $clinic_id=$request->clinic_id;
//        $filterBy = $request->searchText;
         $status='';
        if ($request->in_clinic_booking_is_active != null) {
            $status = $request->in_clinic_booking_is_active;
        } else {
            $status = 1;
        }
        $getQuery=   DB::table("dm_in_clinic_booking")


            ->join('dm_clinic','dm_clinic.clinic_id','dm_in_clinic_booking.clinic_id')
            ->join('dm_doctor','dm_doctor.doctor_id','dm_in_clinic_booking.doctor_id')

            ->select(DB::raw('DATE_FORMAT(dm_in_clinic_booking.in_clinic_booking_date, "%Y-%m-%d") as in_clinic_booking_date'),'dm_clinic.clinic_full_name','dm_clinic.clinic_id','dm_in_clinic_booking.doctor_id','dm_doctor.doctor_full_name',
                DB::raw("count(dm_in_clinic_booking.in_clinic_booking_is_active) as total_booking",

                )
            )

            ->groupBy('dm_in_clinic_booking.clinic_id')
            ->groupBy('dm_in_clinic_booking.doctor_id')
			->groupBy('dm_in_clinic_booking.in_clinic_booking_date')
            //->where('dm_in_clinic_booking.in_clinic_booking_date','>=',now())
			->where('dm_in_clinic_booking.in_clinic_booking_date','>=',date("Y-m-d"))
            ->where(function ($query) use ($clinic_id) {
                if($clinic_id != null)
                {
                    $query
                        ->where('dm_in_clinic_booking.clinic_id',$clinic_id);           //passing clinic_id
                }
            })
            ->where('dm_in_clinic_booking.in_clinic_booking_is_active',$status)
            ->orderBy($sortColumn, $sortOrder)
             ->get();
            //dd($getQuery);
//            ->paginate($itemsPerPage);
        return response()->json(['success'=>'true','resultData' =>  $getQuery], 200);
    }

    public function getDoctorDetailsWithoutPagination(Request $request){
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;
        $status= $request->doctor_is_active;
        if ($status != null) {
            $status = $request->doctor_is_active;
        } else
        {
            $status = 1;
        }

        $getQuery = DB::table("dm_doctor")
            ->join('dm_specialization','dm_specialization.doctor_id','dm_doctor.doctor_id')
            ->select('dm_doctor.doctor_id','dm_doctor.doctor_full_name','doctor_mobile_number','doctor_overall_experience'
                ,'doctor_city','doctor_address','dm_specialization.specialization_name'
            )

            ->where(function ($q) use ($filterBy) {
                $q->where('dm_doctor.doctor_full_name', 'like', "%$filterBy%");
//                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")
//                    ->orWhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%");
            })
            ->where('dm_doctor.doctor_is_active',$status)
            ->get();


        return response()->json([ 'success' => 'true','resultData' => $getQuery], 200);
    }

    public function getDoctorDetails(Request $request){
        $itemsPerPage = $request->itemsPerPage;
        $sortColumn =$request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;
        $status= $request->doctor_is_active;
        if ($status != null) {
            $status = $request->doctor_is_active;
        } else
        {
            $status = 1;
        }

        $getQuery = DB::table("dm_doctor")
            ->join('dm_specialization','dm_specialization.doctor_id','dm_doctor.doctor_id'
            )

              ->join('dm_doctor_education','dm_doctor_education.doctor_id','dm_doctor.doctor_id'
        )

                   ->join('dm_doctor_experience','dm_doctor_experience.doctor_id','dm_doctor.doctor_id'
        )

            ->select('dm_doctor.doctor_id','dm_doctor.doctor_full_name','doctor_mobile_number','doctor_overall_experience'
                ,'dm_specialization.specialization_name','dm_doctor.doctor_description',
                'dm_doctor_education.education_name','dm_doctor_experience.experience_name','dm_doctor.city_id','dm_doctor.area_id'
                ,'dm_doctor.doctor_profile_image','dm_doctor.doctor_first_name','dm_doctor.doctor_last_name',
                'dm_doctor.doctor_is_active','dm_doctor.doctor_is_approved','dm_doctor.disease_category_id'
            )

            ->where(function ($q) use ($filterBy) {
                $q->where('dm_doctor.doctor_full_name', 'like', "%$filterBy%");
//                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")
//                    ->orWhere('dm_family_member.family_member_full_name', 'like', "%$filterBy%");
            })

            ->orderBy('dm_doctor.doctor_full_name','ASC')
            ->paginate($itemsPerPage);


        return response()->json([ 'success' => 'true','resultData' => $getQuery], 200);
    }

    public function  addClinicDetails(Request $request){



        $rules=[
            'doctor_profile_image'=>'mimes:jpeg,png,jpg'
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['success' => 'true', 'message' => 'File Type Unsupported']);
        }



            try {
                $comp = DB::table('dm_clinic')->where('clinic_full_name',$request->clinic_full_name)

                    ->count();
                if ($comp > 0) {
                    return response()->json(['success' => 'true', 'message' => 'Clinic  name already exist enter a new Clinic name'], 200);
                }
                DB::beginTransaction();
                $role_id = DB::table('roles')
                    ->select('roles.id')
                    ->where('role_is_active', 1)
                    ->where('roles.name', 'Clinic')
                    ->first();

                $password = random_int(100000, 999999);
                $insertedUserId = DB::table('dm_user')->insertGetId(
                    [
                        'role_id' => $role_id->id,
                        'user_mobile' => $request->clinic_mobile_number,
                        'password' => bcrypt("123456"),
                        'password_normal' => "123456",

                    ]);


                $clinicid=  DB::table('dm_clinic')->insertGetId(
                    [

                        'user_id' => $insertedUserId,
                        'city_id' => $request->city_id,
                        'area_id' => $request->area_id,
                        'clinic_first_name' => $request->clinic_first_name,
                        'clinic_last_name' => $request->clinic_last_name,
                        'clinic_full_name' => $request->clinic_first_name . ' ' . $request->clinic_last_name,
                        'clinic_mobile_number' =>  $request->clinic_mobile_number,
                        'clinic_address'=>$request->clinic_address,
                        'clinic_description'=>$request->clinic_description,
                        'clinic_longitude'=>$request->clinic_longitude,
                        'clinic_latitude'=>$request->clinic_latitude,
                        'is_master_clinic'=>1,

                        'clinic_position' => "0,1",

                    ]);

                  $clinic_image=DB::table('dm_clinic_image')->insertGetId([
                  'clinic_id'=>$clinicid,
                    'clinic_image'=>"105.jpg",
                ]);

                $dm_doctor=DB::table('dm_doctor_clinic_wise')->insertGetId([
                    'clinic_id'=> $clinicid,
                    'doctor_id'=>'94',
                    'in_clinic_appointment_fee_is_visible'=>1,
                    'video_consultation_fee_is_visible'=>0,
                    'video_consultation_is_avialable'=>0,
                    'in_clinic_appointment_fee'=>600,
                    'video_consultation_fee'=>0,
                    'in_clinic_service_fee'=>25,
                    'video_consultation_service_fee'=>25,
                    'doctor_clinic_wise_is_active'=>1,
                    'in_clinic_consultation_is_avialable'=>1,
                    'in_clinic_cancellation_days'=>1,
                    'video_cancellation_days'=>1,
                    'in_clinic_book_before_days'=>0,
                    'video_book_before_days'=>4
                ]);


                DB::commit();
                return response()->json(['result'=>'success','message' => 'clinic saved successfully'], 200);

            } catch (Exception $ex) {

                DB::rollback();

            }

    }

    public function  webUpdateClinicDetails(Request $request){
        try {
            $comp = DB::table('dm_clinic')
                ->where('clinic_id','!=',$request->clinic_id)
                ->where('clinic_first_name',$request->clinic_first_name)
                ->where('clinic_last_name',$request->clinic_last_name)
                ->count();
            if ($comp > 0) {
                return response()->json(['result' => 'success', 'message' => 'Clinic name already exist enter a new  name'], 200);
            }
            DB::beginTransaction();
            $prof_image=DB::table('dm_clinic')->where('clinic_id',$request->clinic_id)->first();

            $user=DB::table('dm_user')->where('user_id',$prof_image->user_id)->count();
            if($user>0){
                $user=DB::table('dm_user')->where('user_id',$prof_image->user_id)->update([
                    'user_mobile'=>$request->clinic_mobile_number
                ]);
            }

            $doctorid=  DB::table('dm_clinic')->where('clinic_id',$request->clinic_id)->update(
                [



                    'city_id' => $request->city_id,
                    'area_id' => $request->area_id,
                    'clinic_first_name' => $request->clinic_first_name,
                    'clinic_last_name' => $request->clinic_last_name,
                    'clinic_full_name' => $request->clinic_first_name . ' ' . $request->clinic_last_name,
                    'clinic_mobile_number' =>  $request->clinic_mobile_number,
                    'clinic_address'=>$request->clinic_address,
                    'clinic_description'=>$request->clinic_description,
                    'clinic_longitude'=>$request->clinic_longitude,
                    'clinic_latitude'=>$request->clinic_latitude,
                    'is_master_clinic'=>1,

                    'clinic_position' => "0,1",
                ]);


            DB::commit();
            return response()->json(['result' => 'success','message' => 'Clinic Details Updated successfully'], 200);
        }catch (Exception $ex) {

            DB::rollback();

        }

    }

    public function webChangeClinicActive(Request $request){
        $id = $request->clinic_id;
        $status = $request->clinic_is_active;

        $st = DB::table('dm_clinic')
            ->where('clinic_id',  $id )
            ->update([
                'clinic_is_active' => $status,
            ]);
        if ($st) {

            return response()->json(['result'=>'success','message' => 'Clinic Status Changed Successfully'], 200);
        }
    }
    public function webChangeMasterClinic(Request $request){
        $id = $request->clinic_id;
        $status = $request->is_master_clinic;

        $st = DB::table('dm_clinic')
            ->where('clinic_id',  $id )
            ->update([
                'is_master_clinic' => $status,
            ]);
        if ($st) {

            return response()->json(['result'=>'success','message' => ' Clinic Master Status Changed Successfully'], 200);
        }
    }
  public function  addClinicService(Request $request)
  {

         $id=$request->clinic_id;
         $clinic_service_name=$request->clinic_service_name;


             $clinic_service=DB::table('dm_clinic_service')->insertGetId([
                     'clinic_id'=>$id,
                     'clinic_service_name'=>$request->clinic_service_name,
                 ]
                 );



      if ( $clinic_service)
      {
          return response()->json(['result'=>'success','message' => ' Clinic Services Saved Successfully'], 200);
      }
  }

  public function  getClinicService(Request  $request){

      $getQuery=DB::table('dm_clinic_service')
            ->select('clinic_service_name','clinic_service_id','clinic_id')
            ->where('clinic_service_is_active',1)
//            ->where('clinic_id',$request->clinic_id)

          ->get();
      return response()->json(['resultData' => $getQuery,'result'=>'success'], 200);

  }

  public function webGetClinicTiming(Request $request){
      $getQuery=DB::table('dm_clinic_timing')
          ->select('*')
          ->where('clinic_timing_is_active',1)
          ->get();
      return response()->json(['resultData' => $getQuery,'result'=>'success'], 200);

  }

  public function  webSaveClinicTiming(Request  $request){
      $id=$request->clinic_id;
      $clinic_service_name=$request->clinic_service_name;


      $clinic_service=DB::table('dm_clinic_timing')->insertGetId([
              'clinic_id'=>$id,
              'clinic_days'=>$request->clinic_days,
              'clinic_timing'=>$request->clinic_timing,
              'clinic_open_closed'=>'Open',
          ]
      );



      if ( $clinic_service)
      {
          return response()->json(['result'=>'success','message' => ' Clinic Timing Saved Successfully'], 200);
      }

  }

    public function  webUpdateClinicTiming(Request  $request){
        $id=$request->clinic_id;
        $clinic_service_name=$request->clinic_service_name;


        $clinic_service=DB::table('dm_clinic_timing')
            ->where('dm_clinic_timing.clinic_timing_id',$request->clinic_timing_id)
            ->where('dm_clinic_timing.clinic_id',$request->clinic_id)
            ->update([
                'clinic_id'=>$id,
                'clinic_days'=>$request->clinic_days,
                'clinic_timing'=>$request->clinic_timing,
                'clinic_open_closed'=>'Open',
            ]
        );



        if ( $clinic_service)
        {
            return response()->json(['result'=>'success','message' => ' Clinic Timing Saved Successfully'], 200);
        }

    }

}
