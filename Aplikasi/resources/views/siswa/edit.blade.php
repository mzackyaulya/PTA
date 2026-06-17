@extends('layout.main')

@section('title', 'Edit Siswa')

@section('content')
<style>
    .card-title {
        font-size: 20px;
    }

    .section-title {
        font-weight: 600;
        color: #344767;
        border-left: 4px solid #5e72e4;
        padding-left: 10px;
        margin-top: 25px;
        margin-bottom: 15px;
    }

    .form-label {
        font-weight: 500;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
    }
</style>

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="col-md-12">
    <h1 class="fw-semibold mb-4">Form Edit Siswa</h1>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ===================== DATA AKUN ===================== --}}
                <div class="section-title">Data Akun</div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $siswa->user->name ?? '') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">NISN</label>
                    <input type="text"
                           name="nisn"
                           class="form-control"
                           value="{{ old('nisn', $siswa->user->nisn ?? '') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $siswa->user->email ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label text-danger">
                        Password (Kosongkan jika tidak ingin mengubah password)
                    </label>
                    <input type="password" name="password" class="form-control">
                </div>

                {{-- ===================== DATA PRIBADI ===================== --}}
                <div class="section-title">Data Pribadi</div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIS</label>
                        <input type="text"
                               name="nis"
                               class="form-control"
                               value="{{ old('nis', $siswa->nis ?? '') }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">- Pilih -</option>

                            <option value="Laki-Laki"
                                {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Laki-Laki' ? 'selected' : '' }}>
                                Laki-Laki
                            </option>

                            <option value="Perempuan"
                                {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text"
                               name="tempat_lahir"
                               class="form-control"
                               value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date"
                               name="tanggal_lahir"
                               class="form-control"
                               value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Agama</label>
                        <select name="agama" class="form-select" required>
                            <option value="">- Pilih Agama -</option>

                            <option value="Islam"
                                {{ old('agama', $siswa->agama ?: 'Islam') == 'Islam' ? 'selected' : '' }}>
                                Islam
                            </option>

                            <option value="Kristen"
                                {{ old('agama', $siswa->agama ?? '') == 'Kristen' ? 'selected' : '' }}>
                                Kristen
                            </option>

                            <option value="Katolik"
                                {{ old('agama', $siswa->agama ?? '') == 'Katolik' ? 'selected' : '' }}>
                                Katolik
                            </option>

                            <option value="Hindu"
                                {{ old('agama', $siswa->agama ?? '') == 'Hindu' ? 'selected' : '' }}>
                                Hindu
                            </option>

                            <option value="Buddha"
                                {{ old('agama', $siswa->agama ?? '') == 'Buddha' ? 'selected' : '' }}>
                                Buddha
                            </option>

                            <option value="Konghucu"
                                {{ old('agama', $siswa->agama ?? '') == 'Konghucu' ? 'selected' : '' }}>
                                Konghucu
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kewarganegaraan</label>
                        <select name="kewarganegaraan" class="form-select">
                            <option value="">- Pilih -</option>

                            <option value="WNI"
                                {{ old('kewarganegaraan', $siswa->kewarganegaraan ?: 'WNI') == 'WNI' ? 'selected' : '' }}>
                                WNI
                            </option>

                            <option value="WNA"
                                {{ old('kewarganegaraan', $siswa->kewarganegaraan ?? '') == 'WNA' ? 'selected' : '' }}>
                                WNA
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text"
                               name="nik"
                               class="form-control"
                               value="{{ old('nik', $siswa->nik ?? '') }}">
                    </div>
                </div>

                {{-- ===================== ALAMAT ===================== --}}
                <div class="section-title">Alamat</div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Dusun</label>
                        <input type="text"
                               name="dusun"
                               class="form-control"
                               value="{{ old('dusun', $siswa->dusun ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kecamatan</label>
                        <input type="text"
                               name="kecamatan"
                               class="form-control"
                               value="{{ old('kecamatan', $siswa->kecamatan ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kelurahan</label>
                        <input type="text"
                               name="kelurahan"
                               class="form-control"
                               value="{{ old('kelurahan', $siswa->kelurahan ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label class="form-label">RT</label>
                        <input type="text"
                               name="rt"
                               class="form-control"
                               value="{{ old('rt', $siswa->rt ?? '') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label">RW</label>
                        <input type="text"
                               name="rw"
                               class="form-control"
                               value="{{ old('rw', $siswa->rw ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kode Pos</label>
                        <input type="text"
                               name="kodepos"
                               class="form-control"
                               value="{{ old('kodepos', $siswa->kodepos ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text"
                               name="nohp"
                               class="form-control"
                               value="{{ old('nohp', $siswa->nohp ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Tinggal</label>
                        <select name="jenis_tinggal" class="form-select">
                            <option value="">- Pilih -</option>

                            @foreach(['Bersama Orang Tua', 'Wali', 'Kost', 'Asrama', 'Panti Asuhan'] as $jenis)
                                <option value="{{ $jenis }}"
                                    {{ old('jenis_tinggal', $siswa->jenis_tinggal ?? '') == $jenis ? 'selected' : '' }}>
                                    {{ $jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Alat Transportasi</label>
                        <select name="alat_transportasi" class="form-select">
                            <option value="">- Pilih -</option>

                            @foreach(['Jalan Kaki', 'Sepeda', 'Motor', 'Mobil', 'Angkutan Umum', 'Ojek'] as $transport)
                                <option value="{{ $transport }}"
                                    {{ old('alat_transportasi', $siswa->alat_transportasi ?? '') == $transport ? 'selected' : '' }}>
                                    {{ $transport }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- ===================== DATA AYAH ===================== --}}
                <div class="section-title">Data Ayah</div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text"
                               name="nama_ayah"
                               class="form-control"
                               value="{{ old('nama_ayah', $siswa->nama_ayah ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Lahir Ayah</label>
                        <input type="date"
                               name="tanggal_lahir_ayah"
                               class="form-control"
                               value="{{ old('tanggal_lahir_ayah', $siswa->tanggal_lahir_ayah ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">NIK Ayah</label>
                        <input type="text"
                               name="nik_ayah"
                               class="form-control"
                               value="{{ old('nik_ayah', $siswa->nik_ayah ?? '') }}">
                    </div>
                </div>

                @php
                    $pendidikans = [
                        'Tidak Sekolah',
                        'SD / Sederajat',
                        'SLTP / Sederajat',
                        'SLTA / Sederajat',
                        'Diploma I',
                        'Diploma II',
                        'Diploma III',
                        'S1',
                        'Magister',
                        'Doktor'
                    ];
                @endphp

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pendidikan Ayah</label>
                        <select name="pendidikan_ayah" class="form-select">
                            <option value="">- Pilih Pendidikan -</option>

                            @foreach ($pendidikans as $p)
                                <option value="{{ $p }}"
                                    {{ old('pendidikan_ayah', $siswa->pendidikan_ayah ?? '') == $p ? 'selected' : '' }}>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan Ayah</label>
                        <input type="text"
                               name="pekerjaan_ayah"
                               class="form-control"
                               value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Penghasilan Ayah</label>
                        <input type="text"
                               name="penghasilan_ayah"
                               class="form-control rupiah"
                               value="{{ old('penghasilan_ayah', $siswa->penghasilan_ayah ?? '') }}">
                    </div>
                </div>

                {{-- ===================== DATA IBU ===================== --}}
                <div class="section-title">Data Ibu</div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text"
                               name="nama_ibu"
                               class="form-control"
                               value="{{ old('nama_ibu', $siswa->nama_ibu ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Lahir Ibu</label>
                        <input type="date"
                               name="tanggal_lahir_ibu"
                               class="form-control"
                               value="{{ old('tanggal_lahir_ibu', $siswa->tanggal_lahir_ibu ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">NIK Ibu</label>
                        <input type="text"
                               name="nik_ibu"
                               class="form-control"
                               value="{{ old('nik_ibu', $siswa->nik_ibu ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pendidikan Ibu</label>
                        <select name="pendidikan_ibu" class="form-select">
                            <option value="">- Pilih Pendidikan -</option>

                            @foreach ($pendidikans as $p)
                                <option value="{{ $p }}"
                                    {{ old('pendidikan_ibu', $siswa->pendidikan_ibu ?? '') == $p ? 'selected' : '' }}>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan Ibu</label>
                        <input type="text"
                               name="pekerjaan_ibu"
                               class="form-control"
                               value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Penghasilan Ibu</label>
                        <input type="text"
                               name="penghasilan_ibu"
                               class="form-control rupiah"
                               value="{{ old('penghasilan_ibu', $siswa->penghasilan_ibu ?? '') }}">
                    </div>
                </div>

                {{-- ===================== DATA WALI ===================== --}}
                <div class="section-title">Data Wali</div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Wali</label>
                        <input type="text"
                               name="nama_wali"
                               class="form-control"
                               value="{{ old('nama_wali', $siswa->nama_wali ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Lahir Wali</label>
                        <input type="date"
                               name="tanggal_lahir_wali"
                               class="form-control"
                               value="{{ old('tanggal_lahir_wali', $siswa->tanggal_lahir_wali ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">NIK Wali</label>
                        <input type="text"
                               name="nik_wali"
                               class="form-control"
                               value="{{ old('nik_wali', $siswa->nik_wali ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pendidikan Wali</label>
                        <select name="pendidikan_wali" class="form-select">
                            <option value="">- Pilih Pendidikan -</option>

                            @foreach ($pendidikans as $p)
                                <option value="{{ $p }}"
                                    {{ old('pendidikan_wali', $siswa->pendidikan_wali ?? '') == $p ? 'selected' : '' }}>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Pekerjaan Wali</label>
                        <input type="text"
                               name="pekerjaan_wali"
                               class="form-control"
                               value="{{ old('pekerjaan_wali', $siswa->pekerjaan_wali ?? '') }}">
                    </div>
                </div>

                {{-- ===================== AKADEMIK & TAMBAHAN ===================== --}}
                <div class="section-title">Data Akademik & Tambahan</div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">No Akta Lahir</label>
                        <input type="text"
                               name="no_akta_lahir"
                               class="form-control"
                               value="{{ old('no_akta_lahir', $siswa->no_akta_lahir ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kebutuhan Khusus</label>
                        <select name="kebutuhan_khusus" class="form-select" required>
                            <option value="">- Pilih -</option>

                            <option value="IYA"
                                {{ old('kebutuhan_khusus', $siswa->kebutuhan_khusus ?: 'TIDAK') == 'IYA' ? 'selected' : '' }}>
                                IYA
                            </option>

                            <option value="TIDAK"
                                {{ old('kebutuhan_khusus', $siswa->kebutuhan_khusus ?: 'TIDAK') == 'TIDAK' ? 'selected' : '' }}>
                                TIDAK
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jurusan</label>
                        <select name="jurusan" class="form-select" required>
                            <option value="">- Pilih -</option>

                            <option value="IPA"
                                {{ old('jurusan', $siswa->jurusan ?: 'IPA') == 'IPA' ? 'selected' : '' }}>
                                IPA
                            </option>

                            <option value="IPS"
                                {{ old('jurusan', $siswa->jurusan ?? '') == 'IPS' ? 'selected' : '' }}>
                                IPS
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Asal Sekolah</label>
                        <input type="text"
                               name="asal_sekolah"
                               class="form-control"
                               value="{{ old('asal_sekolah', $siswa->asal_sekolah ?? '') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label">Anak Ke</label>
                        <input type="text"
                               name="anakke"
                               class="form-control"
                               value="{{ old('anakke', $siswa->anakke ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">No KK</label>
                        <input type="text"
                               name="no_kk"
                               class="form-control"
                               value="{{ old('no_kk', $siswa->no_kk ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Berat Badan (kg)</label>
                        <input type="text"
                               name="berat_badan"
                               class="form-control"
                               value="{{ old('berat_badan', $siswa->berat_badan ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tinggi Badan (cm)</label>
                        <input type="text"
                               name="tinggi_badan"
                               class="form-control"
                               value="{{ old('tinggi_badan', $siswa->tinggi_badan ?? '') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Lingkar Kepala (cm)</label>
                        <input type="text"
                               name="lingkar_kepala"
                               class="form-control"
                               value="{{ old('lingkar_kepala', $siswa->lingkar_kepala ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah Saudara</label>
                        <input type="text"
                               name="jumlah_saudara"
                               class="form-control"
                               value="{{ old('jumlah_saudara', $siswa->jumlah_saudara ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jarak Rumah ke Sekolah (km)</label>
                        <input type="text"
                               name="jarak_rumah"
                               class="form-control"
                               value="{{ old('jarak_rumah', $siswa->jarak_rumah ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tahun Masuk</label>
                        <select name="tahun_masuk" class="form-select">
                            <option value="">- Pilih Tahun -</option>

                            @php
                                $tahunSekarang = date('Y');
                            @endphp

                            @for ($i = $tahunSekarang; $i >= $tahunSekarang - 15; $i--)
                                <option value="{{ $i }}"
                                    {{ old('tahun_masuk', $siswa->tahun_masuk ?? '') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status_siswa" class="form-select" required>
                            <option value="aktif"
                                {{ old('status_siswa', $siswa->status_siswa ?: 'aktif') == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="lulus"
                                {{ old('status_siswa', $siswa->status_siswa ?? '') == 'lulus' ? 'selected' : '' }}>
                                Lulus
                            </option>

                            <option value="pindah"
                                {{ old('status_siswa', $siswa->status_siswa ?? '') == 'pindah' ? 'selected' : '' }}>
                                Pindah
                            </option>
                        </select>
                    </div>
                </div>

                {{-- ===================== FOTO ===================== --}}
                <div class="mb-4">
                    <label class="form-label">Foto</label>

                    @php
                        $fotoSiswa = url('/assets/img/admin.png');

                        if (!empty($siswa->foto)) {
                            $cleanFoto = str_replace('storage/', '', $siswa->foto);
                            $fotoSiswa = url('/storage/' . $cleanFoto);
                        }
                    @endphp

                    <div class="mb-2">
                        <img src="{{ $fotoSiswa }}"
                             alt="Foto Siswa"
                             class="img-thumbnail"
                             style="max-height: 150px;"
                             onerror="this.onerror=null; this.src='{{ url('/assets/img/admin.png') }}';">
                    </div>

                    <input type="file" name="foto" class="form-control">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                </div>

                <button type="submit" class="btn btn-success px-4">Update</button>
                <a href="{{ route('siswa.index') }}" class="btn btn-secondary px-4">Batal</a>
            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let rupiahInputs = document.querySelectorAll('.rupiah');

        rupiahInputs.forEach(function (input) {
            if (input.value) {
                let angka = input.value.replace(/\D/g, '');
                input.value = formatRupiah(angka);
            }

            input.addEventListener('keyup', function () {
                let angka = this.value.replace(/\D/g, '');
                this.value = formatRupiah(angka);
            });
        });
    });

    function formatRupiah(angka) {
        let number_string = angka.toString();
        let sisa = number_string.length % 3;
        let rupiah = number_string.substr(0, sisa);
        let ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }
</script>
@endsection