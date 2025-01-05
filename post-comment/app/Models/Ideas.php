<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ideas extends Model
{
    protected $fillable = [
        "content"
    ];

    protected static function booted()
    {
        if (auth()->check()){
            static::creating(function ($model) {
                $model->user_id = auth()->id();
            });
        }
    }

    public function comments(){
        return $this->hasMany(Comments::class, "idea_id", "id");
    }

    public function userPost(){
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function Likes(){
        return $this->hasMany(Likes::class, "idea_id", "id");
    }

    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_like', $userId)->exists();
    }
}
