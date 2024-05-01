<?php

namespace App\Listeners;

use App\Events\BookingCanceled;
use App\Jobs\SendBookingNotification;

class SendBookingCanceledNotification
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
    public function handle(BookingCanceled $event): void
    {
        $booking = $event->booking->load(['room', 'customer'])->toArray();
        dispatch(new SendBookingNotification($booking, 'Canceled'));
    }
}
