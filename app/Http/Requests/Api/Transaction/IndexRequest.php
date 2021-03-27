<?php

namespace App\Http\Requests\Api\Transaction;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Transaction\TransactionResource;
use App\Models\Transaction;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed per_page
 */
class IndexRequest extends ApiRequest
{
    public function run(): JsonResponse
    {
        $Objects = Transaction::where('user_id',auth()->user()->getId())->orderBy('created_at','desc')->paginate($this->per_page?:10);
        return $this->successJsonResponse([],TransactionResource::collection($Objects->items()),'Transactions',$Objects);
    }
}
