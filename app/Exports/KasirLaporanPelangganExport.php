<?php

namespace App\Exports;

use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KasirLaporanPelangganExport implements WithMultipleSheets
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
            new KasirPelangganRingkasanSheet($this->userId, $this->startDate, $this->endDate),
            new KasirPelangganDataSheet($this->userId, $this->startDate, $this->endDate),
        ];
    }
}

class KasirPelangganRingkasanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
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
        $totalPelanggan = Pelanggan::count();
        $pelangganBaru = Pelanggan::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->count();
        $pelangganMember = Pelanggan::whereNotNull('id_member')->count();
        $transaksiPelanggan = Transaksi::where('id_user', $this->userId)
            ->whereNotNull('id_pelanggan')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->count();

        return collect([
            ['Total Pelanggan', (string) $totalPelanggan],
            ['Pelanggan Baru', (string) $pelangganBaru],
            ['Pelanggan Member', (string) $pelangganMember],
            ['Transaksi Pelanggan', (string) $transaksiPelanggan],
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

class KasirPelangganDataSheet implements FromCollection, WithHeadings, WithMapping, WithTitle
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
        return Pelanggan::with('membership')
            ->withCount(['transaksi as total_transaksi' => function ($q) {
                $q->where('id_user', $this->userId);
            }])
            ->withSum(['transaksi as total_belanja' => function ($q) {
                $q->where('id_user', $this->userId)->where('status', 'Lunas');
            }], 'total')
            ->withMax(['transaksi as tgl_terakhir' => function ($q) {
                $q->where('id_user', $this->userId);
            }], 'tanggal')
            ->orderBy('id_pelanggan', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return ['Nama', 'No. HP', 'Email', 'Alamat', 'Member', 'Total Transaksi', 'Total Belanja', 'Terakhir Transaksi'];
    }

    public function map($p): array
    {
        $totalBelanja = $p->total_belanja ?? 0;
        return [
            $p->nm_pelanggan,
            $p->no_hp ?? '-',
            $p->email,
            $p->alamat,
            $p->membership->nm_member ?? '-',
            (string) ($p->total_transaksi ?? 0),
            'Rp ' . number_format($totalBelanja, 0, ',', '.'),
            $p->tgl_terakhir ? \Carbon\Carbon::parse($p->tgl_terakhir)->format('d/m/Y') : '-',
        ];
    }

    public function title(): string
    {
        return 'Data Pelanggan';
    }
}
