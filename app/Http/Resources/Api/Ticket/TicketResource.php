<?php

namespace App\Http\Resources\Api\Ticket;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $Objects['title'] = $this->getTitle();
        $Objects['message'] = $this->getMessage();
        $Objects['attachment'] = $this->getAttachment();
        $Objects['status'] = $this->getStatus();
        $Objects['TicketResponses'] = TicketResponseResource::collection($this->ticket_responses);
        return $Objects;
    }
}
