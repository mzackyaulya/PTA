@extends('layout.main')

@section('title', 'Daftar Materi')

@section('content')

<style>

    /* ================= CARD ================= */
    .materi-card{
        border-radius:14px;
        background:#fff;
        padding:14px;
    }

    /* ================= ICON FILE ================= */
    .file-icon{
        width:70px;
        height:70px;
        background:#f3f5f7;
        border-radius:14px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:34px;
    }

    /* ================= BADGE ================= */
    .materi-badge{
        width:70px;
        height:70px;
        background:#eef1f5;
        border-radius:14px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:18px;
        font-weight:700;
    }

    /* ================= TITLE ================= */
    .materi-title{
        font-weight:600;
        font-size:15px;
        margin-bottom:6px;
    }

    /* ================= DATE ================= */
    .materi-date{
        font-size:12px;
        color:#6c757d;
        margin-bottom:14px;
    }

    /* ================= BUTTON ================= */
    .btn-download{
        background:#173e8c;
        color:white;
        border-radius:8px;
        font-size:14px;
        padding:8px;
    }

    .btn-download:hover{
        background:#0f2e6b;
        color:white;
    }

    /* ================= SEARCH ================= */
    .search-box{
        background:#f8f9fa;
        border-radius:12px;
        overflow:hidden;
    }

    .search-box input{
        background:#f8f9fa;
        box-shadow:none;
    }

    .search-box input:focus{
        box-shadow:none;
        background:#f8f9fa;
    }

</style>


<h1 class="mb-4 fw-bold">
    Daftar Materi
</h1>


{{-- ================= SEARCH MATERI ================= --}}
<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <h6 class="fw-bold mb-3 text-muted">
            CARI MATERI
        </h6>

        <div class="input-group input-group-lg search-box">

            <span class="input-group-text bg-light border-0">
                <i class="fas fa-search text-secondary"></i>
            </span>

            <input
                type="text"
                id="searchMateri"
                class="form-control border-0"
                placeholder="Cari materi pelajaran"
            >

        </div>

    </div>

</div>


{{-- ================= LIST MATERI ================= --}}
<div class="row g-3">

    @foreach($materi as $m)

        @php
            $ext = pathinfo($m->file, PATHINFO_EXTENSION);
        @endphp

        <div class="col-lg-4 col-md-6 materi-item">

            <div class="card shadow-sm border-0 materi-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">

                        {{-- ICON FILE --}}
                        <div class="file-icon">

                            @if($ext == 'pdf')
                                <i class="fas fa-file-pdf text-danger"></i>

                            @elseif($ext == 'ppt' || $ext == 'pptx')
                                <i class="fas fa-file-powerpoint text-warning"></i>

                            @elseif($ext == 'doc' || $ext == 'docx')
                                <i class="fas fa-file-word text-primary"></i>

                            @elseif($ext == 'xls' || $ext == 'xlsx')
                                <i class="fas fa-file-excel text-success"></i>

                            @else
                                <i class="fas fa-file text-secondary"></i>
                            @endif

                        </div>


                        {{-- BADGE --}}
                        <div class="materi-badge">
                            M{{ $m->materi }}
                        </div>

                    </div>


                    {{-- TITLE --}}
                    <div class="materi-title">
                        {{ $m->judul }}
                    </div>


                    {{-- DATE --}}
                    <div class="materi-date">
                        {{ $m->created_at->format('Y-m-d H:i:s') }}
                    </div>


                    {{-- BUTTON DOWNLOAD --}}
                    <a
                        href="{{ route('materi.download', $m->id) }}"
                        class="btn btn-download w-100"
                    >
                        Unduh Materi
                    </a>

                </div>

            </div>

        </div>

    @endforeach

</div>


{{-- ================= NOT FOUND ================= --}}
<div id="noResult" class="text-center text-muted mt-4" style="display:none;">
    <p>Materi tidak ditemukan</p>
</div>


<script>

const searchInput = document.getElementById("searchMateri");
const items = document.querySelectorAll(".materi-item");
const noResult = document.getElementById("noResult");

searchInput.addEventListener("keyup", function(){

    let keyword = this.value.toLowerCase();
    let visible = 0;

    items.forEach(function(item){

        let text = item.innerText.toLowerCase();

        if(text.includes(keyword)){
            item.style.display = "";
            visible++;
        }else{
            item.style.display = "none";
        }

    });

    if(visible === 0){
        noResult.style.display = "block";
    }else{
        noResult.style.display = "none";
    }

});

</script>

@endsection