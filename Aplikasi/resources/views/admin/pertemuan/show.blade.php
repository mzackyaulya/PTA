@extends('layout.main')

@section('title', 'Detail Absensi Pertemuan')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-info">
            <h5 class="mb-0 fw-bold">Detail Absensi Pertemuan</h5>
        </div>

        <div class="card-body">


            {{-- ================= INFO PERTEMUAN ================= --}}
            <div class="row mb-4">

                <div class="col-md-3 text-center">
                    <b>Mata Pelajaran</b>
                    <br>
                    {{ $pertemuan->mengajar->mapel->nama }}
                </div>

                <div class="col-md-3 text-center">
                    <b>Kelas</b>
                    <br>
                    {{ $pertemuan->mengajar->kelas->nama_kelas }}
                </div>

                <div class="col-md-3 text-center">
                    <b>Pertemuan</b>
                    <br>
                    {{ $pertemuan->pertemuan_ke }}
                </div>

                <div class="col-md-3 text-center">
                    <b>Tanggal</b>
                    <br>
                    {{ $pertemuan->tanggal }}
                </div>

            </div>



            {{-- ================= STATISTIK ABSENSI ================= --}}
            <div class="row mb-4 text-center">

                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h4>{{ $hadir }}</h4>
                            Hadir
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h4>{{ $izin }}</h4>
                            Izin
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h4>{{ $sakit }}</h4>
                            Sakit
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h4>{{ $alpa }}</h4>
                            Alpha
                        </div>
                    </div>
                </div>

            </div>



            {{-- ================= TABEL ABSENSI ================= --}}
            <table class="table table-bordered table-striped">

                <thead class="table-light">
                    <tr>
                        <th class="text-center">NISN</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Keterangan</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($pertemuan->absensis as $absen)

                        <tr>

                            <td class="text-center">
                                {{ $absen->siswa->user->nisn }}
                            </td>

                            <td class="text-center">
                                {{ $absen->siswa->user->name }}
                            </td>

                            <td class="text-center">

                                @if($absen->status == 'hadir')
                                    <span class="badge bg-success">Hadir</span>

                                @elseif($absen->status == 'izin')
                                    <span class="badge bg-warning">Izin</span>

                                @elseif($absen->status == 'sakit')
                                    <span class="badge bg-info">Sakit</span>

                                @elseif($absen->status == 'alpa')
                                    <span class="badge bg-danger">Alpha</span>

                                @else
                                    <span class="badge bg-secondary">Belum Absen</span>
                                @endif

                            </td>

                            <td class="text-center">
                                {{ $absen->keterangan ?? '-' }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>


        </div>

    </div>

</div>

@endsection