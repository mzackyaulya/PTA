<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $data = TahunAjaran::orderBy('tahun','desc')->get();
        return view('tahunajaran.index', compact('data'));
    }

    public function create()
    {
        return view('tahunajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun'=>'required',
            'semester'=>'required|numeric'
        ]);

        if($request->aktif){
            TahunAjaran::where('aktif',1)->update(['aktif'=>0]);
        }

        TahunAjaran::create([
            'tahun'=>$request->tahun,
            'semester'=>$request->semester,
            'aktif'=>$request->aktif ?? 0
        ]);

        return redirect()->route('tahunajaran.index')
            ->with('success','Tahun ajaran berhasil ditambahkan');
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('tahunajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        if($request->aktif){
            TahunAjaran::where('aktif',1)->update(['aktif'=>0]);
        }

        $tahunAjaran->update($request->all());

        return redirect()->route('tahunajaran.index')
            ->with('success','Tahun ajaran diperbarui');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();
        return back()->with('success','Data dihapus');
    }
}
