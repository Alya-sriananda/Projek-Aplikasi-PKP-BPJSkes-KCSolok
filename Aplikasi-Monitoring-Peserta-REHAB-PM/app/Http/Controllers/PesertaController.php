<?php

namespace App\Http\Controllers;

use App\Models\Peserta;

class PesertaController extends Controller
{
    /**
     * Menampilkan detail peserta.
     */
    public function show(Peserta $peserta)
    {
        $peserta->load([
            'batches' => function ($query) {
                $query->latest('tanggal_data');
            },
            'verifikasiSipp' => function ($query) {
                $query->latest('tanggal_cek');
            },
            'komunikasi' => function ($query) {
                $query->latest();
            },
        ]);

        $verifikasiTerakhir = $peserta->verifikasiSipp->first();

        return view(
            'peserta.show',
            compact(
                'peserta',
                'verifikasiTerakhir'
            )
        );
    }
}