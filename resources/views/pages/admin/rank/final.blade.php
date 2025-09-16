@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Hasil akhir perangkingan mahasiswa berdasarkan metode AHP.</p>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rank.index') }}" class="text-decoration-none">Analisis & Perangkingan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rank.show', $criteria_analysis->id) }}">Normalisasi Matriks</a></li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
            <div class="card-header bg-light border-0 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-trophy me-2 text-warning"></i>
                        Hasil Akhir Peringkat
                    </h5>
{{--                    <a class="btn btn-success btn-sm" href="{{ route('rank.export', $criteria_analysis->id) }}">--}}
{{--                        <i class="fas fa-file-excel me-2"></i>Export Peringkat--}}
{{--                    </a>--}}
                </div>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark text-center">
                        <tr>
                            <th>Peringkat</th>
                            <th>Nama Alternatif</th>
                            <th>Nilai Akhir (V)</th>
                        </tr>
                        </thead>
                        <tbody class="text-center align-middle">
                        @if (!empty($ranks))
                            @php($rank = 1)
                            @foreach ($ranks as $rankData)
                                <tr>
                                    <td>
                                        @if ($rank == 1)
                                            <span class="badge bg-warning text-dark fs-6 shadow-sm">{{ $rank++ }}</span>
                                        @elseif ($rank == 2)
                                            <span class="badge bg-secondary fs-6 shadow-sm">{{ $rank++ }}</span>
                                        @elseif ($rank == 3)
                                            <span class="badge bg-danger-subtle text-dark-emphasis fs-6 shadow-sm">{{ $rank++ }}</span>
                                        @else
                                            <span class="fs-6">{{ $rank++ }}</span>
                                        @endif
                                    </td>
                                    <th class="table-light text-start">{{ $rankData['student_name'] }}</th>
                                    <td class="fw-bold">{{ round($rankData['rank_result'], 4) }}</td>
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
