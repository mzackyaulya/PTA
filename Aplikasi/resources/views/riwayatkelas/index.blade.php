@extends('layout.main')
@section('title','Penempatan Siswa')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Penempatan Siswa</h4>
        <a href="{{ route('riwayatkelas.create') }}" class="btn btn-primary">Tempatkan Siswa</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Tahun Ajaran</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $d)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $d->siswa->user->name ?? '-' }}</td>
                    <td>{{ $d->kelas->tingkat }} {{ $d->kelas->nama_kelas }}</td>
                    <td>{{ $d->tahunAjaran->tahun }} ({{ $d->tahunAjaran->semester }})</td>
                    <td>
                        <form action="{{ route('riwayatkelas.destroy',$d->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
