<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Guru::with('user');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('nuptk', 'like', "%{$search}%")
                    ->orWhere('mapel', 'like', "%{$search}%")
                    ->orWhere('status_kepegawaian', 'like', "%{$search}%")
                    ->orWhere('bidang_keahlian', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qUser) use ($search) {
                        $qUser->where('name', 'like', "%{$search}%")
                            ->orWhere('nip', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $guru = $query->orderBy('created_at', 'desc')->paginate(10);

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
            'nip' => 'required|string|max:50|unique:gurus,nip|unique:users,nip',
            'nik' => 'nullable|string|max:50|unique:gurus,nik',
            'nuptk' => 'nullable|string|max:50|unique:gurus,nuptk',

            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email',
            'password' => 'nullable|min:6',

            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'nohp' => 'nullable|string|max:20',

            'pendidikan_terakhir' => 'nullable|string|max:100',
            'universitas' => 'nullable|string|max:150',
            'tahun_lulus' => 'nullable|string|max:10',
            'bidang_keahlian' => 'nullable|string|max:150',

            'status_kepegawaian' => 'nullable|string|max:100',
            'tanggal_masuk' => 'nullable|date',
            'golongan' => 'nullable|string|max:50',

            'mapel' => 'nullable|string|max:150',
            'is_wali_kelas' => 'nullable',

            'status_guru' => 'required|in:aktif,pensiun,nonaktif',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png,jfif,webp|max:5120',

            'dokumen_ktp' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'dokumen_ijazah' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'dokumen_sertifikat' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'dokumen_sk' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ]);

        // Simpan ke tabel users
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

        // Upload dokumen
        $dokumenKtp = null;
        if ($request->hasFile('dokumen_ktp')) {
            $dokumenKtp = $request->file('dokumen_ktp')->store('dokumen_guru/ktp', 'public');
        }

        $dokumenIjazah = null;
        if ($request->hasFile('dokumen_ijazah')) {
            $dokumenIjazah = $request->file('dokumen_ijazah')->store('dokumen_guru/ijazah', 'public');
        }

        $dokumenSertifikat = null;
        if ($request->hasFile('dokumen_sertifikat')) {
            $dokumenSertifikat = $request->file('dokumen_sertifikat')->store('dokumen_guru/sertifikat', 'public');
        }

        $dokumenSk = null;
        if ($request->hasFile('dokumen_sk')) {
            $dokumenSk = $request->file('dokumen_sk')->store('dokumen_guru/sk', 'public');
        }

        // Simpan ke tabel gurus
        Guru::create([
            'user_id' => $user->id,

            'nip' => $request->nip,
            'nik' => $request->nik,
            'nuptk' => $request->nuptk,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,

            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,

            'alamat' => $request->alamat,
            'nohp' => $request->nohp,
            'email' => $request->email,

            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'universitas' => $request->universitas,
            'tahun_lulus' => $request->tahun_lulus,
            'bidang_keahlian' => $request->bidang_keahlian,

            'status_kepegawaian' => $request->status_kepegawaian,
            'tanggal_masuk' => $request->tanggal_masuk,
            'golongan' => $request->golongan,

            'mapel' => $request->mapel,
            'is_wali_kelas' => $request->has('is_wali_kelas') ? 1 : 0,

            'foto' => $fotoPath,

            'dokumen_ktp' => $dokumenKtp,
            'dokumen_ijazah' => $dokumenIjazah,
            'dokumen_sertifikat' => $dokumenSertifikat,
            'dokumen_sk' => $dokumenSk,

            'status_guru' => $request->status_guru,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        $guru->load('user');

        return view('guru.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        $guru->load('user');

        return view('guru.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $userId = $guru->user ? $guru->user->id : null;

        $request->validate([
            'nip' => 'required|string|max:50|unique:gurus,nip,' . $guru->id . '|unique:users,nip,' . $userId,
            'nik' => 'nullable|string|max:50|unique:gurus,nik,' . $guru->id,
            'nuptk' => 'nullable|string|max:50|unique:gurus,nuptk,' . $guru->id,

            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|min:6',

            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'nohp' => 'nullable|string|max:20',

            'pendidikan_terakhir' => 'nullable|string|max:100',
            'universitas' => 'nullable|string|max:150',
            'tahun_lulus' => 'nullable|string|max:10',
            'bidang_keahlian' => 'nullable|string|max:150',

            'status_kepegawaian' => 'nullable|string|max:100',
            'tanggal_masuk' => 'nullable|date',
            'golongan' => 'nullable|string|max:50',

            'mapel' => 'nullable|string|max:150',
            'is_wali_kelas' => 'nullable',

            'status_guru' => 'required|in:aktif,pensiun,nonaktif',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png,jfif,webp|max:5120',

            'dokumen_ktp' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'dokumen_ijazah' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'dokumen_sertifikat' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'dokumen_sk' => 'nullable|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ]);

        // Update tabel users
        if ($guru->user) {
            $guru->user->update([
                'name' => $request->nama,
                'nip' => $request->nip,
                'email' => $request->email,
                'password' => $request->password
                    ? Hash::make($request->password)
                    : $guru->user->password,
            ]);
        }

        // Foto lama
        $fotoPath = $guru->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            $fotoPath = $request->file('foto')->store('foto_guru', 'public');
        }

        // Dokumen KTP
        $dokumenKtp = $guru->dokumen_ktp;
        if ($request->hasFile('dokumen_ktp')) {
            if ($dokumenKtp && Storage::disk('public')->exists($dokumenKtp)) {
                Storage::disk('public')->delete($dokumenKtp);
            }

            $dokumenKtp = $request->file('dokumen_ktp')->store('dokumen_guru/ktp', 'public');
        }

        // Dokumen Ijazah
        $dokumenIjazah = $guru->dokumen_ijazah;
        if ($request->hasFile('dokumen_ijazah')) {
            if ($dokumenIjazah && Storage::disk('public')->exists($dokumenIjazah)) {
                Storage::disk('public')->delete($dokumenIjazah);
            }

            $dokumenIjazah = $request->file('dokumen_ijazah')->store('dokumen_guru/ijazah', 'public');
        }

        // Dokumen Sertifikat
        $dokumenSertifikat = $guru->dokumen_sertifikat;
        if ($request->hasFile('dokumen_sertifikat')) {
            if ($dokumenSertifikat && Storage::disk('public')->exists($dokumenSertifikat)) {
                Storage::disk('public')->delete($dokumenSertifikat);
            }

            $dokumenSertifikat = $request->file('dokumen_sertifikat')->store('dokumen_guru/sertifikat', 'public');
        }

        // Dokumen SK
        $dokumenSk = $guru->dokumen_sk;
        if ($request->hasFile('dokumen_sk')) {
            if ($dokumenSk && Storage::disk('public')->exists($dokumenSk)) {
                Storage::disk('public')->delete($dokumenSk);
            }

            $dokumenSk = $request->file('dokumen_sk')->store('dokumen_guru/sk', 'public');
        }

        // Update tabel gurus
        $guru->update([
            'nip' => $request->nip,
            'nik' => $request->nik,
            'nuptk' => $request->nuptk,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,

            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,

            'alamat' => $request->alamat,
            'nohp' => $request->nohp,
            'email' => $request->email,

            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'universitas' => $request->universitas,
            'tahun_lulus' => $request->tahun_lulus,
            'bidang_keahlian' => $request->bidang_keahlian,

            'status_kepegawaian' => $request->status_kepegawaian,
            'tanggal_masuk' => $request->tanggal_masuk,
            'golongan' => $request->golongan,

            'mapel' => $request->mapel,
            'is_wali_kelas' => $request->has('is_wali_kelas') ? 1 : 0,

            'foto' => $fotoPath,

            'dokumen_ktp' => $dokumenKtp,
            'dokumen_ijazah' => $dokumenIjazah,
            'dokumen_sertifikat' => $dokumenSertifikat,
            'dokumen_sk' => $dokumenSk,

            'status_guru' => $request->status_guru,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }
}