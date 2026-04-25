<?php

use App\Http\Controllers\AbsensiController;

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalController;

use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MengajarController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PertemuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatKelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class,'index'])
->middleware(['auth','verified'])
->name('dashboard');


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function(){

    Route::get('/profile',[ProfileController::class,'show'])->name('profile.show');
    Route::get('/profile/edit',[ProfileController::class,'edit'])->name('profile.edit');
    Route::put('/profile/update',[ProfileController::class,'update'])->name('profile.update');

});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])->prefix('admin')->group(function(){

    Route::resource('siswa',SiswaController::class);
    Route::resource('guru',GuruController::class);
    Route::resource('kelas', KelasController::class)
        ->parameters(['kelas' => 'kelas']);
    Route::resource('mapel',MapelController::class);

    Route::resource('tahunajaran',TahunAjaranController::class)
        ->parameters(['tahunajaran'=>'tahunAjaran']);

    Route::resource('riwayatkelas',RiwayatKelasController::class)
        ->except(['show','edit','update']);

    Route::get('/riwayatkelas/siswa', [RiwayatKelasController::class, 'getSiswa'])
    ->name('riwayatkelas.siswa');

    Route::resource('mengajar', MengajarController::class)
    ->except(['edit','update']);

    Route::resource('announcements', AnnouncementsController::class)
        ->only(['index','create','store']);

    Route::resource('banners', BannerController::class)
        ->only(['create','store','edit','update']);

    Route::resource('nilai', NilaiController::class)
        ->only(['index','show']);


    /*
    | PERtemuan ABSENSI
    */

    Route::get('/pertemuan',[PertemuanController::class,'index'])->name('pertemuan.index');
    Route::get('/pertemuan/create',[PertemuanController::class,'create'])->name('pertemuan.create');
    Route::post('/pertemuan/store',[PertemuanController::class,'store'])->name('pertemuan.store');
    Route::get('/pertemuan/approve/{id}',[PertemuanController::class,'approve'])->name('pertemuan.approve');
    Route::get('/pertemuan/{id}',[PertemuanController::class,'show'])->name('pertemuan.show');
    
});


/*
|--------------------------------------------------------------------------
| GURU
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:guru'])->prefix('guru')->group(function(){

    // ABSENSI //

    Route::get('/absensi',[AbsensiController::class,'index'])->name('absensi.guru');

    Route::get('/absensi/form/{id}',[AbsensiController::class,'form'])->name('absensi.form');

    Route::post('/absensi/store',[AbsensiController::class,'store'])->name('absensi.store');

    Route::get('/absensi/barcode/{id}',[AbsensiController::class,'barcode'])->name('absensi.barcode');

    Route::get('/scan-check/{id}',[AbsensiController::class,'scanCheck']);
    
    Route::post('/pertemuan/{id}/start',[AbsensiController::class,'start'])->name('absensi.start');

    Route::post('/pertemuan/{id}/close',[AbsensiController::class,'close'])->name('absensi.close');

    Route::post('/guru/absensi/validasi/{id}', [AbsensiController::class, 'validasi'])
    ->name('absensi.validasi');
    Route::post('/guru/jadwal/{mengajar}/validasi-absensi', [AbsensiController::class, 'validasiDariJadwal'])
    ->name('jadwal.validasiAbsensi');

    // Materi //
    
    Route::get('/materi',[MateriController::class,'index'])
        ->name('materi.guru.index');

    Route::get('/materi/create',[MateriController::class,'create'])
        ->name('materi.create');

    Route::post('/materi/store',[MateriController::class,'store'])
        ->name('materi.store');

    Route::delete('/materi/{id}',[MateriController::class,'destroy'])
        ->name('materi.destroy');

    // Nilai //

    Route::get('/nilai',[NilaiController::class,'index'])->name('nilai.guru.index');

    Route::get('/nilai/create',[NilaiController::class,'create'])->name('nilai.create');

    Route::post('/nilai/store',[NilaiController::class,'store'])->name('nilai.store');

    Route::get('/nilai/edit/{id}',[NilaiController::class,'edit'])->name('nilai.edit');

    Route::put('/nilai/update/{id}',[NilaiController::class,'update'])->name('nilai.update');

    Route::delete('/nilai/{id}',[NilaiController::class,'destroy'])->name('nilai.destroy');

});


/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/



Route::prefix('siswa')->group(function(){

    Route::middleware(['auth','role:siswa'])->group(function(){

        Route::get('/absensi',[AbsensiController::class,'absensiSiswa'])->name('absensi.siswa');
        Route::get('/scan/{token}',[AbsensiController::class,'scan'])->name('absensi.scan');

         Route::get('/materi',[MateriController::class,'index'])
            ->name('materi.siswa.index');

        Route::get('/materi/mapel/{id}',[MateriController::class,'materiMapel'])
            ->name('materi.mapel');

        Route::get('/materi/download/{id}',[MateriController::class,'download'])
            ->name('materi.download');

        Route::get('/nilai',[NilaiController::class,'index'])->name('nilai.siswa.index');
        
        

    });

});


/*
|--------------------------------------------------------------------------
| JADWAL
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function(){

    Route::get('/jadwal',[JadwalController::class,'index'])->name('jadwal');

    Route::get('/jadwal/guru',[JadwalController::class,'guruList'])->name('jadwal.guru.list');

    Route::get('/jadwal/guru/{id}',[JadwalController::class,'jadwalGuru'])->name('jadwal.guru');

    Route::get('/jadwal/siswa',[JadwalController::class,'siswaList'])->name('jadwal.siswa.list');

    Route::get('/jadwal/siswa/{id}',[JadwalController::class,'jadwalSiswa'])->name('jadwal.siswa');

});
/*
|--------------------------------------------------------------------------
| QR SCAN PUBLIC
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';