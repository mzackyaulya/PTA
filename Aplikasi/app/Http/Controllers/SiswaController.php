<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'name'           => 'required|string|max:255',
            'nisn'           => 'required|unique:users,nisn',
            'email'          => 'nullable|email|unique:users,email',
            'password'       => 'nullable|min:6',
            'jenis_kelamin'  => 'nullable|string',
            'tempat_lahir'   => 'nullable|string',
            'tanggal_lahir'  => 'nullable|date',
            'agama'          => 'nullable|string',
            'alamat'         => 'nullable|string',
            'nohp'           => 'nullable|string',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png,jfif,webp|max:5120',
            'tahun_masuk'    => 'nullable|numeric',
            'status_siswa'   => 'required|in:aktif,lulus,pindah',
        ]);

        // Simpan ke tabel users
        $user = User::create([
            'name'     => $request->name,
            'nisn'     => $request->nisn,
            'email'    => $request->email,
            'password' => Hash::make($request->password ?? 'siswa123'),
            'role'     => 'siswa',
        ]);

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_siswa', 'public');
        }

        // Simpan ke tabel siswas
        Siswa::create([
            'user_id'          => $user->id,
            'jenis_kelamin'    => $request->jenis_kelamin,
            'tempat_lahir'     => $request->tempat_lahir,
            'tanggal_lahir'    => $request->tanggal_lahir,
            'kewarganegaraan'  => $request->kewarganegaraan,
            'agama'            => $request->agama,
            'alamat'           => $request->alamat,
            'nik'              => $request->nik,
            'nohp'             => $request->nohp,
            'kode_pos'         => $request->kode_pos,
            'nama_ayah'        => $request->nama_ayah,
            'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah,
            'pekerjaan_ayah'   => $request->pekerjaan_ayah,
            'nama_ibu'         => $request->nama_ibu,
            'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu,
            'pekerjaan_ibu'    => $request->pekerjaan_ibu,
            'tahun_masuk'      => $request->tahun_masuk,
            'status_siswa'     => $request->status_siswa,
            'foto'             => $fotoPath,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
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
        return view('siswa.edit',compact('siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'nisn'           => 'required|unique:users,nisn,' . $siswa->user->id,
            'email'          => 'nullable|email|unique:users,email,' . $siswa->user->id,
            'password'       => 'nullable|min:6',
            'jenis_kelamin'  => 'nullable|string',
            'tempat_lahir'   => 'nullable|string',
            'tanggal_lahir'  => 'nullable|date',
            'agama'          => 'nullable|string',
            'alamat'         => 'nullable|string',
            'nohp'           => 'nullable|string',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png,jfif,webp|max:5120',
            'tahun_masuk'    => 'nullable|numeric',
            'status_siswa'   => 'required|in:aktif,lulus,pindah',
        ]);

        // Update user
        $siswa->user->update([
            'name'     => $request->name,
            'nisn'     => $request->nisn,
            'email'    => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $siswa->user->password,
        ]);

        // Handle foto baru
        $fotoPath = $siswa->foto;
        if ($request->hasFile('foto')) {
            // hapus foto lama kalau ada
            if ($fotoPath && \Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('foto_siswa', 'public');
        }

        // Update siswa
        $siswa->update([
            'jenis_kelamin'    => $request->jenis_kelamin,
            'tempat_lahir'     => $request->tempat_lahir,
            'tanggal_lahir'    => $request->tanggal_lahir,
            'kewarganegaraan'  => $request->kewarganegaraan,
            'agama'            => $request->agama,
            'alamat'           => $request->alamat,
            'nik'              => $request->nik,
            'nohp'             => $request->nohp,
            'kode_pos'         => $request->kode_pos,
            'nama_ayah'        => $request->nama_ayah,
            'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah,
            'pekerjaan_ayah'   => $request->pekerjaan_ayah,
            'nama_ibu'         => $request->nama_ibu,
            'tanggal_lahir_ibu'=> $request->tanggal_lahir_ibu,
            'pekerjaan_ibu'    => $request->pekerjaan_ibu,
            'tahun_masuk'      => $request->tahun_masuk,
            'status_siswa'     => $request->status_siswa,
            'foto'             => $fotoPath,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        //
    }
}
