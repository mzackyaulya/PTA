@extends('layout.main')

@section('title','Materi')

@section('content')

<h4 class="mb-4">
Pilih Mata Pelajaran
</h4>

<div class="row">

@foreach($mapel as $m)

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<h5>

{{ $m->mapel->nama }}

</h5>

<a href="{{ route('materi.mapel',$m->mapel->id) }}"
class="btn btn-success w-100 mt-2">

Buka Materi

</a>

</div>

</div>

</div>

@endforeach

</div>

@endsection