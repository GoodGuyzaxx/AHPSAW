@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Pilih analisis perbandingan kriteria untuk melihat hasil perangkingan.</p>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
            <div class="card-header bg-light border-0 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list-alt me-2 text-primary"></i>
                    Pilih Analisis untuk Diranking
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Dibuat Oleh</th>
                            <th>Kriteria yang Dibandingkan</th>
                            <th>Dibuat Pada</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($criteria_analysis->count())
                            @foreach ($criteria_analysis as $analysis)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $analysis->user->name }}</td>
                                    <td>
                                        @foreach ($analysis->details->unique('criteria_id_second') as $key => $detail)
                                            <span class="badge bg-secondary fw-normal">{{ $detail->criteria_name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">{{ $analysis->created_at->translatedFormat('d F Y, H:i') }}</td>
                                    <td class="text-center">
                                        @if ($isAbleToRank)
                                            <a href="{{ route('rank.show', $analysis->id) }}" class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-eye me-2"></i>Lihat Perangkingan
                                            </a>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled data-bs-toggle="tooltip" title="Belum ada data alternatif untuk diranking.">
                                                <i class="fa-solid fa-clock me-2"></i>Tunggu Alternatif
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center text-danger py-4">
                                    <i class="fas fa-exclamation-circle me-2"></i>Operator belum membuat perbandingan kriteria.
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    @include('partials.style-script')
@endsection
