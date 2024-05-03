<?php

namespace Tests\Feature;

use App\Events\BookingCanceled;
use App\Events\BookingCreated;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingNotification;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

class BookingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::find(1);
        $this->actingAs($user);
    }

    public function testGetAllBookings(): void
    {
        $response = $this->get('/api/bookings');

        $response->assertOk()->assertJsonFragment([]);
    }

    public function testGetFilteredBookings(): void
    {
        $filter = [
            'customer' => 'customer',
            'number' => 101
        ];
        $response = $this->json('GET', '/api/bookings', $filter);

        $response->assertJsonMissingValidationErrors()->assertJsonIsArray();
    }

    public function testGetFilteredBookingsWithValidationFailed(): void
    {
        $filter = [
            'customer' => 'wrong',
            'number' => 'wrong_number'
        ];
        $response = $this->json('GET', '/api/bookings', $filter);

        $response->assertStatus(422);
    }

    public function testStoreBooking(): void
    {
        $data = Booking::factory()->make()->toArray();
        $response = $this->post('/api/bookings', $data);

        $response->assertOk()
            ->assertJsonStructure(['id', 'room', 'customer', 'check_in_date', 'check_out_date', 'total_price']);
    }

    public function testCancelBooking(): void
    {
        $booking = Booking::factory()->create();
        $response = $this->delete('/api/bookings/' . $booking->id);

        $response->assertOk();
    }

    public function testBookingCreateEventDispatched(): void
    {
        Event::fake();

        Booking::factory()->create();

        Event::assertDispatched(BookingCreated::class);
    }

    public function testBookingCanceledEventDispatched(): void
    {
        Event::fake();

        $booking = Booking::factory()->create();
        $booking->delete();

        Event::assertDispatched(BookingCanceled::class);
    }

    public function testSendEmailOnBookingCreateEvent(): void
    {
        Notification::fake();

        $booking = Booking::factory()->create();
        Event::dispatch(new BookingCreated($booking));

        Notification::assertSentTo([User::all()], BookingNotification::class);
    }

    public function testSendEmailOnBookingCanceledEvent(): void
    {
        Notification::fake();

        $booking = Booking::factory()->create();
        Event::dispatch(new BookingCanceled($booking));

        Notification::assertSentTo([User::all()], BookingNotification::class);
    }

}
