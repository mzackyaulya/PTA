<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Nilai Siswa</title>
    <style>
        /* Style sederhana agar tampilan di Excel rapi */
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .text-danger { color: #dc3545; }
        th { background-color: #f2f2f2; font-weight: bold; }
    </style>
</head>
<body>

    <table border="0" cellpadding="5" cellspacing="0">
        <tr>
            <td colspan="10" class="font-bold" style="font-size: 16px; padding-bottom: 10px;">
                REKAP NILAI HASIL BELAJAR SISWA
            </td>
        </tr>
        <tr>
            <td colspan="2" class="font-bold">Nama Siswa</td>
            <td colspan="8">: {{ $siswa->nama ?? $siswa->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="2" class="font-bold">NIS / NISN</td>
            <td colspan="8">: {{ $siswa->nis ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="2" class="font-bold">Kelas</td>
            <td colspan="8">: {{ $nilai->first()->kelas->nama_kelas ?? $nilai->first()->kelas->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="2" class="font-bold">Tahun Ajaran / Semester</td>
            <td colspan="8">: {{ $tahun->tahun ?? '-' }} / {{ $tahun->semester ?? '-' }}</td>
        </tr>
        
        <tr>
            <td colspan="10" style="height: 15px;"></td>
        </tr>
    </table>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th rowspan="2" width="50">NO</th>
                <th rowspan="2" width="250">MATA PELAJARAN</th>
                <th rowspan="2" width="50">KKM</th>
                <th rowspan="2" width="60">JB (B)</th>
                <th colspan="2">PENGETAHUAN</th>
                <th colspan="2">KETERAMPILAN</th>
                <th rowspan="2" width="90">RATA - RATA (N)</th>
                <th rowspan="2" width="90" style="background-color: #fff3cd;">N X B</th>
            </tr>
            <tr>
                <th width="70">NILAI</th>
                <th width="80">PREDIKAT</th>
                <th width="70">NILAI</th>
                <th width="80">PREDIKAT</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalJB = 0;
                $totalPengetahuan = 0;
                $totalKeterampilan = 0;
                $totalRataRataN = 0;
                $totalNxB = 0;
                $jumlahData = 0;
            @endphp

            @forelse($nilai as $key => $n)
                @php
                    $jumlahData++;
                    $jb = $n->mapel->jb ?? $n->jb ?? 0;
                    $nilaiP = $n->nilai_pengetahuan ?? 0;
                    $nilaiK = $n->nilai_keterampilan ?? 0;
                    
                    $rataRataN = ($nilaiP + $nilaiK) / 2;
                    $nxB = $rataRataN * $jb;

                    $totalJB += $jb;
                    $totalPengetahuan += $nilaiP;
                    $totalKeterampilan += $nilaiK;
                    $totalRataRataN += $rataRataN;
                    $totalNxB += $nxB;
                @endphp
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $n->mapel->nama_mapel ?? $n->mapel->nama ?? '-' }}</td>
                    <td class="text-center">{{ $n->kkm ?? '75' }}</td>
                    <td class="text-center">{{ $jb }}</td>
                    <td class="text-center">{{ $nilaiP + 0 }}</td>
                    <td class="text-center">{{ $n->predikat_pengetahuan ?? '-' }}</td>
                    <td class="text-center">{{ $nilaiK + 0 }}</td>
                    <td class="text-center">{{ $n->predikat_keterampilan ?? '-' }}</td>
                    <td class="text-center font-bold">{{ $rataRataN + 0 }}</td>
                    <td class="text-center font-bold text-danger" style="background-color: #fff3cd;">{{ $nxB + 0 }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">Belum ada data nilai untuk semester ini.</td>
                </tr>
            @endforelse

            @if($jumlahData > 0)
                <tr class="font-bold" style="background-color: #f8f9fa;">
                    <td colspan="3" class="text-center">Jumlah</td>
                    <td class="text-center">{{ $totalJB }}</td>
                    <td class="text-center">{{ $totalPengetahuan + 0 }}</td>
                    <td></td>
                    <td class="text-center">{{ $totalKeterampilan + 0 }}</td>
                    <td></td>
                    <td class="text-center">{{ $totalRataRataN + 0 }}</td>
                    <td class="text-center text-danger" style="background-color: #fff3cd;">{{ $totalNxB + 0 }}</td>
                </tr>

                <tr class="font-bold" style="background-color: #cfe2ff;">
                    <td colspan="3" class="text-center">Jumlah Rata - Rata</td>
                    <td colspan="7" class="text-center text-danger" style="background-color: #fff3cd;">
                        {{ round($totalNxB / $totalJB, 2) + 0 }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

</body>
</html>