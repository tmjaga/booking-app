<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;

Route::post('/login',[AuthController::class, 'login']);

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/rooms',[RoomController::class,'index'])->name('rooms');
    Route::post('/rooms',[RoomController::class,'store'])->name('rooms.store');

    Route::get('/customers',[CustomerController::class,'index'])->name('customers');
    Route::post('/customers',[CustomerController::class,'store'])->name('customers.store');

    Route::get('/bookings',[BookingController::class,'index'])->name('bookings');
    Route::post('/bookings',[BookingController::class,'store'])->name('bookings.store');
    Route::delete('/bookings/{booking}',[BookingController::class,'cancel'])->name('bookings.cancel');

    Route::get('/bookings/{booking}/payments',[PaymentController::class,'show'])->name('booking.payments');
    Route::post('/bookings/{booking}/payments',[PaymentController::class,'store'])->name('booking.payments.store');

    Route::post('/logout',[AuthController::class, 'logout']);
});
