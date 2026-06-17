<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\TahunAjaran;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

        $tahunAcuan = $tahunAktif;

        if ($tahunAktif && in_array(strtoupper($tahunAktif->semester), ['2', 'II'])) {
            $tahunSemesterSatu = TahunAjaran::where('tahun', $tahunAktif->tahun)
                ->whereIn('semester', ['1', 'I'])
                ->first();

            if ($tahunSemesterSatu) {
                $tahunAcuan = $tahunSemesterSatu;
            }
        }

        $kelas = Kelas::query()
            ->select('kelas.*')
            ->with([
                'wali:id,user_id',
                'wali.user:id,name'
            ])
            ->withCount(['riwayatKelas as jumlah_siswa' => function ($q) use ($tahunAcuan) {
                if ($tahunAcuan) {
                    $q->where('tahun_ajaran_id', $tahunAcuan->id);
                }
            }])
            ->get();

        return view('kelas.index', compact('kelas', 'tahunAktif'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guru = Guru::with('user')->get();
        return view('kelas.create', compact('guru'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'tingkat'    => 'required|string',
            'kapasitas'    => 'required|integer',
            'wali_kelas' => 'nullable|exists:gurus,id',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkat'    => $request->tingkat,
            'kapasitas'  => $request->kapasitas,
            'wali_kelas' => $request->wali_kelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        $guru = Guru::with('user')->get();
        return view('kelas.edit', compact('kelas', 'guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'tingkat'    => 'required|string',
            'kapasitas'    => 'required|integer',
            'wali_kelas' => 'nullable|exists:gurus,id',
        ]);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'tingkat'    => $request->tingkat,
            'kapasitas'  => $request->kapasitas,
            'wali_kelas' => $request->wali_kelas,
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }
}
