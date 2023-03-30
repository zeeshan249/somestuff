<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailSettingModel extends Model
{
    protected $primaryKey = "lms_email_setting_id";
    protected $table = "lms_email_setting";
    public $timestamps = false;
}
