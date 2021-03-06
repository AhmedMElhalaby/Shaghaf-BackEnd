<?php

namespace App\Http\Requests\Api\Chat;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Chat\ChatRoomMessageResource;
use App\Models\ChatRoomMessage;
use App\Models\ChatRoomUser;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed per_page
 * @property mixed chat_room_id
 */
class MessageRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'chat_room_id'=>'required|exists:chats_rooms,id',
        ];
    }
    public function run(): JsonResponse
    {
        ChatRoomMessage::where('chat_room_id',$this->chat_room_id)->where('user_id','!=',auth()->user()->getId())->where('read_at',null)->update(array('read_at'=>now()));
        ChatRoomUser::where('user_id',auth()->user()->getId())->where('chat_room_id',$this->chat_room_id)->update(array('unread_messages'=>0));
        $Objects = new ChatRoomMessage();
        $Objects = $Objects->where('chat_room_id',$this->chat_room_id);
        $Objects = $Objects->paginate($this->filled('per_page')?$this->per_page:10);
        $Objects = ChatRoomMessageResource::collection($Objects);
        return $this->successJsonResponse([],$Objects->items(),'ChatRoomMessages',$Objects);
    }
}
