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

  {{-- Slider pakai Bootstrap Carousel --}}
    <div id="bannerCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse($banners as $key => $banner)
            <div class="carousel-item {{ $key==0 ? 'active' : '' }}">
                <img src="{{ asset('storage/'.$banner->image_path) }}"
                    class="d-block w-100 rounded"
                    style="height:400px; object-fit:cover;"
                    alt="Banner">
                @if($banner->title)
                <div class="carousel-caption d-none d-md-block bg-transparant bg-opacity-50 rounded">
                    <h5 class="text-light">{{ $banner->title }}</h5>
                </div>
                @endif
            </div>
            @empty
            <div class="carousel-item active">
                <div class="d-flex align-items-center justify-content-center bg-light rounded"
                    style="height:250px;">
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


  <div class="mb-4">
    <h2 class="h4 fw-semibold text-dark">Pengumuman</h2>
  </div>

  {{-- Grid Pengumuman pakai row/col Bootstrap --}}
  <div class="row g-4">
    @forelse($announcements as $a)
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="card-title fw-bold">{{ $a->title }}</h5>
              @if($a->category)
                <span class="badge bg-info">{{ $a->category }}</span>
              @endif
            </div>
            @if($a->starts_at || $a->ends_at)
              <p class="text-muted small mb-2">
                {{ $a->starts_at?->format('d M Y') }}
                @if($a->ends_at) — {{ $a->ends_at->format('d M Y') }} @endif
              </p>
            @endif
            <p class="card-text">
              {{ Str::limit(strip_tags($a->body), 150) }}
            </p>
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
@endsection
