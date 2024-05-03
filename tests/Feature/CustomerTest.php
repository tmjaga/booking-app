<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::find(1);
        $this->actingAs($user);
    }

    public function testGetAllCustomers(): void
    {
        $response = $this->get('/api/customers');

        $response->assertOk()->assertJsonFragment([]);
    }

    public function testGetFilteredCustomers(): void
    {
        $filter = [
            'customer_name' => 'Customer',
            'email' => 'customer1@mail.com',
            'phone_number' => '11111111'
        ];
        $response = $this->json('GET', '/api/customers', $filter);

        $response->assertJsonMissingValidationErrors()
            ->assertJsonStructure([
                '*' => ['id', 'customer_name', 'email', 'phone_number', 'created_by', 'bookings']
            ]);
    }

    public function testGetFilteredCustomersWithValidationFailed(): void
    {
        $filter = [
            'customer_name' => 'wrong_name',
            'email' => 'wrong_email',
            'phone_number' => 'wrong_number'
        ];
        $response = $this->json('GET', '/api/customers', $filter);

        $response->assertStatus(422);
    }

    public function testStoreCustomer(): void
    {

        $data = Customer::factory()->make()->toArray();
        $response = $this->post('/api/customers', $data);

        $response->assertOk()
            ->assertJsonStructure(['id', 'customer_name', 'email', 'phone_number', 'created_by', 'bookings']);
    }

}
