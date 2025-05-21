<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['booking_id', 'amount', 'payment_date', 'status'];

    protected static function booted()
    {
        static::saving(function ($model) {
            if (! $model->payment_date) {
                $model->payment_date = now()->format('Y-m-d H:i:s');
            }
        });
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
