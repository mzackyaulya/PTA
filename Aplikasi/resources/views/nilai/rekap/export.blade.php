<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Nilai Seluruh Siswa</title>
    <style>
        /* Style sederhana agar tampilan di Excel rapi */
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
    </style>
</head>
<body>

    <table border="0" cellpadding="5" cellspacing="0">
        <tr>
            <td colspan="8" class="font-bold" style="font-size: 16px; padding-bottom: 5px; text-align: left;">
                REKAP NILAI HASIL BELAJAR SISWA
            </td>
        </tr>
        <tr>
            <td colspan="8" class="font-bold" style="text-align: left; padding-bottom: 15px;">
                Tahun Ajaran: {{ $tahun->tahun ?? '-' }} {{ $tahun && $tahun->semester ? 'Semester ' . $tahun->semester : '' }}
            </td>
        </tr>
    </table>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th width="50">No</th>
                <th width="100">NIS</th>
                <th width="250">Nama Siswa</th>
                <th width="80">Kelas</th>
                <th width="100">Jumlah Mapel</th>
                <th width="130">Rata Pengetahuan</th>
                <th width="130">Rata Keterampilan</th>
                <th width="110" style="background-color: #fff3cd;">Rata Akhir</th>
            </tr>
        </thead>

        <tbody>
            @foreach($rekap as $key => $r)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $r['siswa']->nis ?? '-' }}</td>
                    <td>{{ $r['siswa']->user->name ?? '-' }}</td>
                    <td class="text-center">
                        {{ $r['kelas']->tingkat ?? '' }}
                        {{ $r['kelas']->nama_kelas ?? '-' }}
                    </td>
                    <td class="text-center">{{ $r['jumlah_mapel'] }}</td>
                    
                    <td class="text-center">
                        {{ isset($r['rata_pengetahuan']) ? $r['rata_pengetahuan'] + 0 : '-' }}
                    </td>
                    <td class="text-center">
                        {{ isset($r['rata_keterampilan']) ? $r['rata_keterampilan'] + 0 : '-' }}
                    </td>
                    <td class="text-center font-bold" style="background-color: #fff3cd; color: #dc3545;">
                        {{ isset($r['rata_akhir']) ? $r['rata_akhir'] + 0 : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>