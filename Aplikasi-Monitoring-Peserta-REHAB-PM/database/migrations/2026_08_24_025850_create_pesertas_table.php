<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();

            // Identitas individu peserta
            $table->string('noka', 20)->unique();

            $table->string('nama');

            // Nomor HP boleh sama untuk beberapa peserta
            $table->string('no_hp', 20)->nullable();

            $table->string('email')->nullable();

            $table->text('alamat')->nullable();

            $table->string('status_aktif', 50)->nullable();

            // Field dari Excel yang masih relevan
            $table->string('nopendaftar', 30)->nullable();
            $table->string('nopenghubung', 30)->nullable();

            $table->date('startcicilan')->nullable();
            $table->date('endcicilan')->nullable();
            $table->date('tglcicilan')->nullable();

            $table->date('tanggal_update_data')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};