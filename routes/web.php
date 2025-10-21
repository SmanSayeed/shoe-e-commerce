<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;

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
Route::post('reset_password', [LoginController::class, 'reset_password'])->name('reset_password.store');

// User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [FrontendUserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/edit', [FrontendUserController::class, 'edit'])->name('user.profile.edit');
    Route::post('/profile/update', [FrontendUserController::class, 'update'])->name('user.profile.update');
    Route::get('/dashboard', [FrontendUserController::class, 'dashboard'])->name('user.dashboard');
});

// Admin Authentication Routes (legacy support - redirect to main login)
Route::get('/admin/login', function() {
    return redirect('/login');
});

// Protected Admin Routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/create-category', [CategoryController::class, 'create'])->name('create-category');
    Route::get('/sub-categories', [SubCategoryController::class, 'index'])->name('sub-categories');
    Route::get('/create-sub-category', [SubCategoryController::class, 'create'])->name('create-sub-category');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/create-product', [ProductController::class, 'create'])->name('create-product');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('view-order');
});

