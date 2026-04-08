<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AssetHighestRisksExport implements FromArray, WithStyles
{
    private $data;
    private $title;

    public function __construct($data, $title = 'Laporan Aset dengan Risiko Tertinggi')
    {
        $this->data = $data;
        $this->title = $title;
    }

    public function array(): array
    {
        $result = [];
        $currentAgency = null;
        $rowIndex = 0;

        foreach ($this->data as $item) {
            // Add agency header when agency changes
            if ($currentAgency !== ($item['agensi'] ?? null)) {
                // Add blank row for spacing
                if ($rowIndex > 0) {
                    $result[] = [''];
                    $rowIndex++;
                }

                $currentAgency = $item['agensi'] ?? null;

                // Add agency header row
                $result[] = [$currentAgency, '', '', ''];
                $rowIndex++;

                // Add sub-header row
                $result[] = ['Kedudukan', 'Nama Aset', 'Jenis Aset', 'Bilangan Risiko Terdaftar'];
                $rowIndex++;
            }

            // Add data row
            $result[] = [
                $rowIndex - 1 - (($rowIndex - 1) / 3),
                $item['asset_nama'] ?? '',
                $item['jenis_aset'] ?? '',
                $item['risk_count'] ?? 0,
            ];
            $rowIndex++;
        }

        return count($result) > 0 ? $result : [['Tiada data']];
    }

    public function styles(Worksheet $sheet)
    {
        $rowNum = 1;
        $currentAgency = null;
        $index = 0;

        foreach ($this->data as $item) {
            if ($currentAgency !== ($item['agensi'] ?? null)) {
                // Blank row
                if ($rowNum > 1) {
                    $rowNum++;
                }

                $currentAgency = $item['agensi'] ?? null;

                // Agency header style
                $sheet->getStyle("A{$rowNum}:D{$rowNum}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '009944'],
                    ],
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $rowNum++;

                // Sub-header style
                $sheet->getStyle("A{$rowNum}:D{$rowNum}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '00aa44'],
                    ],
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $rowNum++;
                $index = 1;
            }

            // Data row styling
            $sheet->getStyle("A{$rowNum}:D{$rowNum}")->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Alternate row colors for readability
            if ($index % 2 === 0) {
                $sheet->getStyle("A{$rowNum}:D{$rowNum}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'f0f0f0'],
                    ],
                ]);
            }

            $rowNum++;
            $index++;
        }

        // Auto-fit columns
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(20);
    }
}
