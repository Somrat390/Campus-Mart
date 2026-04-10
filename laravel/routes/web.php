<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| EMERGENCY FIX ROUTES (Visit these on Render)
|--------------------------------------------------------------------------
*/

// 1. Fix Database Tokens: https://campus-mart-3.onrender.com/fix-db
Route::get('/fix-db', function () {
    try {
        Schema::dropIfExists('password_reset_tokens');
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        return "✅ Database table 'password_reset_tokens' fixed!";
    } catch (\Exception $e) {
        return "❌ DB Error: " . $e->getMessage();
    }
});

// 2. Fix Broken Images: https://campus-mart-3.onrender.com/fix-storage
Route::get('/fix-storage', function () {
    try {
        Artisan::call('storage:link');
        return "✅ Storage link created! Images should now appear.";
    } catch (\Exception $e) {
        return "❌ Storage Error: " . $e->getMessage();
    }
});

Route::get('/clear-all', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return "✅ All caches cleared! Cloudinary should now see your keys.";
});


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Recovery
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// OTP Verification
Route::get('/verify-otp/{email}', [OtpController::class, 'show'])->name('otp.show');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');
Route::post('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');

Route::get('/email/verify', function () {
    return redirect()->route('login')->with('error', 'Please login or verify your email.');
})->name('verification.notice');


/*
|--------------------------------------------------------------------------
| Protected Routes (Authenticated Users)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    // Product Management
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('/products/{product}/sold', [ProductController::class, 'markAsSold'])->name('products.sold');
    Route::get('/my-ads', [ProductController::class, 'myAds'])->name('products.myAds');

    // Real-time Chat
    Route::get('/chat/{product}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{product}/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/inbox', [ChatController::class, 'inbox'])->name('chat.inbox');

    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{user}/verify', [App\Http\Controllers\AdminController::class, 'verify'])->name('admin.verify');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.delete');
});