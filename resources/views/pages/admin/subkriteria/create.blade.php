@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Tambahkan sub kriteria baru ke dalam sistem penilaian.</p>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('subkriteria.index') }}" class="text-decoration-none">
                        <i class="fas fa-layer-group me-1"></i>Data Sub Kriteria
                    </a>
                </li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
                    <div class="card-header bg-gradient-info text-white border-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fas fa-plus text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Formulir Tambah Sub Kriteria</h5>
                                <small class="opacity-75">Isi semua kolom yang diperlukan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('subkriteria.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="criteria_id" class="form-label fw-semibold">
                                    <i class="fas fa-star me-2 text-primary"></i>Kriteria Induk
                                </label>
                                <select class="form-select @error('criteria_id') is-invalid @enderror" id="criteria_id" name="criteria_id" required>
                                    <option value="" disabled selected>Pilih kriteria...</option>
                                    @foreach ($criterias as $criteria)
                                        <option value="{{ $criteria->id }}" {{ old('criteria_id') == $criteria->id ? 'selected' : '' }}>
                                            {{ $criteria->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted mt-1 d-block">Pilih kriteria utama yang akan memiliki sub kriteria ini.</small>
                                @error('criteria_id')
                                <div class="invalid-feedback mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="name_sub" class="form-label fw-semibold">
                                    <i class="fas fa-puzzle-piece me-2 text-info"></i>Nama Sub Kriteria
                                </label>
                                <input type="text" id="name_sub" name="name_sub"
                                       class="form-control @error('name_sub') is-invalid @enderror"
                                       value="{{ old('name_sub') }}" required placeholder="Contoh: Sangat Baik">
                                <small class="text-muted mt-1 d-block">Masukkan nama unik untuk sub kriteria.</small>
                                @error('name_sub')
                                <div class="invalid-feedback mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="value" class="form-label fw-semibold">
                                    <i class="fas fa-hashtag me-2 text-success"></i>Nilai
                                </label>
                                <input type="number" class="form-control @error('value') is-invalid @enderror" id="value" name="value"
                                       value="{{ old('value') }}" required placeholder="Contoh: 5">
                                <small class="text-muted mt-1 d-block">Masukkan nilai numerik untuk sub kriteria ini.</small>
                                @error('value')
                                <div class="invalid-feedback mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                                @enderror
                            </div>
                    </div>

                    <div class="card-footer bg-light border-0 text-end p-3">
                        <a href="{{ route('subkriteria.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Data
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .icon-shape {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .bg-gradient-info {
            background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%) !important;
        }
        .animate-fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0.125rem 0.25rem rgba(13, 110, 253, 0.1);
            border-color: #86b7fe;
        }
    </style>
@endsection
