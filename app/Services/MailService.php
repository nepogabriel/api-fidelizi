<?php

namespace App\Services;

use App\Mail\PointsEarnedMail;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService
{
    private CustomerRepository $customerRepository;

    public function __construct()
    {
        $this->customerRepository = new CustomerRepository();
    }

    public function sendPointsEarned(int $customerId, int $points, float $orderAmount): void
    {
        try {
            $customer = $this->customerRepository->findCustomerById($customerId);
            $orderAmount = number_format($orderAmount, 2, ',', '.');

            if (!$customer) {
                Log::warning('Cliente não encontrado para envio de e-mail de pontos ganhos.', [
                    'customer_id' => $customerId,
                    'points' => $points,
                    'amount' => $orderAmount,
                ]);

                return;
            }

            Mail::to($customer->email)
                ->send(new PointsEarnedMail($customer, $points, $orderAmount));

            Log::info('E-mail de pontos ganhos enviado com sucesso.', [
                'customer_id' => $customer->id,
                'email' => $customer->email,
                'points' => $points,
                'amount' => $orderAmount,
                'sent_at' => now(),
            ]);
        } catch (\Throwable $exception) {
            Log::critical('Erro inesperado ao tentar enviar e-mail de pontos ganhos.', [
                'customer_id' => $customerId,
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);
        }
    }
}