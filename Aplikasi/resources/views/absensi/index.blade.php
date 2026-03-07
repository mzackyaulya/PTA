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
                        <th class="text-center">No</th>
                        <th class="text-center">Mata Pelajaran</th>
                        <th class="text-center">Kelas</th>
                        <th class="text-center">Pertemuan</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($pertemuan as $key => $p)

                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>

                            <td class="text-center">
                                {{ $p->mengajar->mapel->nama ?? '-' }}
                            </td>

                            <td class="text-center">
                                {{ $p->mengajar->kelas->nama_kelas ?? '-' }}
                            </td>

                            <td class="text-center">
                                Pertemuan {{ $p->pertemuan_ke }}
                            </td>

                            <td class="text-center">
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