<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //

    public $guarded = [];

    public $appends = ["display_created_at"];

    public function user()
    {
        return $this->belongsTo(User::class, "user_comment", "id");
    }

    public function idea()
    {
        return $this->belongsTo(Ideas::class, "idea_id", "id");
    }

    public function getDisplayCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
