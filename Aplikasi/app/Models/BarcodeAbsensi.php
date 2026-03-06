<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BarcodeAbsensi extends Model
{
    use HasUuids;

    protected $table = 'barcode_absensi';

    protected $fillable = [
        'pertemuan_id',
        'token',
        'expired_at'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function pertemuan()
    {
        return $this->belongsTo(PertemuanAbsensi::class);
    }
}