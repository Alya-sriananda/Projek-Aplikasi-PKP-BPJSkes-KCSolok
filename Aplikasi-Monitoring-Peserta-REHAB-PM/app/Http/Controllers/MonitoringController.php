<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Peserta;
use App\Services\PesertaStatusService;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function __construct(
        protected PesertaStatusService $statusService
    ) {
    }

    /**
     * Menampilkan monitoring peserta dalam sebuah batch.
     */
    public function index(Request $request, Batch $batch)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil periode tagihan
        |--------------------------------------------------------------------------
        */
        $periode = $this->statusService->periodeTagihan();

        /*
        |--------------------------------------------------------------------------
        | Query peserta dalam batch
        |--------------------------------------------------------------------------
        |
        | Kita ambil verifikasi terakhir sekaligus agar tidak terjadi
        | query berulang-ulang ketika menampilkan tabel.
        |
        */
        $query = $batch->pesertas()
            ->with([
                'verifikasiTerakhir',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Pencarian
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('noka', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil data
        |--------------------------------------------------------------------------
        */
        $pesertas = $query
            ->orderBy('nama')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Tentukan status setiap peserta
        |--------------------------------------------------------------------------
        */
        $pesertas->each(function ($peserta) {

            $peserta->status_monitoring =
                $this->statusService->tentukan($peserta);
        });

        /*
        |--------------------------------------------------------------------------
        | Filter berdasarkan status
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {

            $pesertas = $pesertas->filter(function ($peserta) use ($request) {

                return $peserta->status_monitoring['kode']
                    === $request->status;
            })->values();
        }

        /*
        |--------------------------------------------------------------------------
        | Statistik monitoring
        |--------------------------------------------------------------------------
        */
        $statistik = [
            'total' => $pesertas->count(),

            'belum_diverifikasi' => $pesertas
                ->where('status_monitoring.kode', 'belum_diverifikasi')
                ->count(),

            'tidak_rehab' => $pesertas
                ->where('status_monitoring.kode', 'tidak_rehab')
                ->count(),

            'masih_ada_tunggakan' => $pesertas
                ->where('status_monitoring.kode', 'masih_ada_tunggakan')
                ->count(),

            'belum_bayar_bulan_berjalan' => $pesertas
                ->where(
                    'status_monitoring.kode',
                    'belum_bayar_bulan_berjalan'
                )
                ->count(),

            'sudah_bayar' => $pesertas
                ->where('status_monitoring.kode', 'sudah_bayar')
                ->count(),

            'perlu_dicek' => $pesertas
                ->where('status_monitoring.kode', 'perlu_dicek')
                ->count(),
        ];

        return view(
            'monitoring.index',
            compact(
                'batch',
                'pesertas',
                'periode',
                'statistik'
            )
        );
        
    }
    /**
     * Menampilkan detail peserta.
     */
    public function show(Batch $batch, $peserta)
    {
        $peserta = $batch->pesertas()
            ->with([
                'verifikasiSipp' => function ($query) {
                    $query->latest('tanggal_cek');
                },
                'verifikasiTerakhir',
            ])
            ->where('pesertas.id', $peserta)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Ambil anggota keluarga berdasarkan nomor HP
        |--------------------------------------------------------------------------
        */
        $anggotaKeluarga = collect();

        if (!empty($peserta->no_hp)) {
            $anggotaKeluarga = Peserta::where('no_hp', $peserta->no_hp)
                ->where('id', '!=', $peserta->id)
                ->with('verifikasiTerakhir')
                ->orderBy('nama')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Tentukan status peserta utama
        |--------------------------------------------------------------------------
        */
        $peserta->status_monitoring =
            $this->statusService->tentukan($peserta);

        /*
        |--------------------------------------------------------------------------
        | Tentukan status anggota keluarga
        |--------------------------------------------------------------------------
        */
        $anggotaKeluarga->each(function ($anggota) {

            $anggota->status_monitoring =
                $this->statusService->tentukan($anggota);
        });

        /*
        |--------------------------------------------------------------------------
        | Periode tagihan
        |--------------------------------------------------------------------------
        */
        $periode = $this->statusService->periodeTagihan();

        return view(
            'monitoring.show',
            compact(
                'batch',
                'peserta',
                'anggotaKeluarga',
                'periode'
            )
        );
    }
}