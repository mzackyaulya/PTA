<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::with('user')->get();
        return view('siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|unique:users,nisn',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|min:6', // bisa default kalau kosong
        ]);

        // buat akun login di tabel users
        $user = User::create([
            'name' => $request->name,
            'nisn' => $request->nisn,
            'email' => $request->email,
            'password' => bcrypt($request->password ?? 'siswa123'), // default siswa123
            'role' => 'siswa',
        ]);

        // buat biodata siswa di tabel siswas
        Siswa::create([
            'user_id' => $user->id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'nohp' => $request->nohp,
            'tahun_masuk' => $request->tahun_masuk,
            'status_siswa' => $request->status_siswa ?? 'aktif',
        ]);

        return redirect()->route('siswas.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        //
    }
}
