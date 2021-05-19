<?php

namespace App\Http\Requests\Api\Order;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Order\OrderResource;
use App\Models\Discount;
use App\Models\DiscountHistory;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed product_id
 * @property mixed quantity
 * @property mixed note
 * @property mixed delivered_date
 * @property mixed delivered_time
 */
class StoreRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'delivered_date'=>'required|date',
            'delivered_time'=>'required',
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|numeric',
            'note'=>'sometimes|string',
            'home_service'=>'sometimes|boolean',
            'discount_code'=>'sometimes|exists:discounts,code'
        ];
    }

    public function run(): JsonResponse
    {
        $logged = auth()->user();
        if ($logged->getMobileVerifiedAt() == null){
            return $this->failJsonResponse([__('auth.mobile_not_verified')]);
        }
        $delivered_datetime = Carbon::parse($this->delivered_date .' '.$this->delivered_time);
        if (!$delivered_datetime->gt(Carbon::now()->addHour())){
            return $this->failJsonResponse([__('messages.deliver_date_should_be_at_least_hour_from_now')]);
        }

        $Product = (new Product())->find($this->product_id);
        $Total = $this->quantity*$Product->getPrice();
        $Object = new Order();
        if ($this->filled('discount_code')){
            $Discount = (new Discount())->where('code',$this->discount_code)->first();
            if (Functions::CheckDiscountCode($Discount)['status']){
                $Object->setDiscountId($Discount->getId());
                $discount_amount = $Total*$Discount->getValue()/100;
                $Object->setDiscountAmount(($discount_amount < $Discount->getLimit())?$discount_amount:$Discount->getLimit());
            }
        }
        $Object->setUserId(auth()->user()->getId());
        $Object->setFreelancerId($Product->getUserId());
        $Object->setProductId($Product->getId());
        $Object->setPrice($Product->getPrice());
        $Object->setQuantity($this->quantity);
        $Object->setTotal($Total);
        if ($this->filled('home_service')){
            $Object->setHomeService($this->home_service);
        }
        $Object->setDeliveredDate($this->delivered_date);
        $Object->setDeliveredTime($this->delivered_time);
        $Object->setStatus(Constant::ORDER_STATUSES['New']);
        $Object->setNote(@$this->note);
        $Object->save();
        $Object->refresh();
        if ($Object->getDiscountId() != null){
            $DiscountHistory = new DiscountHistory();
            $DiscountHistory->setDiscountId($Object->getDiscountId());
            $DiscountHistory->setOrderId($Object->getId());
            $DiscountHistory->setUserId($Object->getUserId());
            $DiscountHistory->save();
        }
        $Freelancer = (new User)->find($Product->getUserId());
        $Freelancer->setOrderCount($Freelancer->getOrderCount()+1);
        $Freelancer->save();
        Functions::ChangeOrderStatus($Object->getId(),Constant::ORDER_STATUSES['New']);
        Functions::SendNotification($Object->freelancer,'New Order','You have new order !','طلب جديد','لديك طلب جديد !',$Object->getId(),Constant::NOTIFICATION_TYPE['Order'],true);
        return $this->successJsonResponse([__('messages.created_successful')],new OrderResource($Object),'Order');

    }
}
