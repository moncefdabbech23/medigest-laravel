<?php

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\MedicationController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\DoctorAvailabilityController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ===================== Site public =====================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ===================== Espace médecin =====================
// Temporaire : le médecin est dans l'URL jusqu'à la partie 3
Route::get('/doctors/{doctor}/availabilities', [DoctorAvailabilityController::class, 'edit'])->name('doctor.availability.edit');   // A10
Route::put('/doctors/{doctor}/availabilities', [DoctorAvailabilityController::class, 'update'])->name('doctor.availability.update'); // A10

// ===================== Back-office =====================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // --- Personne A ---
    Route::resource('cities', CityController::class)->names('city');                 // A7
    Route::resource('specialties', SpecialtyController::class)->names('specialty');  // A8
    Route::resource('medications', MedicationController::class)->names('medication'); // A8
    Route::patch('doctors/{doctor}/validate', [DoctorController::class, 'toggleValidation'])->name('doctor.validate'); // A9
    Route::resource('doctors', DoctorController::class)->names('doctor');            // A9

    // --- Personne B ---
    Route::resource('patients', AdminPatientController::class)->names('patient');    // B6
});