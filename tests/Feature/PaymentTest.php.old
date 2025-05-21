<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    private $bookingId;
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::find(1);
        $this->actingAs($user);
        $this->bookingId = Booking::factory()->create()->id;
    }

    public function testGetBookingPayments(): void
    {
        $id = $this->bookingId;

        Payment::factory()->state(function () use ($id) {
            return ['booking_id' => $id];
        })->count(2)->create();

        $response = $this->get('/api/bookings/' . $this->bookingId . '/payments');

        $response->assertOk()
            ->assertJsonStructure(['*' => ['id', 'booking_id', 'amount', 'status']])
            ->assertJsonCount(2);
    }

    public function testStoreBookingPayment(): void
    {
        $id = $this->bookingId;
        $data = Payment::factory()->state(function () use ($id) {
            return ['booking_id' => $id];
        })->make()->toArray();

        $response = $this->post('/api/bookings/' . $this->bookingId . '/payments', $data);

        $response->assertOk()->assertJsonStructure(['id', 'booking_id', 'amount', 'status']);
    }
}
