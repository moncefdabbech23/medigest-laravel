<?php

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\MedicationController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DoctorAppointmentController;
use App\Http\Controllers\DoctorAvailabilityController;
use App\Http\Controllers\DoctorController as PublicDoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PatientAppointmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\SpecialtyController as PublicSpecialtyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorProfileController;

// ===================== Site public (tout le monde) =====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/doctors', [PublicDoctorController::class, 'index'])->name('doctor.index');                       // A11
Route::get('/doctors/{doctor}', [PublicDoctorController::class, 'show'])->name('doctor.show');                // A11
Route::get('/specialties/{specialty}', [PublicSpecialtyController::class, 'show'])->name('specialty.show');   // A11

// ===================== Connexion (visiteurs non connectés) =====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');          // A13
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ===================== Espace patient (patients connectés) =====================
Route::middleware(['auth', 'role:patient'])->group(function () {
    // --- Personne B (B13) : /doctors/{doctor}/book ---

    Route::prefix('my')->name('my.')->group(function () {
        // --- Personne B (B13, B16) : /my/appointments, /my/record, /my/profile ---
    });
});

// ===================== Espace médecin (médecins connectés) =====================
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    // --- Personne A (A16) : /doctor/availabilities ---

    // --- Personne B (B14, B15) : /doctor/appointments, consultations, dossiers, fichiers ---
});

// ===================== Back-office (admin connecté) =====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');            // A12

    // --- Personne A ---
    Route::resource('cities', CityController::class)->names('city');                       // A7
    Route::resource('specialties', SpecialtyController::class)->names('specialty');        // A8
    Route::resource('medications', MedicationController::class)->names('medication');      // A8
    Route::patch('doctors/{doctor}/validate', [DoctorController::class, 'toggleValidation'])->name('doctor.validate'); // A9
    Route::resource('doctors', DoctorController::class)->names('doctor');                  // A9

    // --- Personne B ---
    Route::resource('patients', AdminPatientController::class)->names('patient');          // B6
});

// ===================== Tous les utilisateurs connectés =====================
Route::middleware('auth')->group(function () {
    // --- Personne B (B13) : /notifications, /prescriptions/{prescription} ---

    // ---------- TEMPORAIRE : routes de la partie 2 ----------
    // Elles seront SUPPRIMÉES par A16 (horaires), B13 (patient) et B14 (médecin).
   

    Route::get('/doctors/{doctor}/book', [AppointmentController::class, 'create'])->name('appointment.create');                          // B7
    Route::post('/doctors/{doctor}/book', [AppointmentController::class, 'store'])->name('appointment.store');                           // B7
    Route::get('/patients/{patient}/appointments', [PatientAppointmentController::class, 'index'])->name('patient.appointment.index');   // B8
    Route::get('/appointments/{appointment}/edit', [PatientAppointmentController::class, 'edit'])->name('appointment.edit');             // B8
    Route::put('/appointments/{appointment}', [PatientAppointmentController::class, 'update'])->name('appointment.update');              // B8
    Route::patch('/appointments/{appointment}/cancel', [PatientAppointmentController::class, 'cancel'])->name('appointment.cancel');     // B8
    Route::get('/doctors/{doctor}/appointments', [DoctorAppointmentController::class, 'index'])->name('doctor.appointment.index');       // B9
    Route::patch('/appointments/{appointment}/status', [DoctorAppointmentController::class, 'updateStatus'])->name('appointment.status'); // B9
    Route::get('/appointments/{appointment}/consultation/create', [ConsultationController::class, 'create'])->name('consultation.create'); // B10
    Route::post('/appointments/{appointment}/consultation', [ConsultationController::class, 'store'])->name('consultation.store');        // B10
    Route::get('/patients/{patient}/record', [MedicalRecordController::class, 'show'])->name('patient.record');                           // B11
    Route::get('/prescriptions/{prescription}', [PrescriptionController::class, 'show'])->name('prescription.show');                      // B12
    Route::get('/users/{user}/notifications', [NotificationController::class, 'index'])->name('notification.index');                      // B12
    Route::post('/users/{user}/notifications/read', [NotificationController::class, 'markAllRead'])->name('notification.read');           // B12
});
    // --- Personne A (A16) ---
    Route::get('/availabilities', [DoctorAvailabilityController::class, 'edit'])->name('availability.edit');
    Route::put('/availabilities', [DoctorAvailabilityController::class, 'update'])->name('availability.update');
    Route::get('/profile', [DoctorProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [DoctorProfileController::class, 'update'])->name('profile.update');