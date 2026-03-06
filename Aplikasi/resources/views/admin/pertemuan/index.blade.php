@extends('layout.main')

@section('title','Manajemen Pertemuan Absensi')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Manajemen Pertemuan Absensi
            </h5>

            <a href="{{ route('pertemuan.create') }}"
               class="btn btn-primary">

                + Buat Pertemuan

            </a>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Mapel</th>
                        <th>Kelas</th>
                        <th>Pertemuan</th>
                        <th>Hari</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($pertemuan as $key => $p)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>
                            {{ $p->mengajar->mapel->nama }}
                        </td>

                        <td>
                            {{ $p->mengajar->kelas->nama_kelas }}
                        </td>

                        <td>
                            {{ $p->pertemuan_ke }}
                        </td>

                        <td>
                            {{ $p->mengajar->hari }}
                        </td>

                        <td>
                            {{ $p->tanggal }}
                        </td>

                        <td>

                            @if($p->is_approved)

                                <span class="badge bg-success">
                                    Disetujui
                                </span>

                            @else

                                <span class="badge bg-warning">
                                    Belum Disetujui
                                </span>

                            @endif

                        </td>

                        <td>

                            @if(!$p->is_approved)

                            <a href="{{ route('pertemuan.approve',$p->id) }}"
                               class="btn btn-sm btn-success">

                                Approve

                            </a>

                            @endif

                            <a href="{{ route('pertemuan.show',$p->id) }}"
                               class="btn btn-sm btn-info">

                                Detail

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