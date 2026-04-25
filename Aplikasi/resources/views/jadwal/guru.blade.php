@extends('layout.main')

@section('title','Jadwal Mengajar Guru')

@section('content')

<div class="card">

    <div class="card-header">
        <h4>Jadwal Mengajar Guru</h4>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @php
            use App\Models\PertemuanAbsensi;
            use Carbon\Carbon;

            $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

            $jam = $jadwal->sortBy('jam_mulai')
                ->map(function($j){
                    return substr($j->jam_mulai,0,5).' - '.substr($j->jam_selesai,0,5);
                })
                ->unique();

            $hariIni = now()->locale('id')->translatedFormat('l');
            $tanggalHariIni = now()->toDateString();
            $sekarang = now();
        @endphp

        <table class="table table-bordered text-center">

            <thead class="table-dark">
                <tr>
                    <th width="150">Jam</th>

                    @foreach($hari as $h)
                        <th>{{ $h }}</th>
                    @endforeach

                </tr>
            </thead>

            <tbody>

            @foreach($jam as $j)

                <tr>

                    <td class="fw-bold">{{ $j }}</td>

                    @foreach($hari as $h)

                    <td>

                        @foreach($jadwal as $item)

                            @php
                                $jam_item = substr($item->jam_mulai,0,5).' - '.substr($item->jam_selesai,0,5);

                                $pertemuan = PertemuanAbsensi::where('mengajar_id', $item->id)
                                    ->whereDate('tanggal', $tanggalHariIni)
                                    ->first();

                                $jamMulai = Carbon::parse($tanggalHariIni.' '.$item->jam_mulai);
                                $jamSelesai = Carbon::parse($tanggalHariIni.' '.$item->jam_selesai);
                                $waktuValidasi = $jamMulai->copy()->subMinutes(5);

                                $bolehValidasi = $h == $hariIni
                                    && $sekarang->between($waktuValidasi, $jamSelesai);

                                $sudahSelesai = $h == $hariIni && $sekarang->gt($jamSelesai);
                            @endphp

                            @if($item->hari == $h && $jam_item == $j)

                                <b>{{ $item->mapel->nama }}</b>
                                <br>
                                <small>{{ $item->kelas->nama_kelas }}</small>
                                <br>
                                <small class="text-muted">
                                    {{ substr($item->jam_mulai,0,5) }} - {{ substr($item->jam_selesai,0,5) }}
                                </small>

                                <div class="mt-2">

                                    @if($pertemuan && $pertemuan->is_started && !$pertemuan->is_closed)

                                        <a href="{{ route('absensi.guru', ['mengajar_id' => $item->id]) }}"
                                           class="btn btn-sm btn-success">
                                            Absensi Terbuka
                                        </a>

                                    @elseif($pertemuan && $pertemuan->is_closed)

                                        <button class="btn btn-sm btn-danger" disabled>
                                            Pertemuan Selesai
                                        </button>

                                    @elseif($sudahSelesai)

                                        <button class="btn btn-sm btn-danger" disabled>
                                            Waktu Habis
                                        </button>

                                    @elseif($bolehValidasi)

                                        <form action="{{ route('jadwal.validasiAbsensi', $item->id) }}"
                                              method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                Validasi & Buka Absen
                                            </button>
                                        </form>

                                    @else

                                        <button class="btn btn-sm btn-secondary" disabled>
                                            Belum Bisa Validasi
                                        </button>

                                    @endif

                                </div>

                            @endif

                        @endforeach

                    </td>

                    @endforeach

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection