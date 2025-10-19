<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('login', [LoginController::class, 'login']);
Route::get('register', [LoginController::class, 'register']);
Route::get('forgot_password', [LoginController::class, 'forgot_password']);
Route::get('reset_password', [LoginController::class, 'reset_password']);