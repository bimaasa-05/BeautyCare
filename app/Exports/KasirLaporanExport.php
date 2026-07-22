<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KasirLaporanExport implements WithMultipleSheets
{
    protected int $userId;
    protected string $startDate;
    protected string $endDate;

    public function __construct(int $userId, string $startDate, string $endDate)
    {
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function sheets(): array
    {
        return [
            new KasirRingkasanSheet($this->userId, $this->startDate, $this->endDate),
            new KasirTransaksiSheet($this->userId, $this->startDate, $this->endDate),
        ];
    }
}

class KasirRingkasanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected int $userId;
    protected string $startDate;
    protected string $endDate;

    public function __construct(int $userId, string $startDate, string $endDate)
    {
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $totalPendapatan = Transaksi::where('id_user', $this->userId)
            ->where('status', 'Lunas')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->sum('total');

        $totalTransaksi = Transaksi::where('id_user', $this->userId)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->count();

        $metodeTerbanyak = Transaksi::select('metode_byr', DB::raw('COUNT(*) as total'))
            ->where('id_user', $this->userId)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->groupBy('metode_byr')
            ->orderBy('total', 'desc')
            ->first();

        return collect([
            ['Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.')],
            ['Total Transaksi', (string) $totalTransaksi],
            ['Rata-rata / Transaksi', 'Rp ' . number_format($totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0, 0, ',', '.')],
            ['Metode Terbanyak', $metodeTerbanyak->metode_byr ?? '-'],
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

class KasirTransaksiSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected int $userId;
    protected string $startDate;
    protected string $endDate;

    public function __construct(int $userId, string $startDate, string $endDate)
    {
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Transaksi::with('pelanggan')
            ->where('id_user', $this->userId)
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
