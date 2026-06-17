@extends('layout.main')

@section('title','Nilai Siswa')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4>Nilai Siswa</h4>

            <small class="text-muted">
                Nama: {{ $siswa->user->name ?? '-' }}
                |
                NIS: {{ $siswa->nis ?? '-' }}
                |
                Tahun Ajaran:
                {{ $tahun->tahun ?? '-' }}
                {{ $tahun && $tahun->semester ? '(' . $tahun->semester . ')' : '' }}
            </small>
        </div>

        <a href="{{ route('nilai.admin.kelas') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">

                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Mata Pelajaran</th>
                        <th rowspan="2">Guru</th>
                        <th rowspan="2">Kelas</th>
                        <th rowspan="2">KKM</th>
                        <th colspan="2">Pengetahuan</th>
                        <th colspan="2">Keterampilan</th>
                        <th rowspan="2">Nilai Akhir</th>
                        <th rowspan="2">Predikat</th>
                    </tr>

                    <tr>
                        <th>Nilai</th>
                        <th>Predikat</th>
                        <th>Nilai</th>
                        <th>Predikat</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $totalAkhir = 0;
                        $jumlahData = 0;
                    @endphp

                    @forelse($nilai as $key => $n)
                        @php
                            $totalAkhir += $n->nilai_akhir ?? 0;
                            $jumlahData++;
                        @endphp

                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td class="text-start">
                                {{ $n->mapel->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $n->guru->nama ?? $n->guru->user->name ?? '-' }}
                            </td>

                            <td>
                                {{ $n->kelas->tingkat ?? '-' }} {{ $n->kelas->nama_kelas ?? '' }}
                            </td>

                            <td>{{ $n->kkm ?? '-' }}</td>

                            <td>{{ $n->nilai_pengetahuan ?? '-' }}</td>
                            <td>{{ $n->predikat_pengetahuan ?? '-' }}</td>

                            <td>{{ $n->nilai_keterampilan ?? '-' }}</td>
                            <td>{{ $n->predikat_keterampilan ?? '-' }}</td>

                            <td>{{ $n->nilai_akhir ?? '-' }}</td>

                            <td>
                                <span class="badge 
                                    @if($n->predikat_akhir == 'A') bg-success
                                    @elseif($n->predikat_akhir == 'B') bg-primary
                                    @elseif($n->predikat_akhir == 'C') bg-warning text-dark
                                    @else bg-danger
                                    @endif">
                                    {{ $n->predikat_akhir ?? '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-muted py-4">
                                Belum ada nilai pada semester aktif ini.
                            </td>
                        </tr>
                    @endforelse

                    @if($jumlahData > 0)
                        <tr class="fw-bold">
                            <td colspan="9" class="text-end">
                                Rata-rata Nilai Akhir
                            </td>
                            <td colspan="2">
                                {{ round($totalAkhir / $jumlahData, 2) }}
                            </td>
                        </tr>
                    @endif
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection