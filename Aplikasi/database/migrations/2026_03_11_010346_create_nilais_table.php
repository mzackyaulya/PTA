<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('siswa_id');
            $table->uuid('mapel_id');
            $table->uuid('guru_id');
            $table->uuid('kelas_id');
            $table->uuid('tahun_ajaran_id');

            $table->integer('kkm')->default(75);

            $table->decimal('nilai_pengetahuan', 5, 2)->nullable();
            $table->string('predikat_pengetahuan')->nullable();

            $table->decimal('nilai_keterampilan', 5, 2)->nullable();
            $table->string('predikat_keterampilan')->nullable();

            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->string('predikat_akhir')->nullable();

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswas')->cascadeOnDelete();
            $table->foreign('mapel_id')->references('id')->on('mapels')->cascadeOnDelete();
            $table->foreign('guru_id')->references('id')->on('gurus')->cascadeOnDelete();
            $table->foreign('kelas_id')->references('id')->on('kelas')->cascadeOnDelete();
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajarans')->cascadeOnDelete();

            $table->unique([
                'siswa_id',
                'mapel_id',
                'guru_id',
                'kelas_id',
                'tahun_ajaran_id'
            ], 'nilai_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};