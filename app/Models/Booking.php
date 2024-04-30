<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Events\BookingCreated;
use App\Events\BookingCanceled;



class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'customer_id', 'check_in_date', 'check_out_date', 'total_price', 'created_by'];

    protected $dispatchesEvents = [
        'created' => BookingCreated::class,
        'deleted' => BookingCanceled::class
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function payment(): hasMany
    {
        return $this->hasMany(Payment::class, 'booking_id');
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->created_by = Auth::id();
            $model->total_price = $model->totalPrice();
        });
    }

    private function totalPrice(): float
    {
        $checkIn = Carbon::parse($this->check_in_date);
        $checkOut = Carbon::parse($this->check_out_date);

        $nights = $checkOut->diffInDays($checkIn);
        $nights = $nights == 0 ? 1 : $nights;

        return $nights * $this->room->price_per_night;
    }
}
