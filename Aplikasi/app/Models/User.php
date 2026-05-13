<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nisn',
        'nip'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function surats()
    {
        return $this->hasMany(Surat::class, 'user_id');
    }

    public function suratDireview()
    {
        return $this->hasMany(Surat::class, 'reviewed_by');
    }
    protected function name(): Attribute
    {
        return Attribute::make(
            // Menampilkan data (Accessor): Otomatis rapi saat dipanggil di tabel
            get: fn (?string $value) => $value ? ucwords(strtolower($value)) : null,
            
            // Menyimpan data (Mutator): Otomatis rapi saat admin input/save
            set: fn (?string $value) => $value ? ucwords(strtolower($value)) : null,
        );
    }
}
