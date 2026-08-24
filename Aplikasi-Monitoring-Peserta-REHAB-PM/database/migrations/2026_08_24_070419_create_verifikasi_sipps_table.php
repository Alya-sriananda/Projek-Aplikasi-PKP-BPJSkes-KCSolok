<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi_sipps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peserta_id')
                ->constrained('pesertas')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Kapan pegawai melakukan pengecekan SIPP
            $table->date('tanggal_cek');

            // Hasil pengecekan
            $table->boolean('terdaftar_rehab')->default(false);

            $table->date('tanggal_daftar_rehab')->nullable();

            // Jumlah peserta yang terlihat pada SIPP
            $table->unsignedInteger('jumlah_peserta_sipp')->nullable();

            // Nominal tagihan
            $table->decimal('tagihan_bulan_berjalan', 15, 2)->nullable();

            $table->decimal('tagihan_sebelum_bulan_berjalan', 15, 2)->nullable();

            // Contoh: sudah_bayar / belum_bayar
            $table->string('status_pembayaran_bulan_berjalan', 30)->nullable();

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi_sipps');
    }
};