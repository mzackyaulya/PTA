<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKelas;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class RiwayatKelasController extends Controller
{
    public function index()
    {
        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

        $tahunAcuan = $tahunAktif;

        if ($tahunAktif && in_array($tahunAktif->semester, ['2', 'II'])) {
            $tahunAcuan = TahunAjaran::where('tahun', $tahunAktif->tahun)
                ->whereIn('semester', ['1', 'I'])
                ->first();
        }

        $kelas = Kelas::withCount(['riwayatKelas as jumlah_siswa' => function ($q) use ($tahunAcuan) {
            if ($tahunAcuan) {
                $q->where('tahun_ajaran_id', $tahunAcuan->id);
            }
        }])->get()
        ->map(function ($k) {
            $tingkat = strtoupper($k->tingkat);

            if ($tingkat == 'X') {
                $k->tingkat_angka = 10;
            } elseif ($tingkat == 'XI') {
                $k->tingkat_angka = 11;
            } elseif ($tingkat == 'XII') {
                $k->tingkat_angka = 12;
            } else {
                $k->tingkat_angka = 99;
            }

            return $k;
        })
        ->sortBy([
            ['tingkat_angka', 'asc'],
            ['nama_kelas', 'asc']
        ])
        ->values();

        return view('riwayatkelas.index', compact('kelas', 'tahunAktif'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $kelasTujuan = Kelas::findOrFail($request->kelas_id);
        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

        if (!$tahunAktif) {
            return back()->with('error', 'Tahun ajaran aktif belum diatur.');
        }

        $tahunSebelumnya = TahunAjaran::where('id', '<', $tahunAktif->id)
            ->orderBy('id', 'desc')
            ->first();

        $tingkatTujuan = $this->ambilTingkat($kelasTujuan->tingkat);

        $siswa = collect();

        if ($tingkatTujuan == 10) {
            $siswa = Siswa::with('user')
                ->whereDoesntHave('riwayatKelas')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $tingkatSebelumnya = $tingkatTujuan - 1;

            $siswa = Siswa::with('user')
                ->whereHas('riwayatKelas.kelas', function ($q) use ($tingkatSebelumnya) {
                    $q->where('tingkat', $this->romawi($tingkatSebelumnya));
                })
                ->whereHas('riwayatKelas', function ($q) use ($tahunSebelumnya) {
                    if ($tahunSebelumnya) {
                        $q->where('tahun_ajaran_id', $tahunSebelumnya->id);
                    }
                })
                ->whereDoesntHave('riwayatKelas', function ($q) use ($tahunAktif) {
                    $q->where('tahun_ajaran_id', $tahunAktif->id);
                })
                ->get();
        }

        return view('riwayatkelas.create', compact('siswa', 'kelasTujuan', 'tahunAktif'));
    }

    public function getSiswa(Request $request)
    {
        $kelasTujuan = Kelas::findOrFail($request->kelas_id);
        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

        if (!$tahunAktif) {
            return response()->json([]);
        }

        $tahunSebelumnya = TahunAjaran::where('id', '<', $tahunAktif->id)
            ->orderBy('id', 'desc')
            ->first();

        $tingkatTujuan = $this->ambilTingkat($kelasTujuan->tingkat);

        if ($tingkatTujuan == 10) {
            $siswa = Siswa::with('user')
                ->whereDoesntHave('riwayatKelas', function ($q) use ($tahunAktif) {
                    $q->where('tahun_ajaran_id', $tahunAktif->id);
                })
                ->get();
        } else {
            if (!$tahunSebelumnya) {
                return response()->json([]);
            }

            $tingkatSebelumnya = $tingkatTujuan - 1;
            $romawiSebelumnya = $this->romawi($tingkatSebelumnya);

            $siswa = Siswa::with('user')
                ->whereHas('riwayatKelas', function ($q) use ($tahunSebelumnya, $romawiSebelumnya) {
                    $q->where('tahun_ajaran_id', $tahunSebelumnya->id)
                    ->whereHas('kelas', function ($qKelas) use ($romawiSebelumnya) {
                        $qKelas->where('tingkat', $romawiSebelumnya);
                    });
                })
                ->whereDoesntHave('riwayatKelas', function ($q) use ($tahunAktif) {
                    $q->where('tahun_ajaran_id', $tahunAktif->id);
                })
                ->get();
        }

        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'siswa_id' => 'required|array',
            'siswa_id.*' => 'exists:siswas,id',
        ]);

        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

        if (!$tahunAktif) {
            return back()->with('error', 'Tahun ajaran aktif belum diatur.');
        }

        $tahunSimpan = $tahunAktif;

        if (in_array(strtoupper($tahunAktif->semester), ['2', 'II'])) {
            $tahunSemesterSatu = TahunAjaran::where('tahun', $tahunAktif->tahun)
                ->whereIn('semester', ['1', 'I'])
                ->first();

            if ($tahunSemesterSatu) {
                $tahunSimpan = $tahunSemesterSatu;
            }
        }

        foreach ($request->siswa_id as $siswaId) {
            RiwayatKelas::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tahun_ajaran_id' => $tahunSimpan->id,
                ],
                [
                    'kelas_id' => $request->kelas_id,
                ]
            );
        }

        return redirect()->route('riwayatkelas.index')
            ->with('success', 'Siswa berhasil ditempatkan ke kelas.');
    }

    public function destroy(RiwayatKelas $riwayatKelas)
    {
        $riwayatKelas->delete();

        return back()->with('success', 'Data dihapus');
    }

    private function ambilTingkat($tingkat)
    {
        $tingkat = strtoupper($tingkat);

        if ($tingkat == 'X') {
            return 10;
        }

        if ($tingkat == 'XI') {
            return 11;
        }

        if ($tingkat == 'XII') {
            return 12;
        }

        return null;
    }

    private function romawi($tingkat)
    {
        return match ((int) $tingkat) {
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
            default => '',
        };
    }
}