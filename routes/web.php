<?php

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\MedicationController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\DoctorAvailabilityController;
use App\Http\Controllers\DoctorController as PublicDoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpecialtyController as PublicSpecialtyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController; 
use App\Http\Controllers\PatientAppointmentController; 
use App\Http\Controllers\DoctorAppointmentController;  
use App\Http\Controllers\ConsultationController;  

// ===================== Site public =====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/doctors', [PublicDoctorController::class, 'index'])->name('doctor.index');                         // A11
Route::get('/doctors/{doctor}', [PublicDoctorController::class, 'show'])->name('doctor.show');                  // A11
Route::get('/specialties/{specialty}', [PublicSpecialtyController::class, 'show'])->name('specialty.show');     // A11

// ===================== Espace médecin =====================
// Temporaire : le médecin est dans l'URL jusqu'à la partie 3
Route::get('/doctors/{doctor}/availabilities', [DoctorAvailabilityController::class, 'edit'])->name('doctor.availability.edit');   // A10
Route::put('/doctors/{doctor}/availabilities', [DoctorAvailabilityController::class, 'update'])->name('doctor.availability.update'); // A10

// ===================== Back-office =====================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // --- Personne A ---
    Route::resource('cities', CityController::class)->names('city');                  // A7
    Route::resource('specialties', SpecialtyController::class)->names('specialty');   // A8
    Route::resource('medications', MedicationController::class)->names('medication'); // A8
    Route::patch('doctors/{doctor}/validate', [DoctorController::class, 'toggleValidation'])->name('doctor.validate'); // A9
    Route::resource('doctors', DoctorController::class)->names('doctor');             // A9

    // --- Personne B ---
    Route::resource('patients', AdminPatientController::class)->names('patient');     // B6
    Route::get('/doctors/{doctor}/book', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/doctors/{doctor}/book', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/patients/{patient}/appointments', [PatientAppointmentController::class,
    'index'])->name('patient.appointment.index');
    Route::get('/appointments/{appointment}/edit', [PatientAppointmentController::class,
    'edit'])->name('appointment.edit');
    Route::put('/appointments/{appointment}', [PatientAppointmentController::class,
    'update'])->name('appointment.update');
    Route::patch('/appointments/{appointment}/cancel', [PatientAppointmentController::class,
    'cancel'])->name('appointment.cancel');
    Route::get('/doctors/{doctor}/appointments', [DoctorAppointmentController::class,
    'index'])->name('doctor.appointment.index');
    Route::patch('/appointments/{appointment}/status', [DoctorAppointmentController::class,
    'updateStatus'])->name('appointment.status');
    Route::get('/appointments/{appointment}/consultation/create', [ConsultationController::class,
    'create'])->name('consultation.create');
    Route::post('/appointments/{appointment}/consultation', [ConsultationController::class,
    'store'])->name('consultation.store');



});