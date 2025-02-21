<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FirestoreController;


Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::post('/register', [UserController::class, 'store'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Fallback route for unauthorized access
Route::fallback(function () {
    return redirect()->route('login');
});

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::post('/presence/update', [FirestoreController::class, 'updatePresence']);
    Route::get('/presence/online', [FirestoreController::class, 'getOnlineUsers']);
    Route::post('/presence/clear', [FirestoreController::class, 'clearPresence']);
});