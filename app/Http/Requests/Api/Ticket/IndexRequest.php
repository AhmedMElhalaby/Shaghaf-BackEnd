<?php

namespace App\Http\Requests\Api\Ticket;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Ticket\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed per_page
 */
class IndexRequest extends ApiRequest
{
    public function run(): JsonResponse
    {
        $logged = auth()->user();
        $Objects =new  Ticket();
        $Objects = $Objects->where('user_id',$logged->getId());
        $Objects = $Objects->paginate($this->filled('per_page')?$this->per_page:10);
        return $this->successJsonResponse([],TicketResource::collection($Objects->items()),'Tickets',$Objects);
    }
}
