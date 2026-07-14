<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\BeauticianController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.index');
})->name('home');

Route::get('/pelanggan/dashboard', function () {
    return view('pelanggan.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Akses Login -- Rolee ---
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/admin/pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan.index');
        Route::get('/admin/beautician', [BeauticianController::class, 'index'])->name('admin.beautician.index');
    });
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/kasir/dashboard', function () {
            return view('kasir.dashboard');
        })->name('kasir.dashboard');
    });
    Route::middleware(['role:beautycian'])->group(function () {
        Route::get('/beautycian/dashboard', function () {
            return view('beautycian.dashboard');
        })->name('beautycian.dashboard');
    });
});

require __DIR__ . '/auth.php';