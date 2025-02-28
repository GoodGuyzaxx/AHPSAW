<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RanksExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    private $ranking;
    private $normalisasiAngka;

    public function __construct(array $ranking, array $normalisasiAngka)
    {
        $this->ranking = $ranking;
        $this->normalisasiAngka = $normalisasiAngka;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->ranking as $key => $rank) {
            $rowData = [
                'rank' => $key + 1,
                'student_name' => $rank['student_name'] ?? 'N/A',
                'kelas_name' => $rank['kelas_name'] ?? 'N/A',
            ];

            $criteriaNames = $rank['criteria_name'] ?? [];
            $results = $this->normalisasiAngka[$key]['results'] ?? [];

            foreach ($criteriaNames as $index => $criteriaName) {
                $rowData[$criteriaName] = isset($results[$index]) ? round($results[$index], 3) : 'N/A';
            }

            $rowData['rank_result'] = isset($rank['rank_result']) ? round($rank['rank_result'], 3) : 'N/A';

            $data[] = $rowData;
        }

        return collect($data);
    }

    public function headings(): array
    {
        $headingRow = [
            'Rank',
            'Nama Siswa',
            'Nama Kelas',
        ];

        if (!empty($this->ranking)) {
            $firstRank = $this->ranking[0];
            $criteriaNames = $firstRank['criteria_name'] ?? [];

            foreach ($criteriaNames as $criteriaName) {
                $headingRow[] = $criteriaName;
            }
        }

        $headingRow[] = 'Perhitungan SAW';

        return $headingRow;
    }
}
