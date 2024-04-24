<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    public function roomtype(): BelongsTo
    {
        return $this->BelongsTo(RoomType::class, 'room_type_id');
    }

    public function roomstatus(): BelongsTo
    {
        return $this->BelongsTo(RoomStatus::class, 'room_status_id');
    }

    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class, 'room_id');
    }

}
