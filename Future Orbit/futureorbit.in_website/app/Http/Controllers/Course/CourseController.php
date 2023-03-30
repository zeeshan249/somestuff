<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\path\ImagePath;
use Illuminate\Pagination\Paginator;
use DB;
class CourseController extends Controller
{
    public function allcourses(){
    
      
        $courses=DB::table('lms_child_course')
        ->join('lms_course','lms_course.lms_course_id','lms_child_course.lms_course_id')
       ->select('lms_child_course.lms_child_course_id','lms_child_course.lms_child_course_code','lms_child_course.lms_child_course_name','lms_child_course.lms_child_course_image','lms_child_course.lms_child_course_description','lms_child_course.lms_child_course_fees',
       'lms_child_course.lms_child_course_duration','lms_course.lms_course_name'
       )
       ->where('lms_course.lms_course_name','ICSE')
       ->orwhere('lms_course.lms_course_name','CBSE')
       ->orwhere('lms_course.lms_course_name','WB')
       ->where('lms_child_course_is_active',1)->paginate(4);
       $storagePath=new ImagePath();
       $path =   $storagePath->storage_path();

       $latestcourses=DB::table('lms_child_course')
       ->join('lms_course','lms_course.lms_course_id','lms_child_course.lms_course_id')
      ->select('lms_child_course.lms_child_course_id','lms_child_course.lms_child_course_code','lms_child_course.lms_child_course_name','lms_child_course.lms_child_course_image','lms_child_course.lms_child_course_description','lms_child_course.lms_child_course_fees',
      'lms_child_course.lms_child_course_duration','lms_course.lms_course_name'
      )
      ->where('lms_course.lms_course_name','ICSE')
      ->orwhere('lms_course.lms_course_name','CBSE')
      ->orwhere('lms_course.lms_course_name','WB')
      ->where('lms_child_course_is_active',1)->limit(6)->get();
      $storagePath=new ImagePath();
      $path =   $storagePath->storage_path();
  
        return view('Course.allcourses',['courses'=>$courses,'storagePath'=>$path,'latestcourses'=>$latestcourses]);
    }
    public function coursedetails($id)
    {
        $storagePath=new ImagePath();
        $path =   $storagePath->storage_path();
        $coursedetails=DB::table('lms_child_course')
        ->join('lms_course','lms_course.lms_course_id','lms_child_course.lms_course_id')
       // ->join('lms_subject','lms_subject.lms_course_id','lms_child_course.lms_course_id')
       ->select('lms_child_course.web_lms_child_course_description','lms_child_course.lms_child_course_code','lms_child_course.lms_course_id','lms_child_course.lms_child_course_name','lms_child_course.lms_child_course_image','lms_child_course.lms_child_course_description','lms_child_course.lms_child_course_fees',
       'lms_child_course.lms_child_course_duration','lms_course.lms_course_name',
 
       )
       ->where('lms_child_course.lms_child_course_id',$id)
       
       ->where('lms_child_course.lms_child_course_is_active',1)
       ->first();
   
       $coursesubject=DB::table('lms_subject')->select('lms_subject.lms_subject_id','lms_subject.lms_subject_name')
       ->where('lms_subject.lms_course_id',$coursedetails->lms_course_id)
        ->where('lms_subject.lms_subject_is_active',1)
       ->get();
   
        return view('Course.coursedetails',['storagePath'=>$path,'coursedetails'=>$coursedetails,'coursesubject'=>$coursesubject]);
    }
}
