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

                        @if (auth()->user()->role === 'admin')
                            {{-- PERBAIKAN: Mengubah data-bs-target menjadi #importExcelModal agar sesuai dengan ID modal di bawah --}}
                            <button type="button" class="btn btn-success btn-sm px-3 shadow-sm text-nowrap" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                                <i class="fa fa-file-excel me-1"></i> Import Excel
                            </button>
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
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border-0" type="button"
                                                id="aksiMenu{{ $item->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa fa-ellipsis-v text-muted"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="aksiMenu{{ $item->id }}">
                                                @if (in_array(auth()->user()->role, ['admin', 'waka']))
                                                    <li>
                                                        <a href="{{ route('siswa.show', $item->id) }}" class="dropdown-item py-2 text-sm">
                                                            <i class="fa fa-eye text-info me-2 w-15px"></i> Detail
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (auth()->user()->role === 'admin')
                                                    <li>
                                                        <a href="{{ route('siswa.edit', $item->id) }}" class="dropdown-item py-2 text-sm">
                                                            <i class="fa fa-edit text-warning me-2 w-15px"></i> Edit
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
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
@endsection

{{-- MODAL & SCRIPT DI LETAKKAN DI LUAR @endsection UNTUK MENCEGAH BUG BACKDROP CODES FREEZE --}}
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importExcelModalLabel">Import Data Siswa via Excel</h5>
                <button type="button" class="btn-close" data-bs-close="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="file_excel" class="form-label">Pilih File Excel (.xlsx, .xls)</label>
                        <input type="file" name="file_excel" class="form-control" id="file_excel" required>
                    </div>
                    <div class="text-muted small">
                        *Pastikan format kolom Excel sudah sesuai urutan data siswa.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-close="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Mulai Import</button>
                </div>
            </form>
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

@if (session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                showConfirmButton: true
            });
        });
    </script>
@endif