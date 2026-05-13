@extends('layout.main')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Detail Surat Permohonan</h4>

        <a href="{{ route('surat.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Alert Error --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        {{-- Detail Surat --}}
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Informasi Surat</strong>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Kode Surat</th>
                            <td>{{ $surat->kode_surat ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Jenis Surat</th>
                            <td>{{ ucwords(str_replace('_', ' ', $surat->jenis_surat)) }}</td>
                        </tr>

                        <tr>
                            <th>Judul Surat</th>
                            <td>{{ $surat->judul }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($surat->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif ($surat->status === 'review')
                                    <span class="badge bg-info text-dark">Review</span>
                                @elseif ($surat->status === 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif ($surat->status === 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">{{ $surat->status }}</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Nama Kegiatan</th>
                            <td>{{ $surat->nama_kegiatan ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Tempat Kegiatan</th>
                            <td>{{ $surat->tempat_kegiatan ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Tanggal Mulai</th>
                            <td>
                                {{ $surat->tanggal_mulai ? $surat->tanggal_mulai->format('d-m-Y') : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Tanggal Selesai</th>
                            <td>
                                {{ $surat->tanggal_selesai ? $surat->tanggal_selesai->format('d-m-Y') : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Nama Pelatih / Pembina</th>
                            <td>{{ $surat->nama_pelatih ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Nama Organisasi</th>
                            <td>{{ $surat->nama_organisasi ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Keperluan</th>
                            <td>{{ $surat->keperluan }}</td>
                        </tr>

                        <tr>
                            <th>Diajukan Oleh</th>
                            <td>{{ $surat->pembuat->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <td>{{ $surat->created_at ? $surat->created_at->format('d-m-Y H:i') : '-' }}</td>
                        </tr>

                        <tr>
                            <th>Direview Oleh</th>
                            <td>{{ $surat->waka->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Tanggal Review</th>
                            <td>{{ $surat->reviewed_at ? $surat->reviewed_at->format('d-m-Y H:i') : '-' }}</td>
                        </tr>

                        <tr>
                            <th>Catatan Waka</th>
                            <td>{{ $surat->catatan_waka ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Siswa Terkait --}}
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Siswa yang Terlibat</strong>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Status Siswa</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($surat->siswaTerlibat as $siswa)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $siswa->nis }}</td>
                                        <td>{{ $siswa->user->name ?? '-' }}</td>
                                        <td>
                                            @if ($siswa->status_siswa === 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif ($siswa->status_siswa === 'lulus')
                                                <span class="badge bg-primary">Lulus</span>
                                            @elseif ($siswa->status_siswa === 'pindah')
                                                <span class="badge bg-secondary">Pindah</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $siswa->status_siswa }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            Tidak ada siswa terkait.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel Aksi --}}
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Aksi Surat</strong>
                </div>

                <div class="card-body">

                    {{-- Tombol siswa --}}
                    @if (auth()->user()->role === 'siswa')
                        @if ($surat->status === 'pending')
                            <a href="{{ route('surat.edit', $surat->id) }}" class="btn btn-warning w-100 mb-2">
                                Edit Surat
                            </a>

                            <form action="{{ route('surat.destroy', $surat->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger w-100 mb-2">
                                    Hapus Surat
                                </button>
                            </form>
                        @endif

                        @if ($surat->status === 'selesai')
                            <a href="{{ route('surat.download', $surat->id) }}" class="btn btn-success w-100 mb-2">
                                Download Surat
                            </a>
                        @endif

                        @if ($surat->status === 'ditolak')
                            <div class="alert alert-danger mb-0">
                                Surat ditolak. Silakan lihat catatan Waka.
                            </div>
                        @endif

                        @if ($surat->status === 'review')
                            <div class="alert alert-info mb-0">
                                Surat sedang direview oleh Waka.
                            </div>
                        @endif

                        @if ($surat->status === 'pending')
                            <div class="alert alert-warning mb-0">
                                Surat masih menunggu review Waka.
                            </div>
                        @endif
                    @endif

                    {{-- Tombol waka/admin --}}
                    @if (in_array(auth()->user()->role, ['waka', 'admin']))

                        @if ($surat->status === 'pending')
                            <form action="{{ route('surat.review', $surat->id) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">
                                    Tandai Review
                                </button>
                            </form>
                        @endif

                        @if (in_array($surat->status, ['pending', 'review']))
                            <form action="{{ route('surat.terima', $surat->id) }}" method="POST" class="mb-2"
                                  onsubmit="return confirm('Yakin ingin menerima surat ini?')">
                                @csrf

                                <div class="mb-2">
                                    <label class="form-label">Catatan Waka Opsional</label>
                                    <textarea name="catatan_waka" class="form-control" rows="3"
                                              placeholder="Catatan jika diperlukan...">{{ old('catatan_waka', $surat->catatan_waka) }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-success w-100">
                                    Terima Surat
                                </button>
                            </form>

                            <hr>

                            <form action="{{ route('surat.tolak', $surat->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menolak surat ini?')">
                                @csrf

                                <div class="mb-2">
                                    <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                    <textarea name="catatan_waka" class="form-control" rows="3"
                                              placeholder="Masukkan alasan penolakan..." required>{{ old('catatan_waka') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-danger w-100">
                                    Tolak Surat
                                </button>
                            </form>
                        @endif

                        @if ($surat->status === 'selesai')
                            <a href="{{ route('surat.download', $surat->id) }}" class="btn btn-success w-100 mb-2">
                                Download Surat
                            </a>

                            <div class="alert alert-success mb-0">
                                Surat sudah selesai dan dapat diunduh.
                            </div>
                        @endif

                        @if ($surat->status === 'ditolak')
                            <div class="alert alert-danger mb-0">
                                Surat sudah ditolak.
                            </div>
                        @endif

                    @endif

                </div>
            </div>

            {{-- Ringkasan Status --}}
            <div class="card">
                <div class="card-header">
                    <strong>Ringkasan</strong>
                </div>

                <div class="card-body">
                    <p class="mb-1">
                        <strong>Status:</strong>
                        {{ ucfirst($surat->status) }}
                    </p>

                    <p class="mb-1">
                        <strong>Total Siswa Terkait:</strong>
                        {{ $surat->siswaTerlibat->count() }}
                    </p>

                    <p class="mb-0">
                        <strong>Dibuat:</strong>
                        {{ $surat->created_at ? $surat->created_at->diffForHumans() : '-' }}
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection