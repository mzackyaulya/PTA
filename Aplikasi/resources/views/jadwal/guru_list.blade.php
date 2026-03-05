@extends('layout.main')

@section('title','Daftar Guru')

@section('content')

<div class="card">

    <div class="card-header">
        <h4>Daftar Guru</h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th width="60" class="text-center">No</th>
                    <th class="text-center">NIP</th>
                    <th class="text-center">Nama Guru</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">No HP</th>
                    <th class="text-center">Mata Pelajaran</th>
                    <th class="text-center">Status</th>
                    <th width="130" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($guru as $i => $g)

                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>

                    <td class="text-center">{{ $g->nip }}</td>

                    <td class="text-center">{{ $g->nama }}</td>

                    <td class="text-center">
                        {{ $g->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                    </td>

                    <td class="text-center">{{ $g->nohp }}</td>

                    <td class="text-center">{{ $g->mapel }}</td>

                    <td class="text-center">
                        <span class="badge bg-success">
                            {{ $g->status_guru }}
                        </span>
                    </td>

                    <td class="text-center">
                        <a href="{{ route('jadwal.guru', $g->id) }}"
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