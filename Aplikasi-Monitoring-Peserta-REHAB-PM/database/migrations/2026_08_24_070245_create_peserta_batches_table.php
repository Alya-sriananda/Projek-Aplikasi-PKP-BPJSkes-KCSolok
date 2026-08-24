<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_batches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('batch_id')
                ->constrained('batches')
                ->cascadeOnDelete();

            $table->foreignId('peserta_id')
                ->constrained('pesertas')
                ->cascadeOnDelete();

            $table->timestamps();

            // Satu peserta hanya boleh muncul sekali
            // dalam satu batch.
            $table->unique(['batch_id', 'peserta_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_batches');
    }
};