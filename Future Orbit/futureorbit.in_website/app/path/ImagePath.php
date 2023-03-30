<?php
/**
 * Created by PhpStorm.
 * User: Laravel
 * Date: 21-04-2022
 * Time: AM 11:45
 */

namespace App\path;


class ImagePath
{
     public function storage_path()
     {
       $path="http://app2.futureorbit.in/public/storage/course_images/";

        return $path;

     }

     public function staff_storage_path()
     {
       $path="http://app2.futureorbit.in/public/storage/user_profile_images/";

        return $path;

     }

     public function testimonials_image()
     {
       $path="http://app2.futureorbit.in/public/storage/company_images/";

        return $path;

     }
}
