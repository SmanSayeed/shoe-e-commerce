<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
    Route::get('/user/{id}', [AdminUserController::class, 'show'])->name('user-details');
    Route::resource('categories', CategoryController::class)->except(['index', 'create']);
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/create-category', [CategoryController::class, 'create'])->name('create-category');
    Route::get('/sub-categories', [SubCategoryController::class, 'index'])->name('sub-categories');
    Route::get('/create-sub-category', [SubCategoryController::class, 'create'])->name('create-sub-category');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/create-product', [ProductController::class, 'create'])->name('create-product');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('view-order');
});
