<?php

use App\Http\Controllers\AdminPemasukanController;
use App\Http\Controllers\AdminPemesananController;
use App\Http\Controllers\AdminUlasanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExtraSewaController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\Front\DashboardController as FrontDashboardController;
use App\Http\Controllers\Front\VillaController as FrontVillaController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\KategoriVillaController;
use App\Http\Controllers\KonfirmasiPemesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\VillaController;


use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/kartikasari', [FrontVillaController::class, 'list'])->name('front.villa');
Route::get('/detail/{villa:slug}', [FrontVillaController::class, 'index'])->name('front.detail');


Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [FrontDashboardController::class, 'index'])->name('front.dashboard');
    
    
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan');
    Route::get('/pemesanan/{villa}', [PemesananController::class, 'create'])->name('pemesanan.create');
    Route::post('/pemesanan/store', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::patch('/pemesanan/batal/{pemesanan}', [PemesananController::class, 'batal'])->name('pemesanan.batal');

    Route::get('/pembayaran/{pemesanan}/bayar', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
    
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/ulasan/{pemesanan}', [UlasanController::class, 'create'])->name('ulasan.create');
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');

    // Route::resource('/profile', [ProfileController::class, 'index'])->name('front.profile.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/back/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/kategori', KategoriVillaController::class);
    Route::resource('/villa', VillaController::class);
    Route::delete('/villa/foto/{id}', [VillaController::class, 'deleteFoto'])->name('villa.foto.delete');
    
    Route::resource('/pengeluaran', PengeluaranController::class);
    Route::get('/pengeluaran/export/pdf', [PengeluaranController::class, 'exportPdf'])->name('pengeluaran.export.pdf');

    Route::resource('/extra', ExtraSewaController::class);
    Route::resource('/fasilitas', FasilitasController::class);

    Route::resource('/ulasan', AdminUlasanController::class)->only(['index']);
    Route::patch('/ulasan/{ulasan}/toogle', [AdminUlasanController::class, 'toogleVisibility'])->name('ulasan.toggle');

    Route::get('/pemasukan', [AdminPemasukanController::class, 'index'])->name('admin.pemasukan.index');
    Route::get('/pemasukan/pdf', [AdminPemasukanController::class, 'exportPdf'])->name('admin.pemasukan.pdf');
    Route::resource('/slide', SlideController::class)->except(['show']);

    Route::get('/admin/pemesanan', [AdminPemesananController::class, 'index'])->name('admin.pemesanan.index');
    Route::get('/admin/pemesanan/{pemesanan}', [AdminPemesananController::class, 'show'])->name('admin.pemesanan.show');
    Route::patch('/admin/pemesanan/{pemesanan}/konfirmasi', [AdminPemesananController::class, 'konfirmasi'])->name('admin.pemesanan.konfirmasi');
    Route::patch('/admin/pemesanan/{pemesanan}/tolak', [AdminPemesananController::class, 'tolak'])->name('admin.pemesanan.tolak');

    Route::resource('/konfirmasi', KonfirmasiPemesananController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::get('/back/dashboard', [DashboardController::class, 'index'])->name('front.dashboard');

//     Route::resource('/kategori', KategoriVillaController::class);
//     Route::resource('/villa', VillaController::class);
//     Route::resource('/pengeluaran', PengeluaranController::class);
//     Route::resource('/extra', ExtraSewaController::class);
//     Route::resource('/fasilitas', FasilitasController::class);

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
// });

require __DIR__.'/auth.php';
