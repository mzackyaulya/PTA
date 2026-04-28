<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Siswa::with('user');

        // Menggunakan 'filled' agar query tidak berjalan jika input search kosong
        if ($request->filled('search')) {
            $search = $request->search;
            
            // Membungkus pencarian agar operator OR tidak mengacaukan kondisi lain
            $query->where(function($q) use ($search) {
                
                // 1. Cari berdasarkan kolom di tabel Siswa
                $q->where('tahun_masuk', 'like', "%{$search}%")
                
                // 2. ATAU cari berdasarkan relasi di tabel User
                ->orWhereHas('user', function($qUser) use ($search) {
                    $qUser->where('name', 'like', "%{$search}%")
                            ->orWhere('nisn', 'like', "%{$search}%");
                });
                
            });
        }

        // Pagination 10 data per halaman
        $siswa = $query->orderBy('tahun_masuk', 'desc')->paginate(10); 

        return view('siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('siswa.create', compact('kelas'));
    }

    /**
     * Simpan data siswa baru.
     */
    public function store(Request $request)
    {
        $request->validate([
        // Data akun
        'name'     => 'required|string|max:255',
        'nisn'     => 'required|digits:10|unique:users,nisn',
        'nis'      => 'required|digits:4|unique:siswas,nis',
        'email'    => 'required|email|unique:users,email',
        'password' => 'nullable|min:8',

        // Data pribadi
        'jenis_kelamin'   => 'required|in:Laki-Laki,Perempuan',
        'tempat_lahir'    => 'required|string|max:255',
        'tanggal_lahir'   => 'required|date',
        'kewarganegaraan' => 'required|string|max:50',
        'agama'           => 'required|string|max:50',
        'alamat'          => 'required|string',
        'nik'             => 'required|string|max:20',
        'nohp'            => 'required|string|max:20',

        // Alamat
        'dusun'             => 'required|string|max:255',
        'kecamatan'         => 'required|string|max:255',
        'kelurahan'         => 'required|string|max:255',
        'rt'                => 'required|string|max:10',
        'rw'                => 'required|string|max:10',
        'kodepos'           => 'required|string|max:10',
        'jenis_tinggal'     => 'required|string|max:100',
        'alat_transportasi' => 'required|string|max:100',

        // Data ayah
        'nama_ayah'          => 'required|string|max:255',
        'tanggal_lahir_ayah' => 'required|date',
        'nik_ayah'           => 'required|string|max:20',
        'pendidikan_ayah'    => 'required|string|max:100',
        'pekerjaan_ayah'     => 'required|string|max:100',
        'penghasilan_ayah'   => 'required|string|max:100',

        // Data ibu
        'nama_ibu'          => 'required|string|max:255',
        'tanggal_lahir_ibu' => 'required|date',
        'nik_ibu'           => 'required|string|max:20',
        'pendidikan_ibu'    => 'required|string|max:100',
        'pekerjaan_ibu'     => 'required|string|max:100',
        'penghasilan_ibu'   => 'required|string|max:100',

        // Data wali
        'nama_wali'          => 'required|string|max:255',
        'tanggal_lahir_wali' => 'required|date',
        'nik_wali'           => 'required|string|max:20',
        'pendidikan_wali'    => 'required|string|max:100',
        'pekerjaan_wali'     => 'required|string|max:100',

        // Data tambahan
        'no_akta_lahir'    => 'required|string|max:100',
        'kebutuhan_khusus' => 'required|in:IYA,TIDAK',
        'jurusan'          => 'required|in:IPA,IPS',
        'asal_sekolah'     => 'required|string|max:255',
        'anakke'           => 'required|string|max:10',
        'no_kk'            => 'required|string|max:20',
        'berat_badan'      => 'required|string|max:10',
        'tinggi_badan'     => 'required|string|max:10',
        'lingkar_kepala'   => 'required|string|max:10',
        'jumlah_saudara'   => 'required|string|max:10',
        'jarak_rumah'      => 'required|string|max:20',

        // Lainnya
        'tahun_masuk'  => 'required',
        'status_siswa' => 'required|in:aktif,lulus,pindah',
        'foto'         => 'nullable|image|mimes:jpg,jpeg,png,jfif,webp|max:5120',
    ]);

        DB::beginTransaction();

        try {

            // USER
            $user = User::create([
                'name'     => $request->name,
                'nisn'     => $request->nisn,
                'email'    => $request->email,
                'password' => Hash::make($request->password ?? 'siswa123'),
                'role'     => 'siswa',
            ]);

            // FOTO
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto_siswa', 'public');
            }

            // SISWA (TANPA KELAS)
            Siswa::create([
                'user_id'            => $user->id,
                'nis'                => $request->nis,
                'jenis_kelamin'      => $request->jenis_kelamin,
                'tempat_lahir'       => $request->tempat_lahir,
                'tanggal_lahir'      => $request->tanggal_lahir,
                'kewarganegaraan'    => $request->kewarganegaraan,
                'agama'              => $request->agama,
                'alamat'             => $request->alamat,
                'nik'                => $request->nik,
                'nohp'               => $request->nohp,
                'dusun'              => $request->dusun,
                'kecamatan'          => $request->kecamatan,
                'kelurahan'          => $request->kelurahan,
                'rt'                 => $request->rt,
                'rw'                 => $request->rw,
                'kodepos'            => $request->kodepos,
                'jenis_tinggal'      => $request->jenis_tinggal,
                'alat_transportasi'  => $request->alat_transportasi,

                'nama_ayah'          => $request->nama_ayah,
                'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah,
                'nik_ayah'           => $request->nik_ayah,
                'pendidikan_ayah'    => $request->pendidikan_ayah,
                'pekerjaan_ayah'     => $request->pekerjaan_ayah,
                'penghasilan_ayah'   => $request->penghasilan_ayah,

                'nama_ibu'           => $request->nama_ibu,
                'tanggal_lahir_ibu'  => $request->tanggal_lahir_ibu,
                'nik_ibu'            => $request->nik_ibu,
                'pendidikan_ibu'     => $request->pendidikan_ibu,
                'pekerjaan_ibu'      => $request->pekerjaan_ibu,
                'penghasilan_ibu'    => $request->penghasilan_ibu,

                'nama_wali'          => $request->nama_wali,
                'tanggal_lahir_wali' => $request->tanggal_lahir_wali,
                'nik_wali'           => $request->nik_wali,
                'pendidikan_wali'    => $request->pendidikan_wali,
                'pekerjaan_wali'     => $request->pekerjaan_wali,

                'no_akta_lahir'      => $request->no_akta_lahir,
                'kebutuhan_khusus'   => $request->kebutuhan_khusus,
                'jurusan'            => $request->jurusan,
                'asal_sekolah'       => $request->asal_sekolah,
                'anakke'             => $request->anakke,
                'no_kk'              => $request->no_kk,
                'berat_badan'        => $request->berat_badan,
                'tinggi_badan'       => $request->tinggi_badan,
                'lingkar_kepala'     => $request->lingkar_kepala,
                'jumlah_saudara'     => $request->jumlah_saudara,
                'jarak_rumah'        => $request->jarak_rumah,

                'foto'               => $fotoPath,
                'tahun_masuk'        => $request->tahun_masuk,
                'status_siswa'       => $request->status_siswa,
            ]);

            DB::commit();

            return redirect()->route('siswa.index')
                ->with('success', 'Data siswa berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Tampilkan detail siswa.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load([
            'user',
            'kelasAktif.kelas',
            'kelasAktif.tahunAjaran'
        ]);

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
            'nisn'          => 'required|digits:10|unique:users,nisn,' . $siswa->user->id,
            'nis'           => 'required|digits:4|unique:siswas,nis,' . $siswa->id,
            'email'         => 'nullable|email|unique:users,email,' . $siswa->user->id,
            'password'      => 'nullable|min:8',
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
            'no_akta_lahir'       => $request->no_akta_lahir,
            'kebutuhan_khusus'    => $request->kebutuhan_khusus,
            'jurusan'            => $request->jurusan,
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
