<?php

namespace App\Http\Requests\Api\Transaction;

use App\Http\Requests\Api\ApiRequest;
use App\Models\RefundRequest;
use App\Traits\ResponseTrait;

class RequestRefundRequest extends ApiRequest
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
        $logged = auth()->user();
        $Object = new RefundRequest();
        $Object->setUserId($logged->getId());
        $Object->save();
        return $this->successJsonResponse([__('messages.saved_successfully')]);
    }
}
