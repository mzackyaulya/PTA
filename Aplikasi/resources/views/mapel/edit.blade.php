@extends('layout.main')
@section('title','Edit Mapel')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Mata Pelajaran</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('mapel.update', $mapel->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Mapel</label>
                <input type="text" 
                       name="nama" 
                       class="form-control @error('nama') is-invalid @enderror"
                       value="{{ old('nama', $mapel->nama) }}" 
                       required>

                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Kode</label>
                <input type="text" 
                       name="kode" 
                       class="form-control @error('kode') is-invalid @enderror"
                       value="{{ old('kode', $mapel->kode) }}" required>

                @error('kode')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label>JB</label>
                <input type="number" 
                       name="jb" 
                       class="form-control @error('jb') is-invalid @enderror"
                       value="{{ old('jb', $mapel->jb) }}" required>

                @error('jb')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">
                Update
            </button>

            <a href="{{ route('mapel.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </form>
    </div>
</div>
@endsection