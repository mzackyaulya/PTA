<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Akademik</title>

    <link rel="shortcut icon" type="image/png" href="{{ url('assets/img/logoweb.png') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/styles.min.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Font bagus -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ===== DEFAULT: MOBILE (hijau) ===== */
        .login-bg{
            background: #198754; /* hijau */
            min-height: 100vh;
        }
        .login-overlay{
            background: transparent; /* mobile gak perlu overlay gelap */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px 12px;
        }

        .login-card{
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.25);
        }

        /* Judul */
            .login-title{
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            letter-spacing: .2px;
            font-size: 20px; /* mobile */
            line-height: 1.2;
            margin-bottom: 6px;
        }

        /* ===== PC/TABLET (md ke atas): pakai gambar background + judul lebih besar ===== */
        @media (min-width: 768px) {
            .login-bg{
                background-image: url("{{ asset('assets/img/backgrndLogin.png') }}");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
            .login-overlay{
                background: rgba(0,0,0,0.35); /* overlay cuma untuk PC */
                padding: 0;
            }
            .login-title{
                font-size: 26px; /* windows lebih besar */
                font-weight: 800;
            }
        }
    </style>
</head>

<body>
    <div class="login-bg">
        <div class="login-overlay">
            <div class="container">
                <div class="row justify-content-center justify-content-md-end pe-md-5">
                    <div class="col-12 col-sm-10 col-md-6 col-lg-5 col-xxl-4">
                        <div class="card login-card">
                            <div class="card-body p-4">
                                <div class="text-center mb-3 d-block d-md-none">
                                    <img src="{{ url('assets/img/Logo.png') }}" alt="Logo" width="280" height="110">
                                </div>

                                <div class="text-center login-title">Akademik SMA Muhammadiyah 2</div>
                                <p class="text-center d-md-none mb-4">Sistem Pembelajaran Online dan Efektif</p>
                                <p class="text-center text-muted d-none d-md-block mb-4">Sistem Pembelajaran Online dan Efektif</p>

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="number"
                                            class="form-control"
                                            name="username"
                                            placeholder="Masukkan NISN atau NIP"
                                            value="{{ old('username') }}"
                                            required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password"
                                                    class="form-control"
                                                    id="password"
                                                    name="password"
                                                    placeholder="Masukkan Password"
                                                    required>
                                            <span class="input-group-text" id="togglePassword" style="cursor:pointer">
                                                <i class="fa-solid fa-eye" id="eyeIcon"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100 py-2 fs-5 rounded-3">
                                        Login
                                    </button>

                                    <div class="text-center mt-3">
                                        <span class="fw-bold">Lupa Password?</span>
                                        <a href="#" class="text-success fw-bold ms-1">Hubungi Admin!</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- SCRIPT -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ url('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

  <script>
    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    togglePassword.addEventListener("click", function () {
      const type = password.type === "password" ? "text" : "password";
      password.type = type;
      eyeIcon.classList.toggle("fa-eye");
      eyeIcon.classList.toggle("fa-eye-slash");
    });
  </script>

  @if ($errors->any())
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Login Gagal',
      text: 'Username atau Password salah!',
      confirmButtonColor: '#198754'
    });
  </script>
  @endif

</body>
</html>
