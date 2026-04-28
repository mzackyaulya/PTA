@extends('layout.main')

@section('title', 'Detail Siswa')

@section('content')
    <div class="container-fluid py-4">

        <div class="mb-4">
            <a href="{{ route('siswa.index') }}" class="btn btn-secondary px-4 rounded-pill shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            
            <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning px-4 rounded-pill shadow-sm ms-2">
                <i class="fas fa-edit me-2"></i> Edit Data
            </a>
        </div>

        <div class="text-center">
            <div class="p-4">
                <div class="mb-3">
                    @if ($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Siswa"
                            class="rounded-circle shadow-sm profile-photo"
                            style="width:150px; height:150px; object-fit:cover;">
                    @else
                        <img src="{{ asset('images/default-user.png') }}" class="rounded-circle shadow-sm profile-photo"
                            style="width:150px; height:150px; object-fit:cover;">
                        <div class="text-muted mt-2 small">Belum ada foto</div>
                    @endif
                </div>
                <h4 class="fw-bold mb-1 text-dark">{{ strtoupper($siswa->user->name) }}</h4>
                <p class="text-secondary mb-2 fs-6">{{ $siswa->user->email }}</p>
                <span
                    class="badge {{ $siswa->status_siswa == 'Aktif' ? 'bg-success' : 'bg-secondary' }} px-3 py-2 rounded-pill shadow-sm">
                    {{ ucfirst($siswa->status_siswa) }}
                </span>
            </div>
        </div>

        <div class="card shadow-sm rounded-4 mb-4 border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-id-badge text-primary me-2"></i>Data Akun</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 vertical-table">
                        <tbody>
                            <tr>
                                <td class="col-label">Nama Lengkap</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->user->name }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">NISN</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->user->nisn }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Email</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->user->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label border-bottom-0">Role</td>
                                <td class="col-colon border-bottom-0">:</td>
                                <td class="col-value border-bottom-0">{{ ucfirst($siswa->user->role) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm rounded-4 mb-4 border-0 border-start border-4 border-info">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user text-info me-2"></i>Data Pribadi</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 vertical-table">
                        <tbody>
                            <tr>
                                <td class="col-label">NIS</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->nis ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Jenis Kelamin</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->jenis_kelamin ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tempat, Tanggal Lahir</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->tempat_lahir ?? '-' }},
                                    {{ $siswa->tanggal_lahir ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Agama</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->agama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Jurusan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->jurusan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Kewarganegaraan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->kewarganegaraan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label border-bottom-0">NIK</td>
                                <td class="col-colon border-bottom-0">:</td>
                                <td class="col-value border-bottom-0">{{ $siswa->nik ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm rounded-4 mb-4 border-0 border-start border-4 border-secondary">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-map-marker-alt text-secondary me-2"></i>Alamat & Tempat
                    Tinggal</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 vertical-table">
                        <tbody>
                            <tr>
                                <td class="col-label">Alamat Lengkap</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Dusun</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->dusun ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Kecamatan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->kecamatan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Kelurahan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->kelurahan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">RT / RW</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->rt ?? '-' }} / {{ $siswa->rw ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Kode Pos</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->kodepos ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">No HP</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->nohp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Jenis Tinggal</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->jenis_tinggal ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label border-bottom-0">Alat Transportasi</td>
                                <td class="col-colon border-bottom-0">:</td>
                                <td class="col-value border-bottom-0">{{ $siswa->alat_transportasi ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm rounded-4 mb-4 border-0 border-start border-4 border-primary">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-male text-primary me-2"></i>Data Ayah</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 vertical-table">
                        <tbody>
                            <tr>
                                <td class="col-label">Nama Ayah</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->nama_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tanggal Lahir</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->tanggal_lahir_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">NIK</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->nik_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Pendidikan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->pendidikan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Pekerjaan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->pekerjaan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label border-bottom-0">Penghasilan</td>
                                <td class="col-colon border-bottom-0">:</td>
                                <td class="col-value border-bottom-0">
                                    {{ $siswa->penghasilan_ayah ? 'Rp ' . $siswa->penghasilan_ayah : '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm rounded-4 mb-4 border-0 border-start border-4 border-danger">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-female text-danger me-2"></i>Data Ibu</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 vertical-table">
                        <tbody>
                            <tr>
                                <td class="col-label">Nama Ibu</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->nama_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tanggal Lahir</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->tanggal_lahir_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">NIK</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->nik_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Pendidikan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->pendidikan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Pekerjaan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->pekerjaan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label border-bottom-0">Penghasilan</td>
                                <td class="col-colon border-bottom-0">:</td>
                                <td class="col-value border-bottom-0">
                                    {{ $siswa->penghasilan_ibu ? 'Rp ' . $siswa->penghasilan_ibu : '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm rounded-4 mb-4 border-0 border-start border-4 border-success">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user-shield text-success me-2"></i>Data Wali</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 vertical-table">
                        <tbody>
                            <tr>
                                <td class="col-label">Nama Wali</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->nama_wali ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tanggal Lahir</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->tanggal_lahir_wali ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">NIK</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->nik_wali ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Pendidikan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->pendidikan_wali ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label border-bottom-0">Pekerjaan</td>
                                <td class="col-colon border-bottom-0">:</td>
                                <td class="col-value border-bottom-0">{{ $siswa->pekerjaan_wali ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm rounded-4 border-0 border-start border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-graduation-cap text-warning me-2"></i>Data Akademik &
                    Tambahan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 vertical-table">
                        <tbody>
                            <tr>
                                <td class="col-label">Kelas</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->kelasAktif ? $siswa->kelasAktif->kelas->tingkat : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="col-label">Semester</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">
                                    {{ $siswa->kelasAktif ? $siswa->kelasAktif->tahunAjaran->semester : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tahun Ajaran</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">
                                    {{ $siswa->kelasAktif ? $siswa->kelasAktif->tahunAjaran->tahun : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">No Akta Lahir</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->no_akta_lahir ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Kebutuhan Khusus</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->kebutuhan_khusus ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Asal Sekolah</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->asal_sekolah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Anak Ke</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->anakke ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">No KK</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->no_kk ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Berat Badan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->berat_badan ?? '-' }} kg</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tinggi Badan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->tinggi_badan ?? '-' }} cm</td>
                            </tr>
                            <tr>
                                <td class="col-label">Lingkar Kepala</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->lingkar_kepala ?? '-' }} cm</td>
                            </tr>
                            <tr>
                                <td class="col-label">Jumlah Saudara</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->jumlah_saudara ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Jarak Rumah ke Sekolah</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $siswa->jarak_rumah ?? '-' }} km</td>
                            </tr>
                            <tr>
                                <td class="col-label border-bottom-0">Tahun Masuk</td>
                                <td class="col-colon border-bottom-0">:</td>
                                <td class="col-value border-bottom-0">{{ $siswa->tahun_masuk ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <style>
        /* Styling Tabel Profil Bersih (Tanpa Kotak Vertikal) */
        .vertical-table {
            table-layout: fixed;
            width: 100%;
        }

        /* Hilangkan semua garis pinggir, hanya tinggalkan garis horizontal halus */
        .vertical-table td {
            padding: 12px 20px;
            border-top: none;
            border-bottom: 1px solid #f0f3f5;
            border-left: none !important;
            border-right: none !important;
        }

        /* Hilangkan border bawah pada baris terakhir di setiap tabel */
        .border-bottom-0 {
            border-bottom: none !important;
        }

        /* Pengaturan Lebar Kolom */
        .col-label {
            width: 25%;
            font-weight: 600;
            color: #6c757d;
            background-color: #fafbfc;
            /* Warna background lembut untuk label */
        }

        .col-colon {
            width: 3%;
            text-align: center;
            font-weight: bold;
            color: #495057;
            padding-left: 0 !important;
            padding-right: 0 !important;
            background-color: #fafbfc;
        }

        .col-value {
            width: 72%;
            color: #212529;
            font-weight: 500;
        }

        /* Foto Profil styling */
        .profile-photo {
            border: 4px solid #e9ecef !important;
            padding: 4px;
            transition: 0.3s ease;
        }

        .profile-photo:hover {
            border-color: #0d6efd !important;
        }

        /* Responsif untuk Layar HP */
        @media (max-width: 768px) {
            .col-label {
                width: 40%;
            }

            .col-colon {
                width: 5%;
            }

            .col-value {
                width: 55%;
            }

            .vertical-table td {
                padding: 10px;
            }
        }
    </style>
@endsection
