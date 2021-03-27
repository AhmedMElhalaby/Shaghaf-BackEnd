<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Ticket\IndexRequest;
use App\Http\Requests\Api\Ticket\ShowRequest;
use App\Http\Requests\Api\Ticket\StoreRequest;
use App\Http\Requests\Api\Ticket\ResponseRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
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
    public function response(ResponseRequest $request): JsonResponse
    {
        return $request->run();
    }
}
