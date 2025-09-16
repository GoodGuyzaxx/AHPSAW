@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Beri nilai perbandingan untuk setiap pasangan kriteria.</p>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none"><i class="fas fa-home me-1"></i>Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('perbandingan.index') }}" class="text-decoration-none">Perbandingan Kriteria</a>
                </li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        {{-- PERUBAHAN DI SINI: dari $details->count() menjadi count($details) --}}
        @if (count($details))
            <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
                <form action="{{ route('perbandingan.update', $details[0]->criteria_analysis_id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card-header bg-gradient-info text-white border-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fas fa-edit text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Formulir Perbandingan Antar Kriteria</h5>
                                <small class="opacity-75">Nilai 1: Sama Penting, Nilai 9: Mutlak Sangat Penting</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="table-light text-center">
                                <tr>
                                    <th>Kriteria Pertama</th>
                                    <th>Tingkat Kepentingan</th>
                                    <th>Kriteria Kedua</th>
                                </tr>
                                </thead>
                                <tbody>
                                <input type="hidden" name="id" value="{{ $details[0]->criteria_analysis_id }}">
                                @foreach ($details as $detail)
                                    <tr>
                                        <input type="hidden" name="criteria_analysis_detail_id[]" value="{{ $detail->id }}">
                                        <td class="text-center align-middle">{{ $detail->firstCriteria->name }}</td>
                                        <td style="min-width: 300px;">
                                            <select class="form-select" name="comparison_values[]" required>
                                                <option value="" disabled selected>-- Pilih Nilai Kepentingan --</option>
                                                <option value="1" {{ $detail->comparison_value == 1 ? 'selected' : '' }}>1 - Sama Pentingnya</option>
                                                <option value="2" {{ $detail->comparison_value == 2 ? 'selected' : '' }}>2 - Mendekati sedikit lebih penting</option>
                                                <option value="3" {{ $detail->comparison_value == 3 ? 'selected' : '' }}>3 - Sedikit lebih penting</option>
                                                <option value="4" {{ $detail->comparison_value == 4 ? 'selected' : '' }}>4 - Mendekati lebih penting</option>
                                                <option value="5" {{ $detail->comparison_value == 5 ? 'selected' : '' }}>5 - Lebih penting</option>
                                                <option value="6" {{ $detail->comparison_value == 6 ? 'selected' : '' }}>6 - Mendekati sangat penting</option>
                                                <option value="7" {{ $detail->comparison_value == 7 ? 'selected' : '' }}>7 - Sangat penting</option>
                                                <option value="8" {{ $detail->comparison_value == 8 ? 'selected' : '' }}>8 - Mendekati mutlak sangat penting</option>
                                                <option value="9" {{ $detail->comparison_value == 9 ? 'selected' : '' }}>9 - Mutlak sangat penting</option>
                                            </select>
                                        </td>
                                        <td class="text-center align-middle">{{ $detail->secondCriteria->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-0 text-end p-3">
                        @can('admin')
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perbandingan
                            </button>
                        @endcan
                        @if ($isDoneCounting)
                            <a href="{{ route('perbandingan.result', $criteria_analysis->id) }}" class="btn btn-success">
                                <i class="fas fa-poll me-2"></i>Lihat Hasil
                            </a>
                        @else
                            <span class="btn btn-secondary disabled" data-bs-toggle="tooltip" title="Anda harus menyimpan perbandingan terlebih dahulu.">
                                <i class="fas fa-poll me-2"></i>Lihat Hasil
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        @else
            <div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>Data perbandingan tidak ditemukan.</div>
        @endif
    </main>
    @include('partials.style-script')
@endsection
