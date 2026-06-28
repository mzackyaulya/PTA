@extends('layout.main')

@section('title', 'Data Guru')

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

    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #6c757d;
        font-weight: 700;
        border-bottom: 2px solid #e9ecef;
        white-space: nowrap;
    }

    /* Memastikan dropdown aksi tidak terpotong kontainer tabel */
    .table-responsive {
        overflow-x: auto !important;
        overflow-y: visible !important;
    }
</style>

{{-- PERBAIKAN: Dibungkus dengan row agar grid Bootstrap merentang penuh secara presisi --}}
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3 mb-4 w-100">
            {{-- Header Card --}}
            <div class="card-header bg-white border-bottom py-3 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h4 class="card-title fw-bold m-0" style="color: #2b3452 !important;">Data Guru</h4>

                    <div class="d-flex align-items-center flex-wrap gap-2">
                        {{-- Form Search Bar --}}
                        <form action="{{ route('guru.index') }}" method="GET" class="m-0">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control px-3"
                                    placeholder="Cari Nama/NIP..." value="{{ request('search') }}" aria-label="Search">
                                <button type="submit" class="btn text-white px-3"
                                    style="background-color: #6f42c1;" title="Cari">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>

                        {{-- Tombol Tambah --}}
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('guru.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm text-nowrap">
                                <i class="fa fa-plus me-1"></i> Tambah Guru
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Body Tabel --}}
            <div class="card-body p-0">
                <div class="table-responsive w-100">
                    {{-- PERBAIKAN: Menggunakan class table-layout fixed bawaan/custom jika diperlukan, namun default bootstrap .w-100 akan memaksa melebar penuh --}}
                    <table class="table table-hover align-middle mb-0 w-100">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center py-3" width="4%">No</th>
                                <th class="py-3" width="18%">Nama</th>
                                <th class="text-center py-3" width="10%">NIP</th>
                                <th class="py-3" width="15%">Email</th>
                                <th class="text-center py-3" width="12%">Jenis Kelamin</th>
                                <th class="text-center py-3" width="8%">Agama</th>
                                <th class="text-center py-3" width="8%">Pendidikan</th>
                                <th class="text-center py-3" width="10%">Status Pegawai</th>
                                <th class="py-3" width="12%">Mapel</th>
                                <th class="text-center py-3" width="8%">Status</th>
                                @if (auth()->user()->role === 'admin')
                                    <th class="text-center py-3" width="5%">Aksi</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($guru as $index => $item)
                                <tr>
                                    <td class="text-center text-muted">
                                        {{ method_exists($guru, 'firstItem') ? $guru->firstItem() + $index : $index + 1 }}
                                    </td>

                                    <td class="fw-medium text-dark text-nowrap">
                                        {{ $item->nama ?? $item->user->name ?? '-' }}
                                    </td>

                                    <td class="text-center text-nowrap">
                                        {{ $item->nip ?? $item->user->nip ?? '-' }}
                                    </td>

                                    <td class="text-muted text-nowrap">
                                        {{ $item->email ?? $item->user->email ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->jenis_kelamin ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->agama ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->pendidikan_terakhir ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->status_kepegawaian ?? '-' }}
                                    </td>

                                    <td class="text-nowrap">
                                        {{ $item->mapel ?? '-' }}
                                    </td>

                                    <td class="text-center fw-bold
                                        @if ($item->status_guru == 'aktif') text-success
                                        @elseif($item->status_guru == 'nonaktif') text-warning
                                        @else text-primary
                                        @endif">
                                        {{ ucfirst($item->status_guru ?? '-') }}
                                    </td>

                                    @if (auth()->user()->role === 'admin')
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light border-0" type="button"
                                                    id="aksiMenu{{ $item->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v text-muted"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                                                    aria-labelledby="aksiMenu{{ $item->id }}">
                                                    <li>
                                                        <a href="{{ route('guru.show', $item->id) }}"
                                                            class="dropdown-item py-2 text-sm">
                                                            <i class="fa fa-eye text-info me-2 w-15px"></i> Detail
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('guru.edit', $item->id) }}"
                                                            class="dropdown-item py-2 text-sm">
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
                                    <td colspan="{{ auth()->user()->role === 'admin' ? 11 : 10 }}"
                                        class="text-center text-muted py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fa fa-inbox fs-1 mb-3 text-secondary opacity-50"></i>
                                            <span class="fw-medium fs-5">Data guru tidak ditemukan</span>
                                            <small class="text-muted mt-1">Belum ada data guru yang diinputkan ke sistem.</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Footer / Pagination --}}
            <div class="card-footer bg-white border-top py-3 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap m-0">
                    <p class="text-muted mb-2 mb-md-0 fs-7 m-0">
                        Menampilkan
                        <span class="fw-bold text-dark">{{ method_exists($guru, 'firstItem') ? $guru->firstItem() ?? 0 : 1 }}</span>
                        sampai
                        <span class="fw-bold text-dark">{{ method_exists($guru, 'lastItem') ? $guru->lastItem() ?? count($guru) : count($guru) }}</span>
                        dari total
                        <span class="fw-bold text-dark">{{ method_exists($guru, 'total') ? $guru->total() ?? 0 : count($guru) }}</span>
                        data
                    </p>

                    <div class="d-flex justify-content-center justify-content-md-end m-0">
                        @if (method_exists($guru, 'hasPages') && $guru->hasPages())
                            <div class="custom-pagination">
                                {{ $guru->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
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
                timerProgressBar: true,
                toast: true,
                position: 'top-end'
            });
        });
    </script>
@endif

@endsection