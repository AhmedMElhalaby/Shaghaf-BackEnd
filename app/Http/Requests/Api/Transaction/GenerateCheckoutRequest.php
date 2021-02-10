<?php

namespace App\Http\Requests\Api\Transaction;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Transaction\TransactionResource;
use App\Models\Transaction;
use App\Traits\ResponseTrait;

class GenerateCheckoutRequest extends ApiRequest
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
            'value'=>'required|numeric',
            'payment_token'=>'required'
        ];
    }

    public function persist()
    {
        $Object = new Transaction();
        $Object->setType(Constant::TRANSACTION_TYPES['Deposit']);
        $Object->setValue($this->value);
        $Object->setStatus(Constant::TRANSACTION_STATUS['Pending']);
        $Object->setPaymentToken($this->payment_token);
        $Object->setUserId(auth()->user()->getId());
        $Object->save();
        return $this->successJsonResponse([],new TransactionResource($Object),'Transaction');
    }
}
