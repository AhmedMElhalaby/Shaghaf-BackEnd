<?php

namespace App\Http\Requests\Api\Transaction;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Transaction\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed transaction_id
 * @property mixed type
 */
class CheckPaymentRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'transaction_id'=>'required|exists:transactions,id',
        ];
    }
    public function run(): JsonResponse
    {
        $Object = (new Transaction)->find($this->transaction_id);
        $Response = Functions::CheckPayment($Object->getPaymentToken(),$Object->getPaymentType());
        if(!$Response['status']){
            return $this->failJsonResponse([__('messages.not_paid_yet')],500,$Response['response']);
        }
        $Object->setStatus(Constant::TRANSACTION_STATUS['Paid']);
        $Object->save();
        return $this->successJsonResponse([],new TransactionResource($Object),'Transaction');
    }
}
