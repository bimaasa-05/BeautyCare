<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\DetailBooking;
use App\Exports\Traits\SheetPengaya;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

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
            new BeauticianLaporanReservasiRingkasanSheet($this->karyawanId, $this->startDate, $this->endDate),
            new BeauticianLaporanReservasiSheet($this->karyawanId, $this->startDate, $this->endDate),
        ];
    }
}

class BeauticianLaporanReservasiRingkasanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithCustomStartCell
{
    use SheetPengaya;

    protected int $karyawanId;
    protected string $startDate;
    protected string $endDate;

    public function __construct(int $karyawanId, string $startDate, string $endDate)
    {
        $this->karyawanId = $karyawanId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->judulSheet = 'LAPORAN RESERVASI BEAUTICIAN';
        $this->subtitleSheet = 'Periode ' . date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate));
        $this->barisHeaderSheet = 3;
        $this->lebarKolomSheet = [6, 32, 26];
        $this->kolomUangSheet = [3];
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
            ['no' => 1, 'label' => 'Total Reservasi', 'value' => (float) $totalReservasi],
            ['no' => 2, 'label' => 'Selesai', 'value' => (float) $selesai],
            ['no' => 3, 'label' => 'Dikonfirmasi', 'value' => (float) $dikonfirmasi],
            ['no' => 4, 'label' => 'Diproses', 'value' => (float) $diproses],
            ['no' => 5, 'label' => 'Dibatalkan', 'value' => (float) $dibatalkan],
            ['no' => 6, 'label' => 'Total Pendapatan', 'value' => (float) $totalPendapatan],
            ['no' => 7, 'label' => 'Rata-rata / Transaksi', 'value' => $selesai > 0 ? round($totalPendapatan / $selesai) : 0],
            ['no' => 8, 'label' => 'Layanan Terpopuler', 'value' => $layananTerpopuler->layanan->nm_layanan ?? '-'],
            ['no' => 9, 'label' => 'Periode', 'value' => date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate))],
        ]);
    }

    public function headings(): array
    {
        return ['No.', 'Metrik', 'Nilai'];
    }

    public function map($row): array
    {
        return [$row['no'], $row['label'], $row['value']];
    }

    public function title(): string
    {
        return 'Ringkasan';
    }
}

class BeauticianLaporanReservasiSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithCustomStartCell
{
    use SheetPengaya;

    protected int $karyawanId;
    protected string $startDate;
    protected string $endDate;

    public function __construct(int $karyawanId, string $startDate, string $endDate)
    {
        $this->karyawanId = $karyawanId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->judulSheet = 'RINCIAN RESERVASI';
        $this->subtitleSheet = 'Periode ' . date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate));
        $this->barisHeaderSheet = 3;
        $this->lebarKolomSheet = [6, 22, 28, 14, 18, 16, 14, 16];
        $this->kolomUangSheet = [8];
    }

    public function collection()
    {
        $rows = Booking::with(['detail.layanan', 'pelanggan'])
            ->where('id_karyawan', $this->karyawanId)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        $no = 0;
        foreach ($rows as $row) {
            $row->no_urut = ++$no;
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['No.', 'ID Booking', 'Pelanggan', 'Tanggal', 'Jam', 'Layanan', 'Status', 'Total Bayar'];
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
            $booking->no_urut,
            $booking->id_booking,
            $booking->pelanggan->nm_pelanggan ?? '-',
            $booking->tanggal,
            $booking->jam,
            $layananNames ?: '-',
            $statusLabels[$booking->status] ?? $booking->status,
            (float) $totalBayar,
        ];
    }

    public function title(): string
    {
        return 'Reservasi';
    }
}
