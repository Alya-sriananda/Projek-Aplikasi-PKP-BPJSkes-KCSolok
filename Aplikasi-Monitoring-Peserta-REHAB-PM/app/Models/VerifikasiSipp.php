<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerifikasiSipp extends Model
{
    protected $fillable = [
        'peserta_id',
        'user_id',
        'tanggal_cek',
        'terdaftar_rehab',
        'tanggal_daftar_rehab',
        'jumlah_peserta_sipp',
        'tagihan_bulan_berjalan',
        'tagihan_sebelum_bulan_berjalan',
        'status_pembayaran_bulan_berjalan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_cek' => 'date',
        'tanggal_daftar_rehab' => 'date',

        'terdaftar_rehab' => 'boolean',

        'tagihan_bulan_berjalan' => 'decimal:2',
        'tagihan_sebelum_bulan_berjalan' => 'decimal:2',

        'jumlah_peserta_sipp' => 'integer',
    ];

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}