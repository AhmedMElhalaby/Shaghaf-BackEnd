<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn(): Channel
    {
        return new Channel('chat_room.'.$this->message->chat_room_id.'.new_message');
    }

    public function broadcastAs(): string
    {
        return 'CreateMessageEvent';
    }
}
