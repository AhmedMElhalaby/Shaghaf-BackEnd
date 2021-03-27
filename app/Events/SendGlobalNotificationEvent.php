<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendGlobalNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $notification;

    public function __construct($notification)
    {
        $this->notification = $notification;
        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn(): Channel
    {
        return new Channel('online');
    }

    public function broadcastAs(): string
    {
        return 'SendGlobalNotificationEvent';
    }
}
