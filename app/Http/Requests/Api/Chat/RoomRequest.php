<?php

namespace App\Http\Requests\Api\Chat;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Chat\ChatRoomResource;
use App\Models\ChatRoom;
use App\Models\ChatRoomUser;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed per_page
 */
class RoomRequest extends ApiRequest
{
    public function run(): JsonResponse
    {
        $logged = auth()->user();
        $RoomsId = ChatRoomUser::where('user_id',$logged->getId())->pluck('chat_room_id');
        $Objects = ChatRoom::whereIn('id',$RoomsId)->orderBy('updated_at','desc')->paginate($this->filled('per_page')?$this->per_page:10);
        $Objects = ChatRoomResource::collection($Objects);
        return $this->successJsonResponse([],$Objects->items(),'ChatRooms',$Objects);
    }
}
