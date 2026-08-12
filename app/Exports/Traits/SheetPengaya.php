<?php

namespace App\Exports\Traits;

use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

trait SheetPengaya
{
    protected string $judulSheet = '';
    protected string $subtitleSheet = '';
    protected int $barisHeaderSheet = 1;
    protected array $lebarKolomSheet = [];
    protected array $kolomUangSheet = [];

    public function startCell(): string
    {
        return 'A' . $this->barisHeaderSheet;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->terapkanGaya($event);
            },
        ];
    }

    protected function terapkanGaya(AfterSheet $event): void
    {
        $sheet = $event->sheet->getDelegate();
        $jumlahKolom = count($this->lebarKolomSheet);
        if ($jumlahKolom < 1) {
            return;
        }

        $lastCol = Coordinate::stringFromColumnIndex($jumlahKolom);
        $barisHeader = $this->barisHeaderSheet;
        $lastRow = $sheet->getHighestRow();

        if ($this->judulSheet !== '') {
            $sheet->mergeCells("A1:{$lastCol}1");
            $sheet->setCellValue('A1', $this->judulSheet);
            $sheet->getStyle('A1')->applyFromArray([
                'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FF4F87']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ]);
            $sheet->getRowDimension(1)->setRowHeight(26);

            if ($this->subtitleSheet !== '') {
                $sheet->mergeCells("A2:{$lastCol}2");
                $sheet->setCellValue('A2', $this->subtitleSheet);
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '6B7280']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension(2)->setRowHeight(16);
            }
        }

        $sheet->getStyle("A{$barisHeader}:{$lastCol}{$barisHeader}")->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'C2185B']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFE4EC']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension($barisHeader)->setRowHeight(20);

        if ($lastRow >= $barisHeader) {
            $borderStyle = $sheet->getStyle("A{$barisHeader}:{$lastCol}{$lastRow}")
                ->getBorders()->getAllBorders();
            $borderStyle->setBorderStyle(Border::BORDER_THIN);
            $borderStyle->getColor()->setARGB('D0D0D0');
        }

        foreach ($this->kolomUangSheet as $kolomIdx) {
            $huruf = Coordinate::stringFromColumnIndex($kolomIdx);
            $sheet->getStyle("{$huruf}" . ($barisHeader + 1) . ":{$huruf}{$lastRow}")
                ->getNumberFormat()->setFormatCode('"Rp "#,##0');
            $sheet->getStyle("{$huruf}" . ($barisHeader + 1) . ":{$huruf}{$lastRow}")
                ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        $sheet->getStyle("A{$barisHeader}:A{$lastRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        foreach ($this->lebarKolomSheet as $i => $lebar) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i + 1))->setWidth($lebar);
        }

        if ($lastRow > $barisHeader) {
            $sheet->freezePane('A' . ($barisHeader + 1));
        }
    }
}
