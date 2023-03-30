<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\path\ImagePath;
use DB;

class HomeController extends Controller
{
    public function index()
    {
      $selectedcourseid=[23,22,24,10,13];
        $storagePath=new ImagePath();
        //course and stream images
        $path =   $storagePath->storage_path();
        //
        $staffImagePath = $storagePath->staff_storage_path();
        //testimonials image
        $testimonialsImagePath = $storagePath->testimonials_image();
      //stream section
       $stream=DB::table('lms_course')

       ->select('lms_course.lms_course_code','lms_course.lms_course_name','lms_course.lms_course_image','lms_course.lms_course_description','lms_course.lms_course_fees',
       'lms_course.lms_course_duration'
       ,DB::raw("(SELECT IFNULL(count(lms_student_course_mapping.lms_course_id),0) FROM lms_student_course_mapping  where lms_student_course_mapping.lms_course_id=lms_course.lms_course_id
       ) as totalStudentsEnrolled"))
       ->where('lms_course_is_active',1)
       ->orderByRaw('FIELD(lms_course_id,23,22,24,10,13)')
      ->get();
  
       //course section for icse cbse wb
       $courses=DB::table('lms_child_course')
        ->join('lms_course','lms_course.lms_course_id','lms_child_course.lms_course_id')
       ->select('lms_child_course.lms_child_course_id','lms_child_course.lms_child_course_code','lms_child_course.lms_child_course_name','lms_child_course.lms_child_course_image','lms_child_course.lms_child_course_description','lms_child_course.lms_child_course_fees',
       'lms_child_course.lms_child_course_duration','lms_course.lms_course_name'
       )
       ->where('lms_course.lms_course_name','ICSE')
       ->orwhere('lms_course.lms_course_name','CBSE')
       ->orwhere('lms_course.lms_course_name','WB')
       ->where('lms_child_course.lms_child_course_is_active',1)
       ->where('lms_course.lms_course_is_active',1)
       ->get();
   
       //trending course section exam section jee neet
        $trendingcourses=DB::table('lms_child_course')
            ->join('lms_course','lms_course.lms_course_id','lms_child_course.lms_course_id')
            ->select('lms_child_course.lms_child_course_id','lms_child_course.lms_child_course_code','lms_child_course.lms_child_course_name','lms_child_course.lms_child_course_image','lms_child_course.lms_child_course_description','lms_child_course.lms_child_course_fees',
                'lms_child_course.lms_child_course_duration','lms_course.lms_course_name'
            )
            ->where('lms_child_course.lms_child_course_is_active',1)
            ->where('lms_course.lms_course_name','=','JEE')
            ->orwhere('lms_course.lms_course_name','=','NEET')
           
            ->where('lms_child_course.lms_child_course_is_active',1)
            ->where('lms_course.lms_course_is_active',1)
            ->get();
         
       //instructor section
       $instructors=DB::table('lms_staff')
    
       ->select('lms_staff.lms_staff_id','lms_staff.lms_staff_full_name','lms_staff.description_type','lms_staff.lms_staff_profile_image','lms_staff.lms_staff_qualification','lms_staff.lms_staff_work_experience'
       )
       ->where('lms_staff_is_active',1)
       ->where('lms_staff.lms_designation_id',1)
       ->get();
     //total students enrolled
       $totalstudents=DB::table('lms_student_course_mapping')->count();
     //total no of courses
     $totalcourses=DB::table('lms_child_course')->where('lms_child_course_is_active',1)->count();
     //total no of streams
     $totalstreams=DB::table('lms_course')->where('lms_course_is_active',1)->count();
     //testimonials
     $testimonials=DB::table('lms_testimonials')->select('*')->where('lms_testimonials.status',1)->get();
     //gallery
     $gallery=DB::table('lms_gallery')->select('*')->where('lms_gallery_status',1)->get();
        return view('index',['stream'=>$stream,'storagePath'=>$path,'courses'=>$courses,'trendingcourses'=>$trendingcourses
    ,'instructors'=>$instructors,'staffImagePath'=>$staffImagePath,'totalstudents'=>$totalstudents,'totalcourses'=>$totalcourses,
   'totalstreams'=>$totalstreams,'testimonials'=>$testimonials,'testimonialsImagePath'=>$testimonialsImagePath,'gallery'=>$gallery]);
    }


}
