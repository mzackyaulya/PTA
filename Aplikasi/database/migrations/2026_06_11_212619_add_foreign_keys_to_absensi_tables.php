<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Foreign key untuk pertemuan_absensi
        |--------------------------------------------------------------------------
        */
        Schema::table('pertemuan_absensi', function (Blueprint $table) {
            $table->foreign('mengajar_id')
                ->references('id')
                ->on('mengajars')
                ->cascadeOnDelete();

            $table->unique(
                ['mengajar_id', 'tanggal'],
                'unique_pertemuan_mengajar_tanggal'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Foreign key untuk absensis
        |--------------------------------------------------------------------------
        */
        Schema::table('absensis', function (Blueprint $table) {
            $table->foreign('pertemuan_id')
                ->references('id')
                ->on('pertemuan_absensi')
                ->cascadeOnDelete();

            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswas')
                ->cascadeOnDelete();

            $table->unique(
                ['pertemuan_id', 'siswa_id'],
                'unique_absensi_pertemuan_siswa'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Foreign key untuk barcode_absensi
        |--------------------------------------------------------------------------
        */
        Schema::table('barcode_absensi', function (Blueprint $table) {
            $table->foreign('pertemuan_id')
                ->references('id')
                ->on('pertemuan_absensi')
                ->cascadeOnDelete();

            $table->foreign('last_scan_siswa')
                ->references('id')
                ->on('siswas')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('barcode_absensi', function (Blueprint $table) {
            $table->dropForeign(['pertemuan_id']);
            $table->dropForeign(['last_scan_siswa']);
        });

        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['pertemuan_id']);
            $table->dropForeign(['siswa_id']);
            $table->dropUnique('unique_absensi_pertemuan_siswa');
        });

        Schema::table('pertemuan_absensi', function (Blueprint $table) {
            $table->dropForeign(['mengajar_id']);
            $table->dropUnique('unique_pertemuan_mengajar_tanggal');
        });
    }
};