<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed mobile
 * @property mixed password
 * @property mixed code
 */
class ResetPasswordRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'mobile' => 'required|numeric|exists:users,mobile',
            'code' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
    public function run(): JsonResponse
    {
        $user = User::where('mobile',$this->mobile)->first();
        $passwordReset = PasswordReset::where('user_id',$user->getId())->first();
        if($passwordReset && $passwordReset->code == $this->code){
            $user->setPassword($this->password);
            $user->save();
            DB::table('oauth_access_tokens')
                ->where('user_id', $user->id)
                ->delete();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();
            return $this->successJsonResponse( [__('messages.updated_successful')],new UserResource($user,$tokenResult->accessToken),'User');
        }
        else{
            return $this->failJsonResponse( [__('auth.code_not_correct')]);
        }
    }
}
