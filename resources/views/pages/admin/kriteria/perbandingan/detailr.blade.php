@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Detail langkah-langkah perhitungan metode AHP.</p>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('perbandingan.index') }}" class="text-decoration-none">Perbandingan Kriteria</a></li>
                <li class="breadcrumb-item"><a href="{{ route('perbandingan.show', $criteria_analysis->id) }}">Input Perbandingan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('perbandingan.result', $criteria_analysis->id) }}">Hasil Perbandingan</a></li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
            <div class="card-header bg-light border-0 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-calculator me-2 text-info"></i>
                    Detail Perhitungan AHP
                </h5>
            </div>

            <div class="card-body p-4">
                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">1. Matriks Penjumlahan Kolom Kriteria</h6>
                <div class="table-responsive mb-5">
                    <table class="table table-bordered">
                        {{-- Konten tabel ini sudah benar --}}
                        <thead class="table-light align-middle text-center">
                        <tr>
                            <th>Kriteria</th>
                            @foreach ($criteria_analysis->priorityValues as $priorityValue)
                                <th>{{ $priorityValue->criteria->name }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="align-middle text-center">
                        @php($startAt = 0)
                        @foreach ($criteria_analysis->priorityValues as $priorityValue)
                            <tr>
                                <th class="table-light">{{ $priorityValue->criteria->name }}</th>
                                @foreach ($criteria_analysis->priorityValues as $innerPriorityValue)
                                    <td>
                                        @if ($criteria_analysis->details[$startAt]->criteria_id_first !== $criteria_analysis->details[$startAt]->criteria_id_second && $criteria_analysis->details[$startAt]->comparison_result < 1)
                                            <span class="text-muted small">1 / {{ round($criteria_analysis->details[$startAt]->comparison_value, 2) }} = </span>
                                        @endif
                                        {{ round(floatval($criteria_analysis->details[$startAt]->comparison_result), 3) }}
                                    </td>
                                    @php($startAt++)
                                @endforeach
                            </tr>
                        @endforeach
                        <tr class="table-dark">
                            <th class="text-center">Jumlah</th>
                            @foreach ($totalSums as $total)
                                <th class="text-center">{{ round($total['totalSum'], 3) }}</th>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">2. Matriks Normalisasi dan Nilai Prioritas</h6>
                <div class="table-responsive mb-5">
                    <table class="table table-bordered">
                        {{-- Konten tabel ini sudah benar --}}
                        <thead class="table-light align-middle text-center">
                        <tr>
                            <th>Kriteria</th>
                            @foreach ($criteria_analysis->priorityValues as $priorityValue)
                                <th>{{ $priorityValue->criteria->name }}</th>
                            @endforeach
                            <th>Jumlah Baris</th>
                            <th class="table-dark">Nilai Prioritas</th>
                        </tr>
                        </thead>
                        <tbody class="align-middle text-center">
                        @php($startAt = 0)
                        @foreach ($criteria_analysis->priorityValues as $priorityValue)
                            @php($rowTotal = 0)
                            <tr>
                                <th class="table-light">{{ $priorityValue->criteria->name }}</th>
                                @foreach ($criteria_analysis->priorityValues as $key => $innerPriorityValue)
                                    @php($res = floatval($criteria_analysis->details[$startAt]->comparison_result) / $totalSums[$key]['totalSum'])
                                    <td>
                                        <span class="text-muted small">{{ round(floatval($criteria_analysis->details[$startAt]->comparison_result), 2) }} / {{ round($totalSums[$key]['totalSum'], 2) }}</span><br>
                                        = <b class="text-success">{{ round($res, 3) }}</b>
                                    </td>
                                    @php($rowTotal += $res)
                                    @php($startAt++)
                                @endforeach
                                <td>{{ round($rowTotal, 3) }}</td>
                                <td class="table-dark">
                                    <span class="text-white-50 small">{{ round($rowTotal, 2) }} / {{ $criteria_analysis->priorityValues->count() }}</span><br>
                                    = <b class="text-white">{{ round($priorityValue->value, 3) }}</b>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">3. Matriks Perkalian dengan Nilai Prioritas</h6>
                <div class="table-responsive mb-5">
                    <table class="table table-bordered">
                        <thead class="table-light align-middle text-center">
                        <tr>
                            <th>Kriteria</th>
                            @foreach ($criteria_analysis->priorityValues as $priorityValue)
                                <th>{{ $priorityValue->criteria->name }}</th>
                            @endforeach
                            <th class="table-dark">Jumlah per Baris</th>
                        </tr>
                        </thead>
                        <tbody class="align-middle text-center">
                        @php($startAt = 0)
                        {{-- PERBAIKAN: Inisialisasi variabel $rowTotals --}}
                        @php($rowTotals = [])
                        @foreach ($criteria_analysis->priorityValues as $priorityValue)
                            @php($rowTotal = 0)
                            <tr>
                                <th class="table-light">{{ $priorityValue->criteria->name }}</th>
                                @foreach ($criteria_analysis->priorityValues as $key => $innerpriorityvalue)
                                    @php($res = floatval($criteria_analysis->details[$startAt]->comparison_result) * $innerpriorityvalue->value)
                                    <td>
                                        <span class="text-muted small">{{ round(floatval($criteria_analysis->details[$startAt]->comparison_result), 2) }} * {{ round($innerpriorityvalue->value, 2) }}</span><br>
                                        = <b class="text-success">{{ round($res, 3) }}</b>
                                    </td>
                                    @php($rowTotal += $res)
                                    @php($startAt++)
                                @endforeach
                                {{-- PERBAIKAN: Menyimpan hasil ke dalam array $rowTotals --}}
                                @php(array_push($rowTotals, $rowTotal))
                                <td class="table-dark fw-bold">{{ round($rowTotal, 3) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">4. Penentuan Lambda Maks dan Rasio Konsistensi</h6>
                <div class="table-responsive mb-5">
                    <table class="table table-bordered">
                        <thead class="table-light align-middle text-center">
                        <tr>
                            <th>Kriteria</th>
                            <th>Jumlah Baris</th>
                            <th>Nilai Prioritas</th>
                            <th>Hasil (Jumlah / Prioritas)</th>
                        </tr>
                        </thead>
                        <tbody class="align-middle text-center">
                        @php($lambdaResult = [])
                        {{-- PERBAIKAN: Menggunakan $rowTotals yang sudah dihitung di atas --}}
                        @foreach ($rowTotals as $key => $total)
                            <tr>
                                <th class="table-light">{{ $criteria_analysis->priorityValues[$key]->criteria->name }}</th>
                                <td>{{ round($total, 3) }}</td>
                                <td>{{ round($criteria_analysis->priorityValues[$key]->value, 3) }}</td>
                                <td>
                                    @php($lambda = $total / $criteria_analysis->priorityValues[$key]->value)
                                    @php(array_push($lambdaResult, $lambda))
                                    <span class="text-muted small">{{ round($total, 2) }} / {{ round($criteria_analysis->priorityValues[$key]->value, 2) }}</span><br>
                                    = <b class="text-success">{{ round($lambda, 3) }}</b>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="table-dark">
                            <td colspan="3" class="text-end fw-bold">Lambda Maks (λ maks) = Rata-rata Hasil</td>
                            <td class="fw-bold">
                                @php($lambdaMax = count($lambdaResult) > 0 ? array_sum($lambdaResult) / count($lambdaResult) : 0)
                                <span class="text-white-50 small">Σ / n</span><br>
                                = {{ round($lambdaMax, 3) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-lg-flex justify-content-center">
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header fw-bold text-center">
                                Hasil Akhir Rasio Konsistensi
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                    @php($n = $criteria_analysis->priorityValues->count())
                                    @php($CI = ($n > 1) ? ($lambdaMax - $n) / ($n - 1) : 0)
                                    @php($ruleRC = [1 => 0.0, 2 => 0.0, 3 => 0.58, 4 => 0.90, 5 => 1.12, 6 => 1.24, 7 => 1.32, 8 => 1.41, 9 => 1.45, 10 => 1.49, 11 => 1.51, 12 => 1.48, 13 => 1.56, 14 => 1.57, 15 => 1.59])
                                    @php($RC = $ruleRC[$n] ?? 0)
                                    @php($CR = ($RC > 0) ? $CI / $RC : 0)

                                    <tr>
                                        <th class="table-light w-50">Lambda Maks (λ maks)</th>
                                        <td>{{ round($lambdaMax, 3) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="table-light">Indeks Konsistensi (CI)</th>
                                        <td>{{ round($CI, 3) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="table-light">Indeks Random (RI)</th>
                                        <td>{{ $RC }}</td>
                                    </tr>
                                    <tr>
                                        <th class="table-light">Rasio Konsistensi (CR)</th>
                                        @php($txtClass = $CR <= 0.1 ? 'text-success fw-bold' : 'text-danger fw-bold')
                                        <td class="{{ $txtClass }}">
                                            {{ round($CR, 3) }}
                                            @if ($CR <= 0.1)
                                                <span class="badge bg-success ms-2">Konsisten</span>
                                            @else
                                                <span class="badge bg-danger ms-2">Tidak Konsisten</span>
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('partials.style-script')
@endsection
