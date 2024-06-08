<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecordingController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\DashboardController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rute untuk otentikasi pengguna
require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

    // Library
    Route::get('/library', [DashboardController::class, 'library'])->name('library');

    // Upload Audio
    Route::post('/upload-audio', [AudioController::class, 'store'])->name('upload.audio');
    Route::post('/audio', [AudioController::class, 'store'])->name('audio.store');

    // Hapus Audio
    Route::delete('/audio/{id}', [AudioController::class, 'destroy'])->name('audio.destroy');

    // Recording
    Route::get('/record/new', [RecordingController::class, 'create'])->name('record.new');
    Route::post('/record/save', [RecordingController::class, 'save'])->name('record.save');

    // Logout
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});
