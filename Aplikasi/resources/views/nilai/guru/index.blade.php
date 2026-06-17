@extends('layout.main')

@section('title','Input Nilai')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Input Nilai</h4>
        <small class="text-muted">
            Tahun Ajaran Aktif:
            {{ $tahun->tahun ?? '-' }}
            {{ $tahun && $tahun->semester ? '(' . $tahun->semester . ')' : '' }}
        </small>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($mengajar as $key => $m)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $m->kelas->tingkat ?? '-' }} {{ $m->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $m->mapel->nama ?? '-' }}</td>
                            <td>{{ $m->hari ?? '-' }}</td>
                            <td>
                                {{ substr($m->jam_mulai, 0, 5) }}
                                -
                                {{ substr($m->jam_selesai, 0, 5) }}
                            </td>
                            <td>
                                <a href="{{ route('nilai.guru.input', $m->id) }}"
                                   class="btn btn-primary btn-sm">
                                    Input Nilai
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">
                                Belum ada jadwal mengajar pada semester aktif.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection