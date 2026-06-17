<?php

namespace App\Http\Controllers;

use App\Models\Mengajar;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class MengajarController extends Controller
{
    public function index()
    {
        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

        $kelas = Kelas::withCount(['mengajar as jumlah_jadwal' => function ($q) use ($tahunAktif) {
            if ($tahunAktif) {
                $q->where('tahun_ajaran_id', $tahunAktif->id);
            }
        }])
        ->orderBy('tingkat')
        ->orderBy('nama_kelas')
        ->get();

        return view('mengajar.index', compact('kelas', 'tahunAktif'));
    }

    public function show($kelasId)
    {
        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

        $kelas = Kelas::findOrFail($kelasId);

        $data = Mengajar::with('guru.user', 'kelas', 'mapel', 'tahunAjaran')
            ->where('kelas_id', $kelasId)
            ->when($tahunAktif, function ($q) use ($tahunAktif) {
                $q->where('tahun_ajaran_id', $tahunAktif->id);
            })
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->get();

        return view('mengajar.show', compact('data', 'kelas', 'tahunAktif'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $jamList = [
            ['mulai' => '07:00', 'selesai' => '08:30'],
            ['mulai' => '08:30', 'selesai' => '10:00'],
            ['mulai' => '10:10', 'selesai' => '12:00'],
            ['mulai' => '13:00', 'selesai' => '15:00'],
        ];

        $kelas = Kelas::findOrFail($request->kelas_id);
        $guru = Guru::with('user')->where('status_guru', 'aktif')->get();
        $mapel = Mapel::all();

        return view('mengajar.create', compact('guru', 'kelas', 'mapel', 'jamList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'hari' => 'required|string',
            'jam' => 'required|string',
        ]);

        [$jamMulai, $jamSelesai] = explode('|', $request->jam);

        $tahun = TahunAjaran::where('aktif', 1)->first();

        if (!$tahun) {
            return back()
                ->withInput()
                ->with('error', 'Tahun ajaran aktif belum diatur.');
        }

        /*
        |--------------------------------------------------------------------------
        | Cek bentrok guru
        |--------------------------------------------------------------------------
        | Guru yang sama tidak boleh mengajar di hari dan jam yang sama
        */
        $bentrokGuru = Mengajar::where('guru_id', $request->guru_id)
            ->where('tahun_ajaran_id', $tahun->id)
            ->where('hari', $request->hari)
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->where('jam_mulai', '<', $jamSelesai)
                  ->where('jam_selesai', '>', $jamMulai);
            })
            ->exists();

        if ($bentrokGuru) {
            return back()
                ->withInput()
                ->with('error', 'Jadwal bentrok. Guru ini sudah memiliki jadwal mengajar pada hari dan jam tersebut.');
        }

        /*
        |--------------------------------------------------------------------------
        | Cek bentrok kelas
        |--------------------------------------------------------------------------
        | Kelas yang sama tidak boleh punya dua pelajaran di hari dan jam yang sama
        */
        $bentrokKelas = Mengajar::where('kelas_id', $request->kelas_id)
            ->where('tahun_ajaran_id', $tahun->id)
            ->where('hari', $request->hari)
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->where('jam_mulai', '<', $jamSelesai)
                  ->where('jam_selesai', '>', $jamMulai);
            })
            ->exists();

        if ($bentrokKelas) {
            return back()
                ->withInput()
                ->with('error', 'Jadwal bentrok. Kelas ini sudah memiliki pelajaran pada hari dan jam tersebut.');
        }

        Mengajar::create([
            'guru_id' => $request->guru_id,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'tahun_ajaran_id' => $tahun->id,
            'hari' => $request->hari,
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
        ]);

        return redirect()->route('mengajar.show', $request->kelas_id)
            ->with('success', 'Jadwal mengajar berhasil dibuat.');
    }

    public function destroy(Mengajar $mengajar)
    {
        $kelasId = $mengajar->kelas_id;

        $mengajar->delete();

        return redirect()->route('mengajar.show', $kelasId)
            ->with('success', 'Jadwal dihapus.');
    }
}