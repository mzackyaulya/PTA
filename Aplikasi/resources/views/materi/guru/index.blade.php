@extends('layout.main')

@section('title','Materi Guru')

@section('content')

<div class="card">

    <div class="card-body">

        <div class="d-flex justify-content-between mb-3">

            <h4>Data Materi</h4>

            <a href="{{ route('materi.create') }}" class="btn btn-success">
                Upload Materi
            </a>

        </div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <table class="table table-bordered">

            <thead>

                <tr>
                    <th width="60">No</th>
                    <th>Mata Pelajaran</th>
                    <th width="100">Materi</th>
                    <th>Judul</th>
                    <th width="150">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($materi as $m)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $m->mapel->nama }}</td>

                    <td>
                        M{{ $m->materi }}
                    </td>

                    <td>{{ $m->judul }}</td>

                    <td>

                        <form 
                            action="{{ route('materi.destroy',$m->id) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus materi ini?')"
                        >

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="text-center">
                        Belum ada materi
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection