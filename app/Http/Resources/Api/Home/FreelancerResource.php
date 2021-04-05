<?php

namespace App\Http\Resources\Api\Home;

use App\Models\Category;
use App\Models\FreelancerCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class FreelancerResource extends JsonResource
{
    public function toArray($request): array
    {
        $Object['id'] = $this->getId();
        $Object['name'] = ($this->getCompanyName())?$this->getCompanyName():$this->getName();
        $Object['mobile'] = $this->getMobile();
        $Object['country_id'] = $this->getCountryId();
        $Object['city_id'] = $this->getCityId();
        $Object['Country'] = new CountryResource($this->country);
        $Object['City'] = new CityResource($this->city);
        $Object['email'] = $this->getEmail();
        $Object['bio'] = $this->getBio();
        $Object['gender'] = $this->getGender();
        $Object['avatar'] = $this->getAvatar()?asset($this->getAvatar()):asset('default.png');
        $Object['lat'] = $this->getLat();
        $Object['lng'] = $this->getLng();
        $Object['rate'] = $this->getRate();
        $Object['is_available'] = $this->getIsAvailable();
        $Object['Categories'] = CategoryListResource::collection(Category::whereIn('id',FreelancerCategory::where('user_id',$this->getId())->pluck('category_id'))->get());
        return $Object;
    }

}
