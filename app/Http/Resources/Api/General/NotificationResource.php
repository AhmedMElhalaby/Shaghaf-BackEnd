<?php

namespace App\Http\Resources\Api\General;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $Objects['title'] = (app()->getLocale() == 'ar')?$this->getTitleAr():$this->getTitle();
        $Objects['message'] = (app()->getLocale() == 'ar')?$this->getMessageAr():$this->getMessage();
        $Objects['ref_id'] = $this->getRefId();
        $Objects['type'] = $this->getType();
        $Objects['read_at'] = ($this->getReadAt())?Carbon::parse($this->getReadAt())->format('Y-m-d h:i A'):null;
        $Objects['created_at'] = ($this->created_at)?Carbon::parse($this->created_at)->format('Y-m-d h:i A'):null;
        return $Objects;
    }
}
