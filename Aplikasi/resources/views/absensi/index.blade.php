@extends('layout.main')

@section('title','Absensi')

@section('content')

<div class="card">

<div class="card-header">
<h4>Jadwal Mengajar Hari Ini</h4>
</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>
<th>No</th>
<th>Kelas</th>
<th>Mapel</th>
<th>Jam</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

@foreach($jadwal as $i => $j)

<tr>

<td>{{ $i+1 }}</td>

<td>{{ $j->kelas->nama_kelas }}</td>

<td>{{ $j->mapel->nama }}</td>

<td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>

<td>

<a href="{{ route('absensi.form',$j->id) }}"
class="btn btn-success btn-sm">

Mulai Absen

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection