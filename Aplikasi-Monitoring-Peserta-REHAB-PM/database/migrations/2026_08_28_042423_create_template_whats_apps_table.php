<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_whatsapp', function (Blueprint $table) {
            $table->id();

            $table->string('nama');

            $table->string('kode')->unique();

            $table->string('status_peserta')->nullable();

            $table->text('isi_template');

            $table->boolean('aktif')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_whatsapp');
    }
};