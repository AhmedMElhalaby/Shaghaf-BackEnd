<?php

namespace App\Http\Requests\Api\Home;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Models\User;
use App\Traits\ResponseTrait;

class SendNotificationRequest extends ApiRequest
{
    use ResponseTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'=>'required|exists:users,id',
            'title'=>'required|string',
            'message'=>'required|string',
        ];
    }
    public function persist()
    {
        $User = (new User)->find($this->user_id);
        Functions::SendNotification($User,$this->title,$this->message,$this->title,$this->message,null,auth()->user()->getId(),Constant::NOTIFICATION_TYPE['Chat'],false);
        return $this->successJsonResponse([__('messages.saved_successfully')]);
    }
}










