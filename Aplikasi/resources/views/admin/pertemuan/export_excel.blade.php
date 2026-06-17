<table border="1">
    <thead>
        <tr>
            <th colspan="12" style="font-size:18px;">
                Rekap Absensi Siswa
            </th>
        </tr>
        <tr>
            <th colspan="12">
                Tahun Ajaran:
                {{ $tahunDipilih->tahun ?? '-' }}
                {{ $tahunDipilih && $tahunDipilih->semester ? 'Semester ' . $tahunDipilih->semester : '' }}
            </th>
        </tr>

        @if($tanggalMulai && $tanggalSelesai)
            <tr>
                <th colspan="12">
                    Periode:
                    {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }}
                    sampai
                    {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}
                </th>
            </tr>
        @endif

        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Mata Pelajaran</th>
            <th>Guru</th>
            <th>Hadir</th>
            <th>Izin</th>
            <th>Sakit</th>
            <th>Alpa</th>
            <th>Total</th>
            <th>Persentase Hadir</th>
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
                <td>{{ $r['mapel']->nama ?? '-' }}</td>
                <td>{{ $r['guru']->nama ?? $r['guru']->user->name ?? '-' }}</td>
                <td>{{ $r['hadir'] }}</td>
                <td>{{ $r['izin'] }}</td>
                <td>{{ $r['sakit'] }}</td>
                <td>{{ $r['alpa'] }}</td>
                <td>{{ $r['total'] }}</td>
                <td>{{ $r['persentase'] }}%</td>
            </tr>
        @endforeach
    </tbody>
</table>