<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SAWCalculationExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $exportArray = [];

        // Add criteria information
        $exportArray[] = [
            'Kategori',
            $this->data['dividers'][0]['kategori'] ?? '',
            $this->data['dividers'][1]['kategori'] ?? '',
            $this->data['dividers'][2]['kategori'] ?? '',
        ];
        $exportArray[] = [
            'Nilai pembagi',
            $this->data['dividers'][0]['divider_value'] ?? '',
            $this->data['dividers'][1]['divider_value'] ?? '',
            $this->data['dividers'][2]['divider_value'] ?? '',
        ];
        $exportArray[] = [
            'Nilai prioritas',
            $this->data['criteriaAnalysis']->priorityValues[0]->value ?? '',
            $this->data['criteriaAnalysis']->priorityValues[1]->value ?? '',
            $this->data['criteriaAnalysis']->priorityValues[2]->value ?? '',
        ];

        $exportArray[] = []; // Empty row for spacing

        // Add header row
        $exportArray[] = [
            'No',
            'Nama alternatif',
            'Kelas',
            $this->data['dividers'][0]['criteria_name'] ?? '',
            $this->data['dividers'][1]['criteria_name'] ?? '',
            $this->data['dividers'][2]['criteria_name'] ?? '',
        ];

        // Add data rows
        foreach ($this->data['normalizations'] as $index => $normalization) {
            $exportArray[] = [
                $index + 1,
                $normalization['student_name'] ?? '',
                $normalization['kelas_name'] ?? '',
                $this->formatValue($normalization['alternative_val'][0] ?? null, $this->data['dividers'][0]['divider_value'] ?? 1),
                $this->formatValue($normalization['alternative_val'][1] ?? null, $this->data['dividers'][1]['divider_value'] ?? 1),
                $this->formatValue($normalization['alternative_val'][2] ?? null, $this->data['dividers'][2]['divider_value'] ?? 1),
            ];
        }

        return $exportArray;
    }

    public function headings(): array
    {
        return ['Normalisasi Alternatif Siswa'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            5 => ['font' => ['bold' => true]],
        ];
    }

    private function formatValue($value, $divider)
    {
        if ($value === null || $divider == 0) {
            return '';
        }
        $result = $value / $divider;
        return "$value / $divider = " . number_format($result, 2);
    }
}
