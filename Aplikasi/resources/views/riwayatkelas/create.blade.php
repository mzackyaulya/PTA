@extends('layout.main')

@section('title','Tambah Siswa ke Kelas')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div>
            <h4>Tambah Siswa ke Kelas {{ $kelasTujuan->nama_kelas }}</h4>
            <small class="text-muted">
                Tahun Ajaran: {{ $tahunAktif->tahun }} ({{ $tahunAktif->semester }})
            </small>
        </div>

        <a href="{{ route('riwayatkelas.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card-body">

        @if($siswa->count() > 0)
            <form action="{{ route('riwayatkelas.store') }}" method="POST">
                @csrf

                <input type="hidden" name="kelas_id" value="{{ $kelasTujuan->id }}">

                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="50">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th class="text-center">No</th>
                            <th>Nama Siswa</th>
                            <th class="text-center">NISN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $i => $s)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="siswa_id[]" value="{{ $s->id }}">
                                </td>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ $s->user->name ?? '-' }}</td>
                                <td class="text-center">{{ $s->user->nisn ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary">
                    Simpan Penempatan
                </button>
            </form>
        @else
            <div class="alert alert-warning">
                Tidak ada siswa yang bisa ditambahkan ke kelas ini.
            </div>
        @endif

    </div>
</div>

<script>
    const checkAll = document.getElementById('checkAll');

    if (checkAll) {
        checkAll.addEventListener('change', function () {
            document.querySelectorAll("input[name='siswa_id[]']").forEach(function (checkbox) {
                checkbox.checked = checkAll.checked;
            });
        });
    }
</script>
@endsection