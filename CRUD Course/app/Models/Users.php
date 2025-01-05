<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Users extends Table implements AuthenticatableContract
{
    use HasFactory;
    use Authenticatable;

    public $fillable = ["name_user", "birthdate", "email", "password", "position"];
    public static $redis_key = "table_user_";
    public static $condition = ["users.del_flag" => UNDEL];


    public function getformatBirthdateAttribute()
    {
        return ( new \DateTime($this->birthdate))->format("Y-m-d");
    }
}
