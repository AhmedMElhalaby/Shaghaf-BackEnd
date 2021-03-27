<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Portfolio\IndexRequest;
use App\Http\Requests\Api\Portfolio\ShowRequest;
use App\Http\Requests\Api\Portfolio\StoreRequest;
use App\Http\Requests\Api\Portfolio\UpdateRequest;
use App\Http\Requests\Api\Portfolio\DestroyRequest;
use Illuminate\Http\JsonResponse;

class PortfolioController extends Controller
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
}
