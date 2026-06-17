<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mengajar;
use App\Models\RiwayatKelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            return view('jadwal.index');
        }

        if ($user->role == 'guru') {
            return redirect()->route('jadwal.guru', $user->guru->id);
        }

        if ($user->role == 'siswa') {
            return redirect()->route('jadwal.siswa', $user->siswa->id);
        }
    }

    // JADWAL GURU
    public function jadwalGuru($guru_id)
    {
        $tahun = TahunAjaran::where('aktif', 1)->first();

        $jadwal = collect();

        if ($tahun) {
            $jadwal = Mengajar::with('kelas', 'mapel')
                ->where('guru_id', $guru_id)
                ->where('tahun_ajaran_id', $tahun->id)
                ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                ->orderBy('jam_mulai')
                ->orderBy('jam_selesai')
                ->get();
        }

        return view('jadwal.guru', compact('jadwal', 'tahun'));
    }

    // JADWAL SISWA
    public function jadwalSiswa($siswa_id)
    {
        $tahun = TahunAjaran::where('aktif', 1)->first();

        $siswa = Siswa::with('user')->findOrFail($siswa_id);

        $kelasAktif = null;
        $jadwal = collect();

        if ($tahun) {
            /*
            |--------------------------------------------------------------------------
            | Penempatan siswa
            |--------------------------------------------------------------------------
            | Untuk penempatan siswa, ambil berdasarkan tahun yang sama.
            | Jadi kalau siswa ditempatkan di semester 1, semester 2 tetap terbaca.
            */
            $tahunAjaranIds = TahunAjaran::where('tahun', $tahun->tahun)
                ->pluck('id');

            $kelasAktif = RiwayatKelas::with('kelas')
                ->where('siswa_id', $siswa_id)
                ->whereIn('tahun_ajaran_id', $tahunAjaranIds)
                ->latest()
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Jadwal pelajaran
            |--------------------------------------------------------------------------
            | Jadwal tetap hanya mengambil semester aktif.
            | Jadi kalau aktif semester 1, yang muncul hanya jadwal semester 1.
            | Kalau aktif semester 2, yang muncul hanya jadwal semester 2.
            */
            if ($kelasAktif) {
                $jadwal = Mengajar::with('guru.user', 'mapel', 'kelas')
                    ->where('kelas_id', $kelasAktif->kelas_id)
                    ->where('tahun_ajaran_id', $tahun->id)
                    ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                    ->orderBy('jam_mulai')
                    ->orderBy('jam_selesai')
                    ->get();
            }
        }

        return view('jadwal.siswa', compact('jadwal', 'siswa', 'kelasAktif', 'tahun'));
    }

    public function guruList()
    {
        $guru = Guru::all();

        return view('jadwal.guru_list', compact('guru'));
    }

    public function siswaList()
    {
        $tahun = TahunAjaran::where('aktif', 1)->first();

        $tahunAjaranIds = collect();

        if ($tahun) {
            $tahunAjaranIds = TahunAjaran::where('tahun', $tahun->tahun)
                ->pluck('id');
        }

        $siswa = Siswa::with([
            'user',
            'riwayatKelas.kelas'
        ])->get();

        return view('jadwal.siswa_list', compact('siswa', 'tahun', 'tahunAjaranIds'));
    }
}