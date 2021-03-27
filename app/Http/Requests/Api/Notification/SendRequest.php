<?php

namespace App\Http\Requests\Api\Notification;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\General\NotificationResource;
use App\Models\Notification;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed user_id
 * @property mixed title
 * @property mixed message
 */
class SendRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'title'=>'required|string',
            'message'=>'required|string',
            'user_id'=>'required|exists:users,id'
        ];
    }

    public function run(): JsonResponse
    {
        $User = (new User)->find($this->user_id);
        Functions::SendNotification($User,$this->title,$this->message,$this->title,$this->message,auth()->user()->getId(),Constant::NOTIFICATION_TYPE['Message'],false);
        return $this->successJsonResponse([__('messages.created_successful')]);
    }
}
