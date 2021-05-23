<?php

namespace App\Http\Resources\Api\Ticket;

use Carbon\Carbon;
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
        $Objects['status_str'] = __('crud.Ticket.Statuses.'.$this->getStatus());
        $Objects['created_at'] = Carbon::parse($this->created_at)->diffForHumans();
        $Objects['TicketResponses'] = TicketResponseResource::collection($this->ticket_responses);
        return $Objects;
    }
}
