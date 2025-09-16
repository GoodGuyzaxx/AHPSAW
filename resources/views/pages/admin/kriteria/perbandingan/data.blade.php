@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Kelola analisis perbandingan antar kriteria menggunakan metode AHP.</p>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active fw-semibold">{{ $title }}</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
            <div class="card-header bg-light border-0 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-balance-scale me-2 text-primary"></i>
                        Daftar Analisis Perbandingan
                    </h5>
                    @can('admin')
                        <button type="button" class="btn btn-primary btn-sm" onclick="showCriteriaSelection()">
                            <i class="fas fa-plus me-2"></i>Buat Perbandingan Baru
                        </button>
                    @endcan
                </div>
            </div>

            <div class="card-body p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Info Card -->
                @if ($criterias->count() < 2)
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Perhatian:</strong> Minimal diperlukan 2 kriteria untuk melakukan perbandingan.
                        <a href="{{ route('kriteria.index') }}" class="alert-link">Tambahkan kriteria</a> terlebih dahulu.
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light text-center">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 150px;">Dibuat Oleh</th>
                            <th>Kriteria yang Dibandingkan</th>
                            <th style="width: 150px;">Tanggal Dibuat</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($comparisons as $comparison)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="fas fa-user text-white small"></i>
                                        </div>
                                        <span class="fw-medium">{{ $comparison->user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($comparison->details->unique('criteria_id_second') as $detail)
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info">
                                                {{ $detail->criteria_name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="text-center">
                                    <small class="text-muted">
                                        {{ $comparison->created_at->translatedFormat('d M Y') }}<br>
                                        <span class="badge bg-light text-dark">{{ $comparison->created_at->format('H:i') }}</span>
                                    </small>
                                </td>
                                <td class="text-center">
                                    @php
                                        $totalComparisons = $comparison->details->count();
                                        $completedComparisons = $comparison->details->where('value', '!=', null)->count();
                                        $progress = $totalComparisons > 0 ? ($completedComparisons / $totalComparisons) * 100 : 0;
                                    @endphp
                                    @if($progress >= 100)
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($progress > 0)
                                        <span class="badge bg-warning">{{ round($progress) }}% Selesai</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Dimulai</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('perbandingan.show', $comparison->id) }}"
                                           class="btn btn-success btn-sm"
                                           title="Lihat/Input Perbandingan">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @can('admin')
                                            <button type="button"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="deleteComparison({{ $comparison->id }})"
                                                    title="Hapus Perbandingan">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-balance-scale text-muted"></i>
                                        </div>
                                        <h6 class="text-muted mt-2">Belum ada data perbandingan kriteria</h6>
                                        <p class="text-muted small">Buat perbandingan baru untuk memulai analisis AHP</p>
                                        @can('admin')
                                            <button type="button" class="btn btn-primary btn-sm mt-2" onclick="showCriteriaSelection()">
                                                <i class="fas fa-plus me-2"></i>Buat Perbandingan
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Pilih Kriteria (Collapsed Version) -->
        <div class="card border-0 shadow-sm mt-4" id="criteriaSelectionCard" style="display: none;">
            <div class="card-header bg-gradient-info text-white border-0 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-2 me-3">
                            <i class="fas fa-check-double text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Pilih Kriteria untuk Perbandingan</h5>
                            <small class="opacity-75">Pilih minimal 2 kriteria yang akan dibandingkan</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-light btn-sm" onclick="hideCriteriaSelection()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('perbandingan.store') }}" method="POST" id="criteriaForm">
                    @csrf
                    @if ($criterias->count())
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label fw-bold" for="selectAll">
                                    Pilih Semua Kriteria
                                </label>
                            </div>
                            <hr>
                        </div>

                        <div class="row">
                            @foreach ($criterias as $criteria)
                                <div class="col-md-6 mb-3">
                                    <div class="criteria-card border rounded p-3 h-100" onclick="toggleCriteria({{ $criteria->id }})">
                                        <div class="form-check">
                                            <input class="form-check-input criteria-checkbox"
                                                   type="checkbox"
                                                   value="{{ $criteria->id }}"
                                                   name="criteria_id[]"
                                                   id="criteria_{{ $criteria->id }}">
                                            <label class="form-check-label w-100" for="criteria_{{ $criteria->id }}">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1">{{ $criteria->name }}</h6>
                                                        <span class="badge bg-{{ $criteria->kategori == 'BENEFIT' ? 'success' : 'warning' }} bg-opacity-20 text-{{ $criteria->kategori == 'BENEFIT' ? 'success' : 'warning' }}">
                                                            {{ Str::ucfirst(Str::lower($criteria->kategori)) }}
                                                        </span>
                                                    </div>
                                                    <small class="text-muted">{{ $criteria->weight ?? '0' }}%</small>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="alert alert-info mt-3" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Catatan:</strong> Pilih minimal 2 kriteria untuk melakukan perbandingan berpasangan dalam metode AHP.
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <button type="button" class="btn btn-secondary" onclick="hideCriteriaSelection()">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                <i class="fas fa-arrow-right me-2"></i>Pilih minimal 2 kriteria
                            </button>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-triangle text-warning display-4"></i>
                            <h6 class="mt-3 text-muted">Tidak ada kriteria tersedia</h6>
                            <p class="text-muted">Harap tambahkan data kriteria terlebih dahulu sebelum membuat perbandingan.</p>
                            <a href="{{ route('kriteria.index') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Kriteria
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Hidden form for delete -->
        <form id="deleteForm" method="POST" style="display: none;">
            @method('delete')
            @csrf
        </form>
    </main>

    <script>
        // Show/Hide criteria selection
        function showCriteriaSelection() {
            document.getElementById('criteriaSelectionCard').style.display = 'block';
            document.getElementById('criteriaSelectionCard').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function hideCriteriaSelection() {
            document.getElementById('criteriaSelectionCard').style.display = 'none';
            // Reset form
            document.getElementById('criteriaForm').reset();
            updateSubmitButton();
        }

        // Toggle criteria selection
        function toggleCriteria(criteriaId) {
            const checkbox = document.getElementById('criteria_' + criteriaId);
            checkbox.checked = !checkbox.checked;
            updateSubmitButton();
            updateSelectAll();
        }

        // Select All functionality
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.criteria-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSubmitButton();
                });
            }

            // Individual checkbox change
            document.querySelectorAll('.criteria-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function(e) {
                    e.stopPropagation(); // Prevent card click when clicking checkbox directly
                    updateSubmitButton();
                    updateSelectAll();
                });
            });
        });

        // Update select all checkbox
        function updateSelectAll() {
            const totalCheckboxes = document.querySelectorAll('.criteria-checkbox').length;
            const checkedCheckboxes = document.querySelectorAll('.criteria-checkbox:checked').length;
            const selectAllCheckbox = document.getElementById('selectAll');

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = totalCheckboxes === checkedCheckboxes && totalCheckboxes > 0;
                selectAllCheckbox.indeterminate = checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
            }
        }

        // Update submit button state
        function updateSubmitButton() {
            const checkedCheckboxes = document.querySelectorAll('.criteria-checkbox:checked').length;
            const submitBtn = document.getElementById('submitBtn');

            if (submitBtn) {
                if (checkedCheckboxes >= 2) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-arrow-right me-2"></i>Lanjutkan Perbandingan (' + checkedCheckboxes + ' kriteria)';
                    submitBtn.classList.remove('btn-secondary');
                    submitBtn.classList.add('btn-primary');
                } else {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-arrow-right me-2"></i>Pilih minimal 2 kriteria';
                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.add('btn-secondary');
                }
            }
        }

        // Delete comparison
        function deleteComparison(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data perbandingan ini?\n\nData yang dihapus tidak dapat dikembalikan.')) {
                const form = document.getElementById('deleteForm');
                if (form) {
                    form.action = '{{ route("perbandingan.destroy", ":id") }}'.replace(':id', id);
                    form.submit();
                }
            }
        }
    </script>

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

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .text-gray-800 {
            color: #5a5c69 !important;
        }

        .avatar-sm {
            width: 32px;
            height: 32px;
        }

        .empty-state {
            padding: 2rem 1rem;
        }

        .empty-state-icon {
            font-size: 3rem;
            opacity: 0.3;
        }

        .btn-group .btn {
            border-radius: 0.25rem;
            margin-right: 2px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .card.border {
            transition: all 0.2s ease;
        }

        .card.border:hover {
            border-color: #0d6efd !important;
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        /* Modal backdrop fix */
        .modal {
            z-index: 1060 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }

        /* Prevent body scroll when modal is open */
        body.modal-open {
            overflow: hidden;
        }

        /* Ensure modal content is clickable */
        .modal-dialog {
            position: relative;
            z-index: 1070;
        }

        /* Fix for checkbox labels */
        .form-check-label {
            cursor: pointer;
        }

        .form-check-input:checked + .form-check-label {
            color: #0d6efd;
        }
    </style>
@endsection
