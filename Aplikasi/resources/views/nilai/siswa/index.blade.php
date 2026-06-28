@extends('layout.main')

@section('title','Nilai Siswa')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white py-4 px-4">
            <h5 class="mb-0 fw-bold">Nilai Siswa</h5>
            <small class="text-muted d-block mt-1">
                Tahun Ajaran: {{ $tahun->tahun ?? '-' }} {{ $tahun && $tahun->semester ? '(' . $tahun->semester . ')' : '' }}
            </small>
        </div>

        <div class="card-body px-4 py-4">

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle m-0">
                    <thead class="table-success fw-bold text-uppercase fs-7" style="background-color: #6c6ff5;">
                        <tr>
                            <th rowspan="2" class="align-middle" style="width: 5%;">NO</th>
                            <th rowspan="2" class="align-middle" style="width: 25%;">MATA PELAJARAN</th>
                            <th rowspan="2" class="align-middle" style="width: 8%;">KKM</th>
                            <th rowspan="2" class="align-middle" style="width: 8%;">JB (B)</th>
                            <th colspan="2" style="width: 18%;">PENGETAHUAN</th>
                            <th colspan="2" style="width: 18%;">KETERAMPILAN</th>
                            <th rowspan="2" class="align-middle" style="width: 10%;">RATA - RATA (N)</th>
                            <th rowspan="2" class="align-middle" style="width: 10%; ">N X B</th>
                        </tr>
                        <tr>
                            <th>NILAI</th>
                            <th>PREDIKAT</th>
                            <th>NILAI</th>
                            <th>PREDIKAT</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $totalJB = 0;
                            $totalPengetahuan = 0;
                            $totalKeterampilan = 0;
                            $totalRataRataN = 0;
                            $totalNxB = 0;
                            $jumlahData = 0;
                        @endphp

                        @forelse($nilai as $key => $n)
                            @php
                                $jumlahData++;
                                $jb = $n->mapel->jb ?? $n->jb ?? 0;
                                $nilaiP = $n->nilai_pengetahuan ?? 0;
                                $nilaiK = $n->nilai_keterampilan ?? 0;
                                
                                $rataRataN = ($nilaiP + $nilaiK) / 2;
                                $nxB = $rataRataN * $jb;

                                $totalJB += $jb;
                                $totalPengetahuan += $nilaiP;
                                $totalKeterampilan += $nilaiK;
                                $totalRataRataN += $rataRataN;
                                $totalNxB += $nxB;
                            @endphp

                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="text-start px-3">{{ $n->mapel->nama ?? '-' }}</td>
                                <td>{{ $n->kkm ?? '75' }}</td>
                                <td>{{ $jb }}</td>
                                <td>{{ $nilaiP + 0 }}</td>
                                <td>{{ $n->predikat_pengetahuan ?? '-' }}</td>
                                <td>{{ $nilaiK + 0 }}</td>
                                <td>{{ $n->predikat_keterampilan ?? '-' }}</td>
                                <td class="fw-bold">{{ $rataRataN + 0 }}</td>
                                <td class="fw-bold">{{ $nxB + 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-muted py-4">Belum ada data nilai pada semester ini.</td>
                            </tr>
                        @endforelse

                        @if($jumlahData > 0)
                            <tr class="fw-bold" style="background-color: #f8f9fa;">
                                <td colspan="3" class="text-center">Jumlah</td>
                                <td>{{ $totalJB }}</td>
                                <td>{{ $totalPengetahuan + 0 }}</td>
                                <td></td>
                                <td>{{ $totalKeterampilan + 0 }}</td>
                                <td></td>
                                <td>{{ $totalRataRataN + 0 }}</td>
                                <td>{{ $totalNxB + 0 }}</td>
                            </tr>

                            <tr class="fw-bold" style="background-color: #cfe2ff;">
                                <td colspan="3" class="text-center">Jumlah Rata - Rata</td>
                                <td colspan="7" class="text-center fs-6">
                                    {{ round($totalNxB / $totalJB, 2) + 0 }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="table-responsive mt-5" style="max-width: 600px;">
                <table class="table table-bordered text-center align-middle m-0">
                    <thead class="table-success fw-bold small text-uppercase">
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
</div>

@endsection