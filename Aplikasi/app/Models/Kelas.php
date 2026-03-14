<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kelas extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kelas';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'kapasitas',
        'wali_kelas',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    public function wali()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas');
    }

    public function riwayatKelas()
    {
        return $this->hasMany(RiwayatKelas::class, 'kelas_id');
    }

    public function mengajar()
    {
        return $this->hasMany(Mengajar::class);
    }

}
