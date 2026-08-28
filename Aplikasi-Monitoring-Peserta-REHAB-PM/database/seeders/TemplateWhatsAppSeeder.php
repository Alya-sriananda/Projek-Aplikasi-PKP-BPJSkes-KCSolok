<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TemplateWhatsApp;

class TemplateWhatsAppSeeder extends Seeder
{
    public function run(): void
    {
        TemplateWhatsApp::create([
            'nama' => 'Belum Bayar Bulan Berjalan',
            'kode' => 'belum_bayar_bulan_berjalan',
            'status_peserta' => 'belum_bayar_bulan_berjalan',
            'isi_template' => <<<TEXT
Yth. Bapak/Ibu {{nama}},

Kami menginformasikan terkait pembayaran iuran program REHAB BPJS Kesehatan.

No. Kartu: {{noka}}

Tagihan {{bulan_sebelumnya}}: {{tagihan_bulan_sebelumnya}}
Tagihan {{bulan_berjalan}}: {{tagihan_bulan_berjalan}}

Mohon untuk melakukan pembayaran sesuai ketentuan yang berlaku.

Terima kasih.
TEXT,
            'aktif' => true,
        ]);

        TemplateWhatsApp::create([
            'nama' => 'Masih Ada Tunggakan Sebelumnya',
            'kode' => 'masih_menunggak_sebelumnya',
            'status_peserta' => 'masih_menunggak_sebelumnya',
            'isi_template' => <<<TEXT
Yth. Bapak/Ibu {{nama}},

Kami mengingatkan bahwa masih terdapat tagihan yang perlu diperhatikan.

No. Kartu: {{noka}}

Tagihan {{bulan_sebelumnya}}: {{tagihan_bulan_sebelumnya}}
Tagihan {{bulan_berjalan}}: {{tagihan_bulan_berjalan}}

Mohon dapat melakukan pembayaran sesuai ketentuan program REHAB BPJS Kesehatan.

Terima kasih.
TEXT,
            'aktif' => true,
        ]);

        TemplateWhatsApp::create([
            'nama' => 'Sudah Bayar Bulan Berjalan',
            'kode' => 'sudah_bayar_bulan_berjalan',
            'status_peserta' => 'sudah_bayar_bulan_berjalan',
            'isi_template' => <<<TEXT
Yth. Bapak/Ibu {{nama}},

Terima kasih atas pembayaran iuran REHAB BPJS Kesehatan.

No. Kartu: {{noka}}

Tagihan {{bulan_sebelumnya}}: {{tagihan_bulan_sebelumnya}}
Tagihan {{bulan_berjalan}}: {{tagihan_bulan_berjalan}}

Terima kasih atas perhatian dan kerja samanya.
TEXT,
            'aktif' => true,
        ]);
    }
}