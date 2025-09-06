<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    public function registerCustomer($customer): Customer
    {
        // dd($customer);
        return Customer::create($customer);
    }
}