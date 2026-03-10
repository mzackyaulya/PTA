<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materis';

    protected $fillable = [
        'mapel_id',
        'guru_id',
        'judul',
        'deskripsi',
        'file',
        'materi'
    ];

    // karena menggunakan UUID
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }

        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function mapel()
    {
        return $this->belongsTo(Mapel::class,'mapel_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class,'guru_id');
    }
}