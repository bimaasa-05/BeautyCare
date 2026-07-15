<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\BeautycianController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPelangganController;
use App\Http\Controllers\AdminBeautycianController;
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

        Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.user.index');
        Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.user.create');
        Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.user.store');
        Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.user.edit');
        Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.user.update');
        Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.user.destroy');
        Route::get('/admin/pelanggan', [AdminPelangganController::class, 'index'])->name('admin.pelanggan.index');
        Route::get('/admin/pelanggan/create', [AdminPelangganController::class, 'create'])->name('admin.pelanggan.create');
        Route::post('/admin/pelanggan', [AdminPelangganController::class, 'store'])->name('admin.pelanggan.store');
        Route::get('/admin/pelanggan/{pelanggan}/edit', [AdminPelangganController::class, 'edit'])->name('admin.pelanggan.edit');
        Route::put('/admin/pelanggan/{pelanggan}', [AdminPelangganController::class, 'update'])->name('admin.pelanggan.update');
        Route::delete('/admin/pelanggan/{pelanggan}', [AdminPelangganController::class, 'destroy'])->name('admin.pelanggan.destroy');
        Route::get('/admin/beautician', [AdminBeautycianController::class, 'index'])->name('admin.beautician.index');
        Route::get('/admin/beautician/create', [AdminBeautycianController::class, 'create'])->name('admin.beautician.create');
        Route::post('/admin/beautician', [AdminBeautycianController::class, 'store'])->name('admin.beautician.store');
        Route::get('/admin/beautician/{beautician}/edit', [AdminBeautycianController::class, 'edit'])->name('admin.beautician.edit');
        Route::put('/admin/beautician/{beautician}', [AdminBeautycianController::class, 'update'])->name('admin.beautician.update');
        Route::delete('/admin/beautician/{beautician}', [AdminBeautycianController::class, 'destroy'])->name('admin.beautician.destroy');
    });


    //-------------------------------------------------
    //Route Kasir
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/kasir/dashboard', function () {
            return view('kasir.dashboard');
        })->name('kasir.dashboard');
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
     Route::get('/pelanggan/booking', [PelangganController::class, 'index'])->name('pelanggan.booking');
    //--------------------------------------------------
});


require __DIR__ . '/auth.php';