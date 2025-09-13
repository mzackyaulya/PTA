@extends('layout.main')
@section('title','Tambah Pengumuman')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Tambah Pengumuman</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 col-lg-6">

                    {{-- Judul --}}
                    <div class="form-group mb-3">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control" id="title" name="title"
                               placeholder="Masukan Judul Pengumuman"
                               value="{{ old('title') }}" required>
                    </div>

                    {{-- Tipe Pengumuman --}}
                    <div class="form-group mb-3">
                        <label for="type">Tipe Pengumuman</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="text" {{ old('type')=='text' ? 'selected' : '' }}>Text</option>
                            <option value="image" {{ old('type')=='image' ? 'selected' : '' }}>Gambar</option>
                        </select>
                    </div>

                    {{-- Isi Text --}}
                    <div class="form-group mb-3" id="text-field" style="display:none;">
                        <label for="body">Isi Pengumuman</label>
                        <textarea class="form-control" id="body" name="body" rows="5"
                                  placeholder="Masukan isi pengumuman">{{ old('body') }}</textarea>
                    </div>

                    {{-- Upload Gambar --}}
                    <div class="form-group mb-3" id="image-field" style="display:none;">
                        <label for="image">Gambar Pengumuman</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    {{-- Tanggal Terbit --}}
                    <div class="form-group mb-3">
                        <label for="published_at">Tanggal Terbit</label>
                        <input type="date" class="form-control" id="published_at" name="published_at"
                               value="{{ old('published_at') ?? date('Y-m-d') }}">
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

{{-- Script untuk toggle field --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const typeSelect = document.getElementById("type");
        const textField = document.getElementById("text-field");
        const imageField = document.getElementById("image-field");

        function toggleFields() {
            if (typeSelect.value === "text") {
                textField.style.display = "block";
                imageField.style.display = "none";
            } else if (typeSelect.value === "image") {
                textField.style.display = "none";
                imageField.style.display = "block";
            } else {
                textField.style.display = "none";
                imageField.style.display = "none";
            }
        }

        typeSelect.addEventListener("change", toggleFields);
        toggleFields(); // jalankan saat pertama kali
    });
</script>
@endsection
