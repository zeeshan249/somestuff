<?php

namespace App\Http\Controllers\Exam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\path\ImagePath;
use DB;

class ExamController extends Controller
{
    public function allexams(){
            //trending course section
           $trendingcourses=DB::table('lms_child_course')
           ->join('lms_course','lms_course.lms_course_id','lms_child_course.lms_course_id')
           ->select('lms_child_course.lms_child_course_id','lms_child_course.lms_child_course_code','lms_child_course.lms_child_course_name','lms_child_course.lms_child_course_image','lms_child_course.lms_child_course_description','lms_child_course.lms_child_course_fees',
               'lms_child_course.lms_child_course_duration','lms_course.lms_course_name'
           )
           ->where('lms_child_course.lms_child_course_is_active',1)
           ->where('lms_course.lms_course_name','JEE')
           ->orwhere('lms_course.lms_course_name','NEET')
          
           ->where('lms_child_course_is_active',1)->paginate(4,'page');

       $storagePath=new ImagePath();
       $path =   $storagePath->storage_path();

       $latestcourses=DB::table('lms_child_course')
       ->join('lms_course','lms_course.lms_course_id','lms_child_course.lms_course_id')
      ->select('lms_child_course.lms_child_course_id','lms_child_course.lms_child_course_code','lms_child_course.lms_child_course_name','lms_child_course.lms_child_course_image','lms_child_course.lms_child_course_description','lms_child_course.lms_child_course_fees',
      'lms_child_course.lms_child_course_duration','lms_course.lms_course_name'
      )
      ->where('lms_child_course.lms_child_course_is_active',1)
      ->where('lms_course.lms_course_name','JEE')
      ->orwhere('lms_course.lms_course_name','NEET')
      ->where('lms_child_course_is_active',1)->limit(6)->get();
      $storagePath=new ImagePath();
      $path =   $storagePath->storage_path();
        return view('Exams.allexams',['courses'=>$trendingcourses,'storagePath'=>$path,'latestcourses'=>$latestcourses,
        
    ]);
    }
}
