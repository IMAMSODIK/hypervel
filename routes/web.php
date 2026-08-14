<?php

use App\Http\Controllers\AuthBannerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    \App\Models\PageView::record('landing');

    return view('welcome');
});

Route::get('/about', [AboutController::class, 'page'])->name('about.page');

Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/projects', [ProjectController::class, 'listing'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::post('/contact', [InquiryController::class, 'store'])->name('contact.inquiry');

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

    Route::get('/master/services', [ServiceController::class, 'index'])->name('master.services.index');
    Route::post('/master/services', [ServiceController::class, 'store'])->name('master.services.store');
    Route::put('/master/services/{service}', [ServiceController::class, 'update'])->name('master.services.update');
    Route::delete('/master/services/{service}', [ServiceController::class, 'destroy'])->name('master.services.destroy');

    Route::get('/master/about', [AboutController::class, 'edit'])->name('master.about.index');
    Route::put('/master/about', [AboutController::class, 'update'])->name('master.about.update');

    Route::get('/master/projects', [ProjectController::class, 'index'])->name('master.projects.index');
    Route::get('/master/projects/create', [ProjectController::class, 'create'])->name('master.projects.create');
    Route::post('/master/projects', [ProjectController::class, 'store'])->name('master.projects.store');
    Route::get('/master/projects/{project}/edit', [ProjectController::class, 'edit'])->name('master.projects.edit');
    Route::put('/master/projects/{project}', [ProjectController::class, 'update'])->name('master.projects.update');
    Route::delete('/master/projects/{project}', [ProjectController::class, 'destroy'])->name('master.projects.destroy');
    Route::delete('/master/projects/{project}/images/{image}', [ProjectController::class, 'destroyImage'])->name('master.projects.images.destroy');

    Route::get('/master/clients', [ClientController::class, 'index'])->name('master.clients.index');
    Route::post('/master/clients', [ClientController::class, 'store'])->name('master.clients.store');
    Route::put('/master/clients/{client}', [ClientController::class, 'update'])->name('master.clients.update');
    Route::delete('/master/clients/{client}', [ClientController::class, 'destroy'])->name('master.clients.destroy');

    Route::get('/master/products', [ProductController::class, 'index'])->name('master.products.index');
    Route::get('/master/products/create', [ProductController::class, 'create'])->name('master.products.create');
    Route::post('/master/products', [ProductController::class, 'store'])->name('master.products.store');
    Route::get('/master/products/{product}/edit', [ProductController::class, 'edit'])->name('master.products.edit');
    Route::put('/master/products/{product}', [ProductController::class, 'update'])->name('master.products.update');
    Route::delete('/master/products/{product}', [ProductController::class, 'destroy'])->name('master.products.destroy');
    Route::delete('/master/products/{product}/images/{image}', [ProductController::class, 'destroyImage'])->name('master.products.images.destroy');

    Route::get('/master/inquiries', [InquiryController::class, 'index'])->name('master.inquiries.index');
    Route::get('/master/inquiries/{inquiry}', [InquiryController::class, 'show'])->name('master.inquiries.show');
    Route::put('/master/inquiries/{inquiry}/read', [InquiryController::class, 'markRead'])->name('master.inquiries.read');
    Route::delete('/master/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('master.inquiries.destroy');
});