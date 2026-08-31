<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Services\TindakLanjutService;

class TindakLanjutController extends Controller
{
    /**
     * Menampilkan daftar peserta yang harus ditindaklanjuti
     * pada batch terbaru.
     */
    public function index(TindakLanjutService $service)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil batch terbaru
        |--------------------------------------------------------------------------
        */

        $batch = Batch::latest('tanggal_data')
            ->latest('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Jika belum ada batch
        |--------------------------------------------------------------------------
        */

        if (!$batch) {
            return view('tindak-lanjut.index', [
                'batch' => null,
                'peserta' => collect(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil peserta yang harus ditindaklanjuti
        |--------------------------------------------------------------------------
        */

        $peserta = $service->pesertaYangHarusDitindaklanjuti($batch);

        /*
        |--------------------------------------------------------------------------
        | Tampilkan halaman
        |--------------------------------------------------------------------------
        */

        return view('tindak-lanjut.index', [
            'batch' => $batch,
            'peserta' => $peserta,
        ]);
    }
}