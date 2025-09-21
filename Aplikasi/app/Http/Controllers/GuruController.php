<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Guru::with('user')->get();
        return view('guru.index', compact('guru'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:gurus,nip|unique:users,nip',
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|min:6',
            'jenis_kelamin' => 'required|string',
            'status_guru' => 'required|in:aktif,pensiun,nonaktif',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,jfif,webp|max:5120',
        ]);

        // Simpan ke users
        $user = User::create([
            'name' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make($request->password ?? 'guru123'),
            'role' => 'guru',
        ]);

        // Upload foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_guru', 'public');
        }

        // Simpan ke gurus
        Guru::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'nohp' => $request->nohp,
            'email' => $request->email,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jabatan' => $request->jabatan,
            'mapel' => $request->mapel,
            'status_guru' => $request->status_guru,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        //
    }
}
