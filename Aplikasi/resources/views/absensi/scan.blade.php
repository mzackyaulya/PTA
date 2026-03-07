@extends('layout.main')

@section('title','Scan QR Absensi')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            Scan QR Absensi
        </div>

        <div class="card-body text-center">

            <p>Scan QR dari guru untuk melakukan absensi</p>

            <div id="reader" style="width:300px;margin:auto;"></div>

        </div>

    </div>

</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>

function onScanSuccess(decodedText) {

    window.location.href = decodedText;

}

let scanner = new Html5QrcodeScanner(
    "reader",
    { fps:10, qrbox:250 }
);

scanner.render(onScanSuccess);

</script>

@endsection