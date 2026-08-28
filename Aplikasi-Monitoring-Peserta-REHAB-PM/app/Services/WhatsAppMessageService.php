<?php

namespace App\Services;
use App\Models\VerifikasiSipp;
use App\Models\Peserta;
use App\Models\TemplatePesan;

class WhatsAppMessageService
{
    public function generate(
        Peserta $peserta,
        VerifikasiSipp $verifikasi,
        TemplatePesan $template
    ): string {
        $statusService = app(PesertaStatusService::class);

        $periode = $statusService->periodeTagihan();

        $verifikasi = $peserta->verifikasiTerakhir;

        $tagihanSebelumnya = $verifikasi
            ? $verifikasi->tagihan_sebelum_bulan_berjalan
            : 0;

        $tagihanBerjalan = $verifikasi
            ? $verifikasi->tagihan_bulan_berjalan
            : 0;

        $variables = [
            '{nama}' => $peserta->nama ?? '',
            '{noka}' => $peserta->noka ?? '',
            '{no_hp}' => $peserta->no_hp ?? '',
            '{email}' => $peserta->email ?? '',
            '{jumlah_peserta_sipp}' => $verifikasi
                ? $verifikasi->jumlah_peserta_sipp
                : 0,
            '{tanggal_daftar_rehab}' => $verifikasi
                ? $verifikasi->tanggal_daftar_rehab?->format('d-m-Y')
                : '',

            '{bulan_sebelumnya}' => $periode['bulan_sebelumnya'],
            '{bulan_berjalan}' => $periode['bulan_berjalan'],

            '{tagihan_sebelumnya}' => $this->rupiah(
                $tagihanSebelumnya
            ),

            '{tagihan_berjalan}' => $this->rupiah(
                $tagihanBerjalan
            ),
            '{total_tagihan}' => $this->rupiah(
                $tagihanSebelumnya + $tagihanBerjalan
            ),
        ];

        return str_replace(
            array_keys($variables),
            array_values($variables),
            $template->isi_template
        );
    }

    private function rupiah($nominal): string
    {
        return 'Rp ' . number_format(
            (float) $nominal,
            0,
            ',',
            '.'
        );
    }
}