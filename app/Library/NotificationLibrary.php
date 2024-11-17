<?php

namespace App\Library;

use App\Models\notification;

class NotificationLibrary
{
    public function getNotification(){
        return notification::selectALL(["user_id" => auth()->id(), "status" => UNREAD]) ?? [];
    }
}
