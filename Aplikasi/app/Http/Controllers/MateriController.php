<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Mengajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // ==========================
        // JIKA GURU
        // ==========================
        if(auth()->user()->role == 'guru'){

            $guru = auth()->user()->guru;

            $materi = Materi::with('mapel')
                        ->where('guru_id',$guru->id)
                        ->orderBy('materi','asc')
                        ->get();

            $mapel = Mapel::all();

            return view('materi.guru.index', compact('materi','mapel'));
        }


        // ==========================
        // JIKA SISWA
        // ==========================
        if(auth()->user()->role == 'siswa'){

            $siswa = auth()->user()->siswa;

            $kelas = $siswa->riwayatKelas()->latest()->first();

            if(!$kelas){
                return view('materi.siswa.index',[
                    'mapel' => []
                ]);
            }

            $mapel = Mengajar::with(['mapel','guru','kelas'])
                ->where('kelas_id',$kelas->kelas_id)
                ->get()
                ->unique('mapel_id')
                ->values();

            return view('materi.siswa.index', compact('mapel'));
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mapel = Mapel::all();

        return view('materi.guru.create', compact('mapel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mapel_id' => 'required',
            'judul' => 'required',
            'file' => 'required|mimes:pdf,docx,ppt,pptx|max:10000'
        ]);


        $file = $request->file('file')->store('materi','public');


        Materi::create([
            'mapel_id' => $request->mapel_id,
            'guru_id' => auth()->user()->guru->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'materi' => $request->materi,
            'file' => $file
        ]);

        return redirect()->route('materi.guru.index')
            ->with('success','Materi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    // public function show($id)
    // {
    //     $materi = Materi::findOrFail($id);

    //     return view('materi.show', compact('materi'));
    // }

    public function download($id)
    {

        $materi = Materi::findOrFail($id);

        if(!Storage::disk('public')->exists($materi->file)){
            return back()->with('error','File tidak ditemukan');
        }

        return Storage::disk('public')->download($materi->file);

    }

    public function mapelSiswa()
    {

        $siswa = auth()->user()->siswa;

        $mapel = Mengajar::with('mapel')
                ->where('kelas_id',$siswa->kelas_id)
                ->get();

        return view('materi.siswa.mapel',compact('mapel'));
    }

    public function materiMapel($mapel_id)
    {

        $materi = Materi::where('mapel_id',$mapel_id)
                    ->orderBy('materi','asc')
                    ->get();

        return view('materi.siswa.materi',compact('materi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materi $materi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $materi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        Storage::delete('public/'.$materi->file);

        $materi->delete();

        return back()->with('success','Materi berhasil dihapus');
    }
}
