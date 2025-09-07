<?php

namespace App\Services;

use App\Jobs\SendPointsEarnedEmail;
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

            $data['points_earned'] = $points;

            $order = $this->orderRepository->registerOrder($data);
            
            if ($points > 0) {
                $this->customerRepository->incrementCustomerPoints($data['customer_id'], $points);

                SendPointsEarnedEmail::dispatch($data['customer_id'], $points, $data['amount']);
            }

            Log::info('Pedido cadastrado com sucesso.', [
                'customer_id' => $order->customer_id,
                'amount' => $order->amount,
                'points_earned' => $order->points_earned,
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