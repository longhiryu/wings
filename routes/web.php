<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;

/** Auth routes */
Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/** Frontend routes */
Route::prefix('/')->group(function () {
    Route::get('', [HomeController::class, 'index'])->name('frontend.index');
});