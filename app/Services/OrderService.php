<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository,
        private CustomerRepository $customerRepository
    ) {}

    public function registerOrder(array $data)
    {
        try {
            $points = floor($data['amount'] / 5);

            $data['earned_points'] = $points;

            $order = $this->orderRepository->registerOrder($data);

            $this->customerRepository->incrementCustomerPoints($data['customer_id'], $points);
            

            Log::info('Pedido cadastrado com sucesso.', [
                'customer_id' => $order->customer_id,
                'amount' => $order->amount,
                'earned_points' => $order->earned_points,
                'hour' => now(),
            ]);

            return [
                'return' => [
                    'message' => 'Pedido cadastrado com sucesso!',
                    'data' => $order,
                ],
                'code' => Response::HTTP_CREATED
            ];
        } catch (\Exception $exception) {
            Log::error('Erro ao cadastrar pedido: ', [
                'message' => $exception->getMessage(),
                'code-http' => $exception->getCode(),
                'trace' =>$exception->getTrace(),
            ]);

            return [
                'return' => [
                    'error' => 'Não foi possível cadastrar o pedido!',
                ],
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }
}