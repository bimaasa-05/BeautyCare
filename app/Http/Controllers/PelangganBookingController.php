<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\DetailTransaksi;
use App\Models\Layanan;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Membership;
use App\Models\Pembayaran;
use App\Models\PromoKlaim;
use App\Models\Transaksi;
use App\Helpers\ActivityLogger;
use App\Services\SaldoAkunService;
use App\Support\BookingSlot;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganBookingController extends Controller
{
    public function index(Request $request)
    {
        $id_pelanggan = $this->resolveIdPelanggan();

        $bookings = Booking::with(['detail.layanan', 'karyawan', 'transaksi'])
            ->where('id_pelanggan', $id_pelanggan)
            ->orderBy('id_booking', 'desc')
            ->get();

        $total_booking = $bookings->count();
        $menunggu = $bookings->where('status', 'menunggu')->count();
        $dikonfirmasi = $bookings->where('status', 'dikonfirmasi')->count();
        $selesai = $bookings->where('status', 'selesai')->count();
        $dibatalkan = $bookings->where('status', 'dibatalkan')->count();

        $activeBooking = Booking::where('id_pelanggan', $id_pelanggan)
            ->whereIn('status', ['menunggu', 'dikonfirmasi', 'diproses'])
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        $search = $request->search;

        if ($search) {
            $bookings = $bookings->filter(function ($b) use ($search) {
                $keyword = strtolower($search);
                $idBooking = '#' . str_pad($b->id_booking, 3, '0', STR_PAD_LEFT);
                $namaKaryawan = $b->karyawan ? strtolower($b->karyawan->nama) : '';
                $nmLayanan = $b->detail->filter(fn($d) => $d->layanan)->pluck('layanan.nm_layanan')->implode(' ');

                return str_contains(strtolower($b->status), $keyword)
                    || str_contains(strtolower($b->tanggal), $keyword)
                    || str_contains(strtolower($b->jam), $keyword)
                    || str_contains(strtolower($b->catatan), $keyword)
                    || str_contains($namaKaryawan, $keyword)
                    || str_contains($nmLayanan, $keyword)
                    || str_contains(strtolower($idBooking), $keyword);
            });
        }

        return view('pelanggan.booking.index', compact(
            'bookings',
            'total_booking',
            'menunggu',
            'dikonfirmasi',
            'selesai',
            'dibatalkan',
            'activeBooking',
            'search'
        ));
    }

    public function create()
    {
        if ($this->hasActiveBooking()) {
            return redirect()->route('pelanggan.booking')->with('error', 'Anda masih memiliki booking yang belum selesai. Selesaikan booking Anda terlebih dahulu sebelum membuat booking baru.');
        }

        $layanans = Layanan::where('status', 'Tersedia')->get();
        $karyawans = Karyawan::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'beautycian'))
            ->where('status', 'Tersedia')
            ->orderBy('id_user')
            ->get();

        $karyawanSibukIds = Booking::where('status', 'diproses')
            ->whereNotNull('id_karyawan')
            ->distinct()
            ->pluck('id_karyawan')
            ->toArray();

        $user = auth()->user();
        $diskonMember = 0;
        $pelanggan = Pelanggan::dariUser($user);
        if ($pelanggan && $pelanggan->id_member) {
            $member = $pelanggan->membershipAktif();
            if ($member) {
                $diskonMember = (int) $member->diskon;
            }
        }

        $claimedPromos = PromoKlaim::with('promo')
            ->where('id_user', auth()->id())
            ->where('status', 'tersedia')
            ->get()
            ->filter(function ($klaim) {
                return $klaim->promo
                    && $klaim->promo->jenis_promo !== 'Buy 1 Get 1'
                    && $klaim->promo->selesai > now()->format('Y-m-d');
            });

        $bookingsPerDay = Booking::get()
            ->groupBy(fn($b) => \Carbon\Carbon::parse($b->tanggal)->format('Y-m-d'))
            ->map(fn($group) => [
                'total' => $group->count(),
                'aktif' => $group->whereIn('status', ['menunggu', 'dikonfirmasi', 'diproses'])->count(),
                'selesai' => $group->where('status', 'selesai')->count(),
                'dibatalkan' => $group->where('status', 'dibatalkan')->count(),
            ]);

        $slotJam = BookingSlot::slotJam();
        $tanggalAwal = request('tanggal', now()->toDateString());
        $bookedJamByKaryawan = BookingSlot::blokirJamKaryawan($tanggalAwal);
        $bookedJamGlobal = BookingSlot::blokirJamGlobal($tanggalAwal);
        $jamLewat = BookingSlot::jamLewat($tanggalAwal);
        $sedangMelayaniDetail = BookingSlot::sedangMelayaniDetail();

        return view('pelanggan.booking.create', compact('layanans', 'karyawans', 'karyawanSibukIds', 'diskonMember', 'claimedPromos', 'bookingsPerDay', 'slotJam', 'bookedJamByKaryawan', 'bookedJamGlobal', 'jamLewat', 'sedangMelayaniDetail'));
    }

    public function slotJamData(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();

        return response()->json([
            'bookedJamByKaryawan' => BookingSlot::blokirJamKaryawan($tanggal),
            'bookedJamGlobal' => BookingSlot::blokirJamGlobal($tanggal),
            'jamLewat' => BookingSlot::jamLewat($tanggal),
        ]);
    }

    public function store(Request $request)
    {
        if ($this->hasActiveBooking()) {
            return redirect()->route('pelanggan.booking')->with('error', 'Anda masih memiliki booking yang belum selesai. Selesaikan booking Anda terlebih dahulu sebelum membuat booking baru.');
        }

        $request->validate([
            'id_layanan' => 'required|array',
            'id_layanan.*' => 'integer|exists:layanan,id_layanan',
            'id_karyawan' => 'required|integer',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'harga' => 'required|array',
            'harga.*' => 'numeric',
            'diskon' => 'nullable|array',
            'diskon.*' => 'numeric|min:0',
            'catatan' => 'nullable|string',
            'id_promo' => 'nullable|integer|exists:promo,id_promo',
        ]);

        $jam = BookingSlot::normalJam($request->jam);

        if (Booking::where('id_karyawan', $request->id_karyawan)->where('status', 'diproses')->exists()) {
            return redirect()->back()->withErrors('Terapis sedang melayani pelanggan lain. Silakan pilih terapis lain yang tersedia.');
        }

        if (!BookingSlot::validJamSlot($jam)) {
            return redirect()->back()->withInput()->withErrors(['jam' => 'Jam harus berada dalam jam operasional toko (' . BookingSlot::formatJamIndo(BookingSlot::jamBuka()) . ' - ' . BookingSlot::formatJamIndo(BookingSlot::jamTutup()) . ').']);
        }

        if ($request->tanggal < now()->toDateString()) {
            return redirect()->back()->withInput()->withErrors(['tanggal' => 'Tanggal booking tidak boleh di masa lalu.']);
        }

        $durasi = (int) Layanan::whereIn('id_layanan', $request->id_layanan)->sum('durasi');
        if (BookingSlot::jamBentrok($request->id_karyawan, $request->tanggal, $jam, null, $durasi)) {
            return redirect()->back()->withInput()->withErrors(['jam' => 'Jam tersebut sudah dibooking untuk terapis yang dipilih (sudah memperhitungkan durasi layanan). Silakan pilih jam lain.']);
        }

        if (\Carbon\Carbon::parse($request->tanggal . ' ' . $jam)->lte(now())) {
            return redirect()->back()->withInput()->withErrors(['jam' => 'Jam booking sudah lewat. Silakan pilih jam yang masih tersedia.']);
        }

        $idPromo = $request->id_promo;
        $promo = null;
        if ($idPromo) {
            $promoKlaim = PromoKlaim::with('promo')
                ->where('id_user', auth()->id())
                ->where('id_promo', $idPromo)
                ->where('status', 'tersedia')
                ->first();

            if (!$promoKlaim) {
                return redirect()->back()->withErrors('Promo tidak tersedia atau sudah digunakan');
            }

            $promo = $promoKlaim->promo;

            if ($promo->selesai <= now()->format('Y-m-d')) {
                return redirect()->back()->withErrors('Promo sudah berakhir dan tidak dapat digunakan');
            }

            if ($promo->jenis_promo === 'Buy 1 Get 1') {
                return redirect()->back()->withErrors('Promo ' . $promo->nm_promo . ' (Buy 1 Get 1) hanya berlaku untuk produk, bukan layanan');
            }

            if (!$promo->berlakuUntuk(auth()->user())) {
                return redirect()->back()->withErrors('Promo ' . $promo->nm_promo . ' tidak berlaku untuk Anda');
            }

            $eligibleLayanan = array_values(array_filter(
                $request->id_layanan,
                fn($idLayanan) => $promo->itemEligible('Layanan', $idLayanan)
            ));

            if (empty($eligibleLayanan)) {
                return redirect()->back()->withErrors('Promo ' . $promo->nm_promo . ' tidak berlaku untuk layanan yang dipilih');
            }

            $promoKlaim->update(['status' => 'digunakan']);
        }

        $idPelanggan = $this->resolveIdPelanggan();

        $booking = Booking::create([
            'id_pelanggan' => $idPelanggan,
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'jam' => $jam,
            'status' => 'menunggu',
            'catatan' => $request->catatan ?? '',
        ]);

        $idLayanans = $request->id_layanan;
        $hargas = $request->harga;
        $diskons = $request->diskon ?? [];

        $diskonPromoById = [];
        if ($promo) {
            $itemsEligible = [];
            foreach ($idLayanans as $i => $idLayanan) {
                $harga = (float) ($hargas[$i] ?? 0);
                if ($promo->itemEligible('Layanan', $idLayanan)) {
                    $itemsEligible[] = ['jenis' => 'Layanan', 'id_item' => (int) $idLayanan, 'subtotal' => $harga];
                }
            }

            $totalDiskonPromo = $promo->hitungDiskon($itemsEligible);
            $subtotalEligible = array_sum(array_column($itemsEligible, 'subtotal'));

            foreach ($itemsEligible as $item) {
                $bagian = $subtotalEligible > 0
                    ? (int) round($totalDiskonPromo * $item['subtotal'] / $subtotalEligible)
                    : 0;
                $diskonPromoById[$item['id_item']] = $bagian;
            }
            if ($itemsEligible) {
                $lastId = $itemsEligible[count($itemsEligible) - 1]['id_item'];
                $diskonPromoById[$lastId] = max(
                    0,
                    $totalDiskonPromo - (array_sum($diskonPromoById) - $diskonPromoById[$lastId])
                );
            }
        }

        foreach ($idLayanans as $i => $idLayanan) {
            $harga = (float) ($hargas[$i] ?? 0);
            $diskon = (float) ($diskons[$i] ?? 0);

            if ($promo) {
                $diskon = (float) ($diskonPromoById[(int) $idLayanan] ?? 0);
            }

            $diskon = min($diskon, $harga);
            $subtotal = max(0, $harga - $diskon);

            DetailBooking::create([
                'id_booking' => $booking->id_booking,
                'id_layanan' => $idLayanan,
                'harga' => $harga,
                'diskon' => $diskon,
                'subtotal' => $subtotal,
                'id_promo' => $idPromo,
            ]);
        }

        DB::table('log_booking')->insert([
            'id_pelanggan' => $idPelanggan,
            'tanggal' => $request->tanggal,
        ]);

        $pelanggan = Pelanggan::where('id_user', auth()->id())->first();
        if ($pelanggan) {
            $pelanggan->increment('total_booking');
        }

        buatNotif(auth()->id(), 'Booking Baru', 'Booking treatment berhasil dibuat', 'Booking', route('pelanggan.booking'));

        if ($booking->id_karyawan && $booking->status === 'dikonfirmasi') {
            buatNotif($booking->id_karyawan, 'Jadwal Treatment Baru', 'Booking baru oleh ' . auth()->user()->nama . ' pada ' . $booking->tanggal . ' ' . $booking->jam . '.', 'Booking', url('/beautycian/jadwal-treatment'));
        }

        ActivityLogger::log('Menambahkan', auth()->user()->nama . ' membuat booking baru', 'Booking', $booking->id_booking);

        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            buatNotif($admin->id, 'Booking Baru', 'Booking baru oleh ' . auth()->user()->nama, 'Booking', url('/admin/dashboard'));
        }

        return redirect()->route('pelanggan.booking.pembayaran', $booking->id_booking)->with('success', 'Booking berhasil dibuat! Silakan lanjutkan ke pembayaran.');
    }

    public function pembayaran($id)
    {
        $booking = Booking::with(['detail.layanan', 'karyawan'])
            ->where('id_booking', $id)
            ->where('id_pelanggan', $this->resolveIdPelanggan())
            ->firstOrFail();

        if ($booking->status_pembayaran === 'menunggu' && $booking->transaksi) {
            return redirect()->route('pelanggan.pembayaran.show', $booking->transaksi->id_transaksi);
        }

        if (!in_array($booking->status_pembayaran, ['belum', 'menunggu'])) {
            return redirect()->route('pelanggan.booking.detail', $booking->id_booking);
        }

        $total = (int) $booking->detail->sum('subtotal');
        $dpAmount = (int) round($total / 2);
        $sisa = max(0, $total - $dpAmount);

        $banks = CheckoutController::getBanksForTransfer();
        $bankTujuan = CheckoutController::bankTujuan();

        $pelanggan = Pelanggan::find($this->resolveIdPelanggan());
        $saldo = $pelanggan ? (float) $pelanggan->saldo : 0;

        return view('pelanggan.booking.pembayaran', compact('booking', 'total', 'dpAmount', 'sisa', 'banks', 'bankTujuan', 'saldo'));
    }

    public function bayar(Request $request, $id)
    {
        $booking = Booking::with(['detail.layanan', 'karyawan'])
            ->where('id_booking', $id)
            ->where('id_pelanggan', $this->resolveIdPelanggan())
            ->firstOrFail();

        if ($booking->status_pembayaran !== 'belum') {
            if ($booking->status_pembayaran === 'menunggu' && $booking->transaksi) {
                return redirect()->route('pelanggan.pembayaran.show', $booking->transaksi->id_transaksi);
            }
            return redirect()->route('pelanggan.booking.detail', $booking->id_booking);
        }

        $request->validate([
            'tipe' => 'required|in:dp,full',
            'metode' => 'required|in:QRIS,Transfer,Saldo',
            'provider' => 'required|string|max:50',
            'bank_id' => 'nullable|required_if:metode,Transfer|integer|exists:banks,id',
            'pakai_saldo' => 'nullable|numeric|min:0',
        ]);

        $providers = [
            'QRIS' => ['QRIS'],
            'Transfer' => \App\Models\Bank::active()->transfer()->pluck('nama_bank')->toArray(),
            'Saldo' => ['Saldo Akun'],
        ];
        abort_unless(in_array($request->provider, $providers[$request->metode]), 422);

        $bank = null;
        if ($request->metode === 'Transfer' && $request->bank_id) {
            $bank = \App\Models\Bank::find($request->bank_id);
        }

        $user = auth()->user();
        $pelanggan = Pelanggan::find($this->resolveIdPelanggan());
        if (!$pelanggan) {
            return back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $total = (int) $booking->detail->sum('subtotal');
        $dpAmount = (int) round($total / 2);
        $amount = $request->tipe === 'dp' ? $dpAmount : $total;
        if ($amount <= 0) {
            return back()->with('error', 'Nominal pembayaran tidak valid.');
        }

        $subtotalLayanan = (int) $booking->detail->sum('harga');
        $diskonLayanan = (int) $booking->detail->sum('diskon');

        return DB::transaction(function () use ($request, $user, $pelanggan, $booking, $amount, $subtotalLayanan, $diskonLayanan, $bank) {
            $pakaiSaldo = (float) $request->input('pakai_saldo', 0);
            $bayarSaldoPenuh = $request->metode === 'Saldo';

            if ($bayarSaldoPenuh) {
                $saldoTersedia = (float) $pelanggan->saldo;
                if ($saldoTersedia < (float) $amount) {
                    return back()->with('error', 'Saldo akun Anda Rp ' . number_format($saldoTersedia, 0, ',', '.') . ' tidak cukup untuk total Rp ' . number_format((float) $amount, 0, ',', '.') . '. Silakan pilih metode kedua untuk sisa pembayaran.');
                }
                $pakaiSaldo = (float) $amount;
            }

            $lastId = Transaksi::max('id_transaksi') + 1;
            $noInvoice = 'INV-' . date('Ymd') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

            $transaksi = Transaksi::create([
                'id_booking' => $booking->id_booking,
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'id_user' => $user->id,
                'sumber' => 'online',
                'jenis_transaksi' => 'Booking',
                'no_invoice' => $noInvoice,
                'tanggal' => now()->toDateString(),
                'subtotal' => $subtotalLayanan,
                'diskon' => $diskonLayanan,
                'pajak' => 0,
                'total' => $amount,
                'metode_byr' => $request->provider,
                'dibayar' => 0,
                'kembali' => 0,
                'catatan' => 'Bayar ' . ($request->tipe === 'dp' ? 'DP 50%' : 'Lunas') . ' booking #BK' . str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT),
                'status' => 'Menunggu Pembayaran',
            ]);

            if ($pakaiSaldo > 0) {
                $saldoService = new SaldoAkunService();
                $saldoResult = $saldoService->prosesCheckout(
                    $pelanggan->id_pelanggan,
                    $amount,
                    $pakaiSaldo,
                    $transaksi->id_transaksi,
                    null,
                    false
                );
                $transaksi->update(['saldo_terpakai' => $saldoResult['pakai_saldo']]);
                $amount = $saldoResult['sisa_bayar'];
            }

            foreach ($booking->detail as $d) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'jenis' => 'Layanan',
                    'id_item' => $d->id_layanan,
                    'nm_item' => $d->layanan->nm_layanan ?? 'Layanan',
                    'qty' => 1,
                    'harga' => $d->harga,
                    'diskon' => $d->diskon ?? 0,
                    'subtotal' => $d->subtotal ?? 0,
                ]);
            }

            $transaksiStatus = 'Menunggu Pembayaran';

            if ($bayarSaldoPenuh) {
                $now = now();
                Pembayaran::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'metode' => 'Saldo',
                    'provider' => 'Saldo Akun',
                    'kode_pembayaran' => 'SLD-' . str_pad((string) $transaksi->id_transaksi, 8, '0', STR_PAD_LEFT),
                    'nominal' => 0,
                    'status' => 'Dibayar',
                    'expires_at' => $now,
                    'paid_at' => $now,
                    'no_referensi' => 'SALDO-' . $transaksi->id_transaksi,
                ]);
                $transaksiStatus = 'Sedang Diproses';
            } else {
                $expiresAt = $request->metode === 'QRIS'
                    ? now()->addMinutes(3)
                    : now()->addMinutes(15);

                $pembayaranData = [
                    'id_transaksi' => $transaksi->id_transaksi,
                    'metode' => $request->metode,
                    'provider' => $request->provider,
                    'kode_pembayaran' => CheckoutController::generateKodePembayaran($request->metode, $transaksi->id_transaksi, $bank),
                    'nominal' => $amount,
                    'status' => 'Menunggu',
                    'expires_at' => $expiresAt,
                ];

                if ($bank) {
                    $pembayaranData['bank_id'] = $bank->id;
                    $pembayaranData['no_rekening_tujuan'] = $bank->no_rekening;
                    $pembayaranData['atas_nama_tujuan'] = $bank->atas_nama;
                }

                Pembayaran::create($pembayaranData);
            }

            $transaksi->update(['status' => $transaksiStatus]);

            $booking->update([
                'status_pembayaran' => 'menunggu',
                'tipe_pembayaran' => $request->tipe,
            ]);

            $tipeLabel = $request->tipe === 'dp' ? 'DP 50%' : 'lunas';
            ActivityLogger::log('Menambahkan', $user->nama . ' membayar ' . $tipeLabel . ' booking ' . $noInvoice . ' via ' . $request->provider, 'Transaksi', $transaksi->id_transaksi);

            $targetPesanan = route('pelanggan.pembayaran.show', $transaksi->id_transaksi);

            if ($bayarSaldoPenuh) {
                buatNotif($user->id, 'Booking Dibayar', 'Pembayaran ' . $noInvoice . ' dibayar penuh dengan saldo akun. Menunggu verifikasi kasir.', 'Transaksi', $targetPesanan);
            } else {
                buatNotif($user->id, 'Booking Dibuat', 'Booking ' . $noInvoice . ' berhasil dibuat. Silakan selesaikan pembayaran.', 'Transaksi', $targetPesanan);
            }

            $petugas = \App\Models\User::whereIn('role', ['kasir', 'admin'])->get();
            foreach ($petugas as $petugasUser) {
                $judulPetugas = $bayarSaldoPenuh ? 'Pembayaran Booking (Saldo Akun)' : 'Pembayaran Booking Baru';
                $isiPetugas = $bayarSaldoPenuh
                    ? $user->nama . ' membayar booking ' . $noInvoice . ' penuh dengan saldo akun. Segera verifikasi.'
                    : $user->nama . ' membayar booking ' . $noInvoice . ' menunggu pembayaran (' . $request->provider . ').';
                buatNotif($petugasUser->id, $judulPetugas, $isiPetugas, 'Transaksi', route('kasir.pembayaran.pesanan-online'));
            }

            return redirect($targetPesanan);
        });
    }

    public function show($id)
    {
        $booking = Booking::with(['detail.layanan', 'karyawan', 'transaksi.pembayaran'])
            ->where('id_booking', $id)
            ->where('id_pelanggan', $this->resolveIdPelanggan())
            ->firstOrFail();

        return view('pelanggan.booking.detail', compact('booking'));
    }

    public function pdf($id)
    {
        $booking = Booking::with(['detail.layanan', 'karyawan'])
            ->where('id_booking', $id)
            ->where('id_pelanggan', $this->resolveIdPelanggan())
            ->firstOrFail();

        $pdf = Pdf::loadView('pelanggan.booking.pdf', compact('booking'));
        return $pdf->download('Detail-Booking-BK' . str_pad($booking->id_booking, 3, '0', STR_PAD_LEFT) . '.pdf');
    }

    public function edit($id)
    {
        $booking = Booking::where('id_booking', $id)
            ->where('id_pelanggan', $this->resolveIdPelanggan())
            ->firstOrFail();

        $detail = DetailBooking::where('id_booking', $booking->id_booking)->first();
        $layanans = Layanan::where('status', 'Tersedia')->get();
        $karyawans = Karyawan::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'beautycian'))
            ->where('status', 'Tersedia')
            ->orderBy('id_user')
            ->get();

        $karyawanSibukIds = Booking::where('status', 'diproses')
            ->whereNotNull('id_karyawan')
            ->distinct()
            ->pluck('id_karyawan')
            ->toArray();

        $diskonMember = 0;
        $user = auth()->user();
        $pelanggan = Pelanggan::dariUser($user);
        if ($pelanggan && $pelanggan->id_member) {
            $member = $pelanggan->membershipAktif();
            if ($member) {
                $diskonMember = (int) $member->diskon;
            }
        }

        $slotJam = BookingSlot::slotJam();
        $bookedJamByKaryawan = BookingSlot::blokirJamKaryawan($booking->tanggal, $booking->id_booking);
        $sedangMelayaniDetail = BookingSlot::sedangMelayaniDetail();

        return view('pelanggan.booking.edit', compact('booking', 'detail', 'layanans', 'karyawans', 'karyawanSibukIds', 'diskonMember', 'slotJam', 'bookedJamByKaryawan', 'sedangMelayaniDetail'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_layanan' => 'required|integer|exists:layanan,id_layanan',
            'id_karyawan' => 'required|integer',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'harga' => 'required|numeric',
            'diskon' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $booking = Booking::where('id_booking', $id)
            ->where('id_pelanggan', $this->resolveIdPelanggan())
            ->firstOrFail();

        $jam = BookingSlot::normalJam($request->jam);

        if (Booking::where('id_karyawan', $request->id_karyawan)->where('status', 'diproses')->exists()) {
            return redirect()->back()->withErrors('Terapis sedang melayani pelanggan lain. Silakan pilih terapis lain yang tersedia.');
        }

        if (!BookingSlot::validJamSlot($jam)) {
            return redirect()->back()->withInput()->withErrors(['jam' => 'Jam harus berada dalam jam operasional toko (' . BookingSlot::formatJamIndo(BookingSlot::jamBuka()) . ' - ' . BookingSlot::formatJamIndo(BookingSlot::jamTutup()) . ').']);
        }

        if ($request->tanggal < now()->toDateString()) {
            return redirect()->back()->withInput()->withErrors(['tanggal' => 'Tanggal booking tidak boleh di masa lalu.']);
        }

        $durasi = (int) Layanan::where('id_layanan', $request->id_layanan)->value('durasi');
        if (BookingSlot::jamBentrok($request->id_karyawan, $request->tanggal, $jam, $booking->id_booking, $durasi)) {
            return redirect()->back()->withInput()->withErrors(['jam' => 'Jam tersebut sudah dibooking untuk terapis yang dipilih (sudah memperhitungkan durasi layanan). Silakan pilih jam lain.']);
        }

        $karyawanLama = $booking->id_karyawan;
        $statusBooking = $booking->status;

        $booking->update([
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'jam' => $jam,
            'catatan' => $request->catatan ?? '',
        ]);

        $diskon = (float) ($request->diskon ?? 0);
        $harga = (float) $request->harga;
        $subtotal = $harga - $diskon;

        DetailBooking::updateOrCreate(
            ['id_booking' => $booking->id_booking],
            [
                'id_layanan' => $request->id_layanan,
                'harga' => $harga,
                'diskon' => $diskon,
                'subtotal' => $subtotal,
            ]
        );

        buatNotif(auth()->id(), 'Booking Diperbarui', 'Booking treatment berhasil diperbarui', 'Booking', route('pelanggan.booking'));

        buatNotifRole('kasir', 'Booking Diperbarui', auth()->user()->nama . ' mengubah booking #' . $id . ' menjadi ' . $request->tanggal . ' ' . $request->jam . '.', 'Booking', route('kasir.reservasi.index'));

        if ($karyawanLama !== $request->id_karyawan && $statusBooking === 'dikonfirmasi') {
            if ($request->id_karyawan) {
                buatNotif($request->id_karyawan, 'Jadwal Treatment Baru', 'Booking baru oleh ' . auth()->user()->nama . ' pada ' . $request->tanggal . ' ' . $request->jam . '.', 'Booking', url('/beautycian/jadwal-treatment'));
            }

            if ($karyawanLama) {
                buatNotif($karyawanLama, 'Booking Dipindahkan', 'Booking ' . auth()->user()->nama . ' dipindahkan ke terapis lain.', 'Booking', url('/beautycian/jadwal-treatment'));
            }
        }

        ActivityLogger::log('Mengubah', auth()->user()->nama . ' mengubah booking #' . $id, 'Booking', $id);

        return redirect()->route('pelanggan.booking')->with('success', 'Booking berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $booking = Booking::where('id_booking', $id)
            ->where('id_pelanggan', $this->resolveIdPelanggan())
            ->firstOrFail();

        if ($booking->status !== 'menunggu') {
            return redirect()->route('pelanggan.booking')->with('error', 'Booking hanya dapat dibatalkan saat statusnya masih menunggu.');
        }

        $karyawanId = $booking->id_karyawan;

        $booking->update(['status' => 'dibatalkan']);

        ActivityLogger::log('Membatalkan', auth()->user()->nama . ' membatalkan booking #' . $id, 'Booking', $id);

        buatNotif(auth()->id(), 'Booking Dibatalkan', 'Booking treatment berhasil dibatalkan', 'Booking', route('pelanggan.booking'));

        buatNotifRole('kasir', 'Booking Dibatalkan', auth()->user()->nama . ' membatalkan booking #' . $id . '.', 'Booking', route('kasir.reservasi.index'));

        if ($karyawanId) {
            buatNotif($karyawanId, 'Booking Dibatalkan', auth()->user()->nama . ' membatalkan booking #' . $id . '.', 'Booking', url('/beautycian/jadwal-treatment'));
        }

        return redirect()->route('pelanggan.booking')->with('success', 'Booking berhasil dibatalkan!');
    }

    private function hasActiveBooking()
    {
        $idPelanggan = $this->resolveIdPelanggan();

        return Booking::where('id_pelanggan', $idPelanggan)
            ->whereIn('status', ['menunggu', 'dikonfirmasi', 'diproses'])
            ->whereDate('tanggal', now()->toDateString())
            ->exists();
    }

    private function resolveIdPelanggan()
    {
        $user = auth()->user();
        if ($user->dataPelanggan) {
            return $user->dataPelanggan->id_pelanggan;
        }
        return Pelanggan::firstOrCreate(
            ['id_user' => $user->id],
            ['nm_pelanggan' => $user->nama, 'email' => $user->email, 'no_hp' => $user->no_hp ?? '']
        )->id_pelanggan;
    }
}
