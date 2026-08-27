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
     * Halaman upload Excel.
     */
    public function create()
    {
        return view('batches.create');
    }

    /**
     * Proses import Excel.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_data' => ['required', 'date'],
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ]);

        $file = $request->file('file');

        $namaFile = $file->getClientOriginalName();

        // Cek apakah batch dengan tanggal + file yang sama sudah pernah diimport
        $existingBatch = Batch::where('tanggal_data', $validated['tanggal_data'])
            ->where('nama_file', $namaFile)
            ->first();

        if ($existingBatch) {
            return back()
                ->withErrors([
                    'file' => 'File tersebut sudah pernah diimport untuk tanggal data tersebut.'
                ])
                ->withInput();
        }

        $batch = DB::transaction(function () use ($validated, $file, $namaFile) {

            $batch = Batch::create([
                'tanggal_data' => $validated['tanggal_data'],
                'nama_file' => $namaFile,
                'jumlah_data' => 0,
            ]);

            Excel::import(
                new PesertaImport($batch->id),
                $file
            );

            $batch->update([
                'jumlah_data' => $batch->pesertas()->count(),
            ]);

            return $batch;
        });

        return redirect()
            ->route('batches.create')
            ->with(
                'success',
                "Import berhasil. Batch {$batch->id} berisi {$batch->jumlah_data} peserta."
            );
    }
    /**
     * Menampilkan detail satu batch beserta peserta.
     */
    public function show(Batch $batch)
    {
        $batch->load('pesertas');

        return view('batches.show', compact('batch'));
    }
}