@extends('layout.main')

@section('title', 'Upload Materi')

@section('content')

<div class="card">

    <div class="card-body">

        <h4>Upload Materi</h4>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form 
            action="{{ route('materi.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            {{-- Mata Pelajaran --}}
            <div class="mb-3">

                <label>Mata Pelajaran</label>

                <select name="mapel_id" class="form-control">

                    @foreach($mapel as $m)

                        <option value="{{ $m->id }}">
                            {{ $m->nama }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Materi Ke --}}
            <div class="mb-3">

                <label>Materi Ke</label>

                <input 
                    type="number"
                    name="materi"
                    class="form-control"
                    placeholder="contoh: 1"
                >

            </div>


            {{-- Judul Materi --}}
            <div class="mb-3">

                <label>Judul Materi</label>

                <input 
                    type="text"
                    name="judul"
                    class="form-control"
                >

            </div>


            {{-- Deskripsi --}}
            <div class="mb-3">

                <label>Deskripsi</label>

                <textarea 
                    name="deskripsi"
                    class="form-control"
                ></textarea>

            </div>


            {{-- File Materi --}}
            <div class="mb-3">

                <label>File Materi</label>

                <input 
                    type="file"
                    name="file"
                    class="form-control"
                >

            </div>


            <button class="btn btn-success">
                Upload Materi
            </button>

        </form>

    </div>

</div>

@endsection