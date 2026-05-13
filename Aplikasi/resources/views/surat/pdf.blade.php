<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            line-height: 1.5;
        }

        .kop {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop h3,
        .kop h4,
        .kop p {
            margin: 0;
            padding: 0;
        }

        .kop h3 {
            font-size: 16px;
            font-weight: bold;
        }

        .kop h4 {
            font-size: 14px;
            font-weight: bold;
        }

        .kop p {
            font-size: 11px;
        }

        .judul-surat {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .judul-surat h4 {
            margin: 0;
            text-decoration: underline;
            font-size: 14px;
            font-weight: bold;
        }

        .judul-surat p {
            margin: 3px 0 0 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-info td {
            vertical-align: top;
            padding: 3px 0;
        }

        .label {
            width: 30%;
        }

        .colon {
            width: 3%;
        }

        .content {
            width: 67%;
        }

        .paragraph {
            text-align: justify;
            margin-top: 15px;
        }

        .table-siswa {
            margin-top: 10px;
            border: 1px solid #000;
        }

        .table-siswa th,
        .table-siswa td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
        }

        .table-siswa th {
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .ttd {
            margin-top: 40px;
            width: 100%;
        }

        .ttd td {
            vertical-align: top;
            text-align: center;
        }

        .space-ttd {
            height: 70px;
        }

        .catatan {
            margin-top: 15px;
            font-size: 11px;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        <h4>MAJELIS PENDIDIKAN DASAR DAN MENENGAH</h4>
        <h4>PIMPINAN CABANG MUHAMMADIYAH BUKIT KECIL PALEMBANG</h4>
        <h3>SMA MUHAMMADIYAH 2 PALEMBANG</h3>
        <p>Jl. K.H. Ahmad Dahlan No. 23 B Palembang</p>
    </div>

    {{-- JUDUL --}}
    <div class="judul-surat">
        <h4>SURAT PERMOHONAN</h4>
        <p>Nomor: {{ $surat->kode_surat ?? '-' }}</p>
    </div>

    <p class="paragraph">
        Yang bertanda tangan di bawah ini menerangkan bahwa terdapat permohonan surat dengan rincian sebagai berikut:
    </p>

    {{-- INFORMASI SURAT --}}
    <table class="table-info">
        <tr>
            <td class="label">Jenis Surat</td>
            <td class="colon">:</td>
            <td class="content">{{ ucwords(str_replace('_', ' ', $surat->jenis_surat)) }}</td>
        </tr>

        <tr>
            <td class="label">Judul Surat</td>
            <td class="colon">:</td>
            <td class="content">{{ $surat->judul }}</td>
        </tr>

        <tr>
            <td class="label">Nama Kegiatan</td>
            <td class="colon">:</td>
            <td class="content">{{ $surat->nama_kegiatan ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Tempat Kegiatan</td>
            <td class="colon">:</td>
            <td class="content">{{ $surat->tempat_kegiatan ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Tanggal Kegiatan</td>
            <td class="colon">:</td>
            <td class="content">
                @if ($surat->tanggal_mulai && $surat->tanggal_selesai)
                    {{ $surat->tanggal_mulai->format('d-m-Y') }}
                    s/d
                    {{ $surat->tanggal_selesai->format('d-m-Y') }}
                @elseif ($surat->tanggal_mulai)
                    {{ $surat->tanggal_mulai->format('d-m-Y') }}
                @else
                    -
                @endif
            </td>
        </tr>

        <tr>
            <td class="label">Pelatih / Pembina</td>
            <td class="colon">:</td>
            <td class="content">{{ $surat->nama_pelatih ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Organisasi</td>
            <td class="colon">:</td>
            <td class="content">{{ $surat->nama_organisasi ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Pemohon</td>
            <td class="colon">:</td>
            <td class="content">{{ $surat->pembuat->name ?? '-' }}</td>
        </tr>
    </table>

    {{-- KEPERLUAN --}}
    <p class="paragraph">
        Adapun keperluan permohonan surat ini adalah sebagai berikut:
    </p>

    <p class="paragraph">
        {{ $surat->keperluan }}
    </p>

    {{-- SISWA TERKAIT --}}
    <p class="paragraph">
        Siswa yang terkait dalam permohonan surat ini adalah:
    </p>

    <table class="table-siswa">
        <thead>
            <tr>
                <th width="8%">No</th>
                <th width="25%">NIS</th>
                <th>Nama Siswa</th>
                <th width="20%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($surat->siswaTerlibat as $siswa)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->user->name ?? '-' }}</td>
                    <td class="text-center">{{ ucfirst($siswa->status_siswa) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        Tidak ada siswa terkait.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="paragraph">
        Demikian surat ini dibuat untuk dapat digunakan sebagaimana mestinya.
    </p>

    {{-- CATATAN WAKA --}}
    @if ($surat->catatan_waka)
        <div class="catatan">
            <strong>Catatan Waka:</strong>
            <br>
            {{ $surat->catatan_waka }}
        </div>
    @endif

    {{-- TANDA TANGAN --}}
    <table class="ttd">
        <tr>
            <td width="55%"></td>
            <td width="45%">
                Palembang, {{ now()->format('d-m-Y') }}
                <br>
                Wakil Kepala Sekolah
                <br>
                Bidang Kesiswaan
                <div class="space-ttd"></div>
                <strong>{{ $surat->waka->name ?? '____________________' }}</strong>
            </td>
        </tr>
    </table>

</body>
</html>