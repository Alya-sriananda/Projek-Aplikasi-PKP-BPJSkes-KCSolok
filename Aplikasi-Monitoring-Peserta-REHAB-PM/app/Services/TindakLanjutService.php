<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\Peserta;
use Illuminate\Support\Collection;

class TindakLanjutService
{
    /**
     * Mendapatkan daftar peserta yang harus ditindaklanjuti
     * pada batch tertentu.
     *
     * Aturan:
     *
     * 1. Peserta baru pada batch tersebut → masuk.
     * 2. Peserta lama yang belum pernah diproses → masuk.
     * 3. Peserta yang sudah pernah diproses → tidak masuk.
     */
    public function pesertaYangHarusDitindaklanjuti(Batch $batch): Collection
    {
        $pesertaBatch = $batch->pesertas()
            ->with([
                'verifikasiSipp' => function ($query) {
                    $query->latest('tanggal_cek');
                },
                'komunikasi' => function ($query) {
                    $query->latest();
                },
            ])
            ->get();

        return $pesertaBatch
            ->filter(function (Peserta $peserta) {
                return $this->harusDitindaklanjuti($peserta);
            })
            ->map(function (Peserta $peserta) {
                $peserta->kategori_tindak_lanjut =
                    $this->tentukanKategori($peserta);

                return $peserta;
            })
            ->values();
    }

    /**
     * Menentukan apakah peserta masih harus diproses.
     */
    public function harusDitindaklanjuti(Peserta $peserta): bool
    {
        /*
         * Belum pernah diverifikasi SIPP
         * berarti peserta belum diproses.
         */
        if ($peserta->verifikasiSipp->isEmpty()) {
            return true;
        }

        /*
         * Jika sudah pernah diverifikasi,
         * kita anggap sudah diproses.
         */
        return false;
    }

    /**
     * Menentukan kategori peserta.
     */
    public function tentukanKategori(Peserta $peserta): string
    {
        /*
         * Jika hanya muncul pada satu batch,
         * berarti peserta baru.
         */
        $jumlahBatch = $peserta->batches()->count();

        if ($jumlahBatch <= 1) {
            return 'peserta_baru';
        }

        return 'peserta_lama_belum_diproses';
    }
}

