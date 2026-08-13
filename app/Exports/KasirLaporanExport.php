<?php

namespace App\Exports;

use App\Models\Transaksi;
use App\Exports\Traits\SheetPengaya;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

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

class KasirRingkasanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithCustomStartCell
{
    use SheetPengaya;

    protected int $userId;
    protected string $startDate;
    protected string $endDate;

    public function __construct(int $userId, string $startDate, string $endDate)
    {
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->judulSheet = 'LAPORAN PENDAPATAN KASIR';
        $this->subtitleSheet = 'Periode ' . date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate));
        $this->barisHeaderSheet = 3;
        $this->lebarKolomSheet = [6, 32, 26];
        $this->kolomUangSheet = [3];
    }

    public function collection()
    {
        $totalPendapatan = Transaksi::where('id_kasir', $this->userId)
            ->where('status', 'Lunas')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->sum('total');

        $totalTransaksi = Transaksi::where('id_kasir', $this->userId)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->count();

        $metodeTerbanyak = Transaksi::select('metode_byr', DB::raw('COUNT(*) as total'))
            ->where('id_kasir', $this->userId)
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->groupBy('metode_byr')
            ->orderBy('total', 'desc')
            ->first();

        return collect([
            ['no' => 1, 'label' => 'Total Pendapatan', 'value' => (float) $totalPendapatan],
            ['no' => 2, 'label' => 'Total Transaksi', 'value' => $totalTransaksi],
            ['no' => 3, 'label' => 'Rata-rata / Transaksi', 'value' => $totalTransaksi > 0 ? round($totalPendapatan / $totalTransaksi) : 0],
            ['no' => 4, 'label' => 'Metode Terbanyak', 'value' => $metodeTerbanyak->metode_byr ?? '-'],
            ['no' => 5, 'label' => 'Periode', 'value' => date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate))],
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

class KasirTransaksiSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithCustomStartCell
{
    use SheetPengaya;

    protected int $userId;
    protected string $startDate;
    protected string $endDate;

    public function __construct(int $userId, string $startDate, string $endDate)
    {
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->judulSheet = 'RINCIAN TRANSAKSI KASIR';
        $this->subtitleSheet = 'Periode ' . date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate));
        $this->barisHeaderSheet = 3;
        $this->lebarKolomSheet = [6, 22, 28, 14, 18, 14, 16];
        $this->kolomUangSheet = [5];
    }

    public function collection()
    {
        $rows = Transaksi::with('pelanggan')
            ->where('id_kasir', $this->userId)
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
        return ['No.', 'No. Invoice', 'Pelanggan', 'Tanggal', 'Total', 'Metode', 'Status'];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->no_urut,
            $transaksi->no_invoice,
            $transaksi->pelanggan->nm_pelanggan ?? '-',
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
