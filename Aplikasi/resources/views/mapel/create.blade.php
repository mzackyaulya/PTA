@extends('layout.main')
@section('title','Tambah Mapel')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Tambah Mata Pelajaran</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('mapel.store') }}">
            @csrf

            <div class="mb-3">
                <label>Nama Mapel</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Kode</label>
                <input type="text" name="kode" class="form-control">
            </div>

            <button class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>
@endsection
