@extends('layout.main')

@section('title','Daftar Pertemuan Absensi')

@section('content')

<style>
    .mode-card{
        background:#ffffff;
        border:1px solid #e5e7eb;
        border-radius:10px;
        padding:6px;
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:6px;
        margin-bottom:20px;
        box-shadow:0 2px 8px rgba(0,0,0,0.04);
    }

    .mode-card .mode-btn{
        display:flex;
        align-items:center;
        justify-content:center;
        padding:14px 18px;
        border-radius:8px;
        font-weight:600;
        text-decoration:none;
        border:1px solid #0d6efd;
        transition:0.2s;
    }

    .mode-card .mode-btn.active{
        background:#0d6efd;
        color:#fff;
    }

    .mode-card .mode-btn.inactive{
        background:#fff;
        color:#0d6efd;
    }

    .mode-card .mode-btn:hover{
        opacity:0.9;
    }

    .absen-container{
        max-width:1100px;
        margin:auto;
    }

    .section-box{
        background:#f9fafc;
        border-radius:8px;
        padding:18px;
        margin-bottom:20px;
    }

    .action-box{
        display:flex;
        justify-content:space-between;
        align-items:center;
    }

    .btn-absen{
        margin-right:10px;
    }

    .table thead th,
    .table tbody td{
        text-align:center;
        vertical-align:middle;
    }

    .popup-overlay{
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:rgba(0,0,0,0.5);
        display:none;
        justify-content:center;
        align-items:center;
    }

    .popup-card{
        background:#fff;
        padding:30px;
        border-radius:12px;
        width:360px;
        text-align:center;
        position:relative;
    }

    .popup-close{
        position:absolute;
        right:15px;
        top:10px;
        border:none;
        background:none;
    }

    .form-disabled{
        pointer-events:none;
        opacity:0.5;
    }

    .status-box{
        display:inline-block;
        min-width:32px;
        height:32px;
        line-height:32px;
        border-radius:6px;
        color:white;
        font-weight:bold;
    }

    .status-hadir{ background:#28a745; }
    .status-izin{ background:#ffc107; color:#000; }
    .status-sakit{ background:#17a2b8; }
    .status-alpa{ background:#dc3545; }

</style>


<div class="container absen-container">

    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">DAFTAR PERTEMUAN ABSENSI</h5>
        </div>

        <div class="card-body">


            {{-- ================= PILIH JADWAL MENGAJAR ================= --}}
            <div class="section-box">

                <select class="form-control" onchange="pilihJadwal(this.value)">

                    <option value="" disabled {{ !request('mengajar_id') ? 'selected' : '' }}>
                        Pilih Jadwal Mengajar Hari Ini
                    </option>

                    @forelse($jadwal as $j)

                        <option value="{{ $j->id }}"
                            @if(request('mengajar_id') == $j->id) selected @endif>

                            {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                            |
                            {{ $j->mapel->nama ?? '-' }}
                            |
                            {{ $j->kelas->tingkat ?? '-' }} {{ $j->kelas->nama_kelas ?? '-' }}

                        </option>

                    @empty

                        <option disabled>
                            Tidak ada jadwal mengajar hari ini
                        </option>

                    @endforelse

                </select>

            </div>


            @if(request('mengajar_id'))

                @php
                    $modeAktif = request('mode', 'absen');
                @endphp

                <div class="mode-card">

                    <a href="{{ route('absensi.guru', [
                        'mengajar_id' => request('mengajar_id'),
                        'mode' => 'absen'
                    ]) }}"
                    class="mode-btn {{ $modeAktif == 'absen' ? 'active' : 'inactive' }}">
                        Absensi Siswa
                    </a>

                    <a href="{{ route('absensi.guru', [
                        'mengajar_id' => request('mengajar_id'),
                        'mode' => 'rekap'
                    ]) }}"
                    class="mode-btn {{ $modeAktif == 'rekap' ? 'active' : 'inactive' }}">
                        Lihat Semua Absensi
                    </a>

                </div>

            @endif


            @if(isset($selectedPertemuan) && request('mode') != 'rekap')

            <div class="section-box action-box">
                <div>
                    @if($selectedPertemuan->is_closed)
                        <button class="btn btn-danger btn-absen" disabled>
                            Absensi Ditutup
                        </button>

                    @elseif(!$selectedPertemuan->is_approved)
                        <button class="btn btn-warning btn-absen" disabled>
                            Menunggu Admin Membuka Absensi
                        </button>

                    @elseif($selectedPertemuan->is_approved && $selectedPertemuan->is_started && !$selectedPertemuan->is_saved)
                        <button class="btn btn-success btn-absen" disabled>
                            Absensi Berjalan
                        </button>

                        <button type="submit" form="formAbsensi" class="btn btn-primary btn-absen">
                            Simpan
                        </button>

                    @elseif($selectedPertemuan->is_saved && !$selectedPertemuan->is_closed)
                        <button class="btn btn-success btn-absen" disabled>
                            Absensi Disimpan
                        </button>

                        <form method="POST" action="{{ route('absensi.close', $selectedPertemuan->id) }}" style="display:inline">
                            @csrf
                            <button class="btn btn-danger btn-absen">
                                Tutup
                            </button>
                        </form>
                    @endif
                </div>

                <div>
                    @if($selectedPertemuan->is_approved && $selectedPertemuan->is_started && !$selectedPertemuan->is_closed)
                        <button class="btn btn-outline-dark" id="btnQR">
                            <i class="fas fa-qrcode"></i>
                        </button>
                    @else
                        <button class="btn btn-outline-dark" disabled>
                            <i class="fas fa-qrcode"></i>
                        </button>
                    @endif
                </div>
            </div>

            @endif


            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                    {{ session('success') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

            @endif


            @if(request('mode') == 'rekap')

                <div class="section-box">

                    <h5 class="mb-3"> Absensi Semua Siswa</h5>

                    <p>
                        <strong>Mata Pelajaran:</strong> {{ $selectedJadwal->mapel->nama ?? '-' }} <br>
                        <strong>Kelas:</strong> {{ $selectedJadwal->kelas->tingkat ?? '-' }} {{ $selectedJadwal->kelas->nama_kelas ?? '-' }}
                    </p>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center">

                            <thead class="table-light">
                                <tr>
                                    <th>NO</th>
                                    <th>NISN</th>
                                    <th>NAMA SISWA</th>

                                    @for($i = 1; $i <= ($jumlahPertemuan ?? 0); $i++)
                                        <th>Pertemuan {{ $i }}</th>
                                    @endfor

                                    <th>PERSENTASE</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($rekapSiswa ?? [] as $key => $s)

                                    @php
                                        $totalPertemuan = $jumlahPertemuan ?? 0;
                                        $jumlahHadir = $s->absensi->where('status','hadir')->count();
                                        $persen = $totalPertemuan > 0 ? round(($jumlahHadir / $totalPertemuan) * 100) : 0;
                                    @endphp

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $s->user->nisn ?? '-' }}</td>
                                        <td>{{ $s->user->name ?? '-' }}</td>

                                        @for($i = 1; $i <= $totalPertemuan; $i++)

                                            @php
                                                $data = $s->absensi->first(function($a) use ($i){
                                                    return $a->pertemuan && $a->pertemuan->pertemuan_ke == $i;
                                                });
                                            @endphp

                                            <td>
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
                                                        -
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

                                @empty

                                    <tr>
                                        <td colspan="{{ 4 + ($jumlahPertemuan ?? 0) }}">
                                            Belum ada data siswa.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>
                    </div>

                    <div class="mt-3">
                        <strong>Keterangan :</strong>
                        <span class="status-box status-hadir text-center">H</span> Hadir
                        <span class="status-box status-izin text-center">I</span> Izin
                        <span class="status-box status-sakit text-center">S</span> Sakit
                        <span class="status-box status-alpa text-center">A</span> Alpa
                    </div>

                </div>

            @else

                {{-- ================= FORM ABSENSI ================= --}}
                <form id="formAbsensi" method="POST" action="{{ route('absensi.store') }}">
                    @csrf

                    <input type="hidden" name="pertemuan_id" value="{{ $selectedPertemuan->id ?? '' }}">

                    <div class="section-box
                    @if(isset($selectedPertemuan) && (!$selectedPertemuan->is_approved || $selectedPertemuan->is_closed))
                        form-disabled
                    @endif
                    ">

                        <table class="table table-bordered">

                            <thead class="table-light">
                                <tr>
                                    <th>NO</th>
                                    <th>NISN</th>
                                    <th>NAMA</th>
                                    <th>HADIR</th>
                                    <th>IZIN</th>
                                    <th>SAKIT</th>
                                    <th>ALPA</th>
                                    <th>KETERANGAN</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($siswa ?? [] as $key => $s)

                                    <tr>

                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $s->user->nisn }}</td>
                                        <td>{{ $s->user->name }}</td>

                                        <td>
                                            <input type="radio"
                                            name="status[{{ $key }}]"
                                            value="hadir"
                                            {{ optional($s->absensi->first())->status == 'hadir' ? 'checked' : '' }}>
                                        </td>

                                        <td>
                                            <input type="radio"
                                            name="status[{{ $key }}]"
                                            value="izin"
                                            {{ optional($s->absensi->first())->status == 'izin' ? 'checked' : '' }}>
                                        </td>

                                        <td>
                                            <input type="radio"
                                            name="status[{{ $key }}]"
                                            value="sakit"
                                            {{ optional($s->absensi->first())->status == 'sakit' ? 'checked' : '' }}>
                                        </td>

                                        <td>
                                            <input type="radio"
                                            name="status[{{ $key }}]"
                                            value="alpa"
                                            {{ optional($s->absensi->first())->status == 'alpa' ? 'checked' : '' }}>
                                        </td>

                                        <td>
                                            <input type="text"
                                            name="keterangan[{{ $key }}]"
                                            class="form-control"
                                            placeholder="Keterangan siswa....."
                                            value="{{ optional($s->absensi->first())->keterangan }}">
                                        </td>

                                        <input type="hidden" name="siswa_id[]" value="{{ $s->id }}">

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="8">
                                            Silahkan pilih pertemuan terlebih dahulu
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </form>

            @endif


        </div>
    </div>
</div>



{{-- ================= MODAL QR ================= --}}
<div id="popupQR" class="popup-overlay">

    <div class="popup-card">

        <button class="popup-close" id="closeQR">✕</button>

        <p>Silahkan Scan QR Code</p>

        <div id="qr-container">

            @if(isset($barcode))
                {!! QrCode::size(230)->generate(url('/siswa/scan/'.$barcode->token)) !!}
            @endif

        </div>

    </div>

</div>



<script>

function pilihJadwal(id){
    if(id){
        window.location.href = "/guru/absensi?mengajar_id=" + id + "&mode=absen";
    }
}

    document.addEventListener('DOMContentLoaded', function () { 
        const btnQR = document.getElementById('btnQR');
        const popupQR = document.getElementById('popupQR');
        const closeQR = document.getElementById('closeQR');

        if (btnQR && popupQR) {
            btnQR.addEventListener('click', function () {
                popupQR.style.display = 'flex';
            });
        }

        if (closeQR && popupQR) {
            closeQR.addEventListener('click', function () {
                popupQR.style.display = 'none';
            });
        }

        if (popupQR) {
            popupQR.addEventListener('click', function (e) {
                if (e.target === popupQR) {
                    popupQR.style.display = 'none';
                }
            });
        }
    });

</script>

@endsection