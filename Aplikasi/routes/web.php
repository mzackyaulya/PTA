<?php

use App\Http\Controllers\AbsensiController;

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalController;

use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\MengajarController;
use App\Http\Controllers\PertemuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatKelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
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
    Route::resource('kelas',KelasController::class);
    Route::resource('mapel',MapelController::class);

    Route::resource('tahunajaran',TahunAjaranController::class)
        ->parameters(['tahunajaran'=>'tahunAjaran']);

    Route::resource('riwayatkelas',RiwayatKelasController::class)
        ->except(['show','edit','update']);

    Route::resource('mengajar',MengajarController::class)
        ->except(['show','edit','update']);

    Route::resource('announcements', AnnouncementsController::class)
            ->only(['index','create','store']);
    Route::resource('banners', BannerController::class)
        ->only(['create','store','edit','update']);

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

    Route::get('/absensi',[AbsensiController::class,'index'])->name('absensi.guru');

    Route::get('/absensi/form/{id}',[AbsensiController::class,'form'])->name('absensi.form');

    Route::post('/absensi/store',[AbsensiController::class,'store'])->name('absensi.store');

    Route::get('/absensi/barcode/{id}',[AbsensiController::class,'barcode'])->name('absensi.barcode');

});


/*
|--------------------------------------------------------------------------
| SISWA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:siswa'])->prefix('siswa')->group(function(){

    Route::get('/absensi',[AbsensiController::class,'absensiSiswa'])->name('absensi.siswa');

    Route::get('/scan/{token}',[AbsensiController::class,'scan'])->name('absensi.scan');

    Route::get('/scan-camera',[AbsensiController::class,'scanCamera'])
        ->name('absensi.scan.camera');

    Route::resource('announcements', AnnouncementsController::class)
        ->only(['index']);

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


require __DIR__.'/auth.php';