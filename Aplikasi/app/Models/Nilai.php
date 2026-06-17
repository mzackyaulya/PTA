<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Nilai extends Model
{
    use HasUuids;

    protected $table = 'nilais';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'guru_id',
        'kelas_id',
        'tahun_ajaran_id',
        'kkm',
        'nilai_pengetahuan',
        'predikat_pengetahuan',
        'nilai_keterampilan',
        'predikat_keterampilan',
        'nilai_akhir',
        'predikat_akhir',
        'keterangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id');
    }
}