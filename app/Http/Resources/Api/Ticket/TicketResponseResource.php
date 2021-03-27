<?php

namespace App\Http\Resources\Api\Ticket;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResponseResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $Objects['response'] = $this->getResponse();
        $Objects['sender_type'] = $this->getSenderType();
        return $Objects;
    }
}
