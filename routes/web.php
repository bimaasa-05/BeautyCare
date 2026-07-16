<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KasirPelangganController;
use App\Http\Controllers\BeauticianController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.index');
})->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Akses Login -- Rolee --- Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.user.create');
    });
    Route::get('/admin/pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan.index');
    Route::get('/admin/beautician', [BeauticianController::class, 'index'])->name('admin.beautician.index');


    //-------------------------------------------------
    //Route Kasir
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/kasir/dashboard', function () {
            return view('kasir.dashboard');
        })->name('kasir.dashboard');

        Route::get('/kasir/pelanggan', [KasirPelangganController::class, 'index'])->name('kasir.pelanggan.index');
        Route::get('/kasir/pelanggan/create', [KasirPelangganController::class, 'create'])->name('kasir.pelanggan.create');
        Route::post('/kasir/pelanggan', [KasirPelangganController::class, 'store'])->name('kasir.pelanggan.store');
        Route::get('/kasir/pelanggan/{id}', [KasirPelangganController::class, 'show'])->name('kasir.pelanggan.show');
        Route::get('/kasir/pelanggan/{id}/edit', [KasirPelangganController::class, 'edit'])->name('kasir.pelanggan.edit');
        Route::put('/kasir/pelanggan/{id}', [KasirPelangganController::class, 'update'])->name('kasir.pelanggan.update');
        Route::delete('/kasir/pelanggan/{id}', [KasirPelangganController::class, 'destroy'])->name('kasir.pelanggan.destroy');

        Route::get('/kasir/transaksi', function () {
            return view('kasir.transaksi.index');
        })->name('kasir.transaksi.index');
        Route::get('/kasir/checkin', function () {
            return view('kasir.checkin.index');
        })->name('kasir.checkin.index');
        Route::get('/kasir/pembayaran', function () {
            return view('kasir.pembayaran.index');
        })->name('kasir.pembayaran.index');
        Route::get('/kasir/invoice', function () {
            return view('kasir.invoice.index');
        })->name('kasir.invoice.index');
        Route::get('/kasir/riwayat-transaksi', function () {
            return view('kasir.riwayat-transaksi.index');
        })->name('kasir.riwayat-transaksi.index');
    });
    //--------------------------------------------------
    //Route BeautyCian
    Route::middleware(['role:beautycian'])->group(function () {
        Route::get('/beautycian/dashboard', function () {
            return view('beautycian.dashboard');
        })->name('beautycian.dashboard');
    });
    //--------------------------------------------------
    //Route Pelangggan
    Route::get('/pelanggan/dashboard', function () {
        return view('pelanggan.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
});


require __DIR__ . '/auth.php';
