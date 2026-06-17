<table border="1">
    <thead>
        <tr>
            <th colspan="9" style="font-size: 18px;">
                Rekap Nilai Siswa
            </th>
        </tr>
        <tr>
            <th colspan="9">
                Tahun Ajaran:
                {{ $tahun->tahun ?? '-' }}
                {{ $tahun && $tahun->semester ? 'Semester ' . $tahun->semester : '' }}
            </th>
        </tr>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Jumlah Mapel</th>
            <th>Rata Pengetahuan</th>
            <th>Rata Keterampilan</th>
            <th>Rata Akhir</th>
            <th>Predikat</th>
        </tr>
    </thead>

    <tbody>
        @foreach($rekap as $key => $r)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $r['siswa']->nis ?? '-' }}</td>
                <td>{{ $r['siswa']->user->name ?? '-' }}</td>
                <td>
                    {{ $r['kelas']->tingkat ?? '' }}
                    {{ $r['kelas']->nama_kelas ?? '-' }}
                </td>
                <td>{{ $r['jumlah_mapel'] }}</td>
                <td>{{ $r['rata_pengetahuan'] ?? '-' }}</td>
                <td>{{ $r['rata_keterampilan'] ?? '-' }}</td>
                <td>{{ $r['rata_akhir'] ?? '-' }}</td>
                <td>{{ $r['predikat'] ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>