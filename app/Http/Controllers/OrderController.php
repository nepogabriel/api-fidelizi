<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function store(StoreOrderRequest $request)
    {
        $data = $this->orderService->registerOrder($request->validated());

        return ApiResponse::response($data['return'], $data['code']);
    }
}
