<?php

namespace App\Http\Resources\Api\Ticket;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResponseResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $Objects['response'] = $this->getResponse();
        $Objects['sender_type'] = $this->getSenderType();
        $Objects['created_at'] = Carbon::parse($this->created_at)->diffForHumans();
        return $Objects;
    }
}
