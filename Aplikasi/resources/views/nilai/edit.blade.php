@extends('layout.main')

@section('title','Edit Nilai')

@section('content')

<div class="card">

    <div class="card-header">
        <h4>Edit Nilai</h4>
    </div>

    <div class="card-body">

        <form action="{{ url('guru/nilai/update/'.$nilai->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label>Tugas</label>

                <input type="number"
                       name="tugas"
                       class="form-control"
                       value="{{ $nilai->tugas }}">

            </div>


            <div class="mb-3">

                <label>UTS</label>

                <input type="number"
                       name="uts"
                       class="form-control"
                       value="{{ $nilai->uts }}">

            </div>


            <div class="mb-3">

                <label>UAS</label>

                <input type="number"
                       name="uas"
                       class="form-control"
                       value="{{ $nilai->uas }}">

            </div>


            <button class="btn btn-primary">

                Update Nilai

            </button>

        </form>

    </div>

</div>

@endsection