<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\User\UserResource;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed device_token
 * @property mixed device_type
 */
class RefreshRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'device_type' => 'required|string',
            'device_token' => 'required|string'
        ];
    }
    public function run(): JsonResponse
    {
        $logged = $this->user();
        $logged->setDeviceToken($this->device_token);
        $logged->setDeviceType($this->device_type);
        $logged->save();
        $logged->token()->revoke();
        $logged->token()->delete();
        $tokenResult = $logged->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return $this->successJsonResponse( [__('messages.updated_successful')],new UserResource($logged,$tokenResult->accessToken),'User');
    }
}
