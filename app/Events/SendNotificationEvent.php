<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $notification;
    public $user_id;

    public function __construct($notification,$user_id)
    {
        $this->notification = $notification;
        $this->user_id = $user_id;
        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn(): Channel
    {
        return new Channel('online.'.$this->user_id);
    }

    public function broadcastAs(): string
    {
        return 'SendNotificationEvent';
    }
}
