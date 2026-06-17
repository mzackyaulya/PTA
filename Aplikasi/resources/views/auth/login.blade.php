<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Akademik</title>

    <link rel="shortcut icon" type="image/png" href="{{ url('/assets/img/logoweb.png') }}">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            width: 100%;
            min-height: 100%;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            overflow: hidden;
        }

        .login-page {
            width: 100%;
            min-height: 100vh;
            background-color: #0f5f39;
            background-image: url("/assets/img/backgrndLogin.png");
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;

            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 150px;
        }

        .login-card {
            width: 410px;
            background: #ffffff;
            border-radius: 18px;
            padding: 32px 30px;
            box-shadow: 0 18px 40px rgba(0,0,0,0.28);
        }

        .logo-box {
            text-align: center;
            margin-bottom: 18px;
        }

        .logo-box img {
            width: 150px;
            height: auto;
            object-fit: contain;
            display: inline-block;
        }

        .login-title {
            text-align: center;
            font-size: 27px;
            font-weight: 800;
            color: #5f6f7a;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .login-subtitle {
            text-align: center;
            color: #7a8793;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            height: 44px;
            border: 1px solid #d8dee7;
            border-radius: 7px;
            padding: 10px 14px;
            font-size: 14px;
            outline: none;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 3px rgba(25,135,84,0.12);
        }

        .password-wrapper {
            display: flex;
            width: 100%;
        }

        .password-wrapper input {
            border-radius: 7px 0 0 7px;
        }

        .toggle-password {
            width: 52px;
            border: 1px solid #d8dee7;
            border-left: none;
            background: #eef2f5;
            border-radius: 0 7px 7px 0;
            cursor: pointer;
            font-size: 16px;
            color: #536471;
        }

        .login-btn {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 12px;
            background: #37c979;
            color: white;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 8px;
        }

        .login-btn:hover {
            background: #27b96a;
        }

        .forgot {
            text-align: center;
            margin-top: 18px;
            font-size: 15px;
            color: #4b5563;
        }

        .forgot a {
            color: #16a34a;
            text-decoration: none;
            font-weight: 700;
            margin-left: 4px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 18px;
            font-size: 14px;
            text-align: center;
        }

        @media (max-width: 992px) {
            .login-page {
                justify-content: center;
                padding: 20px;
            }

            .login-card {
                width: 100%;
                max-width: 420px;
            }
        }

        @media (max-width: 576px) {
            body {
                overflow-y: auto;
            }

            .login-page {
                min-height: 100vh;
                padding: 20px;
                background-position: center top;
            }

            .login-card {
                padding: 26px 22px;
            }

            .login-title {
                font-size: 23px;
            }

            .logo-box img {
                width: 130px;
            }
        }
    </style>
</head>

<body>

<div class="login-page">

    <div class="login-card">

        <h1 class="login-title">
            SIAKAD <br>
            SMA Muhammadiyah 2
        </h1>

        <p class="login-subtitle">
            Sistem Informasi Akademik SMAMDUPA
        </p>

        @if ($errors->any())
            <div class="alert-error">
                Username atau Password salah!
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="number"
                       name="username"
                       class="form-control"
                       placeholder="Masukkan NISN atau NIP"
                       value="{{ old('username') }}"
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>

                <div class="password-wrapper">
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control"
                           placeholder="Masukkan Password"
                           required>

                    <button type="button" class="toggle-password" id="togglePassword">
                        👁
                    </button>
                </div>
            </div>

            <button type="submit" class="login-btn">
                Login
            </button>

            <div class="forgot">
                Lupa Password?
                <a href="#">Hubungi Admin!</a>
            </div>

        </form>

    </div>

</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        if (password.type === 'password') {
            password.type = 'text';
            togglePassword.textContent = '🙈';
        } else {
            password.type = 'password';
            togglePassword.textContent = '👁';
        }
    });
</script>

</body>
</html>