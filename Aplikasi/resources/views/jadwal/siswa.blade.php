@extends('layout.main')

@section('title','Jadwal Pelajaran')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Jadwal Pelajaran</h4>
    </div>

    <div class="card-body">

        @php
            $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

            $jam = [
                '07:00 - 08:30',
                '08:30 - 10:00',
                '10:10 - 12:00',
                '13:00 - 15:00',
            ];
        @endphp

        <table class="table table-bordered text-center">

            <thead class="table-dark">
                <tr>
                    <th style="width:150px">Jam</th>

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
                                        $jam_item = substr($item->jam_mulai,0,5).' - '.substr($item->jam_selesai,0,5);

                                        return $item->hari == $h && $jam_item == $j;
                                    });
                                @endphp

                                @if($jadwalItem)

                                    <b>{{ $jadwalItem->mapel->nama ?? '-' }}</b>
                                    <br>
                                    <small>{{ $jadwalItem->guru->nama ?? $jadwalItem->guru->user->name ?? '-' }}</small>

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