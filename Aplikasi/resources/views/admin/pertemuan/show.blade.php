@extends('layout.main')

@section('title','Detail Absensi')

@section('content')

<style>
    .page-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 5px 18px rgba(0,0,0,0.08);
    }

    .info-table th {
        width: 25%;
        background: #f8f9fa;
    }

    .summary-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.07);
    }

    .summary-card h4 {
        font-weight: 700;
        margin-bottom: 2px;
    }

    .table thead th,
    .table tbody td {
        vertical-align: middle;
        text-align: center;
    }
</style>

<div class="container-fluid py-4">

    <div class="mb-3">
        <a href="{{ route('pertemuan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Informasi Pertemuan --}}
    <div class="card page-card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Pertemuan Absensi</h5>
        </div>

        <div class="card-body">
            <table class="table table-bordered info-table mb-0">
                <tr>
                    <th>Mata Pelajaran</th>
                    <td>{{ $pertemuan->mengajar->mapel->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $pertemuan->mengajar->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Guru</th>
                    <td>{{ $pertemuan->mengajar->guru->nama ?? $pertemuan->mengajar->guru->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Pertemuan</th>
                    <td>Pertemuan {{ $pertemuan->pertemuan_ke ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Hari / Tanggal</th>
                    <td>
                        {{ $pertemuan->mengajar->hari ?? '-' }},
                        {{ $pertemuan->tanggal ? \Carbon\Carbon::parse($pertemuan->tanggal)->format('d-m-Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <th>Jam</th>
                    <td>
                        {{ $pertemuan->mengajar->jam_mulai ?? '-' }} -
                        {{ $pertemuan->mengajar->jam_selesai ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if(!$pertemuan->is_approved)
                            <span class="badge bg-warning text-dark">Belum Disetujui</span>
                        @elseif($pertemuan->is_approved && !$pertemuan->is_started)
                            <span class="badge bg-secondary">Siap</span>
                        @elseif($pertemuan->is_started && !$pertemuan->is_saved && !$pertemuan->is_closed)
                            <span class="badge bg-success">Berlangsung</span>
                        @elseif($pertemuan->is_saved && !$pertemuan->is_closed)
                            <span class="badge bg-primary">Disimpan</span>
                        @elseif($pertemuan->is_closed)
                            <span class="badge bg-danger">Selesai</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Rekap Absensi --}}
    @php
        $hadir = $absensi->where('status', 'hadir')->count();
        $izin = $absensi->where('status', 'izin')->count();
        $sakit = $absensi->where('status', 'sakit')->count();
        $alpa = $absensi->where('status', 'alpa')->count();
        $belumAbsen = $siswa->count() - $absensi->count();
    @endphp

    <div class="row mb-4">
        <div class="col-md-2 mb-3">
            <div class="card summary-card text-center">
                <div class="card-body">
                    <h4 class="text-success">{{ $hadir }}</h4>
                    <small>Hadir</small>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-3">
            <div class="card summary-card text-center">
                <div class="card-body">
                    <h4 class="text-warning">{{ $izin }}</h4>
                    <small>Izin</small>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-3">
            <div class="card summary-card text-center">
                <div class="card-body">
                    <h4 class="text-info">{{ $sakit }}</h4>
                    <small>Sakit</small>
                </div>
            </div>
        </div>

        <div class="col-md-2 mb-3">
            <div class="card summary-card text-center">
                <div class="card-body">
                    <h4 class="text-danger">{{ $alpa }}</h4>
                    <small>Alpa</small>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card summary-card text-center">
                <div class="card-body">
                    <h4 class="text-secondary">{{ $belumAbsen < 0 ? 0 : $belumAbsen }}</h4>
                    <small>Belum Absen</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Absensi Siswa --}}
    <div class="card page-card">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold">Daftar Absensi Siswa</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($siswa as $key => $s)
                            @php
                                $dataAbsen = $absensi->where('siswa_id', $s->id)->first();
                            @endphp

                            <tr>
                                <td>{{ $key + 1 }}</td>

                                <td>
                                    {{ $s->user->nisn ?? '-' }}
                                </td>

                                <td class="text-start">
                                    {{ $s->user->name ?? $s->nama ?? '-' }}
                                </td>

                                <td>
                                    @if(!$dataAbsen)
                                        <span class="badge bg-secondary">Belum Absen</span>
                                    @elseif($dataAbsen->status == 'hadir')
                                        <span class="badge bg-success">Hadir</span>
                                    @elseif($dataAbsen->status == 'izin')
                                        <span class="badge bg-warning text-dark">Izin</span>
                                    @elseif($dataAbsen->status == 'sakit')
                                        <span class="badge bg-info">Sakit</span>
                                    @elseif($dataAbsen->status == 'alpa')
                                        <span class="badge bg-danger">Alpa</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $dataAbsen->keterangan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Tidak ada data siswa pada kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

@endsection