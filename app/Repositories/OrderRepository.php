<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function registerOrder(array $data): Order
    {
        $order = Order::create($data);

        if (!$order)
            throw new \Exception('Ops! Algo de errado ocorreu ao registar o pedido.');

        return $order;
    }
}