<?php

use App\Imports\PesertaImport;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
    Route::get('/test-import', function () {
        return view('test-import');
    });
    Route::post('/test-import', function () {
        request()->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        Excel::import(
            new PesertaImport,
            request()->file('file')
        );

        return 'Import selesai';
    });