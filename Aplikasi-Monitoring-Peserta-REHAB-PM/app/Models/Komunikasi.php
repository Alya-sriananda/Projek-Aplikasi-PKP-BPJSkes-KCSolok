<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Komunikasi extends Model
{
    protected $fillable = [
        'peserta_id',
        'user_id',
        'no_hp',
        'template',
        'pesan',
        'status',
        'tanggal_dihubungi',
        'catatan',
    ];

    protected $casts = [
        'tanggal_dihubungi' => 'datetime',
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