<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'gurus';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',

        // Identitas utama guru
        'nip',
        'nik',
        'nuptk',
        'nama',
        'jenis_kelamin',

        // Data kelahiran dan agama
        'tempat_lahir',
        'tanggal_lahir',
        'agama',

        // Kontak dan alamat
        'alamat',
        'nohp',
        'email',

        // Data pendidikan
        'pendidikan_terakhir',
        'universitas',
        'tahun_lulus',
        'bidang_keahlian',

        // Data kepegawaian
        'status_kepegawaian',
        'tanggal_masuk',
        'golongan',

        // Data mapel dan wali kelas
        'mapel',
        'is_wali_kelas',

        // Foto
        'foto',

        // Dokumen guru
        'dokumen_ktp',
        'dokumen_ijazah',
        'dokumen_sertifikat',
        'dokumen_sk',

        // Status guru
        'status_guru',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'is_wali_kelas' => 'boolean',
    ];

    // Relasi ke User / akun login
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke jadwal mengajar
    public function mengajar()
    {
        return $this->hasMany(Mengajar::class);
    }

    // Relasi ke Kelas sebagai wali kelas
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'guru_id', 'id');
    }
}