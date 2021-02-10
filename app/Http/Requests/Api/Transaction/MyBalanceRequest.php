<?php

namespace App\Http\Requests\Api\Transaction;

use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Traits\ResponseTrait;

class MyBalanceRequest extends ApiRequest
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
        ];
    }

    public function persist()
    {
        return $this->successJsonResponse([],Functions::UserBalance(auth()->user()->getId()),'Balance');
    }
}
