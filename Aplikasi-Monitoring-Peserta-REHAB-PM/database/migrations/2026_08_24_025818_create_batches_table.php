<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();

            // Tanggal laporan/data mingguan
            $table->date('tanggal_data');

            // Nama file Excel yang diimport
            $table->string('nama_file');

            // Jumlah baris peserta dari file Excel
            $table->unsignedInteger('jumlah_data')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};