<?php

namespace App\Http\Requests\Api\Home;

use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Home\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryRequest extends ApiRequest
{

    public function run(): JsonResponse
    {
        return $this->successJsonResponse([],CategoryResource::collection(Category::where('is_active',true)->whereNull('parent_id')->get()),'Categories');

    }
}
