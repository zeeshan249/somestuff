<?php

namespace App;

use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    protected $primaryKey = "lms_user_id";
    protected $table = "lms_user";
    public $timestamps = false;
    protected $guard_name = 'api';

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // To Change password
    public static function loggedUserChangePassword($centerId,
        $oldPassword, $newPassword, $loggedUserId) {
        try {
            $getQuery = DB::table('lms_user')
                ->where('lms_user_id', '=', $loggedUserId)
                ->where('lms_center_id', '=', $centerId)
                ->select(['password'])
                ->first();
            $bcryptPassword = $getQuery->password;
            if (password_verify($oldPassword, $bcryptPassword)) {

                DB::table('lms_user')
                    ->where('lms_user_id', $loggedUserId)
                    ->where('lms_center_id', '=', $centerId)
                    ->update([
                        'password' => bcrypt($newPassword),
                        'password_normal' => $newPassword,

                    ]);

                $resultData['responseData'] = "1";
            } else {
                $resultData['responseData'] = "2";
            }
        } catch (Exception $ex) {
            $resultData['responseData'] = "2";
        }

        return $resultData;
    }
}
