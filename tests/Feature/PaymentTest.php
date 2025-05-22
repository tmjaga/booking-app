<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
    $this->booking = Booking::factory()->create();
});

it('returns payments for a booking', function () {
    Payment::factory()
        ->count(2)
        ->for($this->booking)
        ->create();

    $response = $this->getJson("/api/bookings/{$this->booking->id}/payments");

    $response->assertOk()->assertJsonStructure([
        '*' => ['id', 'booking_id', 'amount', 'status'],
    ])
        ->assertJsonCount(2);
});

it('stores a payment for a booking', function () {
    $booking = Booking::factory()->create();

    $data = Payment::factory()->make([
        'booking_id' => $booking->id,
    ])->toArray();

    $response = $this->postJson("/api/bookings/{$booking->id}/payments", $data);

    $response->assertCreated()->assertJsonStructure([
        'data' => ['id', 'booking_id', 'amount', 'status'],
    ]);
});
