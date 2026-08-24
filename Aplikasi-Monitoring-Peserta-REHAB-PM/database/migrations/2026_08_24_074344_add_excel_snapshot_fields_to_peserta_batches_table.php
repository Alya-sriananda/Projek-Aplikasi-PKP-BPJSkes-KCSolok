<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peserta_batches', function (Blueprint $table) {

            // Data snapshot dari Excel mingguan
            $table->unsignedInteger('total_peserta')->nullable();
            $table->unsignedInteger('zero')->nullable();
            $table->unsignedInteger('bulan_menunggak')->nullable();

            $table->string('idcicilan', 50)->nullable();
            $table->string('index_data', 100)->nullable();

            $table->unsignedInteger('jml_bulancicil_awal')->nullable();
            $table->unsignedInteger('jml_bulan_menunggak_awal')->nullable();

            $table->string('kanal_pendaftaran', 100)->nullable();

            $table->decimal(
                'tot_tag_bulan_berjalan_awal',
                15,
                2
            )->nullable();

            $table->decimal(
                'tot_tag_menunggak_awal',
                15,
                2
            )->nullable();

            $table->decimal(
                'tot_tag_sd_bulan_ini_awal',
                15,
                2
            )->nullable();

            $table->string('user_sipp', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('peserta_batches', function (Blueprint $table) {

            $table->dropColumn([
                'total_peserta',
                'zero',
                'bulan_menunggak',
                'idcicilan',
                'index_data',
                'jml_bulancicil_awal',
                'jml_bulan_menunggak_awal',
                'kanal_pendaftaran',
                'tot_tag_bulan_berjalan_awal',
                'tot_tag_menunggak_awal',
                'tot_tag_sd_bulan_ini_awal',
                'user_sipp',
            ]);
        });
    }
};