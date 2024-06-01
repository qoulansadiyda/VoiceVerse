<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecordingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AudioController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk otentikasi pengguna
require __DIR__.'/auth.php';


// Rute untuk halaman dashboard dan merekam audio
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
    Route::get('/record/new', [RecordingController::class, 'create'])->name('record.new');
    Route::post('/record/save', [RecordingController::class, 'save'])->name('record.save');
    Route::post('/upload-audio', [AudioController::class, 'uploadAudio'])->name('upload.audio');
});
