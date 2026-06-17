@extends('layout.main')

@section('title', 'Tambah Guru')

@section('content')

<div class="col-md-12">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title fw-semibold mb-4">Form Tambah Guru</h5>

            {{-- NOTIF ERROR --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- NOTIF SUCCESS --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- VALIDASI ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Data belum berhasil disimpan.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ================= DATA AKUN ================= --}}
                <h6 class="fw-bold mb-3">Data Akun</h6>

                <div class="mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text"
                           name="nip"
                           class="form-control @error('nip') is-invalid @enderror"
                           value="{{ old('nip') }}"
                           required>
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text"
                           name="nama"
                           class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama') }}"
                           required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password (default = guru123 jika dikosongkan)</label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                {{-- ================= DATA IDENTITAS GURU ================= --}}
                <h6 class="fw-bold mb-3">Data Identitas Guru</h6>

                <div class="mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text"
                           name="nik"
                           class="form-control @error('nik') is-invalid @enderror"
                           value="{{ old('nik') }}">
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">NUPTK</label>
                    <input type="text"
                           name="nuptk"
                           class="form-control @error('nuptk') is-invalid @enderror"
                           value="{{ old('nuptk') }}">
                    @error('nuptk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                            class="form-select @error('jenis_kelamin') is-invalid @enderror"
                            required>
                        <option value="">- Pilih -</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text"
                           name="tempat_lahir"
                           class="form-control @error('tempat_lahir') is-invalid @enderror"
                           value="{{ old('tempat_lahir') }}">
                    @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date"
                           name="tanggal_lahir"
                           class="form-control @error('tanggal_lahir') is-invalid @enderror"
                           value="{{ old('tanggal_lahir') }}">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Agama</label>
                    <select name="agama"
                            class="form-select @error('agama') is-invalid @enderror"
                            required>
                        <option value="">- Pilih Agama -</option>
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('agama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat"
                              class="form-control @error('alamat') is-invalid @enderror"
                              rows="2">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text"
                           name="nohp"
                           class="form-control @error('nohp') is-invalid @enderror"
                           value="{{ old('nohp') }}">
                    @error('nohp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                {{-- ================= DATA PENDIDIKAN ================= --}}
                <h6 class="fw-bold mb-3">Data Pendidikan</h6>

                <div class="mb-3">
                    <label class="form-label">Pendidikan Terakhir</label>
                    <select name="pendidikan_terakhir" class="form-select">
                        <option value="">- Pilih Pendidikan Terakhir -</option>
                        @foreach(['SMA/SMK','D1','D2','D3','D4','S1','S2','S3'] as $p)
                            <option value="{{ $p }}" {{ old('pendidikan_terakhir') == $p ? 'selected' : '' }}>
                                {{ $p }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Universitas</label>
                    <input type="text"
                           name="universitas"
                           class="form-control"
                           value="{{ old('universitas') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun Lulus</label>
                    <input type="text"
                           name="tahun_lulus"
                           class="form-control"
                           value="{{ old('tahun_lulus') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Bidang Keahlian</label>
                    <input type="text"
                           name="bidang_keahlian"
                           class="form-control"
                           value="{{ old('bidang_keahlian') }}">
                </div>

                <hr>

                {{-- ================= DATA KEPEGAWAIAN ================= --}}
                <h6 class="fw-bold mb-3">Data Kepegawaian</h6>

                <div class="mb-3">
                    <label class="form-label">Status Kepegawaian</label>
                    <select name="status_kepegawaian" class="form-select">
                        <option value="">- Pilih Status Kepegawaian -</option>
                        @foreach(['PNS','PPPK','GTY','GTT','Honorer','Tetap Yayasan','Kontrak'] as $status)
                            <option value="{{ $status }}" {{ old('status_kepegawaian') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Masuk</label>
                    <input type="date"
                           name="tanggal_masuk"
                           class="form-control"
                           value="{{ old('tanggal_masuk') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mata Pelajaran</label>
                    <input type="text"
                           name="mapel"
                           class="form-control"
                           value="{{ old('mapel') }}">
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox"
                           name="is_wali_kelas"
                           value="1"
                           class="form-check-input"
                           id="is_wali_kelas"
                           {{ old('is_wali_kelas') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_wali_kelas">
                        Sebagai Wali Kelas
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Guru</label>
                    <select name="status_guru"
                            class="form-select @error('status_guru') is-invalid @enderror"
                            required>
                        <option value="aktif" {{ old('status_guru', 'aktif') == 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="pensiun" {{ old('status_guru') == 'pensiun' ? 'selected' : '' }}>
                            Pensiun
                        </option>
                        <option value="nonaktif" {{ old('status_guru') == 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                    @error('status_guru')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                {{-- ================= FOTO DAN DOKUMEN ================= --}}
                <h6 class="fw-bold mb-3">Foto dan Dokumen</h6>

                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file"
                           name="foto"
                           class="form-control @error('foto') is-invalid @enderror"
                           accept="image/*">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Dokumen KTP</label>
                    <input type="file"
                           name="dokumen_ktp"
                           class="form-control"
                           accept=".pdf,.jpg,.jpeg,.png,.webp">
                </div>

                <div class="mb-3">
                    <label class="form-label">Dokumen Ijazah</label>
                    <input type="file"
                           name="dokumen_ijazah"
                           class="form-control"
                           accept=".pdf,.jpg,.jpeg,.png,.webp">
                </div>

                <div class="mb-3">
                    <label class="form-label">Dokumen Sertifikat</label>
                    <input type="file"
                           name="dokumen_sertifikat"
                           class="form-control"
                           accept=".pdf,.jpg,.jpeg,.png,.webp">
                </div>

                <div class="mb-3">
                    <label class="form-label">Dokumen SK</label>
                    <input type="file"
                           name="dokumen_sk"
                           class="form-control"
                           accept=".pdf,.jpg,.jpeg,.png,.webp">
                </div>

                <button type="submit" class="btn btn-success">
                    Simpan
                </button>

                <a href="{{ route('guru.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>
        </div>
    </div>
</div>

@endsection