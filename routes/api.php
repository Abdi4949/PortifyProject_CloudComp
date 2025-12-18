<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentCallbackController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Menggunakan method 'handle' yang sudah diperbaiki
Route::post('payments/midtrans-notification', [PaymentCallbackController::class, 'handle']);