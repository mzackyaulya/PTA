<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertemuanAbsensi;
use App\Models\Mengajar;
use Illuminate\Support\Str;

class PertemuanController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Tampilkan daftar pertemuan
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $pertemuan = PertemuanAbsensi::with('mengajar.mapel','mengajar.kelas')
                        ->orderBy('tanggal','desc')
                        ->get();

        return view('admin.pertemuan.index', compact('pertemuan'));
    }



    /*
    |--------------------------------------------------------------------------
    | Form buat pertemuan
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $mengajar = Mengajar::with('mapel','kelas')->get();

        return view('admin.pertemuan.create', compact('mengajar'));
    }



    /*
    |--------------------------------------------------------------------------
    | Simpan pertemuan
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        $request->validate([
            'mengajar_id'   => 'required',
            'pertemuan_ke'  => 'required',
            'tanggal'       => 'required'
        ]);

        PertemuanAbsensi::create([
            'id'            => Str::uuid(),
            'mengajar_id'   => $request->mengajar_id,
            'pertemuan_ke'  => $request->pertemuan_ke,
            'tanggal'       => $request->tanggal,
            'is_approved'   => false,
            'is_started'    => false
        ]);

        return redirect()
                ->route('pertemuan.index')
                ->with('success','Pertemuan berhasil dibuat');
    }



    /*
    |--------------------------------------------------------------------------
    | Approve pertemuan
    |--------------------------------------------------------------------------
    */

    public function approve($id)
    {
        $pertemuan = PertemuanAbsensi::findOrFail($id);

        $pertemuan->update([
            'is_approved' => true
        ]);

        return redirect()
                ->back()
                ->with('success','Pertemuan berhasil disetujui');
    }



    /*
    |--------------------------------------------------------------------------
    | Detail pertemuan
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $pertemuan = PertemuanAbsensi::with(
                        'mengajar.mapel',
                        'mengajar.kelas',
                        'absensis.siswa'
                    )->findOrFail($id);

        return view('admin.pertemuan.show', compact('pertemuan'));
    }

}