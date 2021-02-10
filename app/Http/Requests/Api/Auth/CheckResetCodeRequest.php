<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Models\PasswordReset;
use App\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed code
 * @property mixed mobile
 */
class CheckResetCodeRequest extends ApiRequest
{
    use ResponseTrait;


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => 'required|numeric|exists:users,mobile',
            'code' => 'required|string',
        ];
    }
    public function attributes()
    {
        return [];
    }
    public function persist()
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
