<?php

namespace App\Http\Requests\Api\Portfolio;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\User\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed portfolio_id
 */
class ShowRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => 'required|exists:portfolios,id',
        ];
    }
    public function run(): JsonResponse
    {
        return $this->successJsonResponse([],new PortfolioResource((new  Portfolio())->find($this->portfolio_id)),'Portfolio');
    }
}
