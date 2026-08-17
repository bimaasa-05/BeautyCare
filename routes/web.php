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
use App\Http\Controllers\KasirLaporanController;
use App\Http\Controllers\BeauticianController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPelangganController;
use App\Http\Controllers\AdminBeautycianController;
use App\Http\Controllers\AdminLayananController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminStokController;
use App\Http\Controllers\AdminMembershipController;
use App\Http\Controllers\AdminPromoController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\AdminSupplierController;
use App\Http\Controllers\AdminBankController;
use App\Http\Controllers\AdminReservasiController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminLaporanPelangganController;
use App\Http\Controllers\KasirLaporanPelangganController;
use App\Http\Controllers\KasirDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPengaturanController;
use App\Http\Controllers\AdminRiwayatController;
use App\Http\Controllers\KasirPengeluaranController;
use App\Http\Controllers\BeatycianJadwalTreatmentController;
use App\Http\Controllers\MembershipPelangganController;
use App\Http\Controllers\BeautycianPelangganController;
use App\Http\Controllers\BeautycianLaporanReservasiController;
use App\Http\Controllers\BeautycianDashboardController;
use App\Http\Controllers\PelangganDashboardController;
use App\Http\Controllers\PelangganTreatmentController;
use App\Http\Controllers\PelangganBookingController;
use App\Http\Controllers\PelangganProdukController;
use App\Http\Controllers\KonsultasiPelangganController;
use App\Http\Controllers\KasirKonsultasiController;
use App\Http\Controllers\BeautycianKonsultasiController;
use App\Http\Controllers\AdminKonsultasiController;
use App\Http\Controllers\AdminLeaderboardController;
use App\Http\Controllers\RealtimeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $tingkatMembership = \App\Models\Membership::where('status', 'aktif')
        ->orderBy('min_transaksi')
        ->orderBy('min_pembelian')
        ->get();

    $pengaturan = \App\Models\Pengaturan::first();

    $kategoriLayanan = \App\Models\KategoriLayanan::where('status', 'tersedia')
        ->with(['layanan' => function($query) {
            $query->where('status', 'tersedia')
                  ->whereNotNull('foto')
                  ->where('foto', '!=', '')
                  ->orderBy('id_layanan');
        }])
        ->orderBy('nm_layanan')
        ->get();

    $ringkasanRating = \App\Models\Rating::ringkasanGlobal();
    $ulasanTerbaru = \App\Models\Rating::semuaTerbaru(3);

    return view('landing.index', compact('tingkatMembership', 'pengaturan', 'kategoriLayanan', 'ringkasanRating', 'ulasanTerbaru'));
})->name('home');

Route::post('/kontak', [App\Http\Controllers\ContactController::class, 'store'])->name('landing.contact');

//Halaman Layanan & Ulasan Publik
Route::get('/layanan/{layanan}', [App\Http\Controllers\LayananPublikController::class, 'show'])->name('layanan.detail')->whereNumber('layanan');
Route::get('/ulasan', [App\Http\Controllers\RatingController::class, 'index'])->name('rating.index');

//Halaman Legal
Route::get('/syarat-ketentuan', [App\Http\Controllers\LegalController::class, 'terms'])->name('legal.terms');
Route::get('/kebijakan-privasi', [App\Http\Controllers\LegalController::class, 'privacy'])->name('legal.privacy');

//Pusat Bantuan
Route::get('/bantuan', [App\Http\Controllers\HelpCenterController::class, 'index'])->name('help.index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Realtime Status Booking
    Route::get('/realtime/booking-status', [RealtimeController::class, 'bookingStatus'])->name('realtime.booking-status');

    //Notifikasi
    Route::get('/notif/get', [NotifikasiController::class, 'getNotif'])->name('notif.get');
    Route::get('/notif/aktivitas-baru', [NotifikasiController::class, 'popupAktivitas'])->name('notif.aktivitas-baru');
    Route::get('/{role}/notifikasi/index', [NotifikasiController::class, 'index'])->whereIn('role', ['admin', 'kasir', 'beautycian', 'pelanggan'])->name('notif.index');
    Route::get('/{role}/notifikasi/{id}/read', [NotifikasiController::class, 'markRead'])->whereIn('role', ['admin', 'kasir', 'beautycian', 'pelanggan'])->name('notif.read');
    Route::post('/{role}/notifikasi/mark-all-read', [NotifikasiController::class, 'markAllRead'])->whereIn('role', ['admin', 'kasir', 'beautycian', 'pelanggan'])->name('notif.mark-all-read');

    //Akses Login -- Rolee --- Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/dashboard/data', [AdminDashboardController::class, 'data'])->name('admin.dashboard.data');

        Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.user.index');
        Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.user.create');
        Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.user.store');
        Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.user.edit');
        Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.user.update');
        Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.user.destroy');
        Route::post('/admin/users/{user}/update-status', [AdminUserController::class, 'updateStatus'])->name('admin.user.update-status');

        Route::get('/admin/pelanggan', [AdminPelangganController::class, 'index'])->name('admin.pelanggan.index');
        Route::get('/admin/pelanggan/create', [AdminPelangganController::class, 'create'])->name('admin.pelanggan.create');
        Route::post('/admin/pelanggan', [AdminPelangganController::class, 'store'])->name('admin.pelanggan.store');
        Route::get('/admin/pelanggan/{pelanggan}/edit', [AdminPelangganController::class, 'edit'])->name('admin.pelanggan.edit');
        Route::put('/admin/pelanggan/{pelanggan}', [AdminPelangganController::class, 'update'])->name('admin.pelanggan.update');
        Route::delete('/admin/pelanggan/{pelanggan}', [AdminPelangganController::class, 'destroy'])->name('admin.pelanggan.destroy');
        Route::post('/admin/pelanggan/{user}/toggle-status', [AdminPelangganController::class, 'toggleStatus'])->name('admin.pelanggan.toggle-status');

        Route::get('/admin/karyawan', [AdminBeautycianController::class, 'index'])->name('admin.karyawan.index');
        Route::get('/admin/karyawan/create', [AdminBeautycianController::class, 'create'])->name('admin.karyawan.create');
        Route::post('/admin/karyawan', [AdminBeautycianController::class, 'store'])->name('admin.karyawan.store');
        Route::get('/admin/karyawan/{beautician}', [AdminBeautycianController::class, 'show'])->name('admin.karyawan.show');
        Route::get('/admin/karyawan/{beautician}/edit', [AdminBeautycianController::class, 'edit'])->name('admin.karyawan.edit');
        Route::put('/admin/karyawan/{beautician}', [AdminBeautycianController::class, 'update'])->name('admin.karyawan.update');
        Route::delete('/admin/karyawan/{beautician}', [AdminBeautycianController::class, 'destroy'])->name('admin.karyawan.destroy');

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

        Route::get('/admin/stok', [AdminStokController::class, 'index'])->name('admin.stok.index');
        Route::get('/admin/stok/refund', [AdminStokController::class, 'refundCreate'])->name('admin.stok.refund-create');
        Route::post('/admin/stok/refund', [AdminStokController::class, 'refundStore'])->name('admin.stok.refund-store');

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
        Route::get('/admin/supplier/{id}', [AdminSupplierController::class, 'show'])->name('admin.supplier.show');
        Route::get('/admin/supplier/{id}/edit', [AdminSupplierController::class, 'edit'])->name('admin.supplier.edit');
        Route::put('/admin/supplier/{id}', [AdminSupplierController::class, 'update'])->name('admin.supplier.update');
        Route::delete('/admin/supplier/{id}', [AdminSupplierController::class, 'destroy'])->name('admin.supplier.destroy');

        Route::get('/admin/bank', [AdminBankController::class, 'index'])->name('admin.bank.index');
        Route::get('/admin/bank/create', [AdminBankController::class, 'create'])->name('admin.bank.create');
        Route::post('/admin/bank', [AdminBankController::class, 'store'])->name('admin.bank.store');
        Route::get('/admin/bank/{id}', [AdminBankController::class, 'show'])->name('admin.bank.show');
        Route::get('/admin/bank/{id}/edit', [AdminBankController::class, 'edit'])->name('admin.bank.edit');
        Route::put('/admin/bank/{id}', [AdminBankController::class, 'update'])->name('admin.bank.update');
        Route::delete('/admin/bank/{id}', [AdminBankController::class, 'destroy'])->name('admin.bank.destroy');

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
        Route::post('/admin/profile/update-alamat', function (\Illuminate\Http\Request $req) {
            $req->validate(['alamat' => 'nullable|string|max:500']);
            auth()->user()->update(['alamat' => $req->alamat ?? '']);
            return back()->with('success', 'Alamat berhasil diperbarui!');
        })->name('admin.profile.update-alamat');
        Route::get('/admin/reservasi', [AdminReservasiController::class, 'index'])->name('admin.reservasi.index');
        Route::get('/admin/reservasi/{id}', [AdminReservasiController::class, 'show'])->name('admin.reservasi.show')->where('id', '[0-9]+');

        Route::get('/admin/transaksi', [AdminTransaksiController::class, 'index'])->name('admin.transaksi.index');
        Route::get('/admin/transaksi/export', [AdminTransaksiController::class, 'export'])->name('admin.transaksi.export');
        Route::get('/admin/transaksi/pembelian', [AdminTransaksiController::class, 'createPembelian'])->name('admin.transaksi.pembelian-create');
        Route::post('/admin/transaksi/pembelian', [AdminTransaksiController::class, 'storePembelian'])->name('admin.transaksi.pembelian-store');
        Route::post('/admin/transaksi', [AdminTransaksiController::class, 'store'])->name('admin.transaksi.store');
        Route::put('/admin/transaksi/{id}', [AdminTransaksiController::class, 'update'])->name('admin.transaksi.update');
        Route::delete('/admin/transaksi/{id}', [AdminTransaksiController::class, 'destroy'])->name('admin.transaksi.destroy');
        Route::get('/admin/transaksi/{id}', [AdminTransaksiController::class, 'show'])->name('admin.transaksi.show')->where('id', '[0-9]+');
        Route::get('/admin/transaksi/{id}/invoice', [AdminTransaksiController::class, 'invoice'])->name('admin.transaksi.invoice');
        Route::get('/admin/transaksi/{id}/invoice-pdf', [AdminTransaksiController::class, 'invoicePdf'])->name('admin.transaksi.invoice-pdf');
        Route::get('/admin/transaksi/{id}/struk', [AdminTransaksiController::class, 'struk'])->name('admin.transaksi.struk');

        Route::get('/admin/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('/admin/laporan/export-pdf', [AdminLaporanController::class, 'exportPDF'])->name('admin.laporan.export-pdf');
        Route::get('/admin/laporan/export-excel', [AdminLaporanController::class, 'exportExcel'])->name('admin.laporan.export-excel');

        //Route Pengaturan
        Route::get('/admin/pengaturan', [AdminPengaturanController::class, 'index'])->name('admin.pengaturan.index');
        Route::post('/admin/pengaturan', [AdminPengaturanController::class, 'update'])->name('admin.pengaturan.update');
        Route::get('/admin/laporan-pelanggan', [AdminLaporanPelangganController::class, 'index'])->name('admin.laporan-pelanggan.index');
        Route::get('/admin/laporan-pelanggan/export-pdf', [AdminLaporanPelangganController::class, 'exportPDF'])->name('admin.laporan-pelanggan.export-pdf');
        Route::get('/admin/laporan-pelanggan/export-excel', [AdminLaporanPelangganController::class, 'exportExcel'])->name('admin.laporan-pelanggan.export-excel');

        Route::get('/admin/riwayat', [AdminRiwayatController::class, 'index'])->name('admin.riwayat.index');
        Route::get('/admin/riwayat/{id}', [AdminRiwayatController::class, 'show'])->name('admin.riwayat.show');

        //Route Konsultasi Admin
        Route::get('/admin/konsultasi', [AdminKonsultasiController::class, 'index'])->name('admin.konsultasi.index');

        //Route Papan Peringkat
        Route::get('/admin/leaderboard', [AdminLeaderboardController::class, 'index'])->name('admin.leaderboard.index');
    });


    //-------------------------------------------------
    //Route Kasir
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/kasir/dashboard', [KasirDashboardController::class, 'index'])->name('kasir.dashboard');

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
        Route::get('/kasir/reservasi/slot-data', [KasirReservasiController::class, 'slotData'])->name('kasir.reservasi.slot-data');
        Route::get('/kasir/reservasi/{id}', [KasirReservasiController::class, 'show'])->name('kasir.reservasi.show');
        Route::get('/kasir/reservasi/{id}/edit', [KasirReservasiController::class, 'edit'])->name('kasir.reservasi.edit');
        Route::put('/kasir/reservasi/{id}', [KasirReservasiController::class, 'update'])->name('kasir.reservasi.update');
        Route::post('/kasir/reservasi/{id}/konfirmasi', [KasirReservasiController::class, 'konfirmasi'])->name('kasir.reservasi.konfirmasi');
        Route::delete('/kasir/reservasi/{id}', [KasirReservasiController::class, 'destroy'])->name('kasir.reservasi.destroy');

        Route::get('/kasir/checkin', [KasirCheckinController::class, 'index'])->name('kasir.checkin.index');
        Route::post('/kasir/checkin/{id}/process', [KasirCheckinController::class, 'checkIn'])->name('kasir.checkin.process');
        Route::post('/kasir/checkin/{id}/undo', [KasirCheckinController::class, 'undoCheckIn'])->name('kasir.checkin.undo');
        Route::get('/kasir/pembayaran', [KasirPembayaranController::class, 'index'])->name('kasir.pembayaran.index');
        Route::get('/kasir/pembayaran/pesanan-online', [KasirPembayaranController::class, 'pesananOnline'])->name('kasir.pembayaran.pesanan-online');
        Route::post('/kasir/pembayaran/verifikasi/{id}', [KasirPembayaranController::class, 'verifikasi'])->name('kasir.pembayaran.verifikasi');
        Route::get('/kasir/pembayaran/bayar/{id}', [KasirPembayaranController::class, 'create'])->name('kasir.pembayaran.create');
        Route::post('/kasir/pembayaran', [KasirPembayaranController::class, 'store'])->name('kasir.pembayaran.store');
        Route::get('/kasir/pembayaran/{id}', [KasirPembayaranController::class, 'show'])->name('kasir.pembayaran.show');
        Route::get('/kasir/invoice', [KasirTransaksiController::class, 'invoiceIndex'])->name('kasir.invoice.index');
        Route::get('/kasir/invoice/{id}', [KasirTransaksiController::class, 'invoice'])->name('kasir.invoice.show');
        Route::get('/kasir/invoice/{id}/pdf', [KasirTransaksiController::class, 'invoicePdf'])->name('kasir.invoice.pdf');
        Route::get('/kasir/struk/{id}', [KasirTransaksiController::class, 'struk'])->name('kasir.struk');
        Route::get('/kasir/riwayat-transaksi', [KasirRiwayatTransaksiController::class, 'index'])->name('kasir.riwayat-transaksi.index');
        Route::get('/kasir/riwayat-transaksi/{id}', [KasirRiwayatTransaksiController::class, 'show'])->name('kasir.riwayat-transaksi.show');

        Route::get('/kasir/pengeluaran', [KasirPengeluaranController::class, 'index'])->name('kasir.pengeluaran.index');
        Route::post('/kasir/pengeluaran', [KasirPengeluaranController::class, 'store'])->name('kasir.pengeluaran.store');
        Route::delete('/kasir/pengeluaran/{id}', [KasirPengeluaranController::class, 'destroy'])->name('kasir.pengeluaran.destroy');

        Route::get('/kasir/laporan', [KasirLaporanController::class, 'index'])->name('kasir.laporan.index');
        Route::get('/kasir/laporan/export-pdf', [KasirLaporanController::class, 'exportPDF'])->name('kasir.laporan.export-pdf');
        Route::get('/kasir/laporan/export-excel', [KasirLaporanController::class, 'exportExcel'])->name('kasir.laporan.export-excel');

        Route::get('/kasir/laporan-pelanggan', [KasirLaporanPelangganController::class, 'index'])->name('kasir.laporan-pelanggan.index');
        Route::get('/kasir/laporan-pelanggan/export-pdf', [KasirLaporanPelangganController::class, 'exportPDF'])->name('kasir.laporan-pelanggan.export-pdf');
        Route::get('/kasir/laporan-pelanggan/export-excel', [KasirLaporanPelangganController::class, 'exportExcel'])->name('kasir.laporan-pelanggan.export-excel');

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
        Route::post('/kasir/profile/update-alamat', function (\Illuminate\Http\Request $req) {
            $req->validate(['alamat' => 'nullable|string|max:500']);
            auth()->user()->update(['alamat' => $req->alamat ?? '']);
            return back()->with('success', 'Alamat berhasil diperbarui!');
        })->name('kasir.profile.update-alamat');

        //Route Konsultasi Kasir
        Route::get('/kasir/konsultasi', [KasirKonsultasiController::class, 'index'])->name('kasir.konsultasi.index');
        Route::post('/kasir/konsultasi/{id}/konfirmasi', [KasirKonsultasiController::class, 'konfirmasi'])->name('kasir.konsultasi.konfirmasi');
        Route::post('/kasir/konsultasi/{id}/tolak', [KasirKonsultasiController::class, 'tolak'])->name('kasir.konsultasi.tolak');
    });
    //--------------------------------------------------
    //Route BeautyCian
    Route::middleware(['role:beautycian'])->group(function () {
        Route::get('/beautycian/dashboard', [BeautycianDashboardController::class, 'index'])->name('beautycian.dashboard');

        //Profile Beautycian
        Route::get('/beautycian/profile', function () {
            return view('beautycian.profile.index');
        })->name('beautycian.profile');
        Route::post('/beautycian/profile/update-foto', function (\Illuminate\Http\Request $req) {
            $req->validate(['foto' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
            auth()->user()->update(['foto' => $req->file('foto')->store('profile-beautycian', 'public')]);
            return back()->with('message', 'Foto profil berhasil diperbarui!');
        })->name('beautycian.profile.update-foto');
        Route::post('/beautycian/profile/update', function (\Illuminate\Http\Request $req) {
            $req->validate(['nama' => 'required|string|max:255', 'email' => 'required|email|max:255|unique:users,email,' . auth()->id(), 'no_hp' => 'required|string|max:20']);
            auth()->user()->update($req->only(['nama', 'email', 'no_hp']));
            return back()->with('message', 'Profil berhasil diperbarui!');
        })->name('beautycian.profile.update');
        Route::post('/beautycian/profile/update-password', function (\Illuminate\Http\Request $req) {
            $req->validate(['current_password' => 'required|current_password', 'new_password' => 'required|string|min:8|confirmed']);
            auth()->user()->update(['password' => bcrypt($req->new_password)]);
            return back()->with('message', 'Password berhasil diperbarui!');
        })->name('beautycian.profile.update-password');
        Route::post('/beautycian/profile/update-alamat', function (\Illuminate\Http\Request $req) {
            $req->validate(['alamat' => 'nullable|string|max:500']);
            auth()->user()->update(['alamat' => $req->alamat ?? '']);
            return back()->with('message', 'Alamat berhasil diperbarui!');
        })->name('beautycian.profile.update-alamat');

        //Route Jadwal Treatment
        Route::get('/beautycian/jadwal-treatment', [BeatycianJadwalTreatmentController::class, 'index'])->name('beautycian.jadwal-treatment.index');
        Route::post('/beautycian/jadwal-treatment', [BeatycianJadwalTreatmentController::class, 'updateStatus'])->name('beautycian.jadwal-treatment.update');

        //Route Status Treatment (Kanban)
        Route::get('/beautycian/status-treatment', [BeatycianJadwalTreatmentController::class, 'statusTreatment'])->name('beautycian.status-treatment.index');
        Route::post('/beautycian/status-treatment/complete', [BeatycianJadwalTreatmentController::class, 'completeWithDoc'])->name('beautycian.status-treatment.complete');

        //Route Riwayat Treatment
        Route::get('/beautycian/riwayat-treatment', [BeatycianJadwalTreatmentController::class, 'riwayatTreatment'])->name('beautycian.riwayat-treatment.index');
        Route::get('/beautycian/riwayat-treatment/{id}', [BeatycianJadwalTreatmentController::class, 'showRiwayat'])->name('beautycian.riwayat-treatment.show');
        Route::post('/beautycian/riwayat-treatment/dokumentasi', [BeatycianJadwalTreatmentController::class, 'storeDokumentasi'])->name('beautycian.riwayat-treatment.dokumentasi');

        Route::get('/beautycian/pelanggan', [BeautycianPelangganController::class, 'index'])->name('beautycian.pelanggan.index');

        Route::get('/beautycian/laporan-reservasi', [BeautycianLaporanReservasiController::class, 'index'])->name('beautycian.laporan-reservasi.index');
        Route::get('/beautycian/laporan-reservasi/export-pdf', [BeautycianLaporanReservasiController::class, 'exportPDF'])->name('beautycian.laporan-reservasi.export-pdf');
        Route::get('/beautycian/laporan-reservasi/export-excel', [BeautycianLaporanReservasiController::class, 'exportExcel'])->name('beautycian.laporan-reservasi.export-excel');
        Route::get('/beautycian/laporan-reservasi/{id}', [BeautycianLaporanReservasiController::class, 'show'])->name('beautycian.laporan-reservasi.show')->where('id', '[0-9]+');

        //Route Konsultasi Beautycian
        Route::get('/beautycian/konsultasi', [BeautycianKonsultasiController::class, 'index'])->name('beautycian.konsultasi.index');
        Route::post('/beautycian/konsultasi/{id}/selesai', [BeautycianKonsultasiController::class, 'selesai'])->name('beautycian.konsultasi.selesai');
    });
    //--------------------------------------------------
    //Route Pelangggan
    Route::get('/pelanggan/dashboard', [PelangganDashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:pelanggan'])->name('dashboard');
    Route::middleware(['role:pelanggan'])->group(function () {

        //Route Booking
        Route::get('/pelanggan/booking', [PelangganBookingController::class, 'index'])->name('pelanggan.booking');
        Route::get('/pelanggan/booking/create', [PelangganBookingController::class, 'create'])->name('pelanggan.booking.create');
        Route::get('/pelanggan/booking/slot', [PelangganBookingController::class, 'slotJamData'])->name('pelanggan.booking.slot');
        Route::post('/pelanggan/booking', [PelangganBookingController::class, 'store'])->name('pelanggan.booking.store');
        Route::get('/pelanggan/booking/{id}/detail', [PelangganBookingController::class, 'show'])->name('pelanggan.booking.detail');
        Route::get('/pelanggan/booking/{id}/pembayaran', [PelangganBookingController::class, 'pembayaran'])->name('pelanggan.booking.pembayaran');
        Route::post('/pelanggan/booking/{id}/pembayaran', [PelangganBookingController::class, 'bayar'])->name('pelanggan.booking.bayar');
        Route::get('/pelanggan/booking/{id}/pdf', [PelangganBookingController::class, 'pdf'])->name('pelanggan.booking.pdf');
        Route::get('/pelanggan/booking/{id}/edit', [PelangganBookingController::class, 'edit'])->name('pelanggan.booking.edit');
        Route::put('/pelanggan/booking/{id}', [PelangganBookingController::class, 'update'])->name('pelanggan.booking.update');
        Route::delete('/pelanggan/booking/{id}', [PelangganBookingController::class, 'destroy'])->name('pelanggan.booking.destroy');

        //Route Treatment
        Route::get('/pelanggan/treatment', [PelangganTreatmentController::class, 'index'])->name('pelanggan.treatment');
        Route::get('/pelanggan/treatment/{id}', [PelangganTreatmentController::class, 'show'])->name('pelanggan.treatment.detail');
        Route::get('/pelanggan/treatment/{id}/pdf', [PelangganTreatmentController::class, 'pdf'])->name('pelanggan.treatment.pdf');

        //Route Promo
        Route::get('/pelanggan/promo', [App\Http\Controllers\PelangganPromoController::class, 'index'])->name('pelanggan.promo');
        Route::post('/pelanggan/promo/claim', [App\Http\Controllers\PelangganPromoController::class, 'claim'])->name('pelanggan.promo.claim');

        //Route Membership
        Route::get('/pelanggan/membership', [MembershipPelangganController::class, 'index'])->name('pelanggan.membership');

        //Route Konsultasi Pelanggan
        Route::get('/pelanggan/konsultasi', [KonsultasiPelangganController::class, 'index'])->name('pelanggan.konsultasi.index');
        Route::get('/pelanggan/konsultasi/create', [KonsultasiPelangganController::class, 'create'])->name('pelanggan.konsultasi.create');
        Route::post('/pelanggan/konsultasi', [KonsultasiPelangganController::class, 'store'])->name('pelanggan.konsultasi.store');

        //Route Saldo Akun
        Route::get('/pelanggan/saldo', [App\Http\Controllers\PelangganSaldoController::class, 'index'])->name('pelanggan.saldo.index');
        Route::get('/pelanggan/saldo/topup', [App\Http\Controllers\SaldoTopUpController::class, 'create'])->name('pelanggan.saldo.topup');
        Route::post('/pelanggan/saldo/topup', [App\Http\Controllers\SaldoTopUpController::class, 'store'])->name('pelanggan.saldo.topup.store');

        //Route Produk
        Route::get('/pelanggan/produk', [PelangganProdukController::class, 'index'])->name('pelanggan.produk');
        Route::get('/pelanggan/produk/{produk}', [PelangganProdukController::class, 'show'])->name('pelanggan.produk.detail')->whereNumber('produk');
        Route::post('/pelanggan/produk/favorit/toggle', [App\Http\Controllers\PelangganFavoritController::class, 'toggle'])->name('pelanggan.favorit.toggle');

        //Route Rating
        Route::get('/pelanggan/rating/layanan/{booking}', [App\Http\Controllers\PelangganRatingController::class, 'layanan'])->name('pelanggan.rating.layanan')->whereNumber('booking');
        Route::post('/pelanggan/rating', [App\Http\Controllers\RatingController::class, 'store'])->name('rating.store');
        Route::delete('/pelanggan/rating/{rating}', [App\Http\Controllers\RatingController::class, 'destroy'])->name('rating.destroy')->whereNumber('rating');

        //Route Keranjang
        Route::get('/pelanggan/keranjang', [App\Http\Controllers\KeranjangController::class, 'index'])->name('pelanggan.keranjang');
        Route::get('/pelanggan/keranjang/stok', [App\Http\Controllers\KeranjangController::class, 'stokRefresh'])->name('pelanggan.keranjang.stok');
        Route::get('/pelanggan/keranjang/history', [App\Http\Controllers\KeranjangController::class, 'history'])->name('pelanggan.keranjang.history');
        Route::get('/pelanggan/keranjang/{id}', [App\Http\Controllers\KeranjangController::class, 'show'])->name('pelanggan.keranjang.detail')->whereNumber('id');
        Route::post('/pelanggan/keranjang', [App\Http\Controllers\KeranjangController::class, 'store'])->name('pelanggan.keranjang.store');
        Route::put('/pelanggan/keranjang/{id}', [App\Http\Controllers\KeranjangController::class, 'update'])->name('pelanggan.keranjang.update');
        Route::delete('/pelanggan/keranjang/batch', [App\Http\Controllers\KeranjangController::class, 'batchDestroy'])->name('pelanggan.keranjang.batch');
        Route::delete('/pelanggan/keranjang/{id}', [App\Http\Controllers\KeranjangController::class, 'destroy'])->name('pelanggan.keranjang.destroy')->whereNumber('id');
        Route::post('/pelanggan/checkout-notif', [App\Http\Controllers\KeranjangController::class, 'checkoutNotif'])->name('pelanggan.checkout.notif');

        //Route Checkout Online
        Route::get('/pelanggan/checkout', [App\Http\Controllers\CheckoutController::class, 'create'])->name('pelanggan.checkout');
        Route::post('/pelanggan/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('pelanggan.checkout.store');

        //Route Pembayaran Online
        Route::get('/pelanggan/pembayaran/membership', [App\Http\Controllers\CheckoutController::class, 'pembayaranMembership'])->name('pelanggan.pembayaran.membership');
        Route::get('/pelanggan/pembayaran/{transaksi}', [App\Http\Controllers\PembayaranController::class, 'show'])->name('pelanggan.pembayaran.show');
        Route::get('/pelanggan/pembayaran/{transaksi}/berhasil', [App\Http\Controllers\PembayaranController::class, 'berhasil'])->name('pelanggan.pembayaran.berhasil');
        Route::get('/pelanggan/pembayaran/{transaksi}/status', [App\Http\Controllers\PembayaranController::class, 'status'])->name('pelanggan.pembayaran.status');
        Route::post('/pelanggan/pembayaran/{transaksi}/sudah-bayar', [App\Http\Controllers\PembayaranController::class, 'sudahBayar'])->name('pelanggan.pembayaran.sudah-bayar');
        Route::post('/pelanggan/pembayaran/{transaksi}/batal', [App\Http\Controllers\PembayaranController::class, 'batal'])->name('pelanggan.pembayaran.batal');
        Route::post('/pelanggan/pembayaran/{transaksi}/perpanjang', [App\Http\Controllers\PembayaranController::class, 'perpanjang'])->name('pelanggan.pembayaran.perpanjang');
        Route::post('/pelanggan/pembayaran/{transaksi}/bukti', [App\Http\Controllers\PembayaranController::class, 'uploadBukti'])->name('pelanggan.pembayaran.bukti');

        //Route Pesanan
        Route::get('/pelanggan/pesanan', [App\Http\Controllers\PesananController::class, 'index'])->name('pelanggan.pesanan.index');
        Route::get('/pelanggan/pesanan/{transaksi}', [App\Http\Controllers\PesananController::class, 'show'])->name('pelanggan.pesanan.show');

        //Route Profile
        Route::get('/pelanggan/profile', [App\Http\Controllers\PelangganProfileController::class, 'index'])->name('pelanggan.profile');
        Route::post('/pelanggan/profile/update-alamat', [App\Http\Controllers\PelangganProfileController::class, 'updateAlamat'])->name('pelanggan.profile.update-alamat');
        Route::post('/pelanggan/profile/update-foto', [App\Http\Controllers\PelangganProfileController::class, 'updateFoto'])->name('pelanggan.profile.update-foto');
        Route::post('/pelanggan/profile/update', [App\Http\Controllers\PelangganProfileController::class, 'update'])->name('pelanggan.profile.update');
        Route::post('/pelanggan/profile/update-password', [App\Http\Controllers\PelangganProfileController::class, 'updatePassword'])->name('pelanggan.profile.update-password');
    });
    //--------------------------------------------------
});


require __DIR__ . '/auth.php';
