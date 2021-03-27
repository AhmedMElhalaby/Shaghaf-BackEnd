<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed code
 * @property mixed mobile
 */
class CheckResetCodeRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'mobile' => 'required|numeric|exists:users,mobile',
            'code' => 'required|string',
        ];
    }
    public function run(): JsonResponse
    {
        $user = User::where('mobile',$this->mobile)->first();
        $passwordReset = PasswordReset::where('user_id',$user->getId())->first();
        if($passwordReset &&$passwordReset->code == $this->code){
            return $this->successJsonResponse( [__('auth.code_correct')]);
        }
        else{
            return $this->failJsonResponse( [__('auth.code_not_correct')]);
        }
    }
}
