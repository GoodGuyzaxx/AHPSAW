@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Detail perhitungan normalisasi dan perangkingan metode SAW.</p>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rank.index') }}" class="text-decoration-none">Analisis & Perangkingan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rank.show', $criteriaAnalysis->id) }}">Normalisasi Matriks</a></li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
            <div class="card-header bg-light border-0 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-calculator me-2 text-info"></i>
                        Detail Perhitungan Peringkat
                    </h5>
                    <a href="{{ route('export.saw', $criteriaAnalysis->id) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel me-2"></i>Export ke Excel
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">1. Informasi Pembagi & Bobot</h6>
                <div class="table-responsive mb-5">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th class="table-light w-25">Kategori</th>
                            @foreach ($dividers as $divider)
                                <td class="text-center">{{ $divider['kategori'] }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="table-light">Nilai Pembagi (Max/Min)</th>
                            @foreach ($dividers as $divider)
                                <td class="text-center">{{ $divider['divider_value'] }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="table-light">Bobot Prioritas (W)</th>
                            @foreach ($criteriaAnalysis->priorityValues as $key => $innerpriorityvalue)
                                <td class="text-center fw-bold">{{ round($innerpriorityvalue->value, 3) }}</td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">2. Proses Normalisasi Matriks (R)</h6>
                <div class="table-responsive mb-5">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light align-middle text-center">
                        <tr>
                            <th>Nama Alternatif</th>
                            @foreach ($dividers as $divider)
                                <th>{{ $divider['name'] }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="align-middle text-center">
                        @if (!empty($normalizations))
                            @foreach ($normalizations as $normalisasi)
                                <tr>
                                    <th class="table-light text-start">{{ $normalisasi['student_name'] }}</th>
                                    @foreach ($dividers as $key => $divider)
                                        <td>
                                            @php
                                                $val = $normalisasi['alternative_val'][$key] ?? null;
                                                $result = $normalisasi['results'][$key] ?? null;
                                            @endphp
                                            @if ($result !== null)
                                                @if ($divider['kategori'] === 'BENEFIT' && $val != 0)
                                                    <span class="text-muted small">{{ $val }} / {{ $divider['divider_value'] }}</span><br>=
                                                @elseif ($divider['kategori'] === 'COST' && $val != 0)
                                                    <span class="text-muted small">{{ $divider['divider_value'] }} / {{ $val }}</span><br>=
                                                @endif
                                                <b class="text-success">{{ round($result, 3) }}</b>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">3. Proses Perhitungan Peringkat (V = R x W)</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light align-middle text-center">
                        <tr>
                            <th>Nama Alternatif</th>
                            @foreach ($dividers as $divider)
                                <th>Hitung {{ $divider['name'] }}</th>
                            @endforeach
                            <th class="table-dark">Hasil Akhir (V)</th>
                            <th class="table-dark">Peringkat</th>
                        </tr>
                        </thead>
                        <tbody class="align-middle text-center">
                        @if (!empty($ranking))
                            @foreach ($ranking as $rank)
                                <tr>
                                    <th class="table-light text-start">{{ $rank['student_name'] }}</th>
                                    @foreach ($criteriaAnalysis->priorityValues as $key => $innerpriorityvalue)
                                        @php($hasilNormalisasi = $rank['results'][$key] ?? 0)
                                        @php($kali = $innerpriorityvalue->value * $hasilNormalisasi)
                                        <td>
                                            <span class="text-muted small">({{ round($hasilNormalisasi, 3) }} x {{ round($innerpriorityvalue->value, 3) }})</span><br>
                                            = <b class="text-info">{{ round($kali, 3) }}</b>
                                        </td>
                                    @endforeach
                                    <td class="table-secondary fw-bold">{{ round($rank['rank_result'], 4) }}</td>
                                    <td class="table-dark fw-bold">{{ $loop->iteration }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    @include('partials.style-script')
@endsection
