<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Http\JsonResponse;
use App\Models\Order;
use App\Traits\ResponseTrait;
use App\Helpers\Constant;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Order\OrderResource;

/**
 * @property mixed per_page
 * @property mixed is_completed
 */
class IndexRequest extends ApiRequest
{
    public function run():JsonResponse
    {
        $logged = auth()->user();
        $Objects = new Order();
        if($logged->getType() == Constant::USER_TYPE['Customer']){
            $Objects = $Objects->where('user_id',$logged->getId());
        }else{
            $Objects = $Objects->where('freelancer_id',$logged->getId());
        }
        if ($this->filled('is_completed') && $this->is_completed) {
            $Objects = $Objects->whereIn('status',Constant::COMPLETED_ORDER_STATUSES);
        }else{
            $Objects = $Objects->whereNotIn('status',Constant::COMPLETED_ORDER_STATUSES);
        }
        $Objects = $Objects->paginate($this->filled('per_page')?$this->per_page:10);
        $Objects = OrderResource::collection($Objects);
        return $this->successJsonResponse([],$Objects->items(),'Orders',$Objects);
    }
}
