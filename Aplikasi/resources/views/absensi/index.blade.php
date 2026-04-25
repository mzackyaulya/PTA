@extends('layout.main')

@section('title','Daftar Pertemuan Absensi')

@section('content')

<style>

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
                            {{ $j->kelas->nama_kelas ?? '-' }}

                        </option>

                    @empty

                        <option disabled>
                            Tidak ada jadwal mengajar hari ini
                        </option>

                    @endforelse

                </select>

            </div>


            @if(isset($selectedPertemuan))

            <div class="section-box action-box">
                <div>
                    @php
                        $sekarang = now()->format('H:i:s');
                        $belumMulai = $sekarang < $selectedJadwal->jam_mulai;
                        $sudahSelesai = $sekarang > $selectedJadwal->jam_selesai;
                    @endphp

                    @if($belumMulai)
                        <button class="btn btn-secondary btn-absen" disabled>
                            Belum Masuk Jam Pelajaran
                        </button>

                    @elseif($sudahSelesai || $selectedPertemuan->is_closed)
                        <button class="btn btn-danger btn-absen" disabled>
                            Absensi Ditutup
                        </button>

                    @elseif(!$selectedPertemuan->is_approved)
                        <form method="POST" action="{{ route('absensi.validasi', $selectedPertemuan->id) }}" style="display:inline">
                            @csrf
                            <button class="btn btn-success btn-absen">
                                Validasi & Buka Absen
                            </button>
                        </form>

                    @elseif($selectedPertemuan->is_started && !$selectedPertemuan->is_saved)
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

                        <form method="POST" action="{{ route('absensi.close',$selectedPertemuan->id) }}" style="display:inline">
                            @csrf
                            <button class="btn btn-danger btn-absen">
                                Tutup
                            </button>
                        </form>
                    @endif
                </div>

                <div>
                    @if($selectedPertemuan->is_started && !$selectedPertemuan->is_closed)
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
        window.location.href = "/guru/absensi?mengajar_id=" + id;
    }
}

</script>

@endsection