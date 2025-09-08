{{-- Login --}}
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Akademik</title>
  <link rel="shortcut icon" type="image/png" href={{ url("assets/images/logos/logoweb.png")}} />
  <link rel="stylesheet" href={{ url("assets/css/styles.min.css") }} />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="#" class="text-nowrap logo-img text-center py-3 d-block">
                  <img src={{ url("assets/images/logos/logosekolah.png")}} alt="" width="250px">
                </a>
                <p class="text-center">Selamat Datang di Sma Muhammadiyah 2 Palembang</p>
                <form>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" >
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <a class="text-primary fw-bold mb-3" href="./index.html">Forgot Password ?</a>

                  <a href="./index.html" class="btn btn-primary w-100 py-8 fs-4 mb-3 rounded-2">Sign In</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src={{ url("assets/libs/jquery/dist/jquery.min.js")}}></script>
  <script src={{ url("assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js")}}></script>
  <!-- solar icons -->
  <script src={{ url("https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js")}}></script>
</body>

</html>
