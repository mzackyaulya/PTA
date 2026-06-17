<?php

namespace App\Http\Controllers;

use App\Models\PertemuanAbsensi;
use App\Models\Mengajar;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Mapel;

class PertemuanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalDipilih = $request->tanggal ?? now()->toDateString();

        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

        $hariInggris = \Carbon\Carbon::parse($tanggalDipilih)->format('l');

        $hariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        $hariIni = $hariMap[$hariInggris] ?? '-';

        $pertemuan = collect();

        if ($tahunAktif) {

            /*
            |--------------------------------------------------------------------------
            | Ambil jadwal hanya berdasarkan hari dan tahun ajaran aktif
            |--------------------------------------------------------------------------
            */
            $jadwalPadaTanggal = Mengajar::with([
                    'mapel',
                    'kelas',
                    'guru.user'
                ])
                ->where('hari', $hariIni)
                ->where('tahun_ajaran_id', $tahunAktif->id)
                ->orderBy('jam_mulai', 'asc')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Buat pertemuan otomatis jika belum ada
            |--------------------------------------------------------------------------
            */
            foreach ($jadwalPadaTanggal as $jadwal) {

                $sudahAda = PertemuanAbsensi::where('mengajar_id', $jadwal->id)
                    ->whereDate('tanggal', $tanggalDipilih)
                    ->first();

                if (!$sudahAda) {

                    $pertemuanKe = PertemuanAbsensi::where('mengajar_id', $jadwal->id)
                        ->count() + 1;

                    PertemuanAbsensi::create([
                        'id'            => Str::uuid(),
                        'mengajar_id'   => $jadwal->id,
                        'tanggal'       => $tanggalDipilih,
                        'pertemuan_ke'  => $pertemuanKe,
                        'is_approved'   => false,
                        'is_started'    => false,
                        'is_closed'     => false,
                        'is_saved'      => false,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Tampilkan pertemuan hanya dari tahun ajaran aktif
            |--------------------------------------------------------------------------
            */
            $pertemuan = PertemuanAbsensi::with([
                    'mengajar.mapel',
                    'mengajar.kelas',
                    'mengajar.guru.user'
                ])
                ->whereDate('tanggal', $tanggalDipilih)
                ->whereHas('mengajar', function ($query) use ($hariIni, $tahunAktif) {
                    $query->where('hari', $hariIni)
                        ->where('tahun_ajaran_id', $tahunAktif->id);
                })
                ->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'asc')
                ->get();
        }

        $tanggalHariIni = $tanggalDipilih;

        return view('admin.pertemuan.index', compact(
            'pertemuan',
            'hariIni',
            'tanggalHariIni',
            'tahunAktif'
        ));
    }

    public function approve($id)
    {
        $pertemuan = PertemuanAbsensi::findOrFail($id);

        $pertemuan->update([
            'is_approved' => true,
            'is_started'  => true,
            'is_closed'   => false,
            'is_saved'    => false,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Absensi berhasil dibuka oleh admin.');
    }

    public function show($id)
    {
        $pertemuan = PertemuanAbsensi::with([
            'mengajar.mapel',
            'mengajar.kelas',
            'mengajar.guru.user',
            'absensis.siswa.user'
        ])->findOrFail($id);

        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

        $absensi = $pertemuan->absensis;

        $siswa = collect();

        if ($tahunAktif && $pertemuan->mengajar) {

            /*
            |--------------------------------------------------------------------------
            | Ambil siswa berdasarkan tahun ajaran yang sama
            |--------------------------------------------------------------------------
            | Kalau siswa ditempatkan di semester 1, semester 2 tetap terbaca.
            | Tapi tetap dalam tahun yang sama.
            */
            $tahunAjaranIds = TahunAjaran::where('tahun', $tahunAktif->tahun)
                ->pluck('id');

            $siswa = Siswa::with('user')
                ->whereHas('riwayatKelas', function ($q) use ($pertemuan, $tahunAjaranIds) {
                    $q->where('kelas_id', $pertemuan->mengajar->kelas_id)
                      ->whereIn('tahun_ajaran_id', $tahunAjaranIds);
                })
                ->get();
        }

        $hadir = $absensi->where('status', 'hadir')->count();
        $izin  = $absensi->where('status', 'izin')->count();
        $sakit = $absensi->where('status', 'sakit')->count();
        $alpa  = $absensi->where('status', 'alpa')->count();

        $belumAbsen = $siswa->count() - $absensi->count();

        return view('admin.pertemuan.show', compact(
            'pertemuan',
            'siswa',
            'absensi',
            'hadir',
            'izin',
            'sakit',
            'alpa',
            'belumAbsen',
            'tahunAktif'
        ));
    }
    public function rekap(Request $request)
    {
        $tahunList = TahunAjaran::orderBy('tahun', 'desc')
            ->orderBy('semester', 'asc')
            ->get();

        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

        $tahunDipilih = $request->filled('tahun_ajaran_id')
            ? TahunAjaran::find($request->tahun_ajaran_id)
            : $tahunAktif;

        $kelasList = Kelas::orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        $mapelList = Mapel::orderBy('nama')
            ->get();

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        $absensi = collect();

        if ($tahunDipilih) {
            $query = Absensi::with([
                'siswa.user',
                'pertemuan.mengajar.mapel',
                'pertemuan.mengajar.kelas',
                'pertemuan.mengajar.guru.user'
            ])
            ->whereHas('pertemuan.mengajar', function ($q) use ($tahunDipilih, $request) {
                $q->where('tahun_ajaran_id', $tahunDipilih->id);

                if ($request->filled('kelas_id')) {
                    $q->where('kelas_id', $request->kelas_id);
                }

                if ($request->filled('mapel_id')) {
                    $q->where('mapel_id', $request->mapel_id);
                }
            });

            if ($tanggalMulai && $tanggalSelesai) {
                $query->whereHas('pertemuan', function ($q) use ($tanggalMulai, $tanggalSelesai) {
                    $q->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
                });
            }

            $absensi = $query->get();
        }

        $rekap = $absensi
            ->groupBy(function ($item) {
                return $item->siswa_id . '-' . optional(optional($item->pertemuan)->mengajar)->mapel_id;
            })
            ->map(function ($items) {
                $first = $items->first();

                $hadir = $items->where('status', 'hadir')->count();
                $izin  = $items->where('status', 'izin')->count();
                $sakit = $items->where('status', 'sakit')->count();
                $alpa  = $items->where('status', 'alpa')->count();

                $total = $hadir + $izin + $sakit + $alpa;
                $persentase = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;

                return [
                    'siswa' => $first->siswa,
                    'kelas' => optional(optional($first->pertemuan)->mengajar)->kelas,
                    'mapel' => optional(optional($first->pertemuan)->mengajar)->mapel,
                    'guru' => optional(optional($first->pertemuan)->mengajar)->guru,
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'alpa' => $alpa,
                    'total' => $total,
                    'persentase' => $persentase,
                ];
            })
            ->values();

        return view('admin.pertemuan.rekap', compact(
            'rekap',
            'tahunList',
            'tahunDipilih',
            'kelasList',
            'mapelList',
            'tanggalMulai',
            'tanggalSelesai'
        ));
    }
    public function exportRekap(Request $request)
    {
        $tahunDipilih = $request->filled('tahun_ajaran_id')
            ? TahunAjaran::find($request->tahun_ajaran_id)
            : TahunAjaran::where('aktif', 1)->first();

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        $absensi = collect();

        if ($tahunDipilih) {
            $query = Absensi::with([
                'siswa.user',
                'pertemuan.mengajar.mapel',
                'pertemuan.mengajar.kelas',
                'pertemuan.mengajar.guru.user'
            ])
            ->whereHas('pertemuan.mengajar', function ($q) use ($tahunDipilih, $request) {
                $q->where('tahun_ajaran_id', $tahunDipilih->id);

                if ($request->filled('kelas_id')) {
                    $q->where('kelas_id', $request->kelas_id);
                }

                if ($request->filled('mapel_id')) {
                    $q->where('mapel_id', $request->mapel_id);
                }
            });

            if ($tanggalMulai && $tanggalSelesai) {
                $query->whereHas('pertemuan', function ($q) use ($tanggalMulai, $tanggalSelesai) {
                    $q->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
                });
            }

            $absensi = $query->get();
        }

        $rekap = $absensi
            ->groupBy(function ($item) {
                return $item->siswa_id . '-' . optional(optional($item->pertemuan)->mengajar)->mapel_id;
            })
            ->map(function ($items) {
                $first = $items->first();

                $hadir = $items->where('status', 'hadir')->count();
                $izin  = $items->where('status', 'izin')->count();
                $sakit = $items->where('status', 'sakit')->count();
                $alpa  = $items->where('status', 'alpa')->count();

                $total = $hadir + $izin + $sakit + $alpa;
                $persentase = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;

                return [
                    'siswa' => $first->siswa,
                    'kelas' => optional(optional($first->pertemuan)->mengajar)->kelas,
                    'mapel' => optional(optional($first->pertemuan)->mengajar)->mapel,
                    'guru' => optional(optional($first->pertemuan)->mengajar)->guru,
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'alpa' => $alpa,
                    'total' => $total,
                    'persentase' => $persentase,
                ];
            })
            ->values();

        $namaFile = 'rekap_absensi_' . date('Ymd_His') . '.xls';

        $html = view('admin.pertemuan.export_excel', compact(
            'rekap',
            'tahunDipilih',
            'tanggalMulai',
            'tanggalSelesai'
        ))->render();

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $namaFile . '"')
            ->header('Cache-Control', 'max-age=0');
    }
}