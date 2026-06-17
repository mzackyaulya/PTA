@extends('layout.main')

@section('title','Dashboard Kehadiran Siswa')

@section('content')

<style>
    .attendance-page {
        width: 100%;
    }

    .attendance-card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 22px rgba(0,0,0,0.08);
    }

    .attendance-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 22px 26px;
        background: #fff;
        border-bottom: 1px solid #eef0f3;
    }

    .attendance-header h5 {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        color: #1f2937;
    }

    .scan-btn {
        background: #28a745;
        border: none;
        color: white;
        padding: 12px 22px;
        border-radius: 8px;
        font-weight: 600;
        white-space: nowrap;
    }

    .scan-btn:hover {
        background: #218838;
        color: white;
    }

    .status-box {
        display: inline-flex;
        width: 34px;
        height: 34px;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        color: white;
        border-radius: 8px;
    }

    .status-hadir { background:#28a745; }
    .status-izin  { background:#ffc107; color:black; }
    .status-sakit { background:#17a2b8; }
    .status-alpa  { background:#dc3545; }

    .desktop-table {
        display: block;
    }

    .mobile-attendance {
        display: none;
    }

    .table-responsive-custom {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .attendance-table {
        min-width: 720px;
        margin-bottom: 0;
    }

    .attendance-table th,
    .attendance-table td {
        vertical-align: middle;
        text-align: center;
        padding: 16px 14px;
    }

    .attendance-table thead th {
        font-size: 13px;
        letter-spacing: 1px;
        text-transform: uppercase;
        background: #f8fafc;
    }

    .percent-badge {
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 13px;
    }

    .legend-box {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin-top: 18px;
        font-size: 15px;
    }

    .legend-box strong {
        margin-right: 4px;
    }

    .mobile-subject-card {
        background: #ffffff;
        border: 1px solid #edf0f3;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 14px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.05);
    }

    .mobile-subject-title {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
    }

    .mobile-subject-title h6 {
        font-size: 17px;
        font-weight: 700;
        color: #111827;
        margin: 0;
        line-height: 1.4;
    }

    .mobile-percent {
        flex-shrink: 0;
        font-size: 13px;
        font-weight: 700;
        padding: 7px 10px;
        border-radius: 20px;
        color: white;
    }

    .mobile-meeting-grid {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 8px;
        -webkit-overflow-scrolling: touch;
    }

    .mobile-meeting-item {
        min-width: 105px;
        background: #f8fafc;
        border: 1px solid #edf0f3;
        border-radius: 12px;
        padding: 10px 6px;
        text-align: center;
        flex-shrink: 0;
    }

    .mobile-meeting-item small {
        display: block;
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 7px;
    }

    .empty-status {
        border-radius: 14px;
        padding: 18px;
        text-align: center;
    }

    .scan-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.62);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 999999;
        padding: 18px;
    }

    .scan-card {
        background: white;
        padding: 24px;
        border-radius: 18px;
        width: 360px;
        max-width: 100%;
        text-align: center;
        position: relative;
        box-shadow: 0 10px 28px rgba(0,0,0,0.3);
    }

    .close-scan {
        position: absolute;
        right: 14px;
        top: 12px;
        border: none;
        background: none;
        font-size: 24px;
        cursor: pointer;
        line-height: 1;
        color: #111827;
    }

    #reader {
        width: 300px;
        max-width: 100%;
        margin: auto;
    }

    @media (max-width: 768px) {
        .attendance-page {
            padding: 0;
        }

        .attendance-card {
            border-radius: 16px;
        }

        .attendance-header {
            padding: 18px 16px;
            flex-direction: row;
            align-items: center;
        }

        .attendance-header h5 {
            font-size: 22px;
            line-height: 1.3;
        }

        .scan-btn {
            padding: 10px 14px;
            font-size: 13px;
            border-radius: 8px;
        }

        .desktop-table {
            display: none;
        }

        .mobile-attendance {
            display: block;
        }

        .card-body {
            padding: 16px !important;
        }

        .legend-box {
            gap: 8px;
            font-size: 14px;
            justify-content: flex-start;
        }

        .status-box {
            width: 30px;
            height: 30px;
            font-size: 14px;
            border-radius: 7px;
        }

        .mobile-meeting-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .scan-card {
            width: 92%;
            padding: 22px 16px;
        }
    }

    @media (max-width: 420px) {
        .attendance-header h5 {
            font-size: 20px;
        }

        .scan-btn {
            font-size: 12px;
            padding: 9px 12px;
        }

        .mobile-meeting-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="container attendance-page">

    <div class="card attendance-card">

        <div class="attendance-header">
            <h5>Dashboard Absensi Siswa</h5>
            <small class="text-muted">
                Tahun Ajaran:
                {{ $tahunAktif->tahun ?? '-' }}
                {{ $tahunAktif && $tahunAktif->semester ? 'Semester ' . $tahunAktif->semester : '' }}
            </small>

            <button class="scan-btn" id="openScanner">
                <i class="fas fa-qrcode me-1"></i>
                Scan Absensi
            </button>
        </div>

        <div class="card-body">

            @if($absensi->count() == 0)

                <div class="alert alert-secondary empty-status">
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

                    <div class="alert alert-secondary empty-status">
                        Belum ada pertemuan absensi
                    </div>

                @else

                    {{-- Tampilan Desktop --}}
                    <div class="desktop-table">
                        <div class="table-responsive-custom">
                            <table class="table table-bordered text-center attendance-table">

                                <thead>
                                    <tr>
                                        <th rowspan="2">Mata Pelajaran</th>
                                        <th colspan="{{ $maxPertemuan }}">Pertemuan</th>
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
                                                    $data = $items->firstWhere('pertemuan.pertemuan_ke', $i);
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
                                                <span class="badge percent-badge
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
                        </div>
                    </div>

                    {{-- Tampilan Mobile / Android --}}
                    <div class="mobile-attendance">
                        @foreach($grouped as $mapel => $items)

                            @php
                                $total  = $items->count();
                                $hadir  = $items->where('status','hadir')->count();
                                $persen = $total > 0 ? round(($hadir / $total) * 100) : 0;
                            @endphp

                            <div class="mobile-subject-card">
                                <div class="mobile-subject-title">
                                    <h6>{{ $mapel }}</h6>

                                    <span class="mobile-percent
                                        @if($persen >= 80) bg-success
                                        @elseif($persen >= 60) bg-warning text-dark
                                        @else bg-danger
                                        @endif
                                    ">
                                        {{ $persen }}%
                                    </span>
                                </div>

                                <div class="mobile-meeting-grid">
                                    @for ($i = 1; $i <= $maxPertemuan; $i++)

                                        @php
                                            $data = $items->firstWhere('pertemuan.pertemuan_ke', $i);
                                        @endphp

                                        <div class="mobile-meeting-item">
                                            <small>Pertemuan {{ $i }}</small>

                                            @if($data)
                                                @if($data->status == 'hadir')
                                                    <span class="status-box status-hadir">H</span>
                                                @elseif($data->status == 'izin')
                                                    <span class="status-box status-izin">I</span>
                                                @elseif($data->status == 'sakit')
                                                    <span class="status-box status-sakit">S</span>
                                                @elseif($data->status == 'alpa')
                                                    <span class="status-box status-alpa">A</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>

                                    @endfor
                                </div>
                            </div>

                        @endforeach
                    </div>

                    <div class="legend-box">
                        <strong>Keterangan:</strong>

                        <span class="status-box status-hadir">H</span> Hadir
                        <span class="status-box status-izin">I</span> Izin
                        <span class="status-box status-sakit">S</span> Sakit
                        <span class="status-box status-alpa">A</span> Alpa
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

        <div id="reader"></div>

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
        scanned = false;
        popup.style.display = "flex";

        document.getElementById("reader").innerHTML = "";

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
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
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

                                    setTimeout(function () {
                                        window.location.reload();
                                    }, 1500);

                                } else if(data.status === "expired"){

                                    document.getElementById("reader").innerHTML =
                                        "<h5 style='color:red'>QR expired</h5>";

                                } else if(data.status === "login_required"){

                                    document.getElementById("reader").innerHTML =
                                        "<h5 style='color:red'>Harus login sebagai siswa</h5>";

                                } else if(data.status === "invalid"){

                                    document.getElementById("reader").innerHTML =
                                        "<h5 style='color:red'>QR tidak valid</h5>";

                                } else {

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