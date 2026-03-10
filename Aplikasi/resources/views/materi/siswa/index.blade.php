@extends('layout.main')

@section('title','Materi Pembelajaran')

@section('content')

<div class="card-header d-flex justify-content-between align-items-center">
    <h1 class="mb-2">Materi Pembelajaran</h1>
</div>

<div class="card">

    <div class="card-body">

        {{-- SEARCH BAR --}}
        <div class="row mb-3">
            <div class="col-md-6">

                <div class="input-group input-group-lg">

                    <span class="input-group-text">
                        <i class="fas fa-search text-muted"></i>
                    </span>

                    <input 
                        type="text"
                        id="searchMateri"
                        class="form-control"
                        placeholder="Cari Mata Pelajaran"
                    >

                </div>

            </div>
        </div>

        <div class="table-responsive">

            <table class="table table-bordered" id="tableMateri">

                <thead>
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th width="150" class="text-center">Materi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($mapel as $m)

                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>

                        <td>
                            {{ $m->mapel->nama }}
                        </td>

                        <td>
                            {{ $m->guru->user->name }}
                        </td>

                        <td>
                            {{ $m->kelas->nama_kelas }}
                        </td>

                        <td class="text-center">

                            <a 
                                href="{{ route('materi.mapel',$m->mapel->id) }}"
                                class="btn btn-primary"
                            >
                                Materi
                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="3" class="text-center">
                            Belum ada materi
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
<script>

const searchInput = document.getElementById("searchMateri");
const tableRows = document.querySelectorAll("#tableMateri tbody tr");

searchInput.addEventListener("keyup", function () {

    const keyword = this.value.toLowerCase();

    tableRows.forEach(function(row){

        const rowText = row.innerText.toLowerCase();

        if(rowText.includes(keyword)){
            row.style.display = "";
        }else{
            row.style.display = "none";
        }

    });

});

</script>
@endsection