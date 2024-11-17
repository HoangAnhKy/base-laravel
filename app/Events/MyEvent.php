<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MyEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $userID;
    public function __construct($message, $id)
    {
        $this->message = $message;
        $this->userID = $id;
    }

    public function broadcastOn()
    {
//        return ['my-channel']; //public
        return new PrivateChannel('App.Models.User.' . $this->userID);
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
