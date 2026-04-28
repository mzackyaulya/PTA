@extends('layout.main')

@section('title', 'Data Kelas')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title fw-bold mb-2">Data Kelas</h2>

        @if (auth()->user()->role === 'admin')
            <a href="{{ route('kelas.create') }}" class="btn btn-primary">Tambah Kelas</a>
        @endif
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Nama Kelas</th>
                    <th class="text-center">Tingkat</th>
                    <th class="text-center">Wali Kelas</th>
                    <th class="text-center">Kapasitas</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($kelas as $item)
                    <tr>
                        <td class="text-center">{{ $item->nama_kelas }}</td>
                        <td class="text-center">{{ $item->tingkat }}</td>
                        <td class="text-center">{{ $item->wali->user->name ?? '-' }}</td>

                        <td class="text-center">
                            @if($item->jumlah_siswa >= $item->kapasitas)
                                <span class="text-danger fw-semibold">
                                    {{ $item->jumlah_siswa }} / {{ $item->kapasitas }}
                                </span>
                            @else
                                {{ $item->jumlah_siswa }} / {{ $item->kapasitas }}
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="{{ route('kelas.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('kelas.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data Kelas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end'
            });
        });
    </script>
@endif
@endsection