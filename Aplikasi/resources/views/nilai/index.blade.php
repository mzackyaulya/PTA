@extends('layout.main')

@section('title','Data Nilai')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Data Nilai</h4>

        @if(auth()->user()->role == 'guru')
            <a href="{{ url('guru/nilai/create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Input Nilai
            </a>
        @endif
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped" id="table-nilai">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Siswa</th>
                    <th>Mapel</th>
                    <th>Kelas</th>
                    <th>Tugas</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Nilai Akhir</th>

                    @if(auth()->user()->role == 'guru')
                        <th>Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody>

                @foreach($nilai as $n)

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $n->siswa->user->name }}</td>
                    <td>{{ $n->mapel->nama }}</td>
                    <td>{{ $n->kelas->nama_kelas }}</td>

                    <td>{{ $n->tugas }}</td>
                    <td>{{ $n->uts }}</td>
                    <td>{{ $n->uas }}</td>

                    <td>
                        {{ $n->nilai_akhir }}
                    </td>

                    @if(auth()->user()->role == 'guru')

                    <td>

                        <a href="{{ url('guru/nilai/edit/'.$n->id) }}"
                           class="btn btn-warning btn-sm">

                           Edit

                        </a>

                        <form action="{{ url('guru/nilai/'.$n->id) }}"
                              method="POST"
                              style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">
                                Hapus
                            </button>

                        </form>

                    </td>

                    @endif

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>
</div>

@endsection