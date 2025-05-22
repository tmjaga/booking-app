<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('gets all bookings', function () {
    $response = $this->getJson('/api/rooms');

    $response->assertOk()->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'number',
                'room_type',
                'price_per_night',
                'status',
            ],
        ],
    ]);
});

it('gets filtered rooms', function () {
    $filter = [
        'number' => '101',
        'room_type_id' => 1,
        'status' => 'free',
    ];

    $response = $this->getJson('/api/rooms?'.http_build_query($filter));

    $response->assertOk()->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'number',
                'room_type',
                'price_per_night',
                'status',
            ],
        ],
    ]);
});

it('returns validation error when filtering rooms with invalid data', function () {
    $filter = [
        'number' => 'wrong_number',
        'room_type_id' => 100,
        'status' => 'free',
    ];

    $response = $this->getJson('/api/rooms?'.http_build_query($filter));

    $response->assertStatus(422);
});

it('gets a single room by number', function () {
    $roomNumber = 101;
    $response = $this->get('/api/rooms/'.$roomNumber);

    $response->assertOk()->assertJsonStructure([
        'data' => [
            'id',
            'number',
            'room_type',
            'price_per_night',
            'created_by',
            'status',
            'booking' => [
                '*' => [
                    'id',
                    'check_in_date',
                    'check_out_date',
                    'total_price',
                ],
            ],
        ],
    ]);
});

it('stores a new room', function () {
    $data = Room::factory()->make()->toArray();

    $response = $this->post('/api/rooms/', $data);

    $response->assertCreated()->assertJsonStructure([
        'data' => [
            'id',
            'number',
            'room_type',
            'price_per_night',
            'status',
        ],
    ]);
});
