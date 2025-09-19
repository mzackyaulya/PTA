@extends('layout.main')

@section('title', 'Profil Siswa')

@section('content')
<div class="container-fluid py-4">

    <h5 id="greeting" class="fw-bold text-dark px-2 mb-4"></h5>

    <div class="card shadow-sm rounded-4 mb-4">
        <div class="card-body d-flex align-items-center">
            <img src="{{ optional($user->siswa)->foto ? asset('storage/'.$user->siswa->foto) : asset('assets/img/admin.png') }}"
                class="rounded-circle border shadow-sm" width="120" height="120" alt="Foto Profil">
            <div class="ms-4">
                <h4 class="fw-bold mb-0">{{ strtoupper($user->name) }}</h4>
                <p class="text-muted mb-1">{{ $user->nisn ?? $user->nip }}</p>
                <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
            </div>
        </div>
    </div>

    <div class="card shadow-sm rounded-4 mb-4">
        <div class="card-body">
            <h5 class="fw-bold text-dark">Data Pribadi</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->name }}</td>
                            <td><strong>Nama Ayah</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->nama_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->email }}</td>
                            <td><strong>Tanggal Lahir Ayah</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->tanggal_lahir_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->jenis_kelamin ?? '-' }}</td>
                            <td><strong>NIK Ayah</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->nik_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tempat, Tanggal Lahir</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->tempat_lahir ?? '-' }}, {{ $user->siswa->tanggal_lahir ?? '-' }}</td>
                            <td><strong>Pendidikan Ayah</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->pendidikan_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kewarganegaraan</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->kewarganegaraan ?? '-' }}</td>
                            <td><strong>Pekerjaan Ayah</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->pekerjaan_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Agama</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->agama ?? '-' }}</td>
                            <td><strong>Nama Ibu</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->nama_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->alamat ?? '-' }}</td>
                            <td><strong>Tanggal Lahir Ibu</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->tanggal_lahir_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>No HP</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->nohp ?? '-' }}</td>
                            <td><strong>NIK Ibu</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->nik_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kelas</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->kelas ?? '-' }}</td>
                            <td><strong>Pendidikan Ibu</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->pendidikan_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jurusan</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->jurusan ?? '-' }}</td>
                            <td><strong>Pekerjaan Ibu</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->pekerjaan_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tahun Masuk</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->tahun_masuk ?? '-' }}</td>
                            <td><strong>Status</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->status_siswa ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kode Pos</strong></td>
                            <td class="colon">:</td>
                            <td>{{ $user->siswa->kode_pos ?? '-' }}</td>
                            <td><strong>RT/RW</strong></td>
                            <td class="colon">:</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <h5 class="fw-bold text-dark">Riwayat Penerimaan Beasiswa</h5>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>2024/2025 Ganjil</td>
                        <td>Beasiswa KIP Kuliah</td>
                    </tr>
                    <tr>
                        <td>2023/2024 Genap</td>
                        <td>Beasiswa KIP Kuliah</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    td.colon {
        width: 15px;
        text-align: center;
        padding: 0 4px;
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
        border: 4px solid #0d6efd; /* outline biru tebal */
        padding: 3px; /* jarak kecil biar border terlihat */
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
