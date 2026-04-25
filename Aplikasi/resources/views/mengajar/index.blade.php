@extends('layout.main')

@section('title','Jadwal Mengajar')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Jadwal Mengajar</h4>
        <small class="text-muted">
            Tahun Ajaran Aktif:
            {{ $tahunAktif->tahun ?? '-' }}
            {{ $tahunAktif ? '(' . $tahunAktif->semester . ')' : '' }}
        </small>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tingkat</th>
                    <th class="text-center">Kelas</th>
                    <th class="text-center">Jumlah Jadwal</th>
                    <th class="text-center" width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $i => $k)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td class="text-center">{{ $k->tingkat }}</td>
                        <td class="text-center">{{ $k->nama_kelas }}</td>
                        <td class="text-center">{{ $k->jumlah_jadwal }}</td>
                        <td class="text-center">
                            <a href="{{ route('mengajar.show', $k->id) }}" class="btn btn-info btn-sm">
                                Lihat Jadwal
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data kelas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection