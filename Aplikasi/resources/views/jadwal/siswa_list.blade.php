@extends('layout.main')

@section('title','Daftar Siswa')

@section('content')

<div class="card">

    <div class="card-header">
        <h4>Daftar Siswa</h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th width="60" class="text-center">No</th>
                    <th class="text-center">NIS</th>
                    <th class="text-center">Nama Siswa</th>
                    <th class="text-center">Kelas</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">Tahun Masuk</th>
                    <th class="text-center">Status</th>
                    <th width="120" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($siswa as $i => $s)

                    <tr>

                        <td class="text-center">{{ $i + 1 }}</td>

                        <td class="text-center">{{ $s->nis }}</td>

                        <td class="text-center">{{ $s->user->name ?? '-' }}</td>

                        <td class="text-center">
                            {{ optional(optional($s->kelasAktif)->kelas)->nama_kelas ?? '-' }}
                        </td>

                        <td class="text-center">{{ $s->jenis_kelamin ?? '-' }}</td>

                        <td class="text-center">{{ $s->tahun_masuk ?? '-' }}</td>

                        <td class="text-center">
                            <span class="badge bg-success">
                                {{ $s->status_siswa ?? '-' }}
                            </span>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('jadwal.siswa', $s->id) }}"
                               class="btn btn-primary btn-sm">
                                Lihat Jadwal
                            </a>
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection