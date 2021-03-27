<?php

namespace App\Http\Requests\Api\Ticket;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Ticket\TicketResource;
use App\Models\Ticket;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed ticket_id
 */
class ShowRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'ticket_id'=>'required|exists:tickets,id'
        ];
    }
    public function run(): JsonResponse
    {
        return $this->successJsonResponse([],new TicketResource((new  Ticket())->find($this->ticket_id)),'Ticket');
    }
}
