<?php

namespace App\Http\Resources\Api\Chat;

use App\Http\Resources\Api\Home\UserResource;
use App\Models\ChatRoomUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $MCRU = ChatRoomUser::where('user_id',auth()->user()->getId())->where('chat_room_id',$this->getId())->first();
        $Objects['unread_messages'] = $MCRU->getUnreadMessages();
        $Objects['latest_user_id'] = $this->getLatestUserId();
        $Objects['latest_message'] = $this->getLatestMessage();
        $Objects['latest_type'] = $this->getLatestType();
        $CRU = ChatRoomUser::where('user_id','!=',auth()->user()->getId())->where('chat_room_id',$this->getId())->first();
        $Objects['User'] = new UserResource($CRU->user);
        $Objects['last_update'] = Carbon::parse($this->updated_at)->diffForHumans();
        $Objects['last_update_formatted'] = Carbon::parse($this->updated_at)->format('Y-m-d H:i:s');
        return $Objects;
    }
}
