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
                        <th rowspan="2">KKM</th>
                        <th rowspan="2">JB (B)</th>
                        <th colspan="2">Pengetahuan</th>
                        <th colspan="2">Keterampilan</th>
                        <th rowspan="2">Rata - Rata (N)</th>
                        <th rowspan="2">N x B</th>
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
                        $totalJB = 0;
                        $jumlahData = 0;

                        // Variabel untuk menampung total nilai murni (untuk baris Jumlah)
                        $totalNilaiP = 0;
                        $totalNilaiK = 0;
                        $totalNilaiRataMurni = 0;

                        // Variabel untuk menampung total akumulasi N x B
                        $totalNxB = 0;
                    @endphp

                    @forelse($nilai as $key => $n)
                        @php
                            $jb = $n->mapel->jb ?? 0;
                            $totalJB += $jb;
                            $jumlahData++;

                            $nP = $n->nilai_pengetahuan ?? 0;
                            $nK = $n->nilai_keterampilan ?? 0;
                            
                            // N (Rata-Rata) diperoleh dari rata-rata pengetahuan dan keterampilan
                            $nilaiRataN = ($nP + $nK) / 2;

                            // Hitung N x B untuk baris ini
                            $nxBRow = $nilaiRataN * $jb;

                            // Akumulasi data untuk summary bawah
                            $totalNilaiP += $nP;
                            $totalNilaiK += $nK;
                            $totalNilaiRataMurni += $nilaiRataN;
                            $totalNxB += $nxBRow;
                        @endphp

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="text-start">{{ $n->mapel->nama ?? '-' }}</td> 
                            <td>{{ $n->kkm ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $jb }}</span></td>
                            <td>{{ $nP > 0 ? $nP : '-' }}</td>
                            <td>{{ $n->predikat_pengetahuan ?? '-' }}</td>
                            <td>{{ $nK > 0 ? $nK : '-' }}</td>
                            <td>{{ $n->predikat_keterampilan ?? '-' }}</td>
                            <td class="fw-semibold">{{ round($nilaiRataN, 2) }}</td>
                            <td class="fw-bold">{{ round($nxBRow, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-muted">Belum ada nilai.</td>
                        </tr>
                    @endforelse

                    @if($jumlahData > 0)
                        <tr class="fw-bold bg-light">
                            <td colspan="3" class="text-center">Jumlah</td> <td>{{ $totalJB }}</td>
                            <td>{{ $totalNilaiP }}</td>
                            <td></td>
                            <td>{{ $totalNilaiK }}</td>
                            <td></td>
                            <td>{{ round($totalNilaiRataMurni, 2) }}</td>
                            <td>{{ round($totalNxB, 2) }}</td>
                        </tr>

                        <tr class="fw-bold table-light text-dark">
                            <td colspan="3" class="text-center">Jumlah Rata - Rata</td>
                            <td colspan="7" class="fs-5">{{ $totalJB > 0 ? round($totalNxB / $totalJB, 2) : 0 }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection