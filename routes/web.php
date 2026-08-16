<?php

use App\Http\Controllers\ConsultationsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('patients', PatientController::class);

    //consultation
    Route::resource('consultations', ConsultationsController::class);
    Route::post('consultations/{consultation}/complete', [ConsultationsController::class, 'complete'])->name('consultations.complete');
    Route::post('consultations/{consultation}/cancel', [ConsultationsController::class, 'cancel'])->name('consultations.cancel');
    Route::get('patients/{patient}/consultations', [ConsultationsController::class, 'patientHistory'])->name('consultations.patient-history');
    Route::get('consultations/{consultation}/prescription-print', [ConsultationsController::class, 'prescriptionPrint'])->name('consultations.prescription-print');
});

require __DIR__.'/auth.php';
