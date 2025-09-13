<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','body','image_path','published_at'
    ];

    protected $casts = [
        'published_at' => 'date',
    ];
}
