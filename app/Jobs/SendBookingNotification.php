<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\BookingNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendBookingNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $booking, private string $action)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::send(User::all(), new BookingNotification($this->booking, $this->action));
    }
}
