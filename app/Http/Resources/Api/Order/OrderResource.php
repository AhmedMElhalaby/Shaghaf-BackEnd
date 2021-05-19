<?php

namespace App\Http\Resources\Api\Order;

use App\Helpers\Functions;
use App\Http\Resources\Api\Product\ProductResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Home\FreelancerResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        $Objects = array();
        $Objects['id'] = $this->getId();
        $Objects['user_id'] = $this->getUserId();
        $Objects['User'] = new FreelancerResource($this->user);
        $Objects['product_id'] = $this->getProductId();
        $Objects['Product'] = new ProductResource($this->product);
        $Objects['freelancer_id'] = $this->getFreelancerId();
        $Objects['Freelancer'] = new FreelancerResource($this->freelancer);
        $Objects['quantity'] = $this->getQuantity();
        $Objects['price'] = $this->getPrice();
        $Objects['amount'] = $this->getTotal();
        $Objects['discount_amount'] = $this->getDiscountAmount();
        $Objects['total'] = $this->getTotal() -$this->getDiscountAmount();
        $UserBalance = Functions::UserBalance($this->getUserId());
        if ($UserBalance >= $Objects['total']) {
            $balance = 0;
        }else{
            $balance = $Objects['total'] - $UserBalance;
        }
        $Objects['balance'] = $balance;
        $Objects['order_date'] = Carbon::parse($this->created_at);
        $Objects['delivered_date'] = $this->getDeliveredDate();
        $Objects['delivered_time'] = $this->getDeliveredTime();
        $Objects['home_service'] = $this->getHomeService();
        $Objects['reject_reason'] = $this->getRejectReason();
        $Objects['cancel_reason'] = $this->getCancelReason();
        $Objects['rate'] = $this->reviews()->avg('rate')??'0';
        $Objects['status'] = $this->getStatus();
        $Objects['note'] = $this->getNote();
        $Objects['status_str'] = __('crud.Order.Statuses.'.$this->getStatus());
        $Objects['OrderStatuses'] = OrderStatusResource::collection($this->order_statuses);
        return $Objects;
    }
}
