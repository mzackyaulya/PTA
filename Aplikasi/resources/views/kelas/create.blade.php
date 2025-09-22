@extends('layout.main')

@section('title', 'Tambah Kelas')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Form Tambah Kelas</h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('kelas.store') }}" method="POST">
                        @csrf

                        {{-- Nama Kelas --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}" class="form-control" required>
                        </div>

                        {{-- Tingkat --}}
                        <div class="mb-3">
                            <label class="form-label">Tingkat</label>
                            <select name="tingkat" class="form-select" required>
                                <option value="">- Pilih Tingkat -</option>
                                <option value="X" {{ old('tingkat')=='X' ? 'selected' : '' }}>X</option>
                                <option value="XI" {{ old('tingkat')=='XI' ? 'selected' : '' }}>XI</option>
                                <option value="XII" {{ old('tingkat')=='XII' ? 'selected' : '' }}>XII</option>
                            </select>
                        </div>

                        {{-- Wali Kelas --}}
                        <div class="mb-3">
                            <label class="form-label">Wali Kelas</label>
                            <select name="wali_kelas" class="form-select">
                                <option value="">- Pilih Wali Kelas -</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}" {{ old('wali_kelas') == $g->id ? 'selected' : '' }}>
                                        {{ $g->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
