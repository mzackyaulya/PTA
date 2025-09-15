@extends('layout.main')
@section('title','Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-2">
        <h1 class="h2 fw-bold text-dark">Dashboard</h1>
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
                        <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-transparant fw-bold px-4 py-2 fs-5 text-white">
                            <i class="fas fa-pen"></i> EDIT BANNER
                        </a>
                    </div>
                </div>
                @if($banner->title)
                <div class="carousel-caption d-none d-md-block bg-transparant bg-opacity-50 rounded">
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
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h2 class="h5 fw-semibold text-dark mb-0">Pengumuman</h2>

            {{-- Search box --}}
            <form action="{{ route('announcements.index') }}" method="GET" class="d-flex" style="max-width: 350px;">
                <input type="text"
                    name="search"
                    class="form-control form-control-lg rounded-pill me-2"
                    placeholder="Cari Pengumuman"
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>


    <div class="row g-4">
        @forelse($announcements as $a)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm d-flex flex-column">

                {{-- Judul (1 baris, kecil) --}}
                <div class="card-header border-bottom">
                    <h4 class="card-title fw-semibold text-dark text-truncate mb-0" style="font-size: 1.4rem;">
                        {{ $a->title }}
                    </h4>
                </div>

                {{-- Isi card --}}
                <div class="card-body p-0 d-flex flex-column">

                    {{-- Gambar (dibesarkan, tidak lewat tanggal) --}}
                    @if($a->image_path)
                        <div style="flex-grow:1; max-height:250px; overflow:hidden;">
                            <img src="{{ asset('storage/'.$a->image_path) }}"
                                class="w-100"
                                style="object-fit:cover; height:100%;"
                                alt="Pengumuman">
                        </div>
                    @endif

                    {{-- Isi text ringkas --}}
                    @if($a->body)
                        <div class="p-3">
                            <p class="card-text text-muted mb-0" style="font-size: 0.85rem;">
                                {{ Str::limit(strip_tags($a->body), 80) }}
                            </p>
                        </div>
                    @endif

                    {{-- Bagian tanggal --}}
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


        <div class="offcanvas offcanvas-end h-100 p-0" tabindex="-1" id="announcementDetail{{ $a->id }}">
            {{-- Tombol Close di luar kiri atas --}}
            <button type="button"
                    class="btn-close rounded-circle shadow-sm position-absolute bg-white"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
                    style="z-index:2000; top:10px; left:-60px; width:42px; height:42px;">
            </button>

            {{-- Header langsung nempel atas --}}
            <div class="offcanvas-header border-bottom py-2">
                <h4 class="offcanvas-title fw-semibold mb-0">{{ $a->title }}</h4>
            </div>

            {{-- Body scrollable --}}
            <div class="offcanvas-body d-flex flex-column p-0">

                {{-- Konten utama (scroll kalau panjang) --}}
                <div class="p-3 flex-grow-1 overflow-auto">
                    @if($a->image_path)
                        <img src="{{ asset('storage/'.$a->image_path) }}" class="img-fluid mb-3 rounded">
                    @endif

                    @if($a->body)
                        <p class="text-muted">{{ $a->body }}</p>
                    @endif
                </div>

                {{-- Footer tanggal, selalu di bawah --}}
                <div class="border-top p-3 bg-light">
                    <span class="text-muted d-flex align-items-center">
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        {{ \Carbon\Carbon::parse($a->published_at)->translatedFormat('d M Y') }}
                    </span>
                </div>
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
/* === Offcanvas full === */
.offcanvas.offcanvas-end {
    top: 0 !important;              /* full sampai atas */
    margin-top: 0 !important;       /* hilangkan jarak atas */
    padding-top: 0 !important;      /* hilangkan padding atas */
    border-top-left-radius: 0 !important;
    border-top-right-radius: 0 !important;
}
.offcanvas-header {
    padding-top: 0.5rem;            /* header rapat */
    padding-bottom: 0.5rem;
}
.offcanvas-body {
    display: flex;
    flex-direction: column;
    height: 100%;
}
.offcanvas-body > .flex-grow-1 {
    overflow-y: auto;               /* scroll kalau konten panjang */
}

/* === Carousel edit button === */
.carousel-item .position-relative:hover .edit-btn {
    display: block !important;
}
</style>
@endsection
