<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Transaction\CheckPaymentRequest;
use App\Http\Requests\Api\Transaction\GenerateCheckoutRequest;
use App\Http\Requests\Api\Transaction\IndexRequest;
use App\Http\Requests\Api\Transaction\MyBalanceRequest;
use App\Http\Requests\Api\Transaction\RequestRefundRequest;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function index(IndexRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function my_balance(MyBalanceRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function generate_checkout(GenerateCheckoutRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function check_payment(CheckPaymentRequest $request): JsonResponse
    {
        return $request->run();
    }
    public function request_refund(RequestRefundRequest $request): JsonResponse
    {
        return $request->run();
    }
}
