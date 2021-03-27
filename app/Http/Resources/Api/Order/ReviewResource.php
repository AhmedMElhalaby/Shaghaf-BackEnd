<?php

namespace App\Http\Resources\Api\Order;

use App\Helpers\Constant;
use App\Http\Resources\Api\Home\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['review'] = $this->getReview();
        $Objects['rate'] = $this->getRate();
        $Objects['User'] = new UserResource($this->order->user);
        $Objects['created_at'] = Carbon::parse($this->created_at)->format('Y-m-d h:i A');
        return $Objects;
    }
}
