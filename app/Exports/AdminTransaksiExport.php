<?php

namespace App\Exports;

use App\Models\Transaksi;
use App\Exports\Traits\SheetPengaya;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AdminTransaksiExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithEvents, WithCustomStartCell
{
    use SheetPengaya;

    protected ?string $keyword;
    protected ?string $startDate;
    protected ?string $endDate;

    public function __construct(?string $keyword = null, ?string $startDate = null, ?string $endDate = null)
    {
        $this->keyword = $keyword;
        $this->startDate = $startDate;
        $this->endDate = $endDate;

        $this->judulSheet = 'LAPORAN TRANSAKSI';
        $this->subtitleSheet = 'Periode ' . ($startDate ? date('d M Y', strtotime($startDate)) : 'Semua') . ' – ' . ($endDate ? date('d M Y', strtotime($endDate)) : 'Semua');
        $this->barisHeaderSheet = 3;
        $this->lebarKolomSheet = [6, 20, 30, 18, 14, 14, 14, 16, 20, 16, 16, 16, 18, 30];
        $this->kolomUangSheet = [5, 6, 7, 8, 10, 11];
    }

    public function collection()
    {
        $keyword = $this->keyword;

        $rows = Transaksi::with('pelanggan', 'supplier', 'pengeluaran', 'user')
            ->when($this->keyword, function ($q) use ($keyword) {
                return $q->where(function ($q) use ($keyword) {
                    $q->where('no_invoice', 'like', "%{$keyword}%")
                        ->orWhere('catatan', 'like', "%{$keyword}%")
                        ->orWhereHas('pelanggan', function ($q) use ($keyword) {
                            $q->where('nm_pelanggan', 'like', "%{$keyword}%")
                                ->orWhere('no_hp', 'like', "%{$keyword}%");
                        })
                        ->orWhereHas('supplier', function ($q) use ($keyword) {
                            $q->where('nm_supplier', 'like', "%{$keyword}%");
                        })
                        ->orWhereHas('pengeluaran', function ($q) use ($keyword) {
                            $q->where('kategori', 'like', "%{$keyword}%")
                                ->orWhere('keterangan', 'like', "%{$keyword}%");
                        });
                });
            })
            ->when($this->startDate, fn($q, $d) => $q->whereDate('tanggal', '>=', $d))
            ->when($this->endDate, fn($q, $s) => $q->whereDate('tanggal', '<=', $s))
            ->orderBy('id_transaksi', 'desc')
            ->get();

        $no = 0;
        foreach ($rows as $row) {
            $row->no_urut = ++$no;
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['No.', 'Jenis', 'No. Invoice', 'Pelanggan/Supplier', 'Tanggal', 'Subtotal', 'Diskon', 'Pajak', 'Total', 'Metode', 'Dibayar', 'Kembali', 'Status', 'Admin', 'Catatan'];
    }

    public function map($t): array
    {
        $jenis = $t->jenis_transaksi;

        if (in_array($jenis, ['Pembelian', 'Pengeluaran'])) {
            $label = 'Transaksi Keluar';
            $pihak = $t->supplier->nm_supplier ?? ($t->pengeluaran->kategori ?? '-');
        } elseif ($jenis === 'Pemasukan') {
            $label = 'Pemasukan';
            $pihak = $t->pengeluaran->kategori ?? 'Dana Luar';
        } else {
            $label = 'Penjualan';
            $pihak = $t->pelanggan->nm_pelanggan ?? '-';
        }

        return [
            $t->no_urut,
            $label,
            $t->no_invoice,
            $pihak,
            $t->tanggal,
            (float) $t->subtotal,
            (float) $t->diskon,
            (float) $t->pajak,
            (float) $t->total,
            $t->metode_byr,
            (float) $t->dibayar,
            (float) $t->kembali,
            $t->status,
            $t->user->nama ?? '-',
            $t->catatan,
        ];
    }

    public function title(): string
    {
        return 'Transaksi';
    }
}
