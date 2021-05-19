<?php

namespace App\Http\Resources\Api\Home;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $Objects['code'] = $this->getCode();
        $Objects['use_times'] = $this->getUseTimes();
        $Objects['expire_date'] = $this->getExpireDate();
        $Objects['value'] = $this->getValue();
        $Objects['limit'] = $this->getLimit();
        return $Objects;
    }
}
