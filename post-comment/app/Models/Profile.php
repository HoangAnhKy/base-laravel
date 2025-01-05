<?php

namespace App\Models;

use Illuminate\Container\Attributes\Storage;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = "profile";
    public $fillable = ["user_id", "content", "url_img"];

    public function getViewImgAttribute()
    {
        if (isset($this->url_img)){
            return url($this->url_img);
        }
        return "https://api.dicebear.com/6.x/fun-emoji/svg?seed=Mario";
    }
}
