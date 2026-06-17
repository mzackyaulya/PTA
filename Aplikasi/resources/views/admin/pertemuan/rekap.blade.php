@extends('layout.main')

@section('title','Rekap Absensi')

@section('content')

<div class="container-fluid py-4">

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-0 fw-bold">Rekap Absensi Siswa</h5>
                <small class="text-muted">
                    Tahun Ajaran:
                    {{ $tahunDipilih->tahun ?? '-' }}
                    {{ $tahunDipilih && $tahunDipilih->semester ? 'Semester ' . $tahunDipilih->semester : '' }}
                </small>
            </div>

            <a href="{{ route('pertemuan.rekap.export', request()->query()) }}"
               class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i>
                Download Excel
            </a>
        </div>

        <div class="card-body">

            <form action="{{ route('pertemuan.rekap') }}" method="GET" class="mb-4">
                <div class="row align-items-end">

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" class="form-control">
                            @foreach($tahunList as $t)
                                <option value="{{ $t->id }}"
                                    {{ $tahunDipilih && $tahunDipilih->id == $t->id ? 'selected' : '' }}>
                                    {{ $t->tahun }} Semester {{ $t->semester }}
                                    {{ $t->aktif ? '- Aktif' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Kelas</label>
                        <select name="kelas_id" class="form-control">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}"
                                    {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->tingkat }} {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Mapel</label>
                        <select name="mapel_id" class="form-control">
                            <option value="">Semua Mapel</option>
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id }}"
                                    {{ request('mapel_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Tanggal Mulai</label>
                        <input type="date"
                               name="tanggal_mulai"
                               class="form-control"
                               value="{{ request('tanggal_mulai') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Tanggal Selesai</label>
                        <input type="date"
                               name="tanggal_selesai"
                               class="form-control"
                               value="{{ request('tanggal_selesai') }}">
                    </div>

                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">
                            Filter
                        </button>
                    </div>

                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th>Hadir</th>
                            <th>Izin</th>
                            <th>Sakit</th>
                            <th>Alpa</th>
                            <th>Total</th>
                            <th>Persentase Hadir</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rekap as $key => $r)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $r['siswa']->nis ?? '-' }}</td>
                                <td class="text-start">{{ $r['siswa']->user->name ?? '-' }}</td>
                                <td>
                                    {{ $r['kelas']->tingkat ?? '' }}
                                    {{ $r['kelas']->nama_kelas ?? '-' }}
                                </td>
                                <td>{{ $r['mapel']->nama ?? '-' }}</td>
                                <td>{{ $r['guru']->nama ?? $r['guru']->user->name ?? '-' }}</td>
                                <td>{{ $r['hadir'] }}</td>
                                <td>{{ $r['izin'] }}</td>
                                <td>{{ $r['sakit'] }}</td>
                                <td>{{ $r['alpa'] }}</td>
                                <td>{{ $r['total'] }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ $r['persentase'] }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-muted py-4">
                                    Belum ada data absensi pada filter ini.
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