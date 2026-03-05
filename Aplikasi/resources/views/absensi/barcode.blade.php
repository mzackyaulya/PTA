@extends('layout.main')

@section('title','QR Absensi')

@section('content')

<div class="card">

<div class="card-header">
<h4>QR Code Absensi</h4>
</div>

<div class="card-body text-center">

{!! QrCode::size(300)->generate(route('absensi.scan',$token)) !!}

<p class="mt-3">
Silakan siswa scan QR ini
</p>

</div>

</div>

@endsection