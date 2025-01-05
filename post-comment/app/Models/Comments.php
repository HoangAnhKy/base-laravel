<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    public $fillable = ["content_comment", "idea_id"];

    protected static function booted()
    {
        if (auth()->check()){
            static::creating(function ($model) {
                $model->user_id = auth()->id();
            });
        }
    }

    public function userComment(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
