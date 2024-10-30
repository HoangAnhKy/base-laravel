<?php

namespace App\Models;

class CourseDetail extends Table
{
    public static $condition = ["course_details.del_flag" => UNDEL];
    public  $fillable = ["course_id", "student_id", "create_by", "update_by"];

    public function course(){
        return $this->belongsTo(Courses::class, "course_id");
    }

    public function student(){
        return $this->hasMany(Users::class, "id", "student_id");
    }
}
