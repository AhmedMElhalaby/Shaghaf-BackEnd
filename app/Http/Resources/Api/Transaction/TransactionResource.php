<?php

namespace App\Http\Resources\Api\Transaction;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $Objects = array();
        $Objects['id'] = $this->id;
        $Objects['type'] = $this->type;
        $Objects['value'] = $this->value;
        $Objects['payment_token'] = $this->getPaymentToken();
        $Objects['status'] = $this->status;
        $Objects['created_at'] = ($this->created_at)?Carbon::parse($this->created_at)->format('Y-m-d h:i A'):null;
        return $Objects;
    }
}
