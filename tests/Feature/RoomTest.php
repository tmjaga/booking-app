<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RoomTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::find(1);
        $this->actingAs($user);
    }

    public function testGetAllRooms(): void
    {
        $response = $this->get('/api/rooms');

        $response->assertOk()->assertJsonFragment([]);
    }

    public function testGetFilteredRooms(): void
    {
        $filter = [
            'number' => '101',
            'room_type_id' => 1,
            'status' => 'free'
        ];
        $response = $this->json('GET', '/api/rooms', $filter);

        $response->assertJsonMissingValidationErrors()
            ->assertJsonStructure([
            '*' => ['id', 'number', 'room_type', 'price_per_night', 'status']
        ]);
    }

    public function testGetFilteredRoomsWithValidationFailed(): void
    {
        $filter = [
            'number' => 'wrong_number',
            'room_type_id' => 100,
            'status' => 'free'
        ];
        $response = $this->json('GET', '/api/rooms', $filter);

        $response->assertStatus(422);
    }

    public function testGetRoom(): void
    {
        $roomNumber = 101;
        $response = $this->get('/api/rooms/' . $roomNumber);

        $response->assertOk()
            ->assertJsonIsObject()
            ->assertJsonStructure(['id', 'number', 'room_type', 'price_per_night', 'status']);
    }

    public function testStoreRoom(): void
    {
        $data = [
            'number' => Room::max('number') + 1,
            'room_type_id' => 1,
            'price_per_night' => 200.00
        ];

        $response = $this->post('/api/rooms/', $data);

        $response->assertOk()
            ->assertJsonStructure(['id', 'number', 'room_type', 'price_per_night', 'status']);
    }

}
