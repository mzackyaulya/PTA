@extends('layout.main')

@section('title','Nilai Siswa')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Data Nilai Berdasarkan Kelas</h4>

        <small class="text-muted">
            Tahun Ajaran Aktif:
            {{ $tahun->tahun ?? '-' }}
            {{ $tahun && $tahun->semester ? '(' . $tahun->semester . ')' : '' }}
        </small>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tingkat</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($kelas as $key => $k)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $k->tingkat ?? '-' }}</td>
                        <td>{{ $k->nama_kelas ?? '-' }}</td>
                        <td>
                            <a href="{{ route('nilai.admin.siswa', $k->id) }}"
                               class="btn btn-primary btn-sm">
                                Lihat Siswa
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">
                            Belum ada data kelas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection