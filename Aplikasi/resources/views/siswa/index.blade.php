@extends('layout.main')

@section('title', 'Data Siswa')

@section('content')

<style>
    .custom-pagination .page-item .page-link {
        border-radius: 50% !important;
        margin: 0 4px;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        color: #495057;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
    }
    .custom-pagination .page-item:first-child .page-link,
    .custom-pagination .page-item:last-child .page-link {
        border-radius: 20px !important;
        width: auto;
        padding: 0 16px;
    }
    .custom-pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
        box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
    }
    .custom-pagination .page-item:hover:not(.active):not(.disabled) .page-link {
        background-color: #e9ecef;
    }
    .custom-pagination .page-item.disabled .page-link {
        background-color: #f8f9fa;
        color: #adb5bd;
        border-color: #e9ecef;
    }
    
    /* Typografi Header Tabel */
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #6c757d;
        font-weight: 700;
        border-bottom: 2px solid #e9ecef;
    }
    .table-responsive {
        overflow: visible !important;
    }
</style>

    <div class="col-md-12">
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            {{-- Header Card --}}
            <div class="card-header bg-white border-bottom py-3 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h4 class="card-title fw-bold m-0 text-dark" style="color: #2b3452 !important;">Data Siswa</h4>
                    
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        {{-- Form Search Bar --}}
                        <form action="{{ route('siswa.index') }}" method="GET" class="m-0">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control px-3" placeholder="Cari Nama/NISN..." value="{{ request('search') }}" aria-label="Search">
                                <button type="submit" class="btn text-white px-3" style="background-color: #6f42c1;" title="Cari">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>

                        {{-- Tombol Tambah --}}
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm text-nowrap">
                                <i class="fa fa-plus me-1"></i> Tambah Siswa
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Body Tabel --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center py-3" width="5%">No</th>
                                <th class="py-3">Nama</th>
                                <th class="text-center py-3">NISN</th>
                                <th class="py-3">Email</th>
                                <th class="text-center py-3">Jenis Kelamin</th>
                                <th class="text-center py-3">Agama</th>
                                <th class="text-center py-3">Tahun Masuk</th>
                                <th class="text-center py-3">Status</th>
                                @if (auth()->user()->role === 'admin')
                                    <th class="text-center py-3">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa as $index => $item)
                                <tr>
                                    <td class="text-center text-muted">{{ $siswa->firstItem() + $index }}</td>
                                    <td class="fw-medium text-dark">{{ $item->user->name ?? '-' }}</td>
                                    <td class="text-center">{{ $item->user->nisn ?? '-' }}</td>
                                    <td class="text-muted">{{ $item->user->email ?? '-' }}</td>
                                    <td class="text-center">{{ $item->jenis_kelamin ?? '-' }}</td>
                                    <td class="text-center">{{ $item->agama ?? '-' }}</td>
                                    <td class="text-center">{{ $item->tahun_masuk ?? '-' }}</td>
                                    <td class="text-center fw-bold
                                        @if ($item->status_siswa == 'aktif') text-success
                                        @elseif($item->status_siswa == 'lulus') text-primary
                                        @else text-warning
                                        @endif">
                                        {{ ucfirst($item->status_siswa) }}
                                    </td>
                                    @if (auth()->user()->role === 'admin')
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light border-0" type="button"
                                                    id="aksiMenu{{ $item->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v text-muted"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="aksiMenu{{ $item->id }}">
                                                    <li>
                                                        <a href="{{ route('siswa.show', $item->id) }}" class="dropdown-item py-2 text-sm">
                                                            <i class="fa fa-eye text-info me-2 w-15px"></i> Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('siswa.edit', $item->id) }}" class="dropdown-item py-2 text-sm">
                                                            <i class="fa fa-edit text-warning me-2 w-15px"></i> Edit
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fa fa-inbox fs-1 mb-3 text-secondary opacity-50"></i>
                                            <span class="fw-medium fs-5">Data siswa tidak ditemukan</span>
                                            <small class="text-muted mt-1">Belum ada data siswa yang diinputkan ke sistem.</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Footer Pagination --}}
            <div class="card-footer bg-white border-top py-3 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap m-0">
                    <p class="text-muted mb-2 mb-md-0 fs-7 m-0">
                        Menampilkan <span class="fw-bold text-dark">{{ $siswa->firstItem() ?? 0 }}</span> sampai <span class="fw-bold text-dark">{{ $siswa->lastItem() ?? 0 }}</span> dari total <span class="fw-bold text-dark">{{ $siswa->total() ?? 0 }}</span> data
                    </p>
                    
                    <div class="d-flex justify-content-center justify-content-md-end m-0">
                        @if ($siswa->hasPages())
                            <div class="custom-pagination">
                                {{-- PERBAIKAN: Menambahkan 'pagination::bootstrap-5' agar panah raksasa hilang --}}
                                {{ $siswa->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                            </div>
                        @else
                            <nav class="custom-pagination">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled" aria-disabled="true">
                                        <span class="page-link">Previous</span>
                                    </li>
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">1</span>
                                    </li>
                                    <li class="page-item disabled" aria-disabled="true">
                                        <span class="page-link">Next</span>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
            
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