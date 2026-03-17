<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController; // Ensure this is imported
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// --- Public Routes ---
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'] )->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- Group 1: Authenticated but NOT necessarily Verified (The OTP Stage) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/verify-otp', [OtpController::class, 'show'])->name('otp.show');
    Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');
    Route::post('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');
    
    // Fallback for Laravel's internal "verified" check
    Route::get('/email/verify', function () {
        return redirect()->route('otp.show');
    })->name('verification.notice');
});

// --- Group 2: The Marketplace (Must be Authenticated AND Verified via OTP) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard & My Ads
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-ads', [ProductController::class, 'myAds'])->name('products.myAds');

    // Product CRUD
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Admin Verification (Only accessible if verified)
    Route::get('/admin/verify', [AdminController::class, 'index'])->name('admin.verify');
    Route::post('/admin/verify/{user}', [AdminController::class, 'approve'])->name('admin.approve');
    
});