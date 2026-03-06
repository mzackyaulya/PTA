@extends('layout.main')

@section('title','Form Absensi')

@section('content')

<style>

/* =============================
   POPUP OVERLAY BACKGROUND
============================= */

.popup-overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:999999;
}

/* =============================
   CARD POPUP TENGAH
============================= */

.popup-card{
    background:#ffffff;
    padding:30px;
    border-radius:12px;
    width:380px;
    position:relative;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.25);
    animation:popupFade 0.25s ease;
}

/* =============================
   TOMBOL CLOSE (X)
============================= */

.popup-close{
    position:absolute;
    top:10px;
    right:15px;
    border:none;
    background:none;
    font-size:20px;
    cursor:pointer;
    color:#333;
}

/* =============================
   QR STYLE
============================= */

#qr-container svg{
    background:#fff;
    padding:10px;
    border-radius:10px;
}

/* =============================
   ANIMASI POPUP
============================= */

@keyframes popupFade{
    from{
        transform:scale(0.85);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

</style>

<div class="container">

<div class="card shadow">

    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            Absensi Siswa - Pertemuan {{ $pertemuan->pertemuan_ke }}
        </h5>

        <button class="btn btn-sm text-white" id="btnQR">
            <i class="fas fa-qrcode"></i>
        </button>

    </div>

    <div class="card-body">

        <form action="{{ route('absensi.store') }}" method="POST">

            @csrf

            <input type="hidden"
                   name="pertemuan_id"
                   value="{{ $pertemuan->id }}">

            <table class="table table-bordered">

                <thead class="table-light">

                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">NISN</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Hadir</th>
                        <th class="text-center">Izin</th>
                        <th class="text-center">Sakit</th>
                        <th class="text-center">Alpa</th>
                        <th class="text-center">Keterangan</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($siswa as $key => $s)

                    <tr>

                        <td class="text-center">{{ $key + 1 }}</td>

                        <td class="text-center">
                            {{ $s->user->nisn }}
                        </td>

                        <td class="text-center">
                            {{ $s->user->name }}
                        </td>

                        <td class="text-center">
                            <input type="radio" name="status[{{ $key }}]" value="hadir">
                        </td>

                        <td class="text-center">
                            <input type="radio" name="status[{{ $key }}]" value="izin">
                        </td>

                        <td class="text-center">
                            <input type="radio" name="status[{{ $key }}]" value="sakit">
                        </td>

                        <td class="text-center">
                            <input type="radio" name="status[{{ $key }}]" value="alpa">
                        </td>

                        <td class="text-center">
                            <input type="text"
                                   name="keterangan[{{ $key }}]"
                                   class="form-control"
                                   placeholder="Masukan Keterangan Siswa">
                        </td>

                        <input type="hidden"
                               name="siswa_id[]"
                               value="{{ $s->id }}">

                    </tr>

                    @endforeach

                </tbody>

            </table>

            <div class="mt-3">

                <button type="submit"
                        class="btn btn-primary">
                    Simpan Absensi
                </button>

            </div>

        </form>

    </div>

</div>
```

</div>

<!-- =============================
     POPUP QR CODE
============================= -->

<div id="popupQR" class="popup-overlay">

```
<div class="popup-card">

    <button class="popup-close" id="closeQR">✕</button>

    <p>
        Silahkan scan QR Code untuk Absen
    </p>

    <div id="qr-container" class="mt-3">

        {!! QrCode::size(230)->generate(route('absensi.scan',$barcode->token)) !!}

    </div>

    <div class="mt-3">

        <p class="fw-bold">
            <span id="countdown"></span>
        </p>

    </div>

</div>
```

</div>

<script>

/* =============================
   COUNTDOWN QR CODE
============================= */

let expiredTime = new Date("{{ $barcode->expired_at }}").getTime();

let countdown = setInterval(function(){

    let now = new Date().getTime();
    let distance = expiredTime - now;

    if(distance < 0){

        clearInterval(countdown);

        document.getElementById("countdown").innerHTML = "QR EXPIRED";

        document.getElementById("qr-container").innerHTML =
            "<h5 class='text-danger'>QR Code sudah expired</h5>";

        return;
    }

    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("countdown").innerHTML =
        minutes + " menit " + seconds + " detik";

},1000);


/* =============================
   POPUP CONTROL
============================= */

const popup = document.getElementById("popupQR");
const btnQR = document.getElementById("btnQR");
const closeQR = document.getElementById("closeQR");


btnQR.onclick = function(){
    popup.style.display = "flex";
};

closeQR.onclick = function(){
    popup.style.display = "none";
};

/* klik background untuk menutup popup */

popup.onclick = function(e){
    if(e.target === popup){
        popup.style.display = "none";
    }
};

</script>

@endsection
