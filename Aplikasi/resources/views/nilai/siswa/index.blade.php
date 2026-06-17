@extends('layout.main')

@section('title','Nilai Siswa')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Nilai Siswa</h4>

        <small class="text-muted">
            Tahun Ajaran:
            {{ $tahun->tahun ?? '-' }}
            {{ $tahun && $tahun->semester ? '(' . $tahun->semester . ')' : '' }}
        </small>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Mata Pelajaran</th>
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
                        $jumlahPengetahuan = 0;
                        $jumlahKeterampilan = 0;
                        $jumlahAkhir = 0;
                        $jumlahData = 0;
                    @endphp

                    @forelse($nilai as $key => $n)
                        @php
                            $jumlahPengetahuan += $n->nilai_pengetahuan ?? 0;
                            $jumlahKeterampilan += $n->nilai_keterampilan ?? 0;
                            $jumlahAkhir += $n->nilai_akhir ?? 0;
                            $jumlahData++;
                        @endphp

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="text-start">{{ $n->mapel->nama ?? '-' }}</td>
                            <td>{{ $n->kkm ?? '-' }}</td>
                            <td>{{ $n->nilai_pengetahuan ?? '-' }}</td>
                            <td>{{ $n->predikat_pengetahuan ?? '-' }}</td>
                            <td>{{ $n->nilai_keterampilan ?? '-' }}</td>
                            <td>{{ $n->predikat_keterampilan ?? '-' }}</td>
                            <td>{{ $n->nilai_akhir ?? '-' }}</td>
                            <td>{{ $n->predikat_akhir ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-muted">
                                Belum ada nilai.
                            </td>
                        </tr>
                    @endforelse

                    @if($jumlahData > 0)
                        <tr class="fw-bold">
                            <td colspan="3">Jumlah</td>
                            <td>{{ $jumlahPengetahuan }}</td>
                            <td></td>
                            <td>{{ $jumlahKeterampilan }}</td>
                            <td></td>
                            <td>{{ $jumlahAkhir }}</td>
                            <td></td>
                        </tr>

                        <tr class="fw-bold">
                            <td colspan="3">Rata-rata</td>
                            <td>{{ round($jumlahPengetahuan / $jumlahData, 2) }}</td>
                            <td></td>
                            <td>{{ round($jumlahKeterampilan / $jumlahData, 2) }}</td>
                            <td></td>
                            <td>{{ round($jumlahAkhir / $jumlahData, 2) }}</td>
                            <td></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>KKM Kelas</th>
                        <th>Kurang</th>
                        <th>Cukup</th>
                        <th>Baik</th>
                        <th>Sangat Baik</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>75</td>
                        <td>&lt; 68</td>
                        <td>68 - 75</td>
                        <td>76 - 83</td>
                        <td>84 - 100</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection