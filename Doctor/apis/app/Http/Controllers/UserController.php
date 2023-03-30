<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function Get(Request $request){
        $itemsPerPage=$request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;

        $getQuery = DB::table("dm_user")
            ->join('roles','roles.id','dm_user.role_id')
//            ->join('dm_doctor','dm_doctor.user_id','dm_user.user_id')
//            ->join('dm_customer_personal_details','dm_customer_personal_details.user_id','dm_user.user_id')
            ->select('roles.name','dm_user.user_id','dm_user.user_mobile','dm_user.password','dm_user.password_normal'
            )
            ->where('dm_user.user_is_active',1)
//            ->where('dm_doctor.doctor_is_active',1)
            ->where('roles.name','Doctor')
//            ->where('dm_user.user_id','>=','Doctor')
//            ->orwhere('roles.name','Admin')
//            ->orwhere('roles.name','Clinic')
//            ->orwhere('roles.name','Patient')

            ->where(function ($q) use ($filterBy) {
                $q
                    ->orWhere('dm_user.user_mobile', 'like', "%$filterBy%");
            })
            ->paginate($itemsPerPage);
        return response()->json(['resultData' =>  $getQuery,'success'=>'true'], 200);

    }
    public function  saveDoctor(Request $request)
    {
        $city_id=$request->CityId;
//        $area_id=DB::table('dm_area')
//            ->select('dm_area.area_id')
//            ->where('dm_area.area_is_active',1)
//            ->whereIn('dm_area.city_id',explode(',', $city_id))
//
//            ->pluck('dm_area.area_id');
   //     str_replace( array('[',']') , ''  , $area  )
//         $area=implode(",",[$area_id]);

        $rules=[
            'doctor_profile_image'=>'mimes:jpeg,png,jpg'
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['success' => 'true', 'message' => 'File Type Unsupported']);
        }
        if ($request->hasFile('doctor_profile_image')) {
            $file = $request->file('doctor_profile_image');
            $destinationPath = 'public/user_profile_pic';
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $request->file('doctor_profile_image')->storeAs($destinationPath, $filename);
            $photo = $filename;


            try {
                $comp = DB::table('dm_doctor')->where('doctor_first_name',$request->doctor_first_name)
                    ->where('doctor_last_name',$request->doctor_last_name)
                    ->count();
                if ($comp > 0) {
                    return response()->json(['success' => 'true', 'message' => 'Doctor  name already exist enter a new Doctor name'], 200);
                }
                DB::beginTransaction();
                $role_id = DB::table('roles')
                    ->select('roles.id')
                    ->where('role_is_active', 1)
                    ->where('roles.name', 'Doctor')
                    ->first();

                $password = random_int(100000, 999999);
                $insertedUserId = DB::table('dm_user')->insertGetId(
                    [
                        'role_id' => $role_id->id,
                        'user_mobile' => $request->doctor_mobile_number,
                        'password' => bcrypt("123456"),
                        'password_normal' => "123456",

                    ]);


              $doctorid=  DB::table('dm_doctor')->insertGetId(
                    [

                        'user_id' => $insertedUserId,
                        'disease_category_id' => $request->DiseaseCategoryId,
                        'city_id' => $request->CityId,
                        'area_id' => $request->AreaId,
                        'doctor_first_name' => $request->doctor_first_name,
                        'doctor_last_name' => $request->doctor_last_name,
                        'doctor_full_name' => $request->doctor_first_name . ' ' . $request->doctor_last_name,
                        'doctor_mobile_number' => $request->doctor_mobile_number,
                        'doctor_profile_image' => $photo,
                        'doctor_overall_experience' => $request->doctor_overall_experience,
                        'doctor_position' => "0,1",
                        'doctor_description' => $request->doctor_description,
                        'doctor_is_approved' => 1,
                    ]);
              DB::table('dm_specialization')->insertGetId([
                  'doctor_id'=>$doctorid,
                  'specialization_name'=>$request->specialization_name,
                  'specialization_type'=>1
              ]);


                DB::table('dm_doctor_education')->insertGetId([
                    'doctor_id'=>$doctorid,
                    'education_type'=>1,
                    'education_name'=>$request->education_name,

                ]);

//                DB::table('dm_video_slot')->insertGetId([
//                    'slot_name_id'=>1,
//                    'doctor_id'=>$doctorid,
//                    'video_doctor_max_booking_days'=>'1,2,3',
//                    'video_doctor_is_available_date_wise'=>1,
//                    'video_slot_max_position'=>10,
//                    'video_slot_time_interval'=>15,
//
//                ]);

                DB::table('dm_doctor_experience')->insertGetId([
                    'doctor_id'=>$doctorid,
                    'experience_name'=>$request->experience_name,

                ]);

                $dieses_expl=explode(",",$request->DiseaseCategoryId);
               
                $city_expl=explode(",",$request->CityId);
                $area_expl=explode(",",$request->AreaId);
               
                for($i=0;$i<count($dieses_expl);$i++)
                {
                    if($dieses_expl[$i]>0)
                    {

                    //echo $dieses_expl[$i];
                    $dieses_data=DB::table('dm_disease_category')->where('disease_category_id',$dieses_expl[$i])->select(['city_id','area_id'])->first();
                   
                    $d_city_id=$dieses_data->city_id;
                    $expl_d_city_ary=explode(",",$d_city_id);
                    $city_ary = array_filter(array_unique(array_merge($expl_d_city_ary, $city_expl)));
                    $updated_city_list=implode(",",$city_ary);

                    $dieses_city=DB::table('dm_disease_category')->where('disease_category_id',$dieses_expl[$i])->update(['city_id'=>$updated_city_list]);
                   
                    $d_area_id=$dieses_data->area_id;
                    $expl_d_area_ary=explode(",",$d_area_id);
                    $area_ary = array_filter(array_unique(array_merge($expl_d_area_ary, $area_expl)));
                    $updated_area_list=implode(",",$area_ary);

                     $dieses_area=DB::table('dm_disease_category')->where('disease_category_id',$dieses_expl[$i])->update(['area_id'=>$updated_area_list]);

                    }   

                }
                
//                     DB::table('dm_doctor_video')->insertGetId([
//                         'doctor_id'=>$doctorid,
//                         'video_consultation_is_avialable'=>$request->video_consultation_is_avialable
//
//                     ]);
                DB::commit();
                return response()->json(['success' => 'true','message' => 'Doctor saved successfully'], 200);

            } catch (Exception $ex) {

                DB::rollback();

            }
        }
    }

    public function updateDoctorDetails(Request  $request){

        $rules=[
            'doctor_profile_image'=>'mimes:jpeg,png,jpg'
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['success' => 'true', 'message' => 'File Type Unsupported']);
        }
//        if ($request->hasFile('doctor_profile_image') ) {
//            $file = $request->file('doctor_profile_image');
//            $destinationPath = 'public/user_profile_pic';
//            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
//            $request->file('doctor_profile_image')->storeAs($destinationPath, $filename);
//            $photo = $filename;
            try {
                $comp = DB::table('dm_doctor')
                       ->where('doctor_id','!=',$request->doctor_id)
                    ->where('doctor_first_name',$request->doctor_first_name)
                    ->where('doctor_last_name',$request->doctor_last_name)
                    ->count();
                if ($comp > 0) {
                    return response()->json(['success' => 'true', 'message' => 'Doctor  name already exist enter a new Doctor name'], 200);
                }
                DB::beginTransaction();
                $prof_image=DB::table('dm_doctor')->where('doctor_id',$request->doctor_id)->first();
                        if ($request->hasFile('doctor_profile_image') ) {
                            $file = $request->file('doctor_profile_image');
                            $destinationPath = 'public/user_profile_pic';
                            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
                            $request->file('doctor_profile_image')->storeAs($destinationPath, $filename);
                            $photo = $filename;
                        }
                        else{
                            $photo=$prof_image->doctor_profile_image;
                        }

                        $user_id=$prof_image->user_id;
                        $doctor=DB::table('dm_user')->where('user_id',$user_id)->count();
                        if($doctor>0){
                            $user=DB::table('dm_user')->where('user_id',$user_id)->update([
                               'user_mobile'=>$request->doctor_mobile_number
                            ]);
                        }

                $doctorid=  DB::table('dm_doctor')->where('doctor_id',$request->doctor_id)->update(
                    [


                        'disease_category_id' => $request->DiseaseCategoryId,
                        'city_id' => $request->city_id,
                        'area_id' => $request->AreaId,
                        'doctor_first_name' => $request->doctor_first_name,
                        'doctor_last_name' => $request->doctor_last_name,
                        'doctor_full_name' => $request->doctor_first_name . ' ' . $request->doctor_last_name,
                        'doctor_mobile_number' => $request->doctor_mobile_number,
                        'doctor_profile_image' => $photo,
                        'doctor_overall_experience' => $request->doctor_overall_experience,
                        'doctor_position' => "0,1",
                        'doctor_description' => $request->doctor_description,
                        'doctor_is_approved' => 1,
                    ]);
                DB::table('dm_specialization')->where('doctor_id',$request->doctor_id)->update([

                    'specialization_name'=>$request->specialization_name,
                    'specialization_type'=>1
                ]);
                DB::table('dm_doctor_education')->where('doctor_id',$request->doctor_id)->update([

                    'education_type'=>1,
                    'education_name'=>$request->education_name,

                ]);
                DB::table('dm_doctor_experience')->where('doctor_id',$request->doctor_id)->update([

                    'experience_name'=>$request->experience_name,

                ]);
                
                $dieses_expl=explode(",",$request->DiseaseCategoryId);
               
                $city_expl=explode(",",$request->city_id);
                $area_expl=explode(",",$request->AreaId);
               
                for($i=0;$i<count($dieses_expl);$i++)
                {
                    if($dieses_expl[$i]>0)
                    {

                    //echo $dieses_expl[$i];
                    $dieses_data=DB::table('dm_disease_category')->where('disease_category_id',$dieses_expl[$i])->select(['city_id','area_id'])->first();
                   
                    $d_city_id=$dieses_data->city_id;
                    $expl_d_city_ary=explode(",",$d_city_id);
                    $city_ary = array_filter(array_unique(array_merge($expl_d_city_ary, $city_expl)));
                    $updated_city_list=implode(",",$city_ary);

                    $dieses_city=DB::table('dm_disease_category')->where('disease_category_id',$dieses_expl[$i])->update(['city_id'=>$updated_city_list]);
                   
                    $d_area_id=$dieses_data->area_id;
                    $expl_d_area_ary=explode(",",$d_area_id);
                    $area_ary = array_filter(array_unique(array_merge($expl_d_area_ary, $area_expl)));
                    $updated_area_list=implode(",",$area_ary);

                     $dieses_area=DB::table('dm_disease_category')->where('disease_category_id',$dieses_expl[$i])->update(['area_id'=>$updated_area_list]);

                    }   

                }


                DB::commit();
                return response()->json(['success' => 'true','message' => 'Doctor Details Updated successfully'], 200);
            }catch (Exception $ex) {

                DB::rollback();

            }



        }


    public function changeDoctorStatus(Request  $request){
        $status = $request->doctor_is_active;
        $doctor_id = $request->doctor_id;

        $st = DB::table('dm_doctor')
            ->where('doctor_id',   $doctor_id )
            ->update([
                'doctor_is_active' => $status,
            ]);
        if ($st) {

            return response()->json(['success'=>'true','message' => 'Doctor Status Changed successfully'], 200);
        }
    }

    public function deleteDoctorDetails(Request  $request){
        $status = $request->doctor_is_active;
        $doctor_id = $request->doctor_id;
//        if (file_exists(storage_path('app/public/user_profile_pic/' . $fileName))) {
//            unlink(storage_path('app/public/user_profile_pic/' . $fileName));
//        }
        $st = DB::table('dm_doctor')
            ->where('doctor_id',   $doctor_id )
         ->delete();
        if ($st) {

            return response()->json(['success'=>'true','message' => 'Doctor Deleted successfully'], 200);
        }
    }
    public function  webGetDiseaseCategory(Request $request){
        $disease=DB::table('dm_disease_category')->where('disease_category_active',1)->get();

        if($disease){
            return response()->json(['result'=>'success','resultData'=>$disease], 200);
        }
    }


}
