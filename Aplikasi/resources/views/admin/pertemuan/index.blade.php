@extends('layout.main')

@section('title','Manajemen Pertemuan Absensi')

@section('content')

<style>
    .page-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 5px 18px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .page-header-title {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
    }

    .page-header-subtitle {
        font-size: 13px;
        color: #6b7280;
        line-height: 1.7;
    }

    .filter-box {
        background: #f8fafc;
        border: 1px solid #edf1f5;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 22px;
    }

    .table-absensi {
        border-color: #e5e7eb;
        margin-bottom: 0;
    }

    .table-absensi thead th {
        background: #f8fafc;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: #111827;
        padding: 14px 10px;
        vertical-align: middle;
        text-align: center;
        white-space: nowrap;
    }

    .table-absensi tbody td {
        padding: 14px 10px;
        vertical-align: middle;
        font-size: 14px;
        color: #111827;
    }

    .table-absensi tbody tr:hover {
        background: #f9fafb;
    }

    .badge-status {
        min-width: 120px;
        padding: 8px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-action {
        min-width: 110px;
        margin-bottom: 6px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 10px;
    }

    .mapel-text {
        font-weight: 600;
        line-height: 1.4;
    }

    .kelas-text,
    .guru-text,
    .jam-text {
        font-weight: 500;
        line-height: 1.4;
    }

    .empty-row {
        padding: 28px !important;
        font-size: 14px;
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 12px;
        }

        .card-header .btn {
            width: 100%;
        }

        .filter-box .row > div {
            margin-bottom: 12px;
        }

        .table-absensi thead th,
        .table-absensi tbody td {
            font-size: 12px;
            padding: 10px 8px;
        }

        .btn-action {
            min-width: 95px;
            font-size: 11px;
            padding: 7px 8px;
        }
    }
</style>

<div class="container-fluid py-4">

    <div class="card page-card">

        <div class="card-header bg-white d-flex justify-content-between align-items-center py-4 px-4">
            <div>
                <div class="page-header-title">Manajemen Pertemuan Absensi</div>

                <div class="page-header-subtitle mt-1">
                    Hari: {{ $hariIni ?? '-' }} |
                    Tanggal: {{ isset($tanggalHariIni) ? \Carbon\Carbon::parse($tanggalHariIni)->format('d-m-Y') : '-' }}
                    <br>
                    Tahun Ajaran:
                    {{ $tahunAktif->tahun ?? '-' }}
                    {{ $tahunAktif && $tahunAktif->semester ? 'Semester ' . $tahunAktif->semester : '' }}
                </div>
            </div>

            <a href="{{ route('pertemuan.rekap') }}" class="btn btn-success px-4 py-2">
                <i class="fas fa-file-excel me-1"></i>
                Rekap Absensi
            </a>
        </div>

        <div class="card-body px-4 py-4">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filter Tanggal --}}
            <div class="filter-box">
                <form action="{{ route('pertemuan.index') }}" method="GET">
                    <div class="row align-items-end">

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Pilih Tanggal Pertemuan</label>
                            <input type="date"
                                   name="tanggal"
                                   class="form-control"
                                   value="{{ $tanggalHariIni ?? date('Y-m-d') }}">
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                Tampilkan
                            </button>

                            <a href="{{ route('pertemuan.index') }}" class="btn btn-secondary px-4">
                                Hari Ini
                            </a>
                        </div>

                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle table-absensi">

                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="18%">Mata Pelajaran</th>
                            <th width="10%">Kelas</th>
                            <th width="14%">Guru</th>
                            <th width="12%">Pertemuan</th>
                            <th width="9%">Hari</th>
                            <th width="11%">Tanggal</th>
                            <th width="10%">Jam</th>
                            <th width="13%">Status</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pertemuan as $key => $p)
                            <tr>
                                <td class="text-center">
                                    {{ $key + 1 }}
                                </td>

                                <td class="text-center">
                                    <div class="mapel-text">
                                        {{ $p->mengajar->mapel->nama ?? '-' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="kelas-text">
                                        {{ $p->mengajar->kelas->tingkat ?? '' }}
                                        {{ $p->mengajar->kelas->nama_kelas ?? '-' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="guru-text">
                                        {{ $p->mengajar->guru->nama ?? $p->mengajar->guru->user->name ?? '-' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    Pertemuan {{ $p->pertemuan_ke ?? '-' }}
                                </td>

                                <td class="text-center">
                                    {{ $p->mengajar->hari ?? '-' }}
                                </td>

                                <td class="text-center">
                                    {{ $p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') : '-' }}
                                </td>

                                <td class="text-center">
                                    <div class="jam-text">
                                        {{ $p->mengajar && $p->mengajar->jam_mulai ? substr($p->mengajar->jam_mulai, 0, 5) : '-' }}
                                        -
                                        {{ $p->mengajar && $p->mengajar->jam_selesai ? substr($p->mengajar->jam_selesai, 0, 5) : '-' }}
                                    </div>
                                </td>

                                <td class="text-center">
                                    @if(!$p->is_approved)
                                        <span class="badge bg-warning text-dark badge-status">
                                            Belum Disetujui
                                        </span>
                                    @elseif($p->is_approved && !$p->is_started)
                                        <span class="badge bg-secondary badge-status">
                                            Siap
                                        </span>
                                    @elseif($p->is_started && !$p->is_saved && !$p->is_closed)
                                        <span class="badge bg-success badge-status">
                                            Berlangsung
                                        </span>
                                    @elseif($p->is_saved && !$p->is_closed)
                                        <span class="badge bg-primary badge-status">
                                            Disimpan
                                        </span>
                                    @elseif($p->is_closed)
                                        <span class="badge bg-danger badge-status">
                                            Selesai
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if(!$p->is_approved)
                                        <a href="{{ route('pertemuan.approve', $p->id) }}"
                                           class="btn btn-success btn-sm btn-action">
                                            Buka Absen
                                        </a>
                                    @endif

                                    <a href="{{ route('pertemuan.show', $p->id) }}"
                                       class="btn btn-info btn-sm text-white btn-action">
                                        Lihat Absensi
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center empty-row">
                                    Tidak ada jadwal mengajar pada tanggal ini.
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