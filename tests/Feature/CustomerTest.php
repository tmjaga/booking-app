<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('returns all customers with bookings and nested room data', function () {
    $response = $this->getJson('/api/customers');

    $response->assertOk()->assertJsonStructure([
        'data' => [
            [
                'id',
                'customer_name',
                'email',
                'phone_number',
                'created_by',
                'bookings' => [],
            ],
        ],
    ]);
});

it('returns filtered customers based on query parameters', function () {
    Customer::factory()->create([
        'customer_name' => 'Customer 11',
        'email' => 'customer11@mail.com',
        'phone_number' => '11111111',
    ]);

    Customer::factory()->count(2)->create();

    $filter = [
        'customer_name' => 'Customer',
        'email' => 'customer11@mail.com',
        'phone_number' => '11111111',
    ];

    $response = $this->getJson('/api/customers?'.http_build_query($filter));

    $response->assertOk()->assertJsonStructure([
        'data' => [
            '*' => ['id', 'customer_name', 'email', 'phone_number', 'created_by', 'bookings'],
        ],
    ])
        ->assertJsonFragment([
            'email' => 'customer11@mail.com',
            'phone_number' => '11111111',
        ]);
});

it('returns validation error when filtering customers with invalid data', function () {
    $filter = [
        'customer_name' => 'wrong_name',
        'email' => 'wrong_email',
        'phone_number' => 'wrong_number',
    ];

    $response = $this->getJson('/api/customers?'.http_build_query($filter));

    $response->assertStatus(422);
});

it('stores a customer and returns correct JSON structure', function () {
    $data = Customer::factory()->make()->toArray();

    $response = $this->postJson('/api/customers', $data);

    $response->assertCreated()->assertJsonStructure([
        'data' => [
            'id',
            'customer_name',
            'email',
            'phone_number',
            'created_by',
            'bookings',
        ],
    ]);
});
