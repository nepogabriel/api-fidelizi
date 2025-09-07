<?php

namespace Tests\Unit\Services;

use App\Services\CustomerService;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CustomerServiceTest extends TestCase
{
    protected $customerRepository;
    protected $customerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customerRepository = $this->createMock(CustomerRepository::class);
        $this->customerService = new CustomerService($this->customerRepository);
    }

    public function test_get_all_customers_success()
    {
        $customers = [
            ['id' => 1, 'name' => 'Fulano Cicrano', 'email' => 'fulano@example.com'],
            ['id' => 2, 'name' => 'Beltrano Silva ', 'email' => 'beltrano@example.com'],
        ];

        $this->customerRepository
            ->expects($this->once())
            ->method('getAllCustomersWithPaginate')
            ->willReturn($customers);

        $result = $this->customerService->getAllCustomers();

        $this->assertEquals([
            'return' => $customers,
            'code' => 200,
        ], $result);
    }

    public function test_get_all_customers_handles_exception()
    {
        Log::shouldReceive('error')->once();

        $this->customerRepository
            ->expects($this->once())
            ->method('getAllCustomersWithPaginate')
            ->willThrowException(new \Exception('Database error'));

        $result = $this->customerService->getAllCustomers();

        $this->assertEquals([
            'return' => ['error' => 'Não foi possível buscar todos os clientes!'],
            'code' => 500,
        ], $result);
    }
}