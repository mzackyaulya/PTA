@extends('layout.main')

@section('title', 'Detail Siswa')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Detail Siswa</h5>
            <div class="card">
                <div class="card-body">

                    {{-- ===================== DATA AKUN ===================== --}}
                    <h6 class="fw-bold">Data Akun</h6>
                    <table class="table table-bordered">
                        <tr><th>Nama Lengkap</th><td>{{ $siswa->user->name }}</td></tr>
                        <tr><th>NISN</th><td>{{ $siswa->user->nisn }}</td></tr>
                        <tr><th>Email</th><td>{{ $siswa->user->email ?? '-' }}</td></tr>
                        <tr><th>Role</th><td>{{ ucfirst($siswa->user->role) }}</td></tr>
                    </table>

                    {{-- ===================== DATA PRIBADI ===================== --}}
                    <h6 class="fw-bold mt-4">Data Pribadi</h6>
                    <table class="table table-bordered">
                        <tr><th>NIS</th><td>{{ $siswa->nis ?? '-' }}</td></tr>
                        <tr><th>Jenis Kelamin</th><td>{{ $siswa->jenis_kelamin ?? '-' }}</td></tr>
                        <tr><th>Tempat, Tanggal Lahir</th>
                            <td>{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ?? '-' }}</td></tr>
                        <tr><th>Agama</th><td>{{ $siswa->agama ?? '-' }}</td></tr>
                        <tr><th>Kewarganegaraan</th><td>{{ $siswa->kewarganegaraan ?? '-' }}</td></tr>
                        <tr><th>NIK</th><td>{{ $siswa->nik ?? '-' }}</td></tr>
                    </table>

                    {{-- ===================== ALAMAT ===================== --}}
                    <h6 class="fw-bold mt-4">Alamat</h6>
                    <table class="table table-bordered">
                        <tr><th>Alamat Lengkap</th><td>{{ $siswa->alamat ?? '-' }}</td></tr>
                        <tr><th>Dusun</th><td>{{ $siswa->dusun ?? '-' }}</td></tr>
                        <tr><th>Kecamatan</th><td>{{ $siswa->kecamatan ?? '-' }}</td></tr>
                        <tr><th>Kelurahan</th><td>{{ $siswa->kelurahan ?? '-' }}</td></tr>
                        <tr><th>RT/RW</th><td>{{ $siswa->rt ?? '-' }}/{{ $siswa->rw ?? '-' }}</td></tr>
                        <tr><th>Kode Pos</th><td>{{ $siswa->kodepos ?? '-' }}</td></tr>
                        <tr><th>No HP</th><td>{{ $siswa->nohp ?? '-' }}</td></tr>
                        <tr><th>Jenis Tinggal</th><td>{{ $siswa->jenis_tinggal ?? '-' }}</td></tr>
                        <tr><th>Alat Transportasi</th><td>{{ $siswa->alat_transportasi ?? '-' }}</td></tr>
                    </table>

                    {{-- ===================== DATA ORANG TUA ===================== --}}
                    <h6 class="fw-bold mt-4">Data Ayah</h6>
                    <table class="table table-bordered">
                        <tr><th>Nama</th><td>{{ $siswa->nama_ayah ?? '-' }}</td></tr>
                        <tr><th>Tanggal Lahir</th><td>{{ $siswa->tanggal_lahir_ayah ?? '-' }}</td></tr>
                        <tr><th>NIK</th><td>{{ $siswa->nik_ayah ?? '-' }}</td></tr>
                        <tr><th>Pendidikan</th><td>{{ $siswa->pendidikan_ayah ?? '-' }}</td></tr>
                        <tr><th>Pekerjaan</th><td>{{ $siswa->pekerjaan_ayah ?? '-' }}</td></tr>
                        <tr><th>Penghasilan</th><td>{{ $siswa->penghasilan_ayah ?? '-' }}</td></tr>
                    </table>

                    <h6 class="fw-bold mt-4">Data Ibu</h6>
                    <table class="table table-bordered">
                        <tr><th>Nama</th><td>{{ $siswa->nama_ibu ?? '-' }}</td></tr>
                        <tr><th>Tanggal Lahir</th><td>{{ $siswa->tanggal_lahir_ibu ?? '-' }}</td></tr>
                        <tr><th>NIK</th><td>{{ $siswa->nik_ibu ?? '-' }}</td></tr>
                        <tr><th>Pendidikan</th><td>{{ $siswa->pendidikan_ibu ?? '-' }}</td></tr>
                        <tr><th>Pekerjaan</th><td>{{ $siswa->pekerjaan_ibu ?? '-' }}</td></tr>
                        <tr><th>Penghasilan</th><td>{{ $siswa->penghasilan_ibu ?? '-' }}</td></tr>
                    </table>

                    <h6 class="fw-bold mt-4">Data Wali</h6>
                    <table class="table table-bordered">
                        <tr><th>Nama</th><td>{{ $siswa->nama_wali ?? '-' }}</td></tr>
                        <tr><th>Tanggal Lahir</th><td>{{ $siswa->tanggal_lahir_wali ?? '-' }}</td></tr>
                        <tr><th>NIK</th><td>{{ $siswa->nik_wali ?? '-' }}</td></tr>
                        <tr><th>Pendidikan</th><td>{{ $siswa->pendidikan_wali ?? '-' }}</td></tr>
                        <tr><th>Pekerjaan</th><td>{{ $siswa->pekerjaan_wali ?? '-' }}</td></tr>
                    </table>

                    {{-- ===================== AKADEMIK & TAMBAHAN ===================== --}}
                    <h6 class="fw-bold mt-4">Data Akademik & Tambahan</h6>
                    <table class="table table-bordered">
                        <tr><th>Kelas</th><td>{{ $siswa->kelas ?? '-' }}</td></tr>
                        <tr><th>No Akta Lahir</th><td>{{ $siswa->no_akta_lahir ?? '-' }}</td></tr>
                        <tr><th>Kebutuhan Khusus</th><td>{{ $siswa->kebutuhan_khusus ?? '-' }}</td></tr>
                        <tr><th>Asal Sekolah</th><td>{{ $siswa->asal_sekolah ?? '-' }}</td></tr>
                        <tr><th>Anak Ke</th><td>{{ $siswa->anakke ?? '-' }}</td></tr>
                        <tr><th>No KK</th><td>{{ $siswa->no_kk ?? '-' }}</td></tr>
                        <tr><th>Berat Badan</th><td>{{ $siswa->berat_badan ?? '-' }} kg</td></tr>
                        <tr><th>Tinggi Badan</th><td>{{ $siswa->tinggi_badan ?? '-' }} cm</td></tr>
                        <tr><th>Lingkar Kepala</th><td>{{ $siswa->lingkar_kepala ?? '-' }} cm</td></tr>
                        <tr><th>Jumlah Saudara</th><td>{{ $siswa->jumlah_saudara ?? '-' }}</td></tr>
                        <tr><th>Jarak Rumah ke Sekolah</th><td>{{ $siswa->jarak_rumah ?? '-' }} km</td></tr>
                        <tr><th>Tahun Masuk</th><td>{{ $siswa->tahun_masuk ?? '-' }}</td></tr>
                        <tr><th>Status</th><td>{{ ucfirst($siswa->status_siswa) }}</td></tr>
                    </table>

                    {{-- ===================== FOTO ===================== --}}
                    <h6 class="fw-bold mt-4">Foto</h6>
                    @if($siswa->foto)
                        <img src="{{ asset('storage/'.$siswa->foto) }}" alt="Foto Siswa" class="img-thumbnail" style="max-width: 200px;">
                    @else
                        <p><i>Belum ada foto</i></p>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning">Edit</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
