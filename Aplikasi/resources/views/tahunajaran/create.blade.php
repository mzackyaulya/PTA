@extends('layout.main')
@section('title','Tambah Tahun Ajaran')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Tambah Tahun Ajaran</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('tahunajaran.store') }}">
            @csrf

            <div class="mb-3">
                <label>Tahun Ajaran</label>
                <input type="text" name="tahun" class="form-control" placeholder="2025/2026" required>
            </div>

            <div class="mb-3">
                <label>Semester</label>
                <select name="semester" class="form-control" required>
                    <option value="1">I</option>
                    <option value="2">II</option>

                </select>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="aktif" value="1" class="form-check-input">
                <label class="form-check-label">Set sebagai semester aktif</label>
            </div>

            <button class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>
@endsection
