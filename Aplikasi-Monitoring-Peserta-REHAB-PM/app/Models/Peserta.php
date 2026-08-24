<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peserta extends Model
{
    protected $fillable = [
        'noka',
        'nama',
        'no_hp',
        'email',
        'alamat',
        'status_aktif',
        'nopendaftar',
        'nopenghubung',
        'startcicilan',
        'endcicilan',
        'tglcicilan',
        'tanggal_update_data',
    ];

    protected $casts = [
        'startcicilan' => 'date',
        'endcicilan' => 'date',
        'tglcicilan' => 'date',
        'tanggal_update_data' => 'date',
    ];

    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'peserta_batches');
    }

    public function verifikasiSipp(): HasMany
    {
        return $this->hasMany(VerifikasiSipp::class);
    }

    public function komunikasi(): HasMany
    {
        return $this->hasMany(Komunikasi::class);
    }
}