<?php

namespace App\Models;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mengajar extends Model
{
    protected $fillable = [
        'guru_id',
        'mapel_id',
        'kelas_id',
        'tahun_ajaran_id',
        'hari',
        'jam_ke'
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

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
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
