<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KasirPelangganController;
use App\Http\Controllers\KasirTransaksiController;
use App\Http\Controllers\KasirReservasiController;
use App\Http\Controllers\KasirCheckinController;
use App\Http\Controllers\KasirPembayaranController;
use App\Http\Controllers\KasirRiwayatTransaksiController;
use App\Http\Controllers\BeauticianController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPelangganController;
use App\Http\Controllers\AdminBeautycianController;
use App\Http\Controllers\AdminLayananController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminMembershipController;
use App\Http\Controllers\AdminPromoController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\AdminSupplierController;
use App\Http\Controllers\AdminReservasiController;
use App\Http\Controllers\AdminTransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.index');
})->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Notifikasi
    Route::get('/notif/get', [NotifikasiController::class, 'getNotif'])->name('notif.get');
    Route::get('/notif/{id}/read', [NotifikasiController::class, 'markRead'])->name('notif.read');
    Route::post('/notif/mark-all-read', [NotifikasiController::class, 'markAllRead'])->name('notif.mark-all-read');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notif.index');

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

        Route::get('/admin/membership', [AdminMembershipController::class, 'index'])->name('admin.membership.index');
        Route::get('/admin/membership/create', [AdminMembershipController::class, 'create'])->name('admin.membership.create');
        Route::post('/admin/membership', [AdminMembershipController::class, 'store'])->name('admin.membership.store');
        Route::get('/admin/membership/{id}/edit', [AdminMembershipController::class, 'edit'])->name('admin.membership.edit');
        Route::put('/admin/membership/{id}/status', [AdminMembershipController::class, 'updateStatus'])->name('admin.membership.status');
        Route::put('/admin/membership/{id}', [AdminMembershipController::class, 'update'])->name('admin.membership.update');
        Route::delete('/admin/membership/{id}', [AdminMembershipController::class, 'destroy'])->name('admin.membership.destroy');

        Route::get('/admin/promo', [AdminPromoController::class, 'index'])->name('admin.promo.index');
        Route::get('/admin/promo/create', [AdminPromoController::class, 'create'])->name('admin.promo.create');
        Route::post('/admin/promo', [AdminPromoController::class, 'store'])->name('admin.promo.store');
        Route::get('/admin/promo/{id}/edit', [AdminPromoController::class, 'edit'])->name('admin.promo.edit');
        Route::put('/admin/promo/{id}', [AdminPromoController::class, 'update'])->name('admin.promo.update');
        Route::delete('/admin/promo/{id}', [AdminPromoController::class, 'destroy'])->name('admin.promo.destroy');

        Route::get('/admin/supplier', [AdminSupplierController::class, 'index'])->name('admin.supplier.index');
        Route::get('/admin/supplier/create', [AdminSupplierController::class, 'create'])->name('admin.supplier.create');
        Route::post('/admin/supplier', [AdminSupplierController::class, 'store'])->name('admin.supplier.store');
        Route::get('/admin/supplier/{id}/edit', [AdminSupplierController::class, 'edit'])->name('admin.supplier.edit');
        Route::put('/admin/supplier/{id}', [AdminSupplierController::class, 'update'])->name('admin.supplier.update');
        Route::delete('/admin/supplier/{id}', [AdminSupplierController::class, 'destroy'])->name('admin.supplier.destroy');

        //Profile Admin
        Route::get('/admin/profile', function () {
            return view('admin.profile.index');
        })->name('admin.profile');
        Route::post('/admin/profile/update-foto', function (\Illuminate\Http\Request $req) {
            $req->validate(['foto' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
            auth()->user()->update(['foto' => $req->file('foto')->store('profile-admin', 'public')]);
            return back()->with('success', 'Foto profil berhasil diperbarui!');
        })->name('admin.profile.update-foto');
        Route::post('/admin/profile/update', function (\Illuminate\Http\Request $req) {
            $req->validate(['nama' => 'required|string|max:255', 'email' => 'required|email|max:255|unique:users,email,' . auth()->id(), 'no_hp' => 'required|string|max:20']);
            auth()->user()->update($req->only(['nama', 'email', 'no_hp']));
            return back()->with('success', 'Profil berhasil diperbarui!');
        })->name('admin.profile.update');
        Route::post('/admin/profile/update-password', function (\Illuminate\Http\Request $req) {
            $req->validate(['current_password' => 'required|current_password', 'new_password' => 'required|string|min:8|confirmed']);
            auth()->user()->update(['password' => bcrypt($req->new_password)]);
            return back()->with('success', 'Password berhasil diperbarui!');
        })->name('admin.profile.update-password');
        Route::get('/admin/reservasi', [AdminReservasiController::class, 'index'])->name('admin.reservasi.index');
        Route::get('/admin/reservasi/create', [AdminReservasiController::class, 'create'])->name('admin.reservasi.create');
        Route::post('/admin/reservasi', [AdminReservasiController::class, 'store'])->name('admin.reservasi.store');
        Route::get('/admin/reservasi/get-layanan', [AdminReservasiController::class, 'getLayanan'])->name('admin.reservasi.get-layanan');
        Route::put('/admin/reservasi/{id}/status', [AdminReservasiController::class, 'updateStatus'])->name('admin.reservasi.status');
        Route::get('/admin/reservasi/{id}', [AdminReservasiController::class, 'show'])->name('admin.reservasi.show');
        Route::get('/admin/reservasi/{id}/edit', [AdminReservasiController::class, 'edit'])->name('admin.reservasi.edit');
        Route::put('/admin/reservasi/{id}', [AdminReservasiController::class, 'update'])->name('admin.reservasi.update');
        Route::delete('/admin/reservasi/{id}', [AdminReservasiController::class, 'destroy'])->name('admin.reservasi.destroy');

        Route::get('/admin/transaksi', [AdminTransaksiController::class, 'index'])->name('admin.transaksi.index');
        Route::get('/admin/transaksi/export', [AdminTransaksiController::class, 'export'])->name('admin.transaksi.export');
        Route::get('/admin/transaksi/create', [AdminTransaksiController::class, 'create'])->name('admin.transaksi.create');
        Route::post('/admin/transaksi', [AdminTransaksiController::class, 'store'])->name('admin.transaksi.store');
        Route::get('/admin/transaksi/{id}', [AdminTransaksiController::class, 'show'])->name('admin.transaksi.show');
        Route::get('/admin/transaksi/{id}/invoice', [AdminTransaksiController::class, 'invoice'])->name('admin.transaksi.invoice');
        Route::get('/admin/transaksi/{id}/edit', [AdminTransaksiController::class, 'edit'])->name('admin.transaksi.edit');
        Route::put('/admin/transaksi/{id}', [AdminTransaksiController::class, 'update'])->name('admin.transaksi.update');
        Route::delete('/admin/transaksi/{id}', [AdminTransaksiController::class, 'destroy'])->name('admin.transaksi.destroy');
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

        Route::get('/kasir/reservasi', [KasirReservasiController::class, 'index'])->name('kasir.reservasi.index');
        Route::get('/kasir/reservasi/create', [KasirReservasiController::class, 'create'])->name('kasir.reservasi.create');
        Route::post('/kasir/reservasi', [KasirReservasiController::class, 'store'])->name('kasir.reservasi.store');
        Route::get('/kasir/reservasi/get-layanan', [KasirReservasiController::class, 'getLayanan'])->name('kasir.reservasi.get-layanan');
        Route::get('/kasir/reservasi/{id}', [KasirReservasiController::class, 'show'])->name('kasir.reservasi.show');
        Route::get('/kasir/reservasi/{id}/edit', [KasirReservasiController::class, 'edit'])->name('kasir.reservasi.edit');
        Route::put('/kasir/reservasi/{id}', [KasirReservasiController::class, 'update'])->name('kasir.reservasi.update');
        Route::delete('/kasir/reservasi/{id}', [KasirReservasiController::class, 'destroy'])->name('kasir.reservasi.destroy');

        Route::get('/kasir/checkin', [KasirCheckinController::class, 'index'])->name('kasir.checkin.index');
        Route::post('/kasir/checkin/{id}/process', [KasirCheckinController::class, 'checkIn'])->name('kasir.checkin.process');
        Route::post('/kasir/checkin/{id}/undo', [KasirCheckinController::class, 'undoCheckIn'])->name('kasir.checkin.undo');
        Route::get('/kasir/pembayaran', [KasirPembayaranController::class, 'index'])->name('kasir.pembayaran.index');
        Route::get('/kasir/pembayaran/bayar/{id}', [KasirPembayaranController::class, 'create'])->name('kasir.pembayaran.create');
        Route::post('/kasir/pembayaran', [KasirPembayaranController::class, 'store'])->name('kasir.pembayaran.store');
        Route::get('/kasir/pembayaran/{id}', [KasirPembayaranController::class, 'show'])->name('kasir.pembayaran.show');
        Route::get('/kasir/invoice', [KasirTransaksiController::class, 'invoiceIndex'])->name('kasir.invoice.index');
        Route::get('/kasir/invoice/{id}', [KasirTransaksiController::class, 'invoice'])->name('kasir.invoice.show');
        Route::get('/kasir/riwayat-transaksi', [KasirRiwayatTransaksiController::class, 'index'])->name('kasir.riwayat-transaksi.index');
        Route::get('/kasir/riwayat-transaksi/{id}', [KasirRiwayatTransaksiController::class, 'show'])->name('kasir.riwayat-transaksi.show');

        //Profile Kasir
        Route::get('/kasir/profile', function () {
            return view('kasir.profile.index');
        })->name('kasir.profile');
        Route::post('/kasir/profile/update-foto', function (\Illuminate\Http\Request $req) {
            $req->validate(['foto' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
            auth()->user()->update(['foto' => $req->file('foto')->store('profile-kasir', 'public')]);
            return back()->with('success', 'Foto profil berhasil diperbarui!');
        })->name('kasir.profile.update-foto');
        Route::post('/kasir/profile/update', function (\Illuminate\Http\Request $req) {
            $req->validate(['nama' => 'required|string|max:255', 'email' => 'required|email|max:255|unique:users,email,' . auth()->id(), 'no_hp' => 'required|string|max:20']);
            auth()->user()->update($req->only(['nama', 'email', 'no_hp']));
            return back()->with('success', 'Profil berhasil diperbarui!');
        })->name('kasir.profile.update');
        Route::post('/kasir/profile/update-password', function (\Illuminate\Http\Request $req) {
            $req->validate(['current_password' => 'required|current_password', 'new_password' => 'required|string|min:8|confirmed']);
            auth()->user()->update(['password' => bcrypt($req->new_password)]);
            return back()->with('success', 'Password berhasil diperbarui!');
        })->name('kasir.profile.update-password');
    });
    //--------------------------------------------------
    //Route BeautyCian
    Route::middleware(['role:beautycian'])->group(function () {
        Route::get('/beautycian/dashboard', function () {
            return view('beautycian.dashboard');
        })->name('beautycian.dashboard');

        //Profile Beautycian
        Route::get('/beautycian/profile', function () {
            return view('beautycian.profile.index');
        })->name('beautycian.profile');
        Route::post('/beautycian/profile/update-foto', function (\Illuminate\Http\Request $req) {
            $req->validate(['foto' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
            auth()->user()->update(['foto' => $req->file('foto')->store('profile-beautycian', 'public')]);
            return back()->with('success', 'Foto profil berhasil diperbarui!');
        })->name('beautycian.profile.update-foto');
        Route::post('/beautycian/profile/update', function (\Illuminate\Http\Request $req) {
            $req->validate(['nama' => 'required|string|max:255', 'email' => 'required|email|max:255|unique:users,email,' . auth()->id(), 'no_hp' => 'required|string|max:20']);
            auth()->user()->update($req->only(['nama', 'email', 'no_hp']));
            return back()->with('success', 'Profil berhasil diperbarui!');
        })->name('beautycian.profile.update');
        Route::post('/beautycian/profile/update-password', function (\Illuminate\Http\Request $req) {
            $req->validate(['current_password' => 'required|current_password', 'new_password' => 'required|string|min:8|confirmed']);
            auth()->user()->update(['password' => bcrypt($req->new_password)]);
            return back()->with('success', 'Password berhasil diperbarui!');
        })->name('beautycian.profile.update-password');
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

        //Route Membership
        Route::get('/pelanggan/membership', function () {
            return view('pelanggan.membership.index');
        })->name('pelanggan.membership');

        //Route Produk
        Route::get('/pelanggan/produk', function () {
            return view('pelanggan.produk.index');
        })->name('pelanggan.produk');

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
