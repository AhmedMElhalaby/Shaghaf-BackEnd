<?php

namespace App\Http\Requests\Api\Transaction;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;

class MyBalanceRequest extends ApiRequest
{
    public function run(): JsonResponse
    {
        $AvailableBalance = Functions::UserBalance(auth()->user()->id);
        $HoldBalance = Transaction::where('user_id',auth()->user()->id)->where('type',Constant::TRANSACTION_TYPES['Holding'])->sum('value');
        $Balance = [
            'AvailableBalance'=>$AvailableBalance,
            'HeldBalance'=>$HoldBalance,
            'TotalBalance'=>$AvailableBalance+$HoldBalance
        ];
        return $this->successJsonResponse([],$Balance,'Balance');
    }
}
