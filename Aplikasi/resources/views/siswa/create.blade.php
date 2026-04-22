@extends('layout.main')

@section('title', 'Tambah Siswa')

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
        <h1 class="fw-semibold mb-4">Form Tambah Siswa</h1>
        <div class="card">
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- ===================== DATA AKUN ===================== --}}
                            <div class="section-title">Data Akun</div>
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control" value="{{ old('nisn') }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password (kosongkan = default siswa123)</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            {{-- ===================== DATA PRIBADI ===================== --}}
                            <div class="section-title">Data Pribadi</div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIS</label>
                                    <input type="text" name="nis" class="form-control" value="{{ old('nis') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select" value="{{ old('jenis_kelamin') }}">
                                        <option value="">- Pilih -</option>
                                        <option value="Laki-Laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control"
                                        value="{{ old('tempat_lahir') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                        value="{{ old('tanggal_lahir') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Agama</label>
                                    <select name="agama" class="form-select">
                                        <option value="">- Pilih Agama -</option>
                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Kewarganegaraan</label>
                                    <select name="kewarganegaraan" class="form-select">
                                        <option value="">- Pilih -</option>
                                        <option value="WNI" {{ old('kewarganegaraan') == 'WNI' ? 'selected' : '' }}>WNI
                                        </option>
                                        <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik" class="form-control" value="{{ old('nik') }}">
                                </div>
                            </div>

                            {{-- ===================== ALAMAT ===================== --}}
                            <div class="section-title">Alamat</div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Dusun</label>
                                    <input type="text" name="dusun" class="form-control"
                                        value="{{ old('dusun') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Kecamatan</label><input type="text" name="kecamatan"
                                        class="form-control" value="{{ old('kecamatan') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Kelurahan</label>
                                    <input type="text" name="kelurahan" class="form-control"
                                        value="{{ old('kelurahan') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">RT</label>
                                    <input type="text" name="rt" class="form-control"
                                        value="{{ old('rt') }}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">RW</label>
                                    <input type="text" name="rw" class="form-control"
                                        value="{{ old('rw') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="text" name="kodepos" class="form-control"
                                        value="{{ old('kodepos') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">No HP</label>
                                    <input type="text" name="nohp" class="form-control"
                                        value="{{ old('nohp') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Tinggal</label>
                                    <select name="jenis_tinggal" class="form-select">
                                        <option value="">- Pilih -</option>
                                        <option value="Bersama Orang Tua">Bersama Orang Tua</option>
                                        <option value="Wali">Wali</option>
                                        <option value="Kost">Kost</option>
                                        <option value="Asrama">Asrama</option>
                                        <option value="Panti Asuhan">Panti Asuhan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Alat Transportasi</label>
                                    <select name="alat_transportasi" class="form-select">
                                        <option value="">- Pilih -</option>
                                        <option value="Jalan Kaki">Jalan Kaki</option>
                                        <option value="Sepeda">Sepeda</option>
                                        <option value="Motor">Motor</option>
                                        <option value="Mobil">Mobil</option>
                                        <option value="Angkutan Umum">Angkutan Umum</option>
                                        <option value="Ojek">Ojek</option>
                                    </select>
                                </div>
                            </div>

                            {{-- ===================== ORANG TUA ===================== --}}
                            <div class="section-title">Data Ayah</div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" name="nama_ayah" class="form-control"
                                        value="{{ old('nama_ayah') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir_ayah" class="form-control"
                                        value="{{ old('tanggal_lahir_ayah') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik_ayah" class="form-control"
                                        value="{{ old('nik_ayah') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Pendidikan</label>
                                    <select name="pendidikan_ayah" class="form-select">
                                        <option value="">- Pilih Pendidikan -</option>
                                        <option value="Tidak Sekolah"
                                            {{ old('pendidikan_ayah') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah
                                        </option>
                                        <option value="SD / Sederajat"
                                            {{ old('pendidikan_ayah') == 'SD / Sederajat' ? 'selected' : '' }}>SD / Sederajat
                                        </option>
                                        <option value="SLTP / Sederajat"
                                            {{ old('pendidikan_ayah') == 'SLTP / Sederajat' ? 'selected' : '' }}>SLTP / Sederajat
                                        </option>
                                        <option value="SLTA / Sederajat"
                                            {{ old('pendidikan_ayah') == 'SLTA / Sederajat' ? 'selected' : '' }}>SLTA / Sederajat
                                        </option>
                                        <option value="Diploma I" {{ old('pendidikan_ayah') == 'Diploma I' ? 'selected' : '' }}>
                                            Diploma I</option>
                                        <option value="Diploma II"
                                            {{ old('pendidikan_ayah') == 'Diploma II' ? 'selected' : '' }}>Diploma II</option>
                                        <option value="Diploma III"
                                            {{ old('pendidikan_ayah') == 'Diploma III' ? 'selected' : '' }}>Diploma III</option>
                                        <option value="S1" {{ old('pendidikan_ayah') == 'S1' ? 'selected' : '' }}>S1
                                        </option>
                                        <option value="Magister" {{ old('pendidikan_ayah') == 'Magister' ? 'selected' : '' }}>
                                            Magister</option>
                                        <option value="Doktor" {{ old('pendidikan_ayah') == 'Doktor' ? 'selected' : '' }}>Doktor
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" name="pekerjaan_ayah" class="form-control"
                                        value="{{ old('pekerjaan_ayah') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Penghasilan</label>
                                    <input type="text" name="penghasilan_ayah" class="form-control rupiah"
                                        value="{{ old('penghasilan_ayah') }}">
                                </div>
                            </div>

                            <div class="section-title">Data Ibu</div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" class="form-control"
                                        value="{{ old('nama_ibu') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir_ibu" class="form-control"
                                        value="{{ old('tanggal_lahir_ibu') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik_ibu" class="form-control"
                                        value="{{ old('nik_ibu') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Pendidikan</label>
                                    <select name="pendidikan_ibu" class="form-select">
                                        <option value="">- Pilih Pendidikan -</option>
                                        <option value="Tidak Sekolah"
                                            {{ old('pendidikan_ibu') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah
                                        </option>
                                        <option value="SD / Sederajat"
                                            {{ old('pendidikan_ibu') == 'SD / Sederajat' ? 'selected' : '' }}>SD / Sederajat
                                        </option>
                                        <option value="SLTP / Sederajat"
                                            {{ old('pendidikan_ibu') == 'SLTP / Sederajat' ? 'selected' : '' }}>SLTP / Sederajat
                                        </option>
                                        <option value="SLTA / Sederajat"
                                            {{ old('pendidikan_ibu') == 'SLTA / Sederajat' ? 'selected' : '' }}>SLTA / Sederajat
                                        </option>
                                        <option value="Diploma I" {{ old('pendidikan_ibu') == 'Diploma I' ? 'selected' : '' }}>
                                            Diploma I</option>
                                        <option value="Diploma II"
                                            {{ old('pendidikan_ibu') == 'Diploma II' ? 'selected' : '' }}>Diploma II</option>
                                        <option value="Diploma III"
                                            {{ old('pendidikan_ibu') == 'Diploma III' ? 'selected' : '' }}>Diploma III</option>
                                        <option value="S1" {{ old('pendidikan_ibu') == 'S1' ? 'selected' : '' }}>S1</option>
                                        <option value="Magister" {{ old('pendidikan_ibu') == 'Magister' ? 'selected' : '' }}>
                                            Magister</option>
                                        <option value="Doktor" {{ old('pendidikan_ibu') == 'Doktor' ? 'selected' : '' }}>Doktor
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" name="pekerjaan_ibu" class="form-control"
                                        value="{{ old('pekerjaan_ibu') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Penghasilan</label>
                                    <input type="text" name="penghasilan_ibu" class="form-control rupiah"
                                        value="{{ old('penghasilan_ibu') }}">
                                </div>
                            </div>

                            <div class="section-title">Data Wali</div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nama Wali</label>
                                    <input type="text" name="nama_wali" class="form-control"
                                        value="{{ old('nama_wali') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir_wali" class="form-control"
                                        value="{{ old('tanggal_lahir_wali') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" name="nik_wali" class="form-control"
                                        value="{{ old('nik_wali') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Pendidikan</label>
                                    <select name="pendidikan_wali" class="form-select">
                                        <option value="">- Pilih Pendidikan -</option>
                                        <option value="Tidak Sekolah"
                                            {{ old('pendidikan_wali') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah
                                        </option>
                                        <option value="SD / Sederajat"
                                            {{ old('pendidikan_wali') == 'SD / Sederajat' ? 'selected' : '' }}>SD / Sederajat
                                        </option>
                                        <option value="SLTP / Sederajat"
                                            {{ old('pendidikan_wali') == 'SLTP / Sederajat' ? 'selected' : '' }}>SLTP / Sederajat
                                        </option>
                                        <option value="SLTA / Sederajat"
                                            {{ old('pendidikan_wali') == 'SLTA / Sederajat' ? 'selected' : '' }}>SLTA / Sederajat
                                        </option>
                                        <option value="Diploma I" {{ old('pendidikan_wali') == 'Diploma I' ? 'selected' : '' }}>
                                            Diploma I</option>
                                        <option value="Diploma II"
                                            {{ old('pendidikan_wali') == 'Diploma II' ? 'selected' : '' }}>Diploma II</option>
                                        <option value="Diploma III"
                                            {{ old('pendidikan_wali') == 'Diploma III' ? 'selected' : '' }}>Diploma III</option>
                                        <option value="S1" {{ old('pendidikan_wali') == 'S1' ? 'selected' : '' }}>S1
                                        </option>
                                        <option value="Magister" {{ old('pendidikan_wali') == 'Magister' ? 'selected' : '' }}>
                                            Magister</option>
                                        <option value="Doktor" {{ old('pendidikan_wali') == 'Doktor' ? 'selected' : '' }}>Doktor
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" name="pekerjaan_wali" class="form-control"
                                        value="{{ old('pekerjaan_wali') }}">
                                </div>
                            </div>

                            {{-- ===================== AKADEMIK & TAMBAHAN ===================== --}}
                            <div class="section-title">Data Akademik & tambahan</div>
                            <div class="row">
                                <div class="col-md-4 mb-3"><label class="form-label">No Akta Lahir</label><input
                                        type="text" name="no_akta_lahir" class="form-control"
                                        value="{{ old('no_akta_lahir') }}"></div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Kebutuhan Khusus</label>
                                    <select name="kebutuhan_khusus" class="form-select">
                                        <option value="">- Pilih -</option>
                                        <option value="IYA" {{ old('kebutuhan_khusus') == 'IYA' ? 'selected' : '' }}>
                                            IYA</option>
                                        <option value="TIDAK" {{ old('kebutuhan_khusus') == 'TIDAK' ? 'selected' : '' }}>
                                            TIDAK</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Asal Sekolah</label>
                                    <input type="text" name="asal_sekolah" class="form-control"
                                        value="{{ old('asal_sekolah') }}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Anak Ke</label>
                                    <input type="text" name="anakke" class="form-control"
                                        value="{{ old('anakke') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">No KK</label>
                                    <input type="text" name="no_kk" class="form-control"
                                        value="{{ old('no_kk') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Berat Badan (kg)</label>
                                    <input type="text" name="berat_badan" class="form-control"
                                        value="{{ old('berat_badan') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tinggi Badan (cm)</label>
                                    <input type="text" name="tinggi_badan" class="form-control"
                                        value="{{ old('tinggi_badan') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Lingkar Kepala (cm)</label>
                                    <input type="text" name="lingkar_kepala" class="form-control"
                                        value="{{ old('lingkar_kepala') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jumlah Saudara</label>
                                    <input type="text" name="jumlah_saudara" class="form-control"
                                        value="{{ old('jumlah_saudara') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jarak Rumah ke Sekolah (km)</label>
                                    <input type="text" name="jarak_rumah" class="form-control"
                                        value="{{ old('jarak_rumah') }}">
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
                                                {{ old('tahun_masuk') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor

                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status_siswa" class="form-select">
                                        <option value="aktif">Aktif</option>
                                        <option value="lulus">Lulus</option>
                                        <option value="pindah">Pindah</option>
                                    </select>
                                </div>
                            </div>

                            {{-- ===================== FOTO ===================== --}}
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
    <script>
        document.querySelectorAll('.rupiah').forEach(function(input) {

            input.addEventListener('keyup', function(e) {

                let angka = this.value.replace(/\D/g, '');

                this.value = formatRupiah(angka);

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
