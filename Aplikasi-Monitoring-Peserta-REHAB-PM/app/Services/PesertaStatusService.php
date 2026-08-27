<?php

namespace App\Services;

use App\Models\Peserta;
use Carbon\Carbon;

class PesertaStatusService
{
    /**
     * Menentukan status peserta berdasarkan
     * hasil verifikasi SIPP terakhir.
     */
    public function tentukan(Peserta $peserta): array
    {
        $verifikasi = $peserta->verifikasiTerakhir;

        /*
        |--------------------------------------------------------------------------
        | Belum pernah diverifikasi
        |--------------------------------------------------------------------------
        */
        if (!$verifikasi) {
            return [
                'kode' => 'belum_diverifikasi',
                'label' => 'Belum Diverifikasi',
                'tipe' => 'warning',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Tidak terdaftar REHAB
        |--------------------------------------------------------------------------
        */
        if (!$verifikasi->terdaftar_rehab) {
            return [
                'kode' => 'tidak_rehab',
                'label' => 'Tidak REHAB',
                'tipe' => 'secondary',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Terdaftar REHAB
        |--------------------------------------------------------------------------
        |
        | Kita melihat DUA tagihan:
        |
        | 1. Tagihan sebelum bulan berjalan
        | 2. Tagihan bulan berjalan
        |
        */
        $tagihanSebelumnya =
            (float) ($verifikasi->tagihan_sebelum_bulan_berjalan ?? 0);

        $tagihanBerjalan =
            (float) ($verifikasi->tagihan_bulan_berjalan ?? 0);

        $statusPembayaran =
            $verifikasi->status_pembayaran_bulan_berjalan;

        /*
        |--------------------------------------------------------------------------
        | Belum bayar
        |--------------------------------------------------------------------------
        |
        | Jika masih ada tagihan sebelum bulan berjalan,
        | peserta masih mempunyai tunggakan.
        |
        */
        if ($tagihanSebelumnya > 0) {
            return [
                'kode' => 'masih_ada_tunggakan',
                'label' => 'Masih Ada Tunggakan',
                'tipe' => 'danger',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Belum bayar bulan berjalan
        |--------------------------------------------------------------------------
        */
        if (
            $tagihanBerjalan > 0 &&
            $statusPembayaran === 'belum_bayar'
        ) {
            return [
                'kode' => 'belum_bayar_bulan_berjalan',
                'label' => 'Belum Bayar Bulan Berjalan',
                'tipe' => 'danger',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Sudah bayar
        |--------------------------------------------------------------------------
        */
        if (
            $statusPembayaran === 'sudah_bayar'
        ) {
            return [
                'kode' => 'sudah_bayar',
                'label' => 'Sudah Bayar',
                'tipe' => 'success',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Kondisi data belum dapat ditentukan
        |--------------------------------------------------------------------------
        */
        return [
            'kode' => 'perlu_dicek',
            'label' => 'Perlu Dicek',
            'tipe' => 'warning',
        ];
    }

    /**
     * Mendapatkan nama bulan sebelumnya
     * dan bulan berjalan secara otomatis.
     */
    public function periodeTagihan(): array
    {
        $sekarang = Carbon::now();

        return [
            'bulan_sebelumnya' =>
                $sekarang->copy()
                    ->subMonth()
                    ->translatedFormat('F Y'),

            'bulan_berjalan' =>
                $sekarang->translatedFormat('F Y'),
        ];
    }
}