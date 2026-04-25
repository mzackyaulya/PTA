<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\BarcodeAbsensi;
use App\Models\PertemuanAbsensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $guru = auth()->user()->guru;

        $hariIni = now()->locale('id')->translatedFormat('l');
        $tanggalHariIni = now()->toDateString();

        $jadwal = \App\Models\Mengajar::with(['kelas', 'mapel'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        $selectedJadwal = null;
        $selectedPertemuan = null;
        $siswa = [];
        $barcode = null;

        if ($request->mengajar_id) {
            $selectedJadwal = \App\Models\Mengajar::with(['kelas', 'mapel'])
                ->where('guru_id', $guru->id)
                ->findOrFail($request->mengajar_id);

            $selectedPertemuan = PertemuanAbsensi::firstOrCreate(
                [
                    'mengajar_id' => $selectedJadwal->id,
                    'tanggal' => $tanggalHariIni,
                ],
                [
                    'pertemuan_ke' => PertemuanAbsensi::where('mengajar_id', $selectedJadwal->id)->count() + 1,
                    'is_approved' => false,
                    'is_started' => false,
                    'is_closed' => false,
                    'is_saved' => false,
                ]
            );

            if ($selectedPertemuan && now()->format('H:i:s') > $selectedJadwal->jam_selesai) {
                $selectedPertemuan->update([
                    'is_closed' => true,
                ]);
            }

            $kelasId = $selectedJadwal->kelas_id;

            $siswa = Siswa::with(['user', 'absensi' => function ($q) use ($selectedPertemuan) {
                    $q->where('pertemuan_id', $selectedPertemuan->id);
                }])
                ->whereHas('riwayatKelas', function ($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId);
                })
                ->get();

            if ($selectedPertemuan->is_started && !$selectedPertemuan->is_closed) {
                $barcode = BarcodeAbsensi::create([
                    'pertemuan_id' => $selectedPertemuan->id,
                    'token' => Str::random(40),
                    'expired_at' => now()->addMinutes(5),
                ]);
            }
        }

        return view('absensi.index', compact(
            'jadwal',
            'selectedJadwal',
            'selectedPertemuan',
            'siswa',
            'barcode'
        ));
    }

    public function validasi($id)
    {
        $pertemuan = PertemuanAbsensi::with('mengajar')->findOrFail($id);

        $jadwal = $pertemuan->mengajar;

        $tanggal = $pertemuan->tanggal;

        $jamMulai = Carbon::parse($tanggal . ' ' . $jadwal->jam_mulai);
        $jamSelesai = Carbon::parse($tanggal . ' ' . $jadwal->jam_selesai);
        $waktuBukaValidasi = $jamMulai->copy()->subMinutes(5);

        $sekarang = now();

        if ($sekarang->lt($waktuBukaValidasi)) {
            return back()->with('error', 'Validasi belum bisa dilakukan. Validasi dibuka 5 menit sebelum jam pelajaran.');
        }

        if ($sekarang->gt($jamSelesai)) {
            return back()->with('error', 'Validasi gagal. Jam pelajaran sudah selesai.');
        }

        $pertemuan->update([
            'is_approved' => true,
            'is_started' => true,
            'is_closed' => false,
        ]);

        return back()->with('success', 'Absensi berhasil divalidasi dan dibuka.');
    }

    public function validasiDariJadwal($mengajarId)
    {
        $guru = auth()->user()->guru;

        $jadwal = \App\Models\Mengajar::where('guru_id', $guru->id)
            ->findOrFail($mengajarId);

        $tanggalHariIni = now()->toDateString();

        $pertemuan = PertemuanAbsensi::firstOrCreate(
            [
                'mengajar_id' => $jadwal->id,
                'tanggal' => $tanggalHariIni,
            ],
            [
                'pertemuan_ke' => PertemuanAbsensi::where('mengajar_id', $jadwal->id)->count() + 1,
                'is_approved' => false,
                'is_started' => false,
                'is_closed' => false,
                'is_saved' => false,
            ]
        );

        return $this->validasi($pertemuan->id);
    }

    /*
    |--------------------------------------------------------------------------
    | Mulai pertemuan
    |--------------------------------------------------------------------------
    */

    public function start($id)
    {
        $pertemuan = PertemuanAbsensi::findOrFail($id);

        if(!$pertemuan->is_approved){
            return back()->with('error','Pertemuan belum disetujui admin');
        }

        if($pertemuan->is_started){
            return back()->with('error','Absensi sudah dimulai');
        }

        $pertemuan->update([
            'is_started' => true
        ]);

        return back()->with('success','Absensi berhasil dimulai');
    }

    /*
    |--------------------------------------------------------------------------
    | tutup pertemuan
    |--------------------------------------------------------------------------
    */

    public function close($id)
    {
        $pertemuan = PertemuanAbsensi::findOrFail($id);

        if(!$pertemuan->is_started){
            return back()->with('error','Absensi belum dimulai');
        }

        if($pertemuan->is_closed){
            return back()->with('error','Absensi sudah ditutup');
        }

        $pertemuan->update([
            'is_closed' => true
        ]);

        return back()->with('success','Absensi berhasil ditutup');
    }

    /*
    |--------------------------------------------------------------------------
    | Form absensi siswa
    |--------------------------------------------------------------------------
    */

    public function form($id)
    {
        $pertemuan = PertemuanAbsensi::with('mengajar')->findOrFail($id);

        if(!$pertemuan->is_started){
            return back()->with('error','Absensi belum dimulai');
        }

        if($pertemuan->is_closed){
            return back()->with('error','Absensi sudah ditutup');
        }

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
                    'pertemuan_id' => $request->pertemuan_id,
                    'siswa_id' => $siswa
                ],
                [
                    'status' => $request->status[$key] ?? null,
                    'keterangan' => $request->keterangan[$key] ?? null,
                    'scan_barcode' => false
                ]
            );
        }

        PertemuanAbsensi::where('id',$request->pertemuan_id)
        ->update([
            'is_saved'=>true
        ]);

        $pertemuan = PertemuanAbsensi::findOrFail($request->pertemuan_id);

        return redirect()->route('absensi.guru', [
            'mengajar_id' => $pertemuan->mengajar_id
        ])->with('success', 'Absensi berhasil disimpan');
    }

    /*
    |--------------------------------------------------------------------------
    | Guru generate QR code
    |--------------------------------------------------------------------------
    */

    public function barcode($id)
    {
        $pertemuan = PertemuanAbsensi::findOrFail($id);

        if(!$pertemuan->is_started){
            return back()->with('error','Absensi belum dimulai');
        }

        if($pertemuan->is_closed){
            return back()->with('error','Absensi sudah ditutup');
        }

        $token = Str::random(40);

        $barcode = BarcodeAbsensi::create([
            'pertemuan_id'=>$id,
            'token'=>$token,
            'expired_at'=>now()->addMinutes(5)
        ]);

        return view('absensi.barcode',compact('barcode'));
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
            return response()->json(['status'=>'invalid']);
        }

        if(now()->greaterThan($barcode->expired_at)){
            return response()->json(['status'=>'expired']);
        }

        if(!auth()->check()){
            return response()->json(['status'=>'login_required']);
        }

        $pertemuan = $barcode->pertemuan;

        if(!$pertemuan || !$pertemuan->is_started){
            return response()->json(['status'=>'belum_dimulai']);
        }

        if($pertemuan->is_closed){
            return response()->json(['status'=>'ditutup']);
        }

        $siswa = auth()->user()->siswa;

        if(!$siswa){
            return response()->json(['status'=>'bukan_siswa']);
        }

        // hanya kirim info ke halaman guru
        $barcode->update([
            'last_scan_siswa' => $siswa->id
        ]);

        return response()->json([
            'status'=>'success'
        ]);
    }

    public function scanCheck($id)
    {
        $barcode = BarcodeAbsensi::where('pertemuan_id',$id)
                    ->latest('created_at')
                    ->first();

        if(!$barcode || !$barcode->last_scan_siswa){
            return response()->json([]);
        }

        $siswa_id = $barcode->last_scan_siswa;

        $barcode->update([
            'last_scan_siswa' => null
        ]);

        return response()->json([
            'siswa_id'=>$siswa_id
        ]);
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
