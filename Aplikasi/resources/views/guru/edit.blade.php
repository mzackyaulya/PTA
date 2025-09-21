@extends('layout.main')

@section('title', 'Edit Guru')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Form Edit Guru</h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Data Akun --}}
                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control"
                                value="{{ old('nip', $guru->nip) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control"
                                value="{{ old('nama', $guru->nama) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $guru->email) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password (kosongkan jika tidak diganti)</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        {{-- Data Pribadi --}}
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">- Pilih -</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control"
                                value="{{ old('tempat_lahir', $guru->tempat_lahir) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                value="{{ old('tanggal_lahir', $guru->tanggal_lahir) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Agama</label>
                            <input type="text" name="agama" class="form-control"
                                value="{{ old('agama', $guru->agama) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $guru->alamat) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="nohp" class="form-control"
                                value="{{ old('nohp', $guru->nohp) }}">
                        </div>

                        {{-- Data Pekerjaan --}}
                        <div class="mb-3">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" class="form-control"
                                value="{{ old('pendidikan_terakhir', $guru->pendidikan_terakhir) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control"
                                value="{{ old('jabatan', $guru->jabatan) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <input type="text" name="mapel" class="form-control"
                                value="{{ old('mapel', $guru->mapel) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Guru</label>
                            <select name="status_guru" class="form-select">
                                <option value="aktif" {{ old('status_guru', $guru->status_guru) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="pensiun" {{ old('status_guru', $guru->status_guru) == 'pensiun' ? 'selected' : '' }}>Pensiun</option>
                                <option value="nonaktif" {{ old('status_guru', $guru->status_guru) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        {{-- Upload Foto --}}
                        <div class="mb-3">
                            <label class="form-label">Foto</label><br>
                            @if($guru->foto)
                                <img src="{{ asset('storage/'.$guru->foto) }}" alt="Foto Guru" width="80" class="mb-2 rounded">
                            @endif
                            <input type="file" name="foto" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('guru.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
