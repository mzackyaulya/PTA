<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->string('kode_surat')->nullable();

            $table->enum('jenis_surat', [
                'dispensasi',
                'permohonan_lomba',
                'permohonan_organisasi',
                'izin_kegiatan',
                'keterangan',
                'lainnya'
            ]);

            $table->string('judul');
            $table->string('nama_kegiatan')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('tempat_kegiatan')->nullable();

            $table->string('nama_pelatih')->nullable();
            $table->string('nama_organisasi')->nullable();

            $table->text('keperluan');
            $table->text('catatan_waka')->nullable();

            $table->enum('status', [
                'pending',
                'review',
                'selesai',
                'ditolak'
            ])->default('pending');

            $table->uuid('reviewed_by')->nullable();
            $table->foreign('reviewed_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};