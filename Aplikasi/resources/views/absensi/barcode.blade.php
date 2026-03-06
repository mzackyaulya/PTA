@extends('layout.main')

@section('content')

<div class="container">

    <div class="card shadow text-center">

        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                Barcode Absensi
            </h5>
        </div>

        <div class="card-body">

            <p>
                Silahkan scan QR Code untuk melakukan absensi
            </p>

            <div class="mt-4">

                {!! QrCode::size(250)
                        ->generate(route('absensi.scan',$barcode->token)) !!}

            </div>

            <div class="mt-4">

                <p class="text-danger">

                    QR berlaku sampai
                    {{ $barcode->expired_at }}

                </p>

            </div>

        </div>

    </div>

</div>

@endsection