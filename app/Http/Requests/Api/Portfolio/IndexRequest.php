<?php

namespace App\Http\Requests\Api\Portfolio;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\User\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed user_id
 * @property mixed per_page
 */
class IndexRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'per_page'=> 'sometimes|numeric'
        ];
    }
    public function run(): JsonResponse
    {
        $Objects = new  Portfolio();
        if($this->filled('user_id')){
            $Objects = $Objects->where('user_id',$this->user_id);
        }else{
            $Objects = $Objects->where('user_id',auth()->user()->getId());
        }
        $Objects = $Objects->paginate($this->filled('per_page')?$this->per_page:10);
        return $this->successJsonResponse([],PortfolioResource::collection($Objects->items()),'Portfolios',$Objects);
    }
}
