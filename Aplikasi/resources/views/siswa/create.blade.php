@extends('layout.main')

@section('title', 'Tambah Siswa')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Form Tambah Siswa</h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Data Akun --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn" id="nisn" class="form-control" value="{{ old('nisn') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password (default = siswa123 jika dikosongkan)</label>
                            <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control">
                        </div>

                        {{-- Data Pribadi --}}
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">- Pilih -</option>
                                <option value="Laki-Laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Agama</label>
                            <input type="text" name="agama" id="agama" value="{{ old('agama') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="nohp" value="{{ old('nohp') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" id="kewarganegaraan" value="{{ old('kewarganegaraan') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="kode_pos" id="kode_pos" value="{{ old('kode_pos') }}" class="form-control">
                        </div>

                        {{-- Data Orang Tua --}}
                        <h6 class="fw-bold mt-4">Data Ayah</h6>
                        <div class="mb-3">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah') }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir Ayah</label>
                            <input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah') }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" class="form-control">
                        </div>

                        <h6 class="fw-bold mt-4">Data Ibu</h6>
                        <div class="mb-3">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu') }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir Ibu</label>
                            <input type="date" name="tanggal_lahir_ibu" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" class="form-control">
                        </div>

                        {{-- Data Akademik --}}
                        <div class="mb-3">
                            <label class="form-label">Tahun Masuk</label>
                            <input type="number" name="tahun_masuk" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status_siswa" class="form-select">
                                <option value="aktif">Aktif</option>
                                <option value="lulus">Lulus</option>
                                <option value="pindah">Pindah</option>
                            </select>
                        </div>

                        {{-- Upload Foto --}}
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
