<?php

namespace App\Http\Resources\Api\Home;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $Objects['name'] = (app()->getLocale() == 'ar')?$this->getNameAr():$this->getName();
        $Objects['country_code'] = $this->getCountryCode();
        $Objects['flag'] = asset($this->getFlag());
        $Objects['Cities'] = CityResource::collection($this->cities);
        return $Objects;
    }
}
