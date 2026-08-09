<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class CekKeterlambatanTreatment extends Command
{
    protected $signature = 'treatment:cek-keterlambatan';

    protected $description = 'Kirim notifikasi keterlambatan untuk booking treatment yang sudah lewat jadwal';

    public function handle(): int
    {
        $today = now()->toDateString();

        $bookings = Booking::with('pelanggan')
            ->where('tanggal', $today)
            ->whereIn('status', ['dikonfirmasi', 'diproses'])
            ->get();

        $count = 0;

        foreach ($bookings as $booking) {
            if ($booking->status === 'dikonfirmasi') {
                if ($booking->reminder_jam) {
                    continue;
                }

                $jamJadwal = \Carbon\Carbon::parse($booking->tanggal . ' ' . substr($booking->jam, 0, 5));
                if ($jamJadwal->gt(now())) {
                    continue;
                }

                $nama = $booking->pelanggan->nm_pelanggan ?? 'Pelanggan';
                $jamIndo = str_replace(':', '.', substr($booking->jam, 0, 5));

                $booking->update(['reminder_jam' => true]);

                buatNotif($booking->id_karyawan, 'Jadwal Terlewat', 'Booking ' . $nama . ' pukul ' . $jamIndo . ' sudah lewat dari jadwal. Segera hubungi pelanggan.', 'Booking', url('/beautycian/status-treatment'));

                if ($booking->pelanggan && $booking->pelanggan->id_user) {
                    buatNotif($booking->pelanggan->id_user, 'Jadwal Terlewat', 'Jadwal treatment Anda pukul ' . $jamIndo . ' sudah lewat. Mohon segera konfirmasi ke kasir.', 'Booking', route('pelanggan.booking'));
                }

                buatNotifRole('kasir', 'Jadwal Terlewat', 'Booking ' . $nama . ' pukul ' . $jamIndo . ' sudah lewat dan pelanggan belum check in.', 'Booking', route('kasir.checkin.index'));

                $count++;
            }

            if ($booking->status === 'diproses' && !$booking->jam_mulai_aktual) {
                $booking->update(['jam_mulai_aktual' => now()]);
            }
        }

        $this->info("{$count} booking terlambat dinotifikasi.");

        return Command::SUCCESS;
    }
}
