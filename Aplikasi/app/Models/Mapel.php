<?php

namespace App\Models;

use App\Models\Mengajar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mapel extends Model
{
     protected $fillable = ['nama','kode'];

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

    public function mengajar()
    {
        return $this->hasMany(Mengajar::class);
    }
}
