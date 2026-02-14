<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RiwayatKelas extends Model
{
    protected $table = 'riwayat_kelas';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tahun_ajaran_id'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::uuid();
            }
        });
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
