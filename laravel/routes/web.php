<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

// --- Landing Page ---
Route::get('/', function () {
    return view('welcome');
});

// --- Public Authentication Routes ---
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- Public OTP Routes (NO 'auth' middleware) ---
// We now pass {email} so the controller knows which guest to verify
Route::get('/verify-otp/{email}', [OtpController::class, 'show'])->name('otp.show');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');
Route::post('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');

// This fallback helps if Laravel's internal systems look for a verification notice
Route::get('/email/verify', function () {
    return redirect()->route('login')->with('error', 'Please login or verify your email.');
})->name('verification.notice');


// --- Protected Routes (Must be Authenticated AND Verified) ---
// These routes are only accessible AFTER the user logs in AND email_verified_at is not null
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

    // Admin Verification Panel
    Route::get('/admin/verify', [AdminController::class, 'index'])->name('admin.verify');
    Route::post('/admin/verify/{user}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    Route::patch('/products/{product}/sold', [ProductController::class, 'markAsSold'])->name('products.sold');
});