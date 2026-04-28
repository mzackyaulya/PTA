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
        Schema::create('siswas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('nis',10);
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('kewarganegaraan');
            $table->string('agama');
            $table->string('alamat');
            $table->string('nik');
            $table->string('nohp');
            $table->string('dusun');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('rt');
            $table->string('rw');
            $table->string('kodepos');
            $table->string('jenis_tinggal');
            $table->string('alat_transportasi');

            $table->string('nama_ayah');
            $table->date('tanggal_lahir_ayah');
            $table->string('nik_ayah');
            $table->string('pendidikan_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('penghasilan_ayah');

            $table->string('nama_ibu');
            $table->date('tanggal_lahir_ibu');
            $table->string('nik_ibu');
            $table->string('pendidikan_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('penghasilan_ibu');

            $table->string('nama_wali');
            $table->date('tanggal_lahir_wali');
            $table->string('nik_wali');
            $table->string('pendidikan_wali');
            $table->string('pekerjaan_wali');

            $table->string('no_akta_lahir');
            $table->string('jurusan');
            $table->string('kebutuhan_khusus');
            $table->string('asal_sekolah');
            $table->string('anakke');
            $table->string('no_kk');
            $table->string('berat_badan');
            $table->string('tinggi_badan');
            $table->string('lingkar_kepala');
            $table->string('jumlah_saudara');
            $table->string('jarak_rumah');
            $table->string('foto')->nullable();
            $table->year('tahun_masuk');
            $table->enum('status_siswa', ['aktif','lulus','pindah'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
