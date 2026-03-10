@extends('layout.main')

@section('title','Input Nilai')

@section('content')

<div class="card">

    <div class="card-header">
        <h4>Input Nilai Siswa</h4>
    </div>

    <div class="card-body">

        <form action="{{ url('guru/nilai/store') }}" method="POST">

            @csrf

            {{-- ========================
                    PILIH SISWA
            ======================== --}}
            <div class="mb-3">

                <label>Siswa</label>

                <select name="siswa_id" class="form-control" required>

                    <option value="">-- Pilih Siswa --</option>

                    @foreach($siswa as $s)

                        <option value="{{ $s->id }}">
                            {{ $s->user->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- ========================
                    PILIH MAPEL
            ======================== --}}
            <div class="mb-3">

                <label>Mata Pelajaran</label>

                <select name="mapel_id" class="form-control" required>

                    <option value="">-- Pilih Mata Pelajaran --</option>

                        @foreach($mapel as $m)

                        <option value="{{ $m->id }}">
                            {{ $m->nama }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- ========================
                    PILIH KELAS
            ======================== --}}
            <div class="mb-3">

                <label>Kelas</label>

                <select name="kelas_id" class="form-control" required>

                    <option value="">-- Pilih Kelas --</option>

                    @foreach($kelas as $k)

                        <option value="{{ $k->id }}">
                            {{ $k->nama_kelas }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="mb-3">

                <label>Nilai Tugas</label>

                <input type="number"
                       name="tugas"
                       class="form-control"
                       required>

            </div>


            <div class="mb-3">

                <label>Nilai UTS</label>

                <input type="number"
                       name="uts"
                       class="form-control"
                       required>

            </div>


            <div class="mb-3">

                <label>Nilai UAS</label>

                <input type="number"
                       name="uas"
                       class="form-control"
                       required>

            </div>


            <button class="btn btn-success">
                Simpan Nilai
            </button>

        </form>

    </div>

</div>

@endsection