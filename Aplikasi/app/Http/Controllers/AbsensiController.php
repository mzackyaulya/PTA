<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\BarcodeAbsensi;
use App\Models\PertemuanAbsensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AbsensiController extends Controller
{
    public function index()
    {
        $pertemuan = PertemuanAbsensi::with('mengajar')
                    ->where('is_approved',true)
                    ->get();

        return view('absensi.index',compact('pertemuan'));
    }

    /*
    |--------------------------------------------------------------------------
    | Form absensi siswa
    |--------------------------------------------------------------------------
    */

    public function form($id)
    {
        $pertemuan = PertemuanAbsensi::with('mengajar')->findOrFail($id);

        $kelasId = $pertemuan->mengajar->kelas_id;

        $siswa = Siswa::whereHas('riwayatKelas', function ($query) use ($kelasId) {
            $query->where('kelas_id', $kelasId);
        })->get();

        $barcode = BarcodeAbsensi::create([
            'pertemuan_id'=>$pertemuan->id,
            'token'=>Str::random(40),
            'expired_at'=>now()->addMinutes(5)
        ]);

        return view('absensi.form',compact(
            'pertemuan',
            'siswa',
            'barcode'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan absensi manual oleh guru
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        foreach($request->siswa_id as $key => $siswa){

            Absensi::updateOrCreate(
                [
                    'pertemuan_id'=>$request->pertemuan_id,
                    'siswa_id'=>$siswa
                ],
                [
                    'status'=>$request->status[$key] ?? null,
                    'keterangan'=>$request->keterangan[$key] ?? null,
                    'scan_barcode'=>false
                ]
            );
        }

        return back()->with('success','Absensi berhasil disimpan');
    }

    /*
    |--------------------------------------------------------------------------
    | Guru generate QR code
    |--------------------------------------------------------------------------
    */

    public function barcode($id)
    {
        $token = Str::random(40);

        $barcode = BarcodeAbsensi::create([
            'pertemuan_id'=>$id,
            'token'=>$token,
            'expired_at'=>now()->addMinutes(5)
        ]);

        return view('absensi.barcode',compact('barcode'));
    }

    public function scanCamera()
    {
        return view('absensi.scan');
    }

    /*
    |--------------------------------------------------------------------------
    | Scan barcode oleh siswa
    |--------------------------------------------------------------------------
    */

    public function scan($token)
    {
        $barcode = BarcodeAbsensi::where('token',$token)->first();

        if(!$barcode){
            return "QR tidak valid";
        }

        if(now() > $barcode->expired_at){
            return "QR sudah expired";
        }

        $siswa = auth()->user()->siswa;

        Absensi::updateOrCreate(
            [
                'pertemuan_id'=>$barcode->pertemuan_id,
                'siswa_id'=>$siswa->id
            ],
            [
                'status'=>'hadir',
                'scan_barcode'=>true
            ]
        );

        return redirect()->route('absensi.siswa')
            ->with('success','Absensi berhasil');
    }

    /*
    |--------------------------------------------------------------------------
    | Riwayat absensi siswa
    |--------------------------------------------------------------------------
    */

    public function absensiSiswa()
    {
        $siswa = auth()->user()->siswa;

        $absensi = Absensi::with('pertemuan.mengajar.mapel')
                ->where('siswa_id',$siswa->id)
                ->get();

        return view('absensi.siswa',compact('absensi'));
    }
}
