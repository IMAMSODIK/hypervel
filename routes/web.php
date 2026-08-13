<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send-otp');

    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify-otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('reset-password');
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update-password');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');