<?php

namespace App\Exports;

use App\Models\Transaksi;
use App\Models\Booking;
use App\Models\Pelanggan;
use App\Models\Stok;
use App\Exports\Traits\SheetPengaya;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

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

class LaporanTrenPendapatanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithCustomStartCell
{
    use SheetPengaya;

    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->judulSheet = 'TREN PENDAPATAN';
        $this->subtitleSheet = 'Periode ' . date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate));
        $this->barisHeaderSheet = 3;
        $this->lebarKolomSheet = [6, 22, 22];
        $this->kolomUangSheet = [3];
    }

    public function collection()
    {
        $days = (strtotime($this->endDate) - strtotime($this->startDate)) / 86400;

        if ($days <= 31) {
            $data = Transaksi::select(
                    DB::raw('DATE(tanggal) as label'),
                    DB::raw('COALESCE(SUM(total),0) as total')
                )
                ->where('jenis_transaksi', 'Penjualan')
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
                    'no' => count($result) + 1,
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
            ->where('jenis_transaksi', 'Penjualan')
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
                'no' => count($result) + 1,
                'label' => $monthNames[(int)$current->format('m') - 1] . ' ' . $current->format('Y'),
                'total' => (float)($data[$key] ?? 0),
            ];
            $current->modify('+1 month');
        }
        return collect($result);
    }

    public function headings(): array
    {
        return ['No.', 'Periode', 'Total Pendapatan'];
    }

    public function map($row): array
    {
        return [$row['no'], $row['label'], $row['total']];
    }

    public function title(): string
    {
        return 'Tren Pendapatan';
    }
}

class LaporanTrenReservasiSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithCustomStartCell
{
    use SheetPengaya;

    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->judulSheet = 'TREN RESERVASI';
        $this->subtitleSheet = 'Periode ' . date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate));
        $this->barisHeaderSheet = 3;
        $this->lebarKolomSheet = [6, 22, 22];
        $this->kolomUangSheet = [];
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
                    'no' => count($result) + 1,
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
                'no' => count($result) + 1,
                'label' => $monthNames[(int)$current->format('m') - 1] . ' ' . $current->format('Y'),
                'total' => (int)($data[$key] ?? 0),
            ];
            $current->modify('+1 month');
        }
        return collect($result);
    }

    public function headings(): array
    {
        return ['No.', 'Periode', 'Jumlah Reservasi'];
    }

    public function map($row): array
    {
        return [$row['no'], $row['label'], $row['total']];
    }

    public function title(): string
    {
        return 'Tren Reservasi';
    }
}

class LaporanRingkasanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithCustomStartCell
{
    use SheetPengaya;

    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->judulSheet = 'LAPORAN PENDAPATAN BEAUTYCARE';
        $this->subtitleSheet = 'Periode ' . date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate));
        $this->barisHeaderSheet = 3;
        $this->lebarKolomSheet = [6, 32, 26];
        $this->kolomUangSheet = [3];
    }

    public function collection()
    {
        $totalPendapatan = Transaksi::where('jenis_transaksi', 'Penjualan')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->where('status', '!=', 'Dibatalkan')
            ->sum('total');

        $masuk = Stok::where('type', 'Masuk')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->get()
            ->sum(fn($s) => ($s->harga_satuan ?? 0) * $s->jumlah);

        $refund = Stok::where('type', 'Refund')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->get()
            ->sum(fn($s) => ($s->harga_satuan ?? 0) * $s->jumlah);

        $totalPengeluaran = $masuk - $refund;
        $saldoBersih = $totalPendapatan - $totalPengeluaran;

        $totalReservasi = Booking::whereBetween('tanggal', [$this->startDate, $this->endDate])->count();

        $pelangganBaru = Pelanggan::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->count();

        return collect([
            ['no' => 1, 'label' => 'Total Pendapatan', 'value' => (float) $totalPendapatan],
            ['no' => 2, 'label' => 'Pengeluaran Pembelian', 'value' => (float) $totalPengeluaran],
            ['no' => 3, 'label' => 'Saldo Bersih', 'value' => (float) $saldoBersih],
            ['no' => 4, 'label' => 'Total Reservasi', 'value' => $totalReservasi],
            ['no' => 5, 'label' => 'Pelanggan Baru', 'value' => $pelangganBaru],
            ['no' => 6, 'label' => 'Periode', 'value' => date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate))],
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

class LaporanTransaksiSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithCustomStartCell
{
    use SheetPengaya;

    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->judulSheet = 'RINCIAN TRANSAKSI';
        $this->subtitleSheet = 'Periode ' . date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate));
        $this->barisHeaderSheet = 3;
        $this->lebarKolomSheet = [6, 18, 22, 30, 14, 18, 14, 14];
        $this->kolomUangSheet = [6];
    }

    public function collection()
    {
        $rows = Transaksi::with('pelanggan', 'supplier', 'pengeluaran')
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
        return ['No.', 'Jenis', 'No. Invoice', 'Pelanggan/Supplier', 'Tanggal', 'Total', 'Metode', 'Status'];
    }

    public function map($transaksi): array
    {
        $jenis = $transaksi->jenis_transaksi;

        if (in_array($jenis, ['Pembelian', 'Pengeluaran'])) {
            $label = 'Transaksi Keluar';
            $pihak = $transaksi->supplier->nm_supplier ?? ($transaksi->pengeluaran->kategori ?? '-');
        } elseif ($jenis === 'Pemasukan') {
            $label = 'Pemasukan';
            $pihak = $transaksi->pengeluaran->kategori ?? 'Dana Luar';
        } else {
            $label = 'Penjualan';
            $pihak = $transaksi->pelanggan->nm_pelanggan ?? '-';
        }

        return [
            $transaksi->no_urut,
            $label,
            $transaksi->no_invoice,
            $pihak,
            $transaksi->tanggal,
            (float) $transaksi->total,
            $transaksi->metode_byr,
            $transaksi->status,
        ];
    }

    public function title(): string
    {
        return 'Transaksi';
    }
}

class LaporanReservasiSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithCustomStartCell
{
    use SheetPengaya;

    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->judulSheet = 'RINCIAN RESERVASI';
        $this->subtitleSheet = 'Periode ' . date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate));
        $this->barisHeaderSheet = 3;
        $this->lebarKolomSheet = [6, 14, 26, 26, 14, 16];
        $this->kolomUangSheet = [];
    }

    public function collection()
    {
        $rows = Booking::with('pelanggan', 'detail.layanan')
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
        return ['No.', 'ID Booking', 'Pelanggan', 'Layanan', 'Tanggal', 'Status'];
    }

    public function map($booking): array
    {
        $layanan = $booking->detail
            ->map(fn($d) => $d->layanan->nm_layanan ?? '')
            ->filter()
            ->implode(', ');

        return [
            $booking->no_urut,
            $booking->id_booking,
            $booking->pelanggan->nm_pelanggan ?? '-',
            $layanan ?: '-',
            $booking->tanggal,
            $booking->status,
        ];
    }

    public function title(): string
    {
        return 'Reservasi';
    }
}
