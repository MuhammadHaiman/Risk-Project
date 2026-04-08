<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class HighestRiskReportExport implements FromArray, WithStyles
{
    private $data;
    private $title;

    public function __construct($data, $title = 'Laporan Risiko Tertinggi')
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
                $result[] = ['Kedudukan', 'Risiko', 'Sub-Kategori', 'Kekerapan Didaftarkan'];
                $rowIndex++;
            }

            // Add data row
            $result[] = [
                $rowIndex - 1 - (($rowIndex - 1) / 3),
                $item['risiko_nama'] ?? '',
                $item['sub_kategori'] ?? '',
                $item['frequency'] ?? 0,
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
                        'startColor' => ['rgb' => '003399'],
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
                        'startColor' => ['rgb' => '0066cc'],
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
