<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RanksExport;
use App\Http\Controllers\Controller;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\CriteriaAnalysis;
use App\Models\CriteriaAnalysisDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SAWCalculationExport;

class RankingController extends Controller
{
    public function index()
    {

        if (auth()->user()->level === 'ADMIN' || auth()->user()->level === 'USER') {
            $criteriaAnalysis = CriteriaAnalysis::with('user')->with(['details' => function ($query) {
                $query->join('criterias', 'criteria_analysis_details.criteria_id_second', '=', 'criterias.id')
                    ->select('criteria_analysis_details.*', 'criterias.name as criteria_name')
                    ->orderBy('criterias.id');
            }])
                ->get();
        }

        $availableCriterias = Criteria::all()->pluck('id');
        $isAnyAlternative   = Alternative::checkAlternativeByCriterias($availableCriterias);
        $isAbleToRank       = false;

        if ($isAnyAlternative) {
            $isAbleToRank = true;
        }

        return view('pages.admin.rank.data', [
            'title'             => 'Rangking',
            'criteria_analysis' => $criteriaAnalysis,
            'isAbleToRank'      => $isAbleToRank,
        ]);
    }

    public function show(CriteriaAnalysis $criteriaAnalysis)
    {
        $criteriaAnalysis->load('priorityValues');

        $criterias = CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysis->id);
        $criteriaIds = $criterias->pluck('id');
        $alternatives = Alternative::getAlternativesByCriteria($criteriaIds);
        $dividers = Alternative::getDividerByCriteria($criterias);

        $normalizations = $this->_hitungNormalisasi($dividers, $alternatives);

        // dd($normalizations);
        return view('pages.admin.rank.detail', [
            'title' => 'Normalisasi Tabel',
            'dividers' => $dividers,
            'normalizations' => $normalizations,
            'criteriaAnalysis' => $criteriaAnalysis,
        ]);
    }

    // private function _hitungNormalisasi($dividers, $alternatives)
    // {
    //     $normalisasi = [];

    //     foreach ($alternatives as $alternative) {
    //         $normalisasiAngka = [];

    //         foreach ($alternative['alternative_val'] as $key => $val) {
    //             $result = 0; // Default value

    //             // Pastikan $dividers[$key] ada dan memiliki 'kategori' dan 'divider_value'
    //             if (isset($dividers[$key]) && isset($dividers[$key]['kategori']) && isset($dividers[$key]['divider_value'])) {
    //                 $kategori = $dividers[$key]['kategori'];
    //                 $dividerValue = $dividers[$key]['divider_value'];

    //                 if ($val != 0 && $dividerValue != 0) {
    //                     if ($kategori === 'BENEFIT') {
    //                         $result = floatval($val / $dividerValue);
    //                     } elseif ($kategori === 'COST') {
    //                         $result = floatval($dividerValue / $val);
    //                     }
    //                     $result = number_format($result, 10, '.', ''); // Format to 10 decimal places
    //                 }
    //             }

    //             array_push($normalisasiAngka, $result);
    //         }

    //         array_push($normalisasi, [
    //             'student_id'      => $alternative['student_id'] ?? null,
    //             'student_name'    => strtoupper($alternative['student_name'] ?? ''),
    //             'kelas_name'      => $alternative['kelas_name'] ?? null,
    //             'criteria_name'   => $alternative['criteria_name'] ?? null,
    //             'criteria_id'     => $alternative['criteria_id'] ?? null,
    //             'alternative_val' => $alternative['alternative_val'] ?? [],
    //             'results'         => $normalisasiAngka
    //         ]);
    //     }

    //     // Menambahkan orderby berdasarkan nama siswa (student_name) secara naik (ascending)
    //     $normalisasi = collect($normalisasi)
    //         ->sortBy('student_name')
    //         ->sortBy('kelas_name')
    //         ->sortBy('criteria_id')
    //         ->values()
    //         ->all();

    //     return $normalisasi;
    // }


    //APP CODE

    // private function _hitungNormalisasi($dividers, $alternatives)
    // {
    //     return $alternatives;
    //     return $dividers;
    //     $normalisasi = [];

    //     foreach ($alternatives as $alternative) {
    //         $normalisasiAngka = [];

    //         foreach ($alternative['alternative_val'] as $key => $val) {
    //             if ($val == 0) {
    //                 $dividers = 0;
    //             }

    //             $kategori = $dividers[$key]['kategori'];

    //             if ($kategori === 'BENEFIT' && $val != 0) {
    //                 $result = substr(floatval($val / $dividers[$key]['divider_value']), 0, 11);
    //             }

    //             if ($kategori === 'COST' && $val != 0) {
    //                 $result = substr(floatval($dividers[$key]['divider_value'] / $val), 0, 11);
    //             }

    //             array_push($normalisasiAngka, $result);
    //         }

    //         array_push($normalisasi, [
    //             'student_id'      => $alternative['student_id'],
    //             'student_name'    => strtoupper($alternative['student_name']),
    //             'kelas_name'      => $alternative['kelas_name'],
    //             'criteria_name'   => $alternative['criteria_name'],
    //             'criteria_id'     => $alternative['criteria_id'],
    //             'alternative_val' => $alternative['alternative_val'],
    //             'results'         => $normalisasiAngka
    //         ]);
    //     }

    //     // Menambahkan orderby berdasarkan nama siswa (student_name) secara naik (ascending)
    //     $normalisasi = collect($normalisasi)
    //         ->sortBy('student_name')
    //         ->sortBy('kelas_name')
    //         ->sortBy('criteria_id')
    //         ->values()
    //         ->all();

    //     return $normalisasi;
    // }


    // public function final(CriteriaAnalysis $criteriaAnalysis)
    // {
    //     $criterias      = CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysis->id);
    //     $criteriaIds    = $criterias->pluck('id');
    //     $alternatives   = Alternative::getAlternativesByCriteria($criteriaIds);
    //     $dividers       = Alternative::getDividerByCriteria($criterias);

    //     $normalizations = $this->_hitungNormalisasi($dividers, $alternatives);

    //     try {
    //         $ranking    = $this->_finalRanking($criteriaAnalysis->priorityValues, $normalizations);
    //     } catch (\Exception $exception) {
    //         return back()->withError($exception->getMessage())->withInput();
    //     }

    //     return view('pages.admin.rank.final', [
    //         'title'             => 'Ranking Siswa',
    //         'criteria_analysis' => $criteriaAnalysis,
    //         'dividers'          => $dividers,
    //         'criterias'         => Criteria::all(),
    //         'normalizations'    => $normalizations,
    //         'ranks'             => $ranking
    //     ]);
    // }

    // private function _finalRanking($priorityValues, $normalizations)
    // {
    //     foreach ($normalizations as $keyNorm => $normal) {
    //         foreach ($normal['results'] as $keyVal => $value) {
    //             $importanceVal = $priorityValues[$keyVal]->value;

    //             // Operasi penjumlahan dari perkalian matriks ternormalisasi dan prioritas
    //             $result = $importanceVal * $value;

    //             if (array_key_exists('rank_result', $normalizations[$keyNorm])) {
    //                 $normalizations[$keyNorm]['rank_result'] += $result;
    //             } else {
    //                 $normalizations[$keyNorm]['rank_result'] = $result;
    //             }
    //         }
    //     }

    //     usort($normalizations, function ($a, $b) {
    //         return $b['rank_result'] <=> $a['rank_result'];
    //     });

    //     return $normalizations;
    // }

    private function _hitungNormalisasi($dividers, $alternatives)
    {
        $normalisasi = [];

        foreach ($alternatives as $alternative) {
            $normalisasiAngka = [];

            foreach ($alternative['alternative_val'] as $key => $val) {
                $result = 0; // Default value

                if (isset($dividers[$key])) {
                    $kategori = $dividers[$key]['kategori'];
                    $dividerValue = $dividers[$key]['divider_value'];

                    if ($val != 0 && $dividerValue != 0) {
                        if ($kategori === 'BENEFIT') {
                            $result = floatval($val / $dividerValue);
                        } elseif ($kategori === 'COST') {
                            $result = floatval($dividerValue / $val);
                        }
                        $result = number_format($result, 10, '.', '');
                    }
                }

                $normalisasiAngka[] = $result;
            }

            $normalisasi[] = [
                'student_id'      => $alternative['student_id'],
                'student_name'    => strtoupper($alternative['student_name']),
                'kelas_name'      => $alternative['kelas_name'],
                'criteria_name'   => $alternative['criteria_name'],
                'criteria_id'     => $alternative['criteria_id'],
                'alternative_val' => $alternative['alternative_val'],
                'results'         => $normalisasiAngka
            ];
        }

        // Sorting the normalisasi array
        usort($normalisasi, function ($a, $b) {
            $cmp = strcmp($a['kelas_name'], $b['kelas_name']);
            if ($cmp === 0) {
                $cmp = strcmp($a['student_name'], $b['student_name']);
                if ($cmp === 0) {
                    return $a['criteria_id'] - $b['criteria_id'];
                }
            }
            return $cmp;
        });

        return $normalisasi;
    }

    public function final(CriteriaAnalysis $criteriaAnalysis)
    {
        $criterias      = CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysis->id);
        $criteriaIds    = $criterias->pluck('id');
        $alternatives   = Alternative::getAlternativesByCriteria($criteriaIds);
        $dividers       = Alternative::getDividerByCriteria($criterias);

        $normalizations = $this->_hitungNormalisasi($dividers, $alternatives);

        try {
            $ranking = $this->_finalRanking($criteriaAnalysis->priorityValues, $normalizations);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('pages.admin.rank.final', [
            'title'             => 'Ranking Siswa',
            'criteria_analysis' => $criteriaAnalysis,
            'dividers'          => $dividers,
            'criterias'         => Criteria::all(),
            'normalizations'    => $normalizations,
            'ranks'             => $ranking
        ]);
    }

    private function _finalRanking($priorityValues, $normalizations)
    {
        foreach ($normalizations as $keyNorm => $normal) {
            $rankResult = 0;
            foreach ($normal['results'] as $keyVal => $value) {
                if (isset($priorityValues[$keyVal])) {
                    $importanceVal = $priorityValues[$keyVal]->value;
                    $rankResult += $importanceVal * $value;
                }
            }
            $normalizations[$keyNorm]['rank_result'] = $rankResult;
        }

        usort($normalizations, function ($a, $b) {
            return $b['rank_result'] <=> $a['rank_result'];
        });

        return $normalizations;
    }

    public function detailr(CriteriaAnalysis $criteriaAnalysis)
    {
        $criterias      = CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysis->id);
        $criteriaIds    = $criterias->pluck('id');
        $alternatives   = Alternative::getAlternativesByCriteria($criteriaIds);
        $dividers       = Alternative::getDividerByCriteria($criterias);

        $normalizations = $this->_hitungNormalisasi($dividers, $alternatives);
        try {
            $ranking    = $this->_finalRanking($criteriaAnalysis->priorityValues, $normalizations);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $title          = 'Perhitungan SAW';

        return view('pages.admin.rank.detailr', [
            'criteriaAnalysis'  => $criteriaAnalysis,
            'dividers'          => $dividers,
            'normalizations'    => $normalizations,
            'ranking'           => $ranking,
            'title'             => $title
        ]);
    }


    public function exportToExcel(CriteriaAnalysis $criteriaAnalysis)
    {
        $criterias = CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysis->id);
        $criteriaIds = $criterias->pluck('id');
        $alternatives = Alternative::getAlternativesByCriteria($criteriaIds);
        $dividers = Alternative::getDividerByCriteria($criterias);

        $normalizations = $this->_hitungNormalisasi($dividers, $alternatives);
        try {
            $ranking = $this->_finalRanking($criteriaAnalysis->priorityValues, $normalizations);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $exportData = [
            'criteriaAnalysis' => $criteriaAnalysis,
            'dividers' => $dividers,
            'normalizations' => $normalizations,
            'ranking' => $ranking,
        ];

        return Excel::download(new SAWCalculationExport($exportData), 'saw_calculation.xlsx');
    }

    // export
    public function export(CriteriaAnalysis $criteriaAnalysis)
    {
        $criterias = CriteriaAnalysisDetail::getSelectedCriterias($criteriaAnalysis->id);
        $criteriaIds = $criterias->pluck('id');
        $alternatives = Alternative::getAlternativesByCriteria($criteriaIds);
        $dividers = Alternative::getDividerByCriteria($criterias);

        $normalizations = $this->_hitungNormalisasi($dividers, $alternatives);
        $ranking = $this->_finalRanking($criteriaAnalysis->priorityValues, $normalizations);

        $export = new RanksExport($ranking, $normalizations);

        $fileName = 'Rangking Siswa.xlsx';

        return Excel::download($export, $fileName);
    }
}
