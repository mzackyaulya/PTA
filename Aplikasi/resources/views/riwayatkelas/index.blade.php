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
<div class="card">
    <div class="card-header">
        <h4>Penempatan Siswa</h4>
        <small class="text-muted">
            Tahun Ajaran Aktif:
            {{ $tahunAktif->tahun ?? '-' }}
            {{ $tahunAktif ? '(' . $tahunAktif->semester . ')' : '' }}
        </small>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tingkat</th>
                    <th class="text-center">Kelas</th>
                    <th class="text-center">Jumlah Siswa</th>
                    <th class="text-center" width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $i => $k)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td class="text-center">{{ $k->tingkat ?? '-' }}</td>
                        <td class="text-center">{{ $k->nama_kelas }}</td>
                        <td class="text-center">{{ $k->jumlah_siswa }}</td>
                        <td class="text-center">
                            <button 
                                type="button"
                                class="btn btn-primary btn-sm btnTambahSiswa"
                                data-id="{{ $k->id }}"
                                data-kelas="{{ $k->nama_kelas }}"
                            >
                                Tambah Siswa
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data kelas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modalSiswa" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Tambah Siswa ke Kelas <span id="namaKelas"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formSiswa" method="POST" action="{{ route('riwayatkelas.store') }}">
                @csrf

                <div class="modal-body">

                    <input type="hidden" name="kelas_id" id="kelas_id">

                    <div id="loading" class="text-center">
                        Loading...
                    </div>

                    <div id="listSiswa" style="display:none">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                </tr>
                            </thead>
                            <tbody id="siswaBody"></tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>
<script>
document.querySelectorAll('.btnTambahSiswa').forEach(btn => {
    btn.addEventListener('click', function(){

        let kelasId = this.dataset.id;
        let namaKelas = this.dataset.kelas;

        document.getElementById('kelas_id').value = kelasId;
        document.getElementById('namaKelas').innerText = namaKelas;

        let modal = new bootstrap.Modal(document.getElementById('modalSiswa'));
        modal.show();

        document.getElementById('loading').style.display = 'block';
        document.getElementById('loading').innerText = 'Loading...';
        document.getElementById('listSiswa').style.display = 'none';
        document.getElementById('siswaBody').innerHTML = '';

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
                            <td colspan="3" class="text-center">
                                Tidak ada siswa yang bisa ditambahkan
                            </td>
                        </tr>
                    `;
                } else {
                    data.forEach((s) => {
                        html += `
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="siswa_id[]" value="${s.id}">
                                </td>
                                <td>${s.user?.name ?? '-'}</td>
                                <td>${s.user?.nisn ?? '-'}</td>
                            </tr>
                        `;
                    });
                }

                document.getElementById('siswaBody').innerHTML = html;
                document.getElementById('loading').style.display = 'none';
                document.getElementById('listSiswa').style.display = 'block';
            })
            .catch(error => {
                document.getElementById('loading').innerText = 'Gagal memuat data siswa.';
                console.error(error);
            });
    });
});

document.getElementById('checkAll').addEventListener('change', function(){
    document.querySelectorAll("input[name='siswa_id[]']").forEach(el => {
        el.checked = this.checked;
    });
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