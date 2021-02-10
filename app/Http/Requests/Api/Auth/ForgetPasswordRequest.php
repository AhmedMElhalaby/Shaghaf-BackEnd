<?php

namespace App\Http\Requests\Api\Auth;

use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Traits\ResponseTrait;
use App\Models\User;

/**
 * @property mixed mobile
 */
class ForgetPasswordRequest extends ApiRequest
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
            'mobile' => 'required|numeric|exists:users,mobile',
        ];
    }
    public function persist()
    {
        $user = User::where('mobile',$this->mobile)->first();

        if($user){
            Functions::SendForget($user);
            return $this->successJsonResponse([__('auth.code_sent')] );
        }
        return $this->failJsonResponse([__('messages.object_not_found')]);
    }
}
