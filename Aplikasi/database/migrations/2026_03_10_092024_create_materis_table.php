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
        Schema::create('materis', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('mapel_id');
            $table->uuid('guru_id');

            $table->foreign('mapel_id')
                ->references('id')
                ->on('mapels')
                ->cascadeOnDelete();

            $table->foreign('guru_id')
                ->references('id')
                ->on('gurus')
                ->cascadeOnDelete();

            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('file');
            $table->integer('materi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
