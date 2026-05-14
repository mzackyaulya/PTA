@extends('layout.main')

@section('title', 'Buat Permohonan Surat')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Permohonan Pembuatan Surat</h1>

    {{-- Alert Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('surat.store') }}" method="POST" id="formPengajuan">
        @csrf
        
        <input type="hidden" name="jenis_surat" id="jenis_surat" value="{{ old('jenis_surat') }}" required>

        <div class="card shadow mb-4">
            <div class="card-body">
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">NIS</label>
                        <input type="text" class="form-control rounded-pill bg-light" value="{{ Auth::user()->siswa->nis ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Nama Lengkap</label>
                        <input type="text" class="form-control rounded-pill bg-light" value="{{ Auth::user()->name ?? '-' }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">No. HP</label>
                        <input type="text" class="form-control rounded-pill bg-light" value="{{ Auth::user()->siswa->nohp ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Tanggal Lahir</label>
                        <input type="text" class="form-control rounded-pill bg-light" value="{{ isset(Auth::user()->siswa->tanggal_lahir) ? \Carbon\Carbon::parse(Auth::user()->siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}" readonly>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label class="form-label font-weight-bold">Alamat</label>
                        <input type="text" class="form-control bg-light" value="{{ Auth::user()->siswa->alamat ?? '-' }}" readonly>
                    </div>
                </div>

                <hr class="sidebar-divider">

                <label class="form-label font-weight-bold text-primary mb-3">Silahkan Pilih Jenis Surat yang Ingin Diajukan:</label>
                <div class="row">
                    @php
                        $jenisSuratOptions = [
                            'dispensasi' => ['icon' => 'fas fa-file-signature', 'label' => 'Surat Dispensasi'],
                            'permohonan_lomba' => ['icon' => 'fas fa-trophy', 'label' => 'Surat Izin Lomba'],
                            'permohonan_organisasi' => ['icon' => 'fas fa-users', 'label' => 'Surat Izin Organisasi'],
                            'izin_kegiatan' => ['icon' => 'fas fa-calendar-check', 'label' => 'Izin Kegiatan'],
                            'keterangan' => ['icon' => 'fas fa-file-alt', 'label' => 'Surat Keterangan'],
                            'lainnya' => ['icon' => 'fas fa-folder-open', 'label' => 'Lainnya'],
                        ];
                    @endphp

                    @foreach($jenisSuratOptions as $value => $data)
                        <div class="col-xl-4 col-md-6 mb-3">
                            <div class="card border-left-primary shadow-sm h-100 py-2 jenis-surat-card cursor-pointer" data-type="{{ $value }}">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pilih Jenis Ini</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $data['label'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="{{ $data['icon'] }} fa-2x text-gray-300 icon-surat"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card " id="form_details" style="display: none;">
            <div class="card-body">
                <h6 class="m-0 font-weight-bold mb-3 fw-bold">Informasi Detail Pengajuan</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Judul Surat <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" placeholder="Contoh: Permohonan Dispensasi Lomba Futsal">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" value="{{ old('nama_kegiatan') }}" placeholder="Contoh: Lomba Futsal Antar Sekolah">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Tempat Kegiatan</label>
                        <input type="text" name="tempat_kegiatan" class="form-control" value="{{ old('tempat_kegiatan') }}" placeholder="Contoh: GOR Dempo Palembang">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}">
                    </div>

                    <div class="col-md-6 mb-3" id="field_pelatih">
                        <label class="form-label font-weight-bold">Nama Pelatih / Pembina</label>
                        <input type="text" name="nama_pelatih" class="form-control" value="{{ old('nama_pelatih') }}" placeholder="Contoh: Bapak Ahmad">
                    </div>

                    <div class="col-md-6 mb-3" id="field_organisasi">
                        <label class="form-label font-weight-bold">Nama Organisasi</label>
                        <input type="text" name="nama_organisasi" class="form-control" value="{{ old('nama_organisasi') }}" placeholder="Contoh: IPM / OSIS / Tapak Suci">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label font-weight-bold">Keperluan / Alasan Pengajuan <span class="text-danger">*</span></label>
                        <textarea name="keperluan" class="form-control" rows="5" placeholder="Tuliskan alasan atau keperluan surat...">{{ old('keperluan') }}</textarea>
                    </div>

                    {{-- Checkbox Kelompok & Form Dinamis Anggota --}}
                    <div class="col-md-12 mb-3">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_kelompok" name="is_kelompok" value="1">
                            <label class="form-check-label fw-bold " for="is_kelompok">
                                <i class="fas fa-users me-1"></i> Project Mandiri Berkelompok / Tim
                            </label>
                        </div>

                        {{-- Container Anggota Tim (Disembunyikan secara default) --}}
                        <div id="anggota_tim_container" class="p-3 border rounded bg-light" style="display: none;">          
                            <div id="dynamic_fields">
                                {{-- Baris Input Pertama --}}
                                <div class="row mb-2 anggota-row">
                                    <div class="col-md-4 mb-2">
                                        <label class=" mb-1 fw-bold"> NIS Patner </label>
                                        <input type="text" class="form-control nis-input" placeholder="Masukkan NIS Patner">
                                        {{-- Input hidden ini yang akan dikirim ke controller sebagai siswa_ids[] --}}
                                        <input type="hidden" name="siswa_ids[]" class="siswa-id-hidden">
                                    </div>
                                    <div class="col-md-7 mb-2">
                                        <label class=" mb-1 fw-bold"> Nama Patner </label>
                                        <input type="text" class="form-control nama-input bg-white" placeholder="Nama Patner" readonly>
                                    </div>
                                    <div class="col-md-1 mb-2 d-flex align-items-center">
                                        {{-- Kosong untuk baris pertama agar tidak bisa dihapus --}}
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-sm btn-success mt-2" id="btn_add_anggota">
                                <i class="fas fa-plus"></i> Tambah Anggota
                            </button>
                            <small class="d-block mt-2 text-muted">* Ketik NIS dengan benar agar Nama Siswa otomatis muncul.</small>
                        </div>
                    </div>

                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Ajukan Permohonan Surat
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .cursor-pointer { cursor: pointer; transition: all 0.2s; }
    .cursor-pointer:hover { transform: translateY(-3px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
    .card-active { background-color: #f8f9fc !important; border: 2px solid #4e73df !important; }
    .card-active .icon-surat { color: #4e73df !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.jenis-surat-card');
    const inputJenisSurat = document.getElementById('jenis_surat');
    const formDetails = document.getElementById('form_details');

    function selectCard(type) {
        cards.forEach(c => c.classList.remove('card-active'));
        const targetCard = document.querySelector(`.jenis-surat-card[data-type="${type}"]`);
        if(targetCard) targetCard.classList.add('card-active');

        inputJenisSurat.value = type;
        formDetails.style.display = 'block';
        toggleSpecificFields(type);
        formDetails.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function toggleSpecificFields(jenisSurat) {
        const fieldPelatih = document.getElementById('field_pelatih');
        const fieldOrganisasi = document.getElementById('field_organisasi');
        fieldPelatih.style.display = 'block';
        fieldOrganisasi.style.display = 'block';

        if (jenisSurat === 'permohonan_organisasi') {
            fieldPelatih.style.display = 'none';
        } else if (jenisSurat === 'dispensasi' || jenisSurat === 'permohonan_lomba') {
            fieldOrganisasi.style.display = 'none';
        }
    }

    cards.forEach(card => {
        card.addEventListener('click', function() {
            selectCard(this.dataset.type);
        });
    });

    if (inputJenisSurat.value) {
        selectCard(inputJenisSurat.value);
    }

    // === FITUR ANGGOTA KELOMPOK DINAMIS ===
    
    // 1. Ubah data siswa dari database PHP ke format Object JavaScript
    const siswaData = {};
    @foreach($siswas as $s)
        siswaData["{{ $s->nis }}"] = {
            id: "{{ $s->id }}",
            name: "{{ $s->user->name ?? 'Nama tidak tersedia' }}"
        };
    @endforeach

    const cbKelompok = document.getElementById('is_kelompok');
    const containerTim = document.getElementById('anggota_tim_container');
    const btnAddAnggota = document.getElementById('btn_add_anggota');
    const wrapper = document.getElementById('dynamic_fields');

    // 2. Munculkan/Sembunyikan form tim saat checkbox di klik
    cbKelompok.addEventListener('change', function() {
        if (this.checked) {
            containerTim.style.display = 'block';
        } else {
            containerTim.style.display = 'none';
            // Opsional: Bersihkan input jika batal centang
            document.querySelectorAll('.nis-input').forEach(input => input.value = '');
            document.querySelectorAll('.nama-input').forEach(input => input.value = '');
            document.querySelectorAll('.siswa-id-hidden').forEach(input => input.value = '');
        }
    });

    // 3. Fungsi untuk mencari nama berdasarkan NIS yang diketik
    function attachNisListener(inputElement) {
        inputElement.addEventListener('input', function() {
            const nis = this.value.trim();
            const row = this.closest('.anggota-row');
            const namaInput = row.querySelector('.nama-input');
            const idHidden = row.querySelector('.siswa-id-hidden');
            
            // Jika NIS ada di data siswa
            if (siswaData[nis]) {
                namaInput.value = siswaData[nis].name;
                idHidden.value = siswaData[nis].id; // Masukkan ID ke hidden input untuk backend
                namaInput.classList.add('is-valid');
            } else {
                namaInput.value = '';
                idHidden.value = '';
                namaInput.classList.remove('is-valid');
            }
        });
    }

    // Terapkan fungsi ke input baris pertama
    document.querySelectorAll('.nis-input').forEach(attachNisListener);

    // 4. Tambah baris anggota baru jika tombol '+' diklik
    btnAddAnggota.addEventListener('click', function() {
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2 anggota-row';
        newRow.innerHTML = `
            <div class="col-md-4 mb-2">
                <input type="text" class="form-control nis-input" placeholder="Masukkan NIS">
                <input type="hidden" name="siswa_ids[]" class="siswa-id-hidden">
            </div>
            <div class="col-md-7 mb-2">
                <input type="text" class="form-control nama-input bg-white" placeholder="Nama siswa otomatis tampil" readonly>
            </div>
            <div class="col-md-1 mb-2 d-flex align-items-center">
                <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
            </div>
        `;
        wrapper.appendChild(newRow);
        
        // Aktifkan fitur cari NIS di baris baru
        attachNisListener(newRow.querySelector('.nis-input'));
        
        // Aktifkan tombol hapus di baris baru
        newRow.querySelector('.remove-row').addEventListener('click', function() {
            newRow.remove();
        });
    });
});
</script>
@endsection