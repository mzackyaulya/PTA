@extends('layout.main')

@section('title','Buat Pertemuan Absensi')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header">
            <h5>Buat Pertemuan Absensi</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('pertemuan.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Jadwal Mengajar
                    </label>

                    <select name="mengajar_id" class="form-control">

                        @foreach($mengajar as $m)

                        <option value="{{ $m->id }}">

                            {{ $m->mapel->nama }}
                            -
                            {{ $m->kelas->nama_kelas }}
                            -
                            {{ $m->hari }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Pertemuan Ke</label>

                    <input type="number"
                           name="pertemuan_ke"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>Tanggal</label>

                    <input type="date"
                           name="tanggal"
                           class="form-control">

                </div>

                <button class="btn btn-primary">

                    Simpan

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
