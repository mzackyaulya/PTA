@extends('layout.main')

@section('title','Penempatan Siswa')

@section('content')
<style>
    .modal {
        z-index: 99999 !important;
    }

    .modal-backdrop {
        z-index: 99998 !important;
    }

    .modal-dialog,
    .modal-content {
        pointer-events: auto !important;
    }
</style>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h4 class="mb-0 text-dark font-weight-bold">Penempatan Siswa</h4>
        <small class="text-muted d-block mt-1">
            Tahun Ajaran Aktif: 
            <span class="text-primary font-weight-bold">{{ $tahunAktif->tahun ?? '-' }}</span>
            {{ $tahunAktif ? '(' . $tahunAktif->semester . ')' : '' }}
        </small>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light text-secondary text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                    <tr>
                        <th class="text-center" width="8%]">No</th>
                        <th class="text-center">Tingkat</th>
                        <th class="text-center">Kelas</th>
                        <th class="text-center">Jumlah Siswa</th>
                        <th class="text-center" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $i => $k)
                        <tr>
                            <td class="text-center font-weight-bold text-muted">{{ $i + 1 }}</td>
                            <td class="text-center">{{ $k->tingkat ?? '-' }}</td>
                            <td class="font-weight-bold text-center">{{ $k->nama_kelas }}</td>
                            <td class="text-center">
                                <span class="font-weight-bold">{{ $k->jumlah_siswa }}</span>
                            </td>
                            <td class="text-center">
                                <button 
                                    type="button"
                                    class="btn btn-primary btn-sm px-3 shadow-sm btnTambahSiswa"
                                    data-id="{{ $k->id }}"
                                    data-kelas="{{ $k->nama_kelas }}"
                                    data-max="{{ $k->max_siswa ?? 20 }}"  {{-- Mengambil batas max siswa --}}
                                >
                                    Tambah Siswa
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data kelas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSiswa" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header bg-light py-3">
                <h5 class="modal-title font-weight-bold text-dark">
                    Tambah Siswa ke Kelas <span id="namaKelas"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formSiswa" method="POST" action="{{ route('riwayatkelas.store') }}">
                @csrf

                <div class="modal-body" style="max-height: 60vh;">

                    <input type="hidden" name="kelas_id" id="kelas_id">

                    <div id="loading" class="text-center py-5 text-muted">
                        <div class="spinner-border spinner-border-sm me-2 text-primary" role="status"></div>
                        Memuat data siswa...
                    </div>

                    <div id="listSiswa" style="display:none">
                        <table class="table table-bordered table-striped table-hover align-middle mb-0">
                            <thead class="table-light text-secondary text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="text-center" width="7%">
                                        <input type="checkbox" id="checkAll" class="form-check-input">
                                    </th>
                                    <th>Nama Lengkap</th>
                                    <th class="text-center" width="25%">NISN</th>
                                    <th class="text-center" width="20%">Jurusan</th>
                                </tr>
                            </thead>
                            <tbody id="siswaBody"></tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer bg-light py-2">
                    <button type="submit" class="btn btn-success btn-sm px-4 font-weight-bold shadow-sm">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
let maxSiswaTerpilih = 20; // Default fallback

document.querySelectorAll('.btnTambahSiswa').forEach(btn => {
    btn.addEventListener('click', function(){

        let kelasId = this.dataset.id;
        let namaKelas = this.dataset.kelas;
        maxSiswaTerpilih = parseInt(this.dataset.max) || 20; // Ambil batasan dari tombol

        document.getElementById('kelas_id').value = kelasId;
        document.getElementById('namaKelas').innerText = namaKelas;

        let modal = new bootstrap.Modal(document.getElementById('modalSiswa'));
        modal.show();

        document.getElementById('loading').style.display = 'block';
        document.getElementById('listSiswa').style.display = 'none';
        document.getElementById('siswaBody').innerHTML = '';
        document.getElementById('checkAll').checked = false; 

        fetch("{{ route('riwayatkelas.siswa') }}?kelas_id=" + kelasId)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Request gagal');
                }
                return res.json();
            })
            .then(data => {
                let html = '';

                if (data.length === 0) {
                    html = `
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Tidak ada siswa yang tersedia untuk kelas ini
                            </td>
                        </tr>
                    `;
                } else {
                    data.forEach((s) => {
                        let isChecked = s.terdaftar ? 'checked' : '';

                        html += `
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="siswa_id[]" value="${s.id}" ${isChecked} class="form-check-input siswa-checkbox">
                                </td>
                                <td class="text-dark font-weight-bold">${s.user?.name ?? '-'}</td>
                                <td class="text-center text-secondary">${s.user?.nisn ?? '-'}</td>
                                <td class="text-center text-dark font-weight-bold">${s.jurusan ?? '-'}</td>
                            </tr>
                        `;
                    });
                }

                document.getElementById('siswaBody').innerHTML = html;
                document.getElementById('loading').style.display = 'none';
                document.getElementById('listSiswa').style.display = 'block';

                // Pasang event listener setelah element checkbox di-render ke HTML
                registerCheckboxLimitEvents();
            })
            .catch(error => {
                document.getElementById('loading').innerHTML = '<span class="text-danger">Gagal memuat data siswa. Silakan coba lagi.</span>';
                console.error(error);
            });
    });
});

function registerCheckboxLimitEvents() {
    const checkboxes = document.querySelectorAll(".siswa-checkbox");

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            let checkedCount = document.querySelectorAll(".siswa-checkbox:checked").length;

            if (checkedCount > maxSiswaTerpilih) {
                this.checked = false; // Batalkan centang jika lebih dari kuota
                alert(`Maaf, batas maksimal kelas ini adalah ${maxSiswaTerpilih} siswa!`);
            }
        });
    });
}

document.getElementById('checkAll').addEventListener('change', function(){
    const checkboxes = document.querySelectorAll(".siswa-checkbox");
    
    if (this.checked) {
        let currentChecked = 0;
        checkboxes.forEach(el => {
            if (currentChecked < maxSiswaTerpilih) {
                el.checked = true;
                currentChecked++;
            } else {
                el.checked = false;
            }
        });

        if (checkboxes.length > maxSiswaTerpilih) {
            alert(`Hanya mencentang ${maxSiswaTerpilih} siswa teratas sesuai kuota maksimal kelas.`);
            this.checked = false;
        }
    } else {
        checkboxes.forEach(el => {
            el.checked = false;
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('modalSiswa');

    if (modalEl && modalEl.parentNode !== document.body) {
        document.body.appendChild(modalEl);
    }
});
</script>
@endsection