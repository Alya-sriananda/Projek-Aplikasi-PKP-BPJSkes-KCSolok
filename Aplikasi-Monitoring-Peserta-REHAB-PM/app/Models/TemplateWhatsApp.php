<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateWhatsApp extends Model
{
    protected $table = 'template_whatsapp';

    protected $fillable = [
        'nama',
        'kode',
        'status_peserta',
        'isi_template',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}