
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ url('assets/img/logoweb.png') }}" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Fonts and icons -->
    <script src="{{ url('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
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
                margin-left: 0;   /* pastikan nempel sidebar */
                padding-left: 0;
                }

                /* =========================
                MENU UTAMA (NORMAL STATE)
                ========================= */
                .sidebar {
                    background-color: #155b31; /* hijau tua */

                }

                .sidebar .nav .nav-item a,
                .sidebar .nav .nav-item a i,
                .sidebar .nav .nav-item a p,
                .sidebar .nav .nav-collapse li a span {
                color: #ffffff !important;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 10px 15px;
                border-radius: 4px;
                position: relative;
                z-index: 1;
                }

                /* =========================
                HOVER STATE
                ========================= */
                .sidebar .nav .nav-item a:hover,
                .sidebar .nav .nav-item a:hover i,
                .sidebar .nav .nav-item a:hover p {
                background-color: #198754 !important; /* hijau bootstrap */
                color: #ffffff !important;
                border-radius: 4px;
                }

                /* Hover untuk submenu */
                .sidebar .nav .nav-collapse li a:hover,
                .sidebar .nav .nav-collapse li a:hover i,
                .sidebar .nav .nav-collapse li a:hover span {
                background-color: #29d843 !important; /* hijau terang */
                color: #ffffff !important;
                border-radius: 4px;
                }

                /* Link aktif dengan cekungan */
                .sidebar .nav .nav-item a.active {
                background-color: #198754 !important;
                color: #ffffff !important;
                font-weight: bold;
                position: relative;
                z-index: 20;
                border-radius: 4px 0 0 4px;
                overflow: visible;
                }

                /* Efek cekungan tajam */
                .sidebar .nav .nav-item a.active::after {
                    content: "";
                    position: absolute;
                    top: 0;
                    right: -16px; /* nempel ke konten */
                    width: 40px;
                    height: 100%;
                    background: #eff0f4f4; /* warna konten utama */

                    /* Bentuk cekungan tajam */
                    clip-path: polygon(100% 0, 60% 0, 0 50%, 60% 100%, 100% 100%);

                    z-index: 15;
                }


                /* =========================
                SUBMENU STATE
                ========================= */
                .sidebar .nav .nav-collapse li.active > a,
                .sidebar .nav .nav-collapse li.active > a span,
                .sidebar .nav .nav-collapse li.active > a i {
                background-color: #46bc52 !important; /* hijau muda */
                color: #ffffff !important;
                border-radius: 4px;
                }

                /* caret collapse */
                .sidebar .nav .nav-item a .caret {
                color: #ffffff !important;
                }

                /* Saat menu parent terbuka */
                .sidebar .nav .nav-item a[aria-expanded="true"],
                .sidebar .nav .nav-item a[aria-expanded="true"] i,
                .sidebar .nav .nav-item a[aria-expanded="true"] p {
                color: #ffffff !important;
                font-weight: bold;
                }

                /* Submenu terbuka */
                .sidebar .nav .nav-item .collapse.show a,
                .sidebar .nav .nav-item .collapse.show a i,
                .sidebar .nav .nav-item .collapse.show a span,
                .sidebar .nav .nav-item .collapse.show a p {
                color: #ffffff !important;
                }

                .sidebar,
                .sidebar .nav,
                .sidebar .nav .nav-item {
                overflow: visible !important;
                }

                .main-panel {
                margin-left: 260px; /* sesuai lebar sidebar */
                background-color: #f5f6fa;
                position: relative;
                z-index: 5; /* biar konten tetap di atas sidebar */
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
                            <i class="fas fa-home"></i>
                            <p class="text-white">Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ url('profile')}}" class="{{ request()->is('profile') ? 'active' : '' }}">
                            <i class="fas fa-user"></i>
                            <p class="text-white">Profile</p>
                        </a>
                    </li>
                <li class="nav-item mb-2">
                    <a data-bs-toggle="collapse" href="#belajar">
                    <i class="fas fa-layer-group text-white"></i>
                    <p class="text-white">Pembelajaran</p>
                    <span class="caret"></span>
                    </a>
                    <div class="collapse px-4" id="belajar">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ url('absensi') }}">
                                    <i class="fas fa-user-check"></i>
                                    <span>Absensi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('jadwal') }}">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Jadwal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('materi') }}">
                                    <i class="fas fa-book"></i>
                                    <span>Materi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('tahfiz') }}">
                                    <i class="fas fa-list"></i>
                                    <span>Tahfiz</span>
                                </a>
                            </li>
                        </ul>
                    </div>
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
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <i class="fas fa-layer-group"></i>
                  </a>
                  <div class="dropdown-menu quick-actions animated fadeIn">
                    <div class="quick-actions-header">
                      <span class="title mb-1">Quick Actions</span>
                      <span class="subtitle op-7">Shortcuts</span>
                    </div>
                    <div class="quick-actions-scroll scrollbar-outer">
                      <div class="quick-actions-items">
                        <div class="row m-0">
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-danger rounded-circle">
                                <i class="far fa-calendar-alt"></i>
                              </div>
                              <span class="text">Calendar</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-warning rounded-circle"
                              >
                                <i class="fas fa-map"></i>
                              </div>
                              <span class="text">Maps</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-info rounded-circle">
                                <i class="fas fa-file-excel"></i>
                              </div>
                              <span class="text">Reports</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-success rounded-circle"
                              >
                                <i class="fas fa-envelope"></i>
                              </div>
                              <span class="text">Emails</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-primary rounded-circle"
                              >
                                <i class="fas fa-file-invoice-dollar"></i>
                              </div>
                              <span class="text">Invoice</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="#">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-secondary rounded-circle"
                              >
                                <i class="fas fa-credit-card"></i>
                              </div>
                              <span class="text">Payments</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
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
                        src="assets/img/profile.jpg"
                        alt="..."
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
                                    src="assets/img/profile.jpg"
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
    <script src="{{ url('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ url('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>
  </body>
</html>
