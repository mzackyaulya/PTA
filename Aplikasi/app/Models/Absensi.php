<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasUuids;

    protected $fillable = [
        'siswa_id',
        'mengajar_id',
        'tanggal',
        'status',
        'keterangan',
        'scan_barcode'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mengajar()
    {
        return $this->belongsTo(Mengajar::class);
    }
}
