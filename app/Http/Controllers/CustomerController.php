<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct(
        private CustomerService $customerService
    ) {}

    public function store(StoreCustomerRequest $request)
    {
        $data = $this->customerService->registerCustomer($request->validated());

        return ApiResponse::response($data['return'], $data['code']);
    }
}
