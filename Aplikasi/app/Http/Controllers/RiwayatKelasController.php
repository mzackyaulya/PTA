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
        $data = RiwayatKelas::with('siswa','kelas','tahunAjaran')->get();
        return view('riwayatkelas.index', compact('data'));
    }

    public function create()
    {
        $siswa = Siswa::all();
        $kelas = Kelas::all();
        $tahun = TahunAjaran::where('aktif',1)->first();

        return view('riwayatkelas.create', compact('siswa','kelas','tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'=>'required',
            'kelas_id'=>'required'
        ]);

        $tahun = TahunAjaran::where('aktif',1)->first();

        RiwayatKelas::create([
            'siswa_id'=>$request->siswa_id,
            'kelas_id'=>$request->kelas_id,
            'tahun_ajaran_id'=>$tahun->id
        ]);

        return redirect()->route('riwayatkelas.index')->with('success','Siswa ditempatkan ke kelas');
    }

    public function destroy(RiwayatKelas $riwayatKelas)
    {
        $riwayatKelas->delete();
        return back()->with('success','Data dihapus');
    }
}
