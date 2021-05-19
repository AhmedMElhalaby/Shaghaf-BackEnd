<?php

namespace App\Http\Requests\Api\Home;

use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Home\DiscountResource;
use App\Models\Discount;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed discount_code
 */
class CheckDiscountCodeRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'discount_code'=>'required|exists:discounts,code',
        ];
    }
    public function run(): JsonResponse
    {
        $Discount = (new Discount())->where('code',$this->discount_code)->first();
        $Check = Functions::CheckDiscountCode($Discount);
        if (!$Check['status']){
            return $this->failJsonResponse([$Check['msg']]);
        }
        return $this->successJsonResponse([],new DiscountResource($Discount),'Discount');
    }
}
