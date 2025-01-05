<?php

namespace App\Models;

class Courses extends Table
{
    //
    public static $condition = ["courses.del_flag" => UNDEL];
    public  $fillable = ["name_course", "teacher_id"];
    public static $redis_key = "table_course_";

    public function teacher(){
        return $this->hasOne(Users::class,"id","teacher_id");
    }

    public function student(){
        return $this->hasManyThrough(
            Users::class,
            CourseDetail::class,
            "course_id",
            "id",
            "id",
            "student_id"
        );
    }
}
