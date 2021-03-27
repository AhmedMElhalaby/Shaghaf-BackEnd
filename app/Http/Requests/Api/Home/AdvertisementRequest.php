<?php

namespace App\Http\Requests\Api\Home;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Home\AdvertisementResource;
use App\Models\Advertisement;
use Illuminate\Http\JsonResponse;

class AdvertisementRequest extends ApiRequest
{
    public function run(): JsonResponse
    {
        return $this->successJsonResponse([],AdvertisementResource::collection(Advertisement::where('is_active',true)->get()),'Advertisements');
    }
}
