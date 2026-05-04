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
        </form>
    </div>
</div>
@endsection
