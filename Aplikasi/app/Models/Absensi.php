<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasUuids;

    protected $fillable = [
        'pertemuan_id',
        'siswa_id',
        'status',
        'keterangan',
        'scan_barcode'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function pertemuan()
    {
        return $this->belongsTo(PertemuanAbsensi::class);
    }
}
