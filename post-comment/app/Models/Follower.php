<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $table = "follower";
    public $fillable = ["user_id","user_follow"];
}
