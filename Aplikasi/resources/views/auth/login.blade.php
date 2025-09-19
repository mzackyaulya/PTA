
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Akademik</title>
  <link rel="shortcut icon" type="image/png" href="{{ url('assets/img/logoweb.png') }}" />
  <link rel="stylesheet" href="{{ url('assets/css/styles.min.css') }}" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center bg-success">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="/" class="text-nowrap logo-img text-center d-block py-3 w-50">
                                    <img src="{{ url('assets/img/Logo.png') }}" alt="" width="305px" height="120px">
                                </a>
                                <p class="text-center">Selamat Datang di Akademik</p>
                                <p class="text-center">Sma Muhammadiyah 2 Palembang</p>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="number" class="form-control" id="username" name="username" placeholder="Masukan NISN atau NIP" value="{{ old('username') }}" required>
                                    </div>

                                    <div class="mb-4 position-relative">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password" required>
                                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                                <i class="fa-solid fa-eye" id="eyeIcon"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Login</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Lupa Password?</p>
                                        <a class="text-primary fw-bold ms-2" href="#">Hubungi Admin !</a>
                                    </div>
                                </form>
                                @if ($errors->any())
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Login Gagal',
                                            text: 'Username atau Pssword salah!',
                                            confirmButtonColor: '#198754', // hijau biar sesuai tema
                                        });
                                    </script>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ url('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- solar icons -->
    <script src="{{ url('https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js') }}"></script>
    <script src="{{ url('https://kit.fontawesome.com/your-fontawesome-key.js') }}" crossorigin="anonymous"></script>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        const eyeIcon = document.querySelector("#eyeIcon");

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            // Ganti ikon
            eyeIcon.classList.toggle("fa-eye");
            eyeIcon.classList.toggle("fa-eye-slash");
        });
    </script>
</body>
</html>
