<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

/**
 * @property mixed old_password
 * @property mixed password
 */
class PasswordRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'old_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
    public function run(): JsonResponse
    {
        $logged = $this->user();
        if(Hash::check($this->old_password,$logged->password)){
            $logged->setPassword($this->password);
            $logged->save();
            $logged->token()->revoke();
            $logged->token()->delete();
            $tokenResult = $logged->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();
            return $this->successJsonResponse([__('messages.updated_successful')],new UserResource($logged,$tokenResult->accessToken),'User');
        }
        return $this->failJsonResponse([__('auth.password_not_correct')]);
    }
}
