<?php

namespace App\Http\Controllers;

use App\Library\NotificationLibrary;
use Illuminate\Support\Facades\View;

abstract class Controller
{
    public function __construct()
    {
        $notification = new NotificationLibrary();

        $list_notification = $notification->getNotification();
        $count_notification = $list_notification->where("status", UNREAD)->count();
        View::share(compact("list_notification", "count_notification"));
    }
}
