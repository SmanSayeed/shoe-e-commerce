<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CustomerProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin routes
Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories');
Route::get('/admin/create-category', [CategoryController::class, 'create'])->name('admin.create-category');
Route::get('/admin/sub-categories', [SubCategoryController::class, 'index'])->name('admin.sub-categories');
Route::get('/admin/create-sub-category', [SubCategoryController::class, 'create'])->name('admin.create-sub-category');
Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
Route::get('/admin/create-product', [ProductController::class, 'create'])->name('admin.create-product');
Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
Route::get('/admin/order/{id}', [OrderController::class, 'show'])->name('admin.view-order');

Route::get('login', [LoginController::class, 'login'])->name('login');
// Authentication Routes
Route::get('/login', [LoginController   ::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [LoginController::class, 'register'])->name('register');
Route::post('register', [LoginController::class, 'register'])->name('register.store');
Route::get('forgot-password', [LoginController::class, 'forgot_password'])->name('forgot-password');
Route::post('forgot-password', [LoginController::class, 'forgot_password'])->name('forgot-password.store');
Route::get('check-email', [LoginController::class, 'check_email'])->name('check-email');
Route::get('reset-password', [LoginController::class, 'reset_password'])->name('reset-password');
Route::post('reset-password', [LoginController::class, 'reset_password'])->name('reset-password.store');

// Product routes for frontend
Route::get('/product', [CustomerProductController::class, 'show'])->name('product.show');
Route::get('/product/checkout', [CustomerProductController::class, 'checkout'])->name('product.checkout');
