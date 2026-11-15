<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Site public
Route::get('/', [HomeController::class, 'index'])->name('home');

// Back-office
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // Les Route::resource(...) des étapes suivantes viendront ici
});