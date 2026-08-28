<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\VerifikasiSippController;

Route::get('/batches', [
    BatchController::class,
    'index'
])->name('batches.index');

Route::get('/batches/import', [
    BatchController::class,
    'create'
])->name('batches.create');

Route::post('/batches/import', [
    BatchController::class,
    'store'
])->name('batches.store');

Route::get('/batches/{batch}', [
    BatchController::class,
    'show'
])->name('batches.show');

Route::get('/peserta/{peserta}/verifikasi-sipp', [
    VerifikasiSippController::class,
    'create'
])->name('verifikasi-sipp.create');

Route::post('/peserta/{peserta}/verifikasi-sipp', [
    VerifikasiSippController::class,
    'store'
])->name('verifikasi-sipp.store');