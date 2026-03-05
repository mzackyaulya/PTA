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
                    <th class="text-center">No</th>
                    <th class="text-center">Guru</th>
                    <th class="text-center">Mapel</th>
                    <th class="text-center">Kelas</th>
                    <th class="text-center">Hari</th>
                    <th class="text-center">Jam</th>
                    <th width="100" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $d)
                <tr>
                    <td class="text-center">{{ $i+1 }}</td>
                    <td class="text-center">{{ $d->guru->nama }}</td>
                    <td class="text-center">{{ $d->mapel->nama }}</td>
                    <td class="text-center">{{ $d->kelas->nama_kelas }}</td>
                    <td class="text-center">{{ $d->hari }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($d->jam_mulai)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($d->jam_selesai)->format('H:i') }}
                    </td>
                    <td class="text-center">
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
