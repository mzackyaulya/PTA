<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Mengajar;
use App\Models\RiwayatKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\BarcodeAbsensi;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $guru = auth()->user()->guru->id;

        $hariInggris = now()->format('l');

        $hari = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ][$hariInggris];

        $jadwal = Mengajar::with('kelas','mapel')
                    ->where('guru_id',$guru)
                    ->where('hari',$hari)
                    ->get();

        return view('absensi.index',compact('jadwal'));

    }


    public function form($mengajar_id)
    {

        $mengajar = Mengajar::with('kelas')->find($mengajar_id);

        $siswa = RiwayatKelas::with('siswa.user')
                ->where('kelas_id',$mengajar->kelas_id)
                ->get();

        return view('absensi.form',compact('siswa','mengajar'));
    }


    public function store(Request $request)
    {

        if(!$request->status){
            return back()->with('error','Silakan isi absensi siswa');
        }

        foreach($request->status as $siswa_id => $status){

            Absensi::updateOrCreate(

                [
                    'siswa_id'=>$siswa_id,
                    'mengajar_id'=>$request->mengajar_id,
                    'tanggal'=>now()->toDateString()
                ],

                [
                    'status'=>$status,
                    'keterangan'=>$request->keterangan[$siswa_id] ?? null
                ]

            );

        }

        return back()->with('success','Absensi berhasil disimpan');

    }

    public function barcode($mengajar_id)
    {

        $mengajar = Mengajar::findOrFail($mengajar_id);

        $token = Str::random(40);

        BarcodeAbsensi::create([
            'mengajar_id'=>$mengajar->id,
            'token'=>$token,
            'tanggal'=>now()
        ]);

        return view('absensi.barcode',compact('token'));

    }

    public function scan($token)
    {

        $barcode = BarcodeAbsensi::where('token',$token)->firstOrFail();

        if(!auth()->user()->siswa){
            return "Hanya siswa yang dapat melakukan absensi";
        }

        $siswa_id = auth()->user()->siswa->id;

        $cek = Absensi::where('siswa_id',$siswa_id)
                ->where('mengajar_id',$barcode->mengajar_id)
                ->whereDate('tanggal',now())
                ->first();

        if($cek){
            return "Anda sudah melakukan absensi";
        }

        Absensi::create([
            'siswa_id'=>$siswa_id,
            'mengajar_id'=>$barcode->mengajar_id,
            'tanggal'=>now()->toDateString(),
            'status'=>'hadir',
            'scan_barcode'=>true
        ]);

        return "Absensi berhasil";

    }

    public function absensiSiswa()
    {

        $siswa = auth()->user()->siswa;

        $jadwal = Mengajar::with('mapel','kelas')
                    ->where('kelas_id',$siswa->kelas_id)
                    ->get();

        $absensi = Absensi::where('siswa_id',$siswa->id)
                    ->get()
                    ->groupBy('mengajar_id');

        return view('absensi.siswa',compact('jadwal','absensi'));

    }
}
