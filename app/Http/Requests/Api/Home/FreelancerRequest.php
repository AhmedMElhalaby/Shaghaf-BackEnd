<?php

namespace App\Http\Requests\Api\Home;

use App\Helpers\Constant;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Home\FreelancerResource;
use App\Models\FreelancerCategory;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed per_page
 * @property mixed category_id
 * @property mixed sub_category_id
 * @property mixed q
 * @property mixed top_orders
 * @property mixed rate
 * @property mixed city_id
 */
class FreelancerRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'category_id' => 'exists:categories,id',
            'sub_category_id' => 'exists:categories,id',
        ];
    }
    public function run(): JsonResponse
    {
        $Objects = new User();
        if ($this->filled('category_id')){
            $user_id = FreelancerCategory::where('category_id', $this->category_id)->pluck('user_id');
            $Objects = $Objects->whereIn('id', $user_id);
        }
        if($this->filled('sub_category_id')){
            $user_id = FreelancerCategory::where('category_id', $this->category_id)->where('sub_category_id', $this->sub_category_id)->pluck('user_id');
            $Objects = $Objects->whereIn('id', $user_id);
        }
        if($this->filled('q')){
            $Objects = $Objects->where('name','Like', '%'.$this->q.'%');
        }
        if($this->filled('rate')){
            $Objects = $Objects->where('rate', $this->rate);
        }
        if($this->filled('city_id')){
            $Objects = $Objects->where('city_id', $this->city_id);
        }
        if($this->filled('nearest') && auth()->check()){
            $Objects = $Objects->nearest(auth()->user()->getLat(),auth()->user()->getLng());
        }else{
            $Objects = $Objects->orderBy('rate', 'desc');
        }
        if($this->filled('top_orders') && $this->top_orders){
            $Objects = $Objects->orderBy('order_count', 'desc');
        }
        $Objects = $Objects->paginate($this->filled('per_page')?$this->per_page:10);
        $Objects = FreelancerResource::collection($Objects);
        return $this->successJsonResponse([__('messages.saved_successfully')],$Objects->items(),'Freelancers',$Objects);
    }
}
