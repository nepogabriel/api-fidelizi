<?php

namespace App\Repositories;

use App\Models\Customer;
use Symfony\Component\HttpFoundation\Response;

class CustomerRepository
{
    public function getAllCustomers()
    {
        return Customer::paginate(30);
    }

    public function registerCustomer($customer): Customer
    {
        $customer = Customer::create($customer);

        if (!$customer)
            throw new \Exception('Ops! Algo de errado ocorreu ao registar o cliente.');

        return $customer;
    }

    public function findCustomerById(int $id): Customer
    {
        $customer = Customer::find($id);

        if (!$customer)
            throw new \Exception('Cliente não encontrado.', Response::HTTP_NOT_FOUND);

        return $customer;
    }
}