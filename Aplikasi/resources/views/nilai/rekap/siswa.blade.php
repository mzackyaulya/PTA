@extends('layout.main')

@section('title','Rekap Nilai Per Siswa')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white d-flex justify-content-between align-items-center py-4 px-4">
            <div>
                <h5 class="mb-0 fw-bold">Rekap Nilai Per Siswa</h5>
                <small class="text-muted">
                    Nama: {{ $siswa->user->name ?? '-' }} |
                    NIS: {{ $siswa->nis ?? '-' }}
                    <br>
                    Tahun Ajaran:
                    {{ $tahun->tahun ?? '-' }}
                    {{ $tahun && $tahun->semester ? 'Semester ' . $tahun->semester : '' }}
                </small>
            </div>

            <div>
                <a href="{{ route('nilai.rekap', ['tahun_ajaran_id' => $tahun->id ?? null]) }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

                <a href="{{ route('nilai.rekap.siswa.export', [
                        'siswa' => $siswa->id,
                        'tahun_ajaran_id' => $tahun->id ?? null
                    ]) }}"
                   class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i>
                    Download Excel
                </a>
            </div>
        </div>

        <div class="card-body px-4 py-4">

            <form action="{{ route('nilai.rekap.siswa', $siswa->id) }}" method="GET" class="mb-4">
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
                        <button type="submit" class="btn btn-primary">
                            Tampilkan
                        </button>

                        <a href="{{ route('nilai.rekap.siswa', $siswa->id) }}" class="btn btn-secondary">
                            Tahun Aktif
                        </a>
                    </div>
                </div>
            </form>

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
                            $totalPengetahuan = 0;
                            $totalKeterampilan = 0;
                            $totalAkhir = 0;
                            $jumlahData = 0;
                        @endphp

                        @forelse($nilai as $key => $n)
                            @php
                                $totalPengetahuan += $n->nilai_pengetahuan ?? 0;
                                $totalKeterampilan += $n->nilai_keterampilan ?? 0;
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
                                    {{ $n->kelas->tingkat ?? '' }}
                                    {{ $n->kelas->nama_kelas ?? '-' }}
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
                                    Belum ada nilai pada tahun ajaran dan semester ini.
                                </td>
                            </tr>
                        @endforelse

                        @if($jumlahData > 0)
                            <tr class="fw-bold">
                                <td colspan="5">Rata-rata</td>
                                <td>{{ round($totalPengetahuan / $jumlahData, 2) }}</td>
                                <td></td>
                                <td>{{ round($totalKeterampilan / $jumlahData, 2) }}</td>
                                <td></td>
                                <td>{{ round($totalAkhir / $jumlahData, 2) }}</td>
                                <td></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>

@endsection