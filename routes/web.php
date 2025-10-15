<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::get('/admin', function () {
    return view('admin.dashboard');
});