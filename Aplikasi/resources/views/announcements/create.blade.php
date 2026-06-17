@extends('layout.main')
@section('title','Tambah Pengumuman')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0 fw-bold">Tambah Pengumuman</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-7 col-lg-6">

                    {{-- Judul --}}
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               id="title"
                               name="title"
                               placeholder="Masukkan Judul Pengumuman"
                               value="{{ old('title') }}"
                               required>

                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tipe Pengumuman --}}
                    <div class="form-group mb-3">
                        <label for="type" class="form-label">Tipe Pengumuman</label>
                        <select class="form-control @error('type') is-invalid @enderror"
                                id="type"
                                name="type"
                                required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Gambar</option>
                            <option value="pdf" {{ old('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                            <option value="excel" {{ old('type') == 'excel' ? 'selected' : '' }}>Excel</option>
                        </select>

                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Isi Text --}}
                    <div class="form-group mb-3" id="text-field" style="display:none;">
                        <label for="body" class="form-label">Isi Pengumuman</label>
                        <textarea class="form-control @error('body') is-invalid @enderror"
                                  id="body"
                                  name="body"
                                  rows="5"
                                  placeholder="Masukkan isi pengumuman">{{ old('body') }}</textarea>

                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Upload File --}}
                    <div class="form-group mb-3" id="file-field" style="display:none;">
                        <label for="file" class="form-label" id="file-label">File Pengumuman</label>

                        <input type="file"
                               class="form-control @error('file') is-invalid @enderror"
                               id="file"
                               name="file">

                        <small class="text-muted d-block mt-1" id="file-help">
                            Pilih file sesuai tipe pengumuman.
                        </small>

                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Preview File --}}
                    <div class="form-group mb-3" id="preview-box" style="display:none;">
                        <label class="form-label">Preview</label>

                        <div class="border rounded p-3 bg-light text-center">
                            <img id="preview-image"
                                 src=""
                                 alt="Preview Gambar"
                                 class="img-fluid rounded"
                                 style="max-height: 250px; display:none; object-fit: contain;">

                            <div id="preview-file" style="display:none;">
                                <i id="preview-icon" class="fas fa-file fa-4x mb-3"></i>
                                <p class="mb-0 fw-semibold" id="preview-name"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal Terbit --}}
                    <div class="form-group mb-3">
                        <label for="published_at" class="form-label">Tanggal Terbit</label>
                        <input type="date"
                               class="form-control @error('published_at') is-invalid @enderror"
                               id="published_at"
                               name="published_at"
                               value="{{ old('published_at') ?? date('Y-m-d') }}"
                               required>

                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="form-group d-flex gap-2">
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const typeSelect = document.getElementById("type");
        const textField = document.getElementById("text-field");
        const fileField = document.getElementById("file-field");
        const fileInput = document.getElementById("file");
        const fileLabel = document.getElementById("file-label");
        const fileHelp = document.getElementById("file-help");

        const previewBox = document.getElementById("preview-box");
        const previewImage = document.getElementById("preview-image");
        const previewFile = document.getElementById("preview-file");
        const previewIcon = document.getElementById("preview-icon");
        const previewName = document.getElementById("preview-name");

        function resetPreview() {
            previewBox.style.display = "none";
            previewImage.style.display = "none";
            previewFile.style.display = "none";
            previewImage.src = "";
            previewName.innerText = "";
        }

        function toggleFields() {
            const type = typeSelect.value;

            resetPreview();
            fileInput.value = "";

            if (type === "text") {
                textField.style.display = "block";
                fileField.style.display = "none";
                fileInput.removeAttribute("required");
            } else if (type === "image") {
                textField.style.display = "none";
                fileField.style.display = "block";
                fileInput.setAttribute("required", "required");
                fileInput.setAttribute("accept", ".jpg,.jpeg,.png,.webp");

                fileLabel.innerText = "Upload Gambar Pengumuman";
                fileHelp.innerText = "Format gambar: JPG, JPEG, PNG, WEBP. Maksimal 5MB.";
            } else if (type === "pdf") {
                textField.style.display = "none";
                fileField.style.display = "block";
                fileInput.setAttribute("required", "required");
                fileInput.setAttribute("accept", ".pdf");

                fileLabel.innerText = "Upload File PDF";
                fileHelp.innerText = "Format file: PDF. Maksimal 5MB.";
            } else if (type === "excel") {
                textField.style.display = "none";
                fileField.style.display = "block";
                fileInput.setAttribute("required", "required");
                fileInput.setAttribute("accept", ".xls,.xlsx,.csv");

                fileLabel.innerText = "Upload File Excel";
                fileHelp.innerText = "Format file: XLS, XLSX, CSV. Maksimal 5MB.";
            } else {
                textField.style.display = "none";
                fileField.style.display = "none";
                fileInput.removeAttribute("required");
            }
        }

        fileInput.addEventListener("change", function () {
            resetPreview();

            const file = this.files[0];
            if (!file) return;

            const type = typeSelect.value;
            previewBox.style.display = "block";

            if (type === "image") {
                const reader = new FileReader();

                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = "block";
                };

                reader.readAsDataURL(file);
            } else {
                previewFile.style.display = "block";
                previewName.innerText = file.name;

                if (type === "pdf") {
                    previewIcon.className = "fas fa-file-pdf fa-4x mb-3 text-danger";
                } else if (type === "excel") {
                    previewIcon.className = "fas fa-file-excel fa-4x mb-3 text-success";
                } else {
                    previewIcon.className = "fas fa-file fa-4x mb-3 text-secondary";
                }
            }
        });

        typeSelect.addEventListener("change", toggleFields);
        toggleFields();
    });
</script>
@endsection