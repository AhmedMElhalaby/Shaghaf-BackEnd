<?php

namespace App\Http\Requests\Api\Transaction;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Transaction\TransactionResource;
use App\Models\Transaction;
use App\Traits\ResponseTrait;

class CheckPaymentRequest extends ApiRequest
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
            'transaction_id'=>'required|exists:transactions,id',
            'type'=>'required|in:'.Constant::PAYMENT_METHOD_RULES
        ];
    }

    public function persist()
    {
        $Object = (new Transaction)->find($this->transaction_id);
        $Response = Functions::CheckPayment($this->type,$Object->getPaymentToken());
        if(!$Response){
            return $this->failJsonResponse([__('messages.not_paid_yet')]);
        }
        $Object->setStatus(Constant::TRANSACTION_STATUS['Paid']);
        $Object->save();
        return $this->successJsonResponse([],new TransactionResource($Object),'Transaction');
    }
}
