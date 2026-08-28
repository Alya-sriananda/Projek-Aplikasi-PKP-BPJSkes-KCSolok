<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peserta_batches', function (Blueprint $table) {
            $table->string('status_proses', 30)
                ->default('belum_diproses')
                ->after('user_sipp');

            $table->timestamp('tanggal_proses')
                ->nullable()
                ->after('status_proses');

            $table->foreignId('user_proses')
                ->nullable()
                ->after('tanggal_proses')
                ->constrained('users')
                ->nullOnDelete();

            $table->text('catatan_proses')
                ->nullable()
                ->after('user_proses');
        });
    }

    public function down(): void
    {
        Schema::table('peserta_batches', function (Blueprint $table) {
            $table->dropForeign(['user_proses']);

            $table->dropColumn([
                'status_proses',
                'tanggal_proses',
                'user_proses',
                'catatan_proses',
            ]);
        });
    }
};