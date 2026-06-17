@extends('layout.main')

@section('title','Data Nilai Siswa')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Data Nilai Siswa</h4>

        <small class="text-muted">
            Tahun Ajaran:
            {{ $tahun->tahun ?? '-' }}
            {{ $tahun && $tahun->semester ? 'Semester ' . $tahun->semester : '' }}
        </small>
    </div>

    <div class="card-body">

        {{-- FILTER TAHUN AJARAN --}}
        <form action="{{ route('nilai.admin.kelas') }}" method="GET" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pilih Tahun Ajaran</label>
                    <select name="tahun_ajaran_id" class="form-control">
                        @foreach($tahunList as $t)
                            <option value="{{ $t->id }}"
                                {{ $tahun && $tahun->id == $t->id ? 'selected' : '' }}>
                                {{ $t->tahun }} Semester {{ $t->semester }}
                                {{ $t->aktif == 1 ? ' - Aktif' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        Tampilkan
                    </button>

                    <a href="{{ route('nilai.admin.kelas') }}" class="btn btn-secondary">
                        Tahun Aktif
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">

                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                        <th>Status</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($siswa as $key => $r)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>
                                {{ $r->siswa->nis ?? '-' }}
                            </td>

                            <td class="text-start">
                                {{ $r->siswa->user->name ?? '-' }}
                            </td>

                            <td>
                                @if($r->kelas)
                                    {{ $r->kelas->tingkat ?? '' }} {{ $r->kelas->nama_kelas ?? '' }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                {{ $r->siswa->jenis_kelamin ?? '-' }}
                            </td>

                            <td>
                                <span class="badge bg-success">
                                    {{ $r->siswa->status_siswa ?? '-' }}
                                </span>
                            </td>

                            <td>
                                @if($r->siswa)
                                    <a href="{{ route('nilai.admin.showSiswa', [
                                            'siswa' => $r->siswa->id,
                                            'tahun_ajaran_id' => $tahun->id ?? null
                                        ]) }}"
                                       class="btn btn-info btn-sm text-white">
                                        Lihat Nilai
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted py-4">
                                Belum ada siswa pada tahun ajaran ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection