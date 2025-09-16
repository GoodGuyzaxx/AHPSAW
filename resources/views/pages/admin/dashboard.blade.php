@extends('layouts.admin')

@section('content')
    <main class="container-fluid px-4 animate-fade-in">
        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800 fw-bold">Dashboard</h1>
                <p class="mb-0 text-muted">Selamat datang di Sistem Pendukung Keputusan Bantuan Studi Akhir</p>
            </div>
            <div class="text-end">
                <small class="text-muted">{{ \Carbon\Carbon::now()->format('d F Y') }}</small>
            </div>
        </div>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active fw-semibold">
                    <i class="fas fa-home me-2"></i>Dashboard
                </li>
            </ol>
        </nav>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <!-- Siswa Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-left-primary h-100 animate-fade-in" style="animation-delay: 0.1s">
                    <a style="text-decoration:none; color: inherit;" href="{{ route('student.index') }}">
                        <div class="card-body p-4">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-2 letter-spacing">
                                        <i class="fas fa-graduation-cap me-2"></i>Total Mahasiwa
                                    </div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $students ?? 0 }}</div>
                                    <div class="text-muted small mt-2">Data Mahasiswa terdaftar</div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-shape bg-primary bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-users fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Criteria Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-left-success h-100 animate-fade-in" style="animation-delay: 0.2s">
                    <a href="{{ route('kriteria.index') }}" style="text-decoration:none; color: inherit;">
                        <div class="card-body p-4">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                                        <i class="fas fa-list-check me-2"></i>Kriteria
                                    </div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $criterias ?? 0 }}</div>
                                    <div class="text-muted small mt-2">Kriteria penilaian</div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-shape bg-success bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-table-columns fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Class Card -->
{{--            <div class="col-xl-3 col-md-6">--}}
{{--                <div class="card border-left-info h-100 animate-fade-in" style="animation-delay: 0.3s">--}}
{{--                    <a href="{{ route('kelas.index') ?? '#' }}" style="text-decoration:none; color: inherit;">--}}
{{--                        <div class="card-body p-4">--}}
{{--                            <div class="row no-gutters align-items-center">--}}
{{--                                <div class="col">--}}
{{--                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-2">--}}
{{--                                        <i class="fas fa-door-open me-2"></i>Kelas--}}
{{--                                    </div>--}}
{{--                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $kelases ?? 0 }}</div>--}}
{{--                                    <div class="text-muted small mt-2">Total kelas aktif</div>--}}
{{--                                </div>--}}
{{--                                <div class="col-auto">--}}
{{--                                    <div class="icon-shape bg-info bg-opacity-10 rounded-circle p-3">--}}
{{--                                        <i class="fas fa-school fa-2x text-info"></i>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}

            <!-- Users Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-left-warning h-100 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="card-body p-4">
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">
                                    <i class="fas fa-user-shield me-2"></i>Pengguna
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $users ?? 0 }}</div>
                                <div class="text-muted small mt-2">Pengguna sistem</div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-shape bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-user-gear fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-4">
            <!-- Welcome Section -->
            <div class="col-md-8">
                <div class="card h-100 animate-fade-in" style="animation-delay: 0.5s">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-shape bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-chart-line fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1 fw-bold">Sistem Pendukung Keputusan</h5>
                                <p class="card-text text-muted mb-0">Manajemen data untuk seleksi penerima beasiswa</p>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <small>Analisis kriteria beasiswa</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <small>Perangkingan otomatis</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <small>Laporan komprehensif</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <small>Interface user-friendly</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4">
                <div class="card h-100 animate-fade-in" style="animation-delay: 0.6s">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3 fw-bold">
                            <i class="fas fa-bolt text-warning me-2"></i>Akses Cepat
                        </h5>
                        <div class="d-grid gap-2">
                            <a href="{{ route('alternatif.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-users-rectangle me-2"></i>Data Alternatif
                            </a>
                            <a href="{{ route('perbandingan.index') }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-code-compare me-2"></i>Perbandingan
                            </a>
                            <a href="{{ route('rank.index') }}" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-ranking-star me-2"></i>Lihat Ranking
                            </a>
                            @can('admin')
                                <a href="{{ route('users.index') }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-user-gear me-2"></i>Kelola Pengguna
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card animate-fade-in" style="animation-delay: 0.7s">
                    <div class="card-body p-3">
                        <div class="row align-items-center text-center">
                            <div class="col-md-4">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Terakhir login: {{ \Carbon\Carbon::now()->format('H:i') }}
                                </small>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>
                                    Login sebagai: {{ auth()->user()->level }}
                                </small>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">
                                    <i class="fas fa-server me-1"></i>
                                    Status: <span class="text-success">Online</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
