<?php

namespace App\Exports;

use App\Models\Pelanggan;
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

class KasirPelangganRingkasanSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithCustomStartCell
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

        $this->judulSheet = 'LAPORAN PELANGGAN KASIR';
        $this->subtitleSheet = 'Periode ' . date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate));
        $this->barisHeaderSheet = 3;
        $this->lebarKolomSheet = [6, 32, 26];
        $this->kolomUangSheet = [];
    }

    public function collection()
    {
        $totalPelanggan = Pelanggan::whereHas('transaksi', function ($q) {
            $q->where('id_kasir', $this->userId)->where('jenis_transaksi', '!=', 'Pengeluaran');
        })->count();

        $pelangganBaru = Pelanggan::whereHas('transaksi', function ($q) {
            $q->where('id_kasir', $this->userId)->where('jenis_transaksi', '!=', 'Pengeluaran')
                ->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        })->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->count();

        $pelangganMember = Pelanggan::whereNotNull('id_member')
            ->whereHas('transaksi', function ($q) {
                $q->where('id_kasir', $this->userId)->where('jenis_transaksi', '!=', 'Pengeluaran');
            })->count();

        $transaksiPelanggan = Transaksi::whereNotNull('id_pelanggan')
            ->where('id_kasir', $this->userId)
            ->where('jenis_transaksi', '!=', 'Pengeluaran')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate])
            ->count();

        return collect([
            ['no' => 1, 'label' => 'Total Pelanggan', 'value' => (float) $totalPelanggan],
            ['no' => 2, 'label' => 'Pelanggan Baru', 'value' => (float) $pelangganBaru],
            ['no' => 3, 'label' => 'Pelanggan Member', 'value' => (float) $pelangganMember],
            ['no' => 4, 'label' => 'Transaksi Pelanggan', 'value' => (float) $transaksiPelanggan],
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

class KasirPelangganDataSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithCustomStartCell
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

        $this->judulSheet = 'DATA PELANGGAN KASIR';
        $this->subtitleSheet = 'Periode ' . date('d M Y', strtotime($this->startDate)) . ' – ' . date('d M Y', strtotime($this->endDate));
        $this->barisHeaderSheet = 3;
        $this->lebarKolomSheet = [6, 28, 16, 26, 30, 14, 16, 18, 18];
        $this->kolomUangSheet = [8];
    }

    public function collection()
    {
        $rows = Pelanggan::with('membership')
            ->withCount(['transaksi as total_transaksi' => function ($q) {
                $q->where('id_kasir', $this->userId)->where('jenis_transaksi', '!=', 'Pengeluaran');
            }])
            ->withSum(['transaksi as total_belanja' => function ($q) {
                $q->where('id_kasir', $this->userId)->where('jenis_transaksi', '!=', 'Pengeluaran')->where('status', 'Lunas');
            }], 'total')
            ->withMax(['transaksi as tgl_terakhir' => function ($q) {
                $q->where('id_kasir', $this->userId)->where('jenis_transaksi', '!=', 'Pengeluaran');
            }], 'tanggal')
            ->orderBy('id_pelanggan', 'desc')
            ->get();

        $no = 0;
        foreach ($rows as $row) {
            $row->no_urut = ++$no;
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['No.', 'Nama', 'No. HP', 'Email', 'Alamat', 'Member', 'Total Transaksi', 'Total Belanja', 'Terakhir Transaksi'];
    }

    public function map($p): array
    {
        return [
            $p->no_urut,
            $p->nm_pelanggan,
            $p->no_hp ?? '-',
            $p->email,
            $p->alamat,
            $p->membership->nm_member ?? '-',
            (float) ($p->total_transaksi ?? 0),
            (float) ($p->total_belanja ?? 0),
            $p->tgl_terakhir ? \Carbon\Carbon::parse($p->tgl_terakhir)->format('d/m/Y') : '-',
        ];
    }

    public function title(): string
    {
        return 'Data Pelanggan';
    }
}
