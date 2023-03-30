<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\path\ImagePath;
use DB;
class TeacherController extends Controller
{
    public function index(Request $request){
        $storagePath=new ImagePath();
        //course and stream images
        $path =   $storagePath->storage_path();
        //
        $staffImagePath = $storagePath->staff_storage_path();
        $teacher=DB::table('lms_staff')
        ->join('lms_department','lms_staff.lms_department_id','lms_department.lms_department_id')
        ->select('lms_department.lms_department_name','lms_staff.lms_staff_full_name','lms_staff.lms_staff_profile_image','lms_staff.lms_staff_qualification','lms_staff.lms_staff_work_experience')->where('lms_staff_id',$request->id)->first();
        return view('Teacher.teacher',['staffImagePath'=>$staffImagePath,'instructors'=>$teacher]);
    }
}
