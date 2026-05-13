@extends('layout.main')

@section('title','Buat Permohonan Surat')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Ajukan Surat Permohonan</h4>

        <a href="{{ route('surat.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    {{-- Alert Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <strong>Form Pengajuan Surat</strong>
        </div>

        <div class="card-body">
            <form action="{{ route('surat.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Jenis Surat --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                        <select name="jenis_surat" id="jenis_surat" class="form-control" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            <option value="dispensasi" {{ old('jenis_surat') == 'dispensasi' ? 'selected' : '' }}>
                                Surat Dispensasi
                            </option>
                            <option value="permohonan_lomba" {{ old('jenis_surat') == 'permohonan_lomba' ? 'selected' : '' }}>
                                Surat Permohonan Lomba
                            </option>
                            <option value="permohonan_organisasi" {{ old('jenis_surat') == 'permohonan_organisasi' ? 'selected' : '' }}>
                                Surat Permohonan Organisasi
                            </option>
                            <option value="izin_kegiatan" {{ old('jenis_surat') == 'izin_kegiatan' ? 'selected' : '' }}>
                                Surat Izin Kegiatan
                            </option>
                            <option value="keterangan" {{ old('jenis_surat') == 'keterangan' ? 'selected' : '' }}>
                                Surat Keterangan
                            </option>
                            <option value="lainnya" {{ old('jenis_surat') == 'lainnya' ? 'selected' : '' }}>
                                Lainnya
                            </option>
                        </select>
                    </div>

                    {{-- Judul --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Judul Surat <span class="text-danger">*</span></label>
                        <input type="text"
                               name="judul"
                               class="form-control"
                               value="{{ old('judul') }}"
                               placeholder="Contoh: Permohonan Dispensasi Lomba Futsal"
                               required>
                    </div>

                    {{-- Nama Kegiatan --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Kegiatan</label>
                        <input type="text"
                               name="nama_kegiatan"
                               class="form-control"
                               value="{{ old('nama_kegiatan') }}"
                               placeholder="Contoh: Lomba Futsal Antar Sekolah">
                    </div>

                    {{-- Tempat Kegiatan --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tempat Kegiatan</label>
                        <input type="text"
                               name="tempat_kegiatan"
                               class="form-control"
                               value="{{ old('tempat_kegiatan') }}"
                               placeholder="Contoh: GOR Dempo Palembang">
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date"
                               name="tanggal_mulai"
                               class="form-control"
                               value="{{ old('tanggal_mulai') }}">
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date"
                               name="tanggal_selesai"
                               class="form-control"
                               value="{{ old('tanggal_selesai') }}">
                    </div>

                    {{-- Nama Pelatih --}}
                    <div class="col-md-6 mb-3" id="field_pelatih">
                        <label class="form-label">Nama Pelatih / Pembina</label>
                        <input type="text"
                               name="nama_pelatih"
                               class="form-control"
                               value="{{ old('nama_pelatih') }}"
                               placeholder="Contoh: Bapak Ahmad">
                    </div>

                    {{-- Nama Organisasi --}}
                    <div class="col-md-6 mb-3" id="field_organisasi">
                        <label class="form-label">Nama Organisasi</label>
                        <input type="text"
                               name="nama_organisasi"
                               class="form-control"
                               value="{{ old('nama_organisasi') }}"
                               placeholder="Contoh: IPM / OSIS / Tapak Suci">
                    </div>

                    {{-- Pilih Siswa Terkait --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Pilih Siswa Terkait Berdasarkan NIS</label>
                        <select name="siswa_ids[]" class="form-control" multiple>
                            @foreach ($siswas as $siswa)
                                <option value="{{ $siswa->id }}"
                                    {{ collect(old('siswa_ids'))->contains($siswa->id) ? 'selected' : '' }}>
                                    {{ $siswa->nis }} - {{ $siswa->user->name ?? 'Nama tidak tersedia' }}
                                </option>
                            @endforeach
                        </select>

                        <small class="text-muted">
                            Tekan Ctrl untuk memilih lebih dari satu siswa. Untuk lomba atau kegiatan kelompok, pilih semua siswa yang terlibat.
                        </small>
                    </div>

                    {{-- Keperluan --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Keperluan / Alasan Pengajuan <span class="text-danger">*</span></label>
                        <textarea name="keperluan"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Tuliskan alasan atau keperluan surat..."
                                  required>{{ old('keperluan') }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('surat.index') }}" class="btn btn-secondary">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Ajukan Surat
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function toggleFieldSurat() {
        const jenisSurat = document.getElementById('jenis_surat').value;
        const fieldPelatih = document.getElementById('field_pelatih');
        const fieldOrganisasi = document.getElementById('field_organisasi');

        fieldPelatih.style.display = 'block';
        fieldOrganisasi.style.display = 'block';

        if (jenisSurat === 'permohonan_organisasi') {
            fieldPelatih.style.display = 'none';
            fieldOrganisasi.style.display = 'block';
        }

        if (jenisSurat === 'dispensasi' || jenisSurat === 'permohonan_lomba') {
            fieldPelatih.style.display = 'block';
            fieldOrganisasi.style.display = 'none';
        }

        if (jenisSurat === 'izin_kegiatan' || jenisSurat === 'keterangan' || jenisSurat === 'lainnya' || jenisSurat === '') {
            fieldPelatih.style.display = 'block';
            fieldOrganisasi.style.display = 'block';
        }
    }

    document.getElementById('jenis_surat').addEventListener('change', toggleFieldSurat);
    document.addEventListener('DOMContentLoaded', toggleFieldSurat);
</script>
@endsection