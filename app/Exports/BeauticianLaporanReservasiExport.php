<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BeauticianLaporanReservasiExport implements WithMultipleSheets
{
    protected int $karyawanId;
    protected string $startDate;
    protected string $endDate;

    public function __construct(int $karyawanId, string $startDate, string $endDate)
    {
        $this->karyawanId = $karyawanId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function sheets(): array
    {
        return [
            new BeauticianRingkasanSheet($this->karyawanId, $this->startDate, $this->endDate),
            new BeauticianReservasiSheet($this->karyawanId, $this->startDate, $this->endDate),
        ];
    }
}

class BeauticianRingkasanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected int $karyawanId;
    protected string $startDate;
    protected string $endDate;

    public function __construct(int $karyawanId, string $startDate, string $endDate)
    {
        $this->karyawanId = $karyawanId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $totalReservasi = Booking::where('id_karyawan', $this->karyawanId)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->count();

        $selesai = Booking::where('id_karyawan', $this->karyawanId)
            ->where('status', 'selesai')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->count();

        $totalPendapatan = DetailBooking::whereHas('booking', function ($q) {
            $q->where('id_karyawan', $this->karyawanId)
                ->where('status', 'selesai')
                ->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        })->sum('subtotal');

        $dikonfirmasi = Booking::where('id_karyawan', $this->karyawanId)
            ->where('status', 'dikonfirmasi')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->count();

        $diproses = Booking::where('id_karyawan', $this->karyawanId)
            ->where('status', 'diproses')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->count();

        $dibatalkan = Booking::where('id_karyawan', $this->karyawanId)
            ->where('status', 'dibatalkan')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->count();

        $layananTerpopuler = DetailBooking::select('id_layanan', DB::raw('COUNT(*) as total'))
            ->whereHas('booking', function ($q) {
                $q->where('id_karyawan', $this->karyawanId)
                    ->whereBetween('tanggal', [$this->startDate, $this->endDate]);
            })
            ->groupBy('id_layanan')
            ->orderBy('total', 'desc')
            ->with('layanan')
            ->first();

        return collect([
            ['Total Reservasi', (string) $totalReservasi],
            ['Selesai', (string) $selesai],
            ['Dikonfirmasi', (string) $dikonfirmasi],
            ['Diproses', (string) $diproses],
            ['Dibatalkan', (string) $dibatalkan],
            ['Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.')],
            ['Rata-rata / Transaksi', 'Rp ' . number_format($selesai > 0 ? $totalPendapatan / $selesai : 0, 0, ',', '.')],
            ['Layanan Terpopuler', $layananTerpopuler->layanan->nm_layanan ?? '-'],
            ['Periode', date('d M Y', strtotime($this->startDate)) . ' - ' . date('d M Y', strtotime($this->endDate))],
        ]);
    }

    public function headings(): array
    {
        return ['Metrik', 'Nilai'];
    }

    public function map($row): array
    {
        return [$row[0], $row[1]];
    }

    public function title(): string
    {
        return 'Ringkasan';
    }
}

class BeauticianReservasiSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected int $karyawanId;
    protected string $startDate;
    protected string $endDate;

    public function __construct(int $karyawanId, string $startDate, string $endDate)
    {
        $this->karyawanId = $karyawanId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Booking::with(['detail.layanan', 'pelanggan'])
            ->where('id_karyawan', $this->karyawanId)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return ['ID Booking', 'Pelanggan', 'Tanggal', 'Jam', 'Layanan', 'Status', 'Total Bayar'];
    }

    public function map($booking): array
    {
        $layananNames = $booking->detail->pluck('layanan.nm_layanan')->implode(', ');
        $totalBayar = $booking->detail->sum('subtotal');
        $statusLabels = [
            'dikonfirmasi' => 'Dikonfirmasi',
            'diproses'     => 'Diproses',
            'selesai'      => 'Selesai',
            'dibatalkan'   => 'Dibatalkan',
        ];

        return [
            $booking->id_booking,
            $booking->pelanggan->nm_pelanggan ?? '-',
            $booking->tanggal,
            $booking->jam,
            $layananNames,
            $statusLabels[$booking->status] ?? $booking->status,
            'Rp ' . number_format($totalBayar, 0, ',', '.'),
        ];
    }

    public function title(): string
    {
        return 'Reservasi';
    }
}