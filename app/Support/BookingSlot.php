<?php

namespace App\Support;

use App\Models\Booking;
use App\Models\Pengaturan;
use Carbon\Carbon;

class BookingSlot
{
    public static function jamBuka()
    {
        $p = Pengaturan::first();
        return $p && $p->jam_buka ? substr($p->jam_buka, 0, 5) : '08:00';
    }

    public static function jamTutup()
    {
        $p = Pengaturan::first();
        return $p && $p->jam_tutup ? substr($p->jam_tutup, 0, 5) : '20:00';
    }

    /** Daftar slot jam (format H:i) dari jam buka s.d. jam tutup, interval 1 jam */
    public static function slotJam()
    {
        $buka = (int) substr(self::jamBuka(), 0, 2);
        $tutup = (int) substr(self::jamTutup(), 0, 2);
        $slots = [];
        for ($h = $buka; $h < $tutup; $h++) {
            $slots[] = date('H:i', strtotime("$h:00"));
        }
        return $slots;
    }

    /** Format Indonesia: "13:00" => "13.00" */
    public static function formatJamIndo($jam)
    {
        return str_replace(':', '.', substr($jam, 0, 5));
    }

    /** Normalisasi jam ke H:i:00 (fix bug bentrok H:i vs H:i:s) */
    public static function normalJam($jam)
    {
        return date('H:i', strtotime(substr($jam, 0, 5)));
    }

    /** Total durasi (menit) layanan pada sebuah booking */
    public static function durasiBooking($booking)
    {
        $total = 0;
        foreach ($booking->detail ?? [] as $d) {
            if ($d->layanan) {
                $total += (int) $d->layanan->durasi;
            }
        }
        return max(60, $total);
    }

    public static function validJamSlot($jam)
    {
        return in_array(substr($jam, 0, 5), self::slotJam());
    }

    /**
     * Mapping id_karyawan => [H:i...] slot yang terblokir (durasi-aware).
     * Booking 13.00 durasi 90 menit => blokir slot 13.00 & 14.00, 15.00 bebas.
     */
    public static function blokirJamKaryawan($tanggal, $exceptId = null)
    {
        $slots = self::slotJam();
        $bookings = Booking::with('detail.layanan')
            ->where('tanggal', $tanggal)
            ->whereIn('status', ['menunggu', 'dikonfirmasi', 'diproses'])
            ->whereNotNull('id_karyawan')
            ->when($exceptId, fn ($q) => $q->where('id_booking', '!=', $exceptId))
            ->get();

        $blocked = [];
        foreach ($bookings as $b) {
            $mulai = Carbon::parse($b->tanggal . ' ' . substr($b->jam, 0, 5));
            $selesai = $mulai->copy()->addMinutes(self::durasiBooking($b));
            foreach ($slots as $slot) {
                $s = Carbon::parse($b->tanggal . ' ' . $slot);
                if ($s->gte($mulai) && $s->lt($selesai)) {
                    $blocked[$b->id_karyawan][$slot] = true;
                }
            }
        }

        return collect($blocked)
            ->map(fn ($m) => collect(array_keys($m))->values()->all())
            ->all();
    }

    /**
     * Cek bentrok (overlap) jadwal karyawan dengan mempertimbangkan durasi.
     */
    public static function jamBentrok($idKaryawan, $tanggal, $jam, $exceptId = null, $durasi = 60)
    {
        $durasi = max(60, (int) $durasi);
        $mulai = Carbon::parse($tanggal . ' ' . substr($jam, 0, 5));
        $selesai = $mulai->copy()->addMinutes($durasi);

        $bookings = Booking::with('detail.layanan')
            ->where('id_karyawan', $idKaryawan)
            ->where('tanggal', $tanggal)
            ->whereIn('status', ['menunggu', 'dikonfirmasi', 'diproses'])
            ->when($exceptId, fn ($q) => $q->where('id_booking', '!=', $exceptId))
            ->get();

        foreach ($bookings as $b) {
            $bMulai = Carbon::parse($b->tanggal . ' ' . substr($b->jam, 0, 5));
            $bSelesai = $bMulai->copy()->addMinutes(self::durasiBooking($b));
            if ($mulai->lt($bSelesai) && $bMulai->lt($selesai)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Info beautycian yang sedang melayani (status diproses hari ini).
     * id_karyawan => ['pelanggan' => ..., 'jam' => ..., 'id_booking' => ...]
     */
    public static function sedangMelayaniDetail()
    {
        return Booking::with('pelanggan')
            ->whereDate('tanggal', now()->toDateString())
            ->where('status', 'diproses')
            ->whereNotNull('id_karyawan')
            ->get()
            ->mapWithKeys(function ($b) {
                return [$b->id_karyawan => [
                    'pelanggan' => $b->pelanggan->nm_pelanggan ?? 'Pelanggan',
                    'jam' => substr($b->jam, 0, 5),
                    'id_booking' => $b->id_booking,
                ]];
            })
            ->all();
    }

    /** Array id karyawan yang sedang melayani (untuk kompatibilitas view lama) */
    public static function sedangMelayani()
    {
        return array_keys(self::sedangMelayaniDetail());
    }
}
