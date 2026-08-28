<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\VerifikasiSippController;
use App\Http\Controllers\TemplatePesanController;
use App\Http\Controllers\PesertaController;

Route::get('/peserta/{peserta}', [
    PesertaController::class,
    'show'
])->name('peserta.show');

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

Route::get('/template-pesan', [
    TemplatePesanController::class,
    'index'
])->name('template-pesan.index');

Route::get('/template-pesan/create', [
    TemplatePesanController::class,
    'create'
])->name('template-pesan.create');

Route::post('/template-pesan', [
    TemplatePesanController::class,
    'store'
])->name('template-pesan.store');