<?php

namespace App\Library;

use App\Models\notification;

class NotificationLibrary
{
    public function getNotification(){
        return notification::selectALL(["user_id" => auth()->id()], [],[],[["created_at", "DESC"]]) ?? [];
    }

    public function readNotification($data_request = []){
        if (!empty($data_request)){
            $notification = notification::find($data_request["id"]);

            if (!empty($notification) && notification::updateDB(["id" => $data_request["id"]], ["status" => READ])){
                return $notification->link;
            }
        }
        return false;
    }
}
