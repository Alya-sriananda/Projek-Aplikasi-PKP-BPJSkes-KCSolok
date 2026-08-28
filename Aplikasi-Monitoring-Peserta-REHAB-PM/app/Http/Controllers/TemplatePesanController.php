<?php

namespace App\Http\Controllers;

use App\Models\TemplatePesan;
use Illuminate\Http\Request;

class TemplatePesanController extends Controller
{
    /**
     * Menampilkan daftar template.
     */
    public function index()
    {
        $templates = TemplatePesan::latest()->get();

        return view(
            'template-pesan.index',
            compact('templates')
        );
    }

    /**
     * Menampilkan form membuat template.
     */
    public function create()
    {
        return view('template-pesan.create');
    }

    /**
     * Menyimpan template baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_template' => [
                'required',
                'string',
                'max:100',
            ],

            'isi_template' => [
                'required',
                'string',
            ],

            'aktif' => [
                'nullable',
                'boolean',
            ],
        ]);

        TemplatePesan::create([
            'nama_template' => $validated['nama_template'],
            'isi_template' => $validated['isi_template'],
            'aktif' => $request->boolean('aktif'),
        ]);

        return redirect()
            ->route('template-pesan.index')
            ->with(
                'success',
                'Template WhatsApp berhasil dibuat.'
            );
    }
}