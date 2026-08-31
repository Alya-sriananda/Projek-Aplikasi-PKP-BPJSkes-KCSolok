<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\Peserta;
use Illuminate\Support\Collection;

class TindakLanjutService
{
    /**
     * Mendapatkan peserta yang masih harus ditindaklanjuti
     * pada batch tertentu.
     */
    public function pesertaYangHarusDitindaklanjuti(
        Batch $batch
    ): Collection {

        $pesertaBatch = $batch->pesertas()
            ->with([
                'verifikasiSipp' => function ($query) {
                    $query->latest('tanggal_cek');
                },

                'komunikasi' => function ($query) {
                    $query->latest('tanggal_dihubungi');
                },
            ])
            ->get();

        return $pesertaBatch
            ->filter(function (Peserta $peserta) {
                return $this->harusDitindaklanjuti($peserta);
            })
            ->map(function (Peserta $peserta) use ($batch) {
                $peserta->kategori_tindak_lanjut =
                    $this->tentukanKategori(
                        $peserta,
                        $batch
                    );

                $peserta->status_proses =
                    $this->tentukanStatusProses($peserta);

                return $peserta;
            })
            ->values();
    }

    /**
     * Menentukan apakah peserta masih harus ditindaklanjuti.
     */
    public function harusDitindaklanjuti(
        Peserta $peserta
    ): bool {

        /*
         * Jika belum pernah dihubungi,
         * peserta masih masuk daftar tindak lanjut.
         */
        if ($peserta->komunikasi->isEmpty()) {
            return true;
        }

        /*
         * Jika sudah pernah dihubungi,
         * dianggap selesai.
         */
        return false;
    }
    
    /**
     * Menentukan apakah peserta baru atau peserta lama
     * yang belum selesai diproses.
     */
    public function tentukanKategori(
        Peserta $peserta,
        Batch $batch
    ): string {

        $pernahAdaSebelumnya = $peserta->batches()
            ->where(
                'batches.tanggal_data',
                '<',
                $batch->tanggal_data
            )
            ->exists();

        if (!$pernahAdaSebelumnya) {
            return 'peserta_baru';
        }

        return 'peserta_lama_belum_diproses';
    }


    /**
     * Menentukan posisi proses peserta.
     */
    public function tentukanStatusProses(
        Peserta $peserta
    ): string {

        /*
         * Belum pernah verifikasi.
         */
        if ($peserta->verifikasiSipp->isEmpty()) {

            return 'belum_verifikasi';

        }


        /*
         * Sudah verifikasi,
         * tetapi belum komunikasi.
         */
        if ($peserta->komunikasi->isEmpty()) {

            return 'siap_dihubungi';

        }


        /*
         * Sudah komunikasi.
         */
        return 'selesai';
    }
}