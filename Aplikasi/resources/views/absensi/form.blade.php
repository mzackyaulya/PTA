@extends('layout.main')

@section('title','Absensi Siswa')

@section('content')

<form action="{{ route('absensi.store') }}" method="POST">

@csrf

<input type="hidden" name="mengajar_id" value="{{ $mengajar->id }}">

<table class="table table-bordered">

<thead>

<tr>
<th>No</th>
<th>Nama Siswa</th>
<th>Hadir</th>
<th>Izin</th>
<th>Sakit</th>
<th>Alpa</th>
<th>Keterangan</th>
</tr>

</thead>

<tbody>

@foreach($siswa as $i => $s)

<tr>

<td>{{ $i+1 }}</td>

<td>{{ $s->siswa->user->name }}</td>

<td>
<input type="radio" name="status[{{ $s->siswa->id }}]" value="hadir">
</td>

<td>
<input type="radio" name="status[{{ $s->siswa->id }}]" value="izin">
</td>

<td>
<input type="radio" name="status[{{ $s->siswa->id }}]" value="sakit">
</td>

<td>
<input type="radio" name="status[{{ $s->siswa->id }}]" value="alpa">
</td>

<td>
<input type="text"
name="keterangan[{{ $s->siswa->id }}]"
class="form-control">
</td>

</tr>

@endforeach

</tbody>

</table>

<button class="btn btn-primary">
Simpan
</button>

</form>

@endsection