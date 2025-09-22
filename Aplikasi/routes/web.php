<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth','verified'])
    ->name('dashboard');

Route::middleware(['auth','role:admin'])->group(function () {
    Route::resource('banners', BannerController::class)->only(['create','store','edit','update']);
    Route::resource('announcements', AnnouncementsController::class)->only(['index','create','store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::resource('siswa',SiswaController::class);
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/guru', [GuruController::class, 'index'])->name('guru');
    Route::resource('guru',GuruController::class);
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas');
    Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
});

require __DIR__.'/auth.php';
