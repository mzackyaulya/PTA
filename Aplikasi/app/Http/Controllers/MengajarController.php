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
        $data = Mengajar::with('guru','kelas','mapel','tahunAjaran')->get();
        return view('mengajar.index', compact('data'));
    }

    public function create()
    {
        $guru = Guru::all();
        $kelas = Kelas::all();
        $mapel = Mapel::all();

        return view('mengajar.create', compact('guru','kelas','mapel'));
    }

    public function store(Request $request)
    {
        $tahun = TahunAjaran::where('aktif',1)->first();

        Mengajar::create([
            'guru_id'=>$request->guru_id,
            'kelas_id'=>$request->kelas_id,
            'mapel_id'=>$request->mapel_id,
            'tahun_ajaran_id'=>$tahun->id,
            'hari'=>$request->hari,
            'jam_ke'=>$request->jam_ke
        ]);

        return redirect()->route('mengajar.index')->with('success','Jadwal mengajar dibuat');
    }

    public function destroy(Mengajar $mengajar)
    {
        $mengajar->delete();
        return back()->with('success','Jadwal dihapus');
    }
}
