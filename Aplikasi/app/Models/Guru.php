<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'nohp',
        'email',
        'pendidikan_terakhir',
        'jabatan',
        'mapel',
        'foto',
        'status_guru',
    ];

    // Relasi ke User (akun login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kelas (sebagai wali kelas)
    // public function kelas()
    // {
    //     return $this->hasMany(Kelas::class, 'wali_kelas_id');
    // }
}
