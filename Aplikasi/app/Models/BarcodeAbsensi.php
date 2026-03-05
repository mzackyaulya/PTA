<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BarcodeAbsensi extends Model
{
    use HasUuids;

    protected $table = 'barcode_absensi';

    protected $fillable = [
        'mengajar_id',
        'token',
        'tanggal'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    public function mengajar()
    {
        return $this->belongsTo(Mengajar::class);
    }
}