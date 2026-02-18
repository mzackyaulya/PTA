@extends('layout.main')
@section('title','Tambah Jadwal Mengajar')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Tambah Jadwal Mengajar</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('mengajar.store') }}">
            @csrf

            <div class="mb-3">
                <label>Guru</label>
                <select name="guru_id" class="form-control" required>
                    <option value="">-- pilih guru --</option>
                    @foreach($guru as $g)
                        <option value="{{ $g->id }}">{{ $g->nama }}</option>
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

            <div class="mb-3">
                <label>Mapel</label>
                <select name="mapel_id" class="form-control" required>
                    <option value="">-- pilih mapel --</option>
                    @foreach($mapel as $m)
                        <option value="{{ $m->id }}">{{ $m->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Hari</label>
                <select name="hari" class="form-control">
                    <option>Senin</option>
                    <option>Selasa</option>
                    <option>Rabu</option>
                    <option>Kamis</option>
                    <option>Jumat</option>
                    <option>Sabtu</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Jam Ke</label>
                <input type="number" name="jam_ke" class="form-control" required>
            </div>

            <button class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>
@endsection
