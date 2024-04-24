<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;

Route::post('/login',[AuthController::class, 'login']);

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/rooms',[RoomController::class,'index']);
    Route::post('/logout',[AuthController::class, 'logout']);

});
