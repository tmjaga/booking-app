<?php

namespace App\Listeners;

use App\Events\BookingCanceled;
use App\Models\User;
use App\Notifications\BookingNotification;
use Illuminate\Support\Facades\Notification;

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
        Notification::send(User::all(), new BookingNotification($event->booking, 'Canceled'));
    }
}
