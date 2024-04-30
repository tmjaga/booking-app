<?php

namespace App\Providers;

use App\Http\Enums\PaymentStatus;
use App\Http\Enums\RoomStatus;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Validator::extend('room_status', function ($attribute, $value) {
            return RoomStatus::isValid($value);
        }, 'Incorrect Room Status value. Only ' . implode(', ', RoomStatus::values()) . ' values allowed');

        Validator::extend('payment_status', function ($attribute, $value) {
            return PaymentStatus::isValid($value);
        }, 'Incorrect Payment Status value. Only ' . implode(', ', PaymentStatus::values()) . ' values allowed');
    }
}
