<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Batch extends Model
{
    protected $fillable = [
        'tanggal_data',
        'nama_file',
        'jumlah_data',
    ];

    protected $casts = [
        'tanggal_data' => 'date',
    ];

    public function pesertas(): BelongsToMany
    {
        return $this->belongsToMany(Peserta::class, 'peserta_batches');
    }
}