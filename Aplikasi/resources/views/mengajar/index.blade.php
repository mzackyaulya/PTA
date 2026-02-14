@extends('layout.main')
@section('title','Jadwal Mengajar')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Jadwal Mengajar</h4>
        <a href="{{ route('mengajar.create') }}" class="btn btn-primary">Tambah Jadwal</a>
    </div>

    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Guru</th>
                    <th>Mapel</th>
                    <th>Kelas</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $d)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $d->guru->nama }}</td>
                    <td>{{ $d->mapel->nama }}</td>
                    <td>{{ $d->kelas->nama_kelas }}</td>
                    <td>{{ $d->hari }}</td>
                    <td>Jam ke {{ $d->jam_ke }}</td>
                    <td>
                        <form action="{{ route('mengajar.destroy',$d->id) }}" method="POST">
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
