<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed device_token
 * @property mixed device_type
 */
class LoginRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'mobile' => 'required|numeric',
            'password' => 'required|string',
            'device_token' => 'string|required_with:device_type',
            'device_type' => 'string|required_with:device_token',
        ];
    }
    public function run(): JsonResponse
    {
        $credentials = request(['mobile', 'password']);
        if (!Auth::attempt($credentials))
            return $this->failJsonResponse([__('auth.failed')]);
        $user = $this->user();
        DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        if ($this->input('device_token')) {
            $user->device_token = $this->device_token;
            $user->device_type = $this->device_type;
            $user->save();
        }
        return $this->successJsonResponse( [__('auth.login')], new UserResource($user,$tokenResult->accessToken),'User');
    }
}
