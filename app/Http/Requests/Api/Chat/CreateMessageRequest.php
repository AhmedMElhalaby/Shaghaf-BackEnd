<?php

namespace App\Http\Requests\Api\Chat;

use App\Events\CreateMessageEvent;
use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Chat\ChatRoomMessageResource;
use App\Models\ChatRoom;
use App\Models\ChatRoomMessage;
use App\Models\ChatRoomUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
use Pusher\PusherException;

/**
 * @property mixed per_page
 * @property mixed chat_room_id
 * @property mixed type
 * @property mixed message
 */
class CreateMessageRequest extends ApiRequest
{
    public function rules(): array
    {
        $rules = [
            'chat_room_id'=>'required|exists:chats_rooms,id',
            'type'=>'required|in:'.Constant::CHAT_MESSAGE_TYPE_RULES,
            'message'=>'required'
        ];
        if ($this->type == Constant::CHAT_MESSAGE_TYPE['Text']) {
            $rules['message'] = 'required';
        }
        if ($this->type == Constant::CHAT_MESSAGE_TYPE['Location']) {
            $rules['message'] = 'required';
        }
        if ($this->type == Constant::CHAT_MESSAGE_TYPE['Image']) {
            $rules['message'] = 'required|mimes:jpeg,jpg,png';
        }
        if ($this->type == Constant::CHAT_MESSAGE_TYPE['Audio']) {
            $rules['message'] = 'required|mimes:wav,mp3,amr,m4a';
        }
        if ($this->type == Constant::CHAT_MESSAGE_TYPE['File']) {
            $rules['message'] = 'required|mimes:pdf,doc,docx,xlsx,csv';
        }
        return $rules;
    }
    public function run(): JsonResponse
    {
        $logged = auth()->user();
        $ChatRoom = (new ChatRoom())->find($this->chat_room_id);
        $Object = new ChatRoomMessage();
        $Object->setChatRoomId($ChatRoom->getId());
        $Object->setUserId($logged->getId());
        $Object->setType($this->type);
        $msg = '';
        $msg_ar = '';
        if ($this->type == Constant::CHAT_MESSAGE_TYPE['Image']) {
            $Object->setMessage(Functions::StoreImage('message','chat/images'));
            $msg = 'Image';
            $msg_ar = 'صورة';
        }
        else if ($this->type == Constant::CHAT_MESSAGE_TYPE['Audio']) {
            $Object->setMessage(Functions::StoreImage('message','chat/audios'));
            $msg = 'Audio';
            $msg_ar = 'مقطع صوتي';
        }
        else if ($this->type == Constant::CHAT_MESSAGE_TYPE['File']) {
            $Object->setMessage(Functions::StoreImage('message','chat/files'));
            $msg = 'File';
            $msg_ar = 'ملف';
        }
        else{
            $Object->setMessage($this->message);
            $msg=$this->message;
            $msg_ar=$this->message;
        }
        $Object->save();
        $Object->refresh();
        $ChatRoom->setLatestMessage($Object->getMessage());
        $ChatRoom->setLatestType($this->type);
        $ChatRoom->setLatestUserId($logged->getId());
        $ChatRoom->save();
        ChatRoomUser::where('user_id','!=',auth()->user()->getId())->where('chat_room_id',$this->chat_room_id)->update(array('unread_messages'=>DB::raw('unread_messages+1')));
        $Object = new ChatRoomMessageResource($Object);
        CreateMessageEvent::dispatch($Object);
        $User = ChatRoomUser::where('chat_room_id',$ChatRoom->getId())->where('user_id','!=',$logged->getId())->first();
        try {
            $pusher = new Pusher('da99af9260d89f306342', 'b527dba1b027166d1f6d', '1161957', array('cluster' => 'ap1'));
            if (!$pusher->get('/channels/online.'.$User->getUserId().'.room.'.$ChatRoom->getId())['result']['occupied']) {
                Functions::SendNotification($User->user,'New Message',$msg,'رسالة جديدة',$msg_ar,$logged->getId(),Constant::NOTIFICATION_TYPE['Message'],false);
            }
        } catch (PusherException $e) {
        }
        return $this->successJsonResponse([],$Object,'ChatRoomMessage');
    }
}
