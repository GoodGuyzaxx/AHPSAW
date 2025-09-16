@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Kelola detail sub kriteria untuk setiap kriteria penilaian</p>
            </div>
            <div class="d-flex align-items-center">
                <div class="badge bg-info bg-opacity-10 text-info fs-6 px-3 py-2 rounded-pill">
                    <i class="fas fa-layer-group me-2"></i>
                    {{ $criteria_subs->total() }} Sub Kriteria
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
                <li class="breadcrumb-item">
                    <a href="{{ route('kriteria.index') }}" class="text-decoration-none text-primary">
                        <i class="fas fa-table-columns me-1"></i>Data Kriteria
                    </a>
                </li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        <!-- Error Alerts -->
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

        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm animate-fade-in mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                    </div>
                    <div class="flex-grow-1">
                        <strong>Perhatian!</strong><br>
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Data Management Panel -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <!-- Add Button -->
                            <div class="col-lg-3 col-md-4 mb-3 mb-lg-0">
                                <a href="{{ route('subkriteria.create') }}" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-plus me-2"></i>Tambah Sub Kriteria
                                </a>
                            </div>

                            <!-- Per Page Selection -->
                            <div class="col-lg-3 col-md-4 mb-3 mb-lg-0">
                                <div class="d-flex align-items-center">
                                    <select class="form-select" id="perPage" name="perPage" onchange="submitForm()">
                                        @foreach ($perPageOptions as $option)
                                            <option value="{{ $option }}" {{ $option == $perPage ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted ms-2 text-nowrap">entries per page</small>
                                </div>
                            </div>

                            <!-- Search Form -->
                            <div class="col-lg-6 col-md-4">
                                <form action="{{ route('subkriteria.index') }}" method="GET" class="d-flex">
                                    <div class="input-group">
                                        <input type="text"
                                               name="search"
                                               class="form-control"
                                               placeholder="Cari sub kriteria..."
                                               value="{{ request('search') }}">
                                        <button class="btn btn-outline-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        @if(request('search'))
                                            <a href="{{ route('subkriteria.index') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
                                    </div>
                                </form>
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
                    <div class="card-header bg-gradient-info text-white border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                    <i class="fas fa-list text-white"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Daftar Sub Kriteria</h5>
                                    <small class="opacity-75">Sub kriteria berdasarkan kriteria utama</small>
                                </div>
                            </div>
                            <div class="text-white-50">
                                <i class="fas fa-layer-group fa-2x opacity-25"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4 py-3 fw-semibold text-muted">
                                        <i class="fas fa-tag me-2"></i>Nama Kriteria
                                    </th>
                                    <th class="border-0 py-3 fw-semibold text-muted">
                                        <i class="fas fa-layer-group me-2"></i>Sub Kriteria
                                    </th>
                                    <th class="border-0 py-3 fw-semibold text-muted">
                                        <i class="fas fa-calculator me-2"></i>Nilai
                                    </th>
                                    <th class="border-0 py-3 fw-semibold text-muted text-center">
                                        <i class="fas fa-cogs me-2"></i>Aksi
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $previous_criteria_id = null;
                                    $rowspan = 0;
                                @endphp
                                @forelse ($criteria_subs as $criteria_sub)
                                    @if ($previous_criteria_id !== $criteria_sub->criteria_id)
                                        @if ($previous_criteria_id !== null)
                                            @php
                                                $rowspan--;
                                            @endphp
                                        @endif
                                        <tr class="border-bottom animate-fade-in" style="animation-delay: {{ $loop->iteration * 0.05 }}s">
                                            <td class="ps-4 py-4 align-middle border-end"
                                                rowspan="{{ $rowspan = $criteria_subs->where('criteria_id', $criteria_sub->criteria_id)->count() }}">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-shape bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                        <i class="fas fa-star text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold text-primary">
                                                            {{ $criteria_sub->criteria->name ?? 'Tidak Punya Kriteria' }}
                                                        </h6>
                                                        <small class="text-muted">Kriteria Utama</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-shape bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                                        <i class="fas fa-puzzle-piece text-info"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-semibold">{{ $criteria_sub->name_sub }}</span>
                                                        <br><small class="text-muted">ID: {{ $criteria_sub->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 align-middle">
                                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold fs-6">
                                                        <i class="fas fa-hashtag me-1"></i>{{ $criteria_sub->value }}
                                                    </span>
                                            </td>
                                            <td class="py-4 align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('subkriteria.edit', $criteria_sub->id) }}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       data-bs-toggle="tooltip"
                                                       title="Edit Sub Kriteria">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('subkriteria.destroy', $criteria_sub->id) }}"
                                                          method="POST"
                                                          class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger btnDelete"
                                                                data-object="sub kriteria"
                                                                data-bs-toggle="tooltip"
                                                                title="Hapus Sub Kriteria">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        <tr class="border-bottom animate-fade-in" style="animation-delay: {{ $loop->iteration * 0.05 }}s">
                                            <td class="py-4 align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-shape bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                                        <i class="fas fa-puzzle-piece text-info"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-semibold">{{ $criteria_sub->name_sub }}</span>
                                                        <br><small class="text-muted">ID: {{ $criteria_sub->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 align-middle">
                                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold fs-6">
                                                        <i class="fas fa-hashtag me-1"></i>{{ $criteria_sub->value }}
                                                    </span>
                                            </td>
                                            <td class="py-4 align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('subkriteria.edit', $criteria_sub->id) }}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       data-bs-toggle="tooltip"
                                                       title="Edit Sub Kriteria">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('subkriteria.destroy', $criteria_sub->id) }}"
                                                          method="POST"
                                                          class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger btnDelete"
                                                                data-object="sub kriteria"
                                                                data-bs-toggle="tooltip"
                                                                title="Hapus Sub Kriteria">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    @php
                                        $previous_criteria_id = $criteria_sub->criteria_id;
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="icon-shape bg-light rounded-circle p-4 mx-auto mb-3" style="width: 80px; height: 80px;">
                                                    <i class="fas fa-layer-group fa-2x text-muted"></i>
                                                </div>
                                                <h5 class="text-muted mb-2">Belum Ada Sub Kriteria</h5>
                                                <p class="text-muted mb-4">Anda belum membuat sub kriteria apapun</p>
                                                <a href="{{ route('subkriteria.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-2"></i>Buat Sub Kriteria Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($criteria_subs->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted small">
                                    Menampilkan {{ $criteria_subs->firstItem() }} - {{ $criteria_subs->lastItem() }}
                                    dari {{ $criteria_subs->total() }} data
                                </div>
                                <div>
                                    {{ $criteria_subs->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <!-- Custom Scripts -->
    <script>
        // Per page selection function
        function submitForm() {
            var perPageSelect = document.getElementById('perPage');
            var perPageValue = perPageSelect.value;

            var currentPage = {{ $criteria_subs->currentPage() }};
            var url = new URL(window.location.href);
            var params = new URLSearchParams(url.search);

            params.set('perPage', perPageValue);

            if (!params.has('page')) {
                params.set('page', currentPage);
            }

            url.search = params.toString();
            window.location.href = url.toString();
        }

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
            const tableRows = document.querySelectorAll('tbody tr:not(.empty-row)');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
                });

                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });

            // Search input focus effect
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.addEventListener('focus', function() {
                    this.parentNode.classList.add('shadow');
                });

                searchInput.addEventListener('blur', function() {
                    this.parentNode.classList.remove('shadow');
                });
            }
        });
    </script>

    <style>
        .icon-shape {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .table tbody tr:hover {
            border-left: 3px solid var(--bs-info);
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

        .input-group:focus-within {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .border-end {
            border-right: 2px solid #e9ecef !important;
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.03) 0%, rgba(108, 117, 125, 0.03) 100%);
        }

        /* Custom pagination styling */
        .pagination .page-link {
            border-radius: 0.375rem;
            margin: 0 2px;
            border: 1px solid #dee2e6;
        }

        .pagination .page-link:hover {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            color: white;
        }

        .pagination .active .page-link {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }
    </style>
@endsection
