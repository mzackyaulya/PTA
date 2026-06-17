@extends('layout.main')

@section('title', 'Profil Guru')

@section('content')

<div class="container-fluid py-4">

    <h5 id="greeting" class="fw-bold text-dark px-2 mb-4"></h5>

    {{-- HEADER PROFIL --}}
    <div class="card shadow-sm rounded-4 mb-4 border-0">
        <div class="card-body d-flex align-items-center p-4">

            <img src="{{ $user->guru && $user->guru->foto ? asset('storage/' . $user->guru->foto) : asset('assets/img/admin.png') }}"
                 class="rounded-circle border shadow-sm profile-photo"
                 width="120"
                 height="120"
                 alt="Foto Guru"
                 style="object-fit: cover;">

            <div class="ms-4">
                <h4 class="fw-bold mb-1 text-dark">
                    {{ strtoupper($user->guru->nama ?? $user->name ?? '-') }}
                </h4>

                <p class="text-secondary mb-1 fs-6">
                    <i class="fas fa-id-card me-2"></i>
                    {{ $user->guru->nip ?? $user->nip ?? '-' }}
                </p>

                <p class="text-secondary mb-2 fs-6">
                    <i class="fas fa-envelope me-2"></i>
                    {{ $user->email ?? $user->guru->email ?? '-' }}
                </p>

                <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">
                    {{ ucfirst($user->role ?? 'guru') }}
                </span>

                <span class="badge 
                    @if(($user->guru->status_guru ?? '') == 'aktif') bg-success
                    @elseif(($user->guru->status_guru ?? '') == 'pensiun') bg-warning text-dark
                    @else bg-secondary
                    @endif
                    px-3 py-2 rounded-pill shadow-sm ms-2">
                    {{ ucfirst($user->guru->status_guru ?? '-') }}
                </span>
            </div>

        </div>
    </div>

    {{-- DATA AKUN --}}
    <div class="card shadow-sm rounded-4 mb-4 border-0">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fas fa-user-lock text-primary me-2"></i>Data Akun
            </h5>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 vertical-table">
                    <tbody>
                        <tr>
                            <td class="col-label">NIP</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->nip ?? $user->nip ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">Nama Lengkap</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->nama ?? $user->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">Email</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->email ?? $user->guru->email ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">Role</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ ucfirst($user->role ?? 'guru') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- DATA IDENTITAS GURU --}}
    <div class="card shadow-sm rounded-4 mb-4 border-0">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fas fa-id-badge text-info me-2"></i>Data Identitas Guru
            </h5>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 vertical-table">
                    <tbody>
                        <tr>
                            <td class="col-label">NIK</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->nik ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">NUPTK</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->nuptk ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">Jenis Kelamin</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->jenis_kelamin ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">Tempat, Tanggal Lahir</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">
                                {{ $user->guru->tempat_lahir ?? '-' }},
                                {{ $user->guru->tanggal_lahir ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="col-label">Agama</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->agama ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">Alamat</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->alamat ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">No HP</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->nohp ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- DATA PENDIDIKAN --}}
    <div class="card shadow-sm rounded-4 mb-4 border-0">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fas fa-graduation-cap text-success me-2"></i>Data Pendidikan
            </h5>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 vertical-table">
                    <tbody>
                        <tr>
                            <td class="col-label">Pendidikan Terakhir</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->pendidikan_terakhir ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">Universitas</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->universitas ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">Tahun Lulus</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->tahun_lulus ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">Bidang Keahlian</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->bidang_keahlian ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- DATA KEPEGAWAIAN --}}
    <div class="card shadow-sm rounded-4 mb-4 border-0">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fas fa-briefcase text-warning me-2"></i>Data Kepegawaian
            </h5>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 vertical-table">
                    <tbody>
                        <tr>
                            <td class="col-label">Status Kepegawaian</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->status_kepegawaian ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">Tanggal Masuk</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->tanggal_masuk ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">Mata Pelajaran</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">{{ $user->guru->mapel ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td class="col-label">Sebagai Wali Kelas</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">
                                @if(($user->guru->is_wali_kelas ?? false) == true)
                                    <span class="badge bg-success">Ya</span>
                                @else
                                    <span class="badge bg-secondary">Tidak</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td class="col-label">Status Guru</td>
                            <td class="col-colon">:</td>
                            <td class="col-value">
                                <span class="badge 
                                    @if(($user->guru->status_guru ?? '') == 'aktif') bg-success
                                    @elseif(($user->guru->status_guru ?? '') == 'pensiun') bg-warning text-dark
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($user->guru->status_guru ?? '-') }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- FOTO DAN DOKUMEN --}}
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fas fa-file-alt text-danger me-2"></i>Foto dan Dokumen
            </h5>
        </div>

        <div class="card-body p-4">

            <div class="row g-3">

                @php
                    $dokumen = [
                        'Dokumen KTP' => $user->guru->dokumen_ktp ?? null,
                        'Dokumen Ijazah' => $user->guru->dokumen_ijazah ?? null,
                        'Dokumen Sertifikat' => $user->guru->dokumen_sertifikat ?? null,
                        'Dokumen SK' => $user->guru->dokumen_sk ?? null,
                    ];
                @endphp

                @foreach($dokumen as $nama => $file)
                    <div class="col-md-3 col-sm-6">
                        <div class="border rounded-4 p-3 h-100 text-center bg-light">
                            <i class="fas fa-file-alt text-danger mb-2" style="font-size: 32px;"></i>

                            <h6 class="fw-bold mb-3">{{ $nama }}</h6>

                            @if($file)
                                <a href="{{ asset('storage/' . $file) }}"
                                   class="btn btn-sm btn-primary"
                                   download>
                                    <i class="fas fa-download me-1"></i>
                                    Download
                                </a>
                            @else
                                <span class="badge bg-secondary">Belum Ada</span>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>

</div>

<style>
    .vertical-table {
        table-layout: fixed;
        width: 100%;
    }

    .vertical-table td {
        padding: 0.8rem 1rem;
    }

    .col-label {
        width: 25%;
        font-weight: 600;
        color: #495057;
        background-color: #f8f9fa !important;
    }

    .col-colon {
        width: 5%;
        text-align: center;
        font-weight: bold;
    }

    .col-value {
        width: 72%;
        color: #212529;
    }

    .profile-photo {
        border: 4px solid #e9ecef !important;
        padding: 4px;
        transition: 0.3s ease;
    }

    .profile-photo:hover {
        border-color: #0d6efd !important;
    }

    .greet-word {
        font-family: 'Playfair Display', serif !important;
        font-size: 1.8rem;
        color: #0d6efd;
    }

    .greet-icon {
        margin: 0 6px;
        color: #ffc107;
        font-size: 1.6rem;
        vertical-align: middle;
        line-height: 1;
        position: relative;
        top: -3px;
    }

    .greet-name {
        font-family: 'Poppins', sans-serif !important;
        font-size: 1.8rem;
        font-weight: 600;
        color: #212529;
    }

    @media (max-width: 768px) {
        .card-body.d-flex {
            flex-direction: column;
            text-align: center;
        }

        .card-body.d-flex .ms-4 {
            margin-left: 0 !important;
            margin-top: 1rem;
        }

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
            font-size: 13px;
            padding: 0.7rem 0.5rem;
        }
    }
</style>

<script>
    const userName = "{{ $user->name }}";

    const greetings = [
        `<span class="greet-word">Hello</span> <i class="fas fa-hand-peace greet-icon"></i> <span class="greet-name">${userName}</span>`,
        `<span class="greet-word">Halo</span> <i class="fas fa-smile-beam greet-icon"></i> <span class="greet-name">${userName}</span>`,
        `<span class="greet-word">こんにちは</span> <i class="fas fa-sun greet-icon"></i> <span class="greet-name">${userName}</span>`,
        `<span class="greet-word">Bonjour</span> <i class="fas fa-coffee greet-icon"></i> <span class="greet-name">${userName}</span>`,
        `<span class="greet-word">Hola</span> <i class="fas fa-heart greet-icon"></i> <span class="greet-name">${userName}</span>`,
        `<span class="greet-word">مرحبا</span> <i class="fas fa-moon greet-icon"></i> <span class="greet-name">${userName}</span>`
    ];

    let index = 0;

    function changeGreeting() {
        document.getElementById("greeting").innerHTML = greetings[index];
        index = (index + 1) % greetings.length;
    }

    changeGreeting();
    setInterval(changeGreeting, 3000);
</script>

@endsection