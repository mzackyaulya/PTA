@extends('layout.main')

@section('title','Tambah Pengumuman')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow">
  <h2 class="text-lg font-semibold mb-4">Tambah Pengumuman</h2>
  <form action="{{ route('announcements.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm mb-1">Judul *</label>
      <input name="title" type="text" class="w-full border rounded px-3 py-2" required value="{{ old('title') }}">
      @error('title')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>
    <div>
      <label class="block text-sm mb-1">Kategori (opsional)</label>
      <input name="category" type="text" class="w-full border rounded px-3 py-2" value="{{ old('category') }}" placeholder="Perlombaan / Akademik / Umum">
    </div>
    <div>
      <label class="block text-sm mb-1">Isi Pengumuman *</label>
      <textarea name="body" rows="6" class="w-full border rounded px-3 py-2" required>{{ old('body') }}</textarea>
      @error('body')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm mb-1">Mulai</label>
        <input name="starts_at" type="datetime-local" class="w-full border rounded px-3 py-2" value="{{ old('starts_at') }}">
      </div>
      <div>
        <label class="block text-sm mb-1">Selesai</label>
        <input name="ends_at" type="datetime-local" class="w-full border rounded px-3 py-2" value="{{ old('ends_at') }}">
      </div>
    </div>
    <label class="flex items-center gap-2">
      <input type="checkbox" name="is_published" value="1" checked> <span>Publikasikan</span>
    </label>
    <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
  </form>
</div>
@endsection
