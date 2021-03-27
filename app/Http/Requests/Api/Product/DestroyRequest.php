<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\Api\ApiRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed product_id
 */
class DestroyRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'product_id'=>'required|exists:products,id',
        ];
    }

    public function run(): JsonResponse
    {
        $Object = (new Product())->find($this->product_id);
        try {
            $Object->delete();
            return $this->successJsonResponse([__('messages.deleted_successful')]);
        } catch (\Exception $e) {
            return $this->failJsonResponse([$e->getMessage()]);
        }
    }
}
