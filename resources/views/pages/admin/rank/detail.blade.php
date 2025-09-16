@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Tahap normalisasi matriks keputusan.</p>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('rank.index') }}" class="text-decoration-none">Analisis & Perangkingan</a></li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
            <div class="card-header bg-light border-0 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-table me-2 text-info"></i>
                        Matriks Normalisasi (R)
                    </h5>
                    <div>
                        @php($crValue = session("cr_value_{$criteriaAnalysis->id}"))
                        @if ($crValue > 0.1)
                            <a href="{{ route('perbandingan.show', $criteriaAnalysis->id) }}" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Nilai CR tidak konsisten, harap perbaiki.">
                                <i class="fas fa-exclamation-triangle me-2"></i>CR: {{ $crValue }} (Tidak Konsisten)
                            </a>
                        @else
                            <a href="{{ route('rank.final', $criteriaAnalysis->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-ranking-star me-2"></i>Lanjutkan ke Ranking Akhir
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                @if (session('error'))
                    <div class="alert alert-danger"><i class="fas fa-times-circle me-2"></i>Lakukan perhitungan perbandingan terlebih dahulu.</div>
                @endif

                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">Informasi Pembagi & Bobot</h6>
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
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">Tabel Normalisasi Alternatif</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light align-middle text-center">
                        <tr>
                            <th>No</th>
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
                                    <td>{{ $loop->iteration }}</td>
                                    <th class="table-light text-start">{{ Str::ucfirst(Str::lower($normalisasi['student_name'])) }}</th>
                                    @foreach ($dividers as $key => $value)
                                        <td>
                                            @if (isset($normalisasi['results'][$key]))
                                                {{ round($normalisasi['results'][$key], 3) }}
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
            </div>
        </div>
    </main>
    @include('partials.style-script')
@endsection
