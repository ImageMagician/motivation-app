<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Http\Controllers\Admin\QuoteController as AdminQuoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin', fn() => view('admin/index'))->name('admin');
    Route::apiResource('admin/subscribers', AdminSubscriberController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::apiResource('admin/quotes', AdminQuoteController::class)->only(['index', 'store', 'update', 'destroy']);
});
