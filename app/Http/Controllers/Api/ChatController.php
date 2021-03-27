<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Chat\ReadMessageRequest;
use App\Http\Requests\Api\Chat\RoomRequest;
use App\Http\Requests\Api\Chat\CreateRoomRequest;
use App\Http\Requests\Api\Chat\MessageRequest;
use App\Http\Requests\Api\Chat\CreateMessageRequest;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    public function rooms(RoomRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function create_room(CreateRoomRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function messages(MessageRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function read_messages(ReadMessageRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function create_message(CreateMessageRequest $request): JsonResponse
    {
        return $request->run();
    }
}
