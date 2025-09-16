<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'kewarganegaraan',
        'agama',
        'alamat',
        'nik',
        'nohp',
        'kode_pos',
        'nama_ayah',
        'tanggal_lahir_ayah',
        'nik_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'tanggal_lahir_ibu',
        'nik_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'kelas',
        'jurusan',
        'foto',
        'tahun_masuk',
        'status_siswa',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
