@extends('layout.main')
@section('title','Tahun Ajaran')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Data Tahun Ajaran</h4>
        <a href="{{ route('tahunajaran.create') }}" class="btn btn-primary">Tambah Tahun Ajaran</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:30px" class="text-center">No</th>
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Semester</th>
                    <th class="text-center">Status</th>
                    <th style="width:200px" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $d)
                <tr>
                    <td class="text-center">{{ $i+1 }}</td>
                    <td class="text-center">{{ $d->tahun }}</td>
                    <td class="text-center">
                        @if($d->semester == 1)
                            I
                        @elseif($d->semester == 2)
                            II
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($d->aktif)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('tahunajaran.edit',$d->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
