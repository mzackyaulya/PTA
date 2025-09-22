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
     * Simpan data siswa baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'nisn'            => 'required|unique:users,nisn',
            'email'           => 'nullable|email|unique:users,email',
            'password'        => 'nullable|min:6',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png,jfif,webp|max:5120',
            'status_siswa'    => 'required|in:aktif,lulus,pindah',
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
            'user_id'             => $user->id,
            'nis'                 => $request->nis,
            'jenis_kelamin'       => $request->jenis_kelamin,
            'tempat_lahir'        => $request->tempat_lahir,
            'tanggal_lahir'       => $request->tanggal_lahir,
            'kewarganegaraan'     => $request->kewarganegaraan,
            'agama'               => $request->agama,
            'alamat'              => $request->alamat,
            'nik'                 => $request->nik,
            'nohp'                => $request->nohp,
            'dusun'               => $request->dusun,
            'kecamatan'           => $request->kecamatan,
            'kelurahan'           => $request->kelurahan,
            'rt'                  => $request->rt,
            'rw'                  => $request->rw,
            'kodepos'             => $request->kodepos,
            'jenis_tinggal'       => $request->jenis_tinggal,
            'alat_transportasi'   => $request->alat_transportasi,

            // Data ayah
            'nama_ayah'           => $request->nama_ayah,
            'tanggal_lahir_ayah'  => $request->tanggal_lahir_ayah,
            'nik_ayah'            => $request->nik_ayah,
            'pendidikan_ayah'     => $request->pendidikan_ayah,
            'pekerjaan_ayah'      => $request->pekerjaan_ayah,
            'penghasilan_ayah'    => $request->penghasilan_ayah,

            // Data ibu
            'nama_ibu'            => $request->nama_ibu,
            'tanggal_lahir_ibu'   => $request->tanggal_lahir_ibu,
            'nik_ibu'             => $request->nik_ibu,
            'pendidikan_ibu'      => $request->pendidikan_ibu,
            'pekerjaan_ibu'       => $request->pekerjaan_ibu,
            'penghasilan_ibu'     => $request->penghasilan_ibu,

            // Data wali
            'nama_wali'           => $request->nama_wali,
            'tanggal_lahir_wali'  => $request->tanggal_lahir_wali,
            'nik_wali'            => $request->nik_wali,
            'pendidikan_wali'     => $request->pendidikan_wali,
            'pekerjaan_wali'      => $request->pekerjaan_wali,

            // Data tambahan
            'kelas'               => $request->kelas,
            'no_akta_lahir'       => $request->no_akta_lahir,
            'kebutuhan_khusus'    => $request->kebutuhan_khusus,
            'asal_sekolah'        => $request->asal_sekolah,
            'anakke'              => $request->anakke,
            'no_kk'               => $request->no_kk,
            'berat_badan'         => $request->berat_badan,
            'tinggi_badan'        => $request->tinggi_badan,
            'lingkar_kepala'      => $request->lingkar_kepala,
            'jumlah_saudara'      => $request->jumlah_saudara,
            'jarak_rumah'         => $request->jarak_rumah,

            'foto'                => $fotoPath,
            'tahun_masuk'         => $request->tahun_masuk,
            'status_siswa'        => $request->status_siswa,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail siswa.
     */
    public function show(Siswa $siswa)
    {
        return view('siswa.show', compact('siswa'));
    }

    /**
     * Form edit siswa.
     */
    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    /**
     * Update data siswa.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'nisn'          => 'required|unique:users,nisn,' . $siswa->user->id,
            'email'         => 'nullable|email|unique:users,email,' . $siswa->user->id,
            'password'      => 'nullable|min:6',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,jfif,webp|max:5120',
            'status_siswa'  => 'required|in:aktif,lulus,pindah',
        ]);

        // Update user
        $siswa->user->update([
            'name'     => $request->name,
            'nisn'     => $request->nisn,
            'email'    => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $siswa->user->password,
        ]);

        // Foto
        $fotoPath = $siswa->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('foto_siswa', 'public');
        }

        // Update siswa
        $siswa->update([
            'nis'                 => $request->nis,
            'jenis_kelamin'       => $request->jenis_kelamin,
            'tempat_lahir'        => $request->tempat_lahir,
            'tanggal_lahir'       => $request->tanggal_lahir,
            'kewarganegaraan'     => $request->kewarganegaraan,
            'agama'               => $request->agama,
            'alamat'              => $request->alamat,
            'nik'                 => $request->nik,
            'nohp'                => $request->nohp,
            'dusun'               => $request->dusun,
            'kecamatan'           => $request->kecamatan,
            'kelurahan'           => $request->kelurahan,
            'rt'                  => $request->rt,
            'rw'                  => $request->rw,
            'kodepos'             => $request->kodepos,
            'jenis_tinggal'       => $request->jenis_tinggal,
            'alat_transportasi'   => $request->alat_transportasi,

            // Data ayah
            'nama_ayah'           => $request->nama_ayah,
            'tanggal_lahir_ayah'  => $request->tanggal_lahir_ayah,
            'nik_ayah'            => $request->nik_ayah,
            'pendidikan_ayah'     => $request->pendidikan_ayah,
            'pekerjaan_ayah'      => $request->pekerjaan_ayah,
            'penghasilan_ayah'    => $request->penghasilan_ayah,

            // Data ibu
            'nama_ibu'            => $request->nama_ibu,
            'tanggal_lahir_ibu'   => $request->tanggal_lahir_ibu,
            'nik_ibu'             => $request->nik_ibu,
            'pendidikan_ibu'      => $request->pendidikan_ibu,
            'pekerjaan_ibu'       => $request->pekerjaan_ibu,
            'penghasilan_ibu'     => $request->penghasilan_ibu,

            // Data wali
            'nama_wali'           => $request->nama_wali,
            'tanggal_lahir_wali'  => $request->tanggal_lahir_wali,
            'nik_wali'            => $request->nik_wali,
            'pendidikan_wali'     => $request->pendidikan_wali,
            'pekerjaan_wali'      => $request->pekerjaan_wali,

            // Data tambahan
            'kelas'               => $request->kelas,
            'no_akta_lahir'       => $request->no_akta_lahir,
            'kebutuhan_khusus'    => $request->kebutuhan_khusus,
            'asal_sekolah'        => $request->asal_sekolah,
            'anakke'              => $request->anakke,
            'no_kk'               => $request->no_kk,
            'berat_badan'         => $request->berat_badan,
            'tinggi_badan'        => $request->tinggi_badan,
            'lingkar_kepala'      => $request->lingkar_kepala,
            'jumlah_saudara'      => $request->jumlah_saudara,
            'jarak_rumah'         => $request->jarak_rumah,

            'foto'                => $fotoPath,
            'tahun_masuk'         => $request->tahun_masuk,
            'status_siswa'        => $request->status_siswa,
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
