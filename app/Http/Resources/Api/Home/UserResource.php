<?php

namespace App\Http\Resources\Api\Home;

use App\Models\Category;
use App\Models\FreelancerCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        $Object['id'] = $this->getId();
        $Object['name'] = $this->getName();
        $Object['mobile'] = $this->getMobile();
        $Object['email'] = $this->getEmail();
        $Object['bio'] = $this->getBio();
        $Object['gender'] = $this->getGender();
        $Object['avatar'] = $this->getAvatar()?asset($this->getAvatar()):asset('default.png');
        $Object['lat'] = $this->getLat();
        $Object['lng'] = $this->getLng();
        $Object['rate'] = $this->getRate();
        return $Object;
    }

}
