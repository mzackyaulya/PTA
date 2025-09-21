@extends('layout.main')

@section('title', 'Tambah Guru')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Form Tambah Guru</h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Data Akun --}}
                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password (default = guru123 jika dikosongkan)</label>
                            <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                        </div>

                        {{-- Data Pribadi --}}
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">- Pilih -</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Agama</label>
                            <input type="text" name="agama" class="form-control" value="{{ old('agama') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="nohp" class="form-control" value="{{ old('nohp') }}">
                        </div>

                        {{-- Data Pekerjaan --}}
                        <div class="mb-3">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" class="form-control" value="{{ old('pendidikan_terakhir') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <input type="text" name="mapel" class="form-control" value="{{ old('mapel') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Guru</label>
                            <select name="status_guru" class="form-select">
                                <option value="aktif" selected>Aktif</option>
                                <option value="pensiun">Pensiun</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>

                        {{-- Upload Foto --}}
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
