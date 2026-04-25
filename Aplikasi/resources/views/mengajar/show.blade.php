@extends('layout.main')

@section('title','Detail Jadwal Mengajar')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4>Jadwal Mengajar {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}</h4>
            <small class="text-muted">
                Tahun Ajaran Aktif:
                {{ $tahunAktif->tahun ?? '-' }}
                {{ $tahunAktif ? '(' . $tahunAktif->semester . ')' : '' }}
            </small>
        </div>

        <div>
            <a href="{{ route('mengajar.index') }}" class="btn btn-secondary">
                Kembali
            </a>

            <a href="{{ route('mengajar.create', ['kelas_id' => $kelas->id]) }}" class="btn btn-primary">
                Tambah Jadwal
            </a>
        </div>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Guru</th>
                    <th class="text-center">Mapel</th>
                    <th class="text-center">Hari</th>
                    <th class="text-center">Jam</th>
                    <th class="text-center" width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td class="text-center">{{ $d->guru->user->name ?? $d->guru->nama ?? '-' }}</td>
                        <td class="text-center">{{ $d->mapel->nama ?? '-' }}</td>
                        <td class="text-center">{{ $d->hari }}</td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($d->jam_mulai)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($d->jam_selesai)->format('H:i') }}
                        </td>
                        <td class="text-center">
                            <form action="{{ route('mengajar.destroy', $d->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada jadwal mengajar untuk kelas ini</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection