<?php

namespace App\Services;

use App\Jobs\SendPrizeRedmeedEmail;
use App\Repositories\CustomerRepository;
use App\Repositories\PrizeRepository;
use App\Repositories\RedemptionRepository;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RedemptionService
{
    public function __construct(
        private RedemptionRepository $redemptionRepository,
        private CustomerRepository $customerRepository,
        private PrizeRepository $prizeRepository
    ) {}

    public function prizeRedemption(array $data)
    {
        try {
            $customer = $this->customerRepository->findCustomerById($data['customer_id']);
            $prize = $this->prizeRepository->findPrizeById($data['prize_id']);

            if ((isset($customer['points']) && $customer['points'] <= 0)
                || (isset($prize['points']) && $customer['points'] < $prize['points'])
            ) {
                return [
                    'return' => [
                        'message' => 'Saldo de pontos insuficiente!',
                    ],
                    'code' => Response::HTTP_OK
                ];
            }

            $redemption = $this->redemptionRepository->prizeRedemption($data);

            if (!isset($redemption)) {
                return [
                    'return' => [
                        'message' => 'Ops! Algo inesperado aconteceu ao resgatar o prêmio',
                    ],
                    'code' => Response::HTTP_OK
                ];
            }

            $this->customerRepository->decrementCustomerPoints($data['customer_id'], $prize['points']);

            Log::info('Prêmio resgatado com sucesso.', [
                'customer_id' => $redemption->customer_id,
                'prize_id' => $redemption->prize_id,
                'hour' => now(),
            ]);

            SendPrizeRedmeedEmail::dispatch($customer, $prize);

            return [
                'return' => [
                    'message' => 'Prêmio resgatado com sucesso!',
                    'data' => $redemption,
                ],
                'code' => Response::HTTP_CREATED
            ];
        } catch (\Exception $exception) {
            Log::error('Erro ao resgatar prêmio: ', [
                'message' => $exception->getMessage(),
                'code-http' => $exception->getCode(),
                'trace' =>$exception->getTrace(),
            ]);

            return [
                'return' => [
                    'error' => 'Não foi possível resgatar o prêmio!',
                ],
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }
}