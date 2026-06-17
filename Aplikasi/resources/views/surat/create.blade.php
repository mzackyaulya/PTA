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
                        <label class="form-label font-weight-bold">NIS <span class="text-danger">*</span></label>
                        @if(auth()->user()->role === 'siswa')
                            <input type="text" class="form-control rounded-pill bg-light" value="{{ Auth::user()->siswa->nis ?? '-' }}" readonly>
                            <input type="hidden" name="pengaju_user_id" value="{{ Auth::id() }}">
                        @else
                            <input type="text" name="nis_pengaju" id="nis_pengaju" class="form-control rounded-pill {{ $errors->has('nis_pengaju') ? 'is-invalid' : '' }}" value="{{ old('nis_pengaju') }}" placeholder="Masukkan NIS Siswa Pemohon" required>
                            <input type="hidden" name="pengaju_user_id" id="pengaju_user_id" value="{{ old('pengaju_user_id') }}" required>
                        @endif
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Nama Lengkap</label>
                        <input type="text" id="nama_pengaju" class="form-control rounded-pill bg-light" value="{{ auth()->user()->role === 'siswa' ? (Auth::user()->name ?? '-') : '' }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">No. HP</label>
                        <input type="text" id="nohp_pengaju" class="form-control rounded-pill bg-light" value="{{ auth()->user()->role === 'siswa' ? (Auth::user()->siswa->nohp ?? '-') : '' }}" readonly>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold">Tanggal Lahir</label>
                        <input type="text" id="tgl_lahir_pengaju" class="form-control rounded-pill bg-light" value="{{ auth()->user()->role === 'siswa' ? (isset(Auth::user()->siswa->tanggal_lahir) ? \Carbon\Carbon::parse(Auth::user()->siswa->tanggal_lahir)->translatedFormat('d F Y') : '-') : '' }}" readonly>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label class="form-label font-weight-bold">Alamat</label>
                        <input type="text" id="alamat_pengaju" class="form-control bg-light" value="{{ auth()->user()->role === 'siswa' ? (Auth::user()->siswa->alamat ?? '-') : '' }}" readonly>
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

        <div class="card shadow mb-4" id="form_details" style="display: none;">
            <div class="card-body">
                <h6 class="m-0 font-weight-bold mb-3 text-gray-800">Informasi Detail Pengajuan</h6>
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
                            <input class="form-check-input" type="checkbox" id="is_kelompok" name="is_kelompok" value="1" {{ old('is_kelompok') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label font-weight-bold text-gray-800" for="is_kelompok">
                                <i class="fas fa-users mr-1"></i> Project Mandiri Berkelompok / Tim
                            </label>
                        </div>

                        {{-- Container Anggota Tim --}}
                        <div id="anggota_tim_container" class="p-3 border rounded bg-light" style="display: none;">         
                            
                            <div class="row mb-1 font-weight-bold text-gray-700 d-none d-md-flex">
                                <div class="col-md-4">NIS Partner</div>
                                <div class="col-md-7">Nama Partner</div>
                                <div class="col-md-1">Aksi</div>
                            </div>

                            <div id="dynamic_fields">
                                {{-- Baris Input Pertama (Default) --}}
                                <div class="row mb-2 anggota-row">
                                    <div class="col-md-4 mb-2">
                                        <span class="d-md-none font-weight-bold mb-1 d-block">NIS Partner</span>
                                        <input type="text" class="form-control nis-input" placeholder="Masukkan NIS Partner">
                                        <input type="hidden" name="siswa_ids[]" class="siswa-id-hidden">
                                    </div>
                                    <div class="col-md-7 mb-2">
                                        <span class="d-md-none font-weight-bold mb-1 d-block">Nama Partner</span>
                                        <input type="text" class="form-control nama-input bg-white" placeholder="Nama Partner otomatis muncul" readonly>
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

{{-- LAKUKAN MAPPING DATA PHP DI SINI AGAR TIDAK MEMBUAT COMPILER BLADE ERROR --}}
@php
    $siswaJsonData = $siswas->mapWithKeys(function($s) {
        return [$s->nis => [
            'id' => $s->id,
            'user_id' => $s->user->id ?? '',
            'name' => $s->user->name ?? 'Nama tidak tersedia',
            'nohp' => $s->nohp ?? '-',
            'tanggal_lahir' => isset($s->tanggal_lahir) ? \Carbon\Carbon::parse($s->tanggal_lahir)->translatedFormat('d F Y') : '-',
            'alamat' => $s->alamat ?? '-'
        ]];
    });
@endphp

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.jenis-surat-card');
    const inputJenisSurat = document.getElementById('jenis_surat');
    const formDetails = document.getElementById('form_details');

    // Memanggil variabel yang sudah bersih dan matang dari blok @php di atas
    const siswaData = @json($siswaJsonData);

    function selectCard(type) {
        cards.forEach(c => c.classList.remove('card-active'));
        const targetCard = document.querySelector(`.jenis-surat-card[data-type="${type}"]`);
        if(targetCard) targetCard.classList.add('card-active');

        inputJenisSurat.value = type;
        formDetails.style.display = 'block';
        toggleSpecificFields(type);
    }

    function toggleSpecificFields(jenisSurat) {
        const fieldPelatih = document.getElementById('field_pelatih');
        const fieldOrganisasi = document.getElementById('field_organisasi');
        
        // Reset default tampil
        fieldPelatih.style.display = 'block';
        fieldOrganisasi.style.display = 'block';

        if (jenisSurat === 'permohonan_organisasi') {
            fieldPelatih.style.display = 'none';
        } else if (jenisSurat === 'dispensasi' || jenisSurat === 'permohonan_lomba') {
            fieldOrganisasi.style.display = 'none';
        } else if (jenisSurat === 'keterangan' || jenisSurat === 'lainnya') {
            fieldPelatih.style.display = 'none';
            fieldOrganisasi.style.display = 'none';
        }
    }

    cards.forEach(card => {
        card.addEventListener('click', function() {
            selectCard(this.dataset.type);
            formDetails.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    // Jalankan jika ada nilai lama (old data jenis surat)
    if (inputJenisSurat.value) {
        selectCard(inputJenisSurat.value);
    }

    // === FITUR AUTO-FILL DATA PENGAJU UNTUK ADMIN / WAKA ===
    const nisPengaju = document.getElementById('nis_pengaju');
    if (nisPengaju) {
        function autoFillPengaju(nis) {
            const namaInput = document.getElementById('nama_pengaju');
            const nohpInput = document.getElementById('nohp_pengaju');
            const tglLahirInput = document.getElementById('tgl_lahir_pengaju');
            const alamatInput = document.getElementById('alamat_pengaju');
            const userIdHidden = document.getElementById('pengaju_user_id');

            if (siswaData[nis]) {
                namaInput.value = siswaData[nis].name;
                nohpInput.value = siswaData[nis].nohp;
                tglLahirInput.value = siswaData[nis].tanggal_lahir;
                alamatInput.value = siswaData[nis].alamat;
                userIdHidden.value = siswaData[nis].user_id;
                
                nisPengaju.classList.remove('is-invalid');
                nisPengaju.classList.add('is-valid');
            } else {
                namaInput.value = '';
                nohpInput.value = '';
                tglLahirInput.value = '';
                alamatInput.value = '';
                userIdHidden.value = '';
                
                nisPengaju.classList.remove('is-valid');
                if (nis.length > 0) {
                    nisPengaju.classList.add('is-invalid');
                }
            }
        }

        nisPengaju.addEventListener('input', function() {
            autoFillPengaju(this.value.trim());
        });

        if(nisPengaju.value) {
            autoFillPengaju(nisPengaju.value.trim());
        }
    }

    // === FITUR ANGGOTA KELOMPOK DINAMIS ===
    const cbKelompok = document.getElementById('is_kelompok');
    const containerTim = document.getElementById('anggota_tim_container');
    const btnAddAnggota = document.getElementById('btn_add_anggota');
    const wrapper = document.getElementById('dynamic_fields');

    function toggleAnggotaInputs(isEnabled) {
        const inputs = containerTim.querySelectorAll('input');
        inputs.forEach(input => {
            input.disabled = !isEnabled;
        });
    }

    cbKelompok.addEventListener('change', function() {
        if (this.checked) {
            containerTim.style.display = 'block';
            toggleAnggotaInputs(true);
        } else {
            containerTim.style.display = 'none';
            toggleAnggotaInputs(false);
            
            // Reset fields
            document.querySelectorAll('.nis-input').forEach(input => input.value = '');
            document.querySelectorAll('.nama-input').forEach(input => {
                input.value = '';
                input.classList.remove('is-valid');
            });
            document.querySelectorAll('.siswa-id-hidden').forEach(input => input.value = '');
        }
    });

    function attachNisListener(inputElement) {
        inputElement.addEventListener('input', function() {
            const nis = this.value.trim();
            const row = this.closest('.anggota-row');
            const namaInput = row.querySelector('.nama-input');
            const idHidden = row.querySelector('.siswa-id-hidden');
            
            if (siswaData[nis]) {
                namaInput.value = siswaData[nis].name;
                idHidden.value = siswaData[nis].id;
                namaInput.classList.add('is-valid');
            } else {
                namaInput.value = '';
                idHidden.value = '';
                namaInput.classList.remove('is-valid');
            }
        });
    }

    function addNewRow(nisValue = '', idValue = '', namaValue = '') {
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2 anggota-row';
        newRow.innerHTML = `
            <div class="col-md-4 mb-2">
                <span class="d-md-none font-weight-bold mb-1 d-block">NIS Partner</span>
                <input type="text" class="form-control nis-input" placeholder="Masukkan NIS Partner" value="${nisValue}">
                <input type="hidden" name="siswa_ids[]" class="siswa-id-hidden" value="${idValue}">
            </div>
            <div class="col-md-7 mb-2">
                <span class="d-md-none font-weight-bold mb-1 d-block">Nama Partner</span>
                <input type="text" class="form-control nama-input bg-white ${namaValue ? 'is-valid' : ''}" placeholder="Nama Partner" value="${namaValue}" readonly>
            </div>
            <div class="col-md-1 mb-2 d-flex align-items-center">
                <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
            </div>
        `;
        wrapper.appendChild(newRow);
        attachNisListener(newRow.querySelector('.nis-input'));
        
        newRow.querySelector('.remove-row').addEventListener('click', function() {
            newRow.remove();
        });
    }

    // Terapkan listener ke baris pertama bawaan HTML
    document.querySelectorAll('.nis-input').forEach(attachNisListener);

    btnAddAnggota.addEventListener('click', function() {
        addNewRow();
    });

    // === RESTORE OLD DATA KELOMPOK JIKA VALIDASI GAGAL ===
    const oldSiswaIds = @json(old('siswa_ids', []));
    if (cbKelompok.checked) {
        containerTim.style.display = 'block';
        toggleAnggotaInputs(true);

        if (oldSiswaIds.length > 0) {
            // Isi baris pertama
            const firstRow = wrapper.querySelector('.anggota-row');
            const firstId = oldSiswaIds[0];
            let firstNis = Object.keys(siswaData).find(key => siswaData[key].id == firstId);
            
            if (firstNis) {
                firstRow.querySelector('.nis-input').value = firstNis;
                firstRow.querySelector('.siswa-id-hidden').value = firstId;
                firstRow.querySelector('.nama-input').value = siswaData[firstNis].name;
                firstRow.querySelector('.nama-input').classList.add('is-valid');
            }

            // Generate baris berikutnya jika ada sisa data lama
            for (let i = 1; i < oldSiswaIds.length; i++) {
                const id = oldSiswaIds[i];
                let nis = Object.keys(siswaData).find(key => siswaData[key].id == id);
                if (nis) {
                    addNewRow(nis, id, siswaData[nis].name);
                }
            }
        }
    } else {
        toggleAnggotaInputs(false); // Matikan input jika di awal load tidak dicentang
    }
});
</script>
@endsection