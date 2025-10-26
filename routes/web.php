<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChildCategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin routes
Route::get('/login', [LoginController::class, 'login'])->name('login');
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
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/bulk-delete', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
    Route::patch('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::resource('subcategories', SubCategoryController::class);
    Route::post('/subcategories/bulk-delete', [SubCategoryController::class, 'bulkDestroy'])->name('subcategories.bulk-destroy');
    Route::patch('/subcategories/{subCategory}/toggle-status', [SubCategoryController::class, 'toggleStatus'])->name('subcategories.toggle-status');
    Route::resource('child-categories', ChildCategoryController::class);
    Route::post('/child-categories/bulk-delete', [ChildCategoryController::class, 'bulkDestroy'])->name('child-categories.bulk-destroy');
    Route::patch('/child-categories/{childCategory}/toggle-status', [ChildCategoryController::class, 'toggleStatus'])->name('child-categories.toggle-status');
    Route::resource('products', ProductController::class);
    Route::post('/products/bulk-delete', [ProductController::class, 'bulkDestroy'])->name('products.bulk-destroy');
    Route::get('/get-subcategories', [ProductController::class, 'getSubcategories'])->name('get-subcategories');
    Route::get('/get-child-categories', [ProductController::class, 'getChildCategories'])->name('get-child-categories');
    Route::resource('orders', OrderController::class);
    Route::post('/products/{product}/stock', [ProductController::class, 'updateStock'])->name('products.stock.update');
    Route::get('/products/{product}/stock', [ProductController::class, 'manageStock'])->name('products.stock');
    Route::get('/products/{product}/images', [ProductController::class, 'manageImages'])->name('products.images');
    Route::post('/products/{product}/images', [ProductController::class, 'uploadImages'])->name('products.images.upload');
    Route::patch('/product-images/{image}/primary', [ProductController::class, 'setPrimaryImage'])->name('product-images.primary');
    Route::delete('/product-images/{image}', [ProductController::class, 'deleteImage'])->name('product-images.delete');
    Route::get('/products/{product}/variants', [ProductController::class, 'manageVariants'])->name('products.variants');
    Route::post('/products/{product}/variants', [ProductController::class, 'storeVariant'])->name('products.variants.store');
    Route::get('/product-variants/{variant}/edit', [ProductController::class, 'editVariant'])->name('product-variants.edit');
    Route::put('/product-variants/{variant}', [ProductController::class, 'updateVariant'])->name('product-variants.update');
    Route::delete('/product-variants/{variant}', [ProductController::class, 'deleteVariant'])->name('product-variants.delete');
    Route::get('/brands', [BrandController::class, 'index'])->name('brands');
    Route::get('/create-brand', [BrandController::class, 'create'])->name('create-brand');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brands.show');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
    Route::delete('/brands', [BrandController::class, 'bulkDestroy'])->name('brands.bulk-destroy');
    Route::patch('/brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');
});
