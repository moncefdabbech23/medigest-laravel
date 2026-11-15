<?php

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MedicationController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DoctorAvailabilityController;
use App\Http\Controllers\Admin\DoctorController;
use Illuminate\Support\Facades\Route;

// Site public
Route::get('/', [HomeController::class, 'index'])->name('home');

// Back-office
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('cities', CityController::class)->names('city');
    Route::resource('specialties', SpecialtyController::class)->names('specialty');
    Route::resource('medications', MedicationController::class)->names('medication');
    Route::patch('doctors/{doctor}/validate', [DoctorController::class, 'toggleValidation'])->name('doctor.validate'); // A9
    Route::resource('doctors', DoctorController::class)->names('doctor');         
    // Espace médecin (temporaire : le médecin est dans l'URL jusqu'à la partie 3)
    Route::get('/doctors/{doctor}/availabilities', [DoctorAvailabilityController::class, 'edit'])->name('doctor.availability.edit');
    Route::put('/doctors/{doctor}/availabilities', [DoctorAvailabilityController::class, 'update'])->name('doctor.availability.update');
});
