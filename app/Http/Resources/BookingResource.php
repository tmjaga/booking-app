<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $routeName = $request->route()->getName();

        $includeCustomer = in_array($routeName, ['rooms', 'bookings', 'bookings.store']);
        $includeRoom = in_array($routeName, ['customers', 'bookings', 'bookings.store']);

        return [
            'id' => $this->id,
            'room' => $this->when($includeRoom, $this->room),
            'customer' =>  $this->when($includeCustomer, $this->customer),
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'total_price' => $this->total_price,
        ];
    }
}
