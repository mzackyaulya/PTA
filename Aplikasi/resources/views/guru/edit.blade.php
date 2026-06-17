@extends('layout.main')

@section('title', 'Edit Guru')

@section('content')

<div class="col-md-12">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title fw-semibold mb-4">Form Edit Guru</h5>

            {{-- NOTIF SUCCESS --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- NOTIF ERROR --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- VALIDASI ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Data guru gagal diperbarui.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ================= DATA AKUN ================= --}}
                <h6 class="fw-bold mb-3">Data Akun</h6>

                <div class="mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text"
                           name="nip"
                           class="form-control @error('nip') is-invalid @enderror"
                           value="{{ old('nip', $guru->nip ?? '') }}"
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
                           value="{{ old('nama', $guru->nama ?? '') }}"
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
                           value="{{ old('email', $guru->email ?? $guru->user->email ?? '') }}"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Kosongkan jika tidak ingin mengubah password">
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
                           value="{{ old('nik', $guru->nik ?? '') }}">
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">NUPTK</label>
                    <input type="text"
                           name="nuptk"
                           class="form-control @error('nuptk') is-invalid @enderror"
                           value="{{ old('nuptk', $guru->nuptk ?? '') }}">
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

                        <option value="Laki-laki"
                            {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="Perempuan"
                            {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
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
                           value="{{ old('tempat_lahir', $guru->tempat_lahir ?? '') }}">
                    @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @php
                    $tanggalLahir = '';
                    if (!empty($guru->tanggal_lahir)) {
                        $tanggalLahir = \Carbon\Carbon::parse($guru->tanggal_lahir)->format('Y-m-d');
                    }

                    $tanggalMasuk = '';
                    if (!empty($guru->tanggal_masuk)) {
                        $tanggalMasuk = \Carbon\Carbon::parse($guru->tanggal_masuk)->format('Y-m-d');
                    }
                @endphp

                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date"
                           name="tanggal_lahir"
                           class="form-control @error('tanggal_lahir') is-invalid @enderror"
                           value="{{ old('tanggal_lahir', $tanggalLahir) }}">
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

                        @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                            <option value="{{ $agama }}"
                                {{ old('agama', $guru->agama ?? '') == $agama ? 'selected' : '' }}>
                                {{ $agama }}
                            </option>
                        @endforeach
                    </select>
                    @error('agama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat"
                              class="form-control @error('alamat') is-invalid @enderror"
                              rows="2">{{ old('alamat', $guru->alamat ?? '') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text"
                           name="nohp"
                           class="form-control @error('nohp') is-invalid @enderror"
                           value="{{ old('nohp', $guru->nohp ?? '') }}">
                    @error('nohp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                {{-- ================= DATA PENDIDIKAN ================= --}}
                <h6 class="fw-bold mb-3">Data Pendidikan</h6>

                <div class="mb-3">
                    <label class="form-label">Pendidikan Terakhir</label>
                    <select name="pendidikan_terakhir"
                            class="form-select @error('pendidikan_terakhir') is-invalid @enderror">
                        <option value="">- Pilih Pendidikan Terakhir -</option>

                        @foreach(['SMA/SMK','D1','D2','D3','D4','S1','S2','S3'] as $pendidikan)
                            <option value="{{ $pendidikan }}"
                                {{ old('pendidikan_terakhir', $guru->pendidikan_terakhir ?? '') == $pendidikan ? 'selected' : '' }}>
                                {{ $pendidikan }}
                            </option>
                        @endforeach
                    </select>
                    @error('pendidikan_terakhir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Universitas</label>
                    <input type="text"
                           name="universitas"
                           class="form-control @error('universitas') is-invalid @enderror"
                           value="{{ old('universitas', $guru->universitas ?? '') }}">
                    @error('universitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun Lulus</label>
                    <input type="text"
                           name="tahun_lulus"
                           class="form-control @error('tahun_lulus') is-invalid @enderror"
                           value="{{ old('tahun_lulus', $guru->tahun_lulus ?? '') }}">
                    @error('tahun_lulus')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Bidang Keahlian</label>
                    <input type="text"
                           name="bidang_keahlian"
                           class="form-control @error('bidang_keahlian') is-invalid @enderror"
                           value="{{ old('bidang_keahlian', $guru->bidang_keahlian ?? '') }}">
                    @error('bidang_keahlian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                {{-- ================= DATA KEPEGAWAIAN ================= --}}
                <h6 class="fw-bold mb-3">Data Kepegawaian</h6>

                <div class="mb-3">
                    <label class="form-label">Status Kepegawaian</label>
                    <select name="status_kepegawaian"
                            class="form-select @error('status_kepegawaian') is-invalid @enderror">
                        <option value="">- Pilih Status Kepegawaian -</option>

                        @foreach(['PNS','PPPK','GTY','GTT','Honorer','Tetap Yayasan','Kontrak'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status_kepegawaian', $guru->status_kepegawaian ?? '') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_kepegawaian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Masuk</label>
                    <input type="date"
                           name="tanggal_masuk"
                           class="form-control @error('tanggal_masuk') is-invalid @enderror"
                           value="{{ old('tanggal_masuk', $tanggalMasuk) }}">
                    @error('tanggal_masuk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mata Pelajaran</label>
                    <input type="text"
                           name="mapel"
                           class="form-control @error('mapel') is-invalid @enderror"
                           value="{{ old('mapel', $guru->mapel ?? '') }}">
                    @error('mapel')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox"
                           name="is_wali_kelas"
                           value="1"
                           class="form-check-input"
                           id="is_wali_kelas"
                           {{ old('is_wali_kelas', $guru->is_wali_kelas ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_wali_kelas">
                        Sebagai Wali Kelas
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Guru</label>
                    <select name="status_guru"
                            class="form-select @error('status_guru') is-invalid @enderror"
                            required>
                        <option value="aktif"
                            {{ old('status_guru', $guru->status_guru ?? 'aktif') == 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="pensiun"
                            {{ old('status_guru', $guru->status_guru ?? '') == 'pensiun' ? 'selected' : '' }}>
                            Pensiun
                        </option>

                        <option value="nonaktif"
                            {{ old('status_guru', $guru->status_guru ?? '') == 'nonaktif' ? 'selected' : '' }}>
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

                @php
                    $fotoGuru = url('/assets/img/admin.png');

                    if (!empty($guru->foto)) {
                        $cleanFoto = str_replace('storage/', '', $guru->foto);
                        $fotoGuru = url('/storage/' . $cleanFoto);
                    }
                @endphp

                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file"
                           name="foto"
                           class="form-control @error('foto') is-invalid @enderror"
                           accept="image/*">

                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mt-2">
                        <img src="{{ $fotoGuru }}"
                             width="100"
                             class="rounded border"
                             alt="Foto Guru"
                             onerror="this.onerror=null; this.src='{{ url('/assets/img/admin.png') }}';">
                    </div>
                </div>

                @php
                    $dokumen = [
                        'dokumen_ktp' => 'Dokumen KTP',
                        'dokumen_ijazah' => 'Dokumen Ijazah',
                        'dokumen_sertifikat' => 'Dokumen Sertifikat',
                        'dokumen_sk' => 'Dokumen SK',
                    ];
                @endphp

                @foreach($dokumen as $field => $label)
                    <div class="mb-3">
                        <label class="form-label">{{ $label }}</label>
                        <input type="file"
                               name="{{ $field }}"
                               class="form-control @error($field) is-invalid @enderror"
                               accept=".pdf,.jpg,.jpeg,.png,.webp">

                        @error($field)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if (!empty($guru->$field))
                            @php
                                $cleanDoc = str_replace('storage/', '', $guru->$field);
                                $urlDoc = url('/storage/' . $cleanDoc);
                            @endphp

                            <small class="d-block mt-1">
                                File saat ini:
                                <a href="{{ $urlDoc }}" target="_blank">Lihat Dokumen</a>
                            </small>
                        @endif
                    </div>
                @endforeach

                <button type="submit" class="btn btn-success">
                    Update
                </button>

                <a href="{{ route('guru.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>
</div>

@endsection