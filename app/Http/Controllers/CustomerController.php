<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(StoreCustomerRequest $request)
    {
        return ['Deu certo', $request->email];
    }
}
