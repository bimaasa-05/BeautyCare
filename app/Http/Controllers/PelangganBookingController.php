<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Layanan;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Membership;
use App\Models\PromoKlaim;
use App\Helpers\ActivityLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganBookingController extends Controller
{
    public function index(Request $request)
    {
        $id_pelanggan = $this->resolveIdPelanggan();

        $bookings = Booking::with(['detail.layanan', 'karyawan'])
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

        return view('pelanggan.booking.create', compact('layanans', 'karyawans', 'diskonMember', 'claimedPromos'));
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
                fn ($idLayanan) => $promo->itemEligible('Layanan', $idLayanan)
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
            'jam' => $request->jam,
            'status' => 'menunggu',
            'catatan' => $request->catatan ?? '',
        ]);

        $idLayanans = $request->id_layanan;
        $hargas = $request->harga;
        $diskons = $request->diskon ?? [];

        foreach ($idLayanans as $i => $idLayanan) {
            $harga = (float) ($hargas[$i] ?? 0);
            $diskon = (float) ($diskons[$i] ?? 0);

            if ($promo) {
                $diskon = $promo->itemEligible('Layanan', $idLayanan)
                    ? (float) $promo->hitungDiskon([['jenis' => 'Layanan', 'id_item' => $idLayanan, 'subtotal' => $harga]])
                    : 0;
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

        return redirect()->route('pelanggan.booking')->with('success', 'Booking berhasil dibuat!');
    }

    public function show($id)
    {
        $booking = Booking::with(['detail.layanan', 'karyawan'])
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

        $diskonMember = 0;
        $user = auth()->user();
        $pelanggan = Pelanggan::dariUser($user);
        if ($pelanggan && $pelanggan->id_member) {
            $member = $pelanggan->membershipAktif();
            if ($member) {
                $diskonMember = (int) $member->diskon;
            }
        }

        return view('pelanggan.booking.edit', compact('booking', 'detail', 'layanans', 'karyawans', 'diskonMember'));
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

        $karyawanLama = $booking->id_karyawan;
        $statusBooking = $booking->status;

        $booking->update([
            'id_karyawan' => $request->id_karyawan,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
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
