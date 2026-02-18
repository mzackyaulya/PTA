@extends('layout.main')
@section('title','Edit Tahun Ajaran')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Tahun Ajaran</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('tahunajaran.update',$tahunAjaran->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Tahun Ajaran</label>
                <input type="text" name="tahun" class="form-control"
                       value="{{ $tahunAjaran->tahun }}" required>
            </div>

            <div class="mb-3">
                <label>Semester</label>
                <select name="semester" class="form-control" required>
                    <option value="1" {{ $tahunAjaran->semester == 1 ? 'selected' : '' }}>I</option>
                    <option value="2" {{ $tahunAjaran->semester == 2 ? 'selected' : '' }}>II</option>
                </select>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="aktif" value="1" class="form-check-input"
                    {{ $tahunAjaran->aktif ? 'checked' : '' }}>
                <label class="form-check-label">Set sebagai semester aktif</label>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('tahunajaran.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
