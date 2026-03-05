@extends('layout.main')

@section('title','Jadwal Mengajar Guru')

@section('content')

<div class="card">

    <div class="card-header">
        <h4>Jadwal Mengajar Guru</h4>
    </div>

    <div class="card-body">

        @php
            $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

            $jam = $jadwal->sortBy('jam_mulai')
                ->map(function($j){
                    return substr($j->jam_mulai,0,5).' - '.substr($j->jam_selesai,0,5);
                })
                ->unique();
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
                            @endphp

                            @if($item->hari == $h && $jam_item == $j)

                                <b>{{ $item->mapel->nama }}</b>
                                <br>
                                <small>{{ $item->kelas->nama_kelas }}</small>

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