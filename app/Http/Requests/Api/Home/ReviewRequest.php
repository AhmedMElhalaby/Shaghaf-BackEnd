<?php

namespace App\Http\Requests\Api\Home;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Home\FreelancerResource;
use App\Http\Resources\Api\Order\ReviewResource;
use App\Models\FreelancerCategory;
use App\Models\Review;
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
class ReviewRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
        ];
    }
    public function run(): JsonResponse
    {
        $Objects = new Review();
        $Objects = $Objects->whereNotNull('review');
        $Objects = $Objects->orderBy('rate', 'desc');
        $Objects = $Objects->paginate($this->filled('per_page')?$this->per_page:10);
        $Objects = ReviewResource::collection($Objects);
        return $this->successJsonResponse([__('messages.saved_successfully')],$Objects->items(),'Reviews',$Objects);
    }
}
