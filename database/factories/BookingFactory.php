<?php

namespace Database\Factories;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bookingDate = Booking::max('check_out_date');
        $bookingDate = Carbon::parse($bookingDate)->addDay();

        return [
            'room_id' => 1,
            'customer_id' => 1,
            'check_in_date' => $bookingDate,
            'check_out_date' => $bookingDate,
            'created_by' => 1
        ];
    }
}
