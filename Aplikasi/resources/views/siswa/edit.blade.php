@extends('layout.main')

@section('title', 'Edit Siswa')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Form Edit Siswa</h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ===================== DATA AKUN ===================== --}}
                        <h6 class="fw-bold">Data Akun</h6>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $siswa->user->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control"
                                value="{{ old('nisn', $siswa->user->nisn) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $siswa->user->email) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password (isi jika mau ganti)</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        {{-- ===================== DATA PRIBADI ===================== --}}
                        <h6 class="fw-bold mt-4">Data Pribadi</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text" name="nis" class="form-control"
                                    value="{{ old('nis', $siswa->nis) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="">- Pilih -</option>
                                    <option value="Laki-Laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control"
                                    value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control"
                                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Agama</label>
                                <input type="text" name="agama" class="form-control"
                                    value="{{ old('agama', $siswa->agama) }}">
                            </div>
                            <div class="col-md-4 mb-3"><label class="form-label">Kewarganegaraan</label>
                                <input type="text" name="kewarganegaraan" class="form-control"
                                    value="{{ old('kewarganegaraan', $siswa->kewarganegaraan) }}">
                            </div>
                            <div class="col-md-4 mb-3"><label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control"
                                    value="{{ old('nik', $siswa->nik) }}">
                            </div>
                        </div>

                        {{-- ===================== ALAMAT ===================== --}}
                        <h6 class="fw-bold mt-4">Alamat</h6>
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $siswa->alamat) }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Dusun</label><input type="text" name="dusun" class="form-control" value="{{ old('dusun', $siswa->dusun) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Kecamatan</label><input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $siswa->kecamatan) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Kelurahan</label><input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan', $siswa->kelurahan) }}"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3"><label class="form-label">RT</label><input type="text" name="rt" class="form-control" value="{{ old('rt', $siswa->rt) }}"></div>
                            <div class="col-md-2 mb-3"><label class="form-label">RW</label><input type="text" name="rw" class="form-control" value="{{ old('rw', $siswa->rw) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Kode Pos</label><input type="text" name="kodepos" class="form-control" value="{{ old('kodepos', $siswa->kodepos) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">No HP</label><input type="text" name="nohp" class="form-control" value="{{ old('nohp', $siswa->nohp) }}"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="form-label">Jenis Tinggal</label><input type="text" name="jenis_tinggal" class="form-control" value="{{ old('jenis_tinggal', $siswa->jenis_tinggal) }}"></div>
                            <div class="col-md-6 mb-3"><label class="form-label">Alat Transportasi</label><input type="text" name="alat_transportasi" class="form-control" value="{{ old('alat_transportasi', $siswa->alat_transportasi) }}"></div>
                        </div>

                        {{-- ===================== ORANG TUA ===================== --}}
                        <h6 class="fw-bold mt-4">Data Ayah</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Nama Ayah</label><input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah', $siswa->nama_ayah) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Tanggal Lahir</label><input type="date" name="tanggal_lahir_ayah" class="form-control" value="{{ old('tanggal_lahir_ayah', $siswa->tanggal_lahir_ayah) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">NIK</label><input type="text" name="nik_ayah" class="form-control" value="{{ old('nik_ayah', $siswa->nik_ayah) }}"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Pendidikan</label><input type="text" name="pendidikan_ayah" class="form-control" value="{{ old('pendidikan_ayah', $siswa->pendidikan_ayah) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Pekerjaan</label><input type="text" name="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Penghasilan</label><input type="text" name="penghasilan_ayah" class="form-control" value="{{ old('penghasilan_ayah', $siswa->penghasilan_ayah) }}"></div>
                        </div>

                        <h6 class="fw-bold mt-4">Data Ibu</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Nama Ibu</label><input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu', $siswa->nama_ibu) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Tanggal Lahir</label><input type="date" name="tanggal_lahir_ibu" class="form-control" value="{{ old('tanggal_lahir_ibu', $siswa->tanggal_lahir_ibu) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">NIK</label><input type="text" name="nik_ibu" class="form-control" value="{{ old('nik_ibu', $siswa->nik_ibu) }}"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Pendidikan</label><input type="text" name="pendidikan_ibu" class="form-control" value="{{ old('pendidikan_ibu', $siswa->pendidikan_ibu) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Pekerjaan</label><input type="text" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Penghasilan</label><input type="text" name="penghasilan_ibu" class="form-control" value="{{ old('penghasilan_ibu', $siswa->penghasilan_ibu) }}"></div>
                        </div>

                        <h6 class="fw-bold mt-4">Data Wali</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Nama Wali</label><input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali', $siswa->nama_wali) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Tanggal Lahir</label><input type="date" name="tanggal_lahir_wali" class="form-control" value="{{ old('tanggal_lahir_wali', $siswa->tanggal_lahir_wali) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">NIK</label><input type="text" name="nik_wali" class="form-control" value="{{ old('nik_wali', $siswa->nik_wali) }}"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Pendidikan</label><input type="text" name="pendidikan_wali" class="form-control" value="{{ old('pendidikan_wali', $siswa->pendidikan_wali) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Pekerjaan</label><input type="text" name="pekerjaan_wali" class="form-control" value="{{ old('pekerjaan_wali', $siswa->pekerjaan_wali) }}"></div>
                        </div>

                        {{-- ===================== AKADEMIK & TAMBAHAN ===================== --}}
                        <h6 class="fw-bold mt-4">Data Akademik & Tambahan</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Kelas</label><input type="text" name="kelas" class="form-control" value="{{ old('kelas', $siswa->kelas) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">No Akta Lahir</label><input type="text" name="no_akta_lahir" class="form-control" value="{{ old('no_akta_lahir', $siswa->no_akta_lahir) }}"></div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kebutuhan Khusus</label>
                                <select name="kebutuhan_khusus" class="form-select">
                                    <option value="">- Pilih -</option>
                                    <option value="IYA" {{ old('kebutuhan_khusus', $siswa->kebutuhan_khusus) == 'IYA' ? 'selected' : '' }}>IYA</option>
                                    <option value="TIDAK" {{ old('kebutuhan_khusus', $siswa->kebutuhan_khusus) == 'TIDAK' ? 'selected' : '' }}>TIDAK</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="form-label">Asal Sekolah</label><input type="text" name="asal_sekolah" class="form-control" value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}"></div>
                            <div class="col-md-2 mb-3"><label class="form-label">Anak Ke</label><input type="text" name="anakke" class="form-control" value="{{ old('anakke', $siswa->anakke) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">No KK</label><input type="text" name="no_kk" class="form-control" value="{{ old('no_kk', $siswa->no_kk) }}"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3"><label class="form-label">Berat Badan (kg)</label><input type="text" name="berat_badan" class="form-control" value="{{ old('berat_badan', $siswa->berat_badan) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Tinggi Badan (cm)</label><input type="text" name="tinggi_badan" class="form-control" value="{{ old('tinggi_badan', $siswa->tinggi_badan) }}"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Lingkar Kepala (cm)</label><input type="text" name="lingkar_kepala" class="form-control" value="{{ old('lingkar_kepala', $siswa->lingkar_kepala) }}"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="form-label">Jumlah Saudara</label><input type="text" name="jumlah_saudara" class="form-control" value="{{ old('jumlah_saudara', $siswa->jumlah_saudara) }}"></div>
                            <div class="col-md-6 mb-3"><label class="form-label">Jarak Rumah ke Sekolah (km)</label><input type="text" name="jarak_rumah" class="form-control" value="{{ old('jarak_rumah', $siswa->jarak_rumah) }}"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3"><label class="form-label">Tahun Masuk</label><input type="number" name="tahun_masuk" class="form-control" value="{{ old('tahun_masuk', $siswa->tahun_masuk) }}"></div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status_siswa" class="form-select">
                                    <option value="aktif" {{ old('status_siswa', $siswa->status_siswa) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="lulus" {{ old('status_siswa', $siswa->status_siswa) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                    <option value="pindah" {{ old('status_siswa', $siswa->status_siswa) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                                </select>
                            </div>
                        </div>

                        {{-- ===================== FOTO ===================== --}}
                        <div class="mb-3">
                            <label class="form-label">Foto Saat Ini</label><br>
                            @if($siswa->foto)
                                <img src="{{ asset('storage/'.$siswa->foto) }}" alt="Foto Siswa" class="img-thumbnail" style="max-width: 150px;">
                            @else
                                <p><i>Belum ada foto</i></p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ganti Foto (Opsional)</label>
                            <input type="file" name="foto" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
