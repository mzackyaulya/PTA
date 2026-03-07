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
        Schema::create('barcode_absensi', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('pertemuan_id');

            $table->string('token');

            $table->timestamp('expired_at');

            $table->unsignedBigInteger('last_scan_siswa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barcode_absensi');
    }
};
