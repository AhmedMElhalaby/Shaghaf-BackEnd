<?php

namespace App\Http\Resources\Api\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $Objects['file'] = $this->getFile();
        return $Objects;
    }
}
