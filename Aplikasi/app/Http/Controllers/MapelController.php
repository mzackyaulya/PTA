<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $data = Mapel::all();
        return view('mapel.index', compact('data'));
    }

    public function create()
    {
        return view('mapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'  =>'required',
            'nama'  =>'required',
            'jb'    =>'required'
        ]);

        Mapel::create($request->all());

        return redirect()->route('mapel.index')->with('success','Mapel ditambahkan');
    }

    public function edit(Mapel $mapel)
    {
        return view('mapel.edit', compact('mapel'));
    }

    public function update(Request $request, Mapel $mapel)
    {
        $data = $request->validate([
            'nama'  => 'required|string|max:255',
            'kode'  => 'required|string|max:50',
            'jb'    => 'required'

        ]);

        $mapel->update($data);

        return redirect()->route('mapel.index')->with('success','Mapel diperbarui');
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        return back()->with('success','Mapel dihapus');
    }
}
