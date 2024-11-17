<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notification extends Table
{
    public static $condition = [];
    public  $fillable = ["link", "messenger", "user_id"];
    public static $redis_key = "table_course_";
}
