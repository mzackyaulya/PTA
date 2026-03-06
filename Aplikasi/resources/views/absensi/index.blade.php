@extends('layout.main')

@section('title','Daftar Pertemuan Absensi')
    
@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Pertemuan Absensi</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Pertemuan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($pertemuan as $key => $p)

                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>
                                {{ $p->mengajar->mapel->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $p->mengajar->kelas->nama_kelas ?? '-' }}
                            </td>

                            <td>
                                Pertemuan {{ $p->pertemuan_ke }}
                            </td>

                            <td>
                                {{ $p->tanggal }}
                            </td>

                            <td class="text-center">

                                <a href="{{ route('absensi.form',$p->id) }}"
                                   class="btn btn-sm btn-success">

                                    Isi Absensi

                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection