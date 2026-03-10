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
        Schema::create('nilais', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('siswa_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('mapel_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('guru_id')->constrained()->cascadeOnDelete();

            $table->foreignUuid('kelas_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('tahun_ajaran_id')->constrained()->cascadeOnDelete();

            $table->integer('tugas')->nullable();
            $table->integer('uts')->nullable();
            $table->integer('uas')->nullable();

            $table->decimal('nilai_akhir',5,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
