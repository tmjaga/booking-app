<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Jobs\SendBookingNotification;

class SendBookingCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking->load(['room', 'customer'])->toArray();
        dispatch(new SendBookingNotification($booking, 'Created'));
    }
}
