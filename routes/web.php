<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::get('register', [LoginController::class, 'register'])->name('register');
Route::get('forgot_password', [LoginController::class, 'forgot_password'])->name('forgot_password');
Route::get('reset_password', [LoginController::class, 'reset_password'])->name('reset_password');