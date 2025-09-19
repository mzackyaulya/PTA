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

                        {{-- Data Akun --}}
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

                        {{-- Data Pribadi --}}
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">- Pilih -</option>
                                <option value="Laki-Laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control"
                                   value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                   value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Agama</label>
                            <input type="text" name="agama" class="form-control"
                                   value="{{ old('agama', $siswa->agama) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $siswa->alamat) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="nohp" class="form-control"
                                   value="{{ old('nohp', $siswa->nohp) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control"
                                   value="{{ old('nik', $siswa->nik) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" class="form-control"
                                   value="{{ old('kewarganegaraan', $siswa->kewarganegaraan) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control"
                                   value="{{ old('kode_pos', $siswa->kode_pos) }}">
                        </div>

                        {{-- Data Orang Tua --}}
                        <h6 class="fw-bold mt-4">Data Ayah</h6>
                        <div class="mb-3">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control"
                                   value="{{ old('nama_ayah', $siswa->nama_ayah) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir Ayah</label>
                            <input type="date" name="tanggal_lahir_ayah" class="form-control"
                                   value="{{ old('tanggal_lahir_ayah', $siswa->tanggal_lahir_ayah) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" class="form-control"
                                   value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}">
                        </div>

                        <h6 class="fw-bold mt-4">Data Ibu</h6>
                        <div class="mb-3">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control"
                                   value="{{ old('nama_ibu', $siswa->nama_ibu) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir Ibu</label>
                            <input type="date" name="tanggal_lahir_ibu" class="form-control"
                                   value="{{ old('tanggal_lahir_ibu', $siswa->tanggal_lahir_ibu) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" class="form-control"
                                   value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}">
                        </div>

                        {{-- Data Akademik --}}
                        <div class="mb-3">
                            <label class="form-label">Tahun Masuk</label>
                            <input type="number" name="tahun_masuk" class="form-control"
                                   value="{{ old('tahun_masuk', $siswa->tahun_masuk) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status_siswa" class="form-select">
                                <option value="aktif" {{ old('status_siswa', $siswa->status_siswa) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="lulus" {{ old('status_siswa', $siswa->status_siswa) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="pindah" {{ old('status_siswa', $siswa->status_siswa) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                            </select>
                        </div>

                        {{-- Upload Foto --}}
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
