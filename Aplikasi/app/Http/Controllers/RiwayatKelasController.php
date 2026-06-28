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

    private function tahunAcuanPenempatan($tahunAktif)
    {
        if (!$tahunAktif) {
            return null;
        }

        if (in_array(strtoupper($tahunAktif->semester), ['2', 'II'])) {
            return TahunAjaran::where('tahun', $tahunAktif->tahun)
                ->whereIn('semester', ['1', 'I'])
                ->first();
        }

        $tahunMulai = (int) substr($tahunAktif->tahun, 0, 4);

        return TahunAjaran::whereIn('semester', ['1', 'I'])
            ->get()
            ->filter(function ($ta) use ($tahunMulai) {
                return (int) substr($ta->tahun, 0, 4) < $tahunMulai;
            })
            ->sortByDesc(function ($ta) {
                return (int) substr($ta->tahun, 0, 4);
            })
            ->first();
    }

    private function harusNaikTingkat($tahunAktif)
    {
        return $tahunAktif && in_array(strtoupper($tahunAktif->semester), ['1', 'I']);
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

    private function ambilJurusan($namaKelas)
    {
        $namaKelas = strtoupper($namaKelas);

        if (str_contains($namaKelas, 'IPA')) {
            return 'IPA';
        }

        if (str_contains($namaKelas, 'IPS')) {
            return 'IPS';
        }

        return null;
    }

    public function getSiswa(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $kelasTujuan = Kelas::findOrFail($request->kelas_id);
        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

        if (!$tahunAktif) {
            return response()->json([]);
        }

        $tingkatTujuan = $this->ambilTingkat($kelasTujuan->tingkat);
        $tahunAcuan = $this->tahunAcuanPenempatan($tahunAktif);
        $jurusanTujuan = $this->ambilJurusan($kelasTujuan->nama_kelas);

        // KONDISI 1: KELAS X
        if ($tingkatTujuan == 10) {
            $siswaQuery = Siswa::with('user')
                ->where(function($query) use ($tahunAktif, $kelasTujuan) {
                    // Ambil siswa yang BELUM punya riwayat kelas sama sekali
                    $query->whereDoesntHave('riwayatKelas')
                    // ATAU siswa yang sudah terdaftar DI KELAS INI pada tahun aktif ini (supaya tetap muncul)
                    ->orWhereHas('riwayatKelas', function($q) use ($tahunAktif, $kelasTujuan) {
                        $q->where('tahun_ajaran_id', $tahunAktif->id)
                        ->where('kelas_id', $kelasTujuan->id);
                    });
                });

            if ($jurusanTujuan) {
                $siswaQuery->where('jurusan', $jurusanTujuan);
            }

            $siswa = $siswaQuery->orderBy('id', 'desc')->get();
        } 
        // KONDISI 2: KELAS XI & XII
        else {
            if (!$tahunAcuan) return response()->json([]);

            $tingkatAsal = $this->harusNaikTingkat($tahunAktif) ? $tingkatTujuan - 1 : $tingkatTujuan;
            $romawiAsal = $this->romawi($tingkatAsal);

            $siswaQuery = Siswa::with('user')
                ->where(function($query) use ($tahunAcuan, $romawiAsal, $tingkatAsal, $jurusanTujuan, $tahunAktif, $kelasTujuan) {
                    // Kondisi asal kenaikan tingkat
                    $query->whereHas('riwayatKelas', function ($q) use ($tahunAcuan, $romawiAsal, $tingkatAsal, $jurusanTujuan) {
                        $q->where('tahun_ajaran_id', $tahunAcuan->id)
                        ->whereHas('kelas', function ($qKelas) use ($romawiAsal, $tingkatAsal, $jurusanTujuan) {
                            $qKelas->whereIn('tingkat', [$romawiAsal, (string) $tingkatAsal]);
                            if ($jurusanTujuan && $tingkatAsal > 10) {
                                $qKelas->where('nama_kelas', 'like', '%' . $jurusanTujuan . '%');
                            }
                        });
                    })
                    // Belum ditempatkan di kelas LAIN pada tahun aktif ini
                    ->whereDoesntHave('riwayatKelas', function ($q) use ($tahunAktif, $kelasTujuan) {
                        $q->where('tahun_ajaran_id', $tahunAktif->id)
                        ->where('kelas_id', '!=', $kelasTujuan->id); 
                    })
                    // ATAU dia memang sudah terdaftar di kelas ini
                    ->orWhereHas('riwayatKelas', function($q) use ($tahunAktif, $kelasTujuan) {
                        $q->where('tahun_ajaran_id', $tahunAktif->id)
                        ->where('kelas_id', $kelasTujuan->id);
                    });
                });

            if ($jurusanTujuan) {
                $siswaQuery->where('jurusan', $jurusanTujuan);
            }

            $siswa = $siswaQuery->orderBy('id', 'desc')->get();
        }

        // Tambahkan flag 'terdaftar' secara dinamis untuk dibaca JavaScript frontend
        $siswa->map(function($s) use ($kelasTujuan, $tahunAktif) {
            $s->terdaftar = $s->riwayatKelas()
                ->where('tahun_ajaran_id', $tahunAktif->id)
                ->where('kelas_id', $kelasTujuan->id)
                ->exists();
            return $s;
        });

        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'siswa_id' => 'nullable|array',
            'siswa_id.*' => 'exists:siswas,id',
        ]);

        $kelasTujuan = Kelas::findOrFail($request->kelas_id);
        $arrSiswaTerpilih = $request->input('siswa_id', []);

        // VALIDASI PROTEKSI BACKEND: Cek apakah jumlah yang dicentang melebihi batas maksimal kelas
        // Catatan: Ganti 'max_siswa' sesuai nama kolom kuota kelas Anda di database
        $batasMaksimal = $kelasTujuan->max_siswa ?? 20; 
        if (count($arrSiswaTerpilih) > $batasMaksimal) {
            return back()->with('error', 'Gagal menyimpan! Jumlah siswa terpilih (' . count($arrSiswaTerpilih) . ') melebihi batas maksimal kelas yaitu ' . $batasMaksimal . ' siswa.');
        }

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

        // 1. PROSES UNCHECK: Hapus siswa yang sebelumnya ada di kelas ini, tapi sekarang TIDAK dicentang
        RiwayatKelas::where('kelas_id', $request->kelas_id)
            ->where('tahun_ajaran_id', $tahunSimpan->id)
            ->whereNotIn('siswa_id', $arrSiswaTerpilih)
            ->delete();

        // 2. PROSES CHECK: Masukkan atau perbarui siswa yang sedang dicentang
        if (!empty($arrSiswaTerpilih)) {
            foreach ($arrSiswaTerpilih as $siswaId) {
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
        }

        return redirect()->route('riwayatkelas.index')
            ->with('success', 'Penempatan siswa berhasil disimpan.');
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