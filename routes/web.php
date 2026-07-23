<?php

use App\Http\Controllers\Admin\BeritaAcaraController as AdminBeritaAcaraController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataPendudukController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\PendudukImportController;
use App\Http\Controllers\Admin\PerangkatDesaController;
use App\Http\Controllers\Admin\PotensiDesaController;
use App\Http\Controllers\Admin\ProfilDesaController;
use App\Http\Controllers\Admin\ProgramKerjaController as AdminProgramKerjaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PotensiDesaController as PublicPotensiDesaController;
use App\Http\Controllers\ProgramKerjaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Publik (Guest)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/potensi-desa', [PublicPotensiDesaController::class, 'index'])->name('potensi.index');
Route::get('/program-kerja', [ProgramKerjaController::class, 'index'])->name('program-kerja.index');
Route::get('/program-kerja/{program_kerja}', [ProgramKerjaController::class, 'show'])->name('program-kerja.show');
Route::get('/berita-acara', [BeritaAcaraController::class, 'index'])->name('berita-acara.index');
Route::get('/berita-acara/{slug}', [BeritaAcaraController::class, 'show'])->name('berita-acara.show');

/*
|--------------------------------------------------------------------------
| Autentikasi (login only, tanpa register)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Panel Superadmin
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profil', [ProfilDesaController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilDesaController::class, 'update'])->name('profil.update');

    Route::resource('potensi', PotensiDesaController::class)->except(['show']);
    Route::resource('perangkat', PerangkatDesaController::class)->except(['show']);
    Route::resource('program-kerja', AdminProgramKerjaController::class)->except(['show']);

    Route::resource('berita-acara', AdminBeritaAcaraController::class)->except(['show']);
    Route::patch('/berita-acara/{berita_acara}/toggle-status', [AdminBeritaAcaraController::class, 'toggleStatus'])
        ->name('berita-acara.toggle-status');

    Route::get('/data-penduduk', [DataPendudukController::class, 'index'])->name('data-penduduk.index');
    Route::get('/data-penduduk/stats', [DataPendudukController::class, 'stats'])->name('data-penduduk.stats');

    Route::get('/penduduk/import', [PendudukImportController::class, 'create'])->name('penduduk.import');
    Route::post('/penduduk/import', [PendudukImportController::class, 'store'])->name('penduduk.import.store');
    Route::get('/penduduk/import/template', [PendudukImportController::class, 'template'])->name('penduduk.import.template');

    Route::resource('penduduk', PendudukController::class)->except(['show']);

    Route::prefix('pembersihan')->name('maintenance.')->group(function () {
        Route::get('/', [MaintenanceController::class, 'index'])->name('index');
        Route::delete('/file', [MaintenanceController::class, 'destroyFile'])->name('destroy-file');
        Route::delete('/orphans', [MaintenanceController::class, 'destroyOrphans'])->name('destroy-orphans');
        Route::post('/cache', [MaintenanceController::class, 'clearCache'])->name('clear-cache');
    });
});
