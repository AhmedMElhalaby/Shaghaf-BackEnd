<?php

namespace App\Http\Requests\Api\Chat;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Chat\ChatRoomResource;
use App\Models\ChatRoom;
use App\Models\ChatRoomUser;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed per_page
 * @property mixed user_id
 */
class CreateRoomRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'user_id'=>'required|exists:users,id',
        ];
    }
    public function run(): JsonResponse
    {
        $logged = auth()->user()->getId();
        $LRoomsId = ChatRoomUser::where('user_id',$logged)->pluck('chat_room_id')->toArray();
        $URoomsId = ChatRoomUser::where('user_id',$this->user_id)->pluck('chat_room_id')->toArray();
        $similarity = array_intersect($LRoomsId,$URoomsId);
        if (empty($similarity)) {
            $Object = new ChatRoom();
            $Object->save();
            $Object->refresh();
            $UObject = new ChatRoomUser();
            $UObject->setUserId($logged);
            $UObject->setChatRoomId($Object->getId());
            $UObject->save();
            $LObject = new ChatRoomUser();
            $LObject->setUserId($this->user_id);
            $LObject->setChatRoomId($Object->getId());
            $LObject->save();
        }else {
            $Object = (new ChatRoom())->whereIn('id',$similarity)->first();
        }
        return $this->successJsonResponse([],new ChatRoomResource($Object),'ChatRoom');

    }
}
