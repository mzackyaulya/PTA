@extends('layout.main')

@section('title','Jadwal Pelajaran')

@section('content')

<style>
    .jadwal-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .jadwal-header {
        padding: 22px 24px;
        background: #fff;
        border-bottom: 1px solid #eef0f3;
    }

    .jadwal-header h4 {
        font-weight: 700;
        margin-bottom: 10px;
        color: #111827;
    }

    .jadwal-info {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.6;
    }

    .jadwal-body {
        padding: 22px 24px;
    }

    .jadwal-table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 10px;
    }

    .jadwal-table {
        min-width: 900px;
        margin-bottom: 0;
    }

    .jadwal-table th {
        background: #212529 !important;
        color: white;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 13px;
        padding: 16px 12px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .jadwal-table td {
        padding: 18px 12px;
        vertical-align: middle;
        min-width: 130px;
    }

    .jam-cell {
        width: 130px;
        min-width: 130px;
        font-weight: 700;
        white-space: nowrap;
    }

    .mapel-title {
        font-weight: 700;
        color: #111827;
        line-height: 1.4;
    }

    .guru-name {
        color: #374151;
        font-size: 13px;
        line-height: 1.4;
    }

    .empty-cell {
        color: #9ca3af;
    }

    .scroll-hint {
        display: none;
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .jadwal-header {
            padding: 20px 18px;
        }

        .jadwal-header h4 {
            font-size: 26px;
            line-height: 1.3;
        }

        .jadwal-info {
            font-size: 15px;
        }

        .jadwal-body {
            padding: 18px 16px;
        }

        .scroll-hint {
            display: block;
        }

        .jadwal-table {
            min-width: 760px;
        }

        .jadwal-table th {
            font-size: 12px;
            padding: 14px 10px;
        }

        .jadwal-table td {
            padding: 16px 10px;
            min-width: 120px;
            font-size: 14px;
        }

        .jam-cell {
            width: 110px;
            min-width: 110px;
            font-size: 14px;
            white-space: normal;
            line-height: 1.5;
        }

        .mapel-title {
            font-size: 15px;
        }

        .guru-name {
            font-size: 13px;
        }
    }
</style>

<div class="card jadwal-card">
    <div class="jadwal-header">
        <h4>Jadwal Pelajaran</h4>

        <div class="jadwal-info">
            Siswa: {{ $siswa->user->name ?? '-' }}
            |
            Kelas:
            {{ $kelasAktif && $kelasAktif->kelas ? $kelasAktif->kelas->tingkat . ' ' . $kelasAktif->kelas->nama_kelas : '-' }}
            |
            Tahun Ajaran:
            {{ $tahun->tahun ?? '-' }}
            {{ $tahun && $tahun->semester ? '(' . $tahun->semester . ')' : '' }}
        </div>
    </div>

    <div class="jadwal-body">

        @if (!$kelasAktif)
            <div class="alert alert-warning">
                Siswa ini belum ditempatkan ke kelas pada tahun ajaran sekarang.
            </div>
        @endif

        <div class="scroll-hint">
            Geser tabel ke samping untuk melihat hari lainnya →
        </div>

        @php
            $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

            $jam = [
                '07:00 - 08:30',
                '08:30 - 10:00',
                '10:10 - 12:00',
                '13:00 - 15:00',
            ];
        @endphp

        <div class="jadwal-table-wrapper">
            <table class="table table-bordered text-center jadwal-table">

                <thead>
                    <tr>
                        <th>Jam</th>

                        @foreach($hari as $h)
                            <th>{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach($jam as $j)
                        <tr>
                            <td class="jam-cell">
                                {{ str_replace(' - ', ' - ', $j) }}
                            </td>

                            @foreach($hari as $h)
                                <td>
                                    @php
                                        $jadwalItem = $jadwal->first(function($item) use ($h, $j) {
                                            $jam_item = substr($item->jam_mulai, 0, 5) . ' - ' . substr($item->jam_selesai, 0, 5);

                                            return $item->hari == $h && $jam_item == $j;
                                        });
                                    @endphp

                                    @if($jadwalItem)
                                        <div class="mapel-title">
                                            {{ $jadwalItem->mapel->nama ?? '-' }}
                                        </div>

                                        <div class="guru-name mt-1">
                                            {{ $jadwalItem->guru->nama ?? $jadwalItem->guru->user->name ?? '-' }}
                                        </div>
                                    @else
                                        <span class="empty-cell">-</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection