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
        Schema::create('surat_siswas', function (Blueprint $table) {
            $table->id();

            $table->uuid('surat_id');
            $table->foreign('surat_id')
                ->references('id')
                ->on('surats')
                ->onDelete('cascade');

            $table->uuid('siswa_id');
            $table->foreign('siswa_id')
                ->references('id')
                ->on('siswas')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['surat_id', 'siswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_siswas');
    }
};
