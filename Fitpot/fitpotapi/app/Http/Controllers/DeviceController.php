<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    public function Get(Request $request)
    {


        $itemsPerPage = $request->itemsPerPage;
        $sortColumn = $request->sortColumn;
        $sortOrder = $request->sortOrder;
        $filterBy = $request->searchText;


        $getQuery = DB::table("device")->select('*')

            ->where(function ($q) use ($filterBy) {
                $q->where('device.device_name', 'like', "%$filterBy%");
//                    ->orWhere('dm_doctor.doctor_full_name', 'like', "%$filterBy%")

            })
            ->orderBy($sortColumn, $sortOrder)
            ->paginate($itemsPerPage);

        return response()->json(['resultData' => $getQuery], 200);
    }

    public function Save(Request $request)
    {
        $rules=[
            'device_logo'=>'mimes:jpeg,png,jpg'
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['success' => 'true', 'message' => 'File Type Unsupported']);
        }
        if ($request->hasFile('device_logo'))
        {
            $file            = $request->file('device_logo');
            $destinationPath = 'public/device_images';
            $filename        = Str::random(10).'.'. $file->getClientOriginalExtension();
            $request->file('device_logo')->storeAs($destinationPath, $filename);
            $photo = $filename;
            try {
                $comp = DB::table('device')->where('device_name', $request->device_name)->count();
                if ($comp > 0) {
                    return response()->json(['success' => 'true', 'message' => 'Device   name already exist enter a new device name'], 200);
                }
                else {


                    $inserted = DB::table('device')->insertGetId(
                        [
                            'device_name' => $request->device_name,
                            'device_type' => $request->device_type,
                            'device_logo' => $photo,
                            'is_device_auth_required' => $request->is_device_auth_required,
                            'device_auth_param' => $request->device_auth_param,
                            'device_auth_url' => $request->device_auth_url,
                            'is_device_app_installation_required' => $request->is_device_app_installation_required,
                            'device_app_android_url' =>   $request->device_app_android_url,
                            'device_app_ios_url' =>$request->device_app_ios_url,
                            'device_os_type' => $request->device_os_type,
                            'android_package_name' => $request->android_package_name,
                            'ios_package_name' => $request->ios_package_name,

                        ]);
                    return response()->json(['success' => 'true', 'message' => 'Device added successfully'], 200);
                }
            }
            catch (Exception $ex)
            {
                if(\Storage::exists('public/device_images/'.$photo)){
                    \Storage::delete('public/device_images/'.$photo);
                }
                return response()->json(['success' => 'false', 'message' => 'something went wrong'], 200);
            }

        }
        else{
            $photo='';
        }

    }
    public function Status(Request  $request)
    {
        $status = $request->device_status;
        $device_id = $request->device_id;

        $st = DB::table('device')
            ->where('device_id',  $device_id )
            ->update([
                'device_status' => $status,
            ]);
        if ($st) {

            return response()->json(['success'=>'true','message' => 'Device Status Changed successfully'], 200);
        }


    }

    public function Delete(Request $request)
    {

     $image=DB::table('device')->select('device_logo')
         ->where('device_id',  $request->device_id )->first();
        $deleteQuery = DB::table('device')
            ->where('device_id',  $request->device_id )->delete();
        if ($deleteQuery > 0) {
            \Storage::delete('public/device_images/'.$image->device_logo);
            return response()->json(['success'=>'true','message' => 'Device Deleted'], 200);
        }
    }
    public function Update(Request $request)
    {

        $db = DB::table('device')->where('device_name', $request->device_name)->where('device_id', '!=', $request->device_id)->count();

        if ($db) {
            return response()->json([ 'success' => 'true','message' => 'Device name already exist enter a new Device name'], 200);
        } else {
            //search for  existing image from database
            $image=DB::table('device')->select('device_logo')->where('device_id',$request->device_id)->first();
           //checking user device_logo input
            $rules=[
                'device_logo'=>'mimes:jpeg,png,jpg'
            ];
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails()){
                return response()->json(['success' => 'true', 'message' => 'File Type Unsupported']);
            }
            if ($request->hasFile('device_logo')) {
                $file            = $request->file('device_logo');
                $destinationPath = 'public/device_images/';
                $filename        = Str::random(10).'.'. $file->getClientOriginalExtension();
                $request->file('device_logo')->storeAs($destinationPath, $filename);
                $photo = $filename;
                $prev= \Storage::delete('public/device_images/'.$image->device_logo);

            }else{
                $photo = $image->device_logo ;
            }
            try {
                $updateQuery = DB::table('device')
                    ->where('device_id', $request->device_id)
                    ->update([
                        'device_name' => $request->device_name,
                        'device_type' => $request->device_type,
                        'device_logo' => $photo,
                        'is_device_auth_required' => $request->is_device_auth_required,
                        'device_auth_param' => $request->device_auth_param,
                        'device_auth_url' => $request->device_auth_url,
                        'is_device_app_installation_required' => $request->is_device_app_installation_required,
                        'device_app_android_url' => $request->device_app_android_url,
                        'device_app_ios_url' => $request->device_app_ios_url,

                        'device_os_type' => $request->device_os_type,
                        'android_package_name' => $request->android_package_name,
                        'ios_package_name' => $request->ios_package_name,

                    ]);
                if ($updateQuery > 0) {

                    return response()->json(['success' => 'true', 'message' => 'Device name  updated successfully'], 200);
                }
            }
            catch (Exception $ex)
            {

                return response()->json(['success' => 'false', 'message' => 'something went wrong'], 200);
            }
        }
    }

    public function authStatus(Request  $request)
    {
        $status = $request->is_device_auth_required;
        $device_id = $request->device_id;

        $st = DB::table('device')
            ->where('device_id',  $device_id )
            ->update([
                'is_device_auth_required' => $status,
            ]);
        if ($st) {

            return response()->json(['success'=>'true','message' => 'Auth Status Changed successfully'], 200);
        }


    }


}
