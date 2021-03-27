<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed product_id
 */
class ShowRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'product_id'=>'required|exists:products,id'
        ];
    }
    public function run(): JsonResponse
    {
        return $this->successJsonResponse([],new ProductResource((new  Product())->find($this->product_id)),'Product');
    }
}
