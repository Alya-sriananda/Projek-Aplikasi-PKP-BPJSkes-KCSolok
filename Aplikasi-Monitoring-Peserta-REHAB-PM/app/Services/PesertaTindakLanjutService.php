<?php

namespace App\Services;

use App\Models\Batch;
use Illuminate\Support\Collection;

class PesertaTindakLanjutService
{
    /**
     * Mengambil peserta yang perlu ditindak pada batch tertentu.
     *
     * Kategori:
     *
     * 1. Peserta baru pada batch tersebut
     * 2. Peserta lama yang pada batch sebelumnya masih belum diproses
     */
    public function pesertaPerluDitindak(Batch $batch): Collection
    {
        $batch->load([
            'pesertas',
        ]);

        $pesertaPerluDitindak = collect();

        foreach ($batch->pesertas as $peserta) {

            $pesertaBatchSaatIni = $peserta->pivot;

            /*
             * Cari histori kemunculan peserta sebelum batch saat ini.
             */
            $historiSebelumnya = $peserta->batches()
                ->where('batches.id', '<', $batch->id)
                ->withPivot([
                    'status_proses',
                    'tanggal_proses',
                    'user_proses',
                ])
                ->orderByDesc('tanggal_data')
                ->orderByDesc('id')
                ->get();

            /*
             * Peserta baru:
             * belum pernah muncul di batch sebelumnya.
             */
            if ($historiSebelumnya->isEmpty()) {

                $peserta->kategori_tindak_lanjut = 'peserta_baru';

                $pesertaPerluDitindak->push($peserta);

                continue;
            }

            /*
             * Peserta lama.
             *
             * Kita hanya masukkan jika kemunculan terakhir
             * sebelumnya masih belum diproses.
             */
            $kemunculanTerakhir = $historiSebelumnya->first();

            if (
                $kemunculanTerakhir->pivot->status_proses
                === 'belum_diproses'
            ) {

                $peserta->kategori_tindak_lanjut = 'belum_diproses';

                $pesertaPerluDitindak->push($peserta);
            }
        }

        return $pesertaPerluDitindak;
    }
}