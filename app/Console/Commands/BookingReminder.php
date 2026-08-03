<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Promo;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BookingReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengirim reminder booking (H-1 & H-2 jam), membatalkan booking yang lewat, dan menutup promo yang sudah berakhir';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->format('Y-m-d');
        $tomorrow = now()->addDay()->format('Y-m-d');

        // 1. Reminder H-1 (jadwal besok)
        Booking::where('tanggal', $tomorrow)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->where('reminder_h1', false)
            ->get()
            ->each(function ($booking) {
                $booking->update(['reminder_h1' => true]);
                buatNotif(
                    $booking->id_pelanggan,
                    'Reminder: Treatment Besok',
                    'Halo! Anda memiliki jadwal treatment besok, ' . Carbon::parse($booking->tanggal)->format('d M Y') . ' pukul ' . $booking->jam . '. Jangan lupa datang ya!',
                    'Booking',
                    route('pelanggan.booking')
                );
            });

        // 2. Reminder H-2 jam (jadwal hari ini dalam 2 jam ke depan)
        $nowJam = now()->format('H:i:s');
        $plus2Jam = now()->addMinutes(120)->format('H:i:s');
        Booking::where('tanggal', $today)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->where('reminder_jam', false)
            ->whereBetween('jam', [$nowJam, $plus2Jam])
            ->get()
            ->each(function ($booking) {
                $booking->update(['reminder_jam' => true]);
                buatNotif(
                    $booking->id_pelanggan,
                    'Jadwal Treatment dalam 2 Jam',
                    'Jadwal treatment Anda hari ini pukul ' . $booking->jam . ' sudah dekat. Mohon bersiap ya!',
                    'Booking',
                    route('pelanggan.booking')
                );
            });

        // 3. Auto-batal booking yang sudah lewat & masih menunggu
        $dibatalkan = Booking::where('tanggal', '<', $today)
            ->where('status', 'menunggu')
            ->get()
            ->each(function ($booking) {
                $booking->update(['status' => 'dibatalkan']);
                buatNotif(
                    $booking->id_pelanggan,
                    'Booking Dibatalkan Otomatis',
                    'Booking Anda tanggal ' . Carbon::parse($booking->tanggal)->format('d M Y') . ' pukul ' . $booking->jam . ' dibatalkan karena tidak dikonfirmasi.',
                    'Booking',
                    route('pelanggan.booking')
                );
            })->count();

        // 4. Tutup promo yang sudah berakhir
        $promoBerakhir = Promo::where('status', 'Tersedia')
            ->where('selesai', '<', $today)
            ->update(['status' => 'Berakhir']);

        $this->info("Reminder H-1 & H-2 jam dikirim. {$dibatalkan} booking dibatalkan. {$promoBerakhir} promo ditandai Berakhir.");
    }
}
