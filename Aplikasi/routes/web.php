<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementsController;

use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;

use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\RiwayatKelasController;
use App\Http\Controllers\MengajarController;

/*
|--------------------------------------------------------------------------
| AUTH LANDING
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
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth','verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE (ALL LOGIN USER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])->group(function () {

    /*
    |----------------------------------
    | MASTER DATA
    |----------------------------------
    */
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class);

    /*
    |----------------------------------
    | AKADEMIK SETUP
    |----------------------------------
    */
    Route::resource('tahunajaran', TahunAjaranController::class);
    Route::resource('mapel', MapelController::class);
    Route::resource('riwayatkelas', RiwayatKelasController::class)->except(['show','edit','update']);
    Route::resource('mengajar', MengajarController::class)->except(['show','edit','update']);

    /*
    |----------------------------------
    | INFORMASI SEKOLAH
    |----------------------------------
    */
    Route::resource('banners', BannerController::class)->only(['create','store','edit','update']);
    Route::resource('announcements', AnnouncementsController::class)->only(['index','create','store']);
});

require __DIR__.'/auth.php';
