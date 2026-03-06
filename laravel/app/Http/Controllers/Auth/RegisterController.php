<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

// The Welcome/Home Page
Route::get('/', function () {
    return view('welcome');
});

// Registration Routes
// 1. Show the form (GET request)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// 2. Handle the form submission (POST request)
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// 3. A temporary Login route (so the redirect works)
Route::get('/login', function () {
    return "Login Page (We will build this next!)";
})->name('login');