<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $fillable = [
        'user_like',
        'idea_id',
    ];

}
