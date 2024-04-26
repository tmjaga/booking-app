<?php

namespace App\Models;

use App\Http\Enums\RoomStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Room extends Model
{
    use HasFactory;

    //protected $appends = ['status'];
    protected $fillable = ['number', 'room_type_id', 'price_per_night'];

    public function roomtype(): BelongsTo
    {
        return $this->BelongsTo(RoomType::class, 'room_type_id');
    }

    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class, 'room_id');
    }

    // add accessor (calculated) Attribute status
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->booking()
                    ->where('check_in_date', '<=', now())
                    ->where('check_out_date', '>=', now())
                    ->exists() ? RoomStatus::BUSY->value : RoomStatus::FREE->value;
            }
        );
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });
    }
}
