<?php

namespace App\Http\Requests\Api\Order;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Order\OrderResource;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed order_id
 * @property mixed rate
 * @property mixed review
 */
class ReviewRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'order_id'=>'required|exists:orders,id',
            'rate'=>'required|numeric',
            'review'=>'string'
        ];
    }

    public function run(): JsonResponse
    {
        $Order = (new Order())->find($this->order_id);
        $Freelancer = (new User())->find($Order->getFreelancerId());
        $Object = new Review();
        $Object->setOrderId($Order->getId());
        $Object->setRate($this->rate);
        $Object->setReview($this->review);
        $Object->save();
        $OrderIds = (new Order())->where('freelancer_id',$Freelancer->getId())->pluck('id');
        $Rate = (new Review())->whereIn('order_id',$OrderIds)->avg('rate');
        $Freelancer->setRate($Rate);
        $Freelancer->save();
        return $this->successJsonResponse([],new OrderResource($Order),'Order');
    }
}
