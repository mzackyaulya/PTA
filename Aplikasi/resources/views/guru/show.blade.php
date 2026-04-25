@extends('layout.main')

@section('title', 'Detail Guru')

@section('content')
<style>
    .vertical-table {
        table-layout: fixed;
        width: 100%;
    }

    .vertical-table td {
        padding: 12px 20px;
        border-top: none;
        border-bottom: 1px solid #f0f3f5;
        border-left: none !important;
        border-right: none !important;
    }

    .border-bottom-0 {
        border-bottom: none !important;
    }

    .col-label {
        width: 25%;
        font-weight: 600;
        color: #6c757d;
        background-color: #fafbfc;
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

    .profile-photo {
        border: 4px solid #e9ecef !important;
        padding: 4px;
        transition: 0.3s ease;
    }

    .profile-photo:hover {
        border-color: #0d6efd !important;
    }

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

<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="{{ route('guru.index') }}" class="btn btn-secondary px-4 rounded-pill shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>

        <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-warning px-4 rounded-pill shadow-sm ms-2">
            <i class="fas fa-edit me-2"></i> Edit Data
        </a>
    </div>

    <div class="text-center">
        <div class="p-4">
            <div class="mb-3">
                @if ($guru->foto)
                    <img src="{{ asset('storage/' . $guru->foto) }}" alt="Foto Guru"
                        class="rounded-circle shadow-sm profile-photo"
                        style="width:150px; height:150px; object-fit:cover;">
                @else
                    <img src="{{ asset('images/default-user.png') }}" alt="Foto Guru"
                        class="rounded-circle shadow-sm profile-photo"
                        style="width:150px; height:150px; object-fit:cover;">
                    <div class="text-muted mt-2 small">Belum ada foto</div>
                @endif
            </div>

            <h4 class="fw-bold mb-1 text-dark">{{ strtoupper($guru->user->name ?? $guru->nama) }}</h4>
            <p class="text-secondary mb-2 fs-6">{{ $guru->user->email ?? $guru->email ?? '-' }}</p>

            <span class="badge 
                @if ($guru->status_guru == 'aktif') bg-success
                @elseif ($guru->status_guru == 'pensiun') bg-primary
                @else bg-secondary
                @endif
                px-3 py-2 rounded-pill shadow-sm">
                {{ ucfirst($guru->status_guru ?? '-') }}
            </span>
        </div>
    </div>

    <div class="card shadow-sm rounded-4 mb-4 border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fas fa-id-badge text-primary me-2"></i>Data Akun
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 vertical-table">
                    <tbody>
                        <tr>
                            <td class="col-label">Nama Lengkap</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $guru->user->name ?? $guru->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="col-label">NIP</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $guru->user->nip ?? $guru->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="col-label">Email</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $guru->user->email ?? $guru->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="col-label border-bottom-0">Role</td>
                            <td class="col-colon border-bottom-0">:</td>
                            <td class="col-value border-bottom-0">{{ ucfirst($guru->user->role ?? 'guru') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm rounded-4 mb-4 border-0 border-start border-4 border-info">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fas fa-user text-info me-2"></i>Data Pribadi
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 vertical-table">
                    <tbody>
                        <tr>
                            <td class="col-label">Jenis Kelamin</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $guru->jenis_kelamin ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="col-label">Tempat, Tanggal Lahir</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">
                                {{ $guru->tempat_lahir ?? '-' }},
                                {{ $guru->tanggal_lahir ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-label">Agama</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $guru->agama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="col-label border-bottom-0">No HP</td>
                            <td class="col-colon border-bottom-0">:</td>
                            <td class="col-value border-bottom-0">{{ $guru->nohp ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm rounded-4 mb-4 border-0 border-start border-4 border-secondary">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fas fa-map-marker-alt text-secondary me-2"></i>Alamat
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 vertical-table">
                    <tbody>
                        <tr>
                            <td class="col-label border-bottom-0">Alamat Lengkap</td>
                            <td class="col-colon border-bottom-0">:</td>
                            <td class="col-value border-bottom-0">{{ $guru->alamat ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm rounded-4 border-0 border-start border-4 border-warning">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fas fa-graduation-cap text-warning me-2"></i>Data Pengajaran
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 vertical-table">
                    <tbody>
                        <tr>
                            <td class="col-label">Pendidikan Terakhir</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $guru->pendidikan_terakhir ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="col-label">Jabatan</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $guru->jabatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="col-label">Mata Pelajaran</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $guru->mapel ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="col-label border-bottom-0">Status Guru</td>
                            <td class="col-colon border-bottom-0">:</td>
                            <td class="col-value border-bottom-0">{{ ucfirst($guru->status_guru ?? '-') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection