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

        if($user->role == 'admin'){
            return view('jadwal.index');
        }

        if($user->role == 'guru'){
            return redirect()->route('jadwal.guru', $user->guru->id);
        }

        if($user->role == 'siswa'){
            return redirect()->route('jadwal.siswa', $user->siswa->id);
        }
    }

    // JADWAL GURU
    public function jadwalGuru($guru_id)
    {
        $tahun = TahunAjaran::where('aktif',1)->first();

        $jadwal = Mengajar::with('kelas','mapel')
            ->where('guru_id',$guru_id)
            ->where('tahun_ajaran_id',$tahun->id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->orderBy('jam_selesai')
            ->get();

        return view('jadwal.guru', compact('jadwal'));
    }


    // JADWAL SISWA
    public function jadwalSiswa($siswa_id)
    {
        $tahun = TahunAjaran::where('aktif',1)->first();

        $kelas = RiwayatKelas::where('siswa_id',$siswa_id)
            ->where('tahun_ajaran_id',$tahun->id)
            ->first();

        $jadwal = Mengajar::with('guru','mapel')
            ->where('kelas_id',$kelas->kelas_id)
            ->where('tahun_ajaran_id',$tahun->id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->orderBy('jam_selesai')
            ->get();

        return view('jadwal.siswa', compact('jadwal'));
    }

    public function guruList()
    {
        $guru = Guru::all();
        return view('jadwal.guru_list', compact('guru'));
    }

    public function siswaList()
    {
        $siswa = Siswa::all();
        return view('jadwal.siswa_list', compact('siswa'));
    }
}