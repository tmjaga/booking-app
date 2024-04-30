<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SimpleMessage;
use Illuminate\Notifications\Notification;

class BookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking, public string $action)
    {
        $this->booking = $booking->load(['room', 'customer'])->toArray();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $templateData = [
            'action' => $this->action,
            'period' => $this->booking['check_in_date'] . ' - ' . $this->booking['check_out_date'],
            'room' => $this->booking['room'],
            'customer' => $this->booking['customer'],
        ];

        $message = new MailMessage();
        $message->subject('Booking '. $this->action)
        ->markdown('mails.booking_notification', $templateData);

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
