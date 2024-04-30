<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Models\User;
use App\Notifications\BookingNotification;
use Illuminate\Support\Facades\Notification;

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
        Notification::send(User::all(), new BookingNotification($event->booking, 'Created'));
    }
}
