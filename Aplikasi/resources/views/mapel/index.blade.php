@extends('layout.main')
@section('title','Mata Pelajaran')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Data Mata Pelajaran</h4>
        <a href="{{ route('mapel.create') }}" class="btn btn-primary">Tambah</a>
    </div>

    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mapel</th>
                    <th>Kode</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $d)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->kode }}</td>
                    <td>
                        <a href="{{ route('mapel.edit',$d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('mapel.destroy',$d->id) }}" method="POST" class="d-inline">
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
