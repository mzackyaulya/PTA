<?php

namespace App\Models;

use App\Models\RiwayatKelas;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'nis',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'kewarganegaraan',
        'agama',
        'alamat',
        'nik',
        'nohp',
        'dusun',
        'kecamatan',
        'kelurahan',
        'rt',
        'rw',
        'kodepos',
        'jurusan',
        'jenis_tinggal',
        'alat_transportasi',


        'nama_ayah',
        'tanggal_lahir_ayah',
        'nik_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',


        'nama_ibu',
        'tanggal_lahir_ibu',
        'nik_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',


        'nama_wali',
        'tanggal_lahir_wali',
        'nik_wali',
        'pendidikan_wali',
        'pekerjaan_wali',

        'no_akta_lahir',
        'kebutuhan_khusus',
        'asal_sekolah',
        'anakke',
        'no_kk',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'jumlah_saudara',
        'jarak_rumah',

        'foto',
        'tahun_masuk',
        'status_siswa',
    ];

    // Mutator untuk Nama Ayah
    protected function namaAyah(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucwords(strtolower($value)),
        );
    }

    // Mutator untuk Nama Ibu
    protected function namaIbu(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucwords(strtolower($value)),
        );
    }

    // Mutator untuk Nama Wali
    protected function namaWali(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucwords(strtolower($value)),
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucwords(strtolower($value)),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function riwayatKelas()
    {
        return $this->hasMany(RiwayatKelas::class);
    }

    public function kelasAktif()
    {
        return $this->hasOne(RiwayatKelas::class)
            ->whereHas('tahunAjaran', function ($q) {
                $q->where('aktif', 1);
            })
            ->latestOfMany('created_at');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class,'siswa_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'siswa_id', 'id');
    }

    public function surats()
    {
        return $this->belongsToMany(
            Surat::class,
            'surat_siswas',
            'siswa_id',
            'surat_id'
        )->withTimestamps();
    }

}
