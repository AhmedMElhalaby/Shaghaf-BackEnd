<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\IndexRequest;
use App\Http\Requests\Api\Product\ShowRequest;
use App\Http\Requests\Api\Product\StoreRequest;
use App\Http\Requests\Api\Product\UpdateRequest;
use App\Http\Requests\Api\Product\DestroyRequest;
use App\Http\Requests\Api\Product\DestroyMediaRequest;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(IndexRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function show(ShowRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function store(StoreRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function update(UpdateRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function destroy(DestroyRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function destroy_media(DestroyMediaRequest $request): JsonResponse
    {
        return $request->run();
    }
}
