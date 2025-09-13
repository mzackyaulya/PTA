@extends('layout.main')
@section('title','Tambah Banner')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded-xl shadow">
  <h2 class="text-lg font-semibold mb-4">Tambah Banner</h2>
  <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm mb-1">Judul (opsional)</label>
      <input name="title" type="text" class="w-full border rounded px-3 py-2" value="{{ old('title') }}">
      @error('title')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>
    <div>
      <label class="block text-sm mb-1">Gambar *</label>
      <input name="image" type="file" accept=".jpg,.jpeg,.png,.webp" class="w-full">
      @error('image')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm mb-1">Urutan</label>
        <input name="sort_order" type="number" value="{{ old('sort_order',0) }}" class="w-full border rounded px-3 py-2">
      </div>
      <label class="flex items-center gap-2 mt-7">
        <input type="checkbox" name="is_active" value="1" checked> <span>Aktif</span>
      </label>
    </div>
    <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
  </form>
</div>
@endsection
