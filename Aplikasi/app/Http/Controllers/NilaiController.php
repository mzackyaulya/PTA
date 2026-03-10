<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\TahunAjaran;

class NilaiController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = Auth::user();

        // ADMIN melihat semua nilai
        if($user->role == 'admin'){
            $nilai = Nilai::with(['siswa','mapel','kelas','guru','tahunAjaran'])->get();
        }

        // GURU melihat nilai yang dia input
        elseif($user->role == 'guru'){
            $guru = Guru::where('user_id',$user->id)->first();

            $nilai = Nilai::where('guru_id',$guru->id)
                ->with(['siswa','mapel','kelas','tahunAjaran'])
                ->get();
        }

        // SISWA melihat nilai sendiri
        else{
            $siswa = Siswa::where('user_id',$user->id)->first();

            $nilai = Nilai::where('siswa_id',$siswa->id)
                ->with(['mapel','kelas','tahunAjaran','guru'])
                ->get();
        }

        return view('nilai.index',compact('nilai'));
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {

        $siswa = Siswa::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();

        $tahun = TahunAjaran::where('aktif',true)->first();

        return view('nilai.create',compact(
            'siswa',
            'mapel',
            'kelas',
            'tahun'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        $request->validate([
            'siswa_id'=>'required',
            'mapel_id'=>'required',
            'kelas_id'=>'required',
            'tugas'=>'required|numeric',
            'uts'=>'required|numeric',
            'uas'=>'required|numeric'
        ]);

        $guru = Guru::where('user_id',Auth::id())->first();

        $tahun = TahunAjaran::where('aktif',true)->first();

        $nilai_akhir =
            ($request->tugas * 0.3) +
            ($request->uts * 0.3) +
            ($request->uas * 0.4);

        Nilai::create([

            'siswa_id'=>$request->siswa_id,
            'guru_id'=>$guru->id,
            'mapel_id'=>$request->mapel_id,
            'kelas_id'=>$request->kelas_id,
            'tahun_ajaran_id'=>$tahun->id,

            'tugas'=>$request->tugas,
            'uts'=>$request->uts,
            'uas'=>$request->uas,

            'nilai_akhir'=>$nilai_akhir

        ]);

        return redirect()->back()->with('success','Nilai berhasil disimpan');
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {

        $nilai = Nilai::findOrFail($id);

        $siswa = Siswa::all();
        $mapel = Mapel::all();
        $kelas = Kelas::all();

        return view('nilai.edit',compact(
            'nilai',
            'siswa',
            'mapel',
            'kelas'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request,$id)
    {

        $nilai = Nilai::findOrFail($id);

        $nilai_akhir =
            ($request->tugas * 0.3) +
            ($request->uts * 0.3) +
            ($request->uas * 0.4);

        $nilai->update([

            'tugas'=>$request->tugas,
            'uts'=>$request->uts,
            'uas'=>$request->uas,
            'nilai_akhir'=>$nilai_akhir

        ]);

        return redirect()->back()->with('success','Nilai berhasil diupdate');
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {

        $nilai = Nilai::findOrFail($id);

        $nilai->delete();

        return redirect()->back()->with('success','Nilai berhasil dihapus');
    }

}