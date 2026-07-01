<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController; // Import the controller
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Points to the dashboard method in PatientController
Route::get('/dashboard', [PatientController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Points to the index method in PatientController
Route::get('/yakap-member', [PatientController::class, 'index'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';