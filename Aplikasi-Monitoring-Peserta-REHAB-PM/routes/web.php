<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\VerifikasiSippController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

/*
|--------------------------------------------------------------------------
| Batch
|--------------------------------------------------------------------------
*/

// Daftar seluruh batch
Route::get('/batches', [
    BatchController::class,
    'index'
])->name('batches.index');


// Form import Excel
Route::get('/batches/import', [
    BatchController::class,
    'create'
])->name('batches.create');


// Proses import Excel
Route::post('/batches/import', [
    BatchController::class,
    'store'
])->name('batches.store');


// Detail batch + daftar peserta
Route::get('/batches/{batch}', [
    BatchController::class,
    'show'
])->name('batches.show');

/*
|--------------------------------------------------------------------------
| Verifikasi SIPP
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/peserta/{peserta}/verifikasi', [
        VerifikasiSippController::class,
        'create'
    ])->name('verifikasi-sipp.create');

    Route::post('/peserta/{peserta}/verifikasi', [
        VerifikasiSippController::class,
        'store'
    ])->name('verifikasi-sipp.store');

});