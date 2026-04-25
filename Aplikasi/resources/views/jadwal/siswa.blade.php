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

        // ambil semua jam unik
        $jam = $jadwal->sortBy('jam_mulai')
                      ->map(function($j){
                            return substr($j->jam_mulai,0,5).' - '.substr($j->jam_selesai,0,5);
                      })
                      ->unique();
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

                    @foreach($jadwal as $item)

                        @php
                            $jam_item = substr($item->jam_mulai,0,5).' - '.substr($item->jam_selesai,0,5);
                        @endphp

                        @if($item->hari == $h && $jam_item == $j)

                            <b>{{ $item->mapel->nama }}</b>
                            <br>
                            <small>{{ $item->guru->nama }}</small>

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
