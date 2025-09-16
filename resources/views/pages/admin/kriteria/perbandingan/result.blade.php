@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Ringkasan hasil perhitungan metode AHP.</p>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('perbandingan.index') }}" class="text-decoration-none">Perbandingan Kriteria</a></li>
                <li class="breadcrumb-item"><a href="{{ route('perbandingan.show', $criteria_analysis->id) }}">Input Perbandingan</a></li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
            <div class="card-header bg-light border-0 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-poll me-2 text-success"></i>
                        Ringkasan Hasil Analisis
                    </h5>
                    <a href="{{ route('perbandingan.detailr', $criteria_analysis->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-calculator me-2"></i>Lihat Perhitungan Detail
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">1. Matriks Penjumlahan Kolom Kriteria</h6>
                <div class="table-responsive mb-5">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary align-middle text-center">
                        <tr>
                            <th>Kriteria</th>
                            @foreach ($criteria_analysis->priorityValues as $priorityValue)
                                <th>{{ $priorityValue->criteria->name }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="align-middle">
                        @php($startAt = 0)
                        @foreach ($criteria_analysis->priorityValues as $priorityValue)
                            @php($bgYellow = 'bg-warning text-dark')
                            <tr>
                                <th scope="row" class="text-center table-primary">
                                    {{ $priorityValue->criteria->name }}
                                </th>
                                @foreach ($criteria_analysis->priorityValues as $priorityvalue)
                                    @if ($criteria_analysis->details[$startAt]->criteria_id_first === $criteria_analysis->details[$startAt]->criteria_id_second)
                                        @php($bgYellow = '')
                                        <td class="text-center bg-success text-white ">
                                            {{ floatval($criteria_analysis->details[$startAt]->comparison_result) }}
                                        </td>
                                    @else
                                        <td class="text-center {{ $bgYellow }}">
                                            {{ round(floatval($criteria_analysis->details[$startAt]->comparison_result), 2) }}
                                        </td>
                                    @endif
                                    @php($startAt++)
                                @endforeach
                            </tr>
                        @endforeach
                        <tr class="table-dark">
                            <th class="text-center">Jumlah</th>
                            @foreach ($totalSums as $total)
                                <td class="text-center fw-bold">
                                    {{ round($total['totalSum'], 2) }}
                                </td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">2. Matriks Normalisasi dan Nilai Prioritas</h6>
                <div class="table-responsive mb-5">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary align-middle text-center">
                        <tr>
                            <th>Kriteria</th>
                            @foreach ($criteria_analysis->priorityValues as $priorityValue)
                                <th>{{ $priorityValue->criteria->name }}</th>
                            @endforeach
                            <th class="table-primary">Jumlah</th>
                            <th class="table-dark text-white">Nilai Prioritas</th>
                        </tr>
                        </thead>
                        <tbody class="align-middle">
                        @php($startAt = 0)
                        @php($rowTotals = [])
                        @foreach ($criteria_analysis->priorityValues as $priorityValue)
                            @php($rowTotal = 0)
                            <tr>
                                <th scope="row" class="table-primary text-center">
                                    {{ $priorityValue->criteria->name }}</th>
                                @foreach ($criteria_analysis->priorityValues as $key => $priorityvalue)
                                    <td class="text-center">
                                        @php($res = floatval($criteria_analysis->details[$startAt]->comparison_result) / $totalSums[$key]['totalSum'])
                                        {{ round($res, 2) }}
                                        @php($rowTotal += Str::substr($res, 0, 11))
                                    </td>
                                    @php($startAt++)
                                @endforeach
                                @php(array_push($rowTotals, $rowTotal))
                                <td class="text-center">
                                    {{ round($rowTotal, 2) }}
                                </td>
                                <td class="text-center table-dark text-white fw-bold">
                                    {{ round($priorityValue->value, 3) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">3. Matriks Perkalian Setiap Elemen dengan Nilai Prioritas</h6>
                <div class="table-responsive mb-5">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary align-middle text-center">
                        <tr>
                            <th>Kriteria</th>
                            @foreach ($criteria_analysis->priorityValues as $priorityValue)
                                <th>{{ $priorityValue->criteria->name }}</th>
                            @endforeach
                            <th class="table-dark text-white">Jumlah Baris</th>
                        </tr>
                        </thead>
                        <tbody class="align-middle">
                        @php($startAt = 0)
                        @php($rowTotals = [])
                        @foreach ($criteria_analysis->priorityValues as $priorityValue)
                            @php($rowTotal = 0)
                            <tr>
                                <th scope="row" class="table-primary text-center">
                                    {{ $priorityValue->criteria->name }}</th>
                                @foreach ($criteria_analysis->priorityValues as $key => $innerpriorityvalue)
                                    <td class="text-center">
                                        @php($res = floatval($criteria_analysis->details[$startAt]->comparison_result) * $innerpriorityvalue->value)
                                        {{ round($res, 2) }}
                                        @php($rowTotal += Str::substr($res, 0, 11))
                                    </td>
                                    @php($startAt++)
                                @endforeach
                                @php(array_push($rowTotals, $rowTotal))
                                <td class="text-center table-dark text-white fw-bold">
                                    {{ round($rowTotal, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">4. Penentuan Lambda Maks dan Rasio Konsistensi</h6>
                <div class="d-flex justify-content-center">
                    <div class="col-12 col-lg-8">
                        <table class="table table-bordered">
                            <tbody>
                            @php($lambdaMax = null)
                            @php($lambdaResult = [])
                            @foreach ($rowTotals as $key => $total)
                                {{-- Looping ini hanya untuk kalkulasi, tidak perlu ditampilkan --}}
                                @php($lambda = $total / $criteria_analysis->priorityValues[$key]->value)
                                @php($res = substr($lambda, 0, 11))
                                @php(array_push($lambdaResult, $res))
                            @endforeach
                            @php($lambdaMax = array_sum($lambdaResult) / count($lambdaResult))
                            @php($CI = ($lambdaMax - count($lambdaResult)) / (count($lambdaResult) - 1))
                            @php($RC = $ruleRC[$criteria_analysis->priorityValues->count()])
                            @php($CR = $RC != 0.0 ? $CI / $RC : 0.0)

                            <tr>
                                <th class="table-light w-50">Banyak Kriteria (n)</th>
                                <td>{{ $criteria_analysis->priorityValues->count() }}</td>
                            </tr>
                            <tr>
                                <th class="table-light">Lambda Maks (λ maks)</th>
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
                                <td class="{{ $txtClass }}">{{ round($CR, 3) }}
                                    @if ($CR <= 0.1)
                                        <span class="badge bg-success ms-2">Konsisten</span>
                                    @else
                                        <span class="badge bg-danger ms-2">Tidak Konsisten</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="p-3">
                                    @if ($CR > 0.1)
                                        <div class="alert alert-danger text-center mb-0">
                                            Nilai Rasio Konsistensi melebihi <b>0.1</b>. Harap masukkan kembali nilai perbandingan.
                                            <a href="{{ route('perbandingan.show', $criteria_analysis->id) }}" class="btn btn-danger mt-2">
                                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Input
                                            </a>
                                        </div>
                                    @elseif(!$isAbleToRank)
                                        <div class="alert alert-warning text-center mb-0">
                                            Belum ada data alternatif. Harap input data alternatif terlebih dahulu untuk melihat perangkingan.
                                        </div>
                                    @else
                                        <div class="d-grid">
                                            <a href="{{ route('rank.index', $criteria_analysis->id) }}" class="btn btn-lg btn-success">
                                                <i class="fas fa-trophy me-2"></i>Lihat Perangkingan Akhir
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @php(session(["cr_value_{$criteria_analysis->id}" => round($CR, 2)]))
    @include('partials.style-script')
@endsection
