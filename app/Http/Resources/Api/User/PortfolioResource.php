<?php

namespace App\Http\Resources\Api\User;

use App\Helpers\Constant;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $Objects['description'] = $this->getDescription();
        $Objects['type'] = $this->getType();
        $Objects['media'] = ($this->getType() == Constant::PORTFOLIO_MEDIA_TYPE['Image'])?asset($this->getMedia()):$this->getMedia();
        return $Objects;
    }
}
