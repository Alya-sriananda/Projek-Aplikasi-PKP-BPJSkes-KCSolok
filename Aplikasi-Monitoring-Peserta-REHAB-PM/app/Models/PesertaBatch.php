<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesertaBatch extends Model
{
    protected $fillable = [
        'batch_id',
        'peserta_id',

        'total_peserta',
        'zero',
        'bulan_menunggak',

        'idcicilan',
        'index_data',

        'jml_bulancicil_awal',
        'jml_bulan_menunggak_awal',

        'kanal_pendaftaran',

        'tot_tag_bulan_berjalan_awal',
        'tot_tag_menunggak_awal',
        'tot_tag_sd_bulan_ini_awal',

        'user_sipp',

        // Status proses
        'status_proses',
        'tanggal_proses',
        'user_proses',
        'catatan_proses',
    ];

    protected $casts = [
        'total_peserta' => 'integer',
        'zero' => 'integer',
        'bulan_menunggak' => 'integer',

        'jml_bulancicil_awal' => 'integer',
        'jml_bulan_menunggak_awal' => 'integer',

        'tot_tag_bulan_berjalan_awal' => 'decimal:2',
        'tot_tag_menunggak_awal' => 'decimal:2',
        'tot_tag_sd_bulan_ini_awal' => 'decimal:2',

        'tanggal_proses' => 'datetime',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class);
    }

    public function userProses(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_proses');
    }
}