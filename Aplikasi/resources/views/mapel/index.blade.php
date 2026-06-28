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
                    <th>Kode</th>
                    <th>Nama Mapel</th>
                    <th>JB</th>
                    <th width="150" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $d)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $d->kode }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->jb ?? '-' }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            
                            <a href="{{ route('mapel.edit',$d->id) }}" 
                            class="btn btn-warning btn-sm px-3">
                                Edit
                            </a>

                            <form action="{{ route('mapel.destroy',$d->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger btn-sm px-3"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data Mata Pelajaran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
