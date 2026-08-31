<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\RiwayatAktivitas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function getNotif()
    {
        $user = Auth::user();
        $notif = Notifikasi::with(['user', 'aktor'])
            ->forUser($user->id)
            ->latest()
            ->get();

        $unreadCount = Notifikasi::forUser($user->id)->unread()->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notif->map(function ($n) use ($user) {
                return [
                    'id' => $n->id_notif,
                    'judul' => $n->judul,
                    'isi' => $n->isi,
                    'type' => $n->type,
                    'url' => $n->url,
                    'target' => $this->notifTarget($user->role, $n->type) ?? $n->url,
                    'waktu' => $n->created_at ? $n->created_at->diffForHumans() : '',
                    'status' => $n->status,
                    'aktor_foto' => $n->aktor?->foto,
                    'aktor_nama' => $n->aktor?->nama,
                ];
            }),
        ]);
    }

    private function notifTarget($role, $type)
    {
        $map = [
            'Transaksi' => [
                'admin' => 'admin.transaksi.index',
                'kasir' => 'kasir.riwayat-transaksi.index',
                'beautycian' => 'beautycian.jadwal-treatment.index',
                'pelanggan' => 'pelanggan.pesanan.index',
            ],
            'Booking' => [
                'admin' => 'admin.reservasi.index',
                'kasir' => 'kasir.reservasi.index',
                'beautycian' => 'beautycian.jadwal-treatment.index',
                'pelanggan' => 'pelanggan.booking',
            ],
            'Stok' => [
                'admin' => 'admin.stok.index',
                'kasir' => 'kasir.transaksi.index',
                'beautycian' => 'beautycian.dashboard',
                'pelanggan' => 'pelanggan.produk',
            ],
            'Promo' => [
                'admin' => 'admin.promo.index',
                'kasir' => 'kasir.dashboard',
                'beautycian' => 'beautycian.dashboard',
                'pelanggan' => 'pelanggan.promo',
            ],
            'Membership' => [
                'admin' => 'admin.membership.index',
                'kasir' => 'kasir.dashboard',
                'beautycian' => 'beautycian.dashboard',
                'pelanggan' => 'pelanggan.membership',
            ],
            'Registrasi' => [
                'admin' => 'admin.user.index',
                'kasir' => 'kasir.dashboard',
                'beautycian' => 'beautycian.dashboard',
                'pelanggan' => 'dashboard',
            ],
            'Laporan' => [
                'admin' => 'admin.laporan-masalah.index',
                'kasir' => 'kasir.laporan-masalah.index',
                'beautycian' => 'beautycian.laporan-masalah.index',
                'pelanggan' => 'pelanggan.laporan-masalah.index',
            ],
        ];

        if (!isset($map[$type][$role])) {
            return null;
        }

        return route($map[$type][$role]);
    }

    public function popupAktivitas(Request $request)
    {
        $user = Auth::user();
        $since = $request->input('since');
        $now = now()->toDateTimeString();
        $items = [];

        if ($since) {
            // Normalisasi ke format DATETIME app timezone agar cocok dengan kolom created_at di MySQL
            $since = Carbon::parse($since)->toDateTimeString();

            // Popup realtime untuk admin: perubahan data oleh kasir/beautycian/pelanggan
            if ($user->role === 'admin') {
                // Popup notifikasi dari sistem (mis. registrasi pelanggan baru / pesan kontak,
                // aktor NULL) dan aksi pelanggan, agar admin langsung tahu ada yang menunggu persetujuan
                $notifBaru = Notifikasi::with('aktor')
                    ->where('id_user', $user->id)
                    ->where('created_at', '>', $since)
                    ->where(function ($q) {
                        $q->whereNull('aktor_id')
                            ->orWhereHas('aktor', fn ($a) => $a->where('role', 'pelanggan'))
                            ->orWhere(function ($q2) {
                                $q2->where('type', 'Laporan')
                                    ->whereHas('aktor', fn ($a) => $a->whereIn('role', ['kasir', 'beautycian']));
                            });
                    })
                    ->latest()
                    ->take(5)
                    ->get();

                // Kumpulan waktu notif aksi pelanggan, dipakai untuk menyaring
                // RiwayatAktivitas duplikat (1 aksi bisa tercatat di kedua tempat)
                $waktuNotifPelanggan = [];
                foreach ($notifBaru as $n) {
                    if ($n->aktor && $n->aktor->role === 'pelanggan' && $n->created_at) {
                        $waktuNotifPelanggan[] = Carbon::parse($n->created_at);
                    }
                }

                $aktivitas = RiwayatAktivitas::with('user')
                    ->whereIn('role', ['kasir', 'beautycian', 'pelanggan'])
                    ->where('created_at', '>', $since)
                    ->orderByDesc('created_at')
                    ->take(5)
                    ->get();

                foreach ($aktivitas as $a) {
                    // Laporan masalah muncul lewat popup Notifikasi (tipe Laporan),
                    // lewati riwayatnya agar tidak muncul 2 popup untuk 1 laporan
                    if ($a->tipe === 'Laporan') {
                        continue;
                    }

                    // Aksi pelanggan yang sama sudah muncul lewat popup Notifikasi,
                    // lewati riwayat duplikat dalam rentang 30 detik (hindari 2 popup utk 1 perubahan)
                    if ($a->role === 'pelanggan' && $a->created_at && $waktuNotifPelanggan) {
                        $waktuRiwayat = Carbon::parse($a->created_at);
                        foreach ($waktuNotifPelanggan as $w) {
                            if (abs($waktuRiwayat->diffInSeconds($w)) <= 30) {
                                continue 2;
                            }
                        }
                    }

                    $pelaku = ucfirst($a->role).' '.($a->user?->nama ?? '');
                    $items[] = [
                        'message' => trim($pelaku).': '.$a->deskripsi,
                        'type' => 'success',
                    ];
                }

                foreach ($notifBaru as $n) {
                    $items[] = [
                        'id_notif' => $n->id_notif,
                        'message' => $n->judul.': '.$n->isi,
                        'type' => 'success',
                    ];
                }
            } else {
                // Role lain: tampilkan notifikasi dari AKTOR LAIN saja
                // (aksi sendiri tidak perlu muncul sebagai toast, tetap tercatat di bell & aktivitas admin)
                // Notifikasi sistem dari cron (aktor_id NULL) tetap popup agar info penting tidak terlewat
                $notif = Notifikasi::with('aktor')
                    ->where('id_user', $user->id)
                    ->where('created_at', '>', $since)
                    ->where(function ($q) use ($user) {
                        $q->where('aktor_id', '!=', $user->id)
                            ->orWhereNull('aktor_id');
                    })
                    ->latest()
                    ->take(5)
                    ->get();

                foreach ($notif as $n) {
                    $items[] = [
                        'message' => $n->judul.': '.$n->isi,
                        'type' => 'info',
                    ];
                }
            }

            // Dedup: hanya simpan notifikasi unik per id_notif (atau fallback message+type)
            $seen = [];
            $items = array_values(array_filter($items, function ($item) use (&$seen) {
                $key = $item['message'] ?? '';
                if (isset($item['id_notif'])) {
                    $key = 'notif_'.$item['id_notif'];
                }
                if (isset($seen[$key])) {
                    return false;
                }
                $seen[$key] = true;
                return true;
            }));
        }

        return response()->json([
            'now' => $now,
            'items' => $items,
        ]);
    }

    public function markRead($role, $id)
    {
        if ($role !== Auth::user()->role) {
            abort(403);
        }

        $notif = Notifikasi::where('id_notif', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        $notif->update([
            'status' => 1,
            'read_at' => now(),
        ]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        $dashboard = [
            'admin' => 'admin.dashboard',
            'kasir' => 'kasir.dashboard',
            'beautycian' => 'beautycian.dashboard',
            'pelanggan' => 'dashboard',
        ];

        return redirect(
            $this->notifTarget($role, $notif->type)
            ?? $notif->url
            ?? route($dashboard[$role] ?? 'dashboard')
        );
    }

    public function markAllRead($role)
    {
        if ($role !== Auth::user()->role) {
            abort(403);
        }

        Notifikasi::forUser(Auth::id())->unread()->update([
            'status' => 1,
            'read_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Semua notifikasi telah dibaca']);
    }
}
