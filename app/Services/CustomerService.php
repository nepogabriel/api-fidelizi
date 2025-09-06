<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CustomerService
{
    public function __construct(
        private CustomerRepository $customerRepository
    ) {}

    public function getAllCustomers(): array
    {
        try {
            $customers = $this->customerRepository->getAllCustomers();

            return [
                'return' => $customers,
                'code' => Response::HTTP_OK
            ];
        } catch (\Exception $exception) {
            Log::error('Erro ao buscar todos os clientes: ', [
                'message' => $exception->getMessage(),
                'code-http' => $exception->getCode(),
                'trace' =>$exception->getTrace(),
            ]);

            return [
                'return' => [
                    'error' => 'Não foi possível buscar todos os clientes!',
                ],
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }

    public function registerCustomer(array $customer): array
    {
        try {
            $responseCustomer = $this->customerRepository->registerCustomer($customer);

            Log::info('Cliente criado com sucesso.', [
                'name' => $responseCustomer->name,
                'email' => $responseCustomer->email,
                'hour' => now(),
            ]);

            return [
                'return' => [
                    'message' => 'Cliente cadastrado com sucesso!',
                    'data' => $responseCustomer,
                ],
                'code' => Response::HTTP_CREATED
            ];
        } catch (\Exception $exception) {
            Log::error('Erro ao cadastrar cliente: ', [
                'message' => $exception->getMessage(),
                'code-http' => $exception->getCode(),
                'trace' =>$exception->getTrace(),
            ]);

            return [
                'return' => [
                    'error' => 'Não foi possível cadastrar o cliente!',
                ],
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }

    public function findCustomerById(int $id): array
    {
        try {
            $customer = $this->customerRepository->findCustomerById($id);

            return [
                'return' => [
                    'message' => 'Cliente encontrado com sucesso!',
                    'data' => $customer,
                ],
                'code' => Response::HTTP_OK
            ];
        } catch (\Exception $exception) {
            Log::error('Erro ao buscar cliente por ID: ', [
                'message' => $exception->getMessage(),
                'code-http' => $exception->getCode(),
                'trace' =>$exception->getTrace(),
            ]);

            return [
                'return' => [
                    'error' => 'Não foi possível encontrar o cliente!',
                ],
                'code' => Response::HTTP_NOT_FOUND,
            ];
        }
    }
}