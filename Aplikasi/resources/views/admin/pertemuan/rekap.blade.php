@extends('layout.main')

@section('title','Rekap Absensi')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header">

            <h5>Rekap Absensi Siswa</h5>

        </div>

        <div class="card-body">

            <table class="table table-bordered text-center">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Hadir</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                        <th>Alpa</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($rekap as $key => $r)

                    <tr>

                        <td>{{ $key+1 }}</td>

                        <td>{{ $r->nama }}</td>

                        <td>{{ $r->kelas }}</td>

                        <td>{{ $r->hadir }}</td>

                        <td>{{ $r->izin }}</td>

                        <td>{{ $r->sakit }}</td>

                        <td>{{ $r->alpa }}</td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection