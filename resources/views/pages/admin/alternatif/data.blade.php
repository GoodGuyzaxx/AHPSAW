@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">{{ $title }}</h1>
                <p class="mb-0 text-muted">Kelola data alternatif dan nilai kriteria untuk setiap mahasiswa.</p>
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
                        <i class="fas fa-users me-2 text-primary"></i>
                        Daftar Alternatif Mahasiswa
                    </h5>
                    @can('admin')
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAlternativeModal">
                            <i class="fas fa-plus me-2"></i>Tambah Alternatif
                        </button>
                    @endcan
                </div>
            </div>

            <div class="card-body p-4">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        @foreach ($errors->all() as $error)<span>{{ $error }}</span>@endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <select class="form-select form-select-sm me-2" id="perPage" onchange="submitForm()">
                                @foreach ($perPageOptions as $option)
                                    <option value="{{ $option }}" {{ $option == $perPage ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            <label class="form-label mb-0 text-muted small">entri per halaman</label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <form action="{{ route('alternatif.index') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama mahasiswa..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light text-center">
                        <tr>
                            <th rowspan="2" class="align-middle">No</th>
                            <th rowspan="2" class="align-middle">Nama Alternatif</th>
                            <th colspan="{{ $criterias->count() }}">Kriteria</th>
                            @can('admin')
                                <th rowspan="2" class="align-middle">Aksi</th>
                            @endcan
                        </tr>
                        <tr>
                            @forelse ($criterias as $criteria)
                                <th>{{ $criteria->name }}</th>
                            @empty
                                <th>Tidak Ada Kriteria</th>
                            @endforelse
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($alternatives as $alternative)
                            <tr>
                                <td class="text-center">{{ ($alternatives->currentPage() - 1) * $alternatives->perPage() + $loop->iteration }}</td>
                                <td>{{ $alternative->name }}</td>
                                @foreach ($criterias as $criteria)
                                    @php
                                        $subCriteria = $alternative->alternatives->where('criteria_id', $criteria->id)->first();
                                    @endphp
                                    <td class="text-center">{{ $subCriteria->criteriaSub->name_sub ?? 'N/A' }}</td>
                                @endforeach
                                @can('admin')
                                    <td class="text-center">
                                        <a href="{{ route('alternatif.edit', $alternative->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('alternatif.destroy', $alternative->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 3 + $criterias->count() }}" class="text-center text-danger py-4">
                                    <i class="fas fa-exclamation-circle me-2"></i>Data tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $alternatives->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="addAlternativeModal" tabindex="-1" aria-labelledby="addAlternativeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('alternatif.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-gradient-info text-white border-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fas fa-plus-circle text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold" id="addAlternativeModalLabel">Tambah Alternatif Baru</h5>
                                <small class="opacity-75">Isi data mahasiswa dan nilai kriterianya</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label for="student_id" class="form-label fw-semibold"><i class="fas fa-user-graduate me-2 text-primary"></i>Pilih Mahasiswa</label>
                            <select class="form-select @error('student_id') is-invalid @enderror" id="student_id" name="student_id" required>
                                <option value="" disabled selected>-- Pilih dari daftar mahasiswa yang tersedia --</option>
                                @forelse ($student_list as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @empty
                                    <option disabled>Tidak ada mahasiswa yang bisa ditambahkan</option>
                                @endforelse
                            </select>
                            @error('student_id')<div class="invalid-feedback mt-1">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3 fw-bold"><i class="fas fa-tasks me-2 text-info"></i>Input Nilai Kriteria</h6>
                        @forelse ($criterias as $criteria)
                            <input type="hidden" name="criteria_id[]" value="{{ $criteria->id }}">
                            <div class="mb-3">
                                <label for="criteria_{{ $criteria->id }}" class="form-label">{{ $criteria->name }}</label>
                                <select id="criteria_{{ $criteria->id }}" class="form-select @error('criteria_subs') is-invalid @enderror" name="criteria_subs[]" required>
                                    <option value="" disabled selected>-- Pilih {{ $criteria->name }} --</option>
                                    @foreach ($criteria->criteriaSubs as $sub)
                                        <option value="{{ $sub->id }}|{{ $sub->value }}">{{ $sub->name_sub }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @empty
                            <p class="text-muted text-center">Belum ada data kriteria. Silakan tambahkan kriteria terlebih dahulu.</p>
                        @endforelse
                    </div>

                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Batal</button>
                        <button type="submit" class="btn btn-primary" {{ $criterias->count() ? '' : 'disabled' }}><i class="fas fa-save me-2"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('partials.style-script')
@endsection
