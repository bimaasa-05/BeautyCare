<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KasirPelangganController;
use App\Http\Controllers\KasirTransaksiController;
use App\Http\Controllers\KasirReservasiController;
use App\Http\Controllers\BeauticianController;
use App\Http\Controllers\BeautycianController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPelangganController;
use App\Http\Controllers\AdminBeautycianController;
use App\Http\Controllers\AdminLayananController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminProdukController;
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
        
        Route::get('/admin/layanan', [AdminLayananController::class, 'index'])->name('admin.layanan.index');
        Route::get('/admin/layanan/create', [AdminLayananController::class, 'create'])->name('admin.layanan.create');
        Route::post('/admin/layanan', [AdminLayananController::class, 'store'])->name('admin.layanan.store');
        Route::get('/admin/layanan/{layanan}/edit', [AdminLayananController::class, 'edit'])->name('admin.layanan.edit');
        Route::put('/admin/layanan/{layanan}', [AdminLayananController::class, 'update'])->name('admin.layanan.update');
        Route::delete('/admin/layanan/{layanan}', [AdminLayananController::class, 'destroy'])->name('admin.layanan.destroy');

        Route::get('/admin/kategori', [AdminKategoriController::class, 'index'])->name('admin.kategori.index');
        Route::get('/admin/kategori/create', [AdminKategoriController::class, 'create'])->name('admin.kategori.create');
        Route::post('/admin/kategori', [AdminKategoriController::class, 'store'])->name('admin.kategori.store');
        Route::get('/admin/kategori/{id}/edit', [AdminKategoriController::class, 'edit'])->name('admin.kategori.edit');
        Route::put('/admin/kategori/{id}', [AdminKategoriController::class, 'update'])->name('admin.kategori.update');
        Route::delete('/admin/kategori/{id}', [AdminKategoriController::class, 'destroy'])->name('admin.kategori.destroy');

        Route::get('/admin/produk', [AdminProdukController::class, 'index'])->name('admin.produk.index');
        Route::get('/admin/produk/create', [AdminProdukController::class, 'create'])->name('admin.produk.create');
        Route::post('/admin/produk', [AdminProdukController::class, 'store'])->name('admin.produk.store');
        Route::get('/admin/produk/{produk}/edit', [AdminProdukController::class, 'edit'])->name('admin.produk.edit');
        Route::put('/admin/produk/{produk}', [AdminProdukController::class, 'update'])->name('admin.produk.update');
        Route::delete('/admin/produk/{produk}', [AdminProdukController::class, 'destroy'])->name('admin.produk.destroy');
    });


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

        Route::get('/kasir/transaksi', [KasirTransaksiController::class, 'index'])->name('kasir.transaksi.index');
        Route::get('/kasir/transaksi/create', [KasirTransaksiController::class, 'create'])->name('kasir.transaksi.create');
        Route::post('/kasir/transaksi', [KasirTransaksiController::class, 'store'])->name('kasir.transaksi.store');
        Route::get('/kasir/transaksi/{id}', [KasirTransaksiController::class, 'show'])->name('kasir.transaksi.show');
        Route::get('/kasir/transaksi/{id}/edit', [KasirTransaksiController::class, 'edit'])->name('kasir.transaksi.edit');
        Route::put('/kasir/transaksi/{id}', [KasirTransaksiController::class, 'update'])->name('kasir.transaksi.update');
        Route::delete('/kasir/transaksi/{id}', [KasirTransaksiController::class, 'destroy'])->name('kasir.transaksi.destroy');
        Route::get('/kasir/transaksi/qris-code', [KasirTransaksiController::class, 'qrisCode'])->name('kasir.transaksi.qris-code');

        Route::get('/kasir/reservasi', [KasirReservasiController::class, 'index'])->name('kasir.reservasi.index');
        Route::get('/kasir/reservasi/create', [KasirReservasiController::class, 'create'])->name('kasir.reservasi.create');
        Route::post('/kasir/reservasi', [KasirReservasiController::class, 'store'])->name('kasir.reservasi.store');
        Route::get('/kasir/reservasi/get-layanan', [KasirReservasiController::class, 'getLayanan'])->name('kasir.reservasi.get-layanan');
        Route::get('/kasir/reservasi/{id}', [KasirReservasiController::class, 'show'])->name('kasir.reservasi.show');
        Route::get('/kasir/reservasi/{id}/edit', [KasirReservasiController::class, 'edit'])->name('kasir.reservasi.edit');
        Route::put('/kasir/reservasi/{id}', [KasirReservasiController::class, 'update'])->name('kasir.reservasi.update');
        Route::delete('/kasir/reservasi/{id}', [KasirReservasiController::class, 'destroy'])->name('kasir.reservasi.destroy');

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
    Route::middleware(['role:pelanggan'])->group(function () {
        
        //Route Booking
        Route::get('/pelanggan/booking', [PelangganController::class, 'index'])->name('pelanggan.booking');
        Route::get('/pelanggan/booking/create', [PelangganController::class, 'create'])->name('pelanggan.booking.create');
        Route::post('/pelanggan/booking', [PelangganController::class, 'store'])->name('pelanggan.booking.store');
        Route::get('/pelanggan/booking/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.booking.edit');
        Route::put('/pelanggan/booking/{id}', [PelangganController::class, 'update'])->name('pelanggan.booking.update');
        Route::delete('/pelanggan/booking/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.booking.destroy');

        //Route Reservasi
        Route::get('/pelanggan/reservasi', function () {
            return view('pelanggan.reservasi.index');
        })->name('pelanggan.reservasi');

        //Route Treatment
        Route::get('/pelanggan/treatment', function () {
            return view('pelanggan.treatment.index');
        })->name('pelanggan.treatment');

        //Route Promo
        Route::get('/pelanggan/promo', function () {
            return view('pelanggan.promo.index');
        })->name('pelanggan.promo');

        //Route Profile
        Route::get('/pelanggan/profile', function () {
            return view('pelanggan.profile.index');
        })->name('pelanggan.profile');

        Route::post('/pelanggan/profile/update-foto', function (\Illuminate\Http\Request $req) {
            $req->validate(['foto' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
            $user = auth()->user();
            $file = $req->file('foto');
            $path = $file->store('profile-pelanggan', 'public');
            $user->update(['foto' => $path]);
            return back()->with('success', 'Foto profil berhasil diperbarui!');
        })->name('pelanggan.profile.update-foto');

        Route::post('/pelanggan/profile/update', function (\Illuminate\Http\Request $req) {
            $req->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
                'no_hp' => 'required|string|max:20',
            ]);
            auth()->user()->update($req->only(['nama', 'email', 'no_hp']));
            return back()->with('success', 'Profil berhasil diperbarui!');
        })->name('pelanggan.profile.update');

        Route::post('/pelanggan/profile/update-password', function (\Illuminate\Http\Request $req) {
            $req->validate([
                'current_password' => 'required|current_password',
                'new_password' => 'required|string|min:8|confirmed',
            ]);
            auth()->user()->update(['password' => bcrypt($req->new_password)]);
            return back()->with('success', 'Password berhasil diperbarui!');
        })->name('pelanggan.profile.update-password');
    });
    //--------------------------------------------------
});


require __DIR__ . '/auth.php';