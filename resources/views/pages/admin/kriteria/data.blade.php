@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Kelola kriteria penilaian untuk sistem pendukung keputusan</p>
            </div>
            <div class="d-flex align-items-center">
                <div class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill">
                    <i class="fas fa-table-columns me-2"></i>
                    {{ $criterias->count() }} Kriteria
                </div>
            </div>
        </div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
                <li class="breadcrumb-item">
                    <a href="{{ route('subkriteria.index') }}" class="text-decoration-none text-info">
                        <i class="fas fa-layer-group me-1"></i>Sub Kriteria
                    </a>
                </li>
            </ol>
        </nav>

        <!-- Error Alert -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm animate-fade-in mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle fa-lg me-3"></i>
                    </div>
                    <div class="flex-grow-1">
                        <strong>Terjadi Kesalahan!</strong><br>
                        {{ session('error') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Action Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-list-check text-primary fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold">Manajemen Kriteria</h5>
                                    <p class="mb-0 text-muted small">Tambah, edit, dan hapus kriteria penilaian</p>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('subkriteria.index') }}" class="btn btn-outline-info btn-lg">
                                    <i class="fas fa-layer-group me-2"></i>Sub Kriteria
                                </a>
                                <a href="{{ route('kriteria.create') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus me-2"></i>Tambah Kriteria
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
                    <div class="card-header bg-gradient-primary text-white border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                    <i class="fas fa-database text-white"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Daftar Kriteria</h5>
                                    <small class="opacity-75">Semua kriteria penilaian yang tersedia</small>
                                </div>
                            </div>
                            <div class="text-white-50">
                                <i class="fas fa-chart-bar fa-2x opacity-25"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4 py-3 fw-semibold text-muted">
                                        <i class="fas fa-hashtag me-2"></i>No
                                    </th>
                                    <th class="border-0 py-3 fw-semibold text-muted">
                                        <i class="fas fa-tag me-2"></i>Nama Kriteria
                                    </th>
                                    <th class="border-0 py-3 fw-semibold text-muted">
                                        <i class="fas fa-folder me-2"></i>Kategori
                                    </th>
                                    <th class="border-0 py-3 fw-semibold text-muted">
                                        <i class="fas fa-info-circle me-2"></i>Keterangan
                                    </th>
                                    <th class="border-0 py-3 fw-semibold text-muted text-center">
                                        <i class="fas fa-cogs me-2"></i>Aksi
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if ($criterias->count())
                                    @foreach ($criterias as $criteria)
                                        <tr class="border-bottom animate-fade-in" style="animation-delay: {{ $loop->iteration * 0.05 }}s">
                                            <td class="ps-4 py-4 align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-semibold">
                                                        {{ $loop->iteration }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-shape bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                                        <i class="fas fa-star text-success"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold">{{ $criteria->name }}</h6>
                                                        <small class="text-muted">ID: {{ $criteria->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 align-middle">
                                                @php
                                                    $kategoriClass = $criteria->kategori === 'BENEFIT' ? 'success' : 'warning';
                                                    $kategoriIcon = $criteria->kategori === 'BENEFIT' ? 'arrow-up' : 'arrow-down';
                                                @endphp
                                                <span class="badge bg-{{ $kategoriClass }} bg-opacity-10 text-{{ $kategoriClass }} px-3 py-2 rounded-pill fw-semibold">
                                                        <i class="fas fa-{{ $kategoriIcon }} me-2"></i>
                                                        {{ Str::ucfirst(Str::lower($criteria->kategori)) }}
                                                    </span>
                                            </td>
                                            <td class="py-4 align-middle">
                                                <div class="text-muted">
                                                    {{ $criteria->keterangan ?: 'Tidak ada keterangan' }}
                                                </div>
                                            </td>
                                            <td class="py-4 align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('kriteria.edit', $criteria->id) }}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       data-bs-toggle="tooltip"
                                                       title="Edit Kriteria">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('kriteria.destroy', $criteria->id) }}"
                                                          method="POST"
                                                          class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger btnDelete"
                                                                data-object="kriteria"
                                                                data-bs-toggle="tooltip"
                                                                title="Hapus Kriteria">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="icon-shape bg-light rounded-circle p-4 mx-auto mb-3" style="width: 80px; height: 80px;">
                                                    <i class="fas fa-table-columns fa-2x text-muted"></i>
                                                </div>
                                                <h5 class="text-muted mb-2">Belum Ada Kriteria</h5>
                                                <p class="text-muted mb-4">Anda belum membuat kriteria penilaian apapun</p>
                                                <a href="{{ route('kriteria.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-2"></i>Buat Kriteria Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        @if ($criterias->count())
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 animate-fade-in" style="animation-delay: 0.2s">
                        <div class="card-body text-center p-4">
                            <div class="icon-shape bg-success bg-opacity-10 rounded-circle p-3 mx-auto mb-3">
                                <i class="fas fa-arrow-up fa-2x text-success"></i>
                            </div>
                            <h3 class="fw-bold text-success">{{ $criterias->where('kategori', 'BENEFIT')->count() }}</h3>
                            <p class="text-muted mb-0">Kriteria Benefit</p>
                            <small class="text-muted">Semakin tinggi semakin baik</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 animate-fade-in" style="animation-delay: 0.3s">
                        <div class="card-body text-center p-4">
                            <div class="icon-shape bg-warning bg-opacity-10 rounded-circle p-3 mx-auto mb-3">
                                <i class="fas fa-arrow-down fa-2x text-warning"></i>
                            </div>
                            <h3 class="fw-bold text-warning">{{ $criterias->where('kategori', 'COST')->count() }}</h3>
                            <p class="text-muted mb-0">Kriteria Cost</p>
                            <small class="text-muted">Semakin rendah semakin baik</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 animate-fade-in" style="animation-delay: 0.4s">
                        <div class="card-body text-center p-4">
                            <div class="icon-shape bg-info bg-opacity-10 rounded-circle p-3 mx-auto mb-3">
                                <i class="fas fa-chart-pie fa-2x text-info"></i>
                            </div>
                            <h3 class="fw-bold text-info">{{ $criterias->count() }}</h3>
                            <p class="text-muted mb-0">Total Kriteria</p>
                            <small class="text-muted">Semua kriteria aktif</small>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <!-- Custom Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Enhanced delete confirmation
            const deleteButtons = document.querySelectorAll('.btnDelete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    const objectName = this.dataset.object || 'item';

                    Swal.fire({
                        title: 'Konfirmasi Penghapusan',
                        text: `Apakah Anda yakin ingin menghapus ${objectName} ini? Tindakan ini tidak dapat dibatalkan.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            popup: 'swal-delete-confirm'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Add loading state
                            Swal.fire({
                                title: 'Menghapus...',
                                text: 'Sedang memproses permintaan Anda',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            form.submit();
                        }
                    });
                });
            });

            // Add hover effects to table rows
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
        });
    </script>

    <style>
        .icon-shape {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .table tbody tr:hover {
            border-left: 3px solid var(--bs-primary);
            transform: translateX(2px);
        }

        .btn-group .btn {
            margin: 0 2px;
        }

        .empty-state {
            padding: 2rem;
        }

        .badge.fs-6 {
            font-size: 0.875rem !important;
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
    </style>
@endsection
