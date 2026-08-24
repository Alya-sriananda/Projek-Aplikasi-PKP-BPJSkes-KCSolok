<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komunikasis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peserta_id')
                ->constrained('pesertas')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('no_hp', 20);

            // Template yang digunakan
            $table->string('template', 50)->nullable();

            // Pesan final yang dibuat sistem
            $table->text('pesan')->nullable();

            $table->string('status', 50);

            $table->dateTime('tanggal_dihubungi')->nullable();

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komunikasis');
    }
};