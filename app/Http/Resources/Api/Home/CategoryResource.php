<?php

namespace App\Http\Resources\Api\Home;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $Objects['name'] = (app()->getLocale() == 'ar')?$this->getNameAr():$this->getName();
        $Objects['description'] = (app()->getLocale() == 'ar')?$this->getDescriptionAr():$this->getDescription();
        $Objects['image'] = asset($this->getImage());
        $Objects['has_product'] = $this->getHasProduct();
        $Objects['has_service'] = $this->getHasService();
        $Objects['home_service'] = $this->getHomeService();
        $Objects['user_type'] = $this->getUserType();
        $Objects['SubCategories'] = CategoryResource::collection($this->sub_categories);
        return $Objects;
    }
}
