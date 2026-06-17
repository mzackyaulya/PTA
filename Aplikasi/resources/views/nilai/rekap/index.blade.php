@extends('layout.main')

@section('title','Rekap Nilai Siswa')

@section('content')

<style>
    .page-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 5px 18px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .table-rekap thead th {
        background: #f8fafc;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
        vertical-align: middle;
        text-align: center;
        white-space: nowrap;
        padding: 14px 10px;
    }

    .table-rekap tbody td {
        vertical-align: middle;
        padding: 13px 10px;
        font-size: 14px;
    }

    .filter-box {
        background: #f8fafc;
        border: 1px solid #edf1f5;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 22px;
    }

    .badge-predikat {
        min-width: 45px;
        padding: 7px 10px;
        border-radius: 20px;
    }
</style>

<div class="container-fluid py-4">

    <div class="card page-card">

        <div class="card-header bg-white d-flex justify-content-between align-items-center py-4 px-4">
            <div>
                <h5 class="mb-0 fw-bold">Rekap Nilai Siswa</h5>
                <small class="text-muted">
                    Tahun Ajaran:
                    {{ $tahun->tahun ?? '-' }}
                    {{ $tahun && $tahun->semester ? 'Semester ' . $tahun->semester : '' }}
                </small>
            </div>

            <a href="{{ route('nilai.rekap.export', request()->query()) }}"
               class="btn btn-success px-4">
                <i class="fas fa-file-excel me-1"></i>
                Download Excel
            </a>
        </div>

        <div class="card-body px-4 py-4">

            <div class="filter-box">
                <form action="{{ route('nilai.rekap') }}" method="GET">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Pilih Tahun Ajaran</label>
                            <select name="tahun_ajaran_id" class="form-control">
                                @foreach($tahunList as $t)
                                    <option value="{{ $t->id }}"
                                        {{ $tahun && $tahun->id == $t->id ? 'selected' : '' }}>
                                        {{ $t->tahun }} Semester {{ $t->semester }}
                                        {{ $t->aktif ? '- Aktif' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                Tampilkan
                            </button>

                            <a href="{{ route('nilai.rekap') }}" class="btn btn-secondary px-4">
                                Tahun Aktif
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle table-rekap">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jumlah Mapel</th>
                            <th>Rata Pengetahuan</th>
                            <th>Rata Keterampilan</th>
                            <th>Rata Akhir</th>
                            <th>Predikat</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rekap as $key => $r)
                            <tr>
                                <td>{{ $key + 1 }}</td>

                                <td>{{ $r['siswa']->nis ?? '-' }}</td>

                                <td class="text-start">
                                    {{ $r['siswa']->user->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $r['kelas']->tingkat ?? '' }}
                                    {{ $r['kelas']->nama_kelas ?? '-' }}
                                </td>

                                <td>{{ $r['jumlah_mapel'] }}</td>

                                <td>{{ $r['rata_pengetahuan'] ?? '-' }}</td>

                                <td>{{ $r['rata_keterampilan'] ?? '-' }}</td>

                                <td>{{ $r['rata_akhir'] ?? '-' }}</td>

                                <td>
                                    @if($r['predikat'])
                                        <span class="badge badge-predikat
                                            @if($r['predikat'] == 'A') bg-success
                                            @elseif($r['predikat'] == 'B') bg-primary
                                            @elseif($r['predikat'] == 'C') bg-warning text-dark
                                            @else bg-danger
                                            @endif">
                                            {{ $r['predikat'] }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    @if($r['siswa'])
                                        <a href="{{ route('nilai.rekap.siswa', [
                                                'siswa' => $r['siswa']->id,
                                                'tahun_ajaran_id' => $tahun->id ?? null
                                            ]) }}"
                                           class="btn btn-info btn-sm text-white">
                                            Detail Nilai
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-muted py-4">
                                    Belum ada data siswa pada tahun ajaran ini.
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