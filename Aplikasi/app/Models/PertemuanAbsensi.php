<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PertemuanAbsensi extends Model
{
    use HasUuids;

    protected $table = 'pertemuan_absensi';

    protected $fillable = [
        'mengajar_id',
        'tanggal',
        'pertemuan_ke',
        'is_approved',
        'is_started',
        'is_closed',
        'is_saved'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'pertemuan_id', 'id');
    }

    public function mengajar()
    {
        return $this->belongsTo(Mengajar::class, 'mengajar_id', 'id');
    }
}
