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
        Schema::create('gurus', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke users
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // Identitas utama guru
            $table->string('nip')->unique();
            $table->string('nik')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('nama');
            $table->string('jenis_kelamin');

            // Data kelahiran dan agama
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();

            // Kontak dan alamat
            $table->text('alamat')->nullable();
            $table->string('nohp')->nullable();
            $table->string('email')->nullable();

            // Data pendidikan
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('universitas')->nullable();
            $table->string('tahun_lulus')->nullable();
            $table->string('bidang_keahlian')->nullable();

            // Data kepegawaian
            $table->string('status_kepegawaian')->nullable(); 
            // Contoh: PNS, PPPK, GTY, GTT, Honorer, Tetap Yayasan, Kontrak

            $table->date('tanggal_masuk')->nullable();
            $table->string('golongan')->nullable();

            $table->string('mapel')->nullable();
            // Contoh: Matematika, Bahasa Indonesia, Fisika

            $table->boolean('is_wali_kelas')->default(false);

            $table->string('foto')->nullable();

            // Dokumen guru
            $table->string('dokumen_ktp')->nullable();
            $table->string('dokumen_ijazah')->nullable();
            $table->string('dokumen_sertifikat')->nullable();
            $table->string('dokumen_sk')->nullable();

            $table->enum('status_guru', ['aktif', 'pensiun', 'nonaktif'])
                ->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};