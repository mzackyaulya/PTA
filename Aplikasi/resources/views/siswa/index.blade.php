@extends('layout.main')

@section('title', 'Data Siswa')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title fw-bold mb-2">Data Siswa</h2>
                <a href="{{ route('siswa.create') }}" class="btn btn-primary">
                    Tambah Siswa
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="basic-datatables_length"><label>Show <select name="basic-datatables_length" aria-controls="basic-datatables" class="form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="basic-datatables_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="basic-datatables"></label></div></div></div><div class="row"><div class="col-sm-12"><table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="basic-datatables_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 169.275px;">No</th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 169.275px;">Nama</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 261.888px;">NISN</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 128.163px;">Email</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 51.0125px;">Jenis Kelamin</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 125.55px;">Agama</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 104.713px;">Tahun Masuk</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 104.713px;">Status</th>
                                <th class="sorting text-center" tabindex="0" aria-controls="basic-datatables" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 104.713px;">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1" class="text-center">No</th>
                                <th rowspan="1" colspan="1" class="text-center">Nama</th>
                                <th rowspan="1" colspan="1" class="text-center">NISN</th>
                                <th rowspan="1" colspan="1" class="text-center">Email</th>
                                <th rowspan="1" colspan="1" class="text-center">Jenis Kelamin</th>
                                <th rowspan="1" colspan="1" class="text-center">Agama</th>
                                <th rowspan="1" colspan="1" class="text-center">Tahun Masuk</th>
                                <th rowspan="1" colspan="1" class="text-center">Status</th>
                                <th rowspan="1" colspan="1" class="text-center">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($siswa as $index => $siswa)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $siswa->user->name }}</td>
                                <td class="text-center">{{ $siswa->user->nisn }}</td>
                                <td class="text-center">{{ $siswa->user->email ?? '-' }}</td>
                                <td class="text-center">{{ $siswa->jenis_kelamin ?? '-' }}</td>
                                <td class="text-center">{{ $siswa->agama ?? '-' }}</td>
                                <td class="text-center">{{ $siswa->tahun_masuk ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge
                                        @if($siswa->status_siswa == 'aktif') bg-success
                                        @elseif($siswa->status_siswa == 'lulus') bg-primary
                                        @else bg-warning @endif">
                                        {{ ucfirst($siswa->status_siswa) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada data siswa</td>
                            </tr>
                            @endforelse
                        </tbody>
                        </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="basic-datatables_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="basic-datatables_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="basic-datatables_previous"><a href="#" aria-controls="basic-datatables" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="basic-datatables" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="basic-datatables" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="basic-datatables" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="basic-datatables" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="basic-datatables" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="basic-datatables" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="basic-datatables_next"><a href="#" aria-controls="basic-datatables" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
