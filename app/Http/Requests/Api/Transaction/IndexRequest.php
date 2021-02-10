<?php

namespace App\Http\Requests\Api\Transaction;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Transaction\TransactionResource;
use App\Models\Transaction;
use App\Traits\ResponseTrait;

class IndexRequest extends ApiRequest
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
        $Objects = Transaction::where('user_id',auth()->user()->getId())->orderBy('created_at','desc')->paginate($this->per_page?:10);
        return $this->successJsonResponse([],TransactionResource::collection($Objects->items()),'Transactions',$Objects);
    }
}
