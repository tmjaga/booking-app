<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'room_type' => $this->room_type_name,
            'price_per_night' => $this->price_per_night,
            'status' => $this->status,
            'booking' => $this->when($request->has('number'), BookingResource::collection($this->booking))
        ];
    }
}
