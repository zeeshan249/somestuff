<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
class PlayListController extends Controller
{
    public function getPlaylist(){
    $getQuery = DB::table('lms_youtube_video_playlist')
    ->join('lms_subject', 'lms_subject.lms_subject_id', '=', 'lms_youtube_video_playlist.subject_id')
    ->join('lms_topic', 'lms_topic.lms_topic_id', '=', 'lms_youtube_video_playlist.topic_id')
    ->join('lms_course', 'lms_course.lms_course_id', '=', 'lms_youtube_video_playlist.course_id')


   

    ->select('lms_youtube_video_playlist.playlist_id','lms_subject.lms_subject_name','lms_subject.lms_subject_id','lms_topic.lms_topic_name','lms_youtube_video_playlist.topic_id',
    'lms_youtube_video_playlist.playlist_name',
    DB::raw('DATE_FORMAT(lms_youtube_video_playlist.playlist_created_date, "%d-%m-%Y") as playlist_created_date'),
   'lms_youtube_video_playlist.playlist_image_url',
    DB::raw("
    (case when lms_youtube_video_playlist.playlist_status  = '1' then 'Active'
    when       lms_youtube_video_playlist.playlist_status  = '0' then 'Inactive'

    ELSE 'Active' end) as 'playlist_status'"),)

    ->orderBy('lms_youtube_video_playlist.playlist_created_date')

    ->paginate();

    return $getQuery;
    }
    public function getCourseList()
    {

        $getQuery = DB::table('lms_course')
            ->where('lms_course_is_active', '=', 1)
            ->select(['lms_course_id',
                'lms_course_name',
                'lms_course_image',
                'lms_course_description',
                'lms_course_fees',
                'lms_course_code',
            ])
            ->paginate(20);
        return $getQuery;

    }

    
    // Get subject
    public function getSubjectList(Request $request)
    {
        $getQuery = DB::table('lms_subject')
            ->where('lms_subject_is_active', '=', 1)
            ->where('lms_course_id', '=', $request->courseId)
            ->select()
            ->get();
    
        return $getResult;
    }

       // Get Topic
       public function getTopicList(Request $request)
       {
           $getQuery = DB::table('lms_topic')
              
             
               ->where('lms_subject_id', '=', $request->subjectId)
   
               ->select()
               ->get();
      
           return $getQuery;
       }

       public function savePlaylist(Request $request)
       {
      
        if ($request->hasFile('playlist_img_url')) 
        {

           $pn= $request->playlist_name;

            $file = $request->file('playlist_img_url');
            $destinationPath = 'public/playlist_image';
            $filename = Str::random(10).time() . '.' . $file->getClientOriginalExtension();
            $request->file('playlist_img_url')->storeAs($destinationPath, $filename);
            $photo = $filename;
            $comp = DB::table('lms_youtube_video_playlist')->where('playlist_name',$pn)->count();
          
           
              if ($comp > 0) {
                     $result_data['responseData'] = "1";
                }
                else{

             
                     $saveQuery = DB::table('lms_youtube_video_playlist')->insert(
                    [
                        'course_id'=>$request->courseId,
                        'subject_id' => $request->subjectId,
                        'topic_id'=>$request->topicId,
                        'playlist_name' =>$pn,
                        'playlist_created_by'=>$request->loggedUserId,
                        'playlist_status'=>1,
                        'playlist_image_url'=>$photo 
                 
        
                    ]
                );
                if ($saveQuery) {
                         $result_data['responseData'] = "2";
                   }
                 else{
                      $result_data['responseData'] = "3";
                    }
              
                }
                
      
           
            }
            return $result_data;

    }
}
