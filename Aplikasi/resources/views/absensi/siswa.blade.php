@extends('layout.main')

@section('title','Dashboard Kehadiran Siswa')

@section('content')
<style>
.status-box{
    display:inline-block;
    width:38px;
    height:38px;
    line-height:38px;
    text-align:center;
    font-weight:bold;
    font-size:18px;
    color:white;
    border-radius:6px;
}

.status-hadir{
    background:#28a745;
}

.status-izin{
    background:#ffc107;
    color:black;
}

.status-sakit{
    background:#17a2b8;
}

.status-alpa{
    background:#dc3545;
}
</style>

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">Dashboard Absensi Siswa</h5>

            <!-- BUTTON SCAN --> 
            <a href="{{ route('absensi.scan.camera') }}" class="btn btn-success btn-sm"> 
                <i class="fas fa-qrcode"></i> Scan Absensi 
            </a>
            
        </div>

        <div class="card-body">

            @if($absensi->count() == 0)

                <div class="alert alert-secondary text-center">
                    Belum ada pertemuan sama sekali
                </div>

            @else

                @php

                    $grouped = $absensi->groupBy(function($item){
                        return $item->pertemuan->mengajar->mapel->nama;
                    });

                    $maxPertemuan = $absensi->max(function($item){
                        return $item->pertemuan->pertemuan_ke;
                    });

                @endphp

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
                                $total = $items->count();
                                $hadir = $items->where('status','hadir')->count();
                                $persen = $total > 0 ? round(($hadir / $total) * 100) : 0;
                            @endphp

                            <tr>

                                <td class="text-center">
                                    {{ $mapel }}
                                </td>

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

                                            @if($data->status == 'hadir')
                                                H
                                            @elseif($data->status == 'izin')
                                                I
                                            @elseif($data->status == 'sakit')
                                                S
                                            @elseif($data->status == 'alpa')
                                                A
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

        </div>

    </div>

</div>

@endsection