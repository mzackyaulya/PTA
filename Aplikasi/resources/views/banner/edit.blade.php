@extends('layout.main')
@section('title','Edit Banner')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Edit Banner</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 col-lg-4">

                    {{-- Judul --}}
                    <div class="form-group mb-3">
                        <label for="title">Judul (Opsional)</label>
                        <input type="text" class="form-control" id="title" name="title"
                               value="{{ old('title', $banner->title) }}">
                    </div>

                    {{-- Preview Gambar Lama --}}
                    <div class="mb-3">
                        <label>Gambar Sekarang</label><br>
                        <img src="{{ asset('storage/'.$banner->image_path) }}"
                             alt="Banner" class="img-thumbnail mb-2" style="max-width: 250px;">
                    </div>

                    {{-- Upload Gambar Baru --}}
                    <div class="form-group mb-3">
                        <label for="image">Ganti Gambar (Opsional)</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                    </div>

                    {{-- Tombol --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Update
                        </button>
                        <a href="{{ url('dashboard') }}" class="btn btn-danger">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection
