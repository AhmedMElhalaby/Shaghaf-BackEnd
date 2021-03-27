<?php

namespace App\Http\Requests\Api\Portfolio;

use App\Http\Requests\Api\ApiRequest;
use App\Models\Portfolio;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed portfolio_id
 */
class DestroyRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => 'required|exists:portfolios,id',
        ];
    }
    public function run(): JsonResponse
    {
        $Object = (new  Portfolio())->find($this->portfolio_id);
        try {
            $Object->delete();
            return $this->successJsonResponse([__('messages.deleted_successful')]);
        } catch (\Exception $e) {
            return $this->errorJsonResponse([$e->getMessage()]);
        }
    }
}
