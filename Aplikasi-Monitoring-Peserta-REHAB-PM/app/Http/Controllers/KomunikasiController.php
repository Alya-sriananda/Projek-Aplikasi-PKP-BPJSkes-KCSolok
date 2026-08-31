<?php

namespace App\Http\Controllers;

use App\Models\Komunikasi;
use App\Models\Peserta;
use App\Models\TemplatePesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomunikasiController extends Controller
{
    /**
     * Halaman komunikasi peserta.
     */
    public function create(Peserta $peserta)
    {
        $templates = TemplatePesan::query()
            ->latest()
            ->get();

        return view(
            'komunikasi.create',
            compact(
                'peserta',
                'templates'
            )
        );
    }


    /**
     * Simpan riwayat komunikasi.
     */
    public function store(
        Request $request,
        Peserta $peserta
    ) {
        $validated = $request->validate([

            'no_hp' => [
                'required',
                'string',
                'max:30',
            ],

            'template' => [
                'nullable',
                'string',
                'max:255',
            ],

            'pesan' => [
                'required',
                'string',
            ],

            'status' => [
                'required',
                'in:sudah_dihubungi,gagal',
            ],

            'tanggal_dihubungi' => [
                'required',
                'date',
            ],

            'catatan' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ]);


        Komunikasi::create([

            'peserta_id' => $peserta->id,

            'user_id' => Auth::id(),

            'no_hp' => $validated['no_hp'],

            'template' => $validated['template'],

            'pesan' => $validated['pesan'],

            'status' => $validated['status'],

            'tanggal_dihubungi' =>
                $validated['tanggal_dihubungi'],

            'catatan' =>
                $validated['catatan'] ?? null,

        ]);


        return redirect()
            ->route('tindak-lanjut.index')
            ->with(
                'success',
                "Komunikasi untuk {$peserta->nama} berhasil disimpan."
            );
    }
}