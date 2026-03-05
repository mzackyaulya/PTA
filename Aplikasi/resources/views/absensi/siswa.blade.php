@extends('layout.main')

@section('title','Absensi Saya')

@section('content')
<style>
    .status-h{
        background:#d4edda;
        color:#155724;
        font-weight:bold;
        }

        .status-i{
        background:#ffeeba;
        color:#856404;
        }

        .status-a{
        background:#f8d7da;
        color:#721c24;
    }
</style>

<div class="card">

<div class="card-header d-flex justify-content-between">

<h4>Dashboard Kehadiran Siswa</h4>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>Mata Pelajaran</th>
<th>SKS</th>
<th>Kelas</th>

<th colspan="5" class="text-center">
Pertemuan
</th>

<th>Persentase Kehadiran</th>

</tr>

<tr>

<th></th>
<th></th>
<th></th>

<th>1</th>
<th>2</th>
<th>3</th>
<th>4</th>
<th>5</th>

<th></th>

</tr>

</thead>

<tbody>

@foreach($jadwal as $j)

<tr>

<td>{{ $j->mapel->nama }}</td>

<td>{{ $j->mapel->sks ?? '-' }}</td>

<td>{{ $j->kelas->nama_kelas }}</td>

<td>H</td>
<td>-</td>
<td>-</td>
<td>-</td>
<td>-</td>

<td>100%</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection