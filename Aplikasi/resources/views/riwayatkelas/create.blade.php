@extends('layout.main')
@section('title','Tempatkan Siswa')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Penempatan kelas Siswa</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('riwayatkelas.store') }}">
            @csrf

            <div class="mb-3">
                <label>Siswa</label>
                <select name="siswa_id" class="form-control" required>
                    <option value="">-- pilih siswa --</option>
                    @foreach($siswa as $s)
                        <option value="{{ $s->id }}">{{ $s->user->name ?? $s->nis }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Kelas</label>
                <select name="kelas_id" class="form-control" required>
                    <option value="">-- pilih kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->tingkat }} {{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="alert alert-info">
                Tahun ajaran aktif: <b>{{ $tahun->tahun }} ({{ $tahun->semester }})</b>
            </div>

            <button class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>
@endsection
