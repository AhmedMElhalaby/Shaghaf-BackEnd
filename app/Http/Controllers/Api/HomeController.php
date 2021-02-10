<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Home\SendNotificationRequest;
use App\Http\Requests\Api\Home\InstallRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    use ResponseTrait;


    /**
     * @param InstallRequest $request
     * @return JsonResponse
     */
    public function install(InstallRequest $request): JsonResponse
    {
        return $request->persist();
    }
     /**
     * @param SendNotificationRequest $request
     * @return JsonResponse
     */
    public function send_notification(SendNotificationRequest $request): JsonResponse
    {
        return $request->persist();
    }
}
