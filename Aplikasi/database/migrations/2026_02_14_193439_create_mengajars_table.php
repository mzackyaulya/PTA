<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mengajars', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('guru_id');
            $table->uuid('mapel_id');
            $table->uuid('kelas_id');
            $table->uuid('tahun_ajaran_id');

            $table->string('hari');
            $table->integer('jam_ke');

            $table->timestamps();

            $table->foreign('guru_id')->references('id')->on('gurus')->cascadeOnDelete();
            $table->foreign('mapel_id')->references('id')->on('mapels')->cascadeOnDelete();
            $table->foreign('kelas_id')->references('id')->on('kelas')->cascadeOnDelete();
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajarans')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mengajars');
    }
};
