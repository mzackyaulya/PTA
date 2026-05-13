@extends('layout.main')

@section('title','Dashboard Kehadiran Siswa')

@section('content')

<style>

    .status-box {
        display: inline-block;
        width: 38px;
        height: 38px;
        line-height: 38px;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
        color: white;
        border-radius: 6px;
    }

    .status-hadir { background:#28a745; }
    .status-izin  { background:#ffc107; color:black; }
    .status-sakit { background:#17a2b8; }
    .status-alpa  { background:#dc3545; }

    .scan-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 999999;
    }

    .scan-card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        width: 350px;
        text-align: center;
        position: relative;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }

    .close-scan {
        position: absolute;
        right: 10px;
        top: 10px;
        border: none;
        background: none;
        font-size: 18px;
        cursor: pointer;
    }

</style>


<div class="container">

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Dashboard Absensi Siswa
            </h5>

            <button class="btn btn-success btn-sm" id="openScanner">
                <i class="fas fa-qrcode"></i>
                Scan Absensi
            </button>

        </div>


        <div class="card-body">

            @if($absensi->count() == 0)

                <div class="alert alert-secondary text-center">
                    Belum ada pertemuan absensi
                </div>

            @else

                @php
                    $grouped = $absensi->filter(function($item){
                        return $item->pertemuan
                            && $item->pertemuan->mengajar
                            && $item->pertemuan->mengajar->mapel;
                    })->groupBy(function($item){
                        return $item->pertemuan->mengajar->mapel->nama;
                    });

                    $maxPertemuan = $absensi->filter(function($item){
                        return $item->pertemuan;
                    })->max(function($item){
                        return $item->pertemuan->pertemuan_ke;
                    });
                @endphp

                @if($grouped->count() == 0)

                    <div class="alert alert-secondary text-center">
                        Belum ada pertemuan absensi
                    </div>

                @else

                    <table class="table table-bordered text-center">

                        <thead class="table-light">

                            <tr>
                                <th rowspan="2">Mata Pelajaran</th>
                                <th colspan="{{ $maxPertemuan }}">PERTEMUAN</th>
                                <th rowspan="2">Persentase Kehadiran (%)</th>
                            </tr>

                            <tr>
                                @for ($i = 1; $i <= $maxPertemuan; $i++)
                                    <th>{{ $i }}</th>
                                @endfor
                            </tr>

                        </thead>


                        <tbody>

                            @foreach($grouped as $mapel => $items)

                                @php
                                    $total  = $items->count();
                                    $hadir  = $items->where('status','hadir')->count();
                                    $persen = $total > 0 ? round(($hadir / $total) * 100) : 0;
                                @endphp

                                <tr>

                                    <td>{{ $mapel }}</td>

                                    @for ($i = 1; $i <= $maxPertemuan; $i++)

                                        @php
                                            $data = $items->firstWhere('pertemuan.pertemuan_ke',$i);
                                        @endphp

                                        <td
                                            @if($data)

                                                @if($data->status == 'hadir')
                                                    style="background:#28a745;color:white;font-weight:bold;font-size:18px;"
                                                @elseif($data->status == 'izin')
                                                    style="background:#ffc107;color:black;font-weight:bold;font-size:18px;"
                                                @elseif($data->status == 'sakit')
                                                    style="background:#17a2b8;color:white;font-weight:bold;font-size:18px;"
                                                @elseif($data->status == 'alpa')
                                                    style="background:#dc3545;color:white;font-weight:bold;font-size:18px;"
                                                @endif

                                            @endif
                                        >

                                            @if($data)

                                                @if($data->status == 'hadir') H
                                                @elseif($data->status == 'izin') I
                                                @elseif($data->status == 'sakit') S
                                                @elseif($data->status == 'alpa') A
                                                @endif

                                            @else
                                                -
                                            @endif

                                        </td>

                                    @endfor


                                    <td>

                                        <span class="badge
                                            @if($persen >= 80) bg-success
                                            @elseif($persen >= 60) bg-warning text-dark
                                            @else bg-danger
                                            @endif
                                        ">
                                            {{ $persen }}%
                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>


                    <div class="mt-3">

                        <strong>Keterangan :</strong>

                        <span class="badge bg-success">H</span> Hadir
                        <span class="badge bg-warning text-dark">I</span> Izin
                        <span class="badge bg-info">S</span> Sakit
                        <span class="badge bg-danger">A</span> Alpa

                    </div>

                @endif

            @endif

        </div>

    </div>

</div>


<div class="scan-overlay" id="scannerPopup">

    <div class="scan-card">

        <button class="close-scan" id="closeScanner">✕</button>

        <h5 class="mb-3">
            Scan QR Absensi
        </h5>

        <div id="reader" style="width:300px;margin:auto;"></div>

    </div>

</div>


<script src="https://unpkg.com/html5-qrcode"></script>

<script>

    let scanner;
    let scanned = false;

    const popup = document.getElementById("scannerPopup");
    const open  = document.getElementById("openScanner");
    const close = document.getElementById("closeScanner");

    const beep = new Audio("https://actions.google.com/sounds/v1/cartoon/clang_and_wobble.ogg");


    open.onclick = function(){

        popup.style.display = "flex";

        scanner = new Html5Qrcode("reader");

        Html5Qrcode.getCameras().then(devices => {

            if(devices && devices.length){

                let backCamera = devices.find(camera =>
                    camera.label.toLowerCase().includes("back") ||
                    camera.label.toLowerCase().includes("environment")
                );

                let cameraId = backCamera ? backCamera.id : devices[0].id;

                scanner.start(
                    cameraId,
                    {
                        fps:10,
                        qrbox:{ width:250, height:250 }
                    },

                    function(decodedText){

                        if(scanned) return;
                        scanned = true;

                        beep.play();

                        scanner.stop().then(()=>{

                            document.getElementById("reader").innerHTML = `
                                <div style="padding:30px;text-align:center">
                                    <div class="spinner-border text-success"></div>
                                    <p class="mt-2">Memproses absensi...</p>
                                </div>
                            `;

                            let url = new URL(decodedText);

                            fetch(url.pathname,{
                                method:'GET',
                                credentials:'include',
                                headers:{
                                    'Accept':'application/json'
                                }
                            })
                            .then(response => {

                                if(!response.ok){
                                    throw new Error("Server error");
                                }

                                return response.json();
                            })
                            .then(data => {

                                if(data.status === "success"){

                                    document.getElementById("reader").innerHTML =
                                        "<h5 style='color:green'>Scan berhasil</h5>";

                                }

                                else if(data.status === "expired"){

                                    document.getElementById("reader").innerHTML =
                                        "<h5 style='color:red'>QR expired</h5>";

                                }
                                else if(data.status === "login_required"){

                                    document.getElementById("reader").innerHTML =
                                        "<h5 style='color:red'>Harus login sebagai siswa</h5>";

                                }

                                else if(data.status === "invalid"){

                                    document.getElementById("reader").innerHTML =
                                        "<h5 style='color:red'>QR tidak valid</h5>";

                                }

                                else{

                                    document.getElementById("reader").innerHTML =
                                        "<h5 style='color:red'>Gagal memproses</h5>";

                                }

                            })
                            .catch(error => {
                                console.log(error);

                                document.getElementById("reader").innerHTML =
                                    "<h5 style='color:red'>Server error</h5>";
                            });
                        });

                    },

                    function(error){}

                );

            }

        })

        .catch(err => {

            alert("Kamera tidak dapat diakses");

        });

    };


    close.onclick = function(){

        popup.style.display = "none";

        if(scanner){

            scanner.stop()
            .then(()=>{})
            .catch(()=>{});

        }

    };

</script>

@endsection