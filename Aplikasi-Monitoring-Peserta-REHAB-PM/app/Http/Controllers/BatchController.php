<?php

namespace App\Http\Controllers;

use App\Imports\PesertaImport;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BatchController extends Controller
{
    /**
     * Menampilkan daftar seluruh batch import.
     */
    public function index()
    {
        $batches = Batch::withCount('pesertas')
            ->latest('tanggal_data')
            ->latest('id')
            ->paginate(10);

        return view('batches.index', compact('batches'));
    }

    /**
     * Halaman upload Excel.
     */
    public function create()
    {
        return view('batches.create');
    }

    /**
     * Menampilkan detail satu batch beserta peserta di dalamnya.
     */
    public function show(Batch $batch)
    {
        $batch->load([
            'pesertas' => function ($query) {
                $query->orderBy('nama');
            }
        ]);

        return view('batches.show', compact('batch'));
    }

    /**
     * Proses import Excel.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. VALIDASI INPUT
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'tanggal_data' => [
                'required',
                'date',
            ],

            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | 2. AMBIL INFORMASI FILE
        |--------------------------------------------------------------------------
        */

        $file = $request->file('file');

        $namaFile = $file->getClientOriginalName();


        /*
        |--------------------------------------------------------------------------
        | 3. CEK DUPLIKASI BATCH
        |--------------------------------------------------------------------------
        |
        | Satu file dengan tanggal data yang sama tidak boleh diimport
        | dua kali.
        |
        */

        $existingBatch = Batch::where(
            'tanggal_data',
            $validated['tanggal_data']
        )
            ->where(
                'nama_file',
                $namaFile
            )
            ->first();


        if ($existingBatch) {
            return back()
                ->withErrors([
                    'file' => 'File tersebut sudah pernah diimport untuk tanggal data tersebut.'
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | 4. PROSES IMPORT DALAM DATABASE TRANSACTION
        |--------------------------------------------------------------------------
        |
        | Jika import gagal di tengah jalan, perubahan database dibatalkan.
        |
        */

        try {

            $batch = DB::transaction(function () use (
                $validated,
                $file,
                $namaFile
            ) {

                /*
                |--------------------------------------------------------------------------
                | Buat batch terlebih dahulu
                |--------------------------------------------------------------------------
                */

                $batch = Batch::create([
                    'tanggal_data' => $validated['tanggal_data'],
                    'nama_file' => $namaFile,
                    'jumlah_data' => 0,
                ]);


                /*
                |--------------------------------------------------------------------------
                | Import peserta dari Excel
                |--------------------------------------------------------------------------
                */

                Excel::import(
                    new PesertaImport($batch->id),
                    $file
                );


                /*
                |--------------------------------------------------------------------------
                | Hitung jumlah peserta yang berhasil masuk ke batch
                |--------------------------------------------------------------------------
                */

                $batch->update([
                    'jumlah_data' => $batch->pesertas()->count(),
                ]);


                return $batch;
            });


            /*
            |--------------------------------------------------------------------------
            | 5. BERHASIL
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('batches.show', $batch)
                ->with(
                    'success',
                    "Import berhasil. Batch {$batch->id} berisi {$batch->jumlah_data} peserta."
                );

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | 6. JIKA IMPORT GAGAL
            |--------------------------------------------------------------------------
            */

            return back()
                ->withErrors([
                    'file' => 'Import gagal: ' . $e->getMessage(),
                ])
                ->withInput();
        }
    }
}