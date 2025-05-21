<?php

namespace Tests\Feature;

use App\Events\BookingCanceled;
use App\Events\BookingCreated;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('gets all bookings', function () {
    $response = $this->getJson('/api/bookings');

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

it('gets filtered bookings', function () {
    $filter = [
        'customer' => 'customer',
        'number' => 101,
    ];

    $response = $this->getJson('/api/bookings?'.http_build_query($filter));

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

it('returns validation error when filtering bookings with invalid data', function () {
    $filter = [
        'customer' => 'wrong',
        'number' => 'wrong_number',
    ];

    $response = $this->getJson('/api/bookings?'.http_build_query($filter));

    $response->assertStatus(422);
});

it('stores a booking', function () {

    $data = Booking::factory()->make()->toArray();
    $response = $this->postJson(route('bookings.store'), $data);

    $response->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'id',
                'room' => [
                    'id',
                    'number',
                    'room_type_id',
                    'price_per_night',
                    'created_by',
                    'created_at',
                    'updated_at',
                    'room_type_name',
                    'roomtype' => [
                        'id',
                        'type',
                    ],
                ],
                'customer' => [
                    'id',
                    'customer_name',
                    'email',
                    'phone_number',
                    'created_by',
                    'created_at',
                    'updated_at',
                ],
                'check_in_date',
                'check_out_date',
                'total_price',
            ],
        ]);

    $this->assertDatabaseHas('bookings', [
        'room_id' => $data['room_id'],
        'customer_id' => $data['customer_id'],
    ]);
});

it('cancels a booking', function () {
    $booking = Booking::factory()->create();

    $response = $this->deleteJson('/api/bookings/'.$booking->id);

    $response->assertOk();
});

it('dispatches BookingCreated event when booking is created', function () {
    Event::fake();

    Booking::factory()->create();

    Event::assertDispatched(BookingCreated::class);
});

it('dispatches BookingCanceled event when booking is canceled', function () {
    Event::fake();

    $booking = Booking::factory()->create();
    $booking->delete();

    Event::assertDispatched(BookingCanceled::class);
});

it('sends email notification on booking created event', function () {
    Notification::fake();

    $booking = Booking::factory()->create();

    Event::dispatch(new BookingCreated($booking));

    Notification::assertSentTo([User::all()], BookingNotification::class);
});

it('sends email notification on booking canceled event', function () {
    Notification::fake();

    $booking = Booking::factory()->create();

    Event::dispatch(new BookingCanceled($booking));

    Notification::assertSentTo([User::all()], BookingNotification::class);
});
