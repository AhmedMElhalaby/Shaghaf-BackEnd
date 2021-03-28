<?php

namespace App\Http\Resources\Api\Chat;

use App\Helpers\Constant;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomMessageResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $Objects['chat_room_id'] = $this->getChatRoomId();
        $message = $this->getMessage();
        if ($this->getType() != Constant::CHAT_MESSAGE_TYPE['Text']){
            $message = asset($this->getMessage());
        }
        $Objects['message'] = $message;
        $Objects['type'] = $this->getType();
        $Objects['user_id'] = $this->getUserId();
        $Objects['read_at'] = $this->getReadAt();
        $Objects['user_name'] = $this->user->getName();
        $Objects['created_at'] = Carbon::parse($this->created_at)->diffForHumans();
        $Objects['created_at_formatted'] = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
        return $Objects;
    }
}
