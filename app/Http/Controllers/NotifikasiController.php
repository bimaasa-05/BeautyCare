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
            ->take(10)
            ->get();

        $unreadCount = Notifikasi::forUser($user->id)->unread()->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notif->map(function ($n) {
                return [
                    'id' => $n->id_notif,
                    'judul' => $n->judul,
                    'isi' => $n->isi,
                    'type' => $n->type,
                    'url' => $n->url,
                    'waktu' => $n->created_at ? $n->created_at->diffForHumans() : '',
                    'status' => $n->status,
                    'aktor_foto' => $n->aktor?->foto,
                    'aktor_nama' => $n->aktor?->nama,
                ];
            }),
        ]);
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
                $aktivitas = RiwayatAktivitas::with('user')
                    ->whereIn('role', ['kasir', 'beautycian', 'pelanggan'])
                    ->where('created_at', '>', $since)
                    ->orderByDesc('created_at')
                    ->take(5)
                    ->get();

                foreach ($aktivitas as $a) {
                    $pelaku = ucfirst($a->role).' '.($a->user?->nama ?? '');
                    $items[] = [
                        'message' => trim($pelaku).': '.$a->deskripsi,
                        'type' => 'success',
                    ];
                }

                // Popup notifikasi dari sistem (mis. registrasi pelanggan baru / pesan kontak,
                // aktor NULL) dan aksi pelanggan, agar admin langsung tahu ada yang menunggu persetujuan
                $notifBaru = Notifikasi::with('aktor')
                    ->where('id_user', $user->id)
                    ->where('created_at', '>', $since)
                    ->where(function ($q) {
                        $q->whereNull('aktor_id')
                            ->orWhereHas('aktor', fn ($a) => $a->where('role', 'pelanggan'));
                    })
                    ->latest()
                    ->take(5)
                    ->get();

                foreach ($notifBaru as $n) {
                    $items[] = [
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

        return redirect(route('notif.index', ['role' => $role]));
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

    public function index()
    {
        $notif = Notifikasi::forUser(Auth::id())->latest()->paginate(20);

        return view('notifikasi.index', compact('notif'));
    }
}
