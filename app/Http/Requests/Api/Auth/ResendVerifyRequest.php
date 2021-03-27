<?php

namespace App\Http\Requests\Api\Auth;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use Illuminate\Http\JsonResponse;

class ResendVerifyRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'type'=>'required|in:'.Constant::VERIFICATION_TYPE_RULES
        ];
    }
    public function run(): JsonResponse
    {
        $logged = auth('api')->user();
        return Functions::SendVerification($logged,$this->type);
    }
}
