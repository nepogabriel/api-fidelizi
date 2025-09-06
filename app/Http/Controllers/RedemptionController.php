<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Redemption\StoreRedemptionRequest;
use App\Services\RedemptionService;
use Illuminate\Http\Request;

class RedemptionController extends Controller
{
    public function __construct(
        private RedemptionService $redemptionService
    ) {}

    public function store(StoreRedemptionRequest $request)
    {
        $data = $this->redemptionService->prizeRedemption($request->validated());

        return ApiResponse::response($data['return'], $data['code']);
    }
}
