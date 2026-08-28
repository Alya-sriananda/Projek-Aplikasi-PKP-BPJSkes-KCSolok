<?php

namespace App\Services;

use App\Models\Peserta;
use App\Models\TemplateWhatsApp;

class WhatsAppTemplateService
{
    /**
     * Membuat pesan WhatsApp berdasarkan template
     * dan data peserta.
     */
    public function generate(
        Peserta $peserta,
        TemplateWhatsApp $template
    ): string {
        $verifikasi = $peserta->verifikasiSipp()
            ->latest('tanggal_cek')
            ->first();

        $periode = app(PesertaStatusService::class)
            ->periodeTagihan();

        $variables = [
            '{{nama}}' => $peserta->nama ?? '',
            '{{noka}}' => $peserta->noka ?? '',
            '{{no_hp}}' => $peserta->no_hp ?? '',
            '{{email}}' => $peserta->email ?? '',
            '{{alamat}}' => $peserta->alamat ?? '',

            '{{bulan_sebelumnya}}' =>
                $periode['bulan_sebelumnya'],

            '{{bulan_berjalan}}' =>
                $periode['bulan_berjalan'],

            '{{tagihan_bulan_sebelumnya}}' =>
                $this->rupiah(
                    $verifikasi?->tagihan_sebelum_bulan_berjalan
                ),

            '{{tagihan_bulan_berjalan}}' =>
                $this->rupiah(
                    $verifikasi?->tagihan_bulan_berjalan
                ),

            '{{tanggal_daftar_rehab}}' =>
                $verifikasi?->tanggal_daftar_rehab?->format('d-m-Y') ?? '-',

            '{{jumlah_peserta_sipp}}' =>
                $verifikasi?->jumlah_peserta_sipp ?? '-',
        ];

        return strtr(
            $template->isi_template,
            $variables
        );
    }

    /**
     * Format angka menjadi Rupiah.
     */
    private function rupiah($nominal): string
    {
        if ($nominal === null) {
            return '-';
        }

        return 'Rp ' . number_format(
            (float) $nominal,
            0,
            ',',
            '.'
        );
    }
}