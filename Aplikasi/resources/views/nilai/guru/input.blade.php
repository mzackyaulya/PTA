@extends('layout.main')

@section('title','Input Nilai Siswa')

@section('content')

<style>
    .nilai-table thead th {
        vertical-align: middle;
        text-align: center;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 14px 10px;
    }

    .nilai-table tbody td {
        vertical-align: middle;
        padding: 14px 12px;
    }

    .input-nilai {
        height: 42px;
        min-width: 120px;
        font-size: 15px;
        font-weight: 600;
        text-align: center;
    }

    .input-kkm {
        height: 42px;
        width: 90px;
        min-width: 90px;
        font-size: 15px;
        font-weight: 700;
        text-align: center;
        padding: 6px 10px;
    }

    .input-keterangan {
        height: 42px;
        min-width: 220px;
        font-size: 14px;
    }

    /* Hilangkan tombol panah kecil di input number */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        opacity: 1;
        height: 38px;
    }

    @media (max-width: 768px) {
        .input-nilai {
            min-width: 100px;
        }

        .input-kkm {
            width: 80px;
            min-width: 80px;
        }

        .input-keterangan {
            min-width: 180px;
        }
    }
</style>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4>Input Nilai Siswa</h4>
            <small class="text-muted">
                Kelas:
                {{ $mengajar->kelas->tingkat ?? '-' }} {{ $mengajar->kelas->nama_kelas ?? '-' }}
                |
                Mapel: {{ $mengajar->mapel->nama ?? '-' }}
                |
                Tahun Ajaran:
                {{ $tahun->tahun ?? '-' }}
                {{ $tahun && $tahun->semester ? '(' . $tahun->semester . ')' : '' }}
            </small>
        </div>

        <a href="{{ route('nilai.guru.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('nilai.guru.store', $mengajar->id) }}" method="POST">
            @csrf

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center nilai-table">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th width="150">NIS</th>
                            <th>Nama Siswa</th>
                            <th width="120">KKM</th>
                            <th width="180">Pengetahuan</th>
                            <th width="180">Keterampilan</th>
                            <th width="260">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($siswa as $key => $s)
                            @php
                                $n = $nilai[$s->id] ?? null;
                            @endphp

                            <tr>
                                <td>{{ $key + 1 }}</td>

                                <td>{{ $s->nis ?? '-' }}</td>

                                <td class="text-start">
                                    {{ $s->user->name ?? '-' }}
                                </td>

                                <td>
                                    <input type="number"
                                           name="nilai[{{ $s->id }}][kkm]"
                                           class="form-control input-kkm"
                                           min="0"
                                           max="100"
                                           value="{{ old('nilai.'.$s->id.'.kkm', $n->kkm ?? 75) }}">
                                </td>

                                <td>
                                    <input type="number"
                                           name="nilai[{{ $s->id }}][nilai_pengetahuan]"
                                           class="form-control input-nilai"
                                           min="0"
                                           max="100"
                                           value="{{ old('nilai.'.$s->id.'.nilai_pengetahuan', $n->nilai_pengetahuan ?? '') }}">
                                </td>

                                <td>
                                    <input type="number"
                                           name="nilai[{{ $s->id }}][nilai_keterampilan]"
                                           class="form-control input-nilai"
                                           min="0"
                                           max="100"
                                           value="{{ old('nilai.'.$s->id.'.nilai_keterampilan', $n->nilai_keterampilan ?? '') }}">
                                </td>

                                <td>
                                    <input type="text"
                                           name="nilai[{{ $s->id }}][keterangan]"
                                           class="form-control input-keterangan"
                                           value="{{ old('nilai.'.$s->id.'.keterangan', $n->keterangan ?? '') }}">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">
                                    Belum ada siswa pada kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($siswa->count() > 0)
                <button type="submit" class="btn btn-success mt-3">
                    Simpan Nilai
                </button>
            @endif
        </form>

    </div>
</div>

@endsection