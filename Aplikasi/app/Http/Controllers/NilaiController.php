<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mengajar;
use App\Models\Nilai;
use App\Models\RiwayatKelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    private function predikat($nilai)
    {
        if ($nilai === null || $nilai === '') {
            return null;
        }

        if ($nilai >= 84) {
            return 'A';
        }

        if ($nilai >= 76) {
            return 'B';
        }

        if ($nilai >= 68) {
            return 'C';
        }

        return 'D';
    }

    private function tahunAjaranIdsAktif()
    {
        $tahun = TahunAjaran::where('aktif', 1)->first();

        if (!$tahun) {
            return collect();
        }

        return TahunAjaran::where('tahun', $tahun->tahun)->pluck('id');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - LANGSUNG TAMPIL SEMUA SISWA TAHUN AJARAN AKTIF
    |--------------------------------------------------------------------------
    */
    public function adminKelas(Request $request)
    {
        $tahunList = TahunAjaran::orderBy('tahun', 'desc')
            ->orderBy('semester', 'asc')
            ->get();

        $tahun = null;

        if ($request->filled('tahun_ajaran_id')) {
            $tahun = TahunAjaran::find($request->tahun_ajaran_id);
        }

        if (!$tahun) {
            $tahun = TahunAjaran::where('aktif', 1)->first();
        }

        $siswa = collect();

        if ($tahun) {
            /*
            |--------------------------------------------------------------------------
            | Ambil siswa berdasarkan tahun ajaran yang sama
            |--------------------------------------------------------------------------
            | Contoh:
            | Jika pilih 2032/2033 semester 2, siswa yang ditempatkan di semester 1
            | tetap tampil karena masih dalam tahun ajaran 2032/2033.
            */
            $tahunAjaranIds = TahunAjaran::where('tahun', $tahun->tahun)
                ->pluck('id');

            $riwayat = RiwayatKelas::with([
                    'siswa.user',
                    'kelas'
                ])
                ->whereIn('tahun_ajaran_id', $tahunAjaranIds)
                ->orderBy('created_at', 'desc')
                ->get();

            $siswa = $riwayat
                ->unique('siswa_id')
                ->values();
        }

        return view('nilai.admin.index', compact(
            'siswa',
            'tahun',
            'tahunList'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - METHOD INI BOLEH TETAP ADA JIKA ROUTE LAMA MASIH DIPAKAI
    |--------------------------------------------------------------------------
    */
    public function adminSiswa(Kelas $kelas)
    {
        $tahun = TahunAjaran::where('aktif', 1)->first();

        $siswa = collect();

        if ($tahun) {
            $tahunAjaranIds = TahunAjaran::where('tahun', $tahun->tahun)
                ->pluck('id');

            $riwayat = RiwayatKelas::with([
                    'siswa.user',
                    'kelas'
                ])
                ->where('kelas_id', $kelas->id)
                ->whereIn('tahun_ajaran_id', $tahunAjaranIds)
                ->orderBy('created_at', 'desc')
                ->get();

            $siswa = $riwayat
                ->unique('siswa_id')
                ->values();
        }

        return view('nilai.admin.siswa', compact('kelas', 'siswa', 'tahun'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - LIHAT NILAI SISWA BERDASARKAN SEMESTER AKTIF SAJA
    |--------------------------------------------------------------------------
    */
    public function adminShowSiswa(Request $request, Siswa $siswa)
    {
        $tahunList = TahunAjaran::orderBy('tahun', 'desc')
            ->orderBy('semester', 'asc')
            ->get();

        $tahun = null;

        if ($request->filled('tahun_ajaran_id')) {
            $tahun = TahunAjaran::find($request->tahun_ajaran_id);
        }

        if (!$tahun) {
            $tahun = TahunAjaran::where('aktif', 1)->first();
        }

        $nilai = collect();

        if ($tahun) {
            // Nilai hanya sesuai semester yang dipilih
            $nilai = Nilai::with([
                    'mapel',
                    'guru',
                    'kelas',
                    'tahunAjaran'
                ])
                ->where('siswa_id', $siswa->id)
                ->where('tahun_ajaran_id', $tahun->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('nilai.admin.show_siswa', compact(
            'siswa',
            'nilai',
            'tahun',
            'tahunList'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | GURU - TAMPIL JADWAL MENGAJAR UNTUK INPUT NILAI
    |--------------------------------------------------------------------------
    */
    public function guruIndex()
    {
        $user = auth()->user();
        $guru = $user->guru;

        $tahun = TahunAjaran::where('aktif', 1)->first();

        $mengajar = collect();

        if ($guru && $tahun) {
            $mengajar = Mengajar::with('kelas', 'mapel', 'tahunAjaran')
                ->where('guru_id', $guru->id)
                ->where('tahun_ajaran_id', $tahun->id)
                ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                ->orderBy('jam_mulai')
                ->get();
        }

        return view('nilai.guru.index', compact('mengajar', 'tahun'));
    }

    /*
    |--------------------------------------------------------------------------
    | GURU - FORM INPUT NILAI SISWA
    |--------------------------------------------------------------------------
    */
    public function guruInput(Mengajar $mengajar)
    {
        $user = auth()->user();
        $guru = $user->guru;

        if (!$guru || $mengajar->guru_id !== $guru->id) {
            abort(403);
        }

        $tahun = TahunAjaran::where('aktif', 1)->first();

        $tahunAjaranIds = $this->tahunAjaranIdsAktif();

        $riwayat = RiwayatKelas::with('siswa.user')
            ->where('kelas_id', $mengajar->kelas_id)
            ->whereIn('tahun_ajaran_id', $tahunAjaranIds)
            ->get();

        $siswa = $riwayat->pluck('siswa')->filter();

        $nilai = Nilai::where('guru_id', $guru->id)
            ->where('mapel_id', $mengajar->mapel_id)
            ->where('kelas_id', $mengajar->kelas_id)
            ->where('tahun_ajaran_id', $mengajar->tahun_ajaran_id)
            ->get()
            ->keyBy('siswa_id');

        $mengajar->load('kelas', 'mapel', 'guru');

        return view('nilai.guru.input', compact(
            'mengajar',
            'siswa',
            'nilai',
            'tahun'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | GURU - SIMPAN NILAI
    |--------------------------------------------------------------------------
    */
    public function guruStore(Request $request, Mengajar $mengajar)
    {
        $user = auth()->user();
        $guru = $user->guru;

        if (!$guru || $mengajar->guru_id !== $guru->id) {
            abort(403);
        }

        $request->validate([
            'nilai' => 'required|array',
        ]);

        foreach ($request->nilai as $siswaId => $row) {
            $kkm = $row['kkm'] ?? 75;

            $pengetahuan = $row['nilai_pengetahuan'] ?? null;
            $keterampilan = $row['nilai_keterampilan'] ?? null;

            if ($pengetahuan === null && $keterampilan === null) {
                continue;
            }

            $nilaiAkhir = null;

            if ($pengetahuan !== null && $keterampilan !== null) {
                $nilaiAkhir = round(($pengetahuan + $keterampilan) / 2, 2);
            } elseif ($pengetahuan !== null) {
                $nilaiAkhir = $pengetahuan;
            } elseif ($keterampilan !== null) {
                $nilaiAkhir = $keterampilan;
            }

            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mapel_id' => $mengajar->mapel_id,
                    'guru_id' => $guru->id,
                    'kelas_id' => $mengajar->kelas_id,
                    'tahun_ajaran_id' => $mengajar->tahun_ajaran_id,
                ],
                [
                    'kkm' => $kkm,
                    'nilai_pengetahuan' => $pengetahuan,
                    'predikat_pengetahuan' => $this->predikat($pengetahuan),
                    'nilai_keterampilan' => $keterampilan,
                    'predikat_keterampilan' => $this->predikat($keterampilan),
                    'nilai_akhir' => $nilaiAkhir,
                    'predikat_akhir' => $this->predikat($nilaiAkhir),
                    'keterangan' => $row['keterangan'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('nilai.guru.input', $mengajar->id)
            ->with('success', 'Nilai siswa berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SISWA - LIHAT NILAI SENDIRI
    |--------------------------------------------------------------------------
    */
    public function siswaNilai()
    {
        $user = auth()->user();
        $siswa = $user->siswa;

        $tahun = TahunAjaran::where('aktif', 1)->first();

        $nilai = collect();

        if ($siswa && $tahun) {
            $nilai = Nilai::with('mapel', 'guru', 'kelas')
                ->where('siswa_id', $siswa->id)
                ->where('tahun_ajaran_id', $tahun->id)
                ->get();
        }

        return view('nilai.siswa.index', compact('siswa', 'nilai', 'tahun'));
    }
    /*
|--------------------------------------------------------------------------
| REKAP NILAI - ADMIN / WAKA
|--------------------------------------------------------------------------
*/
public function rekapNilai(Request $request)
{
    $tahunList = TahunAjaran::orderBy('tahun', 'desc')
        ->orderBy('semester', 'asc')
        ->get();

    $tahun = null;

    if ($request->filled('tahun_ajaran_id')) {
        $tahun = TahunAjaran::find($request->tahun_ajaran_id);
    }

    if (!$tahun) {
        $tahun = TahunAjaran::where('aktif', 1)->first();
    }

    $rekap = collect();

    if ($tahun) {
        /*
        |--------------------------------------------------------------------------
        | Ambil siswa berdasarkan tahun ajaran yang sama
        |--------------------------------------------------------------------------
        | Kalau siswa ditempatkan di semester 1, saat semester 2 tetap tampil.
        | Tetapi nilai yang dihitung tetap berdasarkan semester yang dipilih.
        */
        $tahunAjaranIds = TahunAjaran::where('tahun', $tahun->tahun)
            ->pluck('id');

        $riwayat = RiwayatKelas::with([
                'siswa.user',
                'kelas'
            ])
            ->whereIn('tahun_ajaran_id', $tahunAjaranIds)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('siswa_id')
            ->values();

        $rekap = $riwayat->map(function ($r) use ($tahun) {
            // Pastikan relasi mapel di-load untuk mengambil kolom 'jb'
            $nilai = Nilai::with('mapel')
                ->where('siswa_id', $r->siswa_id)
                ->where('tahun_ajaran_id', $tahun->id)
                ->get();

            $jumlahMapel = $nilai->count();
            
            // Hitung total JP/JB keseluruhan mapel yang memiliki nilai
            $totalJB = $nilai->sum(function($n) {
                return $n->mapel->jb ?? 0;
            });

            // Perhitungan Rata-rata Tertimbang berdasarkan bobot JB
            $rataPengetahuan = $totalJB > 0
                ? round($nilai->sum(function($n) { return ($n->nilai_pengetahuan ?? 0) * ($n->mapel->jb ?? 0); }) / $totalJB, 2)
                : null;

            $rataKeterampilan = $totalJB > 0
                ? round($nilai->sum(function($n) { return ($n->nilai_keterampilan ?? 0) * ($n->mapel->jb ?? 0); }) / $totalJB, 2)
                : null;

            $rataAkhir = $totalJB > 0
                ? round($nilai->sum(function($n) { return ($n->nilai_akhir ?? 0) * ($n->mapel->jb ?? 0); }) / $totalJB, 2)
                : null;

            return [
                'siswa' => $r->siswa,
                'kelas' => $r->kelas,
                'jumlah_mapel' => $jumlahMapel,
                'total_jb' => $totalJB, // tambahkan ini jika ingin ditampilkan di list rekap utama
                'rata_pengetahuan' => $rataPengetahuan,
                'rata_keterampilan' => $rataKeterampilan,
                'rata_akhir' => $rataAkhir,
                'predikat' => $this->predikat($rataAkhir),
            ];
        });
    }

    return view('nilai.rekap.index', compact(
        'rekap',
        'tahunList',
        'tahun'
    ));
}

/*
|--------------------------------------------------------------------------
| REKAP NILAI PER SISWA - ADMIN / WAKA
|--------------------------------------------------------------------------
*/
public function rekapNilaiSiswa(Request $request, Siswa $siswa)
{
    $tahunList = TahunAjaran::orderBy('tahun', 'desc')
        ->orderBy('semester', 'asc')
        ->get();

    $tahun = null;

    if ($request->filled('tahun_ajaran_id')) {
        $tahun = TahunAjaran::find($request->tahun_ajaran_id);
    }

    if (!$tahun) {
        $tahun = TahunAjaran::where('aktif', 1)->first();
    }

    $nilai = collect();

    if ($tahun) {
        $nilai = Nilai::with([
                'mapel',
                'guru',
                'kelas',
                'tahunAjaran'
            ])
            ->where('siswa_id', $siswa->id)
            ->where('tahun_ajaran_id', $tahun->id)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    return view('nilai.rekap.siswa', compact(
        'siswa',
        'nilai',
        'tahun',
        'tahunList'
    ));
}

/*
|--------------------------------------------------------------------------
| EXPORT REKAP NILAI SEMUA SISWA
|--------------------------------------------------------------------------
*/
public function exportRekapNilai(Request $request)
{
    $tahun = null;

    if ($request->filled('tahun_ajaran_id')) {
        $tahun = TahunAjaran::find($request->tahun_ajaran_id);
    }

    if (!$tahun) {
        $tahun = TahunAjaran::where('aktif', 1)->first();
    }

    $rekap = collect();

    if ($tahun) {
        $tahunAjaranIds = TahunAjaran::where('tahun', $tahun->tahun)
            ->pluck('id');

        $riwayat = RiwayatKelas::with([
                'siswa.user',
                'kelas'
            ])
            ->whereIn('tahun_ajaran_id', $tahunAjaranIds)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('siswa_id')
            ->values();

        $rekap = $riwayat->map(function ($r) use ($tahun) {
            $nilai = Nilai::where('siswa_id', $r->siswa_id)
                ->where('tahun_ajaran_id', $tahun->id)
                ->get();

            $jumlahMapel = $nilai->count();

            $rataPengetahuan = $jumlahMapel > 0
                ? round($nilai->avg('nilai_pengetahuan'), 2)
                : null;

            $rataKeterampilan = $jumlahMapel > 0
                ? round($nilai->avg('nilai_keterampilan'), 2)
                : null;

            $rataAkhir = $jumlahMapel > 0
                ? round($nilai->avg('nilai_akhir'), 2)
                : null;

            return [
                'siswa' => $r->siswa,
                'kelas' => $r->kelas,
                'jumlah_mapel' => $jumlahMapel,
                'rata_pengetahuan' => $rataPengetahuan,
                'rata_keterampilan' => $rataKeterampilan,
                'rata_akhir' => $rataAkhir,
                'predikat' => $this->predikat($rataAkhir),
            ];
        });
    }

    $namaFile = 'rekap_nilai_' . date('Ymd_His') . '.xls';

    $html = view('nilai.rekap.export', compact('rekap', 'tahun'))->render();

    return response($html)
        ->header('Content-Type', 'application/vnd.ms-excel')
        ->header('Content-Disposition', 'attachment; filename="' . $namaFile . '"')
        ->header('Cache-Control', 'max-age=0');
}

/*
|--------------------------------------------------------------------------
| EXPORT REKAP NILAI PER SISWA
|--------------------------------------------------------------------------
*/
public function exportRekapNilaiSiswa(Request $request, Siswa $siswa)
{
    $tahun = null;

    if ($request->filled('tahun_ajaran_id')) {
        $tahun = TahunAjaran::find($request->tahun_ajaran_id);
    }

    if (!$tahun) {
        $tahun = TahunAjaran::where('aktif', 1)->first();
    }

    $nilai = collect();

    if ($tahun) {
        $nilai = Nilai::with([
                'mapel',
                'guru',
                'kelas',
                'tahunAjaran'
            ])
            ->where('siswa_id', $siswa->id)
            ->where('tahun_ajaran_id', $tahun->id)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    $namaFile = 'rekap_nilai_' . ($siswa->nis ?? 'siswa') . '_' . date('Ymd_His') . '.xls';

    $html = view('nilai.rekap.export_siswa', compact(
        'siswa',
        'nilai',
        'tahun'
    ))->render();

    return response($html)
        ->header('Content-Type', 'application/vnd.ms-excel')
        ->header('Content-Disposition', 'attachment; filename="' . $namaFile . '"')
        ->header('Cache-Control', 'max-age=0');
}
}