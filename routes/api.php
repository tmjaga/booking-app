<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

Route::post('/login',[AuthController::class, 'login']);

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/rooms',[RoomController::class,'index'])->name('rooms');
    Route::get('/bookings',[BookingController::class,'index'])->name('booking');
    Route::get('/bookings/{booking}/payments',[PaymentController::class,'index'])->name('booking.payments');
    Route::post('/logout',[AuthController::class, 'logout']);
});
