@extends('layout.main')
@section('title','Tambah Banner')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Tambah Banner</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 col-lg-4">

                    {{-- Judul --}}
                    <div class="form-group mb-3">
                        <label for="title">Judul (Opsional)</label>
                        <input type="text" class="form-control" id="title" name="title"
                               placeholder="Masukan Title jika butuh"
                               value="{{ old('title') }}">
                    </div>

                    {{-- Upload Gambar --}}
                    <div class="form-group mb-3">
                        <label for="image">Gambar Banner</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>

                    {{-- Urutan & Checkbox --}}
                    <div class="form-group d-flex align-items-center gap-3 mb-3">
                        <div>
                            <label for="sort_order">Urutan</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order"
                                   placeholder="Nomor Urutan Gambar"
                                   value="{{ old('sort_order') }}">
                        </div>
                        <div class="form-check d-flex align-items-center mb-0" style="margin-top: 30px;">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active">
                            <label class="form-check-label mb-0" for="is_active">Aktif</label>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan
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
