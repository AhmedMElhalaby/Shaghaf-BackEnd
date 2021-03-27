<?php

namespace App\Http\Requests\Api\Notification;

use App\Http\Requests\Api\ApiRequest;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class ReadAllRequest extends ApiRequest
{
    public function run(): JsonResponse
    {
        Notification::where('user_id',auth()->user()->getId())->where('read_at',null)->update(array('read_at'=>now()));
        return $this->successJsonResponse([__('messages.updated_successful')]);
    }
}
