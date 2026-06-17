@extends('layout.main')

@section('title', 'Profil Siswa')

@section('content')
    <div class="container-fluid py-4">

        <h5 id="greeting" class="fw-bold text-dark px-2 mb-4"></h5>

        <div class="card shadow-sm rounded-4 mb-4 border-0">
            <div class="card-body d-flex align-items-center p-4">
                <img src="{{ optional($user->siswa)->foto ? asset('storage/' . $user->siswa->foto) : asset('assets/img/admin.png') }}"
                    class="rounded-circle border shadow-sm profile-photo" width="120" height="120" alt="Foto Profil"
                    style="object-fit: cover;">
                <div class="ms-4">
                    <h4 class="fw-bold mb-1 text-dark">{{ strtoupper($user->name) }}</h4>
                    <p class="text-secondary mb-2 fs-5"><i class="fas fa-id-card me-2"></i>{{ $user->nisn ?? $user->nip }}
                    </p>
                    <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">{{ ucfirst($user->role) }}</span>
                </div>
            </div>
        </div>

        <div class="card shadow-sm rounded-4 mb-4 border-0">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user text-primary me-2"></i>Data Pribadi</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0 vertical-table">
                        <tbody>
                            <tr>
                                <td class="col-label">Nama</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Email</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Jenis Kelamin</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->jenis_kelamin ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tempat, Tanggal Lahir</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->tempat_lahir ?? '-' }},
                                    {{ $user->siswa->tanggal_lahir ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Kewarganegaraan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->kewarganegaraan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Agama</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->agama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Alamat Lengkap</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">RT / RW</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->rt ?? '-' }} / {{ $user->siswa->rw ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Kode Pos</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->kodepos ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">No HP</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->nohp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Kelas</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->kelasAktif->kelas->tingkat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Jurusan</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->jurusan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tahun Masuk</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->tahun_masuk ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Status Siswa</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">
                                    <span
                                        class="badge {{ $user->siswa->status_siswa == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $user->siswa->status_siswa ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm rounded-4 mb-4 border-0">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-users text-primary me-2"></i>Data Orang Tua / Wali</h5>
            </div>
            <div class="card-body p-4">

                <h6 class="fw-bold text-secondary mb-3 border-start border-4 border-primary ps-2">Data Ayah</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-hover align-middle mb-0 vertical-table">
                        <tbody>
                            <tr>
                                <td class="col-label">Nama Ayah</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->nama_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tanggal Lahir Ayah</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->tanggal_lahir_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">NIK Ayah</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->nik_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Pendidikan Ayah</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->pendidikan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Pekerjaan Ayah</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->pekerjaan_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Penghasilan Ayah</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">
                                    Rp. {{ $user->siswa->penghasilan_ayah ? : '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-secondary mb-3 border-start border-4 border-danger ps-2">Data Ibu</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-hover align-middle mb-0 vertical-table">
                        <tbody>
                            <tr>
                                <td class="col-label">Nama Ibu</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->nama_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tanggal Lahir Ibu</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->tanggal_lahir_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">NIK Ibu</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->nik_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Pendidikan Ibu</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->pendidikan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Pekerjaan Ibu</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->pekerjaan_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Penghasilan Ibu</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">
                                    Rp. {{ $user->siswa->penghasilan_ibu ? : '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-secondary mb-3 border-start border-4 border-success ps-2">Data Wali</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0 vertical-table">
                        <tbody>
                            <tr>
                                <td class="col-label">Nama Wali</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->nama_wali ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Tanggal Lahir Wali</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->tanggal_lahir_wali ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">NIK Wali</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->nik_wali ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Pendidikan Wali</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->pendidikan_wali ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-label">Pekerjaan Wali</td>
                                <td class="col-colon">:</td>
                                <td class="col-value">{{ $user->siswa->pekerjaan_wali ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
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

        .profile-photo {
            border: 4px solid #e9ecef !important;
            padding: 4px;
            transition: 0.3s ease;
        }

        .profile-photo:hover {
            border-color: #0d6efd !important;
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
