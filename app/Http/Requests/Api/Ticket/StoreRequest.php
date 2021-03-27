<?php

namespace App\Http\Requests\Api\Ticket;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Ticket\TicketResource;
use App\Models\Ticket;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed title
 * @property mixed message
 * @property mixed email
 * @property mixed name
 */
class StoreRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'title'=>'required|string',
            'message'=>'required',
            'attachment'=>'sometimes|mimes:jpeg,jpg,png'
        ];
    }
    public function run(): JsonResponse
    {
        $Ticket =new  Ticket();
        if (auth('api')->check()) {
            $logged = auth('api')->user();
            $Ticket->setUserId($logged->getId());
            $Ticket->setName($logged->getName());
            $Ticket->setEmail($logged->getEmail());
        }else{
            if (!$this->filled('name')){
                return $this->failJsonResponse([__('validation.required', ['attribute' => __('crud.Ticket.name')])]);
            }
            if (!$this->filled('email')){
                return $this->failJsonResponse([__('validation.required', ['attribute' => __('crud.Ticket.email')])]);
            }
            $Ticket->setName($this->name);
            $Ticket->setEmail($this->email);
        }
        $Ticket->setTitle($this->title);
        $Ticket->setMessage($this->message);
        if($this->hasFile('attachment')) {
            $Ticket->setAttachment($this->file('attachment'));
        }
        $Ticket->save();
        return $this->successJsonResponse([__('messages.saved_successfully')],new TicketResource($Ticket),'Ticket');
    }
}
