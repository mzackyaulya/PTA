@extends('layout.main')
@section('title','Tambah Jadwal Mengajar')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Tambah Jadwal Mengajar</h4>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-body">
        <form method="POST" action="{{ route('mengajar.store') }}">
            @csrf

            <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaranAktif->id ?? '' }}">

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
                <input type="text" class="form-control"
                    value="{{ $kelas->tingkat }} {{ $kelas->nama_kelas }}" readonly>

                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
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
                <select name="hari" class="form-control" required>
                    <option value="">-- pilih hari --</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Jam Pelajaran</label>
                <select name="jam" class="form-control" required>
                    <option value="">-- pilih jam --</option>
                    @foreach($jamList as $j)
                        <option value="{{ $j['mulai'] }}|{{ $j['selesai'] }}">
                            {{ $j['mulai'] }} - {{ $j['selesai'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('mengajar.index')}}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection