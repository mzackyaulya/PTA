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

                        <th class="text-center">No</th>
                        <th class="text-center">Mapel</th>
                        <th class="text-center">Kelas</th>
                        <th class="text-center">Pertemuan</th>
                        <th class="text-center">Hari</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($pertemuan as $key => $p)

                    <tr>

                        <td class="text-center">{{ $key + 1 }}</td>

                        <td class="text-center">
                            {{ $p->mengajar->mapel->nama }}
                        </td>

                        <td class="text-center">
                            {{ $p->mengajar->kelas->nama_kelas }}
                        </td>

                        <td class="text-center">
                            {{ $p->pertemuan_ke }}
                        </td>

                        <td class="text-center">
                            {{ $p->mengajar->hari }}
                        </td>

                        <td class="text-center">
                            {{ $p->tanggal }}
                        </td>

                        <td class="text-center">

                            @if(!$p->is_approved)

                                <span class="badge bg-warning">Belum Disetujui</span>

                            @elseif($p->is_approved && !$p->is_started)

                                <span class="badge bg-secondary">Siap</span>

                            @elseif($p->is_started && !$p->is_closed)

                                <span class="badge bg-success">Berlangsung</span>

                            @elseif($p->is_closed)

                                <span class="badge bg-danger">Selesai</span>

                            @endif

                        </td>

                        <td class="text-center">

                            {{-- APPROVE --}}
                            @if(!$p->is_approved)

                                <a href="{{ route('pertemuan.approve',$p->id) }}"
                                class="btn btn-sm btn-success">
                                    Buka Absen
                                </a>

                            @endif


                            {{-- DETAIL --}}
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