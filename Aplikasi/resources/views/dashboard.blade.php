@extends('layout.main')
@section('title','Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-2">
        <h1 class="h3 fw-bold text-dark">Dashboard</h1>
        <p class="text-muted">Informasi SMA Muhammadiyah 2 Palembang</p>
    </div>

    <div class="mb-4 d-flex gap-2">
        <a href="{{ route('announcements.create') }}" class="btn btn-primary">
            Tambah Pengumuman
        </a>
        <a href="{{ route('banners.create') }}" class="btn btn-primary text-white">
            Tambah Banner
        </a>
    </div>

    {{-- Slider Banner --}}
    <div id="bannerCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse($banners->take(3) as $key => $banner)
            <div class="carousel-item {{ $key==0 ? 'active' : '' }}">
                <div class="position-relative">
                    <img src="{{ asset('storage/'.$banner->image_path) }}"
                        class="d-block w-100 rounded"
                        style="height:400px; object-fit:cover;"
                        alt="Banner">
                    <div class="position-absolute top-50 start-50 translate-middle d-none edit-btn text-center">
                        <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-dark fw-bold px-4 py-2 fs-5 shadow">
                            <i class="fas fa-pen"></i> EDIT BANNER
                        </a>
                    </div>
                </div>
                @if($banner->title)
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                    <h5 class="text-light">{{ $banner->title }}</h5>
                </div>
                @endif
            </div>
            @empty
            <div class="carousel-item active">
                <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height:250px;">
                    <span class="text-muted">Belum ada banner</span>
                </div>
            </div>
            @endforelse
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    {{-- Section Pengumuman --}}
    <div class="mb-4">
        <h2 class="h4 fw-semibold text-dark">Pengumuman</h2>
    </div>

    <div class="row g-4">
        @forelse($announcements as $a)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">

                {{-- Judul + Garis bawah --}}
                <div class="card-header border-bottom">
                    <h5 class="card-title fw-bold mb-0">{{ $a->title }}</h5>
                </div>

                {{-- Isi card --}}
                <div class="card-body p-0 d-flex flex-column">

                    {{-- Jika gambar (full, no rounded) --}}
                    @if($a->image_path)
                        <img src="{{ asset('storage/'.$a->image_path) }}"
                             class="w-100"
                             style="object-fit:cover; max-height:200px;"
                             alt="Pengumuman">
                    @endif

                    {{-- Jika text --}}
                    @if($a->body)
                        <div class="p-3">
                            <p class="card-text text-muted mb-0">
                                {{ Str::limit(strip_tags($a->body), 100) }}
                            </p>
                        </div>
                    @endif

                    {{-- Tanggal (full garis atas) --}}
                    <div class="border-top p-3 mt-auto">
                        <a href="#"
                           class="d-inline-flex align-items-center text-primary text-decoration-none"
                           data-bs-toggle="offcanvas"
                           data-bs-target="#announcementDetail{{ $a->id }}">
                            <i class="fas fa-calendar-alt me-2"></i>
                            {{ \Carbon\Carbon::parse($a->published_at)->format('Y-m-d') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Offcanvas Detail --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="announcementDetail{{ $a->id }}">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">{{ $a->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                @if($a->image_path)
                    <img src="{{ asset('storage/'.$a->image_path) }}" class="img-fluid mb-3" alt="Detail Pengumuman">
                @endif
                @if($a->body)
                    <p>{{ $a->body }}</p>
                @endif
                <p class="text-muted mt-3">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ \Carbon\Carbon::parse($a->published_at)->format('d M Y') }}
                </p>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-secondary text-center">Belum ada pengumuman</div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(method_exists($announcements,'links'))
    <div class="mt-4">
        {{ $announcements->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

{{-- CSS tambahan --}}
<style>
  .carousel-item .position-relative:hover .edit-btn {
      display: block !important;
  }
</style>
@endsection
