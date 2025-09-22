<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'jenis_tinggal',
        'alat_transportasi',

        // Data Ayah
        'nama_ayah',
        'tanggal_lahir_ayah',
        'nik_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',

        // Data Ibu
        'nama_ibu',
        'tanggal_lahir_ibu',
        'nik_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',

        // Data Wali
        'nama_wali',
        'tanggal_lahir_wali',
        'nik_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        // kalau mau tambahkan penghasilan_wali di migration, tambahkan juga disini
        // 'penghasilan_wali',

        // Data tambahan
        'kelas',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
