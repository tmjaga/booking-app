<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'email', 'phone_number', 'created_by'];

    public function booking(): HasMany
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->created_by = Auth::id() ?? 1;
        });
    }
}
