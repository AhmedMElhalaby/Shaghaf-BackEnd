<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed category_id
 * @property mixed sub_category_id
 * @property mixed type
 * @property mixed per_page
 * @property mixed user_id
 */
class IndexRequest extends ApiRequest
{
    public function run(): JsonResponse
    {
        $logged = auth()->user();
        $Objects = new  Product();
        if($this->filled('user_id')){
            $Objects = $Objects->where('user_id',$this->user_id);
        }else{
            $Objects = $Objects->where('user_id',$logged->getId());
        }
        if ($this->filled('category_id')) {
            $Objects = $Objects->where('category_id',$this->category_id);
        }
        if ($this->filled('sub_category_id')) {
            $Objects = $Objects->where('sub_category_id',$this->sub_category_id);
        }
        if ($this->filled('type')) {
            $Objects = $Objects->where('type',$this->type);
        }
        $Objects = $Objects->paginate($this->filled('per_page')?$this->per_page:10);
        return $this->successJsonResponse([],ProductResource::collection($Objects->items()),'Products',$Objects);
    }
}
