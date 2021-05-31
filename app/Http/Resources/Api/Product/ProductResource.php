<?php

namespace App\Http\Resources\Api\Product;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $Objects['name'] = $this->getName();
        $Objects['description'] = $this->getDescription();
        $Objects['category_id'] = $this->getCategoryId();
        $Objects['category_name'] = Category::where('id', $this->getCategoryId())->first()->name;
        $Objects['home_service'] = Category::where('id', $this->getCategoryId())->first()->home_service;
        $Objects['sub_category_id'] = $this->getSubCategoryId();
        $Objects['price'] = $this->getPrice();
        $Objects['type'] = $this->getType();
        $Objects['is_active'] = $this->isIsActive();
        $Objects['first_image'] = ($this->media()->first())->getFile();
        $Objects['Media'] = MediaResource::collection($this->media);
        return $Objects;
    }
}
