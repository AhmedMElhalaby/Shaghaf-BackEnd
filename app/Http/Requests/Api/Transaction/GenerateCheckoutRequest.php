<?php

namespace App\Http\Requests\Api\Transaction;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Transaction\TransactionResource;
use App\Models\Transaction;
use App\Traits\ResponseTrait;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed value
 * @property mixed payment_token
 */
class GenerateCheckoutRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'value'=>'required|numeric',
            'payment_type'=>'required|in:'.Constant::PAYMENT_TYPES_RULES
        ];
    }
    public function run(): JsonResponse
    {
        $Object = new Transaction();
        $Object->setType(Constant::TRANSACTION_TYPES['Deposit']);
        $Object->setValue($this->value);
        $Object->setStatus(Constant::TRANSACTION_STATUS['Pending']);
        $Object->setPaymentToken('');
        $Object->setPaymentType($this->payment_type);
        $Object->setUserId(auth()->user()->getId());
        $Object->save();
        $Object->refresh();
        $id = Functions::GenerateCheckout($this->value,$this->payment_type,$Object->getId());
        if($id['status']){
            $Object->setPaymentToken($id['id']);
            $Object->save();
            return $this->successJsonResponse([],new TransactionResource($Object),'Transaction');
        }else{
            $Object->delete();
            return $this->failJsonResponse([$id['message']]);
        }
    }
}
