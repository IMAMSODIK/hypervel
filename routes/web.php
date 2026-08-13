<?php

use App\Http\Controllers\AuthBannerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatisticController;
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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/master/auth-banners', [AuthBannerController::class, 'index'])->name('master.auth.banner');
    Route::post('/master/auth-banners', [AuthBannerController::class, 'store'])->name('master.auth.banner.store');
    Route::put('/master/auth-banners/{auth_banner}', [AuthBannerController::class, 'update'])->name('master.auth.banner.update');
    Route::delete('/master/auth-banners/{auth_banner}', [AuthBannerController::class, 'destroy'])->name('master.auth.banner.destroy');

    Route::get('/master/settings/contact', [SettingController::class, 'edit'])->name('master.settings.contact');
    Route::put('/master/settings/contact', [SettingController::class, 'update'])->name('master.settings.contact.update');

    Route::get('/master/hero', [HeroController::class, 'edit'])->name('master.hero.index');
    Route::put('/master/hero', [HeroController::class, 'update'])->name('master.hero.update');

    Route::get('/master/statistics', [StatisticController::class, 'index'])->name('master.statistics.index');
    Route::post('/master/statistics', [StatisticController::class, 'store'])->name('master.statistics.store');
    Route::put('/master/statistics/{statistic}', [StatisticController::class, 'update'])->name('master.statistics.update');
    Route::delete('/master/statistics/{statistic}', [StatisticController::class, 'destroy'])->name('master.statistics.destroy');
});



