<?php

namespace App\Services;

use App\Models\Peserta;
use App\Models\VerifikasiSipp;
use Carbon\Carbon;

class WhatsAppTemplateService
{
    public function generate(
        Peserta $peserta,
        VerifikasiSipp $verifikasi,
        string $statusKode
    ): string {
        $bulan = Carbon::now()
            ->locale('id')
            ->translatedFormat('F Y');

        $nama = $peserta->nama;

        $tagihanBerjalan = $this->formatRupiah(
            $verifikasi->tagihan_bulan_berjalan
        );

        $tagihanSebelumnya = $this->formatRupiah(
            $verifikasi->tagihan_sebelum_bulan_berjalan
        );

        /*
        |--------------------------------------------------------------------------
        | BELUM BAYAR BULAN BERJALAN
        |--------------------------------------------------------------------------
        */
        if ($statusKode === 'belum_bayar_bulan_berjalan') {
            return
                "Yth. Bapak/Ibu {$nama},\n\n" .
                "Kami mengingatkan terkait pembayaran iuran REHAB BPJS Kesehatan untuk bulan {$bulan}.\n\n" .
                "Tagihan bulan {$bulan}: {$tagihanBerjalan}\n\n" .
                "Mohon dapat melakukan pembayaran sesuai jadwal yang telah ditentukan.\n\n" .
                "Terima kasih atas perhatian dan kerja samanya.";
        }

        /*
        |--------------------------------------------------------------------------
        | TUNGGAKAN SEBELUMNYA + BELUM BAYAR BULAN BERJALAN
        |--------------------------------------------------------------------------
        */
        if (
            $statusKode ===
            'tunggakan_sebelumnya_belum_bayar_berjalan'
        ) {
            return
                "Yth. Bapak/Ibu {$nama},\n\n" .
                "Kami mengingatkan terkait kewajiban pembayaran iuran REHAB BPJS Kesehatan.\n\n" .
                "Saat ini masih terdapat tunggakan sebelum bulan {$bulan} sebesar {$tagihanSebelumnya} dan tagihan bulan {$bulan} sebesar {$tagihanBerjalan} yang belum dibayarkan.\n\n" .
                "Mohon dapat melakukan pembayaran sesuai ketentuan yang berlaku.\n\n" .
                "Terima kasih atas perhatian dan kerja samanya.";
        }

        /*
        |--------------------------------------------------------------------------
        | TUNGGAKAN SEBELUMNYA
        |--------------------------------------------------------------------------
        */
        if ($statusKode === 'tunggakan_sebelumnya') {
            return
                "Yth. Bapak/Ibu {$nama},\n\n" .
                "Kami menginformasikan bahwa pembayaran iuran REHAB BPJS Kesehatan bulan {$bulan} telah tercatat.\n\n" .
                "Namun, masih terdapat tunggakan sebelum bulan {$bulan} sebesar {$tagihanSebelumnya}.\n\n" .
                "Mohon dapat melakukan penyelesaian atas tunggakan tersebut sesuai ketentuan yang berlaku.\n\n" .
                "Terima kasih atas perhatian dan kerja samanya.";
        }

        /*
        |--------------------------------------------------------------------------
        | FALLBACK
        |--------------------------------------------------------------------------
        */
        return
            "Yth. Bapak/Ibu {$nama},\n\n" .
            "Kami ingin menyampaikan informasi terkait kepesertaan REHAB BPJS Kesehatan.\n\n" .
            "Mohon dapat menghubungi petugas untuk informasi lebih lanjut.\n\n" .
            "Terima kasih.";
    }

    private function formatRupiah($nominal): string
    {
        return 'Rp ' . number_format(
            (float) ($nominal ?? 0),
            0,
            ',',
            '.'
        );
    }
}