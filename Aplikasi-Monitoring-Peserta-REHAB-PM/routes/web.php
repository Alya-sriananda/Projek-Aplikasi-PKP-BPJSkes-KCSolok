<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BatchController;

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