<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function getNotif()
    {
        $user = Auth::user();
        $notif = Notifikasi::forUser($user->id)
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
                ];
            }),
        ]);
    }

    public function markRead($id)
    {
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

        return redirect($notif->url ?? '/');
    }

    public function markAllRead()
    {
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
