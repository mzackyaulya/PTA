@extends('layout.main')

@section('title', 'Surat')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 fw-bold">Riwayat Surat</h1>
    </div>

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Alert Error --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse ($surats as $surat)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex flex-column">
                        
                        {{-- Bagian Atas: Ikon dan Status --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle shadow-sm d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-file-alt fa-lg"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted d-block" style="font-size: 0.7rem; font-weight: bold; text-transform: uppercase; line-height: 1;">Nomor Surat</small>
                                    <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $surat->kode_surat ?? '-' }}</span>
                                </div>
                            </div>
                            
                            <div>
                                @if ($surat->status === 'pending')
                                    <span class="badge bg-warning rounded-pill text-dark px-5 py-3 fw-bold">Pending</span>
                                @elseif ($surat->status === 'review')
                                    <span class="badge bg-info rounded-pill text-dark px-4 py-3 fw-bold">Review</span>
                                @elseif ($surat->status === 'selesai')
                                    <span class="badge bg-success rounded-pill px-4 py-3 fw-bold">Selesai</span>
                                @elseif ($surat->status === 'ditolak')
                                    <span class="badge bg-danger rounded-pill px-4 py-3 fw-bold">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-4 py-3 fw-bold">{{ $surat->status }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Bagian Tengah: Informasi Surat --}}
                        <h6 class="font-weight-bold text-primary text-uppercase mb-1" style="font-size: 0.85rem;">
                            @if (auth()->user()->role !== 'siswa')
                                {{ $surat->pembuat->name ?? 'Anonim' }} - 
                            @endif
                            {{ ucwords(str_replace('_', ' ', $surat->jenis_surat)) }}
                        </h6>
                        
                        <h5 class="mb-2 text-dark font-weight-bold" style="font-size: 1.1rem; line-height: 1.3;">
                            {{ $surat->judul }}
                        </h5>
                        
                        @if($surat->nama_kegiatan)
                            <p class="text-muted mb-1" style="font-size: 0.85rem;">
                                <i class="fas fa-tag me-1"></i> {{ $surat->nama_kegiatan }}
                            </p>
                        @endif

                        <p class="text-muted mb-3" style="font-size: 0.85rem;">
                            <i class="fas fa-calendar-alt me-1"></i>
                            @if ($surat->tanggal_mulai && $surat->tanggal_selesai)
                                {{ $surat->tanggal_mulai->format('d M Y') }} - {{ $surat->tanggal_selesai->format('d M Y') }}
                            @elseif ($surat->tanggal_mulai)
                                {{ $surat->tanggal_mulai->format('d M Y') }}
                            @else
                                -
                            @endif
                        </p>

                        {{-- Bagian Bawah: Tombol Aksi --}}
                        <div class="mt-auto">
                            <hr class="mt-0 mb-2">
                            <div class="d-flex flex-wrap gap-1 justify-content-start">
                                
                                <a href="{{ route('surat.show', $surat->id) }}" class="btn btn-sm btn-outline-dark shadow-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>

                                @if (auth()->user()->role === 'siswa' && $surat->status === 'pending')
                                    <a href="{{ route('surat.edit', $surat->id) }}" class="btn btn-sm btn-warning shadow-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @endif

                                {{-- Admin dan Waka otomatis bisa unduh jika status selesai --}}
                                @if ($surat->status === 'selesai')
                                    <a href="{{ route('surat.download', $surat->id) }}" class="btn btn-sm btn-success shadow-sm">
                                        <i class="fas fa-download"></i> Unduh
                                    </a>
                                @endif

                                {{-- HANYA WAKA YANG BISA REVIEWS, TERIMA, DAN TOLAK --}}
                                @if (auth()->user()->role === 'waka')
                                    @if ($surat->status === 'pending')
                                        <form action="{{ route('surat.review', $surat->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                                                Review
                                            </button>
                                        </form>
                                    @endif

                                    @if (in_array($surat->status, ['pending', 'review']))
                                        <form action="{{ route('surat.terima', $surat->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menerima surat ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success shadow-sm">
                                                Terima
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-sm btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $surat->id }}">
                                            Tolak
                                        </button>
                                    @endif
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Modal Tolak HANYA UNTUK WAKA --}}
            @if (auth()->user()->role === 'waka')
                <div class="modal fade" id="tolakModal{{ $surat->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('surat.tolak', $surat->id) }}" method="POST">
                            @csrf
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Tolak Surat</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Yakin ingin menolak surat: <strong>{{ $surat->judul }}</strong>?</p>
                                    <div class="mb-3">
                                        <label class="form-label font-weight-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                                        <textarea name="catatan_waka" class="form-control" rows="4" placeholder="Tuliskan alasan penolakan di sini..." required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Tolak Surat</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        @empty
            <div class="col-12">
                <div class="card shadow-sm text-center py-5 border-0">
                    <div class="card-body">
                        <div class="text-muted mb-3">
                            <i class="fas fa-folder-open fa-3x"></i>
                        </div>
                        <h5 class="text-muted">Belum ada data surat.</h5>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($surats->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $surats->links() }}
        </div>
    @endif

</div>
@endsection