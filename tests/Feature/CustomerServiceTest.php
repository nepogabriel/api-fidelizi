<?php

namespace Tests\Feature\Services;

use App\Services\CustomerService;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CustomerServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_customer_success()
    {
        $customerData = [
            'name' => 'Fulano Cicrano',
            'email' => 'fulano@example.com'
        ];

        $response = app(CustomerService::class)->registerCustomer($customerData);

        $this->assertDatabaseHas('customers', [
            'name' => 'Fulano Cicrano',
            'email' => 'fulano@example.com',
        ]);

        $this->assertEquals(Response::HTTP_CREATED, $response['code']);
        $this->assertEquals('Cliente cadastrado com sucesso!', $response['return']['message']);
        $this->assertEquals('Fulano Cicrano', $response['return']['data']->name);
    }
}