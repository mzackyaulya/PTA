@extends('layout.main')

@section('title','Rekap Nilai Persiswa')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white d-flex justify-content-between align-items-center py-4 px-4">
            <div>
                <h5 class="mb-0 fw-bold">Rekap Nilai Persiswa</h5>
                <small class="text-muted d-block mt-1">
                    Nama: {{ $siswa->user->name ?? '-' }} | NIS: {{ $siswa->nis ?? '-' }} | Tahun Ajaran: {{ $tahun->tahun ?? '-' }} ({{ $tahun->semester ?? '-' }})
                </small>
            </div>

            <div>
                <a href="{{ route('nilai.rekap', ['tahun_ajaran_id' => $tahun->id ?? null]) }}" class="btn btn-secondary btn-sm px-3">
                    Kembali
                </a>

                <a href="{{ route('nilai.rekap.siswa.export', ['siswa' => $siswa->id, 'tahun_ajaran_id' => $tahun->id ?? null]) }}" class="btn btn-success btn-sm px-3">
                    <i class="fas fa-file-excel me-1"></i> Download Excel
                </a>
            </div>
        </div>

        <div class="card-body px-4 py-4">

            <form action="{{ route('nilai.rekap.siswa', $siswa->id) }}" method="GET" class="mb-4">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small text-muted">Pilih Tahun Ajaran</label>
                        <select name="tahun_ajaran_id" class="form-select form-select-sm">
                            @foreach($tahunList as $t)
                                <option value="{{ $t->id }}" {{ $tahun && $tahun->id == $t->id ? 'selected' : '' }}>
                                    {{ $t->tahun }} Semester {{ $t->semester }} {{ $t->aktif ? '- Aktif' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary px-3">Tampilkan</button>
                        <a href="{{ route('nilai.rekap.siswa', $siswa->id) }}" class="btn btn-sm btn-secondary px-3">Tahun Aktif</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle m-0">
                    <thead class="table-light fw-bold text-uppercase fs-7" style="background-color: #f8f9fa;">
                        <tr>
                            <th rowspan="2" class="align-middle" style="width: 5%;">NO</th>
                            <th rowspan="2" class="align-middle" style="width: 25%;">MATA PELAJARAN</th>
                            <th rowspan="2" class="align-middle" style="width: 8%;">KKM</th>
                            <th rowspan="2" class="align-middle" style="width: 8%;">JB (B)</th>
                            <th colspan="2" style="width: 18%;">PENGETAHUAN</th>
                            <th colspan="2" style="width: 18%;">KETERAMPILAN</th>
                            <th rowspan="2" class="align-middle" style="width: 10%;">RATA - RATA (N)</th>
                            <th rowspan="2" class="align-middle" style="width: 10%;">N X B</th>
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
                                <td class="fw-bold ">{{ $nxB + 0 }}</td>
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

        </div>
    </div>
</div>

@endsection