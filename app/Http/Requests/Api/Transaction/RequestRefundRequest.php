<?php

namespace App\Http\Requests\Api\Transaction;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Transaction\TransactionResource;
use App\Models\RequestRefund;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed name
 * @property mixed amount
 * @property mixed address_1
 * @property mixed address_2
 * @property mixed address_3
 * @property mixed iban
 * @property mixed swift_code
 */
class RequestRefundRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name'=>'required|string|max:255',
            'iban'=>'required|string|max:255',
            'swift_code'=>'required|string|max:255',
            'address_1'=>'required|string|max:255',
            'amount'=>'required|numeric',
        ];
    }
    public function run(): JsonResponse
    {
        $logged = auth()->user()->getId();
        $Balance = Functions::UserBalance($logged);
        if ($this->amount > $Balance) {
            return $this->failJsonResponse([__('messages.dont_have_credit')]);
        }
        $RequestRefund = new RequestRefund();
        $RequestRefund->setName($this->name);
        $RequestRefund->setAmount($this->amount);
        $RequestRefund->setUserId($logged);
        $RequestRefund->setAddress1($this->address_1);
        $RequestRefund->setAddress2($this->address_2);
        $RequestRefund->setAddress3($this->address_3);
        $RequestRefund->setIban($this->iban);
        $RequestRefund->setSwiftCode($this->swift_code);
        $RequestRefund->save();
        $RequestRefund->refresh();
        $result = Functions::Payout($this->iban,$this->swift_code,$this->name,$this->amount,$this->address_1,@$this->address_2,@$this->address_3,$RequestRefund->getId());
        if ($result['status']) {
            $RequestRefund->setTokenId($result['token_id']);
            $Transaction = new Transaction();
            $Transaction->setUserId($logged);
            $Transaction->setValue($this->amount);
            $Transaction->setRefId($RequestRefund->getId());
            $Transaction->setType(Constant::TRANSACTION_TYPES['Withdraw']);
            $Transaction->setStatus(Constant::TRANSACTION_STATUS['Paid']);
            $Transaction->setPaymentToken($result['token_id']);
            $Transaction->save();
            $Transaction->refresh();
            $RequestRefund->setTransactionId($Transaction->getId());
            $RequestRefund->save();
            return $this->successJsonResponse([__('messages.saved_successfully')],new TransactionResource($Transaction),'Transaction');
        }else{
            return $this->failJsonResponse([__('messages.wrong_data')]);
        }
    }
}
