<?php

namespace App\Exports;

use App\Models\Transaksi;
use App\Models\Booking;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanExport implements WithMultipleSheets
{
    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function sheets(): array
    {
        return [
            new LaporanRingkasanSheet($this->startDate, $this->endDate),
            new LaporanTrenPendapatanSheet($this->startDate, $this->endDate),
            new LaporanTrenReservasiSheet($this->startDate, $this->endDate),
            new LaporanTransaksiSheet($this->startDate, $this->endDate),
            new LaporanReservasiSheet($this->startDate, $this->endDate),
        ];
    }
}

class LaporanTrenPendapatanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $days = (strtotime($this->endDate) - strtotime($this->startDate)) / 86400;

        if ($days <= 31) {
            $data = Transaksi::select(
                    DB::raw('DATE(tanggal) as label'),
                    DB::raw('COALESCE(SUM(total),0) as total')
                )
                ->whereBetween('tanggal', [$this->startDate, $this->endDate])
                ->where('status', '!=', 'Dibatalkan')
                ->groupBy(DB::raw('DATE(tanggal)'))
                ->orderBy('label')
                ->pluck('total', 'label')
                ->toArray();

            $result = [];
            $current = strtotime($this->startDate);
            $end = strtotime($this->endDate);
            while ($current <= $end) {
                $dateKey = date('Y-m-d', $current);
                $result[] = [
                    'label' => date('d M Y', $current),
                    'total' => (float)($data[$dateKey] ?? 0),
                ];
                $current = strtotime('+1 day', $current);
            }
            return collect($result);
        }

        $data = Transaksi::select(
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as label"),
                DB::raw('COALESCE(SUM(total),0) as total')
            )
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->where('status', '!=', 'Dibatalkan')
            ->groupBy('label')
            ->orderBy('label')
            ->pluck('total', 'label')
            ->toArray();

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $result = [];
        $current = new \DateTime($this->startDate);
        $endDT = new \DateTime($this->endDate);
        while ($current <= $endDT) {
            $key = $current->format('Y-m');
            $result[] = [
                'label' => $monthNames[(int)$current->format('m') - 1] . ' ' . $current->format('Y'),
                'total' => (float)($data[$key] ?? 0),
            ];
            $current->modify('+1 month');
        }
        return collect($result);
    }

    public function headings(): array
    {
        return ['Periode', 'Total Pendapatan'];
    }

    public function map($row): array
    {
        return [$row['label'], 'Rp ' . number_format($row['total'], 0, ',', '.')];
    }

    public function title(): string
    {
        return 'Tren Pendapatan';
    }
}

class LaporanTrenReservasiSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $days = (strtotime($this->endDate) - strtotime($this->startDate)) / 86400;

        if ($days <= 31) {
            $data = Booking::select(
                    DB::raw('DATE(tanggal) as label'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereBetween('tanggal', [$this->startDate, $this->endDate])
                ->groupBy(DB::raw('DATE(tanggal)'))
                ->orderBy('label')
                ->pluck('total', 'label')
                ->toArray();

            $result = [];
            $current = strtotime($this->startDate);
            $end = strtotime($this->endDate);
            while ($current <= $end) {
                $dateKey = date('Y-m-d', $current);
                $result[] = [
                    'label' => date('d M Y', $current),
                    'total' => (int)($data[$dateKey] ?? 0),
                ];
                $current = strtotime('+1 day', $current);
            }
            return collect($result);
        }

        $data = Booking::select(
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as label"),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->groupBy('label')
            ->orderBy('label')
            ->pluck('total', 'label')
            ->toArray();

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $result = [];
        $current = new \DateTime($this->startDate);
        $endDT = new \DateTime($this->endDate);
        while ($current <= $endDT) {
            $key = $current->format('Y-m');
            $result[] = [
                'label' => $monthNames[(int)$current->format('m') - 1] . ' ' . $current->format('Y'),
                'total' => (int)($data[$key] ?? 0),
            ];
            $current->modify('+1 month');
        }
        return collect($result);
    }

    public function headings(): array
    {
        return ['Periode', 'Jumlah Reservasi'];
    }

    public function map($row): array
    {
        return [$row['label'], $row['total']];
    }

    public function title(): string
    {
        return 'Tren Reservasi';
    }
}

class LaporanRingkasanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $totalPendapatan = Transaksi::whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->where('status', '!=', 'Dibatalkan')
            ->sum('total');

        $totalReservasi = Booking::whereBetween('tanggal', [$this->startDate, $this->endDate])->count();

        $pelangganBaru = Pelanggan::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->count();

        return collect([
            ['Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.')],
            ['Total Reservasi', (string) $totalReservasi],
            ['Pelanggan Baru', (string) $pelangganBaru],
            ['Periode', date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate))],
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

class LaporanTransaksiSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Transaksi::with('pelanggan')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return ['No. Invoice', 'Pelanggan', 'Tanggal', 'Total', 'Metode', 'Status'];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->no_invoice,
            $transaksi->pelanggan->nm_pelanggan ?? '-',
            $transaksi->tanggal,
            'Rp ' . number_format($transaksi->total, 0, ',', '.'),
            $transaksi->metode_byr,
            $transaksi->status,
        ];
    }

    public function title(): string
    {
        return 'Transaksi';
    }
}

class LaporanReservasiSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Booking::with('pelanggan', 'layanan')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return ['ID Booking', 'Pelanggan', 'Layanan', 'Tanggal', 'Status'];
    }

    public function map($booking): array
    {
        return [
            $booking->id,
            $booking->pelanggan->nm_pelanggan ?? '-',
            $booking->layanan->nm_layanan ?? '-',
            $booking->tanggal,
            $booking->status,
        ];
    }

    public function title(): string
    {
        return 'Reservasi';
    }
}
