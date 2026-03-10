<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ url('assets/img/logoweb.png') }}" type="image/x-icon" />


    <!-- Fonts and icons -->
    <script src="{{ url('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
            families: [
                "Public Sans:300,400,500,600,700",
                "Playfair Display:700",
                "Poppins:600"
            ]
            },
            custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["{{ url('assets/css/fonts.min.css') }}"],
            },
            active: function () {
            sessionStorage.fonts = true;
            },
        });
    </script>


    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/kaiadmin.min.css') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ url('assets/css/demo.css') }}" />
  </head>
  <body>
    <div class="wrapper">
        <div class="sidebar" style="background-color:#155b31;">
            <style>
                /* =========================
                    STYLE SIDEBAR FIX
                ========================= */

                /* Wrapper konten utama */
                .wrapper .main-panel {
                    background-color: #f5f6fa;
                    margin-left: 0;
                    padding-left: 0;
                    margin-top: 0;
                    padding-top: 0;
                }

                /* =========================
                  MENU UTAMA (NORMAL STATE)
                ========================= */

                .sidebar {
                    background-color: #155b31;
                }

                /* jarak antar menu */
                .sidebar .nav .nav-item{
                    padding:4px 10px;
                }

                /* style menu */
                .sidebar .nav .nav-item a{
                    color:#ffffff !important;
                    text-decoration:none;

                    display:flex;
                    align-items:center;
                    gap:8px;

                    padding:10px 15px;

                    border-radius:10px;
                    margin:4px 6px;

                    position:relative;
                    z-index:1;

                    transition:all .2s ease;
                }

                /* =========================
                        HOVER STATE
                ========================= */

                .sidebar .nav .nav-item a:hover,
                .sidebar .nav .nav-item a:hover i,
                .sidebar .nav .nav-item a:hover p{
                    background-color:#198754 !important;
                    color:#ffffff !important;
                    border-radius:10px;
                }

                /* Hover submenu */
                .sidebar .nav .nav-collapse li a:hover,
                .sidebar .nav .nav-collapse li a:hover i,
                .sidebar .nav .nav-collapse li a:hover span{
                    background-color:#29d843 !important;
                    color:#ffffff !important;
                    border-radius:8px;
                }

                /* =========================
                        MENU AKTIF
                ========================= */

                .sidebar .nav .nav-item a.active{
                    background-color:#198754 !important;
                    color:#ffffff !important;
                    font-weight:bold;

                    border-radius:10px !important;
                    margin:4px 6px !important;

                    position:relative;
                    z-index:20;

                    overflow:hidden;
                }

                /* hilangkan cekungan segitiga */
                .sidebar .nav .nav-item a.active::after{
                    display:none !important;
                }

                /* =========================
                        PARENT MENU
                ========================= */

                .sidebar .nav .nav-item a.parent-menu.active::after{
                    display:none !important;
                }

                /* =========================
                        SUBMENU STATE
                ========================= */

                .sidebar .nav .nav-collapse li.active > a,
                .sidebar .nav .nav-collapse li.active > a span,
                .sidebar .nav .nav-collapse li.active > a i{
                    background-color:#46bc52 !important;
                    color:#ffffff !important;

                    border-radius:8px;
                    margin:2px 6px;
                }

                /* =========================
                        CARET ICON
                ========================= */

                .sidebar .nav .nav-item a{
                    display:flex;
                    align-items:center;
                }

                /* caret dropdown */
                .sidebar .nav .nav-item a .caret{
                    margin-left:auto;

                    display:inline-block !important;

                    width:0;
                    height:0;

                    border-left:5px solid transparent;
                    border-right:5px solid transparent;
                    border-top:6px solid #ffffff;
                }

                /* =========================
                    CARET DROPDOWN DIRECTION
                ========================= */

                /* default (menu tertutup) → kanan */
                .sidebar .nav .nav-item a .caret{
                    margin-left:auto;
                    width:0;
                    height:0;
                    border-top:5px solid transparent;
                    border-bottom:5px solid transparent;
                    border-left:6px solid #ffffff;
                    transition:0.1s;
                }

                /* saat menu terbuka → bawah */
                .sidebar .nav .nav-item a[aria-expanded="true"] .caret{
                    border-left:5px solid transparent;
                    border-right:5px solid transparent;
                    border-top:6px solid #ffffff;
                    border-bottom:0;
                }

                /* menu utama tetap rata */
                .sidebar .nav .nav-item > a{
                    padding-left:15px !important;
                }

                /* submenu masuk sedikit */
                .sidebar .nav-collapse li a{
                    padding-left:35px !important;
                }

                /* =========================
                    PARENT MENU ACTIVE
                ========================= */

                .sidebar .nav .nav-item a[aria-expanded="true"],
                .sidebar .nav .nav-item a[aria-expanded="true"] i,
                .sidebar .nav .nav-item a[aria-expanded="true"] p{
                    color:#ffffff !important;
                    font-weight:bold;
                }

                /* =========================
                    SUBMENU TERBUKA
                ========================= */

                .sidebar .nav .nav-item .collapse.show a,
                .sidebar .nav .nav-item .collapse.show a i,
                .sidebar .nav .nav-item .collapse.show a span,
                .sidebar .nav .nav-item .collapse.show a p{
                    color:#ffffff !important;
                }

                /* =========================
                        OVERFLOW FIX
                ========================= */

                .sidebar,
                .sidebar .nav,
                .sidebar .nav .nav-item{
                    overflow:visible !important;
                }

                /* =========================
                        MAIN PANEL
                ========================= */

                .main-panel{
                    margin-left:260px;
                    background-color:#f5f6fa;
                    position:relative;
                    z-index:1;
                }

                /* =========================
                SUBMENU STYLE SEPERTI MENU UTAMA
                ========================= */

                .sidebar .nav-collapse li{
                    padding:4px 10px;
                }

                /* submenu tampil seperti menu utama */
                .sidebar .nav-collapse li a{
                    display:flex;
                    align-items:center;
                    gap:8px;

                    padding:10px 15px !important;

                    margin:4px 6px !important;
                    border-radius:10px !important;

                    transition:all .2s ease;
                }

                /* hover submenu */
                .sidebar .nav-collapse li a:hover{
                    background:#198754 !important;
                }

                /* submenu aktif */
                .sidebar .nav-collapse li a.active{
                    background:#198754 !important;
                }
                /* =========================
                FIX JARAK DROPDOWN MENU
                ========================= */

                /* hilangkan ruang kosong dropdown */
                .sidebar .collapse{
                    padding-top:4px !important;
                    padding-bottom:4px !important;
                }

                /* rapikan jarak item submenu */
                .sidebar .nav-collapse li{
                    margin-bottom:2px;
                }

                /* pastikan submenu tidak terlalu tinggi */
                .sidebar .nav-collapse{
                    padding-top:2px;
                    padding-bottom:2px;
                }

                /* =========================
                FIX JARAK DROPDOWN JADWAL
                ========================= */

                /* rapikan container dropdown */
                .sidebar .nav-collapse{
                    padding-top:4px !important;
                    padding-bottom:4px !important;
                }

                /* hilangkan margin besar antar item */
                .sidebar .nav-collapse li{
                    margin-bottom:4px !important;
                }

                /* hilangkan ruang kosong setelah dropdown */
                .sidebar .nav-item .collapse{
                    margin-bottom:4px !important;
                }

                /* pastikan item terakhir tidak menambah jarak */
                .sidebar .nav-collapse li:last-child{
                    margin-bottom:0 !important;
                }
                /* =========================
                FIX SPACE DROPDOWN JADWAL
                ========================= */

                /* hilangkan tinggi container collapse */
                .sidebar .nav-collapse .collapse{
                    padding:0 !important;
                    margin:0 !important;
                }

                /* hilangkan margin nav-item di dalam submenu */
                .sidebar .nav-collapse .nav-item{
                    padding:0 !important;
                    margin:0 !important;
                }

                /* rapikan jarak item */
                .sidebar .nav-collapse li{
                    margin-bottom:4px !important;
                }

                /* item terakhir tidak menambah jarak */
                .sidebar .nav-collapse li:last-child{
                    margin-bottom:0 !important;
                }
                /* FIX SPACE JADWAL DROPDOWN */

                #jadwal{
                    padding-top:4px !important;
                    padding-bottom:4px !important;
                }

                #jadwal .nav{
                    margin:0 !important;
                    padding:0 !important;
                }

                #jadwal li{
                    margin:2px 0 !important;
                }

                #qr-container svg{
                    background:#fff;
                    padding:10px;
                    border-radius:10px;
                }

                .modal-dialog{
                    max-width:420px;
                }
                /* FIX MODAL BOOTSTRAP */
                .modal{
                    z-index:99999 !important;
                }

                .modal-backdrop{
                    z-index:99998 !important;
                }
            </style>

            <div class="sidebar-logo">
            <!-- Logo Header -->
            <div class="logo-header d-flex justify-content-end align-items-center">
                <a href="#" class="logo">
                <img
                    src="{{ url('assets/img/LogoSekolah.png') }}"
                    alt="navbar brand"
                    class="navbar-brand"
                    height="140px"
                    width="250px"
                />
                </a>
                <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
                </div>
                <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
                </button>
            </div>
            <!-- End Logo Header -->
            </div>
            {{-- SideBar --}}
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item mb-2">
                            <a href="{{ url('dashboard')}}" class="{{ request()->is('dashboard*') ? 'active' : '' }}">
                                <i class="fas fa-home text-white"></i>
                                <p class="text-white">Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ url('profile')}}" class="{{ request()->is('profile') ? 'active' : '' }}">
                                <i class="fas fa-user text-white"></i>
                                <p class="text-white">Profile</p>
                            </a>
                        </li>

                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item mb-2">
                                <a data-bs-toggle="collapse"
                                href="#data"
                                class="parent-menu {{ request()->is('siswa*') || request()->is('guru*') || request()->is('kelas*') || request()->is('mapel*') ? 'active' : '' }}"
                                aria-expanded="{{ request()->is('siswa*') || request()->is('guru*') || request()->is('kelas*') || request()->is('mapel*') ? 'true' : 'false' }}">
                                    <i class="fas fa-layer-group text-white"></i>
                                    <p class="text-white">Data Master</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse px-4 {{ request()->is('siswa*') || request()->is('guru*') || request()->is('kelas*') || request()->is('mapel*') ? 'show' : '' }}" id="data">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('siswa.index') }}">
                                                <i class="fas fa-user-check"></i>
                                                <span>Data Siswa</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('guru.index') }}">
                                                <i class="fas fa-chalkboard-teacher"></i>
                                                <span>Data Guru</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('kelas.index') }}">
                                                <i class="fas fa-door-open"></i>
                                                <span>Data Kelas</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('mapel.index') }}">
                                                <i class="fas fa-list"></i>
                                                <span>Data Mata Pelajaran</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item mb-2">
                                <a data-bs-toggle="collapse"
                                href="#akademik"
                                class="parent-menu {{ request()->is('tahunajaran*') || request()->is('riwayatkelas*') || request()->is('mengajar*') ? 'active' : '' }}"
                                aria-expanded="{{ request()->is('tahunajaran*') || request()->is('riwayatkelas*') || request()->is('mengajar*') ? 'true' : 'false' }}">
                                    <i class="fas fa-school text-white"></i>
                                    <p class="text-white">Akademik</p>
                                    <span class="caret"></span>
                                </a>

                                <div class="collapse px-4 {{ request()->is('tahunajaran*') || request()->is('riwayatkelas*') || request()->is('mengajar*') ? 'show' : '' }}" id="akademik">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="{{ route('tahunajaran.index') }}">
                                                <i class="fas fa-calendar"></i>
                                                <span>Tahun Ajaran</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('riwayatkelas.index') }}">
                                                <i class="fas fa-users"></i>
                                                <span>Penempatan Siswa</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('mengajar.index') }}">
                                                <i class="fas fa-chalkboard"></i>
                                                <span>Jadwal Mengajar</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                        <li class="nav-item mb-2">

                            <a data-bs-toggle="collapse"
                            href="#belajar"
                            class="parent-menu {{ request()->is('absensi*') || request()->is('jadwal*') || request()->is('materi*') || request()->is('tahfiz*') ? 'active' : '' }}">

                                <i class="fas fa-layer-group text-white"></i>
                                <p class="text-white">Pembelajaran</p>
                                <span class="caret"></span>

                            </a>

                            <div class="collapse px-4 {{ request()->is('absensi*') || request()->is('jadwal*') || request()->is('materi*') || request()->is('tahfiz*') ? 'show' : '' }}"
                                id="belajar">

                                <ul class="nav nav-collapse">

                                    {{-- =======================
                                            ABSENSI
                                    ======================= --}}

                                    {{-- ADMIN --}}
                                    @if(auth()->user()->role === 'admin')

                                        <li>
                                            <a href="{{ route('pertemuan.index') }}"
                                            class="{{ request()->is('admin/pertemuan*') ? 'active' : '' }}">
                                                <i class="fas fa-calendar-check"></i>
                                                <span>Pertemuan Absensi</span>
                                            </a>
                                        </li>

                                    @endif


                                    {{-- GURU --}}
                                    @if(auth()->user()->role === 'guru')

                                        <li>
                                            <a href="{{ route('absensi.guru') }}"
                                            class="{{ request()->is('guru/absensi*') ? 'active' : '' }}">
                                                <i class="fas fa-user-check"></i>
                                                <span>Absensi</span>
                                            </a>
                                        </li>

                                    @endif


                                    {{-- SISWA --}}
                                    @if(auth()->user()->role === 'siswa')

                                        <li>
                                            <a href="{{ route('absensi.siswa') }}"
                                            class="{{ request()->is('siswa/absensi*') ? 'active' : '' }}">
                                                <i class="fas fa-user-check"></i>
                                                <span>Absensi</span>
                                            </a>
                                        </li>

                                    @endif

                                    {{-- =======================
                                            JADWAL
                                    ======================= --}}
                                    @if(auth()->user()->role === 'admin')

                                    <li>

                                        <a data-bs-toggle="collapse"
                                            href="#jadwal"
                                            class="{{ request()->is('jadwal*') ? 'active' : '' }}">

                                            <i class="fas fa-calendar-alt"></i>
                                            <span>Jadwal</span>
                                            <span class="caret"></span>

                                        </a>

                                        <div class="collapse {{ request()->is('jadwal*') ? 'show' : '' }}" id="jadwal">

                                            <ul class="nav nav-collapse">

                                                <li>
                                                    <a href="{{ route('jadwal.guru.list') }}">
                                                        <i class="fas fa-chalkboard-teacher"></i>
                                                        <span>List Guru</span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ route('jadwal.siswa.list') }}">
                                                        <i class="fas fa-user-graduate"></i>
                                                        <span>List Siswa</span>
                                                    </a>
                                                </li>

                                            </ul>

                                        </div>

                                    </li>

                                    @endif


                                    @if(auth()->user()->role === 'guru')

                                        <li>
                                            <a href="{{ route('jadwal.guru', auth()->user()->guru->id) }}"
                                            class="{{ request()->is('jadwal*') ? 'active' : '' }}">
                                                <i class="fas fa-calendar-alt"></i>
                                                <span>Jadwal</span>
                                            </a>
                                        </li>

                                    @endif


                                    @if(auth()->user()->role === 'siswa')

                                        <li>
                                            <a href="{{ route('jadwal.siswa', auth()->user()->siswa->id) }}"
                                            class="{{ request()->is('jadwal*') ? 'active' : '' }}">
                                                <i class="fas fa-calendar-alt"></i>
                                                <span>Jadwal</span>
                                            </a>
                                        </li>

                                    @endif


                                    {{-- =======================
                                            MATERI
                                    ======================= --}}

                                    @if(auth()->user()->role === 'guru')
                                    <li>
                                        <a href="{{ route('materi.guru.index') }}"
                                        class="{{ request()->is('guru/materi*') ? 'active' : '' }}">
                                            <i class="fas fa-book"></i>
                                            <span>Materi</span>
                                        </a>
                                    </li>
                                    @endif

                                    @if(auth()->user()->role === 'siswa')
                                    <li>
                                        <a href="{{ route('materi.siswa.index') }}"
                                        class="{{ request()->is('siswa/materi*') ? 'active' : '' }}">
                                            <i class="fas fa-book"></i>
                                            <span>Materi</span>
                                        </a>
                                    </li>
                                    @endif
                                </ul>

                            </div>

                        </li>

                        {{-- =======================
                                    NILAI
                        ======================= --}}

                        @if(auth()->user()->role == 'admin')
                            <li class="nav-item mb-2">
                                <a href="{{ url('admin/nilai') }}"
                                class="{{ request()->is('admin/nilai*') ? 'active' : '' }}">
                                    <i class="fas fa-chart-bar text-white"></i>
                                    <p class="text-white">Nilai</p>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role == 'guru')
                            <li class="nav-item mb-2">
                                <a href="{{ url('guru/nilai') }}"
                                class="{{ request()->is('guru/nilai*') ? 'active' : '' }}">
                                    <i class="fas fa-chart-bar text-white"></i>
                                    <p class="text-white">Nilai</p>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role == 'siswa')
                            <li class="nav-item mb-2">
                                <a href="{{ url('siswa/nilai') }}"
                                class="{{ request()->is('siswa/nilai*') ? 'active' : '' }}">
                                    <i class="fas fa-chart-bar text-white"></i>
                                    <p class="text-white">Nilai</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" style="background-color:#155b31; color:#fff;">
              <a href="#" class="logo">
                <img
                  src="{{ url('assets/img/LogoSekolah.png') }}"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" style="background-color:#155b31;">
            <div class="container-fluid" >
              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="notifDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fa fa-bell"></i>
                    <span class="notification">4</span>
                  </a>
                  <ul
                    class="dropdown-menu notif-box animated fadeIn"
                    aria-labelledby="notifDropdown"
                  >
                    <li>
                      <div class="dropdown-title">
                        You have 4 new notification
                      </div>
                    </li>
                    <li>
                      <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          <a href="#">
                            <div class="notif-icon notif-danger">
                              <i class="fa fa-heart"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block"> Farrah liked Admin </span>
                              <span class="time">17 minutes ago</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </li>
                    <li>
                      <a class="see-all" href="javascript:void(0);"
                        >See all notifications<i class="fa fa-angle-right"></i>
                      </a>
                    </li>
                  </ul>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                        <img
                            src="{{ auth()->check() && auth()->user()?->siswa?->foto
                                    ? asset('storage/'.auth()->user()->siswa->foto)
                                    : url('assets/img/admin.png') }}"
                            alt="Foto Profil"
                            class="avatar-img rounded-circle"
                        />
                    </div>
                    <span class="profile-username">
                      <span class="text-white fw-bold">{{ Auth::user()->name }}</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user rounded animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    <img
                                        src="{{ optional(auth()->user()->siswa)->foto
                                                ? asset('storage/'.auth()->user()->siswa->foto)
                                                : url('assets/img/admin.png') }}"
                                        alt="image profile"
                                        class="avatar-img rounded"
                                    />
                                </div>
                                <div class="u-text">
                                    <h4>{{ Auth::user()->name }}</h4>
                                    <p class="text-muted">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item mb-1" href="{{ url('profile') }}"><i class="fas fa-user-circle me-2"></i>Profile</a>
                        <a class="dropdown-item mb-1" href="#"><i class="fas fa-unlock me-2"></i>Ganti Sandi</a>
                        <a class="dropdown-item mb-1" href="#"><i class="fas fa-info-circle me-2"></i>Inbox</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off me-2"></i>
                            <span class="align-middle">Keluar</span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">
            @yield('content')
          </div>
        </div>
      </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ url('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    

    <!-- jQuery Scrollbar -->
    <script src="{{ url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ url('assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ url('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ url('assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ url('assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ url('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ url('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Kaiadmin JS -->
    <script src="{{ url('assets/js/kaiadmin.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>
