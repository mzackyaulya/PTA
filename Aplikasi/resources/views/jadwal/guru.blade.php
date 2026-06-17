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

            $jam = [
                '07:00 - 08:30',
                '08:30 - 10:00',
                '10:10 - 12:00',
                '13:00 - 15:00',
            ];

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

                                @php
                                    $jadwalItem = $jadwal->first(function($item) use ($h, $j) {
                                        $jam_item = substr($item->jam_mulai, 0, 5).' - '.substr($item->jam_selesai, 0, 5);

                                        return $item->hari == $h && $jam_item == $j;
                                    });
                                @endphp

                                @if($jadwalItem)

                                    @php
                                        $pertemuan = PertemuanAbsensi::where('mengajar_id', $jadwalItem->id)
                                            ->whereDate('tanggal', $tanggalHariIni)
                                            ->first();

                                        $jamMulai = Carbon::parse($tanggalHariIni.' '.$jadwalItem->jam_mulai);
                                        $jamSelesai = Carbon::parse($tanggalHariIni.' '.$jadwalItem->jam_selesai);
                                        $waktuValidasi = $jamMulai->copy()->subMinutes(5);

                                        $bolehValidasi = $h == $hariIni
                                            && $sekarang->between($waktuValidasi, $jamSelesai);

                                        $sudahSelesai = $h == $hariIni && $sekarang->gt($jamSelesai);
                                    @endphp

                                    <b>{{ $jadwalItem->mapel->nama }}</b>
                                    <br>

                                    <small>{{ $jadwalItem->kelas->tingkat }} {{ $jadwalItem->kelas->nama_kelas }}</small>
                                    <br>

                                    <small class="text-muted">
                                        {{ substr($jadwalItem->jam_mulai, 0, 5) }}
                                        -
                                        {{ substr($jadwalItem->jam_selesai, 0, 5) }}
                                    </small>

                                    <div class="mt-2">

                                        @if($pertemuan && $pertemuan->is_approved && $pertemuan->is_started && !$pertemuan->is_closed)

                                            <a href="{{ route('absensi.guru', ['mengajar_id' => $jadwalItem->id]) }}"
                                            class="btn btn-sm btn-success">
                                                Telah Validasi
                                            </a>

                                        @elseif($pertemuan && $pertemuan->is_closed)

                                            <button class="btn btn-sm btn-danger" disabled>
                                                Pertemuan Selesai
                                            </button>

                                        @elseif($pertemuan && !$pertemuan->is_approved)

                                            <button class="btn btn-sm btn-warning text-dark" disabled>
                                                Menunggu Admin
                                            </button>

                                        @elseif($sudahSelesai)

                                            <button class="btn btn-sm btn-danger" disabled>
                                                Waktu Habis
                                            </button>

                                        @else

                                            <button class="btn btn-sm btn-secondary" disabled>
                                                Belum bisa Validasi
                                            </button>

                                        @endif
                                    </div>

                                @else

                                    <span class="text-muted">-</span>

                                @endif

                            </td>

                        @endforeach

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection