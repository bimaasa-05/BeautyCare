<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Support\BookingSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RealtimeController extends Controller
{
    public function bookingStatus(Request $request)
    {
        $ids = collect(explode(',', (string) $request->query('ids', '')))
            ->filter(fn($v) => ctype_digit($v))
            ->map(fn($v) => (int) $v)
            ->unique()
            ->values();

        $scope = $request->query('scope', 'umum');

        $items = [];
        if ($ids->isNotEmpty()) {
            $query = Booking::with(['detail.layanan'])->whereIn('id_booking', $ids);

            if ($scope === 'beautycian') {
                $query->where('id_karyawan', auth()->id());
            } elseif ($scope === 'pelanggan') {
                $query->where('id_pelanggan', auth()->user()->dataPelanggan?->id_pelanggan ?? -1);
            }

            foreach ($query->get() as $b) {
                $durasiMenit = BookingSlot::durasiBooking($b);
                $mulaiAktual = $b->jam_mulai_aktual ? Carbon::parse($b->jam_mulai_aktual) : null;
                $estimasiSelesai = ($mulaiAktual ?? Carbon::parse($b->tanggal . ' ' . substr($b->jam, 0, 5)))
                    ->copy()
                    ->addMinutes($durasiMenit);

                $items[$b->id_booking] = [
                    'status' => $b->status,
                    'label' => ucfirst($b->status),
                    'durasi_menit' => $durasiMenit,
                    'jam_mulai_aktual' => $b->jam_mulai_aktual,
                    'jam_selesai_aktual' => $b->jam_selesai_aktual,
                    'estimasi_selesai' => $estimasiSelesai->format('Y-m-d H:i:s'),
                ];
            }
        }

        $columns = null;
        if ($scope === 'beautycian') {
            $today = now()->toDateString();
            $cols = Booking::where('id_karyawan', auth()->id())
                ->whereDate('tanggal', $today)
                ->whereIn('status', ['dikonfirmasi', 'diproses', 'selesai'])
                ->orderBy('jam')
                ->get(['id_booking', 'status']);

            $columns = [
                'dikonfirmasi' => $cols->where('status', 'dikonfirmasi')->pluck('id_booking')->values(),
                'diproses' => $cols->where('status', 'diproses')->pluck('id_booking')->values(),
                'selesai' => $cols->where('status', 'selesai')->pluck('id_booking')->values(),
            ];
        }

        return response()->json(['items' => $items, 'columns' => $columns]);
    }
}