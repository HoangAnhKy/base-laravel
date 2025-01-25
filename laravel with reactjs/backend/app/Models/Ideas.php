<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ideas extends Model
{
    public $guarded = [];
    public $appends = ["display_created_at"];

    public function user()
    {
        return $this->belongsTo(User::class, "user_post", "id");
    }

    public function comment()
    {
        return $this->hasMany(Comments::class, "idea_id", "id");
    }

    public function getDisplayCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
