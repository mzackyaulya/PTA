<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Surat extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'kode_surat',
        'jenis_surat',
        'judul',
        'nama_kegiatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'tempat_kegiatan',
        'nama_pelatih',
        'nama_organisasi',
        'keperluan',
        'catatan_waka',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'reviewed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($surat) {
            if (empty($surat->id)) {
                $surat->id = (string) Str::uuid();
            }
        });
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswaTerlibat()
    {
        return $this->belongsToMany(
            Siswa::class,
            'surat_siswas',
            'surat_id',
            'siswa_id'
        )->withTimestamps();
    }

    public function waka()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}