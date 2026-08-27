<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Peserta;
use App\Models\VerifikasiSipp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiSippController extends Controller
{
    /**
     * Menampilkan form verifikasi SIPP.
     */
    
    public function create(Peserta $peserta)
    {
        $verifikasiTerakhir = $peserta->verifikasiTerakhir;

        Carbon::setLocale('id');

        $bulanSekarang = Carbon::now()->translatedFormat('F Y');

        return view(
            'verifikasi-sipp.create',
            compact(
                'peserta',
                'verifikasiTerakhir',
                'bulanSekarang'
            )
        );
    }


    /**
     * Menyimpan hasil verifikasi SIPP.
     */
    public function store(Request $request, Peserta $peserta)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'tanggal_cek' => [
                'required',
                'date',
            ],

            'terdaftar_rehab' => [
                'required',
                'boolean',
            ],

            'tanggal_daftar_rehab' => [
                'nullable',
                'date',
            ],

            'jumlah_peserta_sipp' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'tagihan_bulan_berjalan' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'tagihan_sebelum_bulan_berjalan' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'status_pembayaran_bulan_berjalan' => [
                'nullable',
                'in:belum_bayar,sudah_bayar',
            ],

            'catatan' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Jika tidak terdaftar REHAB
        |--------------------------------------------------------------------------
        |
        | Data yang hanya relevan untuk peserta REHAB kita kosongkan.
        |
        */

        if (!$validated['terdaftar_rehab']) {

            $validated['tanggal_daftar_rehab'] = null;
            $validated['jumlah_peserta_sipp'] = null;
            $validated['tagihan_bulan_berjalan'] = null;
            $validated['tagihan_sebelum_bulan_berjalan'] = null;
            $validated['status_pembayaran_bulan_berjalan'] = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan sebagai RIWAYAT verifikasi baru
        |--------------------------------------------------------------------------
        */

        if (!Auth::check()) {
            abort(401, 'Anda harus login untuk melakukan verifikasi SIPP.');
        }

        $validated['peserta_id'] = $peserta->id;
        $validated['user_id'] = Auth::id();

        $validated['tagihan_bulan_berjalan'] =
            isset($validated['tagihan_bulan_berjalan'])
                ? round($validated['tagihan_bulan_berjalan'])
                : null;

        $validated['tagihan_sebelum_bulan_berjalan'] =
            isset($validated['tagihan_sebelum_bulan_berjalan'])
                ? round($validated['tagihan_sebelum_bulan_berjalan'])
                : null;

        VerifikasiSipp::create($validated);


        /*
        |--------------------------------------------------------------------------
        | Kembali ke daftar peserta batch
        |--------------------------------------------------------------------------
        */

        $batch = $peserta->batches()
            ->latest('tanggal_data')
            ->first();


        if ($batch) {

            return redirect()
                ->route('batches.show', $batch)
                ->with(
                    'success',
                    "Verifikasi SIPP untuk {$peserta->nama} berhasil disimpan."
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Fallback jika peserta tidak mempunyai batch
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('batches.index')
            ->with(
                'success',
                "Verifikasi SIPP untuk {$peserta->nama} berhasil disimpan."
            );
    }
}