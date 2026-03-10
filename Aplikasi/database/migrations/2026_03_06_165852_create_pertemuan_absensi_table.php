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
        Schema::create('pertemuan_absensi', function (Blueprint $table) {
           $table->uuid('id')->primary();

            $table->uuid('mengajar_id');
            $table->date('tanggal');
            $table->integer('pertemuan_ke');

            $table->boolean('is_approved')->default(false); // acc admin
            $table->boolean('is_started')->default(false); // mulai oleh guru
            $table->boolean('is_closed')->default(false); // absensi ditutup
            $table->boolean('is_saved')->default(false); // absensi disimpan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertemuan_absensi');
    }
};
