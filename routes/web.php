<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CustomerProductController ;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('/login', [LoginController   ::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [LoginController::class, 'register'])->name('register');
Route::post('register', [LoginController::class, 'register'])->name('register.store');
Route::get('forgot_password', [LoginController::class, 'forgot_password'])->name('forgot_password');
Route::post('forgot_password', [LoginController::class, 'forgot_password'])->name('forgot_password.store');
Route::get('reset_password', [LoginController::class, 'reset_password'])->name('reset_password');

// Product routes for frontend
Route::get('/product', [CustomerProductController::class, 'show'])->name('product.show');
Route::get('/product/checkout', [CustomerProductController::class, 'checkout'])->name('product.checkout');
