@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Perbarui detail kriteria yang sudah ada.</p>
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
                    <a href="{{ route('kriteria.index') }}" class="text-decoration-none">
                        <i class="fas fa-table-columns me-1"></i>Data Kriteria
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
                                <i class="fas fa-edit text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold">Formulir Edit Kriteria</h5>
                                <small class="opacity-75">Ubah data sesuai kebutuhan</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('kriteria.update', $criteria->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-tag me-2 text-primary"></i>Nama Kriteria
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $criteria->name) }}" autofocus required>
                                <small class="text-muted mt-1 d-block">Nama ini akan menjadi label utama untuk kriteria.</small>
                                @error('name')
                                <div class="invalid-feedback mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="kategori" class="form-label fw-semibold">
                                    <i class="fas fa-sitemap me-2 text-info"></i>Kategori
                                </label>
                                <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                    <option value="" disabled>Pilih kategori...</option>
                                    <option value="BENEFIT" {{ old('kategori', $criteria->kategori) === 'BENEFIT' ? 'selected' : '' }}>Benefit</option>
                                    <option value="COST" {{ old('kategori', $criteria->kategori) === 'COST' ? 'selected' : '' }}>Cost</option>
                                </select>
                                <small class="text-muted mt-1 d-block">Tentukan apakah nilai yang lebih tinggi lebih baik (Benefit) atau lebih buruk (Cost).</small>
                                @error('kategori')
                                <div class="invalid-feedback mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="form-label fw-semibold">
                                    <i class="fas fa-info-circle me-2 text-success"></i>Keterangan
                                </label>
                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan', $criteria->keterangan) }}" required>
                                <small class="text-muted mt-1 d-block">Deskripsi singkat mengenai kriteria ini.</small>
                                @error('keterangan')
                                <div class="invalid-feedback mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                    </div>

                    <div class="card-footer bg-light border-0 text-end p-3">
                        <a href="{{ route('kriteria.index') }}" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.2s">
                    <div class="card-header bg-light border-0">
                        <h6 class="mb-0 fw-semibold"><i class="fas fa-lightbulb me-2"></i>Informasi Kategori</h6>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted">Kriteria yang telah ditentukan dibagi menjadi dua kategori, yaitu:</p>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-arrow-up text-success me-3 mt-1"></i>
                                    <div>
                                        <strong class="text-dark">Benefit (Keuntungan)</strong>
                                        <p class="mb-0 small text-muted">Semakin tinggi nilai, semakin tinggi peluang untuk dipilih.</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-arrow-down text-danger me-3 mt-1"></i>
                                    <div>
                                        <strong class="text-dark">Cost (Biaya)</strong>
                                        <p class="mb-0 small text-muted">Semakin rendah nilai, semakin rendah peluang untuk dipilih.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .icon-shape { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
        .bg-gradient-info { background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%) !important; }
        .animate-fade-in { opacity: 0; transform: translateY(20px); animation: fadeInUp 0.6s ease forwards; }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
    </style>
@endsection
