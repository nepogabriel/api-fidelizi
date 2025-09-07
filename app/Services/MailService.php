<?php

namespace App\Services;

use App\Jobs\SendMaximumPrizeEmail;
use App\Mail\MaximumPrizeMail;
use App\Mail\PointsEarnedMail;
use App\Mail\PrizeRedeemedMail;
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
                'email' => $customer->email,
                'customer' => $customer,
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

    public function sendRedmeedPrize($customer, $prize): void
    {
        try {
            Mail::to($customer->email)
                ->send(new PrizeRedeemedMail($customer, $prize));

            Log::info('E-mail do resgate de prêmio enviado com sucesso.', [
                'email' => $customer->email,
                'customer' => $customer,
                'prize' => $prize,
                'sent_at' => now(),
            ]);
        } catch (\Throwable $exception) {
            Log::critical('Erro inesperado ao tentar enviar e-mail do resgate de prêmio.', [
                'customer' => $customer,
                'prize' => $prize,
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);
        }
    }

    public function sendMaximumPrizeToCustomers($customer): void
    {
        try {
            Mail::to($customer->email)
                ->send(new MaximumPrizeMail($customer));

            Log::info('E-mail do resgate de prêmio enviado com sucesso.', [
                'email' => $customer->email,
                'customer_id' => $customer->id,
                'sent_at' => now(),
            ]);
        } catch (\Throwable $exception) {
            Log::critical('Erro inesperado ao tentar enviar e-mail do resgate de prêmio.', [
                'customer_id' => $customer->id,
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);
        }
    }

    public function prepareMaximumPrizeEmails(): void
    {
        try {
            $customers = $this->customerRepository->getAllCustomers();
            
            foreach ($customers as $customer) {
                if ($customer->email) {                
                    if ($customer->points >= 20) {
                        SendMaximumPrizeEmail::dispatch($customer);
                    
                        Log::info('E-mail do resgate de prêmio adicionado na lista.', [
                            'email' => $customer->email,
                            'customer_id' => $customer->id,
                            'sent_at' => now(),
                        ]);
                    }
                }
            }
        } catch (\Throwable $exception) {
            Log::critical('Erro inesperado ao tentar adicionar na fila o e-mail do resgate de prêmio.', [
                'customer_id' => $customer->id,
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);
        }
    }
}