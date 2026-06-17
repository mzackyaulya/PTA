@extends('layout.main')

@section('title','Daftar Siswa')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4>Daftar Siswa</h4>
            <small class="text-muted">
                Kelas:
                {{ $kelas->tingkat ?? '-' }} {{ $kelas->nama_kelas ?? '-' }}
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
        <table class="table table-bordered table-striped text-center align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($siswa as $key => $s)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $s->nis ?? '-' }}</td>
                        <td>{{ $s->user->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-success">
                                {{ $s->status_siswa ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('nilai.admin.showSiswa', $s->id) }}"
                               class="btn btn-info btn-sm text-white">
                                Lihat Nilai
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">
                            Belum ada siswa pada kelas ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection 