<?php

namespace App\Http\Requests\Api\Notification;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\General\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class ReadRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'notification_id'=>'required|exists:notifications,id',
        ];
    }

    public function run(): JsonResponse
    {
        $Notification = Notification::where('user_id',auth()->user()->getId())->where('id',$this->notification_id)->first();
        if($Notification){
            $Notification->update(array('read_at'=>now()));
            return $this->successJsonResponse([__('messages.updated_successful')],new NotificationResource($Notification),'Notification');
        }
        return $this->failJsonResponse([__('messages.object_not_found')]);
    }
}
