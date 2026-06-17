@extends('layout.main')
@section('title', 'Dashboard')

@section('content')
    <style>
        .dashboard-title {
            font-weight: 700;
            color: #1f2937;
        }

        .dashboard-subtitle {
            color: #6b7280;
        }

        .offcanvas.offcanvas-end {
            top: 0 !important;
            margin-top: 0 !important;
            padding-top: 0 !important;
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            width: 650px !important;
        }

        .offcanvas-header {
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
        }

        .offcanvas-body {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .offcanvas-body > .flex-grow-1 {
            overflow-y: auto;
        }

        .banner-wrapper img {
            height: 400px;
            object-fit: cover;
            width: 100%;
            border-radius: 14px;
        }

        .carousel-item .position-relative:hover .edit-btn {
            display: block !important;
        }

        .announcement-header-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        }

        .search-box .form-control {
            border-radius: 999px;
            padding-left: 18px;
            border: 1px solid #dbe1ea;
        }

        .search-box .btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
        }

        .announcement-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.25s ease;
            background: #fff;
        }

        .announcement-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 26px rgba(0, 0, 0, 0.12);
        }

        .announcement-card .card-header {
            background: #fff;
            border-bottom: 1px solid #e9edf3;
            padding: 18px 20px;
        }

        .announcement-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            line-height: 1.4;
        }

        .announcement-body {
            padding: 16px 18px;
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.6;
            min-height: 90px;
        }

        .announcement-date {
            border-top: 1px solid #e9edf3;
            padding: 14px 18px;
            margin-top: auto;
            background: #fff;
        }

        .announcement-date a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .announcement-date a:hover {
            text-decoration: underline;
        }

        .announcement-image-box {
            width: 100%;
            height: 360px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: auto;
            border-bottom: 1px solid #edf1f5;
            position: relative;
        }

        .announcement-image-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            display: block;
            background: #f8fafc;
            transition: transform 0.25s ease;
            transform-origin: center center;
        }

        .card-zoom-control {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.65);
            border-radius: 999px;
            padding: 6px 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 15;
        }

        .card-zoom-control button {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: #fff;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-zoom-control button:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .card-zoom-text {
            color: #fff;
            font-size: 12px;
            min-width: 45px;
            text-align: center;
        }

        .open-image-btn,
        .file-open-btn,
        .detail-open-image-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 42px;
            height: 42px;
            border-radius: 6px;
            border: none;
            background: rgba(0, 0, 0, 0.65);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            z-index: 30;
            transition: 0.2s;
        }

        .open-image-btn:hover,
        .file-open-btn:hover,
        .detail-open-image-btn:hover {
            background: rgba(0, 0, 0, 0.85);
            color: #fff;
        }

        .file-frame-box {
            width: 100%;
            height: 360px;
            background: #f8fafc;
            border-bottom: 1px solid #edf1f5;
            position: relative;
            overflow: hidden;
        }

        .file-frame-box iframe {
            width: 100%;
            height: 100%;
            border: none;
            background: #fff;
        }

        .detail-image-box {
            width: 100%;
            height: 500px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: auto;
            border-radius: 14px;
            margin-bottom: 1rem;
            position: relative;
            border: 1px solid #e5e7eb;
        }

        .detail-image-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            display: block;
            transition: transform 0.25s ease;
            transform-origin: center center;
        }

        .zoom-control {
            position: absolute;
            bottom: 16px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.65);
            border-radius: 999px;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 14px;
            z-index: 10;
        }

        .zoom-control button {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: #fff;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .zoom-control button:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .zoom-text {
            color: #fff;
            font-size: 14px;
            min-width: 55px;
            text-align: center;
        }

        .detail-file-frame-box {
            width: 100%;
            height: 560px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            position: relative;
            margin-bottom: 1rem;
        }

        .detail-file-frame-box iframe {
            width: 100%;
            height: 100%;
            border: none;
            background: #fff;
        }

        /* =======================
            ZOOM PDF & EXCEL
        ======================= */
        .doc-box {
            width: 100%;
            height: 360px;
            background: #f8fafc;
            border-bottom: 1px solid #edf1f5;
            position: relative;
            overflow: auto;
            touch-action: pan-x pan-y;
            -webkit-overflow-scrolling: touch;
        }

        .doc-box iframe {
            border: none;
            background: #fff;
            display: block;
            transform-origin: top left;
        }

        .doc-zoom-content {
            width: 100%;
            height: 100%;
            min-width: 100%;
            min-height: 100%;
        }

        .doc-zoom-content iframe {
            width: 100%;
            height: 100%;
        }

        .doc-zoom-control {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.68);
            border-radius: 999px;
            padding: 6px 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 40;
        }

        .doc-zoom-control button {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: #fff;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .doc-zoom-control button:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .doc-zoom-text {
            color: #fff;
            font-size: 12px;
            min-width: 45px;
            text-align: center;
        }

        .detail-doc-box {
            width: 100%;
            height: 560px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            position: relative;
            overflow: auto;
            margin-bottom: 1rem;
            touch-action: pan-x pan-y;
            -webkit-overflow-scrolling: touch;
        }

        .detail-doc-box iframe {
            border: none;
            background: #fff;
            display: block;
            transform-origin: top left;
        }

        @media (max-width: 768px) {
            .doc-box {
                height: 300px;
            }

            .detail-doc-box {
                height: 430px;
            }

            .doc-zoom-control {
                bottom: 10px;
                padding: 5px 8px;
                gap: 6px;
            }

            .doc-zoom-control button {
                width: 30px;
                height: 30px;
                font-size: 13px;
            }
        }

        @media (max-width: 768px) {
            .announcement-image-box,
            .file-frame-box {
                height: 280px;
            }

            .offcanvas.offcanvas-end {
                width: 100% !important;
            }

            .detail-image-box,
            .detail-file-frame-box {
                height: 420px;
            }
        }
    </style>

    <div class="container-fluid py-4">
        <div class="mb-3">
            <h1 class="h2 dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle mb-0">Informasi SMA Muhammadiyah 2 Palembang</p>
        </div>

        @if (auth()->user()->role === 'admin')
            <div class="mb-4 d-flex gap-2 flex-wrap">
                <a href="{{ route('announcements.create') }}" class="btn btn-primary">
                    Tambah Pengumuman
                </a>

                @if ($banners->count() < 3)
                    <a href="{{ route('banners.create') }}" class="btn btn-primary text-white">
                        Tambah Banner
                    </a>
                @endif
            </div>
        @endif

        {{-- Slider Banner --}}
        @if (!$hideBanner)
            <div id="bannerCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @forelse($banners->take(3) as $key => $banner)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <div class="position-relative banner-wrapper">

                                <button type="button"
                                    class="btn-close position-absolute bg-white p-2"
                                    style="top:10px; right:10px; z-index:10;"
                                    onclick="hideBannerSession()">
                                </button>

                                @php
                                    $bannerPath = $banner->image_path ?? null;
                                    $bannerPath = $bannerPath ? str_replace('storage/', '', $bannerPath) : null;

                                    $bannerImage = $bannerPath
                                        ? url('/storage/' . $bannerPath)
                                        : url('/assets/img/logo.png');
                                @endphp

                                <img src="{{ $bannerImage }}"
                                    class="d-block w-100"
                                    alt="Banner"
                                    onerror="this.onerror=null; this.src='/assets/img/logo.png';">

                                @if (auth()->user()->role === 'admin')
                                    <div class="position-absolute top-50 start-50 translate-middle d-none edit-btn text-center">
                                        <a href="{{ route('banners.edit', $banner->id) }}"
                                            class="btn fw-bold px-4 py-2 fs-5 text-white"
                                            style="background: rgba(0,0,0,0.45); border-radius: 12px;">
                                            <i class="fas fa-pen"></i> EDIT BANNER
                                        </a>
                                    </div>
                                @endif
                            </div>

                            @if ($banner->title)
                                <div class="carousel-caption d-none d-md-block">
                                    <div class="px-3 py-2 rounded" style="background: rgba(0,0,0,0.45);">
                                        <h5 class="text-light mb-0">{{ $banner->title }}</h5>
                                    </div>
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
        @endif

        {{-- Header Pengumuman --}}
        <div class="card announcement-header-card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h2 class="h5 fw-semibold text-dark mb-0">Pengumuman</h2>

                <form action="{{ route('dashboard') }}" method="GET"
                    class="d-flex search-box" style="max-width: 380px; width: 100%;">
                    <input type="text" name="search" class="form-control form-control-lg me-2"
                        placeholder="Cari Pengumuman" value="{{ request('search') }}">

                    <button type="submit"
                        class="btn btn-primary d-flex align-items-center justify-content-center">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- List Pengumuman --}}
        <div class="row g-4">
            @forelse($announcements as $a)
                @php
                    $extension = $a->image_path ? strtolower(pathinfo($a->image_path, PATHINFO_EXTENSION)) : null;

                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                    $isPdf = $extension === 'pdf';
                    $isExcel = in_array($extension, ['xls', 'xlsx', 'csv']);

                    $previewUrl = $a->image_path ? route('announcements.preview', $a->id) : null;
                    $pdfViewerUrl = $a->image_path ? route('announcements.pdfViewer', $a->id) : null;
                    $excelViewerUrl = $a->image_path ? route('announcements.excelViewer', $a->id) : null;
                @endphp

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card announcement-card h-100 d-flex flex-column">

                        <div class="card-header">
                            <h4 class="announcement-title text-truncate" title="{{ $a->title }}">
                                {{ $a->title }}
                            </h4>
                        </div>

                        <div class="card-body p-0 d-flex flex-column">

                            @if ($a->image_path)
                                @if ($isImage)
                                    <div class="announcement-image-box">
                                        <img id="cardZoomImage{{ $a->id }}"
                                            src="{{ $previewUrl }}"
                                            alt="Pengumuman">

                                        <a href="{{ $previewUrl }}"
                                            target="_blank"
                                            class="open-image-btn"
                                            title="Buka gambar di tab baru">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>

                                        <div class="card-zoom-control">
                                            <button type="button" onclick="cardZoomOut('{{ $a->id }}')" title="Zoom Out">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <span class="card-zoom-text" id="cardZoomText{{ $a->id }}">100%</span>

                                            <button type="button" onclick="cardZoomIn('{{ $a->id }}')" title="Zoom In">
                                                <i class="fas fa-plus"></i>
                                            </button>

                                            <button type="button" onclick="cardResetZoom('{{ $a->id }}')" title="Reset Zoom">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                @elseif ($isPdf)
                                    <div class="doc-box">
                                        <div class="doc-zoom-content" id="cardDocContent{{ $a->id }}">
                                            <iframe id="cardDocFrame{{ $a->id }}" src="{{ $pdfViewerUrl }}"></iframe>
                                        </div>

                                        <a href="{{ $pdfViewerUrl }}"
                                            target="_blank"
                                            class="file-open-btn"
                                            title="Buka PDF di tab baru">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>

                                        <div class="doc-zoom-control">
                                            <button type="button" onclick="docZoomOut('card', '{{ $a->id }}')" title="Zoom Out">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <span class="doc-zoom-text" id="cardDocText{{ $a->id }}">100%</span>

                                            <button type="button" onclick="docZoomIn('card', '{{ $a->id }}')" title="Zoom In">
                                                <i class="fas fa-plus"></i>
                                            </button>

                                            <button type="button" onclick="docResetZoom('card', '{{ $a->id }}')" title="Reset Zoom">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                @elseif ($isExcel)
                                    <div class="doc-box">
                                        <div class="doc-zoom-content" id="cardDocContent{{ $a->id }}">
                                            <iframe id="cardDocFrame{{ $a->id }}" src="{{ $excelViewerUrl }}"></iframe>
                                        </div>

                                        <a href="{{ $excelViewerUrl }}"
                                            target="_blank"
                                            class="file-open-btn"
                                            title="Buka Excel di tab baru">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>

                                        <div class="doc-zoom-control">
                                            <button type="button" onclick="docZoomOut('card', '{{ $a->id }}')" title="Zoom Out">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <span class="doc-zoom-text" id="cardDocText{{ $a->id }}">100%</span>

                                            <button type="button" onclick="docZoomIn('card', '{{ $a->id }}')" title="Zoom In">
                                                <i class="fas fa-plus"></i>
                                            </button>

                                            <button type="button" onclick="docResetZoom('card', '{{ $a->id }}')" title="Reset Zoom">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if ($a->body)
                                <div class="announcement-body">
                                    {{ Str::limit(strip_tags($a->body), 160) }}
                                </div>
                            @endif

                            <div class="announcement-date">
                                <a href="#" class="d-inline-flex align-items-center"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#announcementDetail{{ $a->id }}">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    {{ \Carbon\Carbon::parse($a->published_at)->format('Y-m-d') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Detail Offcanvas --}}
                <div class="offcanvas offcanvas-end h-100 p-0" tabindex="-1" id="announcementDetail{{ $a->id }}">
                    <button type="button" class="btn-close rounded-circle shadow-sm position-absolute bg-white"
                        data-bs-dismiss="offcanvas" aria-label="Close"
                        style="z-index:2000; top:10px; left:-60px; width:42px; height:42px;">
                    </button>

                    <div class="offcanvas-header border-bottom py-3 px-4">
                        <h4 class="offcanvas-title fw-semibold mb-0">{{ $a->title }}</h4>
                    </div>

                    <div class="offcanvas-body d-flex flex-column p-0">
                        <div class="p-4 flex-grow-1 overflow-auto">

                            @if ($a->image_path)
                                @if ($isImage)
                                    <div class="detail-image-box">
                                        <img id="zoomImage{{ $a->id }}"
                                            src="{{ $previewUrl }}"
                                            alt="Pengumuman">

                                        <a href="{{ $previewUrl }}"
                                            target="_blank"
                                            class="detail-open-image-btn"
                                            title="Buka gambar di tab baru">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>

                                        <div class="zoom-control">
                                            <button type="button" onclick="zoomOut('{{ $a->id }}')" title="Zoom Out">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <span class="zoom-text" id="zoomText{{ $a->id }}">100%</span>

                                            <button type="button" onclick="zoomIn('{{ $a->id }}')" title="Zoom In">
                                                <i class="fas fa-plus"></i>
                                            </button>

                                            <button type="button" onclick="resetZoom('{{ $a->id }}')" title="Reset Zoom">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                @elseif ($isPdf)
                                    <div class="detail-doc-box">
                                        <div class="doc-zoom-content" id="detailDocContent{{ $a->id }}">
                                            <iframe id="detailDocFrame{{ $a->id }}" src="{{ $pdfViewerUrl }}"></iframe>
                                        </div>

                                        <a href="{{ $pdfViewerUrl }}"
                                            target="_blank"
                                            class="detail-open-image-btn"
                                            title="Buka PDF di tab baru">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>

                                        <div class="doc-zoom-control">
                                            <button type="button" onclick="docZoomOut('detail', '{{ $a->id }}')" title="Zoom Out">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <span class="doc-zoom-text" id="detailDocText{{ $a->id }}">100%</span>

                                            <button type="button" onclick="docZoomIn('detail', '{{ $a->id }}')" title="Zoom In">
                                                <i class="fas fa-plus"></i>
                                            </button>

                                            <button type="button" onclick="docResetZoom('detail', '{{ $a->id }}')" title="Reset Zoom">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                @elseif ($isExcel)
                                    <div class="detail-doc-box">
                                        <div class="doc-zoom-content" id="detailDocContent{{ $a->id }}">
                                            <iframe id="detailDocFrame{{ $a->id }}" src="{{ $excelViewerUrl }}"></iframe>
                                        </div>

                                        <a href="{{ $excelViewerUrl }}"
                                            target="_blank"
                                            class="detail-open-image-btn"
                                            title="Buka Excel di tab baru">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>

                                        <div class="doc-zoom-control">
                                            <button type="button" onclick="docZoomOut('detail', '{{ $a->id }}')" title="Zoom Out">
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <span class="doc-zoom-text" id="detailDocText{{ $a->id }}">100%</span>

                                            <button type="button" onclick="docZoomIn('detail', '{{ $a->id }}')" title="Zoom In">
                                                <i class="fas fa-plus"></i>
                                            </button>

                                            <button type="button" onclick="docResetZoom('detail', '{{ $a->id }}')" title="Reset Zoom">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if ($a->body)
                                <div class="text-muted" style="line-height: 1.8;">
                                    {!! nl2br(e($a->body)) !!}
                                </div>
                            @endif
                        </div>

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
                    <div class="alert alert-secondary text-center rounded-4">
                        Belum ada pengumuman
                    </div>
                </div>
            @endforelse
        </div>

        @if (method_exists($announcements, 'links'))
            <div class="mt-4">
                {{ $announcements->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <script>
        function hideBannerSession() {
            const banner = document.getElementById('bannerCarousel');

            if (banner) {
                banner.style.display = 'none';
            }

            fetch("{{ route('banner.hideSession') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            });
        }

        let zoomLevels = {};

        function getZoom(id) {
            if (!zoomLevels[id]) {
                zoomLevels[id] = 1;
            }

            return zoomLevels[id];
        }

        function applyZoom(id) {
            const image = document.getElementById('zoomImage' + id);
            const text = document.getElementById('zoomText' + id);

            if (!image || !text) return;

            image.style.transform = 'scale(' + zoomLevels[id] + ')';
            text.innerText = Math.round(zoomLevels[id] * 100) + '%';
        }

        function zoomIn(id) {
            getZoom(id);

            if (zoomLevels[id] < 3) {
                zoomLevels[id] += 0.25;
            }

            applyZoom(id);
        }

        function zoomOut(id) {
            getZoom(id);

            if (zoomLevels[id] > 0.5) {
                zoomLevels[id] -= 0.25;
            }

            applyZoom(id);
        }

        function resetZoom(id) {
            zoomLevels[id] = 1;
            applyZoom(id);
        }

        let cardZoomLevels = {};

        function getCardZoom(id) {
            if (!cardZoomLevels[id]) {
                cardZoomLevels[id] = 1;
            }

            return cardZoomLevels[id];
        }

        function applyCardZoom(id) {
            const image = document.getElementById('cardZoomImage' + id);
            const text = document.getElementById('cardZoomText' + id);

            if (!image || !text) return;

            image.style.transform = 'scale(' + cardZoomLevels[id] + ')';
            text.innerText = Math.round(cardZoomLevels[id] * 100) + '%';
        }

        function cardZoomIn(id) {
            getCardZoom(id);

            if (cardZoomLevels[id] < 3) {
                cardZoomLevels[id] += 0.25;
            }

            applyCardZoom(id);
        }

        function cardZoomOut(id) {
            getCardZoom(id);

            if (cardZoomLevels[id] > 0.5) {
                cardZoomLevels[id] -= 0.25;
            }

            applyCardZoom(id);
        }

        function cardResetZoom(id) {
            cardZoomLevels[id] = 1;
            applyCardZoom(id);
        }

        let docZoomLevels = {};

        function getDocKey(prefix, id) {
            return prefix + '_' + id;
        }

        function getDocZoom(prefix, id) {
            const key = getDocKey(prefix, id);

            if (!docZoomLevels[key]) {
                docZoomLevels[key] = 1;
            }

            return docZoomLevels[key];
        }

        function applyDocZoom(prefix, id) {
            const key = getDocKey(prefix, id);
            const zoom = docZoomLevels[key];

            const content = document.getElementById(prefix + 'DocContent' + id);
            const frame = document.getElementById(prefix + 'DocFrame' + id);
            const text = document.getElementById(prefix + 'DocText' + id);

            if (!content || !frame || !text) return;

            content.style.width = (zoom * 100) + '%';
            content.style.height = (zoom * 100) + '%';

            frame.style.width = (100 / zoom) + '%';
            frame.style.height = (100 / zoom) + '%';
            frame.style.transform = 'scale(' + zoom + ')';
            frame.style.transformOrigin = 'top left';

            text.innerText = Math.round(zoom * 100) + '%';
        }

        function docZoomIn(prefix, id) {
            const key = getDocKey(prefix, id);
            getDocZoom(prefix, id);

            if (docZoomLevels[key] < 3) {
                docZoomLevels[key] += 0.25;
            }

            applyDocZoom(prefix, id);
        }

        function docZoomOut(prefix, id) {
            const key = getDocKey(prefix, id);
            getDocZoom(prefix, id);

            if (docZoomLevels[key] > 0.5) {
                docZoomLevels[key] -= 0.25;
            }

            applyDocZoom(prefix, id);
        }

        function docResetZoom(prefix, id) {
            const key = getDocKey(prefix, id);

            docZoomLevels[key] = 1;
            applyDocZoom(prefix, id);
        }
    </script>
@endsection