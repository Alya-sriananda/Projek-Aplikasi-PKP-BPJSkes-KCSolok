<?php

namespace App\Imports;

use App\Models\Peserta;
use App\Models\PesertaBatch;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PesertaImport implements ToCollection, WithHeadingRow
{
    public function __construct(
        private int $batchId
    ) {}

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {

            // Abaikan baris yang tidak memiliki No Kartu
            if (empty($row['noentitas'])) {
                continue;
            }

            /*
             * 1. Cari peserta berdasarkan NOKA.
             *    Kalau belum ada → buat.
             *    Kalau sudah ada → update data identitasnya.
             */
            $peserta = Peserta::updateOrCreate(
                [
                    'noka' => $row['noentitas'],
                ],
                [
                    'nama' => $row['namaentitas'] ?? null,
                    'no_hp' => $row['nohp'] ?? null,
                    'email' => $row['email'] ?? null,
                    'alamat' => $row['alamat'] ?? null,
                    'status_aktif' => $row['statusaktif'] ?? null,

                    'nopendaftar' => $row['nopendaftar'] ?? null,
                    'nopenghubung' => $row['nopenghubung'] ?? null,

                    'startcicilan' => $this->excelDate(
                        $row['startcicilan'] ?? null
                    ),

                    'endcicilan' => $this->excelDate(
                        $row['endcicilan'] ?? null
                    ),

                    'tglcicilan' => $this->excelDate(
                        $row['tglcicilan'] ?? null
                    ),

                    'tanggal_update_data' => $this->excelDate(
                        $row['tanggalupdatedata'] ?? null
                    ),
                ]
            );

            /*
             * 2. Simpan snapshot data Excel
             *    untuk batch/minggu tersebut.
             */
            PesertaBatch::updateOrCreate(
                [
                    'batch_id' => $this->batchId,
                    'peserta_id' => $peserta->id,
                ],
                [
                    'total_peserta' => $row['total_peserta'] ?? null,
                    'zero' => $row['zero'] ?? null,
                    'bulan_menunggak' => $row['bulan_menunggak'] ?? null,

                    'idcicilan' => $row['idcicilan'] ?? null,
                    'index_data' => $row['index_data'] ?? null,

                    'jml_bulancicil_awal' =>
                        $row['jmlbulancicilawal'] ?? null,

                    'jml_bulan_menunggak_awal' =>
                        $row['jmlbulanmenunggakawal'] ?? null,

                    'kanal_pendaftaran' =>
                        $row['kanal_pendaftaran'] ?? null,

                    'tot_tag_bulan_berjalan_awal' =>
                        $row['tottagbulanberjalanawal'] ?? null,

                    'tot_tag_menunggak_awal' =>
                        $row['tottagmenunggakawal'] ?? null,

                    'tot_tag_sd_bulan_ini_awal' =>
                        $row['tottagsdbulaniniawal'] ?? null,

                    'user_sipp' =>
                        $row['user_sipp'] ?? null,
                ]
            );
        }
    }

    /**
     * Mengubah serial date Excel menjadi format tanggal database.
     */
    private function excelDate(mixed $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)
                ->format('Y-m-d');
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }
}