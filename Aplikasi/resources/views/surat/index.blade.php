@extends('layout.main')

@section('title','Surat')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Data Surat</h4>

        @if (auth()->user()->role === 'siswa')
            <a href="{{ route('surat.create') }}" class="btn btn-primary">
                + Ajukan Surat
            </a>
        @endif
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

    <div class="card">
        <div class="card-header">
            <strong>Daftar Surat Permohonan</strong>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>

                            @if (auth()->user()->role !== 'siswa')
                                <th>Pembuat</th>
                            @endif

                            <th>Jenis Surat</th>
                            <th>Judul</th>
                            <th>Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($surats as $surat)
                            <tr>
                                <td>
                                    {{ $loop->iteration + ($surats->currentPage() - 1) * $surats->perPage() }}
                                </td>

                                @if (auth()->user()->role !== 'siswa')
                                    <td>
                                        {{ $surat->pembuat->name ?? '-' }}
                                    </td>
                                @endif

                                <td>
                                    {{ ucwords(str_replace('_', ' ', $surat->jenis_surat)) }}
                                </td>

                                <td>
                                    {{ $surat->judul }}
                                </td>

                                <td>
                                    {{ $surat->nama_kegiatan ?? '-' }}
                                </td>

                                <td>
                                    @if ($surat->tanggal_mulai && $surat->tanggal_selesai)
                                        {{ $surat->tanggal_mulai->format('d-m-Y') }}
                                        s/d
                                        {{ $surat->tanggal_selesai->format('d-m-Y') }}
                                    @elseif ($surat->tanggal_mulai)
                                        {{ $surat->tanggal_mulai->format('d-m-Y') }}
                                    @else
                                        -
                                    @endif
                                </td>

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

                                <td>
                                    <div class="d-flex flex-wrap gap-1">

                                        <a href="{{ route('surat.show', $surat->id) }}" class="btn btn-sm btn-info">
                                            Detail
                                        </a>

                                        @if (auth()->user()->role === 'siswa' && $surat->status === 'pending')
                                            <a href="{{ route('surat.edit', $surat->id) }}" class="btn btn-sm btn-warning">
                                                Edit
                                            </a>
                                        @endif

                                        @if ($surat->status === 'selesai')
                                            <a href="{{ route('surat.download', $surat->id) }}" class="btn btn-sm btn-success">
                                                Download
                                            </a>
                                        @endif

                                        @if (in_array(auth()->user()->role, ['waka', 'admin']))

                                            @if ($surat->status === 'pending')
                                                <form action="{{ route('surat.review', $surat->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        Review
                                                    </button>
                                                </form>
                                            @endif

                                            @if (in_array($surat->status, ['pending', 'review']))
                                                <form action="{{ route('surat.terima', $surat->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menerima surat ini?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        Terima
                                                    </button>
                                                </form>

                                                <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#tolakModal{{ $surat->id }}">
                                                    Tolak
                                                </button>
                                            @endif

                                        @endif

                                    </div>
                                </td>
                            </tr>

                            {{-- Modal Tolak --}}
                            @if (in_array(auth()->user()->role, ['waka', 'admin']))
                                <div class="modal fade" id="tolakModal{{ $surat->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="{{ route('surat.tolak', $surat->id) }}" method="POST">
                                            @csrf

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tolak Surat</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <p>
                                                        Yakin ingin menolak surat:
                                                        <strong>{{ $surat->judul }}</strong>?
                                                    </p>

                                                    <div class="mb-3">
                                                        <label class="form-label">Alasan Penolakan</label>
                                                        <textarea name="catatan_waka" class="form-control" rows="4" required></textarea>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">
                                                        Tolak Surat
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'siswa' ? 7 : 8 }}" class="text-center">
                                    Belum ada data surat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $surats->links() }}
            </div>
        </div>
    </div>
</div>
@endsection